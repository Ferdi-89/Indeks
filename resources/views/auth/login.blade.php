<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - R-NET Admin</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('/backgroundherolightmode.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        [data-theme="dark"] body {
            background-image: url('/backgroundherodarkmode.webp');
        }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        [data-theme="dark"] .glass-panel {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 antialiased text-base-content relative">
    
    <!-- Theme Toggle -->
    <div class="absolute top-6 right-6">
        <label class="btn btn-circle btn-ghost glass-panel swap swap-rotate" title="Ganti tema">
            <input type="checkbox" id="theme-checkbox" />
            <svg class="swap-off h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>
            <svg class="swap-on h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>
        </label>
    </div>

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <a href="/">
                <img src="/logobasewhite.svg" alt="R-NET" class="h-16 w-auto hidden dark:block">
                <img src="/logobaseblack.svg" alt="R-NET" class="h-16 w-auto block dark:hidden">
            </a>
        </div>
        
        <!-- Login Card -->
        <div class="glass-panel rounded-3xl p-8 sm:p-10 w-full animate-fade-in-up">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold mb-2 text-base-content">Welcome Back</h1>
                <p class="text-base-content/60 text-sm font-medium">Masuk ke dashboard admin R-NET</p>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-error mb-6 rounded-2xl text-sm shadow-sm py-3 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div class="form-control w-full">
                    <label class="label pb-1.5">
                        <span class="label-text font-semibold text-base-content/80">Email Address</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-base-content/40">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="input w-full pl-11 bg-base-100/50 focus:bg-base-100 border-base-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300 rounded-2xl h-12" 
                            placeholder="admin@rnet.com" />
                    </div>
                </div>

                <div class="form-control w-full">
                    <label class="label pb-1.5">
                        <span class="label-text font-semibold text-base-content/80">Password</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-base-content/40">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password" required 
                            class="input w-full pl-11 bg-base-100/50 focus:bg-base-100 border-base-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300 rounded-2xl h-12" 
                            placeholder="••••••••" />
                    </div>
                </div>

                <div class="flex items-center justify-between mt-2">
                    <label class="flex items-center cursor-pointer gap-2 group">
                        <input type="checkbox" name="remember" class="checkbox checkbox-sm checkbox-primary border-base-300 group-hover:border-primary transition-colors rounded-md" />
                        <span class="label-text text-sm font-medium text-base-content/70">Ingat Saya</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-primary w-full rounded-2xl h-12 font-bold text-base shadow-lg shadow-primary/30 hover:shadow-primary/50 transition-all duration-300 border-none">
                        Login ke Dashboard
                        <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                    </button>
                </div>
            </form>
            
            <div class="mt-8 text-center">
                <a href="/" class="text-sm font-medium text-base-content/50 hover:text-primary transition-colors inline-flex items-center gap-1.5">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script>
        // Init Lucide Icons
        lucide.createIcons();

        // Theme Toggle Logic
        const html = document.documentElement;
        const checkbox = document.getElementById('theme-checkbox');
        const THEME_KEY = 'rnet-theme';

        const savedTheme = localStorage.getItem(THEME_KEY) || 'light';
        html.setAttribute('data-theme', savedTheme);
        checkbox.checked = savedTheme === 'dark';

        checkbox.addEventListener('change', () => {
            const t = checkbox.checked ? 'dark' : 'light';
            html.setAttribute('data-theme', t);
            localStorage.setItem(THEME_KEY, t);
        });
    </script>
    
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</body>
</html>
