<?php
use App\Core\Auth;

$user = Auth::user();
?>

<div class="space-y-6">
    <!-- Header Context -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Jadual & Kalendar Tempahan Aktiviti</h1>
            <p class="text-xs text-slate-500 mt-1">Pemantauan jadual peminjaman aset, khidmat jurukamera dan sokongan mesyuarat secara langsung</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?= url('/tickets/create') ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm">
                + Tempah Slot / Permohonan
            </a>
        </div>
    </div>

    <!-- Timeline Schedule Cards -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Susunan Jadual Terkini</span>
            </h2>
            <div class="flex items-center gap-3 text-xs">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Diluluskan</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span> Sedang Aktif</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Dalam Semakan ICT</span>
            </div>
        </div>

        <?php if (empty($events)): ?>
        <div class="p-12 text-center text-slate-500">
            <p class="text-sm">Tiada aktiviti dijadualkan dalam masa terdekat.</p>
        </div>
        <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($events as $event): ?>
            <div class="p-4 rounded-xl border border-slate-200/80 bg-slate-50/40 hover:bg-white hover:border-blue-300 hover:shadow-md transition-all flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 flex flex-col items-center justify-center text-center shrink-0 shadow-sm">
                        <span class="text-[10px] font-bold uppercase text-blue-600 tracking-wider">
                            <?= date('M', strtotime($event['start_date'])) ?>
                        </span>
                        <span class="text-xl font-extrabold text-slate-900 leading-none mt-0.5">
                            <?= date('d', strtotime($event['start_date'])) ?>
                        </span>
                    </div>

                    <div>
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-slate-200 text-slate-800 font-mono">
                                <?= e($event['reference_no']) ?>
                            </span>
                            <span class="px-2 py-0.5 text-[10px] font-semibold rounded bg-blue-50 text-blue-700 border border-blue-200">
                                <?= e($event['category_name']) ?>
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-semibold rounded-full border ring-1 <?= $event['status_badge_class'] ?>">
                                <?= e($event['status_label']) ?>
                            </span>
                        </div>

                        <h3 class="text-sm font-bold text-slate-900 leading-snug">
                            <a href="<?= url('/tickets/' . $event['id']) ?>" class="hover:text-blue-600 transition-colors">
                                <?= e($event['title']) ?>
                            </a>
                        </h3>

                        <div class="flex items-center gap-4 text-xs text-slate-500 mt-2 flex-wrap">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <?= e($event['start_time']) ?> - <?= e($event['end_time']) ?>
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <?= e($event['location']) ?>
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <?= e($event['applicant_name']) ?> (<?= e($event['unit_short_name']) ?>)
                            </span>
                        </div>
                    </div>
                </div>

                <div class="shrink-0 flex md:flex-col items-end justify-center">
                    <a href="<?= url('/tickets/' . $event['id']) ?>" 
                       class="px-4 py-2 bg-white hover:bg-slate-100 border border-slate-300 text-slate-700 text-xs font-semibold rounded-lg shadow-sm transition-colors">
                        Papar Butiran
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
