<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('user/landing');
});

Route::get('/user/dashboard', function () {
    session(['user_logged_in' => true]); 
    
    return view('user.dashboard');
})->name('user.dashboard');

Route::get('/layanan', function () {
    $layanan = collect([
        (object)[
            'id_layanan' => 'L001',
            'nama_layanan' => 'Reguler (2hari)',
            'harga' => 5000,
            'jenis' => 'Kiloan'
        ],
        (object)[
            'id_layanan' => 'L002',
            'nama_layanan' => 'Kilat(24jam',
            'harga' => 8000,
            'jenis' => 'Kiloan'
        ],
        (object)[
            'id_layanan' => 'L003',
            'nama_layanan' => 'Express(12jam)',
            'harga' => 10000,
            'jenis' => 'Kiloan'
        ],
        (object)[
            'id_layanan' => 'L004',
            'nama_layanan' => 'Express(6jam)',
            'harga' => 21000,
            'jenis' => 'Kiloan'
        ],
        (object)[
            'id_layanan' => 'L005',
            'nama_layanan' => 'Jaket',
            'harga' => 8000,
            'jenis' => 'Satuan'
        ],
        (object)[
            'id_layanan' => 'L006',
            'nama_layanan' => 'Jas',
            'harga' => 20000,
            'jenis' => 'Satuan'
        ],
        (object)[
            'id_layanan' => 'L007',
            'nama_layanan' => 'Almamater',
            'harga' => 10000,
            'jenis' => 'Satuan'
        ],
        (object)[
            'id_layanan' => 'L008',
            'nama_layanan' => 'Kemeja',
            'harga' => 5000,
            'jenis' => 'Satuan'
        ],
        (object)[
            'id_layanan' => 'L009',
            'nama_layanan' => 'Bed Cover',
            'harga' => 25000,
            'jenis' => 'Pakaian Berat'
        ],
        (object)[
            'id_layanan' => 'L010',
            'nama_layanan' => 'Selimut',
            'harga' => 10000,
            'jenis' => 'Pakaian Berat'
        ],
        (object)[
            'id_layanan' => 'L011',
            'nama_layanan' => 'Sprei',
            'harga' => 9000,
            'jenis' => 'Pakaian Berat'
        ],
        (object)[
            'id_layanan' => 'L012',
            'nama_layanan' => 'Bantal',
            'harga' => 15000,
            'jenis' => 'Khusus'
        ],
        (object)[
            'id_layanan' => 'L013',
            'nama_layanan' => 'Sepatu Reguler',
            'harga' => 25000,
            'jenis' => 'Khusus'
        ],
        (object)[
            'id_layanan' => 'L014',
            'nama_layanan' => 'Sepatu Reguler(Putih)',
            'harga' => 30000,
            'jenis' => 'Khusus'
        ],
        (object)[
            'id_layanan' => 'L015',
            'nama_layanan' => 'Sepatu Kilat',
            'harga' => 35000,
            'jenis' => 'Khusus'
        ],
        (object)[
            'id_layanan' => 'L016',
            'nama_layanan' => 'Sepatu Kilat(putih)',
            'harga' => 40000,
            'jenis' => 'Khusus'
        ],
        (object)[
            'id_layanan' => 'L017',
            'nama_layanan' => 'Boneka Kecil',
            'harga' => 15000,
            'jenis' => 'Khusus'
        ],
        (object)[
            'id_layanan' => 'L018',
            'nama_layanan' => 'Boneka Sedang',
            'harga' => 35000,
            'jenis' => 'Khusus'
        ],
        (object)[
            'id_layanan' => 'L019',
            'nama_layanan' => 'Boneka Besar',
            'harga' => 50000,
            'jenis' => 'Khusus'
        ],
        (object)[
            'id_layanan' => 'L020',
            'nama_layanan' => 'Tas',
            'harga' => 15000,
            'jenis' => 'Khusus'
        ],
        (object)[
            'id_layanan' => 'L021',
            'nama_layanan' => 'Tas Carrier',
            'harga' => 35000,
            'jenis' => 'Khusus'
        ],
        (object)[
            'id_layanan' => 'L022',
            'nama_layanan' => 'Karpet',
            'harga' => 35000,
            'jenis' => 'Khusus'
        ],
        (object)[
            'id_layanan' => 'L023',
            'nama_layanan' => 'Karpet',
            'harga' => 4000,
            'jenis' => 'Tambahan'
        ],
        (object)[
            'id_layanan' => 'L024',
            'nama_layanan' => 'Setrika',
            'harga' => 4000,
            'jenis' => 'Tambahan'
        ]
    ]);
    return view('user/layanan', compact('layanan'));
});

