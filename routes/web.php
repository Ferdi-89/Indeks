<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Models\pengumuman;
use App\Models\paket;

Route::get('/', function () {

    $data = Cache::remember('landing_page_data',60*60*24, function () {
        return[
            'pengumuman' => pengumuman::pluck('text_pengumuman')->toArray(),
            'pakets' => paket::all()->toArray()
        ];
    });

    $pengumuman = $data['pengumuman'];
    $pakets = collect($data['pakets']);

    $ekonomi = $pakets->where('id_paket','p001')->first();
    $famili = $pakets->where('id_paket','p002')->first();
    $premium = $pakets->where('id_paket','p003')->first();

    if(empty($pengumuman)){
        $pengumuman = ['Selamat datang dan Pilihlah paket anda :> '];
    }
    return view('welcome',compact('pengumuman','famili','ekonomi','premium'));
});
