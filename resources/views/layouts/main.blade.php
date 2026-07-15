<!DOCTYPE html>
<html lang="id" class="scroll-smooth"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    
    {{-- Preload JS utama --}}
    <link rel="modulepreload" href="{{ Vite::asset('resources/js/app.js') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', 'Ni Laundry')</title>

    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://unpkg.com">

    <style> 
        [x-cloak] { display: none !important; }
        .footer-texture {
            background-image: url("{{ asset('img/cubes.png') }}");
        }
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
            width: 100%;
            margin: 0;
            padding: 0;
        }
    </style>

    <meta name="description" content="Jasa laundry kiloan dan satuan terbaik dengan teknologi modern.">
    <meta name="theme-color" content="#0f172a">
    <link rel="icon" href="{{ asset('img/logo.webp') }}" type="image/webp">
</head>

<body class="text-slate-600 antialiased font-sans flex flex-col min-h-screen w-full relative selection:bg-brand-500 selection:text-white">

    @php
        // 1. Deteksi Status Login Admin (Session Manual maupun Auth Guard)
        $isAdmin = session()->has('admin_logged_in') || session()->has('admin_id') || (auth()->check() && auth()->user()->role === 'admin');

        // 2. Deteksi Status Login User (Laravel Auth maupun Custom Session)
        $isUser = auth()->check() || session()->has('user_logged_in') || session()->has('user_id') || session()->has('user');

        // 3. Ambil Nama User secara Aman (Anti-Crash jika kolomnya 'name' atau 'nama')
        $userName = 'zeino';
        if (auth()->check()) {
            $userName = auth()->user()->nama ?? auth()->user()->name ?? 'Member';
        } elseif (session()->has('user_nama')) {
            $userName = session('user_nama');
        } elseif (session()->has('user')) {
            $sessionUser = session('user');
            if (is_object($sessionUser)) {
                $userName = $sessionUser->nama ?? $sessionUser->name ?? 'Member';
            } elseif (is_array($sessionUser)) {
                $userName = $sessionUser['nama'] ?? $sessionUser['name'] ?? 'Member';
            } else {
                $userName = $sessionUser;
            }
        }

        // 4. Ambil Inisial Huruf Pertama untuk Avatar
        $userInitial = strtoupper(substr($userName, 0, 1));
    @endphp

    {{-- NAVBAR --}}
    <nav x-data="{ scrolled: false, mobileOpen: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         class="fixed top-0 w-full z-50 transition-all duration-300 left-0 right-0"
         :class="scrolled ? 'py-2' : 'py-3 md:py-6'">
        
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="rounded-2xl transition-all duration-300 border border-transparent"
                 :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm border-white/40 pl-4 pr-3 py-2' : 'bg-transparent'">
            
                <div class="flex justify-between items-center">
                    {{-- Logo Area --}}
                    <a href="/" class="flex items-center gap-2 md:gap-3 group shrink-0">
                        <img src="{{ asset('img/logo.webp') }}" 
                             alt="Logo Ni Laundry" 
                             width="40" height="40" 
                             class="h-8 w-8 md:h-10 md:w-10 object-contain">
                        <span class="text-lg md:text-2xl font-bold tracking-tight transition-colors"
                              :class="scrolled ? 'text-slate-800' : 'text-slate-900'">
                            Ni Laundry<span class="text-fresh-500">.</span>
                        </span>
                    </a>

                    {{-- Desktop Menu (Dinamis Berdasarkan Status Login) --}}
                    <div class="hidden md:flex items-center gap-1 bg-white/60 p-1.5 rounded-full border border-white/50 backdrop-blur-sm shadow-sm">
                        
                        @if($isAdmin)
                            {{-- MENU ADMIN --}}
                            <a href="/admin/dashboard" class="px-5 py-2 rounded-full text-sm font-semibold {{ request()->is('admin/dashboard') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Dashboard</a> 
                            <a href="/admin/pesanan" class="px-5 py-2 rounded-full text-sm font-semibold {{ request()->is('admin/pesanan') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Pesanan</a>
                            <a href="/admin/layanan" class="px-5 py-2 rounded-full text-sm font-semibold {{ request()->is('admin/layanan') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Layanan</a>
                            <a href="/admin/diskon" class="px-5 py-2 rounded-full text-sm font-semibold {{ request()->is('admin/diskon') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Diskon</a>
                            <a href="/admin/admin" class="px-5 py-2 rounded-full text-sm font-semibold {{ request()->is('admin/admin') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Admin</a>
                        
                        @elseif($isUser)
                            {{-- MENU USER LOGIN (Beranda, Layanan, Riwayat) --}}
                            <a href="/" class="px-5 py-2 rounded-full text-sm font-semibold {{ request()->is('/') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Beranda</a> 
                            <a href="/layanan" class="px-5 py-2 rounded-full text-sm font-semibold {{ request()->is('layanan') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Layanan</a>
                            <a href="/riwayat" class="px-5 py-2 rounded-full text-sm font-semibold {{ request()->is('riwayat') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Riwayat</a>
                        
                        @else
                            {{-- MENU GUEST / BELUM LOGIN (Hanya Beranda & Layanan) --}}
                            <a href="/" class="px-5 py-2 rounded-full text-sm font-semibold {{ request()->is('/') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Beranda</a> 
                            <a href="/layanan" class="px-5 py-2 rounded-full text-sm font-semibold {{ request()->is('layanan') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-brand-600' }}">Layanan</a>
                        @endif

                    </div>

                    {{-- Desktop Right (Dinamis: Profile / Login / Logout) --}}
                    <div class="hidden md:flex items-center gap-4">
                        @if($isAdmin)
                            {{-- ADMIN LOGGED IN --}}
                            <div class="flex items-center gap-3">
                                <div class="text-right">
                                    <div class="text-sm font-bold text-slate-800">Administrator</div>
                                    <div class="text-xs text-brand-600 font-medium">Portal Admin</div>
                                </div>
                                <form action="/admin/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm" title="Logout">
                                        <i class="ph-bold ph-sign-out text-lg"></i>
                                    </button>
                                </form>
                            </div>

                        @elseif($isUser)
                            {{-- USER LOGGED IN --}}
                            <div class="flex items-center gap-3">
                                <div class="text-right">
                                    <div class="text-sm font-bold text-slate-800">{{ $userName }}</div>
                                    <div class="text-xs text-slate-500 font-medium">Keluar</div>
                                </div>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm" title="Logout">
                                        <i class="ph-bold ph-sign-out text-lg"></i>
                                    </button>
                                </form>
                            </div>

                        @else
                            {{-- GUEST --}}
                            <a href="/login" class="px-6 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-brand-600 transition-all shadow-lg hover:shadow-brand-500/20">
                                Login
                            </a>
                        @endif
                    </div>

                    {{-- Mobile Toggle Button --}}
                    <button @click="mobileOpen = !mobileOpen" aria-label="Toggle Menu" class="md:hidden p-2 text-slate-800 hover:bg-slate-100 rounded-lg transition-colors">
                        <i class="ph-bold text-2xl" :class="mobileOpen ? 'ph-x' : 'ph-list'"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu Dropdown (Dinamis Berdasarkan Status Login) --}}
        <div x-show="mobileOpen" x-collapse x-cloak class="md:hidden absolute top-full left-0 w-full px-4 mt-2">
            <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-white/50 p-2 flex flex-col gap-1 ring-1 ring-black/5">
                
                @if($isAdmin)
                    {{-- MENU MOBILE ADMIN --}}
                    <a href="/admin/dashboard" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                        Dashboard Admin <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                    </a>
                    <a href="/admin/pesanan" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                        Kelola Pesanan <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                    </a>
                    <a href="/admin/layanan" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                        Layanan <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                    </a> 
                    <a href="/admin/diskon" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                        Diskon <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                    </a> 
                    <a href="/admin/admin" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                        Admin <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                    </a> 
                    <div class="h-px bg-slate-100 my-1 mx-2"></div>
                    <form action="/admin/logout" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full p-3 font-bold bg-rose-50 text-rose-600 text-center rounded-xl hover:bg-rose-500 hover:text-white transition-colors">Logout Admin</button>
                    </form>

                @elseif($isUser)
                    {{-- MENU MOBILE USER LOGGED IN (Beranda, Layanan, Riwayat) --}}
                    <div class="p-3 mb-2 flex items-center gap-3 bg-slate-50 rounded-xl">
                        <div class="w-10 h-10 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold">
                            {{ $userInitial }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-800">{{ $userName }}</div>
                            <div class="text-xs text-slate-500">Member Aktif</div>
                        </div>
                    </div>
                    <a href="/" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                        Beranda <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                    </a>
                    <a href="/layanan" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                        Layanan <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                    </a>
                    <a href="/riwayat" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                        Riwayat <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                    </a> 
                    <div class="h-px bg-slate-100 my-1 mx-2"></div>
                    <form action="/logout" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full p-3 font-bold bg-rose-50 text-rose-600 text-center rounded-xl hover:bg-rose-500 hover:text-white transition-colors">Logout</button>
                    </form>

                @else
                    {{-- MENU MOBILE GUEST / BELUM LOGIN (Hanya Beranda & Layanan) --}}
                    <a href="/" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                        Beranda <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                    </a>
                    <a href="/layanan" class="p-3 rounded-xl hover:bg-slate-50 font-medium text-slate-700 flex items-center justify-between group">
                        Layanan <i class="ph-bold ph-caret-right text-slate-400 group-hover:text-brand-500"></i>
                    </a>
                    <div class="h-px bg-slate-100 my-1 mx-2"></div>
                    <a href="/login" class="p-3 font-bold bg-slate-900 text-white text-center rounded-xl hover:bg-slate-800 transition-colors shadow-lg">Login Member</a>
                @endif

            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="flex-grow pt-24 md:pt-32 pb-8 md:pb-12 px-4 md:px-8 max-w-7xl mx-auto w-full z-10">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-slate-900 text-white mt-12 md:mt-20 pt-12 md:pt-20 pb-10 rounded-t-[2rem] md:rounded-t-[3rem] relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 footer-texture pointer-events-none"></div>
        <div class="absolute -top-24 -left-24 w-[80vw] md:w-96 h-[80vw] md:h-96 bg-brand-500/20 rounded-full blur-[60px] md:blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[60vw] md:w-96 h-[60vw] md:h-96 bg-fresh-500/10 rounded-full blur-[60px] md:blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 md:px-8 relative z-10 footer-safe-area">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 md:gap-12 mb-12 md:mb-16">
               
                {{-- Brand Column --}}
                <div class="lg:col-span-4 space-y-6">
                    <a href="#" class="flex items-center gap-2 group w-fit">
                        <img src="{{ asset('img/logo.webp') }}" alt="Ni Laundry" class="h-8 md:h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                        <span class="text-xl md:text-2xl font-bold tracking-tight">
                            Ni Laundry<span class="text-fresh-400">.</span>
                        </span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Layanan laundry dengan teknologi modern. Kami merawat pakaian Anda dengan standar kebersihan internasional dan pelayanan sepenuh hati.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" target="_blank" aria-label="Instagram" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-all"><i class="ph-fill ph-instagram-logo text-lg"></i></a>
                        <a href="#" target="_blank" aria-label="Facebook" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-all"><i class="ph-fill ph-facebook-logo text-lg"></i></a>
                        <a href="#" target="_blank" aria-label="WhatsApp" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white hover:border-brand-600 transition-all"><i class="ph-fill ph-whatsapp-logo text-lg"></i></a>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-4 md:space-y-6">
                    <h3 class="font-bold text-lg">Layanan</h3>
                    <ul class="space-y-3 md:space-y-4 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-brand-400 transition-colors flex items-center gap-2 group"><i class="ph-bold ph-caret-right opacity-0 group-hover:opacity-100 transition-opacity -ml-4 group-hover:ml-0"></i> Cuci Kiloan</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition-colors flex items-center gap-2 group"><i class="ph-bold ph-caret-right opacity-0 group-hover:opacity-100 transition-opacity -ml-4 group-hover:ml-0"></i> Cuci Satuan</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition-colors flex items-center gap-2 group"><i class="ph-bold ph-caret-right opacity-0 group-hover:opacity-100 transition-opacity -ml-4 group-hover:ml-0"></i> Cuci Khusus</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-2 space-y-4 md:space-y-6">
                    <h3 class="font-bold text-lg">Perusahaan</h3>
                    <ul class="space-y-3 md:space-y-4 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="#" target="_blank" class="hover:text-brand-400 transition-colors flex items-center gap-2 group">Lokasi Outlet <i class="ph-bold ph-arrow-square-out opacity-0 group-hover:opacity-100 transition-opacity text-xs"></i></a></li>
                        <li><a href="#" target="_blank" class="hover:text-brand-400 transition-colors flex items-center gap-2 group">Kontak Kami <i class="ph-bold ph-arrow-square-out opacity-0 group-hover:opacity-100 transition-opacity text-xs"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>© 2025 Ni Laundry. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- SCRIPTS --}}
    <script defer src="https://unpkg.com/@phosphor-icons/web"></script>
</body>
</html>