@extends('layouts.main')
@section('title', 'Login Member - Ni Laundry')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    
    {{-- Kartu Utama Login --}}
    <div class="w-full max-w-5xl bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-glass border border-white/50 overflow-hidden grid lg:grid-cols-2 p-2"
         data-aos="fade-up" 
         data-aos-duration="800"
         data-aos-easing="ease-out-expo">
        
        {{-- BAGIAN KIRI: GAMBAR (Hanya Tampil di Desktop) --}}
        <div class="hidden lg:block relative rounded-[2rem] overflow-hidden group">
            <img src="https://images.unsplash.com/photo-1582735689369-4fe89db7114c?q=80&w=2070&auto=format&fit=crop"
                 alt="Fresh Laundry" 
                 class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-100 transition-transform duration-1000 group-hover:scale-105">
            
            <div class="absolute inset-0 bg-gradient-to-t from-brand-900/60 to-transparent"></div>
            
            <div class="relative z-10 h-full flex flex-col justify-end p-10 text-white">
                <h2 class="text-3xl font-bold leading-tight mb-3" data-aos="fade-right" data-aos-delay="300">
                    Fresh Clothes,<br>Fresh Mind.
                </h2>
                <p class="text-white/90 text-sm font-medium leading-relaxed max-w-xs" data-aos="fade-right" data-aos-delay="400">
                    Masuk kembali untuk mengatur jadwal pencucian Anda. Bersih, wangi, dan rapi dalam satu aplikasi.
                </p>
            </div>
        </div>

        {{-- BAGIAN KANAN: FORM LOGIN --}}
        <div class="p-6 sm:p-8 md:p-12 flex flex-col justify-center">
            
            {{-- HEADER --}}
            <div class="mb-6" data-aos="fade-down" data-aos-delay="200">
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Selamat Datang!</h1>
                <p class="text-slate-500 font-medium text-sm">Masuk untuk Memesan Laundry Kamu</p>
            </div>

            {{-- ERROR HANDLING PHP (Bawaan Laravel) --}}
            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 text-sm font-medium flex items-center gap-2"
                     data-aos="zoom-in">
                    <i class="ph-bold ph-warning-circle text-lg"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- ERROR HANDLING JAVASCRIPT (Khusus untuk prototype) --}}
            <div id="js-error" class="hidden mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 text-sm font-medium items-center gap-2 transition-all">
                <i class="ph-bold ph-warning-circle text-lg"></i>
                <span>Username atau password salah!</span>
            </div>

            {{-- FORM UTAMA --}}
            {{-- Action dihapus sementara agar tidak lari ke backend --}}
            <form id="loginForm" class="space-y-4" x-data="{ showPassword: false }">
                @csrf
                
                {{-- INPUT USERNAME / NO HP --}}
                <div class="space-y-1.5" data-aos="fade-up" data-aos-delay="300">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">
                        Username / Nomor HP
                    </label>
                    <div class="relative group">
                        <input type="text" name="nama" required autofocus 
                            id="username" 
                            autocomplete="username" 
                            placeholder="Nama Akun atau 0812xxxx"
                            class="input-focus-effect w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 outline-none transition-all placeholder:text-slate-400 font-normal group-hover:border-slate-200">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                            <i class="ph-bold ph-user text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- INPUT PASSWORD --}}
                <div class="space-y-1.5" data-aos="fade-up" data-aos-delay="400">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Password</label>
                    </div>
                    <div class="relative group">
                        
                        <!-- PERUBAHAN 1: Ganti :type menjadi type="password" -->
                        <input type="password" name="password" required 
                            id="password" 
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="input-focus-effect w-full bg-slate-50 border-2 border-slate-100 text-slate-900 text-sm rounded-2xl focus:bg-white focus:border-brand-500 block p-4 pl-12 pr-12 outline-none transition-all placeholder:text-slate-400 font-normal group-hover:border-slate-200">
                        
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-slate-400 group-focus-within:text-brand-500 transition-colors">
                            <i class="ph-bold ph-lock-key text-xl"></i>
                        </div>

                        <!-- PERUBAHAN 2: Ganti @click menjadi onclick murni HTML -->
                        <button type="button" onclick="togglePassword()" 
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer outline-none">
                            <i id="eyeIcon" class="ph-bold ph-eye text-xl"></i>
                        </button>
                    </div>
                </div>

                {{-- CHECKBOX REMEMBER ME --}}
                <div class="flex items-center gap-2 ml-1" data-aos="fade-up" data-aos-delay="450">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500 cursor-pointer">
                    <label for="remember" class="text-sm text-slate-500 font-medium cursor-pointer select-none">Ingat Saya</label>
                </div>

                {{-- TOMBOL SUBMIT --}}
                <button type="submit" id="btn-submit" 
                        class="w-full py-4 px-6 rounded-2xl bg-brand-600 text-white font-bold text-sm shadow-lg shadow-brand-200 hover:shadow-glow hover:-translate-y-1 hover:bg-brand-700 transition-all duration-300 flex items-center justify-center gap-2"
                        data-aos="fade-up" data-aos-delay="500">
                    <span>Masuk Sekarang</span>
                    <i class="ph-bold ph-arrow-right"></i>
                </button>
            </form>

            {{-- DIVIDER "ATAU" --}}
            <div class="relative flex py-4 items-center" data-aos="fade-up" data-aos-delay="550">
                <div class="flex-grow border-t border-slate-200"></div>
                <span class="flex-shrink-0 mx-4 text-slate-400 text-[10px] font-bold uppercase tracking-widest">Atau Login Dengan</span>
                <div class="flex-grow border-t border-slate-200"></div>
            </div>

            {{-- TOMBOL LOGIN GOOGLE --}}
            <div data-aos="fade-up" data-aos-delay="600">
                <a href="{{ route('google.login') }}" 
                   class="flex items-center justify-center gap-3 w-full py-4 px-4 bg-white border-2 border-slate-200 rounded-2xl text-slate-700 font-bold text-sm shadow-sm hover:bg-slate-50 hover:border-slate-300 hover:shadow-md transition-all duration-300 group cursor-pointer">
                    
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    
                    <span>Masuk dengan Google</span>
                </a>
            </div>

            {{-- FOOTER KARTU --}}
            <div class="mt-8 text-center" data-aos="fade-in" data-aos-delay="700">
                <p class="text-sm font-medium text-slate-500">
                    Belum punya akun? 
                    <a href="/register" class="font-bold text-brand-600 hover:text-brand-700 underline decoration-2 underline-offset-4 decoration-brand-200 hover:decoration-brand-500 transition-all">
                        Daftar Gratis
                    </a>
                </p>
            </div>

        </div>
    </div>
