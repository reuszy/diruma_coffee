# Website Diruma Coffee and Living menggunakan Laravel

## Overview

Project ini adalah **Sistem Manajemen Coffeeshop Diruma** yang dibangun menggunakan framework Laravel. Sistem ini menyediakan fungsionalitas bagi administrator untuk mengelola operasional cafe secara efisien, termasuk kategori, menu, informasi kontak, dan pesanan. Bagi user, web ini berfungsi sebagai platform online untuk menjelajahi menu cafe dan melakukan pemesanan katering.

---

## Fitur

-   **Manajemen Kategori**: Admin dapat membuat, mengupdate, dan menghapus kategori untuk mengatur menu.
-   **Manajemen Menu**: Tambah, edit, dan hapus item menu dengan detail seperti harga, deskripsi, dan kategori.
-   **Manajemen Kontak**: Kelola informasi kontak cafe, termasuk nomor telepon, alamat, jam kerja, dan akun social media.
-   **Manajemen Pesanan**: Lihat dan proses pesanan catering user secara efisien.
-   **Jelajahi Menu**: User dapat menjelajahi menu cafe, memfilter berdasarkan kategori, dan melihat informasi detail tentang setiap menu.
-   **Pemesanan Katering Online**: User dapat menambahkan menu Katering ke keranjang belanja, melakukan pemesanan online, dan menerima konfirmasi pesanan.
-   **Desain Responsif**: Desain website sepenuhnya responsif, memastikan situs berfungsi dengan lancar di semua perangkat.
-   **Konten Dinamis**: Admin dapat memperbarui informasi seperti jam kerja, alamat, dan nomor telepon secara dinamis.

---

## Demo

Akses demo dari project ini: [Sistem Manajemen Coffeeshop Diruma](https://diruma.reuszy.site/)

---

## Keamanan

Mengimplementasikan JSON Web Token atau JWT untuk memastikan keamanan

---

## Library Yang Digunakan

Proyek ini menggunakan library - library berikut untuk meningkatkan fungsionalitas:

-   **[ezyang/htmlpurifier (4.18.0)](https://github.com/ezyang/htmlpurifier)**: Standards-compliant HTML filter written in PHP to ensure clean and secure HTML content.
-   **[intervention/image-laravel (1.3.0)](https://github.com/Intervention/image)**: Laravel integration of Intervention Image for image manipulation.
-   **[Midtrans-PHP](https://github.com/Midtrans/midtrans-php.git)**: Laravel integration Payment Gateaway.

---

## Cara Run Project Ini di Komputer Kamu

Ikuti langkah - langkah berikut:

### **Step 1: Clone Repository**

```bash
git clone https://github.com/reuszy/diruma_coffee.git
cd diruma_coffee
```

### **Step 2: Set Up .Env**

1. Rename file `.env.example` ke `.env`:
    ```bash
    mv .env.example .env
    ```

### 2. Konfigurasi `.env`

Set up `.env` file dengan konfigurasi berikut:

#### **Koneksi Database**

Sesuaikan database settings nya:

```plaintext
DB_CONNECTION=mysql
DB_HOST=db_diruma
DB_PORT=127.0.0.1
DB_DATABASE=3306
DB_USERNAME=root
DB_PASSWORD=
```

#### **Konfigurasi Midtrans**

Untuk mendapatkan ClientKey dan ServerKey Midtrans, silahkan registrasi terlebih dahulu di: [Midtrans](https://midtrans.com/id):

```plaintext
MIDTRANS_SERVER_KEY=xxx-xxxxx-xxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=xxx-xxxxx-xxxxxxxxxxxxx
```

#### **Konfigurasi JWT**

Untuk mendapatkan JWT Secret Key, silahkan buka dokumentasi nya disini: [JWT Auth](https://jwt-auth.readthedocs.io/en/develop/laravel-installation/):

```plaintext
MIDTRANS_SERVER_KEY=xxx-xxxxx-xxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=xxx-xxxxx-xxxxxxxxxxxxx
```

--

### **Step 3: Install NPM**

Jalankan perintah ini di terminal:

```bash
npm install
```

### **Step 4: Install Package Project nya**

Jalankan perintah ini di terminal:

```bash
composer install
```

### **Step 5: Buat Key Apps nya**

Jalankan perintah ini di terminal:

```bash
php artisan key:generate
```

### **Step 6: Set Up Database**

1. Buat database MySQL baru (e.g., `db_diruma`).
2. Migration database nya:
    ```bash
    php artisan migrate
    ```
3. Migrate seeder nya:
    ```bash
    php artisan db:seed --class=UserSeeder
    ```

### **Step 7: Jalankan Projectnya**

Run projectnya dan akan berjalan di port 8000 atau port apapun tergantung pilihan anda:

```bash
php artisan serve
```

Lihat website nya di: `http://127.0.0.1:8000`.

## 👥 Contributors

- **Rizqi Dwi Saputra** — Fullstack Developer  
  GitHub: https://github.com/reuszy

## Credits

-   **[BootstrapDash](https://github.com/BootstrapDash/celestialAdmin-free-admin-template)**: The admin dashboard celestialAdmin admin template
    design is powered by BootstrapDash, offering a modern and customizable interface.
-   **[Templatemagic Portfolio](https://themeforest.net/user/templatemagic/portfolio)**: The front-end template for the website is inspired by Templatemagic's portfolio designs.

---

Silahkan untul fork repositori ini atau berkontribusi pada development dengan mengirimkan pull request ke saya!

---
