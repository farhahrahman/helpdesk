<!-- Floating Chatbot Widget Helpdesk ICT BKP -->
<div id="ict-chatbot-root" class="relative z-50">
    <!-- Floating Launcher Button & Tooltip Callout -->
    <div id="ict-chatbot-launcher" class="fixed bottom-5 right-5 sm:bottom-6 sm:right-6 z-50 flex items-center gap-3">
        <!-- Callout Banner (Pop-up sekejap menggamit pengguna) -->
        <div id="ict-chatbot-callout" 
             onclick="toggleChatbot(true)"
             class="hidden sm:flex items-center gap-2.5 bg-white/95 backdrop-blur-md px-4 py-2.5 rounded-2xl shadow-xl border border-slate-200/90 text-xs font-semibold text-slate-800 cursor-pointer hover:shadow-2xl transition-all duration-300 group">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shrink-0"></span>
            <span class="group-hover:text-blue-600 transition-colors">Perlukan Bantuan ICT? Chat di sini!</span>
            <button type="button" 
                    onclick="event.stopPropagation(); dismissCallout();" 
                    class="text-slate-400 hover:text-slate-700 ml-1.5 p-0.5 rounded-md hover:bg-slate-100" 
                    title="Tutup pemakluman">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Circular Launcher Button -->
        <button id="ict-chatbot-toggle-btn" 
                type="button" 
                onclick="toggleChatbot()"
                aria-label="Buka Chatbot Bantuan ICT" 
                class="relative w-14 h-14 rounded-full bg-gradient-to-tr from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-500 hover:to-indigo-600 text-white shadow-2xl shadow-blue-600/40 hover:scale-105 active:scale-95 transition-all duration-300 flex items-center justify-center ring-4 ring-white focus:outline-none">
            <!-- Icon Bot Open -->
            <span id="ict-chatbot-icon-open" class="transition-transform duration-200">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
            </span>
            <!-- Icon Close -->
            <span id="ict-chatbot-icon-close" class="hidden transition-transform duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </span>
            <!-- Online status green dot -->
            <span class="absolute top-0 right-0 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></span>
        </button>
    </div>

    <!-- Chat Dialog Window -->
    <div id="ict-chatbot-window" 
         class="hidden fixed bottom-24 right-4 sm:right-6 z-50 w-[calc(100vw-2rem)] sm:w-[380px] max-w-sm h-[530px] max-h-[82vh] bg-white rounded-3xl shadow-2xl border border-slate-200/90 flex flex-col overflow-hidden transition-all duration-300 origin-bottom-right">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white p-4 flex items-center justify-between border-b border-slate-800 shrink-0">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-2xl bg-blue-600/20 border border-blue-400/40 text-blue-400 flex items-center justify-center font-bold text-base shadow-sm ring-2 ring-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-slate-900 rounded-full"></span>
                </div>
                <div>
                    <h3 class="text-sm font-bold tracking-tight leading-tight flex items-center gap-1.5">
                        <span>Pembantu Maya ICT</span>
                        <span class="px-1.5 py-0.5 text-[9px] font-mono bg-blue-600/40 text-blue-300 border border-blue-400/30 rounded">BKP</span>
                    </h3>
                    <p class="text-[11px] text-emerald-400 font-medium flex items-center gap-1 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Sedia membantu &bull; Pejabat SUKJ
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-1">
                <button type="button" 
                        onclick="toggleChatbot(false)" 
                        class="p-1.5 text-slate-400 hover:text-white rounded-xl hover:bg-white/10 transition-colors" 
                        title="Tutup Chat">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Chat Messages Area -->
        <div id="ict-chatbot-messages" class="flex-1 p-4 overflow-y-auto space-y-3.5 bg-slate-50/70 text-xs text-slate-800">
            <!-- Tarikh Semasa -->
            <div class="text-center my-1">
                <span class="text-[10px] bg-slate-200/80 text-slate-600 px-2.5 py-0.5 rounded-full font-medium">Hari Ini</span>
            </div>

            <!-- Welcome Message daripada Bot -->
            <div class="flex items-start gap-2.5">
                <div class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 text-xs font-bold shadow-sm mt-0.5">
                    🤖
                </div>
                <div class="space-y-1 max-w-[85%]">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Pembantu Maya ICT</p>
                    <div class="p-3 bg-white rounded-2xl rounded-tl-sm border border-slate-200/90 shadow-sm leading-relaxed text-slate-700">
                        Salam sejahtera! Saya <strong>Pembantu Maya Helpdesk ICT BKP</strong>. 👋
                        <br><br>
                        Ada sebarang perkara yang boleh saya bantu mengenai permohonan aset, persidangan mesyuarat, liputan media atau semakan tiket?
                    </div>
                </div>
            </div>

            <!-- Pilihan Topik Pantas (Suggestion Chips) -->
            <div id="ict-chatbot-chips" class="pt-1 flex flex-wrap gap-1.5 pl-9">
                <button type="button" onclick="sendQuickMessage('Cara pinjam laptop & aset ICT')" class="px-2.5 py-1.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 text-blue-700 text-[11px] font-semibold transition-all shadow-2xs hover:border-blue-300 text-left">
                    💻 Pinjam Laptop / Tab
                </button>
                <button type="button" onclick="sendQuickMessage('Semak status permohonan tiket')" class="px-2.5 py-1.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 text-blue-700 text-[11px] font-semibold transition-all shadow-2xs hover:border-blue-300 text-left">
                    🔍 Semak Status Tiket
                </button>
                <button type="button" onclick="sendQuickMessage('Sokongan mesyuarat Webex / Zoom')" class="px-2.5 py-1.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 text-blue-700 text-[11px] font-semibold transition-all shadow-2xs hover:border-blue-300 text-left">
                    🌐 Sokongan Mesyuarat
                </button>
                <button type="button" onclick="sendQuickMessage('Tempahan liputan media & kamera')" class="px-2.5 py-1.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 text-blue-700 text-[11px] font-semibold transition-all shadow-2xs hover:border-blue-300 text-left">
                    📹 Liputan Media
                </button>
                <button type="button" onclick="sendQuickMessage('Log masuk staf & kata laluan')" class="px-2.5 py-1.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 text-blue-700 text-[11px] font-semibold transition-all shadow-2xs hover:border-blue-300 text-left">
                    🔑 Log Masuk & Password
                </button>
                <button type="button" onclick="sendQuickMessage('Hubungi talian hotline Seksyen ICT')" class="px-2.5 py-1.5 rounded-xl bg-white hover:bg-blue-50 border border-slate-200 text-blue-700 text-[11px] font-semibold transition-all shadow-2xs hover:border-blue-300 text-left">
                    📞 Hubungi Pegawai ICT
                </button>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div id="ict-chatbot-typing" class="hidden px-4 py-2 bg-slate-100/80 text-[11px] text-slate-500 flex items-center gap-1.5 border-t border-slate-200/60">
            <span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
            <span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse" style="animation-delay: 0.2s"></span>
            <span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse" style="animation-delay: 0.4s"></span>
            <span class="ml-1 text-[11px] font-medium text-slate-600">Pembantu Maya sedang menaip...</span>
        </div>

        <!-- Input Form -->
        <form id="ict-chatbot-form" onsubmit="handleChatSubmit(event)" class="p-3 bg-white border-t border-slate-200 flex items-center gap-2 shrink-0">
            <input type="text" 
                   id="ict-chatbot-input" 
                   autocomplete="off" 
                   placeholder="Tulis soalan anda di sini..." 
                   class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-300 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-xs text-slate-900 outline-none transition-all">
            <button type="submit" 
                    class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/20 transition-all shrink-0 flex items-center gap-1.5">
                <span>Hantar</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </form>

        <div class="px-3 py-1.5 bg-slate-100 text-[10px] text-slate-400 text-center border-t border-slate-200/80">
            Seksyen ICT BKP &bull; Pejabat Setiausaha Kerajaan Johor
        </div>
    </div>
