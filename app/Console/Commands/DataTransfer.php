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
        $sqlite = DB::connection('sqlite');
        $pgsql = DB::connection('pgsql');

        $rows = $sqlite->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE '%migrations%' AND name != 'sqlite_sequence' ORDER BY name");
        $tables = array_map(fn($r) => is_string($r) ? $r : $r->name, $rows);

        $this->disableForeignKeys($pgsql);

        foreach ($tables as $name) {
            $pgCount = $pgsql->table($name)->count();
            if ($pgCount > 0 && !$this->option('force')) {
                $this->warn("Skipping {$name} - {$pgCount} rows already exist");
                continue;
            }

            if ($this->option('force') && $pgCount > 0) {
                $pgsql->table($name)->truncate();
            }

            $data = $sqlite->table($name)->get();

            if ($data->isNotEmpty()) {
                $chunks = $data->chunk(100);
                foreach ($chunks as $chunk) {
                    $pgsql->table($name)->insert($chunk->map(fn($row) => (array) $row)->toArray());
                }
                $this->info("Transferred {$data->count()} rows to {$name}");
                $this->resetSequence($pgsql, $name);
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
