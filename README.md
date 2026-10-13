# Payment Gateway Xendit (Laravel)

Integrasi payment gateway sederhana dengan Xendit (mode Test) memakai Laravel. Panggilan ke API Xendit dilakukan di sisi server, dan secret key disimpan di `.env`.

## Fitur
- Form checkout, lalu membuat Invoice Xendit dan redirect ke halaman bayar Xendit
- Halaman status pembayaran
- Endpoint `GET /api/balance` untuk cek saldo Xendit
- Webhook `POST /api/xendit/webhook` (diverifikasi lewat header `x-callback-token`) untuk update status pembayaran

## Struktur utama
- `app/Services/XenditService.php`: client API Xendit (Basic Auth)
- `app/Http/Controllers/PaymentController.php`: checkout, hasil, webhook, balance
- `routes/web.php` dan `routes/api.php`: rute halaman dan API
- `config/services.php`: konfigurasi key Xendit dari `.env`

## Cara menjalankan
```bash
composer install
cp .env.example .env
php artisan key:generate
```
Isi di `.env` (dari dashboard Xendit, mode Test):
```
XENDIT_SECRET_KEY=xnd_development_...
XENDIT_CALLBACK_TOKEN=...
```
Lalu:
```bash
php artisan migrate
php artisan serve
```
Buka `http://127.0.0.1:8000`. Cek saldo di `http://127.0.0.1:8000/api/balance`.

Catatan: webhook tidak bisa menjangkau localhost, jadi pakai tunnel (misalnya ngrok) dan daftarkan URL `/api/xendit/webhook` di dashboard Xendit.