</div>

<script>
(function() {
    let isOpen = false;

    // Toggle Chatbot Window
    window.toggleChatbot = function(state) {
        isOpen = (typeof state === 'boolean') ? state : !isOpen;
        const chatWindow = document.getElementById('ict-chatbot-window');
        const iconOpen = document.getElementById('ict-chatbot-icon-open');
        const iconClose = document.getElementById('ict-chatbot-icon-close');
        const callout = document.getElementById('ict-chatbot-callout');

        if (isOpen) {
            chatWindow.classList.remove('hidden');
            iconOpen.classList.add('hidden');
            iconClose.classList.remove('hidden');
            if (callout) callout.classList.add('hidden');
            setTimeout(() => {
                const input = document.getElementById('ict-chatbot-input');
                if (input) input.focus();
                scrollChatToBottom();
            }, 100);
        } else {
            chatWindow.classList.add('hidden');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }
    };

    window.dismissCallout = function() {
        const callout = document.getElementById('ict-chatbot-callout');
        if (callout) callout.remove();
    };

    // Auto-tutup callout selepas 10 saat jika tidak diklik
    setTimeout(() => {
        const callout = document.getElementById('ict-chatbot-callout');
        if (callout && !isOpen) {
            callout.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => { if (callout) callout.remove(); }, 500);
        }
    }, 12000);

    function scrollChatToBottom() {
        const container = document.getElementById('ict-chatbot-messages');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }

    // Append Mesej ke Dialog
    function appendMessage(sender, text, isHtml = false) {
        const container = document.getElementById('ict-chatbot-messages');
        const wrapper = document.createElement('div');
        wrapper.className = 'flex items-start gap-2.5 ' + (sender === 'user' ? 'justify-end' : '');

        if (sender === 'bot') {
            wrapper.innerHTML = `
                <div class="w-7 h-7 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 text-xs font-bold shadow-sm mt-0.5">
                    🤖
                </div>
                <div class="space-y-1 max-w-[85%]">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Pembantu Maya ICT</p>
                    <div class="p-3 bg-white rounded-2xl rounded-tl-sm border border-slate-200/90 shadow-sm leading-relaxed text-slate-700">
                        ${isHtml ? text : escapeHtml(text)}
                    </div>
                </div>
            `;
        } else {
            wrapper.innerHTML = `
                <div class="space-y-1 max-w-[85%]">
                    <p class="text-[10px] text-right text-slate-400 font-bold uppercase tracking-wider">Anda</p>
                    <div class="p-3 bg-blue-600 text-white rounded-2xl rounded-tr-sm shadow-sm leading-relaxed">
                        ${escapeHtml(text)}
                    </div>
                </div>
            `;
        }

        container.appendChild(wrapper);
        scrollChatToBottom();
    }

    function escapeHtml(string) {
        const div = document.createElement('div');
        div.innerText = string;
        return div.innerHTML;
    }

    // Penjana Jawapan Pintar Berasaskan Soalan (Smart FAQ Knowledge Engine)
    async function generateBotResponse(userInput) {
        const query = userInput.toLowerCase();

        // 0. Semakan Terus Nombor Tiket (Cth: ICTBKP/2026/10/0002, TCK-202609-001, atau nombor digit 0002)
        const matchIct = userInput.match(/ICTBKP\/\d{4}\/\d{1,2}\/\d{1,4}/i);
        const matchTck = userInput.match(/TCK-\d{6}-\d{1,4}/i);
        const matchDigits = userInput.match(/\b\d{4}\b/) || userInput.match(/^\s*(\d{1,4})\s*$/);
        const ticketRef = matchIct ? matchIct[0] : (matchTck ? matchTck[0] : (matchDigits ? matchDigits[0] : null));

        if (ticketRef) {
            try {
                const res = await fetch('<?= url('/track') ?>?ref=' + encodeURIComponent(ticketRef) + '&format=json');
                const data = await res.json();
                if (data && data.found && data.ticket) {
                    const t = data.ticket;
                    const isCompleted = t.is_completed;
                    const badgeHtml = isCompleted 
                        ? `<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300">✅ DAH SELESAI</span>`
                        : `<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-black bg-amber-100 text-amber-800 border border-amber-300">⏳ BELUM SELESAI</span>`;
                    
                    return `Maklumat status rasmi bagi tiket <strong>${escapeHtml(t.reference_no)}</strong>:<br><br>
                        <div class="p-3.5 bg-white rounded-2xl border border-slate-200/90 shadow-xs space-y-2.5 text-left text-slate-800">
                            <div class="flex items-center justify-between gap-2 pb-2 border-b border-slate-100">
                                <span class="font-mono font-extrabold text-xs text-[#1d3d75] bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-200">${escapeHtml(t.reference_no)}</span>
                                ${badgeHtml}
                            </div>
                            <div class="space-y-1.5 text-xs">
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block">Tugasan / Tajuk:</span>
                                    <span class="font-bold text-slate-900 block leading-snug">${escapeHtml(t.title)}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 pt-1 border-t border-slate-100 text-[11px]">
                                    <div>
                                        <span class="text-slate-400 font-semibold block">Pemohon:</span>
                                        <span class="font-bold text-slate-800 block truncate">${escapeHtml(t.applicant_name)}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 font-semibold block">Unit:</span>
                                        <span class="font-bold text-slate-800 block truncate">${escapeHtml(t.unit_name)}</span>
                                    </div>
                                </div>
                                <div class="pt-1 border-t border-slate-100 text-[11px]">
                                    <span class="text-slate-400 font-semibold">Status Aliran Kerja:</span>
                                    <span class="font-extrabold ${isCompleted ? 'text-emerald-700' : 'text-amber-700'}">${escapeHtml(t.status_label)}</span>
                                </div>
                            </div>
                            <div class="pt-2 border-t border-slate-100">
                                <a href="${t.track_url}" target="_blank" class="block w-full text-center py-2 bg-[#1d3d75] hover:bg-[#163060] text-white text-xs font-bold rounded-xl shadow-xs transition-colors">
                                    Buka Slip & Jejak Penuh &rarr;
                                </a>
                            </div>
                        </div>`;
                } else {
                    return `Maaf, rekod permohonan bagi nombor rujukan <strong class="font-mono text-slate-900">${escapeHtml(ticketRef)}</strong> tidak ditemui dalam pangkalan data.<br><br>
                        Sila pastikan nombor rujukan dimasukkan dengan tepat atau anda boleh menyemak semula di <a href="<?= url('/track') ?>" class="text-blue-600 font-bold underline hover:text-blue-800">Halaman Semak Status</a>.`;
                }
            } catch (err) {
                // If fetch fails, proceed with standard response
            }
        }

        // 1. Semakan Status Tiket
        if (query.includes('status') || query.includes('tiket') || query.includes('semak') || query.includes('track') || query.includes('rujukan')) {
            return `Untuk menyemak status permohonan terkini:<br><br>
                &bull; <strong>Cara Pantas:</strong> Taip terus nombor rujukan tiket anda di sini (contoh: <code>ICTBKP/2026/10/0002</code> atau <code>0002</code>) dan saya akan terus semakkan statusnya (<strong>Dah Selesai</strong> atau <strong>Belum Selesai</strong>)!<br>
                &bull; Atau anda boleh terus ke <a href="<?= url('/track') ?>" class="text-blue-600 font-bold underline hover:text-blue-800">Halaman Semak Status Tiket Di Sini</a>.<br>
                &bull; Jika permohonan telah lulus, anda boleh terus memuat turun Slip Rasmi di situ.`;
        }

        // 2. Peminjaman Aset / Laptop
        if (query.includes('pinjam') || query.includes('laptop') || query.includes('komputer') || query.includes('tab') || query.includes('dell') || query.includes('lenovo') || query.includes('kew.pa') || query.includes('aset')) {
            return `Permohonan peminjaman aset ICT adalah tertakluk kepada format rasmi <strong>KEW.PA-9</strong>:<br><br>
                &bull; <strong>Peralatan Tersedia:</strong> Laptop Dell Latitude, Lenovo Tab M11, iPhone 15, Kamera DSLR Canon, Tripod & Aksesori.<br>
                &bull; <strong>Cara Mohon:</strong> Klik butang <a href="<?= url('/tickets/create') ?>" class="text-blue-600 font-bold underline hover:text-blue-800">+ Buat Permohonan Baru</a> dan pilih kategori <em>Peminjaman Aset</em>.<br>
                &bull; Pastikan tarikh pinjam dan tarikh jangka pulang dinyatakan dengan tepat.`;
        }

        // 3. Sokongan Mesyuarat (Webex / Zoom / Teams)
        if (query.includes('mesyuarat') || query.includes('webex') || query.includes('zoom') || query.includes('teams') || query.includes('sidang') || query.includes('vip')) {
            return `Kami menyediakan bantuan persidangan video & sokongan mesyuarat dalam talian:<br><br>
                &bull; <strong>Platform:</strong> Cisco Webex, Zoom, Microsoft Teams.<br>
                &bull; <strong>Lokasi:</strong> Bilik Mesyuarat SUKJ, Bilik Gerakan atau Dewan.<br>
                &bull; Sila nyatakan sama ada mesyuarat melibatkan kehadiran VIP (MB, Setiausaha Kerajaan Negeri, YB Exco) agar persediaan teknikal rapi dapat dibuat lebih awal.<br><br>
                👉 <a href="<?= url('/tickets/create') ?>" class="text-blue-600 font-bold underline hover:text-blue-800">Klik di sini untuk Mohon Sokongan Mesyuarat</a>`;
        }

        // 4. Liputan Media & Foto
        if (query.includes('media') || query.includes('foto') || query.includes('gambar') || query.includes('video') || query.includes('jurugambar') || query.includes('liputan')) {
            return `Khidmat liputan media rasmi Bahagian Khidmat Pengurusan meliputi:<br><br>
                &bull; Jurugambar rasmi acara pentadbiran SUKJ.<br>
                &bull; Rakaman video & montaj program.<br>
                &bull; Penyerahan fail gambar beresolusi tinggi selepas majlis.<br><br>
                Sila mohon sekurang-kurangnya 3 hari sebelum tarikh majlis berlangsung melalui borang permohonan rasmi.`;
        }

        // 5. Bantuan Teknikal / Aduan Kerosakan
        if (query.includes('rosak') || query.includes('aduan') || query.includes('teknikal') || query.includes('printer') || query.includes('slow') || query.includes('format') || query.includes('wifi') || query.includes('internet')) {
            return `Bagi masalah perkakasan komputer, talian rangkaian internet, atau pencetak:<br><br>
                Sila buat tiket di bawah kategori <strong>Bantuan Teknikal ICT</strong> dengan menyatakan jenis masalah & lokasi meja/bilik anda supaya juruteknik ICT kami dapat hadir memeriksa.`;
        }

        // 6. Log Masuk & Kata Laluan
        if (query.includes('log masuk') || query.includes('login') || query.includes('password') || query.includes('kata laluan') || query.includes('emel') || query.includes('daftar')) {
            return `Maklumat Log Masuk Staf & Pegawai Kerajaan:<br><br>
                &bull; <strong>ID Pengguna:</strong> Emel Rasmi Kerajaan anda (<code class="text-slate-800 font-mono">@johor.gov.my</code>).<br>
                &bull; <strong>Kata Laluan Asas:</strong> <code class="bg-blue-100 text-blue-900 px-1.5 py-0.5 rounded font-bold font-mono">123456</code>.<br><br>
                👉 <a href="<?= url('/login') ?>" class="text-blue-600 font-bold underline hover:text-blue-800">Klik di sini untuk ke Halaman Log Masuk</a>.`;
        }

        // 7. Hubungi Hotline / Pegawai Bertugas
        if (query.includes('hubungi') || query.includes('telefon') || query.includes('nombor') || query.includes('hotline') || query.includes('farhah') || query.includes('contact') || query.includes('call') || query.includes('waktu') || query.includes('buka')) {
            return `Maklumat Perhubungan Seksyen ICT BKP:<br><br>
                📞 <strong>Talian ICT:</strong> <a href="tel:0105528875" class="text-blue-600 font-bold underline">010-5528875</a><br>
                📧 <strong>Emel:</strong> <a href="mailto:farhah@johor.gov.my" class="text-blue-600 font-bold underline">farhah@johor.gov.my</a><br>
                🏢 <strong>Lokasi:</strong> Seksyen ICT, Bahagian Khidmat Pengurusan, Pejabat Setiausaha Kerajaan Negeri Johor.<br>
                🕒 <strong>Waktu Operasi:</strong> Isnin - Khamis (8.00 AM - 5.00 PM) | Jumaat (8.00 AM - 12.30 PM & 2.45 PM - 5.00 PM).`;
        }

        // 8. Ucapan Terima Kasih
        if (query.includes('terima kasih') || query.includes('tq') || query.includes('thanks') || query.includes('tengkiu')) {
            return `Sama-sama! Senang dapat membantu anda. Jika ada sebarang pertanyaan lain mengenai sistem Helpdesk ICT, jangan segan untuk bertanya lagi ya! 😊`;
        }

        // 9. Salam & Sapaan
        if (query.includes('salam') || query.includes('hai') || query.includes('hello') || query.includes('hi') || query.includes('assalam') || query.includes('pagi') || query.includes('petang')) {
            return `Hai, salam sejahtera! Boleh saya bantu anda dengan apa-apa permohonan atau pertanyaan mengenai perkhidmatan ICT hari ini? Sila pilih topik di atas atau taip soalan anda.`;
        }

        // 10. Fallback Umum
        return `Terima kasih atas mesej anda. Bagi pertanyaan berkenaan <em>"${escapeHtml(userInput)}"</em>, anda boleh membuat permohonan terus melalui pautan <a href="<?= url('/tickets/create') ?>" class="text-blue-600 font-bold underline">+ Buat Permohonan Baru</a> atau hubungi pegawai ICT kami di talian <strong>010-5528875</strong> untuk bantuan segera.`;
    }

    // Handle Form Submit
    window.handleChatSubmit = function(e) {
        if (e) e.preventDefault();
        const input = document.getElementById('ict-chatbot-input');
        const text = (input ? input.value : '').trim();
        if (!text) return;

        input.value = '';
        appendMessage('user', text);

        // Tunjukkan typing indicator
        const typing = document.getElementById('ict-chatbot-typing');
        if (typing) typing.classList.remove('hidden');
        scrollChatToBottom();

        // Asynchronous bot response with typing delay
        setTimeout(async () => {
            try {
                const botReply = await generateBotResponse(text);
                if (typing) typing.classList.add('hidden');
                appendMessage('bot', botReply, true);
            } catch (err) {
                if (typing) typing.classList.add('hidden');
                appendMessage('bot', 'Maaf, berlaku sedikit ralat rangkaian semasa memproses pertanyaan anda.', true);
            }
        }, 500);
    };

    // Handle Quick Action Chip Click
    window.sendQuickMessage = function(text) {
        appendMessage('user', text);
        const typing = document.getElementById('ict-chatbot-typing');
        if (typing) typing.classList.remove('hidden');
        scrollChatToBottom();

        setTimeout(async () => {
            try {
                const botReply = await generateBotResponse(text);
                if (typing) typing.classList.add('hidden');
                appendMessage('bot', botReply, true);
            } catch (err) {
                if (typing) typing.classList.add('hidden');
                appendMessage('bot', 'Maaf, berlaku sedikit ralat rangkaian.', true);
            }
        }, 450);
    };
})();
</script>