Route::post('/pesan', function (\Illuminate\Http\Request $request) {
    // 1. Cek apakah user belum login
    if (!session()->has('user_logged_in')) {
        // Jika belum, lempar ke halaman login dengan pesan peringatan
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk melakukan pesanan!');
    }

    // 2. Jika sudah login, proses pesanan pura-pura berhasil
    return redirect()->back()->with('success', 'Request penjemputan berhasil disimulasikan!');
})->name('pesan.store');

// Tampilkan halaman login user
Route::get('/login', [AuthController::class, 'formLoginUser'])->name('login');
// Proses submit login user
Route::post('/login', [AuthController::class, 'loginUser'])->name('login.perform');



// ==========================================
//            ROUTE UTK ADMIN
// ==========================================
// Tampilkan halaman login admin
Route::get('/admin/login', [AuthController::class, 'formLoginAdmin'])->name('admin.login');
// Proses submit login admin
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);

// Proteksi Dashboard Admin (Harus punya session admin)
Route::get('/admin/dashboard', function () {
    if (!session()->has('admin_logged_in')) {
        return redirect('/admin/login')->with('error', 'Silakan login terlebih dahulu!');
    }
    
    // CONTOH DATA DUMMY
    
    $pesanan_terbaru = collect([
        (object)[
            'id_pesanan' => '001',
            'pelanggan' => (object)['nama' => 'Nama Pelanggan 1'],
            'layanan' => (object)['nama_layanan' => 'Reguler (2hari)'],
            'berat' => 3.5,
            'status_pesanan' => 'Diproses'
        ],
        (object)[
            'id_pesanan' => '002',
            'pelanggan' => (object)['nama' => 'Nama Pelanggan 2'],
            'layanan' => (object)['nama_layanan' => 'Express (12jam)'],
            'berat' => 2,
            'status_pesanan' => 'Pending'
        ],
        (object)[
            'id_pesanan' => '003',
            'pelanggan' => (object)['nama' => 'Nama Pelanggan 3'],
            'layanan' => (object)['nama_layanan' => 'Bed Cover'],
            'berat' => 5,
            'status_pesanan' => 'Selesai'
        ]
    ]);

    // Me-return view admin/dashboard.blade.php beserta datanya
    return view('admin.dashboard', [
        'total_pesanan' => 128,
        'total_pelanggan' => 45,
        'pendapatan' => 3500000,
        'pesanan_terbaru' => $pesanan_terbaru
    ]);
});

Route::post('/logout', function() {
    Auth::logout();
    session()->forget('user_logged_in'); 
    
    return redirect('/login');
})->name('logout');

Route::get('/riwayat', function () {
    return view('user/riwayat');
})->name('riwayat');

