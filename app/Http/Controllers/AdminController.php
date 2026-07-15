<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ====================================================================
    // FITUR MANAJEMEN PESANAN
    // ====================================================================

    /**
     * Menampilkan daftar pesanan (Data Dummy)
     */
    public function pesanan(Request $request)
    {
        // 1. Membuat data pesanan palsu (menggunakan stdClass agar menyerupai objek database)
        $p1 = new \stdClass();
        $p1->id_pesanan = 1;
        $p1->tanggal_pesan = '2026-07-08';
        $p1->metode = 'Antar Jemput';
        $p1->berat = 3.5;
        $p1->total_harga = 28000;
        $p1->jumlah_bayar = 28000; // Lunas
        $p1->status_pesanan = 'Selesai';
        $p1->pelanggan = (object)['nama' => 'Ahmad Subarjo'];
        $p1->layanan = (object)['jenis' => 'Kiloan', 'nama_layanan' => 'Cuci Setrika Reguler'];

        $p2 = new \stdClass();
        $p2->id_pesanan = 2;
        $p2->tanggal_pesan = '2026-07-09';
        $p2->metode = 'Drop Off';
        $p2->berat = 0; // Belum ditimbang
        $p2->total_harga = 0;
        $p2->jumlah_bayar = 0;
        $p2->status_pesanan = 'Pending';
        $p2->pelanggan = (object)['nama' => 'Siti Rahma'];
        $p2->layanan = (object)['jenis' => 'Kiloan', 'nama_layanan' => 'Cuci Ekspres'];

        $p3 = new \stdClass();
        $p3->id_pesanan = 3;
        $p3->tanggal_pesan = '2026-07-09';
        $p3->metode = 'Antar Jemput';
        $p3->berat = 2;
        $p3->total_harga = 50000;
        $p3->jumlah_bayar = 20000; // DP (Belum lunas)
        $p3->status_pesanan = 'Diproses';
        $p3->pelanggan = (object)['nama' => 'Budi Santoso'];
        $p3->layanan = (object)['jenis' => 'Satuan', 'nama_layanan' => 'Cuci Jas & Blazer'];

        $p4 = new \stdClass();
        $p4->id_pesanan = 4;
        $p4->tanggal_pesan = '2026-07-07';
        $p4->metode = 'Drop Off';
        $p4->berat = 1.5;
        $p4->total_harga = 15000;
        $p4->jumlah_bayar = 0; // Belum bayar sama sekali
        $p4->status_pesanan = 'Menunggu Pembayaran';
        $p4->pelanggan = (object)['nama' => 'Rini Amelia'];
        $p4->layanan = (object)['jenis' => 'Kiloan', 'nama_layanan' => 'Setrika Saja'];

        // 2. Gabungkan ke dalam satu Collection laundry
        $semuaPesanan = collect([$p1, $p2, $p3, $p4]);

        // 3. Fitur Pencarian Dummy (Jika input pencarian diisi)
        if ($request->has('search') && $request->search != '') {
            $search = strtolower($request->search);
            $semuaPesanan = $semuaPesanan->filter(function ($item) use ($search) {
                return str_contains(strtolower($item->pelanggan->nama), $search) || 
                       str_contains(strtolower($item->status_pesanan), $search) ||
                       str_contains(strtolower($item->id_pesanan), $search);
            });
        }

        // 4. Kirim data ke view admin.pesanan.index
        $pesanan = $semuaPesanan;
        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $statusBaru = $request->input('status_pesanan');
        return back()->with('success', "Status Pesanan #$id berhasil diperbarui menjadi <b>$statusBaru</b>!");
    }

    public function bayarTunai(Request $request, $id)
    {
        $uangDiterima = $request->input('uang_diterima');
        if ($uangDiterima) {
            return back()->with('success', "Pembayaran pesanan #$id sebesar <b>Rp " . number_format($uangDiterima, 0, ',', '.') . "</b> berhasil dicatat!");
        }
        return back()->with('success', "Pesanan #$id berhasil dilunasi dengan uang pas!");
    }

    public function refund($id)
    {
        return back()->with('success', "Pesanan #$id berhasil dibatalkan dan status dana berubah menjadi <b>Refunded</b>.");
    }

    public function destroy($id)
    {
        return back()->with('success', "Data transaksi #$id berhasil dihapus secara permanen dari sistem.");
    }

    public function edit($id)
    {
        $pesanan = new \stdClass();
        $pesanan->id_pesanan = $id;
        $pesanan->tanggal_pesan = now()->subHours(2)->format('Y-m-d H:i:s');
        $pesanan->metode = ($id % 2 == 0) ? 'Bawa Sendiri' : 'Antar Jemput';
        $pesanan->berat = ($id == 2) ? 0 : 3.5; 
        $pesanan->total_harga = ($id == 2) ? 0 : 28000;
        $pesanan->jumlah_bayar = ($id == 1) ? 28000 : 0;
        $pesanan->status_pesanan = ($id == 2) ? 'Pending' : 'Diproses';
        
        $pesanan->pelanggan = (object)[
            'nama' => 'Budi Santoso',
            'no_hp' => '082147556964',
            'alamat' => 'Jl. Merdeka No. 123, Denpasar, Bali',
            'progres_kg' => 2 
        ];
        
        $pesanan->layanan = (object)[
            'jenis' => 'Kiloan',
            'nama_layanan' => 'Reguler (2hari)',
            'harga' => 8000
        ];

        return view('admin.pesanan.edit', compact('pesanan'));
    }

    public function updateFull(Request $request, $id)
    {
        $berat = $request->input('berat');
        $total = $request->input('total_harga');
        $status = $request->input('status_pesanan');

        return redirect('/admin/pesanan')->with('success', "Pesanan #$id berhasil diupdate! Berat: <b>$berat Kg</b>, Total: <b>Rp " . number_format($total, 0, ',', '.') . "</b>, Status: <b>$status</b>");
    }



    // FITUR MANAJEMEN LAYANAN
    public function layananIndex()
    {
        $l1 = new \stdClass();
        $l1->id_layanan = 1;
        $l1->nama_layanan = 'Cuci Setrika Reguler';
        $l1->jenis = 'Kiloan';
        $l1->harga = 7000;

        $l2 = new \stdClass();
        $l2->id_layanan = 2;
        $l2->nama_layanan = 'Cuci Ekspres Kilat';
        $l2->jenis = 'Kiloan';
        $l2->harga = 12000;

        $l3 = new \stdClass();
        $l3->id_layanan = 3;
        $l3->nama_layanan = 'Cuci Jas & Blazer';
        $l3->jenis = 'Satuan';
        $l3->harga = 25000;

        $l4 = new \stdClass();
        $l4->id_layanan = 4;
        $l4->nama_layanan = 'Cuci Sepatu Premium';
        $l4->jenis = 'Satuan';
        $l4->harga = 30000;

        $l5 = new \stdClass();
        $l5->id_layanan = 5;
        $l5->nama_layanan = 'Setrika Saja';
        $l5->jenis = 'Kiloan';
        $l5->harga = 5000;

        $layanan = collect([$l1, $l2, $l3, $l4, $l5]);

        return view('admin.layanan.index', compact('layanan'));
    }

    public function layananCreate()
    {
        return view('admin.layanan.create');
    }

    public function layananStore(Request $request)
    {
        $nama = $request->input('nama_layanan');
        $jenis = $request->input('jenis');
        $harga = $request->input('harga');

        // Mengalihkan kembali ke katalog layanan dengan membawa alert sukses
        return redirect('/admin/layanan')->with('success', "Layanan baru <b>$nama</b> berhasil ditambahkan ke katalog! Jenis: <b>$jenis</b>, Harga: <b>Rp " . number_format($harga, 0, ',', '.') . "</b>");
    }

    /**
     * Form Edit Layanan (Simulasi Pengambilan Data Berdasarkan ID)
     */
    public function layananEdit($id)
    {
        // Membuat data objek dummy spesifik berdasarkan ID yang diklik
        $layanan = new \stdClass();
        $layanan->id_layanan = $id;
        
        // Kondisi data dinamis agar tampilan form terisi otomatis sesuai ID-nya
        if ($id == 3) {
            $layanan->nama_layanan = 'Cuci Jas & Blazer';
            $layanan->jenis = 'Satuan';
            $layanan->harga = 25000;
        } elseif ($id == 4) {
            $layanan->nama_layanan = 'Cuci Sepatu Premium';
            $layanan->jenis = 'Satuan';
            $layanan->harga = 30000;
        } elseif ($id == 2) {
            $layanan->nama_layanan = 'Cuci Ekspres Kilat';
            $layanan->jenis = 'Kiloan';
            $layanan->harga = 12000;
        } else {
            $layanan->nama_layanan = 'Cuci Setrika Reguler';
            $layanan->jenis = 'Kiloan';
            $layanan->harga = 7000;
        }

        // Mengembalikan data ke view edit milik admin/layanan
        return view('admin.layanan.edit', compact('layanan'));
    }

    /**
     * Memproses Update Perubahan Layanan (Simulasi)
     */
    public function layananUpdate(Request $request, $id)
    {
        $nama = $request->input('nama_layanan');
        $jenis = $request->input('jenis');
        $harga = $request->input('harga');

        // Mengalihkan kembali ke halaman katalog dengan alert sukses bawaan Laravel
        return redirect('/admin/layanan')->with('success', "Layanan #$id (<b>$nama</b>) berhasil diperbarui! Jenis: <b>$jenis</b>, Harga: <b>Rp " . number_format($harga, 0, ',', '.') . "</b>");
    }

    public function layananDestroy($id)
    {
        return back()->with('success', "Layanan dengan ID #$id berhasil dihapus dari katalog!");
    }
}