<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="R-NET - Penyedia layanan internet cepat, stabil, tanpa FUP. Nikmati koneksi unlimited dengan harga terjangkau untuk rumah dan keluarga Anda.">
    <title>Daftar R-NET</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-base-200 min-h-screen font-sans">
    <div class="flex items-center justify-center p-4 py-20">
        <div class="card w-full max-w-lg bg-base-100 shadow-xl border border-base-300">
            <div class="card-body gap-6">
                <div class="text-center space-y-2">
                    <div class="flex justify-center">
                        <a href="/">
                            <img src="/logoprimary.svg" alt="R-NET" class="h-12 w-auto">
                        </a>
                    </div>
                    <h2 class="text-3xl font-extrabold text-primary">Daftar R-NET</h2>
                    <p class="text-base-content/60 text-sm">Lengkapi formulir di bawah untuk berlangganan internet cepat.</p>
                </div>
                <div class="divider my-0"></div>
                <form action="#" method="POST" class="space-y-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Nama Lengkap</span></label>
                        <input type="text" placeholder="Masukkan nama" class="input input-bordered focus:input-primary" required />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Nomor WhatsApp</span></label>
                        <input type="tel" placeholder="0812xxxx" class="input input-bordered focus:input-primary" required />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Alamat Lengkap</span></label>
                        <textarea class="textarea textarea-bordered h-24 focus:textarea-primary" placeholder="Masukkan alamat pemasangan"></textarea>
                    </div>
                    <div class="form-control pt-4">
                        <button type="submit" class="btn btn-primary btn-block text-white font-bold h-12">Submit Pendaftaran</button>
                    </div>
                </form>
                <div class="text-center">
                    <a href="/" class="btn btn-ghost btn-sm text-base-content/50 hover:text-primary">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>