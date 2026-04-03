<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R-NET — Internet Nirkabel Terpercaya di Koto Baru</title>
    <meta name="description" content="R-NET menyediakan layanan internet WiFi cepat untuk rumah tangga dan usaha kecil di Kecamatan Koto Baru, Kota Sungai Penuh.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --accent: #6366f1;
            --accent-light: #818cf8;
            --dark: #0f172a;
            --dark-2: #1e293b;
            --dark-3: #334155;
            --text: #e2e8f0;
            --text-muted: #94a3b8;
            --border: rgba(255,255,255,0.08);
            --card-bg: rgba(255,255,255,0.04);
            --glass: rgba(255,255,255,0.06);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 2.5rem;
            background: rgba(15,23,42,0.8);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            transition: all 0.3s ease;
        }
        .nav-logo { display: flex; align-items: center; gap: .6rem; text-decoration: none; }
        .nav-logo .logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: 1rem;
        }
        .nav-logo span { font-size: 1.4rem; font-weight: 800; color: #fff; letter-spacing: -.5px; }
        .nav-links { display: flex; align-items: center; gap: 2rem; list-style: none; }
        .nav-links a { color: var(--text-muted); text-decoration: none; font-size: .9rem; font-weight: 500; transition: color .2s; }
        .nav-links a:hover { color: #fff; }
        .nav-cta {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; text-decoration: none; padding: .55rem 1.4rem;
            border-radius: 8px; font-size: .9rem; font-weight: 600;
            transition: opacity .2s, transform .2s;
        }
        .nav-cta:hover { opacity: .9; transform: translateY(-1px); }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            text-align: center;
            padding: 8rem 2rem 6rem;
            position: relative;
            overflow: hidden;
        }
        .hero-bg {
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 80% 60% at 50% 20%, rgba(14,165,233,0.15), transparent),
                        radial-gradient(ellipse 50% 40% at 80% 80%, rgba(99,102,241,0.12), transparent);
        }
        .hero-grid {
            position: absolute; inset: 0;
            background-image: linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .hero-content { position: relative; max-width: 860px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(14,165,233,.12); border: 1px solid rgba(14,165,233,.3);
            color: var(--primary); padding: .4rem 1rem; border-radius: 50px;
            font-size: .8rem; font-weight: 600; letter-spacing: .05em;
            margin-bottom: 1.5rem;
            animation: fadeInDown .6s both;
        }
        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 900; line-height: 1.05; letter-spacing: -2px;
            margin-bottom: 1.5rem;
            animation: fadeInUp .6s .1s both;
        }
        .hero h1 .gradient-text {
            background: linear-gradient(135deg, var(--primary), var(--accent-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero p {
            font-size: 1.15rem; color: var(--text-muted); max-width: 600px;
            margin: 0 auto 2.5rem; line-height: 1.7;
            animation: fadeInUp .6s .2s both;
        }
        .hero-actions {
            display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;
            animation: fadeInUp .6s .3s both;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; text-decoration: none; padding: .85rem 2.2rem;
            border-radius: 10px; font-size: 1rem; font-weight: 600;
            display: inline-flex; align-items: center; gap: .5rem;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 20px rgba(14,165,233,.35);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(14,165,233,.45); }
        .btn-outline {
            border: 1px solid var(--border); color: var(--text); text-decoration: none;
            padding: .85rem 2.2rem; border-radius: 10px; font-size: 1rem; font-weight: 600;
            transition: border-color .2s, background .2s;
            display: inline-flex; align-items: center; gap: .5rem;
        }
        .btn-outline:hover { border-color: var(--primary); background: rgba(14,165,233,.07); }
        .hero-stats {
            display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap;
            margin-top: 4rem;
            animation: fadeInUp .6s .4s both;
        }
        .stat-item { text-align: center; }
        .stat-num { font-size: 2rem; font-weight: 800; color: #fff; }
        .stat-num .stat-unit { font-size: 1.2rem; color: var(--primary); }
        .stat-label { font-size: .8rem; color: var(--text-muted); margin-top: .25rem; }

        /* ===== SECTION COMMON ===== */
        section { padding: 6rem 2rem; }
        .container { max-width: 1200px; margin: 0 auto; }
        .section-title { text-align: center; margin-bottom: 3.5rem; }
        .section-title .tag {
            display: inline-block;
            color: var(--primary); font-size: .8rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase; margin-bottom: .75rem;
        }
        .section-title h2 {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800; letter-spacing: -1px; color: #fff;
        }
        .section-title p { color: var(--text-muted); margin-top: .75rem; font-size: 1rem; }

        /* ===== FEATURES ===== */
        #fitur { background: linear-gradient(180deg, var(--dark) 0%, var(--dark-2) 100%); }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; }
        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px; padding: 2rem;
            transition: border-color .3s, transform .3s;
        }
        .feature-card:hover { border-color: rgba(14,165,233,.4); transform: translateY(-4px); }
        .feature-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, rgba(14,165,233,.2), rgba(99,102,241,.2));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; color: var(--primary); margin-bottom: 1.25rem;
        }
        .feature-card h3 { font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: .5rem; }
        .feature-card p { font-size: .9rem; color: var(--text-muted); line-height: 1.6; }

        /* ===== PAKET ===== */
        #paket { background: var(--dark); }
        .paket-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
        .paket-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px; padding: 2.5rem 2rem;
            position: relative; overflow: hidden;
            transition: transform .3s, border-color .3s, box-shadow .3s;
        }
        .paket-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,.4); }
        .paket-card.featured {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(14,165,233,.08), rgba(99,102,241,.05));
            box-shadow: 0 0 40px rgba(14,165,233,.15);
        }
        .paket-featured-badge {
            position: absolute; top: 1.2rem; right: -2rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; font-size: .7rem; font-weight: 700;
            padding: .3rem 2.5rem; transform: rotate(45deg);
        }
        .paket-card .paket-name { font-size: .85rem; font-weight: 600; color: var(--primary); text-transform: uppercase; letter-spacing: .05em; margin-bottom: .5rem; }
        .paket-card .paket-speed { font-size: 3.5rem; font-weight: 900; color: #fff; line-height: 1; }
        .paket-card .paket-speed span { font-size: 1.2rem; color: var(--text-muted); font-weight: 400; }
        .paket-card .paket-price { margin-top: .75rem; margin-bottom: 1.5rem; }
        .paket-price .original { font-size: .9rem; color: var(--text-muted); text-decoration: line-through; }
        .paket-price .current { font-size: 1.6rem; font-weight: 800; color: #fff; }
        .paket-price .current small { font-size: .9rem; font-weight: 400; color: var(--text-muted); }
        .paket-price .promo-badge {
            display: inline-flex; align-items: center; gap: .25rem;
            background: rgba(239,68,68,.15); color: #f87171;
            font-size: .75rem; font-weight: 700; padding: .25rem .6rem;
            border-radius: 6px; margin-left: .5rem;
        }
        .paket-features { list-style: none; margin-bottom: 2rem; }
        .paket-features li {
            display: flex; align-items: center; gap: .6rem;
            font-size: .9rem; color: var(--text-muted); padding: .4rem 0;
            border-bottom: 1px solid var(--border);
        }
        .paket-features li:last-child { border-bottom: none; }
        .paket-features li .fa-check-circle { color: var(--success); }
        .btn-paket {
            display: block; text-align: center; text-decoration: none;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; padding: .85rem; border-radius: 10px;
            font-weight: 700; font-size: .95rem;
            transition: opacity .2s, transform .2s;
        }
        .btn-paket:hover { opacity: .9; transform: translateY(-1px); }
        .btn-paket.outline {
            background: transparent;
            border: 1px solid var(--primary); color: var(--primary);
        }
        .btn-paket.outline:hover { background: rgba(14,165,233,.1); }

        /* ===== PROMO BANNER ===== */
        .promo-banner {
            background: linear-gradient(135deg, rgba(14,165,233,.12), rgba(99,102,241,.1));
            border: 1px solid rgba(14,165,233,.3);
            border-radius: 20px; padding: 2rem 2.5rem;
            display: flex; align-items: center; gap: 2rem;
            margin-bottom: 3rem; flex-wrap: wrap;
        }
        .promo-banner .promo-icon { font-size: 2.5rem; color: var(--warning); }
        .promo-banner-content { flex: 1; min-width: 200px; }
        .promo-banner-content h3 { font-size: 1.2rem; font-weight: 800; color: #fff; margin-bottom: .25rem; }
        .promo-banner-content p { color: var(--text-muted); font-size: .9rem; }
        .promo-value {
            font-size: 2.5rem; font-weight: 900;
            background: linear-gradient(135deg, var(--warning), #f97316);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        /* ===== MESSAGES ===== */
        .messages-section { background: var(--dark-2); border-radius: 20px; padding: 2rem; margin-top: 4rem; }
        .message-item {
            background: var(--card-bg); border: 1px solid var(--border);
            border-radius: 12px; padding: 1.25rem 1.5rem; margin-bottom: 1rem;
            display: flex; align-items: flex-start; gap: 1rem;
        }
        .message-icon { width: 36px; height: 36px; border-radius: 8px; background: rgba(14,165,233,.15); display: flex; align-items: center; justify-content: center; color: var(--primary); flex-shrink: 0; }
        .message-content p { font-size: .9rem; color: var(--text-muted); }
        .message-tema { font-size: .75rem; color: var(--primary); font-weight: 600; margin-bottom: .25rem; }

        /* ===== ABOUT ===== */
        #tentang { background: var(--dark-2); }
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
        .about-content h2 { font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; color: #fff; margin-bottom: 1.25rem; }
        .about-content p { color: var(--text-muted); line-height: 1.8; margin-bottom: 1rem; }
        .about-img {
            background: linear-gradient(135deg, rgba(14,165,233,.2), rgba(99,102,241,.2));
            border: 1px solid var(--border); border-radius: 20px; padding: 3rem;
            text-align: center;
        }
        .about-img i { font-size: 6rem; color: var(--primary); }
        .about-img p { color: var(--text-muted); margin-top: 1rem; font-size: .9rem; }

        /* ===== CTA ===== */
        #daftar-cta {
            background: radial-gradient(ellipse at center, rgba(14,165,233,.12), transparent);
            text-align: center;
        }
        #daftar-cta h2 { font-size: 2.5rem; font-weight: 900; letter-spacing: -1px; color: #fff; margin-bottom: 1rem; }
        #daftar-cta p { color: var(--text-muted); margin-bottom: 2.5rem; font-size: 1.05rem; }

        /* ===== FOOTER ===== */
        footer {
            background: var(--dark-2); border-top: 1px solid var(--border);
            padding: 3rem 2rem 2rem;
        }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 3rem; max-width: 1200px; margin: 0 auto; }
        .footer-brand .logo-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: 1.1rem; margin-bottom: .75rem;
        }
        .footer-brand h3 { font-size: 1.3rem; font-weight: 800; color: #fff; margin-bottom: .5rem; }
        .footer-brand p { color: var(--text-muted); font-size: .9rem; line-height: 1.6; }
        .footer-list h4 { color: #fff; font-weight: 700; margin-bottom: 1rem; font-size: .95rem; }
        .footer-list ul { list-style: none; }
        .footer-list li { margin-bottom: .5rem; }
        .footer-list a { color: var(--text-muted); text-decoration: none; font-size: .9rem; transition: color .2s; }
        .footer-list a:hover { color: var(--primary); }
        .footer-bottom {
            max-width: 1200px; margin: 2rem auto 0;
            padding-top: 1.5rem; border-top: 1px solid var(--border);
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 1rem;
            color: var(--text-muted); font-size: .85rem;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:none; } }
        @keyframes fadeInUp   { from { opacity:0; transform:translateY(20px);  } to { opacity:1; transform:none; } }
        .fade-in { opacity: 0; transform: translateY(24px); transition: opacity .6s, transform .6s; }
        .fade-in.visible { opacity: 1; transform: none; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            nav { padding: 1rem; }
            .nav-links { display: none; }
            .about-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav id="navbar">
        <a href="/" class="nav-logo">
            <div class="logo-icon">R</div>
            <span>R-NET</span>
        </a>
        <ul class="nav-links">
            <li><a href="#fitur">Fitur</a></li>
            <li><a href="#paket">Paket</a></li>
            <li><a href="#tentang">Tentang</a></li>
        </ul>
        <a href="{{ route('pendaftaran') }}" class="nav-cta" id="btn-daftar-nav">Daftar Sekarang</a>
    </nav>

    <!-- HERO -->
    <section class="hero" id="hero">
        <div class="hero-bg"></div>
        <div class="hero-grid"></div>
        <div class="hero-content">
            <div class="hero-badge"><i class="fa-solid fa-wifi"></i> Wireless Internet Service Provider</div>
            <h1>Internet <span class="gradient-text">Cepat & Handal</span> untuk Koto Baru</h1>
            <p>R-NET hadir untuk mendukung aktivitas digital Anda. Koneksi WiFi stabil untuk rumah tangga, pelajar, dan usaha kecil di Kecamatan Koto Baru, Kota Sungai Penuh.</p>
            <div class="hero-actions">
                <a href="{{ route('pendaftaran') }}" class="btn-primary" id="btn-daftar-hero"><i class="fa-solid fa-paper-plane"></i> Daftar Sekarang</a>
                <a href="#paket" class="btn-outline"><i class="fa-solid fa-list"></i> Lihat Paket</a>
            </div>
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-num">300<span class="stat-unit">Mbps</span></div>
                    <div class="stat-label">Kecepatan Maks</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">24<span class="stat-unit">/7</span></div>
                    <div class="stat-label">Layanan Aktif</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">99<span class="stat-unit">%</span></div>
                    <div class="stat-label">Uptime Jaringan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section id="fitur">
        <div class="container">
            <div class="section-title fade-in">
                <span class="tag">Keunggulan Kami</span>
                <h2>Kenapa Pilih R-NET?</h2>
                <p>Dirancang untuk kebutuhan digital masyarakat Koto Baru</p>
            </div>
            <div class="features-grid">
                <div class="feature-card fade-in">
                    <div class="feature-icon"><i class="fa-solid fa-bolt"></i></div>
                    <h3>Koneksi Ultra Cepat</h3>
                    <p>Nikmati kecepatan hingga 300 Mbps untuk streaming, gaming, dan kerja dari rumah tanpa hambatan.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon"><i class="fa-solid fa-signal"></i></div>
                    <h3>Jaringan Stabil</h3>
                    <p>Infrastruktur nirkabel modern dengan access point dan router berkualitas tinggi untuk koneksi tanpa putus.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <h3>Dukung Pendidikan</h3>
                    <p>Mendukung pembelajaran daring siswa dan mahasiswa dengan koneksi stabil dan harga terjangkau.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon"><i class="fa-solid fa-store"></i></div>
                    <h3>Solusi UMKM</h3>
                    <p>Internet handal untuk kebutuhan bisnis online, transaksi digital, dan komunikasi usaha Anda.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon"><i class="fa-solid fa-headset"></i></div>
                    <h3>Dukungan Pelanggan</h3>
                    <p>Tim teknis siap membantu Anda kapan saja. Kami melayani dengan cepat dan profesional.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon"><i class="fa-solid fa-tag"></i></div>
                    <h3>Harga Bersahabat</h3>
                    <p>Paket mulai dari Rp 200.000/bulan dengan kualitas internet yang tidak menguras kantong Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PAKET WIFI -->
    <section id="paket">
        <div class="container">
            <div class="section-title fade-in">
                <span class="tag">Pilihan Paket</span>
                <h2>Paket WiFi R-NET</h2>
                <p>Pilih paket yang sesuai kebutuhan Anda</p>
            </div>

            {{-- Promosi Banner --}}
            @if(count($promotions) > 0)
                @foreach($promotions as $promo)
                <div class="promo-banner fade-in" id="promo-{{ $promo['id_promosi'] }}">
                    <div class="promo-icon"><i class="fa-solid fa-fire-flame-curved"></i></div>
                    <div class="promo-banner-content">
                        <h3>🎉 {{ $promo['judul_promosi'] }}</h3>
                        <p>{{ $promo['isi_promosi'] }} · Berlaku hingga: <strong>{{ \Carbon\Carbon::parse($promo['end_valid'])->translatedFormat('d F Y') }}</strong></p>
                    </div>
                    <div class="promo-value">{{ $promo['value_promosi'] }}%<br><small style="font-size:.9rem;font-weight:400;color:var(--text-muted);">Diskon</small></div>
                </div>
                @endforeach
            @endif

            <div class="paket-grid">
                @php
                    $activePromo = count($promotions) > 0 ? $promotions[0] : null;
                    $packages = [
                        ['name' => 'Starter', 'speed' => 100, 'price' => 200000, 'featured' => false],
                        ['name' => 'Standard', 'speed' => 200, 'price' => 300000, 'featured' => true],
                        ['name' => 'Premium', 'speed' => 300, 'price' => 400000, 'featured' => false],
                    ];
                @endphp

                @foreach($packages as $pkg)
                @php
                    $discount = $activePromo ? ($activePromo['value_promosi'] ?? 0) : 0;
                    $discounted = $discount > 0 ? $pkg['price'] * (1 - $discount/100) : $pkg['price'];
                @endphp
                <div class="paket-card {{ $pkg['featured'] ? 'featured' : '' }} fade-in" id="paket-{{ $pkg['speed'] }}mbps">
                    @if($pkg['featured']) <div class="paket-featured-badge">Populer</div> @endif
                    <div class="paket-name">Paket {{ $pkg['name'] }}</div>
                    <div class="paket-speed">{{ $pkg['speed'] }}<span> Mbps</span></div>
                    <div class="paket-price">
                        @if($discount > 0)
                            <div class="original">Rp {{ number_format($pkg['price'],0,',','.') }}/bln</div>
                        @endif
                        <div class="current">
                            Rp {{ number_format($discounted,0,',','.') }}<small>/bulan</small>
                            @if($discount > 0)
                                <span class="promo-badge"><i class="fa-solid fa-tag"></i> -{{ $discount }}%</span>
                            @endif
                        </div>
                    </div>
                    <ul class="paket-features">
                        <li><i class="fa-solid fa-check-circle"></i> Kecepatan hingga {{ $pkg['speed'] }} Mbps</li>
                        <li><i class="fa-solid fa-check-circle"></i> Internet tanpa batas (Unlimited)</li>
                        <li><i class="fa-solid fa-check-circle"></i> Instalasi Gratis</li>
                        <li><i class="fa-solid fa-check-circle"></i> Dukungan Teknis 24/7</li>
                        @if($pkg['speed'] >= 200) <li><i class="fa-solid fa-check-circle"></i> Prioritas Jaringan</li> @endif
                        @if($pkg['speed'] >= 300) <li><i class="fa-solid fa-check-circle"></i> Dedicated Support</li> @endif
                    </ul>
                    <a href="{{ route('pendaftaran') }}?paket={{ $pkg['speed'] }}mbps" class="btn-paket {{ $pkg['featured'] ? '' : 'outline' }}" id="btn-pilih-{{ $pkg['speed'] }}mbps">
                        Pilih Paket Ini
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Pesan dari Admin --}}
            @if(count($messages) > 0)
            <div class="messages-section fade-in">
                <h3 style="font-size:1.1rem;font-weight:700;color:#fff;margin-bottom:1.25rem;"><i class="fa-solid fa-bullhorn" style="color:var(--primary);margin-right:.5rem;"></i> Informasi & Pengumuman</h3>
                @foreach($messages as $msg)
                <div class="message-item">
                    <div class="message-icon"><i class="fa-solid fa-circle-info"></i></div>
                    <div class="message-content">
                        <div class="message-tema">{{ strtoupper($msg['tema']) }}</div>
                        <p>{{ $msg['pesan'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    <!-- TENTANG -->
    <section id="tentang">
        <div class="container">
            <div class="about-grid fade-in">
                <div class="about-content">
                    <span class="tag" style="color:var(--primary);font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;display:block;margin-bottom:.75rem;">Tentang R-NET</span>
                    <h2>Membangun Konektivitas untuk Sungai Penuh</h2>
                    <p>R-NET merupakan usaha yang bergerak di bidang penyedia layanan jaringan internet nirkabel (Wireless Internet Service Provider / WISP) yang beroperasi di Kecamatan Koto Baru, Kota Sungai Penuh.</p>
                    <p>Kami menyediakan layanan akses internet berbasis WiFi bagi masyarakat, rumah tangga, dan usaha kecil untuk mendukung berbagai aktivitas digital seperti komunikasi, pembelajaran daring, dan bisnis online.</p>
                    <p>Dalam operasionalnya, R-NET membangun dan mengelola infrastruktur jaringan nirkabel yang terdiri dari perangkat jaringan seperti router, access point, dan sistem distribusi jaringan yang terhubung ke pelanggan.</p>
                    <a href="{{ route('pendaftaran') }}" class="btn-primary" style="margin-top:1.5rem;display:inline-flex;" id="btn-daftar-tentang">
                        <i class="fa-solid fa-arrow-right"></i> Daftar Sekarang
                    </a>
                </div>
                <div class="about-img">
                    <i class="fa-solid fa-tower-broadcast"></i>
                    <p>Infrastruktur jaringan nirkabel modern untuk Koto Baru</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="daftar-cta">
        <div class="container">
            <div class="fade-in">
                <h2>Siap Menikmati Internet Cepat?</h2>
                <p>Bergabunglah dengan pelanggan R-NET dan rasakan perbedaannya hari ini.</p>
                <a href="{{ route('pendaftaran') }}" class="btn-primary" id="btn-daftar-cta">
                    <i class="fa-solid fa-paper-plane"></i> Daftar Sekarang — Gratis Instalasi!
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="logo-icon">R</div>
                <h3>R-NET</h3>
                <p>Penyedia layanan internet WiFi nirkabel terpercaya di Kecamatan Koto Baru, Kota Sungai Penuh.</p>
            </div>
            <div class="footer-list">
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#paket">Paket WiFi</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="{{ route('pendaftaran') }}">Pendaftaran</a></li>
                </ul>
            </div>
            <div class="footer-list">
                <h4>Kontak</h4>
                <ul>
                    <li><a href="#"><i class="fa-solid fa-location-dot" style="margin-right:.4rem;"></i>Koto Baru, Sungai Penuh</a></li>
                    <li><a href="https://wa.me/6281234567890"><i class="fa-brands fa-whatsapp" style="margin-right:.4rem;"></i>WhatsApp</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} R-NET. Semua hak dilindungi.</span>
            <span>Dibuat dengan <i class="fa-solid fa-heart" style="color:#ef4444;"></i> untuk Koto Baru</span>
        </div>
    </footer>

    <script>
        // Fade-in on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, idx) => {
                if(entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), idx * 80);
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        // Sticky navbar
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.style.background = window.scrollY > 50
                ? 'rgba(15,23,42,0.98)'
                : 'rgba(15,23,42,0.8)';
        });
    </script>
</body>
</html>
