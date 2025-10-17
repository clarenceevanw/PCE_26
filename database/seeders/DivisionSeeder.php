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
                'name' => 'Steering Committee',
                'slug' => 'SC',
                'role' => 'admin'
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
                'role' => 'admin'
            ],
            [
                'name' => 'Sekretariat, Konsumsi, dan Kesehatan',
                'slug' => 'sekkonkes',
                'role' => 'admin'
            ],
            [
                'name' => 'Acara',
                'slug' => 'acara',
                'role' => 'admin'
            ],
            [
                'name' => 'Information Technology',
                'slug' => 'it',
                'role' => 'admin'
            ],
            [
                'name' => 'Sponsorship',
                'slug' => 'sponsor',
                'role' => 'admin'
            ],
            [
                'name' => 'Public Relation',
                'slug' => 'pr',
                'role' => 'admin'
            ],
            [
                'name' => 'Creative',
                'slug' => 'creative',
                'role' => 'admin'
            ],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
