import { createClient } from '@supabase/supabase-js';

const supabaseUrl = import.meta.env.VITE_SUPABASE_URL;
const supabaseAnonKey = import.meta.env.VITE_SUPABASE_ANON_KEY;

export const getSupabase = () => {
    if (!supabaseUrl || !supabaseAnonKey || supabaseUrl.includes('your-project')) {
        console.warn("Supabase credentials are not set correctly. File upload will be simulated.");
        return null;
    }
    return createClient(supabaseUrl, supabaseAnonKey);
};
