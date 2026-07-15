@extends('layouts.main')
@section('title', 'Riwayat Pesanan')

@section('content')

@php
    $pesanan = collect([
        (object)[
            'id_pesanan' => 8,
            'tanggal_pesan' => '2026-06-18', // Menggunakan format Y-m-d agar Carbon bisa memprosesnya
            'total_harga' => 0,
            'jumlah_bayar' => 0,
            'berat' => 0,
            'status_pesanan' => 'Pending',
            'metode' => 'Antar Jemput',
            'layanan' => (object)['nama_layanan' => 'Express (12 jam)', 'jenis' => 'Kiloan']
        ],
        (object)[
            'id_pesanan' => 7,
            'tanggal_pesan' => '2026-06-18',
            'total_harga' => 0,
            'jumlah_bayar' => 0,
            'berat' => 0,
            'status_pesanan' => 'Pending',
            'metode' => 'Antar Jemput',
            'layanan' => (object)['nama_layanan' => 'Reguler (2 hari)', 'jenis' => 'Kiloan']
        ],
        (object)[
            'id_pesanan' => 6,
            'tanggal_pesan' => '2026-06-06',
            'total_harga' => 45000,
            'jumlah_bayar' => 0,
            'berat' => 10,
            'status_pesanan' => 'Menunggu Pembayaran',
            'metode' => 'Antar Jemput',
            'layanan' => (object)['nama_layanan' => 'Reguler (2 hari)', 'jenis' => 'Kiloan']
        ],
        (object)[
            'id_pesanan' => 5,
            'tanggal_pesan' => '2026-06-06',
            'total_harga' => 0,
            'jumlah_bayar' => 0,
            'berat' => 0,
            'status_pesanan' => 'Pending',
            'metode' => 'Antar Jemput',
            'layanan' => (object)['nama_layanan' => 'Reguler (2 hari)', 'jenis' => 'Kiloan']
        ],
        (object)[
            'id_pesanan' => 4,
            'tanggal_pesan' => '2026-06-05',
            'total_harga' => 0,
            'jumlah_bayar' => 0,
            'berat' => 0,
            'status_pesanan' => 'Pending',
            'metode' => 'Antar Jemput',
            'layanan' => (object)['nama_layanan' => 'Express (6 jam)', 'jenis' => 'Kiloan']
        ],
        (object)[
            'id_pesanan' => 3,
            'tanggal_pesan' => '2026-06-05',
            'total_harga' => 0,
            'jumlah_bayar' => 0,
            'berat' => 0,
            'status_pesanan' => 'Pending',
            'metode' => 'Antar Jemput',
            'layanan' => (object)['nama_layanan' => 'Reguler (2 hari)', 'jenis' => 'Kiloan']
        ],
        (object)[
            'id_pesanan' => 2,
            'tanggal_pesan' => '2026-06-04',
            'total_harga' => 0,
            'jumlah_bayar' => 0,
            'berat' => 0,
            'status_pesanan' => 'Pending',
            'metode' => 'Drop Off',
            'layanan' => (object)['nama_layanan' => 'Reguler (2 hari)', 'jenis' => 'Kiloan']
        ],
        (object)[
            'id_pesanan' => 1,
            'tanggal_pesan' => '2026-06-02',
            'total_harga' => 0,
            'jumlah_bayar' => 0,
            'berat' => 10,
            'status_pesanan' => 'Pending',
            'metode' => 'Antar Jemput',
            'layanan' => (object)['nama_layanan' => 'Reguler (2 hari)', 'jenis' => 'Kiloan']
        ],
    ]);
@endphp

