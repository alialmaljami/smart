<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'type' => 'email',
                'value' => 'Smartdecorat1@gmail.com',
                'label' => 'البريد الإلكتروني',
                'is_active' => true,
            ],
            [
                'type' => 'phone',
                'value' => '+966 XXX XXX XXX',
                'label' => 'رقم الهاتف',
                'is_active' => true,
            ],
            [
                'type' => 'address',
                'value' => 'المملكة العربية السعودية',
                'label' => 'العنوان',
                'is_active' => true,
            ],
            [
                'type' => 'map_url',
                'value' => 'https://maps.app.goo.gl/w8TwGiDcEgCCXHmL9',
                'label' => 'موقعنا',
                'is_active' => true,
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
