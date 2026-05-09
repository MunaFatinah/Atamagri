<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Testimoni;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Atamagri',
            'email'    => 'admin@atamagri.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'status'   => 'aktif',
            'phone'    => '082114728871',
            'location' => 'Karanganyar, Jawa Tengah',
        ]);

        // Demo petani
        $petani = [
            ['name' => 'Budi Santoso',   'email' => 'budi@email.com',    'location' => 'Surakarta'],
            ['name' => 'Siti Aminah',    'email' => 'siti@email.com',    'location' => 'Karanganyar'],
            ['name' => 'Joko Prasetyo',  'email' => 'joko@email.com',    'location' => 'Sukoharjo'],
            ['name' => 'Dewi Nuraini',   'email' => 'dewi@email.com',    'location' => 'Boyolali', 'status' => 'nonaktif'],
            ['name' => 'Ahmad Wahyudi',  'email' => 'ahmad@email.com',   'location' => 'Klaten'],
            ['name' => 'Rina Lestari',   'email' => 'rina@email.com',    'location' => 'Wonogiri'],
            ['name' => 'Mulyono Hadi',   'email' => 'mulyono@email.com', 'location' => 'Sragen', 'status' => 'nonaktif'],
            ['name' => 'Sri Wahyuni',    'email' => 'sri@email.com',     'location' => 'Surakarta'],
            ['name' => 'Bambang Susilo', 'email' => 'bambang@email.com', 'location' => 'Karanganyar'],
            ['name' => 'Endah Rahayu',   'email' => 'endah@email.com',   'location' => 'Sukoharjo'],
        ];

        foreach ($petani as $p) {
            User::create(array_merge([
                'password' => Hash::make('petani123'),
                'role'     => 'petani',
                'status'   => 'aktif',
                'phone'    => '08' . rand(1000000000, 9999999999),
            ], $p));
        }

        // Demo testimoni
        $testimonials = [
            ['nama' => 'Mbah Jinah',    'peran' => 'Petani Sukoharjo',  'pesan' => 'Adanya alat ini, petani sangat senang karena dapat memantau lahan secara otomatis dari rumah saja.',                                                       'bintang' => 5],
            ['nama' => 'Pak Sabar',     'peran' => 'Perangkat Desa',    'pesan' => 'Ini menjadi solusi utama dalam permasalahan pertanian saat ini, terkhusus meninjau perubahan cuaca yang ekstrem.',                                        'bintang' => 5],
            ['nama' => 'Pak Abdullah',  'peran' => 'Petani Karanganyar','pesan' => 'Sekarang pertanian sudah canggih ya, saatnya petani beregenerasi dan Atamagri pasti siap mewujudkannya.',                                                 'bintang' => 5],
        ];

        foreach ($testimonials as $t) {
            Testimoni::create($t);
        }
    }
}