</div>

{{-- LOGIKA JAVASCRIPT UNTUK LOGIN TANPA DATABASE --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loginForm = document.getElementById('loginForm');
        const jsErrorDiv = document.getElementById('js-error');
        
        if(loginForm) {
            loginForm.addEventListener('submit', function(e) {
                // 1. Hentikan form agar tidak me-refresh halaman atau lari ke backend
                e.preventDefault(); 
                
                // 2. Ambil nilai dari input username dan password
                const usernameVal = document.getElementById('username').value;
                const passwordVal = document.getElementById('password').value;
                
                // 3. Cek kondisi hardcode (zeino & zeino)
                if (usernameVal === 'zeino' && passwordVal === 'zeino') {
                    
                    // Sembunyikan error jika sebelumnya muncul
                    jsErrorDiv.classList.add('hidden');
                    jsErrorDiv.classList.remove('flex');
                    
                    // Alert sederhana (bisa diganti SweetAlert jika ada)
                    alert('Berhasil Login! Selamat datang, Zeino.');
                    
                    // 4. Redirect ke halaman beranda / dashboard 
                    // Silakan sesuaikan URL '/dashboard' dengan rute yang Anda miliki
                    window.location.href = '{{ route('user.dashboard') }}'; 
                    
                } else {
                    // Munculkan pesan error
                    jsErrorDiv.classList.remove('hidden');
                    jsErrorDiv.classList.add('flex');
                }
            });
        }
    });
</script>
@endsection