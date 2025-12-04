# SIAmie – Sistem Informasi Penjualan & Manajemen Inventori

SIAmie adalah aplikasi berbasis web yang digunakan untuk mengelola data produk, transaksi penjualan, pelanggan, detail kendaraan, kasir, dan laporan terkait proses operasional toko/bengkel.  
Project ini dibangun menggunakan **PHP Native** dan **MySQL**, sehingga ringan, mudah dipahami, dan cocok digunakan sebagai sistem internal skala kecil–menengah.

---

## 🚀 Features

### **1. Manajemen Produk**
- Tambah, ubah, hapus data produk  
- Stok & harga produk  
- Upload gambar produk

### **2. Manajemen Pelanggan**
- Input & update data customer  
- Riwayat transaksi pelanggan

### **3. Penjualan (Nota Penjualan)**
- Input transaksi  
- Hitung total otomatis  
- Cetak nota

### **4. Manajemen Kendaraan**
- Data kendaraan pelanggan  
- Relasi dengan transaksi

### **5. Dashboard**
- Ringkasan produk  
- Aktivitas kasir  
- Overview transaksi

### **6. Autentikasi**
- Halaman registrasi (`signup.php`)  
- (Opsional) login–logout jika ditambahkan pada versi selanjutnya

---

## 📂 Project Structure
SIAmie/
│── index.php # Halaman utama

│── koneksi.php # Koneksi database

│── signup.php # Register user
│── index.css # Styling halaman utama

│── signup.css # Styling signup

│
├── dashboard/ # Dashboard kasir/admin
├── produk/ # CRUD produk
├── customer/ # CRUD pelanggan
├── kendaraan/ # Data kendaraan pelanggan
├── kasir/ # Modul kasir
├── notapenjualan/ # Input & cetak nota
├── detailpart/ # Detail part & relasi
└── pict/ # Asset gambar
