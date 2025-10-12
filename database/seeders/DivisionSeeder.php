<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                'name' => 'Dosen',
                'slug' => 'dosen',
                'role' => 'committee'
            ],
            [
                'name' => 'Badan Pengurus Harian',
                'slug' => 'bph',
                'role' => 'admin'
            ],
            [
                'name' => 'Badan Pengurus Harian Koordinator',
                'slug' => 'bphk',
                'role' => 'admin'
            ],
            [
                'name' => 'Transportasi dan Keamanan',
                'slug' => 'transkapman',
                'role' => 'committee'
            ],
            [
                'name' => 'Sekretariat, Konsumsi, dan Kesehatan',
                'slug' => 'sekkonkes',
                'role' => 'committee'
            ],
            [
                'name' => 'Acara',
                'slug' => 'acara',
                'role' => 'committee'
            ],
            [
                'name' => 'Information Technology',
                'slug' => 'it',
                'role' => 'admin'
            ],
            [
                'name' => 'Sponsorship',
                'slug' => 'sponsor',
                'role' => 'committee'
            ],
            [
                'name' => 'Materi',
                'slug' => 'materi',
                'role' => 'committee'
            ],
            [
                'name' => 'Creative',
                'slug' => 'creative',
                'role' => 'committee'
            ],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
