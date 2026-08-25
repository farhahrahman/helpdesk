# Sistem Helpdesk & Pengurusan Permohonan ICT BKP
**Bahagian Khidmat Pengurusan (BKP) & Pejabat TSUK Pengurusan**

Sistem Pengurusan Permohonan & Khidmat Sokongan ICT Rasmi berpusat bagi menyelaras permohonan peminjaman aset (iPhone, Kamera DSLR, Mikrofon Audio, Komputer Riba), sokongan teknikal mesyuarat (Online & Bilik Mesyuarat), dan khidmat media/jurukamera secara teratur mengikut tatacara pentadbiran kerajaan tanpa pesanan lisan tidak berekod.

---

## 1. Ciri-Ciri Utama Sistem

1. **Aliran Kerja Perakuan & Kelulusan Berlapis (Multi-Tier Approval):**
   * Menghalang isu staf membuat pesanan secara terus/lisan (*main order*).
   * **Peringkat 1:** Perakuan & Sokongan oleh **Ketua Unit** pemohon masing-masing.
   * **Peringkat 2:** Penilaian ketersediaan, peruntukan aset fizikal & kelulusan rasmi oleh **Seksyen ICT BKP**.
2. **Katalog Perkhidmatan Komprehensif:**
   * **Peminjaman Peralatan / Aset ICT:** iPhone 15 Pro, iPhone 14 Pro, Kamera DSLR Canon/Sony, Mikrofon Wireless RODE/Shure PA Kit, Laptop Dell/Lenovo/MacBook, Projektor & Presenter.
   * **Khidmat Sokongan Mesyuarat:** Penyediaan pautan rasmi Zoom / Webex / Teams / Google Meet, sokongan teknikal bilik mesyuarat, dan persidangan video hibrid.
   * **Khidmat Media & Fotografi:** Jurugambar dan juruvideo untuk majlis rasmi, kursus, bengkel dan kunjungan kenamaan.
3. **Enterprise JSON Storage Engine V3:**
   * Penyimpanan tanpa SQL yang pantas dan selamat menggunakan *Atomic File Locking* (`flock`), *Safe Swap Writing* (`tempnam` + `rename`), dan *Transactional Safety*.
   * Penjanaan automatik No. Rujukan Berstruktur (`ICTBKP/2026/08/0001`).
4. **Jejak Audit Integriti (Audit Trail):**
   * Setiap tindakan direkodkan dengan cap masa, alamat IP, peranan, dan catatan ulasan.
5. **Slip Rasmi Cetakan (Printable Slip):**
   * Borang penyerahan dan penerimaan aset lengkap dengan perakuan pemohon, Ketua Unit, dan Pegawai ICT.
6. **Kalendar & Jadual Aktiviti:**
   * Paparan interaktif susunan jadual penggunaan peralatan dan acara untuk mengelakkan pertindihan slot.

---

## 2. Struktur 6 Unit BKP & Pejabat TSUK

| Kod Unit | Nama Unit | Peranan Utama |
| :--- | :--- | :--- |
| **TSUK** | Pejabat TSUK (Pengurusan) | Pengurusan Tertinggi SUK |
| **PENTADBIRAN** | Unit Pentadbiran | Pentadbiran Am & Operasi BKP |
| **BANGUNAN_ASET** | Unit Pengurusan Bangunan dan Aset | Pengurusan Fasiliti & Aset |
| **KESELAMATAN_BENCANA** | Unit Keselamatan Dan Bencana Alam | Keselamatan Premis & Bencana |
| **KEWANGAN** | Unit Kewangan | Perakaunan & Bajet |
| **ISTIADAT_PROTOKOL** | Unit Istiadat dan Protokol | Acara Rasmi & Sambutan Negeri |
| **DASAR_PEROLEHAN** | Unit Dasar, Keurussetiaan dan Perolehan | Dasar, Mesyuarat & Perolehan |
| **ICT_BKP** | Seksyen ICT BKP | Pentadbiran Sistem & Khidmat Teknikal |

---

## 3. Akaun Ujian Pra-Tetap (Demo Log Masuk)

Semua akaun menggunakan kata laluan lalai: `password123`

1. **Pentadbir Sistem & Pegawai ICT:**
   * Emel: `admin@bkp.gov.my`
   * Peranan: `ADMIN` (Akses penuh kelulusan ICT, inventori aset & laporan)
2. **Ketua Unit Pentadbiran:**
   * Emel: `ketua.pentadbiran@bkp.gov.my`
   * Peranan: `KETUA_UNIT` (Perakuan permohonan staf Unit Pentadbiran)
3. **Ketua Unit Bangunan & Aset:**
   * Emel: `ketua.aset@bkp.gov.my`
4. **Ketua Unit Kewangan:**
   * Emel: `ketua.kewangan@bkp.gov.my`
5. **Staf Pejabat TSUK Pengurusan:**
   * Emel: `staf.tsuk@bkp.gov.my`
   * Peranan: `STAF` (Membuat permohonan peminjaman / media)
6. **Staf Unit Pentadbiran:**
   * Emel: `staf.pentadbiran@bkp.gov.my`
   * Peranan: `STAF`
7. **Staf Unit Kewangan:**
   * Emel: `staf.kewangan@bkp.gov.my`
   * Peranan: `STAF`

---

## 4. Arahan Pemasangan & Pengujian

1. Pastikan persekitaran PHP 8.2+ dan Composer sedia ada.
2. Jana semula autoloader & seed data:
   ```bash
   composer dump-autoload
   php app/cli/seed.php
   ```
3. Buka pelayar web melalui Laragon di:
   `http://localhost/helpdesk/public` atau `http://helpdesk.test`
