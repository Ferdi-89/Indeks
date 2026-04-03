<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil — R-NET</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #0f172a; color: #e2e8f0; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 2rem; }
        .card {
            max-width: 480px; width: 100%;
            background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08);
            border-radius: 24px; padding: 3.5rem 3rem; text-align: center;
        }
        .success-icon {
            width: 80px; height: 80px; border-radius: 50%;
            background: rgba(16,185,129,.15); border: 2px solid rgba(16,185,129,.4);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.2rem; color: #10b981; margin: 0 auto 2rem;
            animation: pop .5s cubic-bezier(.34,1.56,.64,1) both;
        }
        @keyframes pop { from { transform: scale(0); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        h1 { font-size: 1.8rem; font-weight: 800; color: #fff; margin-bottom: .75rem; }
        p { color: #94a3b8; line-height: 1.7; margin-bottom: 1.5rem; }
        .btn {
            display: inline-flex; align-items: center; gap: .5rem;
            background: linear-gradient(135deg, #0ea5e9, #6366f1);
            color: #fff; text-decoration: none; padding: .8rem 2rem;
            border-radius: 10px; font-weight: 700; font-size: .95rem;
            transition: opacity .2s;
        }
        .btn:hover { opacity: .9; }
    </style>
</head>
<body>
    <div class="card">
        <div class="success-icon"><i class="fa-solid fa-check"></i></div>
        <h1>Pendaftaran Terkirim!</h1>
        <p>Terima kasih telah mendaftar sebagai pelanggan R-NET. Tim kami akan segera menghubungi Anda dalam 1–3 hari kerja untuk proses pemasangan.</p>
        <a href="{{ route('home') }}" class="btn"><i class="fa-solid fa-house"></i> Kembali ke Beranda</a>
    </div>
</body>
</html>
