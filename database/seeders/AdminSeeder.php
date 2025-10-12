<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Division;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Jeanne Darsono',
                'nrp' => 'B12230055',
                'division_id' => Division::where('slug', 'bph')->first()->id,
                'anonymous_name' => 'Alioth',
            ],
            [
                'name' => 'Arlene Evangeline',
                'nrp' => 'C13230033',
                'division_id' => Division::where('slug', 'bph')->first()->id,
                'anonymous_name' => 'Vega',
            ],
            [
                'name' => 'Vincent Alexander Langgeng',
                'nrp' => 'C14230135',
                'division_id' => Division::where('slug', 'bph')->first()->id,
                'anonymous_name' => 'Sirius',
            ],
            [
                'name' => 'William Constantine Jioe',
                'nrp' => 'C14230036',
                'division_id' => Division::where('slug', 'it')->first()->id,
                'anonymous_name' => 'Atria',
                'link_gmeet' => 'https://meet.google.com/vvi-stxb-gnu',
            ],
            [
                'name' => 'Andreas Justin Tirta Sani',
                'nrp' => 'C14230093',
                'division_id' => Division::where('slug', 'it')->first()->id,
                'anonymous_name' => 'Avior',
                'link_gmeet' => 'https://meet.google.com/vhr-joai-jtd',
            ],
            [
                'name' => 'Reivan Aryasatya Lobis',
                'nrp' => 'B11230014',
                'division_id' => Division::where('slug', 'acara')->first()->id,
                'anonymous_name' => 'Spica',
                'link_gmeet' => 'https://meet.google.com/ptq-qits-nzo',
            ],
            [
                'name' => 'Jennifer Olivia Wiyono ',
                'nrp' => 'B12230067',
                'division_id' => Division::where('slug', 'creative')->first()->id,
                'anonymous_name' => 'Regulus',
                'link_gmeet' => 'https://meet.google.com/tgt-vbiy-fvy',
            ],
            [
                'name' => 'Rivaldo Tan',
                'nrp' => 'C14230128',
                'division_id' => Division::where('slug', 'transkapman')->first()->id,
                'anonymous_name' => 'Pullox',
                'link_gmeet' => 'https://meet.google.com/zhy-joba-zrj',
            ],
            [
                'name' => 'Davinka Rachmanastya',
                'nrp' => 'B12230023',
                'division_id' => Division::where('slug', 'sekkonkes')->first()->id,
                'anonymous_name' => 'Naos',
                'link_gmeet' => 'https://meet.google.com/seh-pbop-cxt',
            ],
            [
                'name' => 'Florence Kristalin Viena Rudyanto',
                'nrp' => 'C14230153',
                'division_id' => Division::where('slug', 'sponsor')->first()->id,
                'anonymous_name' => 'Schedar',
                'link_gmeet' => 'http://meet.google.com/qsw-pqgy-vun',
            ],
            [
                'name' => 'Christabella Marvina Faniska ',
                'nrp' => 'C13230026',
                'division_id' => Division::where('slug', 'sponsor')->first()->id,
                'anonymous_name' => 'Alnath',
                'link_gmeet' => 'https://meet.google.com/mdo-kmru-jue',
            ],
            [
                'name' => 'Felicia Audrey',
                'nrp' => 'C14230207',
                'division_id' => Division::where('slug', 'acara')->first()->id,
                'anonymous_name' => 'Capella',
                'link_gmeet' => 'https://meet.google.com/npx-uvhr-are',
            ],
            [
                'name' => 'Jennifer Kezia Surjaatmadja',
                'nrp' => 'B12230017',
                'division_id' => Division::where('slug', 'materi')->first()->id,
                'anonymous_name' => 'Antares',
                'link_gmeet' => 'https://meet.google.com/yct-xjso-xdw',
            ],
            [
                'name' => 'Matthew Benedict',
                'nrp' => 'C14230234',
                'division_id' => Division::where('slug', 'transkapman')->first()->id,
                'anonymous_name' => 'Castor',
                'link_gmeet' => 'https://meet.google.com/agc-sgez-mvj',
            ],
            [
                'name' => 'Aleric Revel Budiman',
                'nrp' => 'C13230017',
                'division_id' => Division::where('slug', 'creative')->first()->id,
                'anonymous_name' => 'Wezen',
                'link_gmeet' => 'https://meet.google.com/wmb-uvab-vkh',
            ],
            [
                'name' => 'Fiora Agnesia Winarso',
                'nrp' => 'C14230218',
                'division_id' => Division::where('slug', 'creative')->first()->id,
                'anonymous_name' => 'Proycon',
                'link_gmeet' => 'https://meet.google.com/euf-qmsw-gko',
            ],
            [
                'name' => 'Maria Amelia',
                'nrp' => 'B12230059',
                'division_id' => Division::where('slug', 'sekkonkes')->first()->id,
                'anonymous_name' => 'Muliphain',
                'link_gmeet' => 'https://meet.google.com/mhb-kvqv-wgh',
            ],
        ];
        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
