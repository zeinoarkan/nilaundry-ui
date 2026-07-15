<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Data User Statis (Sebagai pengganti Database)
     */
    private function getStaticUsers()
    {
        return collect([
            (object)[
                'id' => 1,
                'name' => 'zeino',
                'email' => 'zeino@gmail.com',
                'password' => 'zeino', // password polos untuk mempermudah mock login
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 10, Yogyakarta'
            ],
            (object)[
                'id' => 2,
                'name' => 'Siti Aminah',
                'email' => 'siti@gmail.com',
                'password' => 'siti123',
                'no_hp' => '085712345678',
                'alamat' => 'Jl. Mawar No. 5, Sleman'
            ]
        ]);
    }

    /**
     * Menampilkan halaman profil user yang sedang login
     */
    public function profile()
    {
        // Ambil data pelanggan yang sedang login melalui guard 'web'
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Variabel $user ini adalah instance dari model Pelanggan Anda
        return view('profile', compact('user'));
    }

    /**
     * Proses Mock Login (Tanpa Auth bawaan Laravel/Database)
     */
    public function loginProcess(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Cari user di data statis yang email & password-nya cocok
        $user = $this->getStaticUsers()->first(function ($u) use ($email, $password) {
            return $u->email === $email && $u->password === $password;
        });

        if ($user) {
            // Simpan data user ke session jika login berhasil
            session(['mock_user' => $user]);
            return redirect('/user/layanan')->with('success', 'Selamat datang kembali, ' . $user->name);
        }

        return back()->with('error', 'Email atau password salah!');
    }

    /**
     * Proses Mock Logout
     */
    public function logout()
    {
        // Hapus session user
        session()->forget('mock_user');
        return redirect('/user/layanan');
    }
}

Route::post('/pesan', function (Illuminate\Http\Request $request) {
    // Di sini kamu bisa menangkap data $request->id_layanan dan $request->metode jika perlu
    
    // Pura-pura berhasil dan kembali ke halaman layanan dengan pesan sukses
    return redirect('/user/layanan')->with('success', 'Request penjemputan berhasil disimulasikan!');
})->name('pesan.store');