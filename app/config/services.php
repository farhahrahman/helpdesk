<?php
declare(strict_types=1);

/**
 * ICT Services & Equipment Catalog Configuration
 * Sistem Helpdesk ICTBKP (Bahagian Khidmat Pengurusan)
 */

return [
    // 3 Kategori Utama Permohonan
    'categories' => [
        'PEMINJAMAN_ASET' => [
            'id' => 'PEMINJAMAN_ASET',
            'name' => 'Peminjaman Peralatan / Aset ICT',
            'description' => 'Permohonan pinjaman peranti rasmi seperti Laptop Dell, iPhone 15, Lenovo Tab, Kamera, Flash, Tripod, Pointer dll.',
            'icon' => 'device-laptop',
            'badge' => 'blue',
            'lead_time_days' => 1,
        ],
        'SOKONGAN_MESYUARAT' => [
            'id' => 'SOKONGAN_MESYUARAT',
            'name' => 'Khidmat Sokongan & Mesyuarat Online',
            'description' => 'Pengendalian pautan mesyuarat online (Zoom/Webex/Teams/GMeet) & bantuan teknikal bilik mesyuarat.',
            'icon' => 'video',
            'badge' => 'indigo',
            'lead_time_days' => 2,
        ],
        'MEDIA_JURUKAMERA' => [
            'id' => 'MEDIA_JURUKAMERA',
            'name' => 'Khidmat Media, Fotografi & Videografi',
            'description' => 'Permohonan jurugambar / juruvideo bagi majlis, kursus, bengkel atau liputan program rasmi BKP.',
            'icon' => 'camera',
            'badge' => 'purple',
            'lead_time_days' => 3,
        ],
    ],

    // Senarai Rasmi Peralatan ICT untuk Peminjaman (Berdasarkan Senarai Semak BKP)
    'equipment_types' => [
        'LAPTOP_DELL' => [
            'id' => 'LAPTOP_DELL',
            'name' => 'Laptop Dell',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'laptop',
            'description' => 'Komputer riba Dell Latitude untuk urusan mesyuarat, kursus atau tugasan luar',
        ],
        'IPHONE_15' => [
            'id' => 'IPHONE_15',
            'name' => 'iPhone 15',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'smartphone',
            'description' => 'Telefon pintar Apple iPhone 15 rasmi bagi komunikasi dan tugasan luar',
        ],
        'LENOVO_TAB' => [
            'id' => 'LENOVO_TAB',
            'name' => 'Lenovo Tab P11 Plus',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'tablet',
            'description' => 'Tablet Lenovo Tab P11 Plus untuk paparan dokumen mesyuarat tanpa kertas',
        ],
        'KAMERA_CANON' => [
            'id' => 'KAMERA_CANON',
            'name' => 'Kamera Canon',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'camera',
            'description' => 'Kamera digital Canon EOS DSLR / Mirrorless untuk fotografi rasmi',
        ],
        'KAMERA_NIKON' => [
            'id' => 'KAMERA_NIKON',
            'name' => 'Kamera Nikon',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'camera',
            'description' => 'Kamera digital Nikon Mirrorless untuk dokumentasi dan liputan acara',
        ],
        'KAMERA_SONY' => [
            'id' => 'KAMERA_SONY',
            'name' => 'Kamera Sony',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'video',
            'description' => 'Kamera Sony Alpha 4K untuk rakaman video dan videografi majlis',
        ],
        'FLASH_NIKON' => [
            'id' => 'FLASH_NIKON',
            'name' => 'Flash Nikon',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'zap',
            'description' => 'Speedlight flash luaran Nikon untuk pencahayaan foto dalam dewan',
        ],
        'TRIPOD_RED_BUFFALO' => [
            'id' => 'TRIPOD_RED_BUFFALO',
            'name' => 'Tripod Red Buffalo',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'camera',
            'description' => 'Kaki tripod kamera kualiti tinggi tahan lasak Red Buffalo',
        ],
        'POINTER_LOGITECH' => [
            'id' => 'POINTER_LOGITECH',
            'name' => 'Pointer Logitech',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'mouse-pointer',
            'description' => 'Wireless presenter penunjuk laser pembentangan jenama Logitech',
        ],
        'HARD_DISK' => [
            'id' => 'HARD_DISK',
            'name' => 'Hard Disk',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'hard-drive',
            'description' => 'Cakera keras luaran (External Hard Disk) untuk sandaran & pemindahan fail',
        ],
        'PROJEKTOR_SKRIN' => [
            'id' => 'PROJEKTOR_SKRIN',
            'name' => 'Projektor & Skrin Mudah Alih',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'monitor',
            'description' => 'Projektor LCD/HDMI dan layar tayangan mudah alih',
        ],
        'MIKROFON_AUDIO' => [
            'id' => 'MIKROFON_AUDIO',
            'name' => 'Set Mikrofon / PA Kit',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'mic',
            'description' => 'Mikrofon tanpa wayar (wireless / lavalier) dan pembesar suara mudah alih',
        ],
        'OTHER' => [
            'id' => 'OTHER',
            'name' => 'Other / Lain-lain Peralatan',
            'category' => 'PEMINJAMAN_ASET',
            'icon' => 'plus-circle',
            'description' => 'Sila nyatakan sebarang peralatan ICT tambahan dalam ruangan catatan',
        ],
    ],

    // Jenis Sokongan Mesyuarat
    'meeting_support_types' => [
        'MESYUARAT_ONLINE_SAHAJA' => [
            'id' => 'MESYUARAT_ONLINE_SAHAJA',
            'name' => 'Penyediaan Link Mesyuarat Online (Zoom / Webex / Teams / GMeet)',
            'description' => 'Penyediaan akaun hos rasmi & pautan jemputan mesyuarat dalam talian',
        ],
        'TEKNIKAL_BILIK_MESYUARAT' => [
            'id' => 'TEKNIKAL_BILIK_MESYUARAT',
            'name' => 'Bantuan Teknikal Semasa Mesyuarat Fizikal',
            'description' => 'Persediaan sistem audio visual, projektor & pengujian peranti dalam bilik mesyuarat',
        ],
        'HYBRID_ONLINE_DAN_FIZIKAL' => [
            'id' => 'HYBRID_ONLINE_DAN_FIZIKAL',
            'name' => 'Sokongan Penuh Mesyuarat Hibrid (Online + Teknikal Fizikal)',
            'description' => 'Kawalan video persidangan hibrid bersama pemantauan juruteknik sepanjang sesi',
        ],
    ],

    // Platform Mesyuarat
    'meeting_platforms' => [
        'ZOOM' => 'Zoom Meeting Pro / Enterprise',
        'CISCO_WEBEX' => 'Cisco Webex Meetings',
        'GOOGLE_MEET' => 'Google Meet Enterprise',
        'MS_TEAMS' => 'Microsoft Teams',
    ],

    // Lokasi / Bilik Mesyuarat Lazim BKP
    'meeting_venues' => [
        'BILIK_MESYUARAT_UTAMA' => 'Bilik Mesyuarat Utama BKP (Aras 3)',
        'BILIK_MESYUARAT_GERAKAN' => 'Bilik Gerakan Pengurusan BKP (Aras 2)',
        'BILIK_MESYUARAT_TSUK' => 'Bilik Mesyuarat Pejabat TSUK Pengurusan (Aras 4)',
        'DEWAN_SERBAGUNA' => 'Dewan Serbaguna Kompleks Kerajaan',
        'BILIK_PERBINCANGAN' => 'Bilik Perbincangan Unit BKP',
        'LOKASI_LUAR' => 'Lokasi Luar / Premis Agensi Lain',
    ],

    // Skop Liputan Media
    'media_scopes' => [
        'FOTOGRAFI' => 'Fotografi Sahaja (Rakaman Gambar Beresolusi Tinggi)',
        'VIDEOGRAFI' => 'Videografi Sahaja (Rakaman Video Penuh / Klip Sorotan)',
        'FOTO_DAN_VIDEO' => 'Pakej Lengkap (Fotografi & Videografi Majlis)',
    ],
];
