<?php
declare(strict_types=1);

/**
 * Role-Based Access Control (RBAC) & Status Workflow Configuration
 * Sistem Helpdesk ICTBKP
 */

return [
    'roles' => [
        'ADMIN' => [
            'id' => 'ADMIN',
            'name' => 'Pentadbir Sistem & ICT BKP',
            'badge_color' => 'rose',
            'description' => 'Akses penuh sistem, pengurusan aset, kelulusan permohonan dan pelaporan eksekutif',
            'permissions' => [
                'tickets.view_all',
                'tickets.create',
                'tickets.edit',
                'tickets.approve_unit',
                'tickets.approve_ict',
                'tickets.assign_technician',
                'tickets.complete',
                'tickets.cancel',
                'assets.manage',
                'users.manage',
                'reports.view',
                'audit.view',
            ],
        ],
        'KETUA_UNIT' => [
            'id' => 'KETUA_UNIT',
            'name' => 'Ketua Unit / Pegawai Penyelia',
            'badge_color' => 'amber',
            'description' => 'Menyemak dan memperakukan permohonan staf di bawah unit masing-masing sebelum ke ICT',
            'permissions' => [
                'tickets.view_unit',
                'tickets.create',
                'tickets.approve_unit',
                'tickets.reject_unit',
                'reports.view_unit',
            ],
        ],
        'STAF' => [
            'id' => 'STAF',
            'name' => 'Pegawai & Kakitangan Pemohon',
            'badge_color' => 'slate',
            'description' => 'Membuat permohonan pinjaman peralatan, sokongan mesyuarat dan khidmat media',
            'permissions' => [
                'tickets.view_own',
                'tickets.create',
                'tickets.cancel_own',
            ],
        ],
    ],

    // Workflow Status Permohonan
    'statuses' => [
        'MENUNGGU_SOKONGAN_UNIT' => [
            'id' => 'MENUNGGU_SOKONGAN_UNIT',
            'label' => 'Menunggu Sokongan Ketua Unit',
            'badge_class' => 'bg-amber-50 text-amber-700 border-amber-200 ring-amber-500/20',
            'icon' => 'clock',
            'description' => 'Permohonan dihantar oleh staf dan sedang menunggu perakuan Ketua Unit masing-masing',
        ],
        'MENUNGGU_KELULUSAN_ICT' => [
            'id' => 'MENUNGGU_KELULUSAN_ICT',
            'label' => 'Menunggu Kelulusan ICT BKP',
            'badge_class' => 'bg-blue-50 text-blue-700 border-blue-200 ring-blue-500/20',
            'icon' => 'shield-check',
            'description' => 'Telah disokong oleh Ketua Unit, dalam penilaian ketersediaan dan kelulusan ICT BKP',
        ],
        'DILULUSKAN' => [
            'id' => 'DILULUSKAN',
            'label' => 'Diluluskan & Dijadualkan',
            'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-500/20',
            'icon' => 'check-circle',
            'description' => 'Permohonan telah diluluskan rasmi dan aset / petugas ICT telah diperuntukkan',
        ],
        'SEDANG_BERLANGSUNG' => [
            'id' => 'SEDANG_BERLANGSUNG',
            'label' => 'Sedang Dipinjam / Berlangsung',
            'badge_class' => 'bg-indigo-50 text-indigo-700 border-indigo-200 ring-indigo-500/20',
            'icon' => 'activity',
            'description' => 'Peralatan telah diserahkan kepada pemohon atau acara/mesyuarat sedang aktif',
        ],
        'SELESAI' => [
            'id' => 'SELESAI',
            'label' => 'Selesai & Dipulangkan',
            'badge_class' => 'bg-teal-50 text-teal-700 border-teal-200 ring-teal-500/20',
            'icon' => 'check',
            'description' => 'Peralatan dipulangkan dalam keadaan baik dan sesi sokongan telah selesai sepenuhnya',
        ],
        'DITOLAK' => [
            'id' => 'DITOLAK',
            'label' => 'Ditolak / Tidak Disokong',
            'badge_class' => 'bg-rose-50 text-rose-700 border-rose-200 ring-rose-500/20',
            'icon' => 'x-circle',
            'description' => 'Permohonan tidak dapat dipertimbangkan atas faktor pertindihan jadual atau peruntukan',
        ],
        'DIBATALKAN' => [
            'id' => 'DIBATALKAN',
            'label' => 'Dibatalkan oleh Pemohon',
            'badge_class' => 'bg-slate-100 text-slate-600 border-slate-200 ring-slate-400/20',
            'icon' => 'slash',
            'description' => 'Permohonan dibatalkan oleh pihak pemohon sendiri sebelum tarikh acara',
        ],
    ],
];
