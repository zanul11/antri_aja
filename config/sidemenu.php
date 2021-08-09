<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */
    // 'member' => [
    //     [
    //         'icon' => 'fas fa-th-large',
    //         'title' => 'Dashboard',
    //         'url' => '/dashboard'
    //     ], [
    //         'icon' => 'fas fa-user',
    //         'title' => 'Profil',
    //         'url' => '/profil'
    //     ], [
    //         'icon' => 'fas fa-share-alt-square',
    //         'title' => 'Bagi Hasil',
    //         'url' => 'javascript:;',
    //         'caret' => true,
    //         'sub_menu' => [[
    //             'url' => '/bonustotal',
    //             'title' => 'Total Bagi Hasil'
    //         ], [
    //             'url' => '/bonustiket',
    //             'title' => 'Bonus Aktivasi'
    //         ], [
    //             'url' => '/bonusharian',
    //             'title' => 'Bonus Harian'
    //         ]]
    //     ]
    // ],
    'administrator' => [
        [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
            'title' => 'Dashboard',
            'url' => '/dashboard'
        ],
        [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>',
            'title' => 'User',
            'url' => '/user'
        ],
        [
            'icon' => '<i data-feather="percent" ></i>',
            'title' => 'Persentase Bonus',
            'url' => '/persen'
        ],
        [
            'icon' => '<i data-feather="activity" ></i>',
            'title' => 'Data Spesialis',
            'url' => '/spesialis'
        ],
        [
            'icon' => '<i data-feather="users" ></i>',
            'title' => 'Data Marketing',
            'url' => '/marketing'
        ],
        [
            'icon' => '<i data-feather="file-text" ></i>',
            'title' => 'Pemasukan',
            'url' => '/pemasukan'
        ],
        // [
        //     'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>',
        //     'title' => 'Setup',
        //     'url' => '#Setup',
        //     'caret' => true,
        //     'sub_menu' => [[
        //         'url' => '/user',
        //         'title' => 'User'
        //     ]]
        // ]
    ],

    'marketing' => [
        [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
            'title' => 'Dashboard',
            'url' => '/dashboard'
        ],
        [
            'icon' => '<i data-feather="users" ></i>',
            'title' => 'Data Faskes',
            'url' => '/faskes'
        ],
        [
            'icon' => '<i data-feather="dollar-sign" ></i>',
            'title' => 'Saldo',
            'url' => '/saldo'
        ],

    ],
    'dokter' => [
        [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
            'title' => 'Dashboard',
            'url' => '/dashboard'
        ],
        [
            'icon' => '<i data-feather="search" ></i>',
            'title' => 'Profile Faskes',
            'url' => '/profile'
        ],
        [
            'icon' => '<i data-feather="message-circle" ></i>',
            'title' => 'Template Pesan',
            'url' => '/pesan'
        ],
        [
            'icon' => '<i data-feather="dollar-sign" ></i>',
            'title' => 'Saldo',
            'url' => '/saldo'
        ],
        [
            'icon' => '<i data-feather="users" ></i>',
            'title' => 'Data Dokter',
            'url' => '/dokter'
        ],
        [
            'icon' => '<i data-feather="user" ></i>',
            'title' => 'Data Akun Dokter',
            'url' => '/akun'
        ],
        [
            'icon' => '<i data-feather="calendar" ></i>',
            'title' => 'Jadwal Pelayanan',
            'url' => '/jadwal'
        ],
        [
            'icon' => '<i data-feather="layers" ></i>',
            'title' => 'Daftar Antrian',
            'url' => '/antri_dokter'
        ],
    ],
    'akun' => [
        [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
            'title' => 'Dashboard',
            'url' => '/dashboard'
        ],
        [
            'icon' => '<i data-feather="search" ></i>',
            'title' => 'Profile Faskes',
            'url' => '/profile'
        ],
        [
            'icon' => '<i data-feather="message-circle" ></i>',
            'title' => 'Template Pesan',
            'url' => '/pesan'
        ],
        [
            'icon' => '<i data-feather="dollar-sign" ></i>',
            'title' => 'Saldo',
            'url' => '/saldo'
        ],
        [
            'icon' => '<i data-feather="calendar" ></i>',
            'title' => 'Jadwal Pelayanan',
            'url' => '/jadwal'
        ],
        [
            'icon' => '<i data-feather="layers" ></i>',
            'title' => 'Daftar Antrian',
            'url' => '/antri_dokter'
        ],
    ],
    'pasien' => [
        // [
        //     'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
        //     'title' => 'Dashboard',
        //     'url' => '/dashboard'
        // ],
        // [
        //     'icon' => '<i data-feather="user" ></i>',
        //     'title' => 'My Profile',
        //     'url' => '/profile'
        // ],
        [
            'icon' => '<i data-feather="layers" ></i>',
            'title' => 'Daftar Antrian',
            'url' => '/antri'
        ],

    ]
];
