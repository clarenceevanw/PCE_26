<?php

namespace Database\Seeders;

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
        // Optimization: Fetch all divisions once to avoid multiple DB calls in a loop.
        $divisions = Division::all()->keyBy('slug');

        $adminsData = [
            // SC
            [
                'name' => 'Samuel Mario Godwin',
                'nrp' => 'B11230018',
                'division_slug' => 'sc',
                'position' => 'Steering Committee',
                'anonymous_name' => 'Rigel',
            ],
            // BPH
            [
                'name' => 'Stefanus Kelvin Santoso',
                'nrp' => 'B11230022',
                'division_slug' => 'bph',
                'position' => 'Ketua Petra Civil Expo',
                'anonymous_name' => 'Alioth',
            ],
            [
                'name' => 'Amanda Katarina',
                'nrp' => 'B11240006',
                'division_slug' => 'bph',
                'position' => 'Sekretaris',
                'anonymous_name' => 'Vega',
            ],
            [
                'name' => 'Dylan Isaiah Santoso',
                'nrp' => 'B11230046',
                'division_slug' => 'bph',
                'position' => 'Bendahara',
                'anonymous_name' => 'Sirius',
            ],
            [
                'name' => 'Kenneth William Rusli',
                'nrp' => 'B11240012',
                'division_slug' => 'bph',
                'position' => 'Ketua Lomba Kuat Tekan Beton',
                'anonymous_name' => 'Arcturus',
            ],
            [
                'name' => 'Nicholas Bryan Soesilo',
                'nrp' => 'B11230011',
                'division_slug' => 'bph',
                'position' => 'Ketua Earthquake Resistance Design Competition',
                'anonymous_name' => 'Aldebaran',
            ],
            [
                'name' => 'Andreas Alexander Chandra',
                'nrp' => 'B11230033',
                'division_slug' => 'bph',
                'position' => 'Ketua Bridge Competition',
                'anonymous_name' => 'Betelgeuse',
            ],
            // Acara
            [
                'name' => 'Fedilia Yanson Widio',
                'nrp' => 'D11240066',
                'division_slug' => 'acara',
                'position' => 'Koordinator Divisi Acara',
                'anonymous_name' => 'Spica',
                'id_line' => 'fe20lia',
                'link_gmeet' => 'https://meet.google.com/jmz-wvgu-sjt',
                'location' => 'Selasar Gedung B'
            ],
            [
                'name' => 'Ryu Alexander',
                'nrp' => 'B11240002',
                'division_slug' => 'acara',
                'position' => 'Sub-Koordinator Divisi Acara',
                'anonymous_name' => 'Deneb',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/nzm-shnu-jbr',
                'location' => '',
            ],
            [
                'name' => 'Jessica Shine Utomo',
                'nrp' => 'C13240020',
                'division_slug' => 'acara',
                'position' => 'Sub-Koordinator Divisi Acara',
                'anonymous_name' => 'Altair',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/xye-ghvw-mtx',
                'location' => '',
            ],
            [
                'name' => 'Ruth Eliza',
                'nrp' => 'D11240108',
                'division_slug' => 'acara',
                'position' => 'Sub-Koordinator Divisi Acara',
                'anonymous_name' => 'Mizar',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/dgn-kozn-hua',
                'location' => '',
            ],
            // Creative
            [
                'name' => 'Ferdinand Jianming Karlim',
                'nrp' => 'B11230045',
                'division_slug' => 'creative',
                'position' => 'Koordinator Divisi Creative',
                'anonymous_name' => 'Procyon',
                'id_line' => 'ferdinandkarlim17',
                'link_gmeet' => 'https://meet.google.com/jqd-jjaz-hoy',
                'location' => 'Selasar P4',
            ],
            [
                'name' => 'Olivia Kristy Esterina',
                'nrp' => 'H14240028',
                'division_slug' => 'creative',
                'position' => 'Sub-Koordinator Divisi Creative',
                'anonymous_name' => 'Bellatrix',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/xom-nhup-mxb',
                'location' => '',
            ],
            [
                'name' => 'Aurell Nathania Limetta',
                'nrp' => 'D11240091',
                'division_slug' => 'creative',
                'position' => 'Sub-Koordinator Divisi Creative',
                'anonymous_name' => 'Saiph',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/hoi-eezo-xqe',
                'location' => '',
            ],
            // Transkapman
            [
                'name' => 'Darian Joseph Setiabudi',
                'nrp' => 'B11240014',
                'division_slug' => 'transkapman',
                'position' => 'Koordinator Divisi Transkapman',
                'anonymous_name' => 'Castor',
                'id_line' => 'darianjoseph19',
                'link_gmeet' => 'https://meet.google.com/oyp-ueri-qqn',
                'location' => 'Selasar P.7',
            ],
            [
                'name' => 'Lincoln Julius Hartanto',
                'nrp' => 'C11240020',
                'division_slug' => 'transkapman',
                'position' => 'Sub-Koordinator Venue',
                'anonymous_name' => 'Pollux',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/xqd-bmgw-egf',
                'location' => '',
            ],
            [
                'name' => 'Sean Vandana Sanjaya',
                'nrp' => 'C14240092',
                'division_slug' => 'transkapman',
                'position' => 'Sub-Koordinator Operator',
                'anonymous_name' => 'Fomalhaut',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/sdi-azmn-icb',
                'location' => '',
            ],
            [
                'name' => 'Aaron Juan',
                'nrp' => 'D11240100',
                'division_slug' => 'transkapman',
                'position' => 'Sub-Koordinator Data barang',
                'anonymous_name' => 'Adhara',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/fks-yzso-hfj',
                'location' => '',
            ],
            // Sekkonkes
            [
                'name' => 'Aileen Florencia Elliane',
                'nrp' => 'D12240057',
                'division_slug' => 'sekkonkes',
                'position' => 'Koordinator Divisi Sekkonkes',
                'anonymous_name' => 'Naos',
                'id_line' => 'aileenflorenciaa',
                'link_gmeet' => 'https://meet.google.com/yzk-esfr-xzt',
                'location' => 'Selasar T2',
            ],
            [
                'name' => 'Stevie Justian Yap',
                'nrp' => 'B11240016',
                'division_slug' => 'sekkonkes',
                'position' => 'Sub Koordinator Kesehatan',
                'anonymous_name' => 'Schedar',
                'id_line' => 'stepipunya',
                'link_gmeet' => 'https://meet.google.com/mht-utxt-xdo',
                'location' => 'Ruang Sidang P.402',
            ],
            [
                'name' => 'Celine Noviena Aditanzil Sugianto',
                'nrp' => 'D11240116',
                'division_slug' => 'sekkonkes',
                'position' => 'Sub Koordinator Konsumsi',
                'anonymous_name' => 'Alnath',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/ssq-gzjv-dsf',
                'location' => '',
            ],
            // Public Relation
            [
                'name' => 'Gabriella Wiandoko',
                'nrp' => 'D12240136',
                'division_slug' => 'pr',
                'position' => 'Koordinator Divisi Public Relations',
                'anonymous_name' => 'Antares',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/fhg-swuw-fpw',
                'location' => '',
            ],
            [
                'name' => 'Luna Olivia Keniko',
                'nrp' => 'D12240137',
                'division_slug' => 'pr',
                'position' => 'Wakil Koordinator Divisi Public Relations',
                'anonymous_name' => 'Polaris',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/pyh-gyud-bnt',
                'location' => '',
            ],
            // Sponsor
            [
                'name' => 'Agnes Natalia Hermanto',
                'nrp' => 'D12240125',
                'division_slug' => 'sponsor',
                'position' => 'Koordinator Divisi Sponsorship',
                'anonymous_name' => 'Canopus',
                'id_line' => 'agnes132',
                'link_gmeet' => 'https://meet.google.com/pvd-bqqd-vrx',
                'location' => 'Selasar T2',
            ],
            [
                'name' => 'Jennifer Grace Kristanto',
                'nrp' => 'B11240010',
                'division_slug' => 'sponsor',
                'position' => 'Wakil Koordinator Divisi Sponsorship',
                'anonymous_name' => 'Mirfak',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/uoz-nzmg-vdi',
                'location' => '',
            ],
            // IT
            [
                'name' => 'Clarence Evan Wijaya',
                'nrp' => 'C14240069',
                'division_slug' => 'it',
                'position' => 'Koordinator Divisi IT',
                'anonymous_name' => 'Atria',
                'id_line' => 'clarence_evan',
                'link_gmeet' => 'https://meet.google.com/oth-temm-oam',
                'location' => 'Selasar P2',
            ],
            [
                'name' => 'Nataniel Joshe',
                'nrp' => 'C14240154',
                'division_slug' => 'it',
                'position' => 'Wakil Koordinator Divisi IT',
                'anonymous_name' => 'Avior',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/bwv-npuv-rkt',
                'location' => '',
            ],
            [
                'name' => 'DUMMY BOLO',
                'nrp' => 'C14240155',
                'division_slug' => 'sekkonkes',
                'position' => 'Dummy Sekkonkes',
                'anonymous_name' => 'Rigel',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/xye-ghvw-mtx',
                'location' => '',
            ]
        ];

        foreach ($adminsData as $adminData) {
            // Check if the division slug exists in our fetched collection
            if (isset($divisions[$adminData['division_slug']])) {
                Admin::create([
                    'name' => $adminData['name'],
                    'nrp' => $adminData['nrp'],
                    'position' => $adminData['position'],
                    'anonymous_name' => $adminData['anonymous_name'],
                    'division_id' => $divisions[$adminData['division_slug']]->id,
                    // 'link_gmeet' and 'location' will be null by default
                ]);
            }
        }
    }
}
