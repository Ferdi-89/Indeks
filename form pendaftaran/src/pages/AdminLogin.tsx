import React, { useState } from 'react';
import { useLocation } from 'wouter';
import { Lock, Mail, Server } from 'lucide-react';
import toast, { Toaster } from 'react-hot-toast';
import { getSupabase } from '../lib/supabase';

export default function AdminLogin() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [, setLocation] = useLocation();

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);

    try {
      const supabase = getSupabase();
      if (!supabase) {
        // Mock success for preview without supabase
        setTimeout(() => {
            localStorage.setItem('mockAdminAuth', 'true');
            // Dispatch storage event to trigger cross/same-tab state sync if we wanted, or just reload/navigate
            window.dispatchEvent(new Event('storage'));
            toast.success("Mock login success! (Supabase not configured)");
            setIsLoading(false);
            window.location.href = '/admin'; // Force reload to ensure state pick up
        }, 1000);
        return;
      }

      const { error } = await supabase.auth.signInWithPassword({
        email,
        password,
      });

      if (error) {
        throw error;
      }

      toast.success("Login berhasil");
      setLocation('/admin');
    } catch (error: any) {
      toast.error(error.message || "Gagal login");
      setIsLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-slate-50 flex items-center justify-center p-4 font-sans">
      <Toaster position="top-center" />
      <div className="max-w-md w-full bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <div className="text-center mb-8">
          <div className="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <Server className="w-8 h-8" />
          </div>
          <h1 className="text-2xl font-bold text-slate-900 tracking-tight">Login Admin</h1>
          <p className="text-sm text-slate-500 mt-2">Masuk ke dashboard R-NET Internet Rakyat.</p>
        </div>

        <form onSubmit={handleLogin} className="space-y-5">
          <div className="space-y-2">
            <label className="text-sm font-semibold text-slate-700">Email Admin</label>
            <div className="relative">
              <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <Mail className="w-5 h-5" />
              </div>
              <input 
                type="email"
                required
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                className="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                placeholder="admin@r-net.com"
              />
            </div>
          </div>

          <div className="space-y-2">
            <label className="text-sm font-semibold text-slate-700">Kata Sandi</label>
            <div className="relative">
              <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <Lock className="w-5 h-5" />
              </div>
              <input 
                type="password"
                required
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                placeholder="••••••••"
              />
            </div>
          </div>

          <div className="pt-2">
            <button 
               type="submit" 
               disabled={isLoading}
               className="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 rounded-xl transition shadow disabled:opacity-70 disabled:cursor-not-allowed"
            >
              {isLoading ? 'Memproses...' : 'Masuk Dashboard'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
