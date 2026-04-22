import React, { useState, useEffect, useRef, useCallback } from 'react';
import { MapContainer, TileLayer, useMapEvents, useMap } from 'react-leaflet';
import { Navigation, MapPin } from 'lucide-react';
import 'leaflet/dist/leaflet.css';

interface MapPickerProps {
  position: [number, number] | null;
  setPosition: (pos: [number, number]) => void;
  setAddress: (addr: string, isFromMap: boolean) => void;
}

const MapEventHandler = ({ onMove, onMoveEnd, setMapReady }: any) => {
  const map = useMap();
  
  useEffect(() => { 
    setMapReady(map); 
    // Fix for "grey map error" where tiles fail to load immediately 
    // by invalidating the size shortly after the map is mounted
    const timer = setTimeout(() => {
      map.invalidateSize();
    }, 250);
    return () => clearTimeout(timer);
  }, [map, setMapReady]);

  useMapEvents({
    dragstart: onMove,
    zoomstart: onMove,
    moveend: (e) => {
      const center = e.target.getCenter();
      onMoveEnd([center.lat, center.lng]);
    }
  });
  return null;
};

export default function MapPicker({ position, setPosition, setAddress }: MapPickerProps) {
  const defaultPos: [number, number] = [-2.034698, 101.388856]; // Default to Kp. Tengah, Koto Baru, Sungai Penuh
  const [mapInstance, setMapInstance] = useState<any>(null);
  const [isDragging, setIsDragging] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  
  const [tempCenter, setTempCenter] = useState<[number, number]>(position || defaultPos);
  const [tempAddr, setTempAddr] = useState<string>('');
  const initRef = useRef(false);

  // If the parent updates position automatically (e.g. from typing)
  useEffect(() => {
    if (position) {
      setTempCenter(position);
      if (mapInstance && (!initRef.current || position[0] !== tempCenter[0] || position[1] !== tempCenter[1])) {
        mapInstance.flyTo(position, 16);
      }
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [position, mapInstance]);

  const fetchAddress = async (lat: number, lon: number) => {
    setIsLoading(true);
    // Explicitly update parent's position coordinate immediately is REVERTED, only update local
    try {
      const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1&email=admin@r-net.com`, {
         headers: { 'Accept-Language': 'id-ID,id;q=0.9' }
      });
      if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
      const data = await res.json();
      if (data && data.address) {
        const addr = data.address;
        const parts = [];
        
        // Custom formatting to mimic Google Maps Indonesian structure
        const localName = addr.road || addr.hamlet || addr.neighbourhood || addr.residential;
        if (localName) parts.push(localName);
        
        const village = addr.village || addr.suburb || addr.town;
        if (village && village !== localName) parts.push(village);
        
        // Many openstreetmap districts don't include the word "Kec."
        const district = addr.city_district || addr.county;
        if (district) parts.push(district.toLowerCase().includes('kec') ? district : `Kec. ${district}`);
        
        const city = addr.city || addr.municipality || addr.state_district;
        if (city) {
            // Avoid repeating if city and district have exactly the same name in OSM DB
            if (!parts[parts.length - 1]?.includes(city)) {
                parts.push(city);
            }
        }
        
        const state = addr.state || addr.region;
        if (state) parts.push(state);
        
        let formattedAddress = parts.filter(Boolean).join(', ');
        if (addr.postcode) formattedAddress += ` ${addr.postcode}`;
        
        // Fallback to OSM default display format if parsing parts somehow fails
        if (!formattedAddress) formattedAddress = data.display_name;
        
        setTempAddr(`${lat.toFixed(6)}, ${lon.toFixed(6)}\n${formattedAddress}`);
      } else if (data && data.display_name) {
        setTempAddr(`${lat.toFixed(6)}, ${lon.toFixed(6)}\n${data.display_name}`);
      } else {
        setTempAddr('Gagal memuat alamat. Pastikan Anda tersambung internet.');
      }
    } catch (error) {
      console.warn("Geocoding API blocked (trying fallback):", error);
      // Fallback to BigDataCloud (free client-side reverse geocoding API)
      try {
         const fallbackRes = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=id`);
         const fallbackData = await fallbackRes.json();
         if (fallbackData && (fallbackData.locality || fallbackData.city)) {
             const parts = [
                 fallbackData.locality, 
                 fallbackData.city, 
                 fallbackData.principalSubdivision, 
                 fallbackData.countryName
             ].filter(Boolean);
             // Provide a simplified address if main API fails (to keep form working)
             setTempAddr(`${lat.toFixed(6)}, ${lon.toFixed(6)} - ${parts.join(', ')}`);
         }
      } catch (fallbackError) {
         setTempAddr("Pencarian lokasi gagal (Koneksi jaringan terganggu)");
      }
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    // Only auto-geofeature if we intentionally requested an initial load
    if (!initRef.current && position) {
      initRef.current = true;
      fetchAddress(position[0], position[1]);
    } else if (!initRef.current && !position) {
      initRef.current = true;
      // Let it wait for user interaction to set address so form is blank
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [position]);

  const handleMoveEnd = useCallback((newCenter: [number, number]) => {
    setIsDragging(false);
    setTempCenter(newCenter);
    // Fetch and auto-update coordinate and address instantly
    fetchAddress(newCenter[0], newCenter[1]);
  }, []);

  const getCurrentLocation = (e: React.MouseEvent) => {
    e.preventDefault();
    setIsLoading(true);
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          const { latitude, longitude } = pos.coords;
          if (mapInstance) {
            mapInstance.flyTo([latitude, longitude], 17);
          }
          setTempCenter([latitude, longitude]);
          fetchAddress(latitude, longitude);
        },
        () => {
          alert("Akses lokasi ditolak atau tidak tersedia pada perangkat Anda.");
          setIsLoading(false);
        },
        { enableHighAccuracy: true }
      );
    }
  };

  return (
    <div className="rounded-xl overflow-hidden border border-slate-200 shadow-sm z-0 w-full">
       <div className="relative h-[20rem] md:h-[24rem] w-full z-0 block">
           <MapContainer
          center={tempCenter}
          zoom={14}
          zoomControl={false}
          style={{ height: '100%', width: '100%' }}
       >
          <TileLayer
            url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            attribution='&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
          />
          <MapEventHandler
             onMove={() => setIsDragging(true)}
             onMoveEnd={handleMoveEnd}
             setMapReady={setMapInstance}
          />
       </MapContainer>

       {/* Fixed Center Pin overlay */}
       <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-full z-[400] drop-shadow-md pointer-events-none flex flex-col items-center">
           {isLoading && (
              <div className="absolute -top-8 bg-black/70 text-white text-[10px] px-2.5 py-1 rounded-md font-medium whitespace-nowrap mb-1 shadow">
                 Mencari alamat...
              </div>
           )}
           <div className={`transition-transform duration-200 ease-in-out ${isDragging ? '-translate-y-3' : 'translate-y-0'}`}>
              <svg width="42" height="42" viewBox="0 0 24 24" fill="#ef4444" stroke="white" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3" fill="white"></circle></svg>
           </div>
           {/* Small visual shadow dot directly on the coordinate center point */}
           <div className={`w-2.5 h-1 bg-black/30 rounded-full mt-1 blur-[1px] transition-opacity duration-200 ${isDragging ? 'opacity-50' : 'opacity-100'}`}></div>
       </div>

       {/* Use GPS Button */}
       <button
         title="Gunakan Lokasi Saat Ini (GPS)"
         onClick={getCurrentLocation}
         type="button"
         className="absolute bottom-4 right-4 z-[400] bg-white p-3 rounded-full shadow-lg border border-slate-100 text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition"
       >
         <Navigation className="w-5 h-5" />
       </button>
       </div>

       {/* Mobile-friendly Info & Confirmation Footer block */}
       <div className="bg-white p-4 md:px-5 md:py-4 z-10 shrink-0 flex flex-col md:flex-row gap-4 md:items-center relative border-t border-slate-200">
           <div className="flex items-start gap-3 flex-1 min-w-0">
               <MapPin className="text-red-500 w-5 h-5 shrink-0 mt-0.5" />
               <div className="flex-1 min-w-0">
                  <p className="text-[11px] md:text-xs font-bold text-slate-500 uppercase tracking-widest mb-0.5 md:mb-1">Alamat Terpilih</p>
                  <p className="text-sm font-medium text-slate-800 line-clamp-2 leading-snug">
                     {isLoading ? "Mencari lokasi di peta..." : (tempAddr || "Geser peta untuk menentukan area")}
                  </p>
               </div>
           </div>
           <button
              type="button"
              onClick={() => {
                 setPosition(tempCenter);
                 setAddress(tempAddr, true);
              }}
              disabled={isLoading || !tempAddr}
              className="w-full md:w-auto bg-[#1e40af] text-white py-2.5 px-6 rounded-lg font-semibold text-sm hover:bg-[#1e3a8a] transition disabled:opacity-60 disabled:cursor-not-allowed shadow-sm md:shrink-0 text-center"
           >
              Konfirmasi Alamat
           </button>
       </div>
    </div>
  )
}
