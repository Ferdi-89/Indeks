import { Route, Switch, useLocation } from "wouter";
import Registration from "./pages/Registration";
import AdminLogin from "./pages/AdminLogin";
import AdminDashboard from "./pages/AdminDashboard";
import { useEffect, useState } from "react";
import { getSupabase } from "./lib/supabase";

export default function App() {
  const [isAdminAuth, setIsAdminAuth] = useState<boolean | null>(null);

  useEffect(() => {
    const checkAuth = async () => {
      const supabase = getSupabase();
      if (!supabase) {
        // Mock auth state for preview
        setIsAdminAuth(localStorage.getItem('mockAdminAuth') === 'true');
        return;
      }
      const { data: { session } } = await supabase.auth.getSession();
      setIsAdminAuth(!!session);

      const { data: { subscription } } = supabase.auth.onAuthStateChange((_event, session) => {
        setIsAdminAuth(!!session);
      });

      return () => {
        subscription.unsubscribe();
      };
    };
    checkAuth();
  }, []);

  return (
    <Switch>
      <Route path="/" component={Registration} />
      <Route path="/admin">
        {() => (
          <AdminAuthWrapper isAuthenticated={isAdminAuth}>
            <AdminDashboard />
          </AdminAuthWrapper>
        )}
      </Route>
      <Route path="/admin/login" component={AdminLogin} />
      
      {/* Default redirect for unknown paths */}
      <Route>
        {() => {
           window.location.href = "/";
           return null;
        }}
      </Route>
    </Switch>
  );
}

function AdminAuthWrapper({ isAuthenticated, children }: { isAuthenticated: boolean | null, children: React.ReactNode }) {
  const [, setLocation] = useLocation();

  useEffect(() => {
    if (isAuthenticated === false) {
      setLocation('/admin/login');
    }
  }, [isAuthenticated, setLocation]);

  if (isAuthenticated === null) {
    return <div className="min-h-screen flex items-center justify-center bg-slate-50"><p className="text-slate-500 font-medium">Memeriksa sesi...</p></div>;
  }

  if (isAuthenticated === false) {
    return null; // Will redirect in useEffect
  }

  return <>{children}</>;
}