Route::get('/admin/pesanan', function (Request $request) {
    // 1. Proteksi Halaman
    if (!session()->has('admin_logged_in')) {
        return redirect('/admin/login')->with('error', 'Silakan login terlebih dahulu!');
    }

    // 2. Data Pesanan Statis (Dummy Collection)
    $pesanan = collect([
        (object)[
            'id_pesanan' => 'ORD-001',
            'tanggal_pesan' => '2023-10-25 10:00:00',
            'pelanggan' => (object)['nama' => 'Budi Santoso'],
            'metode' => 'Antar Jemput',
            'layanan' => (object)['jenis' => 'Kiloan', 'nama_layanan' => 'Reguler (2hari)'],
            'berat' => 3.5,
            'total_harga' => 17500,
            'status_pesanan' => 'Selesai',
            'snap_token' => null // Lunas
        ],
        (object)[
            'id_pesanan' => 'ORD-002',
            'tanggal_pesan' => '2023-10-26 14:30:00',
            'pelanggan' => (object)['nama' => 'Siti Aminah'],
            'metode' => 'Bawa Sendiri',
            'layanan' => (object)['jenis' => 'Kiloan', 'nama_layanan' => 'Express (12jam)'],
            'berat' => 2,
            'total_harga' => 20000,
            'status_pesanan' => 'Diproses',
            'snap_token' => 'dummy_token_123' // Belum Bayar
        ],
        (object)[
            'id_pesanan' => 'ORD-003',
            'tanggal_pesan' => '2023-10-27 09:15:00',
            'pelanggan' => (object)['nama' => 'Andi Darmawan'],
            'metode' => 'Antar Jemput',
            'layanan' => (object)['jenis' => 'Pakaian Berat', 'nama_layanan' => 'Bed Cover'],
            'berat' => 5,
            'total_harga' => 25000,
            'status_pesanan' => 'Pending',
            'snap_token' => 'dummy_token_456'
        ],
        (object)[
            'id_pesanan' => 'ORD-004',
            'tanggal_pesan' => now()->format('Y-m-d H:i:s'),
            'pelanggan' => (object)['nama' => 'Rina Melati'],
            'metode' => 'Bawa Sendiri',
            'layanan' => (object)['jenis' => 'Satuan', 'nama_layanan' => 'Jas'],
            'berat' => 1,
            'total_harga' => 20000,
            'status_pesanan' => 'Pending',
            'snap_token' => null
        ]
    ]);


    
    return view('admin.pesanan.index', compact('pesanan'));
});

// Update Status Pesanan
Route::post('/admin/pesanan/{id}/update-status', function ($id, Request $request) {
    // Karena tanpa database, kita pura-pura berhasil update dan kembali ke halaman sebelumnya
    return back()->with('success', "Status pesanan $id berhasil diubah menjadi: " . $request->status_pesanan);
});

// Edit Pesanan (Lempar ke halaman form edit)
Route::get('/admin/pesanan/{id}/edit', function ($id) {
    return "Ini adalah halaman pura-pura untuk Edit Pesanan ID: $id";
});

// Hapus Pesanan
Route::delete('/admin/pesanan/{id}', function ($id) {
    // Karena tanpa database, kita pura-pura berhasil menghapus
    return back()->with('success', "Pesanan $id berhasil dihapus!");
});

// Halaman profil
Route::get('/profile', [UserController::class, 'profile'])->name('profile');

Route::get('/register', function() { return view('auth.register'); })->name('register');
Route::post('/register', [AuthController::class, 'registerUser']);

Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Halaman utama kelola pesanan
Route::get('/admin/pesanan', [AdminController::class, 'pesanan']);

// Aksi-aksi form & tombol pada tabel
Route::post('/admin/pesanan/{id}/update-status', [AdminController::class, 'updateStatus']);
Route::post('/admin/pesanan/{id}/bayar-tunai', [AdminController::class, 'bayarTunai']);
Route::post('/admin/pesanan/{id}/refund', [AdminController::class, 'refund'])->name('admin.pesanan.refund');
Route::post('/admin/pesanan/{id}', [AdminController::class, 'destroy']); // Untuk hapus

// Membuka form edit pesanan
Route::get('/admin/pesanan/{id}/edit', [AdminController::class, 'edit']);

// Memproses submit data form edit
Route::post('/admin/pesanan/{id}/update-full', [AdminController::class, 'updateFull']);

Route::get('/admin/layanan', [AdminController::class, 'layananIndex']);
// Rute untuk menampilkan halaman form tambah layanan
Route::get('/admin/layanan/create', [AdminController::class, 'layananCreate']);

// Rute untuk memproses submit data (Store) dari form tambah layanan
Route::post('/admin/layanan', [AdminController::class, 'layananStore']);
Route::get('/admin/layanan/{id}/edit', [AdminController::class, 'layananEdit']);
Route::delete('/admin/layanan/{id}', [AdminController::class, 'layananDestroy']);

// Rute untuk menampilkan halaman form edit layanan
Route::get('/admin/layanan/{id}/edit', [AdminController::class, 'layananEdit']);

// Rute untuk memproses submit data (Update) dari form edit layanan
Route::put('/admin/layanan/{id}', [AdminController::class, 'layananUpdate']);