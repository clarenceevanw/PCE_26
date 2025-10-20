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
                'position' => 'koordinator',
                'anonymous_name' => 'Spica',
                'id_line' => 'fe20lia',
                'link_gmeet' => 'https://meet.google.com/jmz-wvgu-sjt',
                'location' => 'Selasar Gedung B'
            ],
            [
                'name' => 'Ryu Alexander',
                'nrp' => 'B11240002',
                'division_slug' => 'acara',
                'position' => 'sub koordinator',
                'anonymous_name' => 'Deneb',
                'id_line' => 'ryu.a.l030806',
                'link_gmeet' => 'https://meet.google.com/nzm-shnu-jbr',
                'location' => 'Selasar P6',
            ],
            [
                'name' => 'Jessica Shine Utomo',
                'nrp' => 'C13240020',
                'division_slug' => 'acara',
                'position' => 'sub koordinator',
                'anonymous_name' => 'Altair',
                'id_line' => 'jessicashine11',
                'link_gmeet' => 'https://meet.google.com/xye-ghvw-mtx',
                'location' => 'Selasar P1',
            ],
            [
                'name' => 'Ruth Eliza',
                'nrp' => 'D11240108',
                'division_slug' => 'acara',
                'position' => 'sub koordinator',
                'anonymous_name' => 'Mizar',
                'id_line' => 'rutheliza2503',
                'link_gmeet' => 'https://meet.google.com/dgn-kozn-hua',
                'location' => 'Selasar Gedung C',
            ],
            // Creative
            [
                'name' => 'Ferdinand Jianming Karlim',
                'nrp' => 'B11230045',
                'division_slug' => 'creative',
                'position' => 'koordinator',
                'anonymous_name' => 'Procyon',
                'id_line' => 'ferdinandkarlim17',
                'link_gmeet' => 'https://meet.google.com/jqd-jjaz-hoy',
                'location' => 'Selasar P4',
            ],
            [
                'name' => 'Olivia Kristy Esterina',
                'nrp' => 'H14240028',
                'division_slug' => 'creative',
                'position' => 'sub koordinator',
                'anonymous_name' => 'Bellatrix',
                'id_line' => 'olivia22_8_2006',
                'link_gmeet' => 'https://meet.google.com/xom-nhup-mxb',
                'location' => 'Selasar Q3',
            ],
            [
                'name' => 'Aurell Nathania Limetta',
                'nrp' => 'D11240091',
                'division_slug' => 'creative',
                'position' => 'sub koordinator',
                'anonymous_name' => 'Saiph',
                'id_line' => 'anl_3206',
                'link_gmeet' => 'https://meet.google.com/hoi-eezo-xqe',
                'location' => 'Selasar T5',
            ],
            // Transkapman
            [
                'name' => 'Darian Joseph Setiabudi',
                'nrp' => 'B11240014',
                'division_slug' => 'transkapman',
                'position' => 'koordinator',
                'anonymous_name' => 'Castor',
                'id_line' => 'darianjoseph19',
                'link_gmeet' => 'https://meet.google.com/oyp-ueri-qqn',
                'location' => 'Selasar P.7',
            ],
            [
                'name' => 'Lincoln Julius Hartanto',
                'nrp' => 'C11240020',
                'division_slug' => 'transkapman',
                'position' => 'sub koordinator',
                'anonymous_name' => 'Pollux',
                'id_line' => 's0j1r0_s3ta',
                'link_gmeet' => 'https://meet.google.com/xqd-bmgw-egf',
                'location' => 'Selasar I.1',
            ],
            [
                'name' => 'Sean Vandana Sanjaya',
                'nrp' => 'C14240092',
                'division_slug' => 'transkapman',
                'position' => 'sub koordinator',
                'anonymous_name' => 'Fomalhaut',
                'id_line' => 'Selasar P2',
                'link_gmeet' => 'https://meet.google.com/sdi-azmn-icb',
                'location' => 'seanvsa06',
            ],
            [
                'name' => 'Aaron Juan',
                'nrp' => 'D11240100',
                'division_slug' => 'transkapman',
                'position' => 'sub koordinator',
                'anonymous_name' => 'Adhara',
                'id_line' => '1312aaronjk',
                'link_gmeet' => 'https://meet.google.com/fks-yzso-hfj',
                'location' => 'Joglo antara gedung A & B',
            ],
            [
                'name' => 'Ryvan Nathan',
                'nrp' => 'D11240131',
                'division_slug' => 'transkapman',
                'position' => 'sub koordinator',
                'anonymous_name' => 'Arvy',
                'id_line' => 'ryvan1136',
                'link_gmeet' => 'https://meet.google.com/erq-oaxz-tbz',
                'location' => 'Kolam Jodoh W',
            ],
            // Sekkonkes
            [
                'name' => 'Aileen Florencia Elliane',
                'nrp' => 'D12240057',
                'division_slug' => 'sekkonkes',
                'position' => 'koordinator',
                'anonymous_name' => 'Naos',
                'id_line' => 'aileenflorenciaa',
                'link_gmeet' => 'https://meet.google.com/yzk-esfr-xzt',
                'location' => 'Selasar T2',
            ],
            [
                'name' => 'Stevie Justian Yap',
                'nrp' => 'B11240016',
                'division_slug' => 'sekkonkes',
                'position' => 'sub koordinator',
                'anonymous_name' => 'Schedar',
                'id_line' => 'stepipunya',
                'link_gmeet' => 'https://meet.google.com/mht-utxt-xdo',
                'location' => 'Ruang Sidang P.402',
            ],
            [
                'name' => 'Celine Noviena Aditanzil Sugianto',
                'nrp' => 'D11240116',
                'division_slug' => 'sekkonkes',
                'position' => 'sub koordinator',
                'anonymous_name' => 'Alnath',
                'id_line' => 'celinenies',
                'link_gmeet' => 'https://meet.google.com/ssq-gzjv-dsf',
                'location' => 'Selasar Gedung A',
            ],
            // Public Relation
            [
                'name' => 'Gabriella Wiandoko',
                'nrp' => 'D12240136',
                'division_slug' => 'pr',
                'position' => 'koordinator',
                'anonymous_name' => 'Antares',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/fhg-swuw-fpw',
                'location' => '',
            ],
            [
                'name' => 'Luna Olivia Keniko',
                'nrp' => 'D12240137',
                'division_slug' => 'pr',
                'position' => 'wakil koordinator',
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
                'position' => 'koordinator',
                'anonymous_name' => 'Canopus',
                'id_line' => 'agnes132',
                'link_gmeet' => 'https://meet.google.com/pvd-bqqd-vrx',
                'location' => 'Selasar T2',
            ],
            [
                'name' => 'Jennifer Grace Kristanto',
                'nrp' => 'B11240010',
                'division_slug' => 'sponsor',
                'position' => 'wakil koordinator',
                'anonymous_name' => 'Mirfak',
                'id_line' => '',
                'link_gmeet' => 'https://meet.google.com/uoz-nzmg-vdi',
                'location' => 'Selasar P6',
            ],
            // IT
            [
                'name' => 'Clarence Evan Wijaya',
                'nrp' => 'C14240069',
                'division_slug' => 'it',
                'position' => 'koordinator',
                'anonymous_name' => 'Atria',
                'id_line' => 'clarence_evan',
                'link_gmeet' => 'https://meet.google.com/oth-temm-oam',
                'location' => 'Selasar P2',
            ],
            [
                'name' => 'Nataniel Joshe',
                'nrp' => 'C14240154',
                'division_slug' => 'it',
                'position' => 'wakil koordinator',
                'anonymous_name' => 'Avior',
                'id_line' => 'natanieljoshe0120560',
                'link_gmeet' => 'https://meet.google.com/bwv-npuv-rkt',
                'location' => 'Selasar P2',
            ],
            [
                'name' => 'DUMMY BOLO',
                'nrp' => 'C14240155',
                'division_slug' => 'sekkonkes',
                'position' => 'koordinator',
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
                    'id_line' => $adminData['id_line'] ?? null,
                    'link_gmeet' => $adminData['link_gmeet'] ?? null,
                    'location' => $adminData['location'] ?? null,
                ]);
            }
        }
    }
}
