import React, { useState, useEffect } from 'react';
import { useForm } from 'react-hook-form';
import toast, { Toaster } from 'react-hot-toast';
import { MessageSquare, User, MapPin, Home, Phone, UploadCloud, HeadphonesIcon } from 'lucide-react';
import MapPicker from './components/MapPicker';
import { getSupabase } from './lib/supabase';

type FormValues = {
  nama: string;
  email: string;
  telp: string;
  alamat: string;
  foto: FileList;
};

export default function App() {
  const { register, handleSubmit, setValue, watch, formState: { errors } } = useForm<FormValues>();
  const [position, setPosition] = useState<[number, number] | null>(null);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [previewUrl, setPreviewUrl] = useState<string | null>(null);
  const [isMapSelected, setIsMapSelected] = useState(false);
  const [typingTimer, setTypingTimer] = useState<NodeJS.Timeout | null>(null);

  // Watch file changes for preview
  const fileInput = watch("foto");
  useEffect(() => {
    if (fileInput && fileInput.length > 0) {
      const file = fileInput[0];
      setPreviewUrl(URL.createObjectURL(file));
    } else {
      setPreviewUrl(null);
    }
  }, [fileInput]);

  const alamatValue = watch("alamat");

  // Auto tracking: Move map automatically if user typed something in Alamat Lengkap
  useEffect(() => {
      // Don't auto map if less than some characters or if change was caused by map click
      if (isMapSelected || !alamatValue || alamatValue.length < 10) return;

      if (typingTimer) clearTimeout(typingTimer);
      const timer = setTimeout(async () => {
          try {
              const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(alamatValue)}&limit=1&email=admin@r-net.com`, {
                  headers: { 'Accept-Language': 'id-ID,id;q=0.9' }
              });
              if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
              const data = await res.json();
              if (data && data.length > 0) {
                  const { lat, lon } = data[0];
                  setPosition([parseFloat(lat), parseFloat(lon)]);
              }
          } catch (err) {
             console.warn("Geocode lookup gracefully aborted (rate limit/network issue):", err);
          }
      }, 2000); // Wait 2 seconds after typing stops
      setTypingTimer(timer);

      return () => clearTimeout(timer);
      // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [alamatValue, isMapSelected]);

  // Handler to set address specifically requested from the map interaction
  const handleSetAddressMap = (addr: string, isFromMap: boolean) => {
     if (isFromMap) {
        setIsMapSelected(true);
        setValue("alamat", addr, { shouldValidate: true, shouldDirty: true, shouldTouch: true });
        
        // Release the flag after a buffer to allow future manual typings
        setTimeout(() => {
           setIsMapSelected(false);
        }, 5000); // Wait 5 seconds to stop jumpy backwards API fetches
     }
  };

  const uploadToSupabase = async (file: File): Promise<string> => {
    const supabase = getSupabase();
    if (!supabase) {
      return new Promise((resolve) => {
        setTimeout(() => resolve(`https://mock-supabase.url/path/${file.name}`), 1000);
      });
    }

    const fileExt = file.name.split('.').pop();
    const fileName = `${Math.random()}.${fileExt}`;
    const filePath = `pendaftaran/${fileName}`;

    const { error: uploadError } = await supabase.storage
      .from('attachments') 
      .upload(filePath, file);

    if (uploadError) {
      throw uploadError;
    }

    const { data: { publicUrl } } = supabase.storage
      .from('attachments')
      .getPublicUrl(filePath);

    return publicUrl;
  };

  const onSubmit = async (data: FormValues) => {
    if (!position || position[0] === 0 || position[1] === 0) {
      toast.error("Harap tentukan lokasi Anda melalui Peta.");
      return;
    }

    const file = data.foto[0];
    if (!file) {
      toast.error("Harap unggah KTP/Foto Rumah.");
      return;
    }

    setIsSubmitting(true);
    const toastId = toast.loading("Mengirim data...");

    try {
      const path_gambar = await uploadToSupabase(file);

      // Sanitize phone input
      let noTelp = data.telp.replace(/\D/g,''); // format local numbers
      
      const payload = {
        nama: data.nama,
        email: data.email,
        alamat: data.alamat,
        lat: position[0],
        long: position[1],
        telp: `+62${noTelp}`,
        path_gambar: path_gambar
      };

      console.log("Payload Backend API:", payload);
      await new Promise(resolve => setTimeout(resolve, 1000));
      toast.success("Pendaftaran berhasil!", { id: toastId });
    } catch (error: any) {
      console.error(error);
      toast.error(`Gagal submit: ${error.message || 'Error'}`, { id: toastId });
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className="min-h-screen bg-[#f1f5f9] font-sans pb-20">
      <Toaster position="top-center" />
      
      {/* Navbar Minimalist */}
      <nav className="border-b border-slate-200 px-4 md:px-8 py-3 flex items-center justify-between bg-white sticky top-0 z-50 shadow-sm">
        <div className="flex items-center gap-6 text-sm font-medium">
          <div className="flex flex-col items-start leading-none group cursor-pointer mr-2">
            <div className="flex items-center gap-1 font-bold text-2xl tracking-tighter">
              <div className="relative flex items-center justify-center">
                <span className="text-[#4a4a4a] text-3xl leading-none">R</span>
                <div className="absolute top-0 right-[-4px] flex flex-col items-end opacity-90">
                   <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2b99d8" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round" className="transform translate-x-1.5 -translate-y-1"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><circle cx="12" cy="20" r="2" fill="#2b99d8" stroke="none"></circle></svg>
                </div>
              </div>
              <div className="flex tracking-tight text-[#4a4a4a] ml-3">
                 <span>N</span>
                 <span className="text-[#2b99d8]">E</span>
                 <span>T</span>
              </div>
            </div>
            <span className="text-[9px] font-bold tracking-[0.05em] text-slate-500 mt-1 uppercase">Internet Rakyat</span>
          </div>
          <div className="hidden md:flex gap-6">
            <a href="#" className="hover:underline underline-offset-4 decoration-2 text-[#2b99d8]">Layanan</a>
            <a href="#" className="hover:underline underline-offset-4 decoration-2 text-slate-600">Cakupan Area</a>
            <a href="#" className="hover:underline underline-offset-4 decoration-2 text-slate-600">Harga</a>
          </div>
        </div>
        <div className="flex items-center gap-4">
          <span className="text-sm font-medium hidden md:block text-slate-600">Sales: +62 811-1234-5678</span>
          <button className="hidden md:block px-5 py-2 border border-[#cbd5e1] rounded-full text-sm font-medium text-slate-700 hover:bg-slate-50 transition">Masuk</button>
        </div>
      </nav>

      <main className="max-w-7xl mx-auto px-4 md:px-8 pt-6 md:pt-10 grid lg:grid-cols-12 gap-6 md:gap-10">
        
        {/* Left Column (Info Panel) */}
        <div className="lg:col-span-4 space-y-4 md:space-y-6">
          
          <div className="space-y-2">
            <h1 className="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight leading-tight">
              Daftar Layanan
            </h1>
          </div>

          <div className="space-y-3 text-[15px] md:text-base text-slate-600 leading-relaxed max-w-[22rem]">
            <p>Isi formulir pendaftaran di samping untuk mulai menggunakan layanan internet berkecepatan tinggi dari R-NET (Internet Rakyat).</p>
            <p>Dapatkan pengalaman berselancar tanpa batas dengan dukungan fiber optik mutakhir kami yang menjangkau rumah Anda.</p>
          </div>

          <div className="bg-white p-4 text-slate-700 text-sm shadow-sm border border-slate-200 rounded-xl mt-6">
            <p className="font-semibold mb-1 text-slate-900">Petunjuk Lokasi Peta:</p>
            <p className="opacity-90 leading-relaxed text-xs md:text-sm">Geser peta untuk mencari lokasi Anda yang paling tepat, lalu tekan tombol "Konfirmasi Alamat".</p>
          </div>
        </div>

        {/* Right Column (The Form) */}
        <div className="lg:col-span-8 space-y-6 mb-10">
          
          <div className="bg-white p-5 md:p-8 rounded-2xl shadow-sm border border-slate-200">
            <form onSubmit={handleSubmit(onSubmit)} className="space-y-8">
              
              {/* Informasi Pribadi Section */}
              <div className="space-y-5">
                <div className="flex items-center gap-3">
                  <div className="bg-[#eef2ff] text-[#1e40af] p-2 rounded-lg">
                    <User className="w-5 h-5" />
                  </div>
                  <h3 className="font-bold text-lg text-slate-800">Informasi Pribadi</h3>
                </div>

                <div className="space-y-5 md:pl-2">
                  <div className="space-y-1.5">
                    <label className="text-sm font-semibold text-slate-700 flex items-center">
                      Nama Lengkap<span className="text-red-500 ml-1">*</span>
                    </label>
                    <input 
                      type="text"
                      placeholder="Masukkan nama lengkap Anda"
                      className="w-full px-4 py-3 bg-[#f8fafc] border border-slate-200 rounded-lg transition focus:border-blue-500 focus:bg-white focus:ring-1 focus:ring-blue-500 text-sm outline-none"
                      {...register("nama", { required: "Wajib diisi" })}
                    />
                    {errors.nama && <p className="text-red-600 text-xs mt-1">{errors.nama.message}</p>}
                  </div>

                  <div className="grid md:grid-cols-2 gap-5">
                    <div className="space-y-1.5">
                      <label className="text-sm font-semibold text-slate-700 flex items-center">
                        Nomor Telepon<span className="text-red-500 ml-1">*</span>
                      </label>
                      <div className="flex w-full bg-[#f8fafc] border border-slate-200 rounded-lg overflow-hidden focus-within:ring-1 focus-within:bg-white focus-within:ring-blue-500 focus-within:border-blue-500 transition">
                        <span className="flex items-center justify-center px-3 bg-slate-50 border-r border-slate-200 text-sm text-slate-500 font-semibold shadow-inner">
                          +62
                        </span>
                        <input
                          type="tel"
                          placeholder="812-3456-7890"
                          className="w-full px-3 py-3 outline-none text-sm bg-transparent"
                          {...register("telp", { 
                            required: "Wajib diisi",
                            pattern: { value: /^[0-9\-\s]+$/, message: "Hanya angka" },
                            minLength: { value: 8, message: "Minimal 8 digit" }
                          })}
                        />
                      </div>
                      {errors.telp && <p className="text-red-600 text-xs mt-1">{errors.telp.message}</p>}
                    </div>

                    <div className="space-y-1.5">
                      <label className="text-sm font-semibold text-slate-700 flex items-center">
                        Email Utama<span className="text-red-500 ml-1">*</span>
                      </label>
                      <input 
                        type="email"
                        placeholder="email@anda.com"
                        maxLength={100}
                        className="w-full px-4 py-3 bg-[#f8fafc] border border-slate-200 rounded-lg transition focus:border-blue-500 focus:bg-white focus:ring-1 focus:ring-blue-500 text-sm outline-none"
                        {...register("email", { 
                          required: "Wajib diisi",
                          pattern: { value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i, message: "Email tidak valid" }
                        })}
                      />
                      {errors.email && <p className="text-red-600 text-xs mt-1">{errors.email.message}</p>}
                    </div>
                  </div>
                </div>
              </div>

              {/* Informasi Alamat Section */}
              <div className="space-y-5 pt-4 border-t border-slate-100">
                <div className="flex items-center gap-3">
                  <div className="bg-[#eef2ff] text-[#1e40af] p-2 rounded-lg">
                    <MapPin className="w-5 h-5" />
                  </div>
                  <h3 className="font-bold text-lg text-slate-800">Informasi Alamat</h3>
                </div>

                <div className="space-y-5 md:pl-2">
                  <div className="space-y-1.5 flex flex-col">
                    <label className="text-sm font-semibold text-slate-700 flex items-center">
                      Koordinat Lokasi<span className="text-red-500 ml-1">*</span>
                    </label>
                    <div className="w-full">
                      <MapPicker 
                        position={position} 
                        setPosition={setPosition} 
                        setAddress={handleSetAddressMap}
                      />
                    </div>
                  </div>

                  <div className="space-y-1.5">
                    <label className="text-sm font-semibold text-slate-700 flex items-center">
                      Alamat Lengkap<span className="text-red-500 ml-1">*</span>
                    </label>
                    <textarea 
                      rows={3}
                      className="w-full px-4 py-3 bg-[#f8fafc] border border-slate-200 rounded-lg transition focus:border-blue-500 focus:bg-white focus:ring-1 focus:ring-blue-500 resize-none text-sm outline-none"
                      placeholder="Contoh: Jl. Panglima Sudirman No. 12, RT 01/RW 02, Kelurahan Melati, Kode Pos 15810"
                      {...register("alamat", { required: "Wajib diisi" })}
                    ></textarea>
                    {errors.alamat && <p className="text-red-600 text-xs mt-1">{errors.alamat.message}</p>}
                    <p className="text-[11px] text-slate-500 leading-relaxed mt-2 italic">
                      Jika Anda mengubah teks ini dengan alamat/kota yang spesifik, peta di atas otomatis akan bergeser ke lokasi tersebut.
                    </p>
                  </div>
                </div>
              </div>

              {/* Foto Properti Section */}
              <div className="space-y-5 pt-4 border-t border-slate-100">
                <div className="flex items-center gap-3">
                  <div className="bg-[#eef2ff] text-[#1e40af] p-2 rounded-lg">
                    <Home className="w-5 h-5" />
                  </div>
                  <h3 className="font-bold text-lg text-slate-800">Foto Properti</h3>
                </div>

                <div className="space-y-1.5 md:pl-2">
                  <label className="text-sm font-semibold text-slate-700 flex items-center">
                    Upload Foto Rumah<span className="text-red-500 ml-1">*</span>
                  </label>
                  
                  <div className={`relative border border-slate-200 rounded-xl transition hover:border-blue-400 bg-[#f8fafc] overflow-hidden`}>
                    {previewUrl && (
                      <div className="flex items-center p-4 border-b border-slate-200 bg-white">
                         <img src={previewUrl} alt="Preview" className="w-20 h-20 object-cover rounded shadow border border-slate-200" />
                         <div className="flex-1 ml-4">
                            <p className="text-sm font-semibold text-slate-800">Gambar berhasil dipilih</p>
                            <p className="text-xs text-slate-500 mt-1">Gunakan tombol di bawah untuk mengganti.</p>
                         </div>
                      </div>
                    )}
                    
                    <label className="flex flex-col items-center justify-center p-6 md:p-8 cursor-pointer hover:bg-slate-50 transition">
                      <div className="bg-[#eef2ff] p-3 rounded-xl mb-4 text-[#1e40af] shadow-sm font-semibold">
                        <UploadCloud className="w-6 h-6" />
                      </div>
                      <p className="text-sm font-bold text-slate-700 mb-1">
                        {previewUrl ? 'Klik untuk mengganti gambar' : 'Klik untuk upload foto rumah'}
                      </p>
                      <p className="text-xs text-slate-500 font-medium">PNG, JPG maksimal 1 MB</p>
                      <input 
                        type="file" 
                        accept=".png, .jpg, .jpeg"
                        className="hidden" 
                        {...register("foto", { 
                          required: "Wajib diunggah",
                          validate: {
                            lessThan1MB: (files) => {
                              if (!files || files.length === 0) return true;
                              return files[0].size <= 1048576 || "Ukuran maksimal 1MB";
                            }
                          }
                        })}
                      />
                    </label>
                  </div>
                  {errors.foto && <p className="text-red-600 text-xs mt-1">{errors.foto.message}</p>}
                  <p className="text-xs text-slate-500 leading-relaxed mt-2">
                    Upload foto tampak depan rumah yang jelas untuk membantu teknisi menemukan lokasi properti Anda.
                  </p>
                </div>
              </div>

              {/* Submit Section */}
              <div className="pt-8">
                <button 
                  type="submit" 
                  disabled={isSubmitting}
                  className="w-full bg-[#1e40af] text-white font-bold px-8 py-3.5 rounded-lg hover:bg-[#1e3a8a] transition shadow text-sm disabled:opacity-70 flex items-center justify-center"
                >
                  {isSubmitting ? 'Memproses Data...' : 'Kirim Pendaftaran'}
                </button>
                <p className="text-[11px] text-center text-slate-500 font-medium mt-4">
                  Dengan mengirim formulir ini, Anda setuju dengan <br className="hidden sm:block" /> 
                  <span className="text-blue-600 hover:underline cursor-pointer">Syarat Layanan</span> dan <span className="text-blue-600 hover:underline cursor-pointer">Kebijakan Privasi</span> kami.
                </p>
              </div>

            </form>
          </div>

          {/* Contact Support Container directly below the form card */}
          <div className="bg-white border border-slate-200 rounded-2xl p-5 md:p-6 shadow-sm flex flex-col sm:flex-row gap-5 items-start sm:items-center mt-6">
             <div className="bg-[#eef2ff] p-3 md:p-4 rounded-xl text-[#1e40af] shrink-0">
                <HeadphonesIcon className="w-6 h-6 md:w-8 md:h-8" />
             </div>
             <div>
                <h4 className="font-bold text-slate-800 text-base">Butuh Bantuan?</h4>
                <p className="text-sm text-slate-500 mt-1 mb-3">Tim layanan pelanggan kami tersedia 24/7 untuk membantu proses instalasi Anda.</p>
                <div className="flex flex-col sm:flex-row gap-3 sm:gap-6 text-sm font-semibold">
                   <a href="#" className="flex items-center gap-2 text-slate-700 hover:text-blue-600 transition">
                      <Phone className="w-4 h-4 text-blue-600" />
                      0813-7324-2873
                   </a>
                   <a href="#" className="flex items-center gap-2 text-green-600 hover:text-green-700 transition">
                      <MessageSquare className="w-4 h-4" />
                      Dukungan WhatsApp
                   </a>
                </div>
             </div>
          </div>

        </div>
      </main>
    </div>
  );
}
