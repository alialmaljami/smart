<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DataTransfer extends Command
{
    protected $signature = 'data:transfer {--force : Overwrite existing data}';
    protected $description = 'Transfer data from SQLite to PostgreSQL';

    public function handle()
    {
        $pgsql = DB::connection('pgsql');
        $skip = ['migrations', 'sqlite_sequence', 'cache', 'cache_locks', 'sessions', 'failed_jobs', 'job_batches', 'password_reset_tokens', '__temp__blog_posts'];

        $allData = [];

        $jsonPath = database_path('db_data.json');
        if (file_exists($jsonPath)) {
            $this->info('Loading data from JSON file');
            $allData = json_decode(file_get_contents($jsonPath), true) ?? [];
        } else {
            $this->info('Loading data from SQLite');
            config(['database.connections.sqlite.database' => database_path('database.sqlite')]);
            $sqlite = DB::connection('sqlite');
            $rows = $sqlite->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE '%migrations%' AND name != 'sqlite_sequence' ORDER BY name");
            $tables = array_values(array_filter(array_map(fn($r) => is_string($r) ? $r : $r->name, $rows), fn($n) => !in_array($n, $skip) && !str_contains($n, '__temp__')));
            foreach ($tables as $t) {
                $allData[$t] = $sqlite->table($t)->get()->map(fn($r) => (array) $r)->toArray();
            }
        }

        $pgsql->statement('DROP TABLE IF EXISTS "__temp__blog_posts"');
        $this->disableForeignKeys($pgsql);

        foreach ($allData as $name => $data) {
            if (in_array($name, $skip)) continue;
            $pgCount = $pgsql->table($name)->count();
            if ($pgCount > 0 && !$this->option('force')) {
                $this->warn("Skipping {$name} - {$pgCount} rows already exist");
                continue;
            }
            if ($this->option('force') && $pgCount > 0) {
                $pgsql->table($name)->truncate();
            }
            if (!empty($data)) {
                $chunks = array_chunk($data, 100);
                foreach ($chunks as $chunk) {
                    $pgsql->table($name)->insert($chunk);
                }
                $this->info("Transferred " . count($data) . " rows to {$name}");
                try { $this->resetSequence($pgsql, $name); } catch (\Exception $e) {}
            } else {
                $this->warn("No data in {$name}");
            }
        }

        $this->enableForeignKeys($pgsql);
        $this->info('Data transfer completed successfully!');
    }

    private function disableForeignKeys($db)
    {
        $db->statement('SET session_replication_role = replica');
    }

    private function enableForeignKeys($db)
    {
        $db->statement('SET session_replication_role = origin');
    }

    private function resetSequence($db, $table)
    {
        $seq = $db->selectOne("SELECT pg_get_serial_sequence('{$table}', 'id') AS seq");
        if ($seq && $seq->seq) {
            $max = $db->table($table)->max('id');
            $next = ($max ?? 0) + 1;
            $db->statement("ALTER SEQUENCE {$seq->seq} RESTART WITH {$next}");
        }
    }
}
