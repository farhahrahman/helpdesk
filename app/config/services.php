<?php
declare(strict_types=1);

/**
 * ICT Services & Equipment Catalog Configuration
 * Sistem Helpdesk ICTBKP (Bahagian Khidmat Pengurusan)
 */

return [
    // 4 Kategori Utama Permohonan
    'categories' => [
        'PEMINJAMAN_ASET' => [
            'id' => 'PEMINJAMAN_ASET',
            'name' => 'Peminjaman Peralatan / Aset ICT',
            'description' => 'Permohonan pinjaman peranti rasmi mengikut standard KEW.PA-9 (Laptop Dell, iPhone 15, Lenovo Tab, Kamera, Flash, Tripod, Pointer dll).',
            'icon' => 'device-laptop',
            'badge' => 'blue',
            'lead_time_days' => 1,
        ],
        'SOKONGAN_MESYUARAT' => [
            'id' => 'SOKONGAN_MESYUARAT',
            'name' => 'Khidmat Sokongan & Mesyuarat Online',
            'description' => 'Pengendalian pautan mesyuarat online (Cisco Webex/Zoom/Teams/GMeet) & bantuan teknikal bilik mesyuarat.',
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
        'LAIN_LAIN' => [
            'id' => 'LAIN_LAIN',
            'name' => 'Bantuan ICT & Aduan Teknikal',
            'description' => 'Bantuan teknikal perkakasan, perisian, rangkaian, pencetak, emel dan khidmat nasihat ICT am.',
            'icon' => 'tool',
            'badge' => 'emerald',
            'lead_time_days' => 1,
        ],
        'ADUAN_KUARTERS' => [
            'id' => 'ADUAN_KUARTERS',
            'name' => 'Aduan Sistem Kuarters',
            'description' => 'Aduan kerosakan fizikal, fasiliti kuarters, dan isu sistem aplikasi e-Kuarters Kerajaan Negeri Johor.',
            'icon' => 'home',
            'badge' => 'amber',
            'lead_time_days' => 1,
        ],
    ],

    // Senarai Rasmi Peralatan ICT untuk Peminjaman (Lengkap Jenis, No. Siri & Gambar)
    'equipment_types' => [
        'LAPTOP_DELL' => [
            'id' => 'LAPTOP_DELL',
            'name' => 'Laptop Dell Latitude',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Komputer Riba (Laptop)',
            'sample_serial' => 'BKP/ICT/LAP/2026/01 (S/N: 8G6QR93)',
            'icon' => '💻',
            'description' => 'Intel Core i5/i7, 16GB RAM, 512GB SSD, Windows 11 Enterprise & MS Office',
        ],
        'IPHONE_15' => [
            'id' => 'IPHONE_15',
            'name' => 'Apple iPhone 15',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Telefon Pintar (Smartphone)',
            'sample_serial' => 'BKP/ICT/IPH15/2026/01 (S/N: IPH15-MY-99201)',
            'icon' => '📱',
            'description' => '256GB Black/Blue Titanium, Kabel USB-C, 20W Adapter untuk tugasan rasmi luar',
        ],
        'LENOVO_TAB' => [
            'id' => 'LENOVO_TAB',
            'name' => 'Lenovo Tab P11 Plus',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Komputer Tablet',
            'sample_serial' => 'BKP/ICT/TAB/2026/01 (S/N: HA19X7BN)',
            'icon' => '📟',
            'description' => 'Tablet 11" 2K (6GB RAM + 128GB LTE) bersama Precision Pen bagi mesyuarat tanpa kertas',
        ],
        'KAMERA_CANON' => [
            'id' => 'KAMERA_CANON',
            'name' => 'Kamera DSLR/Mirrorless Canon',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Kamera Fotografi Digital',
            'sample_serial' => 'BKP/ICT/CAM/2026/01 (S/N: CN-R6M2-88192)',
            'icon' => '📷',
            'description' => 'Canon EOS R6 Mark II + Lensa RF 24-105mm F4 L IS USM, 2x Bateri & SanDisk 128GB',
        ],
        'KAMERA_NIKON' => [
            'id' => 'KAMERA_NIKON',
            'name' => 'Kamera Nikon Mirrorless',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Kamera Dokumentasi Majlis',
            'sample_serial' => 'BKP/ICT/CAM/2026/02 (S/N: NK-Z6II-44120)',
            'icon' => '📸',
            'description' => 'Nikon Z6 II + Lensa NIKKOR Z 24-70mm f/4 S untuk liputan berkualiti tinggi',
        ],
        'KAMERA_SONY' => [
            'id' => 'KAMERA_SONY',
            'name' => 'Kamera Sony Alpha 4K',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Kamera Videografi & Siaran',
            'sample_serial' => 'BKP/ICT/CAM/2026/03 (S/N: SN-A74-10928)',
            'icon' => '📹',
            'description' => 'Sony A7 IV 4K 60fps untuk rakaman video rasmi, temubual dan siaran langsung',
        ],
        'FLASH_NIKON' => [
            'id' => 'FLASH_NIKON',
            'name' => 'Speedlight Flash Luaran',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Aksesori Pencahayaan Foto',
            'sample_serial' => 'BKP/ICT/FLS/2026/01 (S/N: FL-SB5000-771)',
            'icon' => '⚡',
            'description' => 'Flash luaran Speedlight untuk pencahayaan gambar dalam dewan & auditorium',
        ],
        'TRIPOD_RED_BUFFALO' => [
            'id' => 'TRIPOD_RED_BUFFALO',
            'name' => 'Tripod Red Buffalo',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Kaki Tripod Kamera',
            'sample_serial' => 'BKP/ICT/TRP/2026/01 (S/N: RB-TRP-2026)',
            'icon' => '📐',
            'description' => 'Tripod kukuh tahan lasak dengan Fluid Head untuk kestabilan rakaman',
        ],
        'POINTER_LOGITECH' => [
            'id' => 'POINTER_LOGITECH',
            'name' => 'Pointer Wireless Logitech',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Alat Penunjuk Pembentangan',
            'sample_serial' => 'BKP/ICT/PTR/2026/01 (S/N: LOG-R800-449)',
            'icon' => '🎯',
            'description' => 'Presenter penunjuk laser hijau/merah jarak jauh 30 meter jenama Logitech',
        ],
        'HARD_DISK' => [
            'id' => 'HARD_DISK',
            'name' => 'External Hard Disk 2TB',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Cakera Keras Luaran',
            'sample_serial' => 'BKP/ICT/HDD/2026/01 (S/N: WD-MYPASS-2TB)',
            'icon' => '💾',
            'description' => 'Cakera keras mudah alih 2TB USB 3.2 untuk pemindahan & arkib data program',
        ],
        'MIKROFON_AUDIO' => [
            'id' => 'MIKROFON_AUDIO',
            'name' => 'Set Mikrofon Wireless / PA Kit',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Sistem Audio & Siar Raya',
            'sample_serial' => 'BKP/ICT/MIC/2026/01 (S/N: SHURE-WL-902)',
            'icon' => '🎙️',
            'description' => 'Mikrofon tanpa wayar (wireless / clip-on lavalier) dan pembesar suara mudah alih',
        ],
        'OTHER' => [
            'id' => 'OTHER',
            'name' => 'Peralatan ICT Khas / Lain-lain',
            'category' => 'PEMINJAMAN_ASET',
            'type_label' => 'Aksesori Tambahan',
            'sample_serial' => 'BKP/ICT/ACC/2026/01',
            'icon' => '🔌',
            'description' => 'Kabel HDMI 20m, USB-C Multiport Hub, Extension Cord atau aksesori khusus',
        ],
    ],

    // Jenis Sokongan Mesyuarat
    'meeting_support_types' => [
        'MESYUARAT_ONLINE_SAHAJA' => [
            'id' => 'MESYUARAT_ONLINE_SAHAJA',
            'name' => 'Penyediaan Link Mesyuarat Online (Cisco Webex / Zoom / Teams / GMeet)',
            'description' => 'Penyediaan akaun hos rasmi & pautan jemputan mesyuarat dalam talian',
        ],
        'TEKNIKAL_BILIK_MESYUARAT' => [
            'id' => 'TEKNIKAL_BILIK_MESYUARAT',
            'name' => 'Bantuan Teknikal Semasa Mesyuarat Fizikal',
            'description' => 'Persediaan sistem audio visual & pengujian peranti dalam bilik mesyuarat',
        ],
        'HYBRID_ONLINE_DAN_FIZIKAL' => [
            'id' => 'HYBRID_ONLINE_DAN_FIZIKAL',
            'name' => 'Sokongan Penuh Mesyuarat Hibrid (Online + Teknikal Fizikal)',
            'description' => 'Kawalan video persidangan hibrid bersama pemantauan juruteknik sepanjang sesi',
        ],
    ],

    // Platform Mesyuarat Online (Cisco Webex Meetings Teratas)
    'meeting_platforms' => [
        'CISCO_WEBEX' => 'Cisco Webex Meetings',
        'ZOOM' => 'Zoom Meeting Pro / Enterprise',
        'MS_TEAMS' => 'Microsoft Teams',
        'GOOGLE_MEET' => 'Google Meet Enterprise',
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

    // Jenis Masalah / Bantuan Teknikal ICT (Kategori Aduan & Sokongan ICT)
    'technical_support_types' => [
        'MASALAH_KOMPUTER' => [
            'id' => 'MASALAH_KOMPUTER',
            'name' => 'Komputer / Laptop (Kerosakan Windows, Format, Lembab, Blue Screen)',
            'icon' => '💻',
        ],
        'MASALAH_RANGKAIAN' => [
            'id' => 'MASALAH_RANGKAIAN',
            'name' => 'Rangkaian & Capaian Internet (Wi-Fi, Kabel LAN, IP Konflik)',
            'icon' => '🌐',
        ],
        'PENCETAK_SCANNER' => [
            'id' => 'PENCETAK_SCANNER',
            'name' => 'Pencetak & Pengimbas (Printer Offline, Jammed, Sambungan Network)',
            'icon' => '🖨️',
        ],
        'RESET_KATALALUAN' => [
            'id' => 'RESET_KATALALUAN',
            'name' => 'Reset Kata Laluan / Akaun Emel Rasmi Johor / ID Pengguna',
            'icon' => '🔑',
        ],
        'PEMASANGAN_PERISIAN' => [
            'id' => 'PEMASANGAN_PERISIAN',
            'name' => 'Pemasangan & Lesen Perisian (MS Office, Antivirus, Adobe, dll.)',
            'icon' => '💿',
        ],
        'SIARAYA_AV' => [
            'id' => 'SIARAYA_AV',
            'name' => 'Sistem Siar Raya, TV Paparan & Audio Visual Pejabat',
            'icon' => '🔊',
        ],
        'KHIDMAT_NASIHAT' => [
            'id' => 'KHIDMAT_NASIHAT',
            'name' => 'Khidmat Nasihat ICT / Lain-lain Masalah Teknikal',
            'icon' => '🛠️',
        ],
    ],

    // Senarai Jenis Kerosakan & Aduan Sistem Kuarters
    'kuarters_complaint_types' => [
        'KEROSAKAN_PAIP' => [
            'id' => 'KEROSAKAN_PAIP',
            'name' => 'Kerosakan Paip / Kebocoran Air / Sanitari / Tandas',
            'icon' => '🚰',
        ],
        'KEROSAKAN_ELEKTRIK' => [
            'id' => 'KEROSAKAN_ELEKTRIK',
            'name' => 'Kerosakan Pendawaian / Elektrik / DB Box / Lampu / Kipas',
            'icon' => '⚡',
        ],
        'STRUKTUR_BUMBUNG' => [
            'id' => 'STRUKTUR_BUMBUNG',
            'name' => 'Kerosakan Bumbung / Kebocoran Siling / Retakan Dinding',
            'icon' => '🏠',
        ],
        'PINTU_KUNCI_TINGKAP' => [
            'id' => 'PINTU_KUNCI_TINGKAP',
            'name' => 'Kerosakan Pintu Utama, Tombol Kunci, Tingkap & Gril',
            'icon' => '🔑',
        ],
        'SISTEM_EKUARTERS' => [
            'id' => 'SISTEM_EKUARTERS',
            'name' => 'Isu Sistem / Portal e-Kuarters (Akaun, Semakan, Kata Laluan)',
            'icon' => '💻',
        ],
        'FASILITI_AWAM' => [
            'id' => 'FASILITI_AWAM',
            'name' => 'Fasiliti Bersama Kuarters (Lif, Tangki Air, Pagar, Lampu Jalan Kawasan)',
            'icon' => '🏢',
        ],
        'LAIN_LAIN_KUARTERS' => [
            'id' => 'LAIN_LAIN_KUARTERS',
            'name' => 'Lain-lain Kerosakan / Aduan Kuarters',
            'icon' => '📝',
        ],
    ],

    // Senarai Kompleks Kuarters Kerajaan Negeri Johor
    'kuarters_complexes' => [
        'Kuarters Kolam Air, Johor Bahru',
        'Kuarters Bukit Pasir, Johor Bahru',
        'Kuarters Larkin, Johor Bahru',
        'Kuarters Jalan Kebun Teh, Johor Bahru',
        'Kuarters Straits View, Johor Bahru',
        'Kuarters Jalan Mahmoodiah, Johor Bahru',
        'Kuarters Kota Iskandar, Iskandar Puteri',
        'Kuarters Pegawai Daerah / Luar Daerah',
        'Lain-lain Lokasi Kuarters Kerajaan',
    ],
];
