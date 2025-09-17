# OS Command Simulator (SAFE)

**OS Command Simulator** adalah aplikasi PHP sederhana untuk tujuan pembelajaran yang **TIDAK** mengeksekusi perintah shell. Aplikasi ini menampilkan perintah yang diterima (disanitasi) dan memberikan *simulated output* untuk beberapa perintah umum (mis. `date`, `uptime`, `echo`). Aplikasi ini ditujukan hanya untuk latihan dan demonstrasi konsep webshell tanpa resiko.

> **PERINGATAN:** Jangan pernah menaruh aplikasi ini di server publik tanpa konfigurasi keamanan. Gunakan hanya di lingkungan lokal atau VM lab.

## Fitur
- Menerima input perintah lewat form
- Menampilkan perintah setelah disanitasi (mencegah XSS)
- Mensimulasikan output untuk perintah: `date`, `uptime`, `echo`, `whoami`, `ls`
- Tidak memanggil fungsi PHP yang menjalankan shell (mis. `exec`, `system`, `shell_exec`)

## Cara menjalankan (lokal)
1. Pastikan PHP terpasang (PHP 7.2+ direkomendasikan).
2. Jalankan built-in server:
```bash
php -S 127.0.0.1:8000

Buka di browser: http://127.0.0.1:8000/simulator.php

## Cara Berkontribusi
- Fork repo ini.
- Buat branch fitur: git checkout -b feature/nama-fitur
- Commit perubahan: git commit -m "feat: deskripsi singkat"
- Push dan buat pull request.

## Keamanan dan Etika
- Aplikasi ini tidak mengeksekusi perintah — ini sengaja demi keamanan.
- Jangan mengunggah file yang berisi password atau credential.
- Jangan gunakan contoh ini untuk melakukan aktivitas ilegal.