<div class="max-w-6xl mx-auto my-8 space-y-10">

    {{-- HEADER SECTION --}}
    <div class="relative overflow-hidden bg-white/60 backdrop-blur-xl border border-white/60 rounded-[2.5rem] p-8 md:p-12 shadow-glass flex flex-col md:flex-row items-center justify-between gap-6 group isolate"
         data-aos="fade-down" data-aos-duration="800">
        
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-100/60 rounded-full blur-[80px] -mr-16 -mt-16 pointer-events-none -z-10"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-fresh-100/60 rounded-full blur-[60px] -ml-10 -mb-10 pointer-events-none -z-10"></div>
        
        <div class="relative z-10 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2 tracking-tight">Riwayat Transaksi</h1>
            <p class="text-slate-500 font-medium text-lg">Pantau status laundry dan pembayaran Anda.</p>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row gap-4 items-center">
            <div class="inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-white border border-slate-100 shadow-sm transition-all hover:scale-105 hover:shadow-md duration-300 cursor-default">
                <div class="w-10 h-10 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center text-xl">
                    <i class="ph-fill ph-receipt"></i>
                </div>
                <div class="text-left">
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Total Order</span>
                    <span class="block text-xl font-bold text-slate-800">8</span>
                </div>
            </div>

            <a href="/layanan" class="px-6 py-3 rounded-2xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700 transition-all flex items-center gap-2 shadow-lg shadow-brand-200 hover:-translate-y-1 active:scale-95">
                <i class="ph-bold ph-plus"></i> Pesan Baru
            </a>
        </div>
    </div>

    {{-- GRID LAYOUT PESANAN --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @forelse($pesanan as $p)

        @php
            $total       = $p->total_harga;
            $sudah_bayar = $p->jumlah_bayar ?? 0;
            $sisa        = $total - $sudah_bayar;
            
            $isLunas     = $sisa <= 0 && $total > 0;
            $isDP        = $sudah_bayar > 0 && !$isLunas; 
            $isGratis    = $total == 0 && $p->berat > 0;

            $name = strtolower($p->layanan->nama_layanan ?? '');
            $icon = 'ph-duotone ph-basket'; 
            $color = 'bg-brand-50 text-brand-600';

            if(str_contains($name, 'setrika')) { $icon = 'mdi mdi-iron-outline'; $color = 'bg-orange-50 text-orange-600'; } 
            elseif(str_contains($name, 'karpet')) { $icon = 'ph-duotone ph-rug'; $color = 'bg-red-50 text-red-600'; } 
            elseif(str_contains($name, 'sepatu') || str_contains($name, 'sneaker')) { $icon = 'ph-duotone ph-sneaker'; $color = 'bg-yellow-50 text-yellow-600'; } 
            elseif(str_contains($name, 'sprei') || str_contains($name, 'selimut')) { $icon = 'ph-duotone ph-bed'; $color = 'bg-purple-50 text-purple-600'; } 
            elseif(str_contains($name, 'boneka')) { $icon = 'ph-duotone ph-finn-the-human'; $color = 'bg-pink-50 text-pink-600'; } 
            elseif(str_contains($name, 'jas') || str_contains($name, 'jaket')) { $icon = 'ph-duotone ph-coat-hanger'; $color = 'bg-slate-50 text-slate-600'; } 
            elseif(str_contains($name, 'tas')) { $icon = 'ph-duotone ph-handbag'; $color = 'bg-amber-50 text-amber-600'; } 
            elseif(str_contains($name, 'reguler') || str_contains($name, 'kilat')) { $icon = 'ph-duotone ph-scales'; $color = 'bg-blue-50 text-blue-600'; } 
            elseif(str_contains($name, 'kemeja') || str_contains($name, 'pcs')) { $icon = 'ph-duotone ph-t-shirt'; $color = 'bg-emerald-50 text-emerald-600'; }
            
            // Override khusus untuk icon boks express laundry jika dibutuhkan
            if(str_contains($name, 'express')) { $icon = 'ph-duotone ph-archive'; $color = 'bg-blue-50 text-blue-600'; }
        @endphp

        {{-- CARD ITEM --}}
        <div class="group relative bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(59,130,246,0.15)] hover:border-brand-200 hover:-translate-y-2 transition-all duration-500 ease-out flex flex-col h-full"
             data-aos="fade-up"
             data-aos-delay="{{ ($loop->index % 4) * 150 }}">
            
            {{-- Bagian Atas --}}
            <div class="flex justify-between items-start mb-6 pb-4 border-b border-slate-50 group-hover:border-slate-100 transition-colors">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Order ID</span>
                    <span class="font-mono text-sm font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded-md group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                        #{{ str_pad($p->id_pesanan, 4, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                <div class="text-right">
                     <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Tanggal</span>
                     <span class="text-xs font-bold text-slate-600 flex items-center gap-1 justify-end">
                        <i class="ph-bold ph-calendar-blank text-brand-500 opacity-0 group-hover:opacity-100 transition-opacity -translate-x-2 group-hover:translate-x-0 duration-300"></i>
                        {{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('d M Y') }}
                     </span>
                </div>
            </div>

            {{-- Bagian Tengah --}}
            <div class="flex items-start gap-4 mb-6">
                <div class="w-12 h-12 rounded-2xl shrink-0 flex items-center justify-center text-2xl {{ $color }} group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 shadow-sm">
                    <i class="{{ $icon }}"></i>
                </div>
                
                <div>
                    <h3 class="font-bold text-slate-800 text-lg leading-tight mb-2 group-hover:text-brand-600 transition-colors duration-300">
                        {{ $p->layanan->nama_layanan }}
                    </h3>
                    
                    <div class="flex flex-wrap items-center gap-2 text-xs font-medium text-slate-500">
                        @if($p->status_pesanan == 'Dibatalkan')
                             <span class="bg-red-50 text-red-600 px-2 py-0.5 rounded border border-red-100 flex items-center gap-1">
                                <i class="ph-bold ph-x-circle"></i> Batal
                            </span>
                        @elseif($p->status_pesanan == 'Dikembalikan')
                             <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded border border-slate-200 flex items-center gap-1">
                                <i class="ph-bold ph-arrow-u-up-left"></i> Refunded
                            </span>
                        @elseif($p->berat == 0)
                            <span class="bg-amber-50 text-amber-600 px-2 py-0.5 rounded border border-amber-100 flex items-center gap-1">
                                <i class="ph-bold ph-scales"></i> Sedang Ditimbang
                            </span>
                        @else
                            <span class="bg-slate-50 px-2 py-0.5 rounded border border-slate-100 font-bold text-slate-700">
                                {{ $p->berat }} {{ $p->layanan->jenis == 'Kiloan' ? 'Kg' : 'Pcs' }}
                            </span>
                        @endif

                        <span class="bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
                            {{ $p->metode }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Bagian Status --}}
            <div class="mb-6 space-y-2">
                <div class="flex justify-between items-center text-sm group-hover:translate-x-1 transition-transform duration-300 ease-out">
                    <span class="text-slate-400 font-medium text-xs uppercase">Status</span>
                    
                    @if($p->status_pesanan == 'Pending')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold border border-slate-200 shadow-sm">
                            <i class="ph-bold ph-hourglass"></i> Menunggu Konfirmasi
                        </span>

                    @elseif($p->status_pesanan == 'Menunggu Pembayaran')
                        @if($isDP)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-50 text-orange-700 text-xs font-bold border border-orange-100 shadow-sm">
                                <i class="ph-fill ph-coins"></i> Kurang Bayar (DP)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-100 shadow-sm">
                                <span class="relative flex h-2 w-2 mr-0.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                                </span> Menunggu Bayar
                            </span>
                        @endif

                    @elseif($p->status_pesanan == 'Diproses')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-bold border border-brand-100 shadow-sm">
                             <i class="ph-bold ph-spinner animate-spin text-brand-500"></i> Diproses
                        </span>

                    @elseif($p->status_pesanan == 'Selesai')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100 shadow-sm">
                            <i class="ph-bold ph-check-circle text-emerald-500"></i> Selesai
                        </span>
                        
                    @elseif($p->status_pesanan == 'Dibatalkan')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-bold border border-red-100 shadow-sm">
                            <i class="ph-bold ph-x-circle text-red-500"></i> Dibatalkan
                        </span>
                    @elseif($p->status_pesanan == 'Dikembalikan')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold border border-slate-200 shadow-sm">
                            <i class="ph-bold ph-arrow-u-up-left"></i> Dikembalikan
                        </span>
                    @endif
                </div>
            </div>

            {{-- Bagian Bawah: Harga & Aksi --}}
            <div class="mt-auto pt-4 border-t border-dashed border-slate-200 flex flex-col gap-4 group-hover:border-brand-200 transition-colors">
                <div class="flex justify-between items-end">
                    
                    {{-- LABEL HARGA --}}
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                            {{ $isDP ? 'Sisa Tagihan' : 'Total Tagihan' }}
                        </span>
                        @if($isDP)
                            <span class="text-[10px] text-slate-400 font-medium">Total: Rp {{ number_format($total, 0, ',', '.') }}</span>
                        @endif
                    </div>

                    <div class="text-right">
                        @if($p->status_pesanan == 'Pending')
                             <span class="text-sm font-bold text-slate-400">Menunggu Admin</span>
                        
                        @elseif($p->status_pesanan == 'Dibatalkan' || $p->status_pesanan == 'Dikembalikan')
                             <span class="text-sm font-bold text-red-400 line-through">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        
                        @elseif($isGratis)
                             <span class="text-xl font-bold text-emerald-500 animate-pulse">GRATIS</span>
                        @else
                            <span class="text-xl font-bold {{ $isDP ? 'text-rose-600' : 'text-slate-800' }} group-hover:text-brand-600 transition-colors">
                                Rp {{ number_format($isDP ? $sisa : $total, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- LOGIKA TOMBOL AKSI UTAMA --}}
                {{-- ========================================== --}}

                @if($p->status_pesanan == 'Pending')
                    <div class="flex flex-col gap-2">
                        <div class="w-full py-2.5 text-center text-xs text-slate-500 font-medium bg-slate-50 rounded-xl border border-slate-200">
                            Menunggu konfirmasi laundry...
                        </div>
                        
                        <form id="form-batal-{{ $p->id_pesanan }}" action="/pesanan/cancel/{{ $p->id_pesanan }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="konfirmasiBatal({{ $p->id_pesanan }})" class="w-full py-2 rounded-xl text-red-500 font-bold text-xs hover:bg-red-50 transition-all border border-transparent hover:border-red-100 flex items-center justify-center gap-1 group/cancel">
                                <i class="ph-bold ph-trash group-hover/cancel:scale-110 transition-transform"></i> Batalkan Pesanan
                            </button>
                        </form>
                    </div>

                @elseif($total > 0 && $sisa > 0 && !in_array($p->status_pesanan, ['Dibatalkan', 'Dikembalikan']))
                    
                    {{-- TOMBOL TRIGGER MODAL STATIS --}}
                    <button type="button" onclick="bukaModalBayar('{{ str_pad($p->id_pesanan, 4, '0', STR_PAD_LEFT) }}', '{{ $p->layanan->nama_layanan }}', {{ $isDP ? $sisa : $total }})" 
                            class="w-full py-3 rounded-xl bg-slate-900 text-white font-bold text-sm shadow-lg shadow-slate-200 hover:bg-brand-600 hover:shadow-brand-300 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-2 relative overflow-hidden group/btn">
                        <span class="absolute inset-0 bg-white/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></span>
                        <i class="ph-bold ph-credit-card relative z-10"></i> 
                        <span class="relative z-10">
                            {{ $isDP ? 'Lunasi Sisa Tagihan' : 'Bayar Sekarang' }}
                        </span>
                    </button>

                @elseif($isLunas)
                    <div class="w-full py-2.5 text-center text-xs text-emerald-600 font-bold bg-emerald-50 rounded-xl border border-emerald-200 flex items-center justify-center gap-1">
                        <i class="ph-bold ph-check-circle"></i> Lunas
                    </div>
                    
                    @if($p->status_pesanan == 'Selesai')
                         <a href="/layanan" class="w-full py-2.5 rounded-xl border-2 border-slate-100 text-slate-600 font-bold text-sm hover:bg-slate-50 hover:border-slate-200 hover:text-slate-900 active:scale-95 transition-all text-center block">
                            Pesan Lagi
                        </a>
                    @endif

                @elseif($p->status_pesanan == 'Dibatalkan' || $p->status_pesanan == 'Dikembalikan')
                    <div class="w-full py-2.5 text-center text-xs text-slate-400 font-medium bg-slate-50 rounded-xl border border-slate-200">
                        Tidak ada tagihan aktif
                    </div>
                @endif
            </div>

        </div>
        
        @empty
        <div class="col-span-full py-24 text-center flex flex-col items-center justify-center bg-white/50 border-2 border-dashed border-slate-200 rounded-[2.5rem]"
             data-aos="zoom-in" data-aos-duration="600">
            <div class="w-24 h-24 rounded-full bg-slate-50 flex items-center justify-center mb-6 shadow-inner animate-[bounce_3s_ease-in-out_infinite]">
                <i class="ph-duotone ph-basket text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Pesanan</h3>
            <p class="text-slate-500 max-w-xs mx-auto mb-8">Riwayat pesanan Anda akan muncul di sini.</p>
            <a href="/layanan" class="px-8 py-3 rounded-xl bg-brand-600 text-white font-bold hover:bg-brand-700 hover:scale-105 active:scale-95 transition-all shadow-lg">
                <i class="ph-bold ph-plus"></i> Buat Pesanan Baru
            </a>
        </div>
        @endforelse

    </div>

    </div>
</div>

{{-- MODAL PEMBAYARAN STATIS (UI/UX FOCUS) --}}
<div id="payment-modal" class="fixed inset-0 z-[99999] hidden opacity-0 transition-opacity duration-300">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="tutupModalBayar()"></div>

    {{-- Content --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-[2.5rem] shadow-[0_20px_60px_-15px_rgba(0,0,0,0.3)] overflow-hidden flex flex-col scale-95 transition-transform duration-300" id="payment-modal-content">
        
        {{-- Header Modal --}}
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                <i class="ph-fill ph-wallet text-brand-600"></i> Checkout Pembayaran
            </h3>
            <button type="button" onclick="tutupModalBayar()" class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center hover:bg-red-100 hover:text-red-500 transition-colors">
                <i class="ph-bold ph-x"></i>
            </button>
        </div>

        {{-- Body Modal --}}
        <div class="p-6 overflow-y-auto max-h-[70vh]">
            {{-- Info Ringkasan --}}
            <div class="bg-brand-50 rounded-[1.5rem] p-5 mb-6 border border-brand-100 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-brand-200/50 rounded-full blur-2xl"></div>
                <p class="text-xs text-brand-600 font-bold uppercase tracking-wider mb-1 relative z-10">Total Tagihan</p>
                <h2 class="text-3xl font-bold text-slate-800 mb-3 relative z-10" id="modal-total-tagihan">Rp 0</h2>
                
                <div class="flex justify-between items-center text-sm font-medium text-slate-600 border-t border-brand-200/50 pt-3 relative z-10">
                    <div class="flex items-center gap-1.5">
                        <i class="ph-duotone ph-basket"></i>
                        <span id="modal-nama-layanan">Layanan</span>
                    </div>
                    <span class="text-slate-400 font-mono bg-white/60 px-2 py-0.5 rounded-md" id="modal-order-id">#000</span>
                </div>
            </div>

            <h4 class="font-bold text-slate-700 mb-4 text-sm uppercase tracking-wide">Pilih Metode Pembayaran</h4>
            
            {{-- List Metode Pembayaran --}}
            <div class="space-y-3">
                
                {{-- Opsi QRIS --}}
                <label class="flex items-center justify-between p-4 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-brand-200 transition-colors has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50/50 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner group-has-[:checked]:bg-brand-600 group-has-[:checked]:text-white transition-colors">
                            <i class="ph-duotone ph-qr-code text-2xl"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-800 text-base group-has-[:checked]:text-brand-700 transition-colors">QRIS Instan</span>
                            <span class="block text-xs text-slate-500">Gopay, OVO, Dana, ShopeePay</span>
                        </div>
                    </div>
                    <input type="radio" name="payment_method" value="QRIS" class="w-5 h-5 text-brand-600 border-slate-300 focus:ring-brand-500" checked>
                </label>

                {{-- Opsi Bank Transfer BCA --}}
                <label class="flex items-center justify-between p-4 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-brand-200 transition-colors has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50/50 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner group-has-[:checked]:bg-brand-600 group-has-[:checked]:text-white transition-colors">
                            <i class="ph-duotone ph-bank text-2xl"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-800 text-base group-has-[:checked]:text-brand-700 transition-colors">Virtual Account BCA</span>
                            <span class="block text-xs text-slate-500">Cek otomatis 24 jam</span>
                        </div>
                    </div>
                    <input type="radio" name="payment_method" value="Virtual Account BCA" class="w-5 h-5 text-brand-600 border-slate-300 focus:ring-brand-500">
                </label>

                {{-- Opsi Bank Transfer Mandiri --}}
                <label class="flex items-center justify-between p-4 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-brand-200 transition-colors has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50/50 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center shadow-inner group-has-[:checked]:bg-brand-600 group-has-[:checked]:text-white transition-colors">
                            <i class="ph-duotone ph-buildings text-2xl"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-800 text-base group-has-[:checked]:text-brand-700 transition-colors">Virtual Account Mandiri</span>
                            <span class="block text-xs text-slate-500">Cek otomatis 24 jam</span>
                        </div>
                    </div>
                    <input type="radio" name="payment_method" value="Virtual Account Mandiri" class="w-5 h-5 text-brand-600 border-slate-300 focus:ring-brand-500">
                </label>

            </div>
        </div>

        {{-- Footer Modal --}}
        <div class="p-6 border-t border-slate-100 bg-white">
            <button type="button" onclick="prosesBayarStatik()" class="w-full py-4 rounded-xl bg-brand-600 text-white font-bold text-base shadow-[0_8px_20px_-6px_rgba(37,99,235,0.5)] hover:bg-brand-700 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-2 group">
                <i class="ph-bold ph-shield-check group-hover:scale-110 transition-transform"></i> Bayar Sekarang
            </button>
        </div>
    </div>
</div>

{{-- SCRIPT JAVASCRIPT --}}
<script type="text/javascript">
    
    // Fungsi Format Rupiah
    const formatRupiah = (angka) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    };

    // Fungsi Buka Modal Pembayaran (Statis)
    function bukaModalBayar(id, layanan, nominal) {
        document.getElementById('modal-order-id').innerText = '#' + id;
        document.getElementById('modal-nama-layanan').innerText = layanan;
        document.getElementById('modal-total-tagihan').innerText = formatRupiah(nominal);

        const modal = document.getElementById('payment-modal');
        const modalContent = document.getElementById('payment-modal-content');
        
        modal.classList.remove('hidden');
        
        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        });

        document.body.style.overflow = 'hidden';
    }

    // Fungsi Tutup Modal Pembayaran
    function tutupModalBayar() {
        const modal = document.getElementById('payment-modal');
        const modalContent = document.getElementById('payment-modal-content');
        
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    // Fungsi Simulasi Proses Bayar Statis menggunakan SweetAlert2
    function prosesBayarStatik() {
        const metodeDipilih = document.querySelector('input[name="payment_method"]:checked').value;
        
        tutupModalBayar();
        
        Swal.fire({
            html: `
                <div class="flex flex-col items-center justify-center pt-4">
                    <div class="w-12 h-12 rounded-full border-4 border-slate-200 border-t-brand-600 animate-spin mb-4"></div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Memproses Pembayaran...</h3>
                    <p class="text-xs text-slate-500">Menyambungkan ke ${metodeDipilih}</p>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false,
            background: '#ffffff',
            customClass: { popup: 'rounded-[2.5rem] border border-slate-100 shadow-2xl p-6 overflow-hidden' },
            timer: 1500
        }).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil!',
                text: `Simulasi pembayaran dengan ${metodeDipilih} berhasil. (Fokus UI/UX)`,
                confirmButtonColor: '#2563eb',
                customClass: {
                    popup: 'rounded-[2rem] border border-slate-100 shadow-xl',
                    confirmButton: 'rounded-xl px-8 py-3 font-bold shadow-md'
                }
            });
        });
    }

    // Fungsi Simulasi Batal Statis (Tanpa Submit form backend)
    function konfirmasiBatalStatik(idPesanan) {
        Swal.fire({
            title: 'Batalkan Pesanan?',
            text: `Apakah Anda yakin ingin membatalkan pesanan #${idPesanan} ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', 
            cancelButtonColor: '#64748b', 
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-[2rem] border border-slate-100 shadow-xl',
                confirmButton: 'rounded-xl px-6 py-2.5 font-bold shadow-md',
                cancelButton: 'rounded-xl px-6 py-2.5 font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pesanan Dibatalkan',
                    text: 'Simulasi pembatalan pesanan berhasil diproses.',
                    confirmButtonColor: '#2563eb',
                    customClass: {
                        popup: 'rounded-[2rem] border border-slate-100 shadow-xl'
                    }
                });
            }
        });
    }
</script>

@endsection