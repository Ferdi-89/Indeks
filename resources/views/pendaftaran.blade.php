<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan — R-NET</title>
    <meta name="description" content="Formulir pendaftaran pelanggan baru R-NET. Daftar sekarang dan nikmati internet WiFi cepat di Koto Baru.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #0ea5e9; --accent: #6366f1;
            --dark: #0f172a; --dark-2: #1e293b; --dark-3: #334155;
            --text: #e2e8f0; --text-muted: #94a3b8;
            --border: rgba(255,255,255,0.08);
            --success: #10b981; --danger: #ef4444;
        }
        body { font-family: 'Inter', sans-serif; background: var(--dark); color: var(--text); min-height: 100vh; }
        .page-wrap {
            min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr;
        }
        /* LEFT PANEL */
        .left-panel {
            background: linear-gradient(135deg, #0c1a33 0%, #0f172a 60%),
                        radial-gradient(ellipse at 30% 50%, rgba(14,165,233,.2), transparent);
            display: flex; flex-direction: column; justify-content: center;
            padding: 4rem; position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: ''; position: absolute;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(14,165,233,.12), transparent);
            top: -100px; right: -100px;
        }
        .left-panel::after {
            content: ''; position: absolute;
            width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,.1), transparent);
            bottom: -50px; left: -50px;
        }
        .left-brand { position: relative; margin-bottom: 3rem; }
        .left-brand a { display: flex; align-items: center; gap: .6rem; text-decoration: none; }
        .logo-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: 1.1rem;
        }
        .logo-text { font-size: 1.5rem; font-weight: 800; color: #fff; }
        .left-content { position: relative; }
        .left-content h1 { font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; color: #fff; margin-bottom: 1rem; }
        .left-content .gradient-text {
            background: linear-gradient(135deg, var(--primary), #818cf8);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .left-content p { color: var(--text-muted); line-height: 1.7; margin-bottom: 2rem; }
        .benefit-list { list-style: none; display: flex; flex-direction: column; gap: .75rem; }
        .benefit-list li {
            display: flex; align-items: center; gap: .75rem;
            font-size: .9rem; color: var(--text-muted);
        }
        .benefit-list .icon-check {
            width: 28px; height: 28px; border-radius: 50%;
            background: rgba(16,185,129,.15); border: 1px solid rgba(16,185,129,.3);
            display: flex; align-items: center; justify-content: center;
            color: var(--success); font-size: .7rem; flex-shrink: 0;
        }

        /* RIGHT PANEL */
        .right-panel {
            display: flex; align-items: center; justify-content: center;
            padding: 3rem 4rem; overflow-y: auto;
        }
        .form-box { width: 100%; max-width: 480px; }
        .form-box h2 { font-size: 1.7rem; font-weight: 800; color: #fff; margin-bottom: .4rem; }
        .form-box .sub { color: var(--text-muted); font-size: .9rem; margin-bottom: 2rem; }
        .form-box .sub a { color: var(--primary); text-decoration: none; }
        .step-indicator {
            display: flex; align-items: center; gap: .5rem; margin-bottom: 2rem;
        }
        .step { flex: 1; height: 3px; border-radius: 3px; background: var(--dark-3); transition: background .3s; }
        .step.active { background: var(--primary); }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; font-size: .85rem; font-weight: 600; color: var(--text-muted); margin-bottom: .5rem; }
        .form-group label span.req { color: var(--danger); }
        .form-control {
            width: 100%;
            background: rgba(255,255,255,.04);
            border: 1px solid var(--border);
            color: var(--text); padding: .75rem 1rem;
            border-radius: 10px; font-size: .95rem; font-family: inherit;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14,165,233,.15);
        }
        .form-control::placeholder { color: #475569; }
        select.form-control { cursor: pointer; }
        .input-icon-wrap { position: relative; }
        .input-icon-wrap .icon { position: absolute; left: .9rem; top: 50%; transform: translateY(-50%); color: #475569; font-size: .9rem; }
        .input-icon-wrap .form-control { padding-left: 2.5rem; }
        textarea.form-control { resize: vertical; min-height: 90px; }
        .form-group .hint { font-size: .78rem; color: #475569; margin-top: .35rem; }
        .file-upload {
            border: 2px dashed var(--border); border-radius: 10px; padding: 1.5rem;
            text-align: center; cursor: pointer; transition: border-color .2s, background .2s;
        }
        .file-upload:hover { border-color: var(--primary); background: rgba(14,165,233,.04); }
        .file-upload i { font-size: 1.5rem; color: var(--text-muted); display: block; margin-bottom: .5rem; }
        .file-upload p { font-size: .85rem; color: var(--text-muted); }
        .file-upload input[type="file"] { display: none; }
        .btn-submit {
            width: 100%; padding: .9rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; border: none; border-radius: 10px;
            font-size: 1rem; font-weight: 700; font-family: inherit;
            cursor: pointer; transition: opacity .2s, transform .2s;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            margin-top: 1.5rem;
        }
        .btn-submit:hover { opacity: .9; transform: translateY(-1px); }
        .back-link { display: block; text-align: center; margin-top: 1.25rem; color: var(--text-muted); font-size: .875rem; text-decoration: none; }
        .back-link:hover { color: var(--primary); }
        .alert-error {
            background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3);
            color: #fca5a5; border-radius: 10px; padding: .8rem 1rem; margin-bottom: 1.5rem; font-size: .875rem;
        }
        @media (max-width: 768px) {
            .page-wrap { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>
<div class="page-wrap">
    <!-- LEFT -->
    <div class="left-panel">
        <div class="left-brand">
            <a href="{{ route('home') }}">
                <div class="logo-icon">R</div>
                <span class="logo-text">R-NET</span>
            </a>
        </div>
        <div class="left-content">
            <h1>Daftar & Nikmati Internet <span class="gradient-text">Ultra Cepat</span></h1>
            <p>Proses pendaftaran mudah dan cepat. Isi formulir, dan tim kami akan segera menghubungi Anda untuk pemasangan.</p>
            <ul class="benefit-list">
                <li><div class="icon-check"><i class="fa-solid fa-check"></i></div> Instalasi gratis tanpa biaya tambahan</li>
                <li><div class="icon-check"><i class="fa-solid fa-check"></i></div> Aktivasi dalam 1–3 hari kerja</li>
                <li><div class="icon-check"><i class="fa-solid fa-check"></i></div> Internet unlimited tanpa batas waktu</li>
                <li><div class="icon-check"><i class="fa-solid fa-check"></i></div> Dukungan teknis 24 jam sehari</li>
                <li><div class="icon-check"><i class="fa-solid fa-check"></i></div> Paket mulai Rp 200.000/bulan</li>
            </ul>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="right-panel">
        <div class="form-box">
            <h2>Formulir Pendaftaran</h2>
            <p class="sub">Isi data di bawah ini dengan lengkap. <a href="{{ route('home') }}">← Kembali ke beranda</a></p>

            @if($errors->any())
            <div class="alert-error">
                <ul style="list-style:none;padding:0;">
                    @foreach($errors->all() as $error)
                        <li><i class="fa-solid fa-circle-exclamation" style="margin-right:.4rem;"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" id="form-pendaftaran">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Lengkap <span class="req">*</span></label>
                    <div class="input-icon-wrap">
                        <i class="fa-solid fa-user icon"></i>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap Anda" value="{{ old('nama') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="no_telepon">Nomor Telepon / WhatsApp <span class="req">*</span></label>
                    <div class="input-icon-wrap">
                        <i class="fa-solid fa-phone icon"></i>
                        <input type="tel" id="no_telepon" name="no_telepon" class="form-control" placeholder="Contoh: 08123456789" value="{{ old('no_telepon') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat Lengkap <span class="req">*</span></label>
                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan alamat lengkap (nama jalan, RT/RW, kelurahan, dll.)" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="paket">Pilih Paket <span class="req">*</span></label>
                    <select id="paket" name="paket" class="form-control" required>
                        <option value="" disabled {{ !old('paket') ? 'selected' : '' }}>-- Pilih Paket WiFi --</option>
                        <option value="100mbps" {{ old('paket', request('paket')) === '100mbps' ? 'selected' : '' }}>Paket Starter — 100 Mbps (Rp 200.000/bln)</option>
                        <option value="200mbps" {{ old('paket', request('paket')) === '200mbps' ? 'selected' : '' }}>Paket Standard — 200 Mbps (Rp 300.000/bln)</option>
                        <option value="300mbps" {{ old('paket', request('paket')) === '300mbps' ? 'selected' : '' }}>Paket Premium — 300 Mbps (Rp 400.000/bln)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="koordinat">Koordinat Lokasi</label>
                    <div class="input-icon-wrap">
                        <i class="fa-solid fa-location-dot icon"></i>
                        <input type="text" id="koordinat" name="koordinat" class="form-control" placeholder="Contoh: -2.0614, 101.3921" value="{{ old('koordinat') }}">
                    </div>
                    <p class="hint"><i class="fa-solid fa-circle-info" style="margin-right:.25rem;"></i> Opsional. Buka Google Maps → tahan titik lokasi → salin koordinat.</p>
                </div>

                <div class="form-group">
                    <label>Foto KTP / Bukti Identitas</label>
                    <div class="file-upload" onclick="document.getElementById('l_gambar').click()">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p>Klik untuk upload foto KTP (JPG, PNG, maks 2MB)</p>
                        <input type="file" id="l_gambar" name="l_gambar" accept="image/*">
                    </div>
                    <p class="hint" id="file-name" style="display:none;color:var(--success);"><i class="fa-solid fa-check-circle" style="margin-right:.3rem;"></i><span></span></p>
                </div>

                <button type="submit" class="btn-submit" id="btn-submit-daftar">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Pendaftaran
                </button>
            </form>
            <a href="{{ route('home') }}" class="back-link">← Kembali ke Beranda</a>
        </div>
    </div>
</div>
<script>
    document.getElementById('l_gambar').addEventListener('change', function() {
        const nameEl = document.getElementById('file-name');
        if(this.files.length > 0) {
            nameEl.style.display = 'block';
            nameEl.querySelector('span').textContent = this.files[0].name;
        }
    });
</script>
</body>
</html>
