import React, { useEffect, useState } from 'react';
import { useLocation } from 'wouter';
import { LogOut, Users, MapPin, Search, Calendar, ChevronRight } from 'lucide-react';
import { getSupabase } from '../lib/supabase';
import toast, { Toaster } from 'react-hot-toast';

interface RegistrationEntry {
  id: string;
  nama: string;
  email: string;
  telp: string;
  alamat: string;
  lat: number;
  long: number;
  path_gambar: string;
  created_at: string;
  status: 'pending' | 'survey' | 'installed';
}

export default function AdminDashboard() {
  const [, setLocation] = useLocation();
  const [registrations, setRegistrations] = useState<RegistrationEntry[]>([]);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    fetchRegistrations();
  }, []);

  const fetchRegistrations = async () => {
    setIsLoading(true);
    try {
      const supabase = getSupabase();
      if (!supabase) {
        // Mock data
        setTimeout(() => {
          setRegistrations([
            {
              id: '1',
              nama: 'Budi Santoso',
              email: 'budi.santoso@contoh.com',
              telp: '+6281234567890',
              alamat: 'Jl. Melati No. 12, Koto Baru, Sungai Penuh',
              lat: -2.0346,
              long: 101.3888,
              path_gambar: 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=200&h=200&fit=crop',
              created_at: new Date().toISOString(),
              status: 'pending'
            },
            {
              id: '2',
              nama: 'Siti Aminah',
              email: 'siti@contoh.com',
              telp: '+6281234567891',
              alamat: 'Pasar Sungai Penuh Blok A No 5',
              lat: -2.0645,
              long: 101.3934,
              path_gambar: 'https://images.unsplash.com/photo-1518780664697-55e3ad937233?w=200&h=200&fit=crop',
              created_at: new Date(Date.now() - 86400000).toISOString(),
              status: 'survey'
            }
          ]);
          setIsLoading(false);
        }, 1000);
        return;
      }

      // If backend is active (mocking table name since we don't have SQL DDL running yet)
      const { data, error } = await supabase
        .from('registrations')
        .select('*')
        .order('created_at', { ascending: false });

      if (error) {
        // Don't throw for now, just show error toast
        toast.error("Gagal memuat data registrasi. Pastikan tabel 'registrations' dibuat.");
        console.error(error);
        setIsLoading(false);
      } else {
        setRegistrations(data as RegistrationEntry[]);
        setIsLoading(false);
      }
    } catch (e) {
      console.error(e);
      setIsLoading(false);
    }
  };

  const handleLogout = async () => {
    const supabase = getSupabase();
    if (supabase) {
      await supabase.auth.signOut();
    } else {
      localStorage.removeItem('mockAdminAuth');
      window.location.href = '/admin/login'; // Force reload to clear state
      return;
    }
    setLocation('/admin/login');
  };

  return (
    <div className="min-h-screen bg-slate-50 font-sans flex flex-col md:flex-row">
      <Toaster position="top-right" />
      
      {/* Sidebar Desktop */}
      <aside className="w-full md:w-64 bg-slate-900 border-r border-slate-800 flex flex-col text-white">
        <div className="p-6 border-b border-slate-800 flex justify-between items-center md:block">
           <div>
              <div className="flex items-center gap-1 font-bold text-2xl tracking-tighter text-white">
                 <span className="text-white text-3xl leading-none">R</span>
                 <div className="flex tracking-tight text-white ml-2">
                    <span>N</span>
                    <span className="text-[#2b99d8]">E</span>
                    <span>T</span>
                 </div>
              </div>
              <span className="text-[10px] font-bold tracking-[0.05em] text-slate-400 mt-1 uppercase block">Admin Dashboard</span>
           </div>
           
           {/* Mobile logout */}
           <button onClick={handleLogout} className="md:hidden p-2 text-slate-400 hover:text-white bg-slate-800 rounded-lg">
             <LogOut className="w-5 h-5" />
           </button>
        </div>
        
        <nav className="p-4 flex-1 overflow-x-auto whitespace-nowrap md:whitespace-normal md:overflow-visible flex gap-2 md:block">
           <a href="#" className="flex items-center gap-3 px-4 py-3 bg-blue-600/20 text-blue-400 border border-blue-500/20 rounded-xl font-medium transition">
              <Users className="w-5 h-5 flex-shrink-0" />
              Pendaftaran Masuk
           </a>
        </nav>

        <div className="p-4 border-t border-slate-800 mt-auto hidden md:block">
          <button 
             onClick={handleLogout}
             className="w-full flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl font-medium transition"
          >
             <LogOut className="w-5 h-5 flex-shrink-0" />
             Log Out
          </button>
        </div>
      </aside>

      {/* Main Content */}
      <main className="flex-1 p-4 md:p-8 overflow-y-auto w-full h-full">
         <div className="max-w-6xl mx-auto space-y-6">
            
            <header className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-4 border-b border-slate-200">
               <div>
                  <h1 className="text-2xl font-bold text-slate-900">Daftar Pendaftar</h1>
                  <p className="text-sm text-slate-500 mt-1">Kelola permohonan instalasi internet baru.</p>
               </div>
               
               <div className="relative w-full sm:w-72">
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <Search className="w-4 h-4" />
                  </div>
                  <input 
                    type="text"
                    placeholder="Cari nama atau telepon..."
                    className="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500"
                  />
               </div>
            </header>

            <div className="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
               <div className="overflow-x-auto">
                 <table className="w-full text-left text-sm whitespace-nowrap">
                   <thead className="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                     <tr>
                       <th className="px-6 py-4">Calon Pelanggan</th>
                       <th className="px-6 py-4">Kontak</th>
                       <th className="px-6 py-4">Lokasi & Alamat</th>
                       <th className="px-6 py-4">Tanggal Daftar</th>
                       <th className="px-6 py-4">Status</th>
                       <th className="px-6 py-4"></th>
                     </tr>
                   </thead>
                   <tbody className="divide-y divide-slate-100">
                     {isLoading ? (
                       <tr>
                         <td colSpan={6} className="px-6 py-12 text-center text-slate-500">
                           Memuat data pendaftar...
                         </td>
                       </tr>
                     ) : registrations.length === 0 ? (
                       <tr>
                         <td colSpan={6} className="px-6 py-12 text-center text-slate-500">
                           Belum ada pendaftaran baru.
                         </td>
                       </tr>
                     ) : (
                       registrations.map(reg => (
                         <tr key={reg.id} className="hover:bg-slate-50 transition">
                           <td className="px-6 py-4">
                             <div className="flex items-center gap-3">
                                <img src={reg.path_gambar} alt="Rumah" className="w-10 h-10 rounded-lg object-cover bg-slate-100 border border-slate-200" />
                                <div>
                                   <p className="font-bold text-slate-900">{reg.nama}</p>
                                   <p className="text-xs text-slate-500">{reg.id.slice(0, 8)}</p>
                                </div>
                             </div>
                           </td>
                           <td className="px-6 py-4">
                              <p className="font-medium text-slate-800">{reg.telp}</p>
                              <p className="text-xs text-slate-500">{reg.email}</p>
                           </td>
                           <td className="px-6 py-4 max-w-[200px] truncate">
                              <div className="flex items-center gap-1.5 text-blue-600 font-medium mb-0.5">
                                 <MapPin className="w-3.5 h-3.5" />
                                 <a href={`https://www.google.com/maps/search/?api=1&query=${reg.lat},${reg.long}`} target="_blank" rel="noreferrer" className="hover:underline">
                                    Lihat Peta
                                 </a>
                              </div>
                              <p className="text-xs text-slate-600 truncate" title={reg.alamat}>{reg.alamat}</p>
                           </td>
                           <td className="px-6 py-4">
                              <div className="flex items-center gap-1.5 text-slate-600">
                                <Calendar className="w-4 h-4 text-slate-400" />
                                {new Date(reg.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
                              </div>
                           </td>
                           <td className="px-6 py-4">
                              <span className={`inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ${
                                reg.status === 'pending' ? 'bg-amber-100 text-amber-700' :
                                reg.status === 'survey' ? 'bg-blue-100 text-blue-700' :
                                'bg-green-100 text-green-700'
                              }`}>
                                 {reg.status === 'pending' ? 'Menunggu' :
                                  reg.status === 'survey' ? 'Dijadwalkan Survey' :
                                  'Terpasang'}
                              </span>
                           </td>
                           <td className="px-6 py-4 text-right">
                              <button className="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                <ChevronRight className="w-5 h-5" />
                              </button>
                           </td>
                         </tr>
                       ))
                     )}
                   </tbody>
                 </table>
               </div>
            </div>

         </div>
      </main>
    </div>
  );
}
