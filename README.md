# SIPMAS Galung Maloang

**Sistem Informasi Pelayanan Masyarakat Kelurahan Galung Maloang**

SIPMAS adalah sistem pelayanan administrasi surat berbasis web untuk Kelurahan Galung Maloang, Kecamatan Bacukiki, Kota Parepare. Sistem ini memungkinkan warga mengajukan surat secara online, RT melakukan verifikasi, dan staff kelurahan memproses hingga surat diterbitkan dan dikirim ke WhatsApp warga.

---

## 🚀 Fitur Utama

### 👤 Warga

- Registrasi & Login
- Lengkapi profil (NIK, alamat, dll)
- Upload KTP & KK
- Ajukan surat (10 jenis + "Lainnya")
- Upload dokumen pendukung
- Riwayat pengajuan
- Tracking status pengajuan
- Download PDF surat yang sudah diterbitkan

### 👥 RT (Ketua RT)

- Dashboard monitoring pengajuan
- Approve / Reject pengajuan warga
- Berikan alasan penolakan

### 👨‍💼 Staff Kelurahan

- Dashboard monitoring
- Proses pengajuan
- Edit surat (hybrid: template + manual)
- Preview surat
- Terbitkan surat
- Generate PDF otomatis (Browsershot)
- Kirim surat ke WhatsApp warga (Fonnte)

### 🔧 Admin

- Kelola data Lurah (nama, pangkat, NIP)
- Upload barcode Lurah
- Kelola kop surat

---

## 🛠️ Teknologi

| Teknologi                   | Keterangan         |
| --------------------------- | ------------------ |
| **Laravel 12**              | Framework PHP      |
| **PHP 8.2+**                | Bahasa pemrograman |
| **Tailwind CSS v4**         | Styling UI         |
| **Livewire 3**              | Interaktivitas     |
| **MySQL**                   | Database           |
| **Browsershot + Puppeteer** | Generate PDF       |
| **Fonnte API**              | WhatsApp Gateway   |
| **Laravel Queue**           | Background job     |

---

## 📋 Jenis Surat yang Didukung

1. Surat Keterangan Domisili
2. Surat Keterangan Penghasilan Orang Tua
3. Surat Keterangan Tidak Mampu
4. Surat Keterangan Usaha/Penghasilan
5. Surat Pengantar Izin Keramaian
6. Surat Rekomendasi BBM Bersubsidi
7. Surat Keterangan Belum Menikah
8. Surat Keterangan Kematian
9. Surat Keterangan Tanah Tidak Sengketa
10. Surat Pengantar SKCK
11. Lainnya (custom)

---

## 📁 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/your-username/sipmas-galung-maloang.git
cd sipmas-galung-maloang
```
