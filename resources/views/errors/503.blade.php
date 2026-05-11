<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Maintenance - R-NET</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-xl overflow-hidden text-center p-10 md:p-14 border border-slate-100">
        <!-- Icon -->
        <div class="w-24 h-24 mx-auto bg-[#fffbeb] text-[#d97706] rounded-full flex items-center justify-center mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        
        <h1 class="text-3xl font-extrabold text-slate-800 mb-4">Sistem Sedang Perbaikan</h1>
        <p class="text-slate-500 mb-8 leading-relaxed">
            Mohon maaf atas ketidaknyamanan ini. Kami sedang melakukan pemeliharaan sistem untuk meningkatkan kualitas layanan jaringan R-NET. Silakan coba kembali dalam beberapa saat.
        </p>
        
        <div class="inline-flex items-center gap-2 text-sm text-slate-500 font-medium bg-slate-50 border border-slate-100 px-4 py-2 rounded-full">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#f59e0b] opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-[#f59e0b]"></span>
            </span>
            Pekerjaan Sedang Berlangsung
        </div>
    </div>
</body>
</html>
