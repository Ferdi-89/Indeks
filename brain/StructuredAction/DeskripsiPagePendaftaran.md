2. Page pendaftaran 
terdapat field text : 

id_pendaftar(varchar(5))
nama(varchar(50))
alamat(varchar(100))
latitude(decimal(10,8)) 
longitude(decimal(11,8))
email(varchar(100))
nomor_telp(varchar(20))
file input ( gambar dengan ukuran gambar maksimal 1mb (menggunakan library browser-image-compression ,langsung kompres di dalam web))

untuk longitud dan latidude diambil dari lokasi user saat ini menggunakan geolocation api yang di ekstrak menggunakan koordinat dari maps javascript API 
dalam page ini juga terdapat maps yang dimana user dapat memilih map dengan cara menggeser map dan marker akan mengikuti posisi map yang digeser atau menekan tombol "gunakan lokasi saat ini" maka marker akan mengikuti posisi user saat ini, lalu menekan konfirmasi, maka input langitude,latitude,dan alamat akan secara otomatis terisi, untuk address buat menjadi terlihat sehingga pengguna dapat mengubah dan menyesuaikan alamat nya sendiri.

file input gambar langsung masukkan ke file drive supabase, dan simpan url nya ke dalam database.


