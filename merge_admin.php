<?php

$files = [
    'dashboard' => 'Admin page/dashboard.php',
    'pendaftaran' => 'Admin page/pendaftar.php',
    'paket' => 'Admin page/paket.php',
    'pengumuman' => 'Admin page/pengumuman.php',
    'promosi' => 'Admin page/promosi.php',
];

$combinedHtml = "<!DOCTYPE html>\n<html lang=\"id\">\n<head>\n";
$combinedHtml .= "  <meta charset=\"UTF-8\">\n";
$combinedHtml .= "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
$combinedHtml .= "  <title>R-NET Admin</title>\n";
$combinedHtml .= "  <script src=\"https://cdn.tailwindcss.com\"></script>\n";
$combinedHtml .= "  <script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>\n";
$combinedHtml .= "  <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.8/index.min.css\">\n";
$combinedHtml .= "  <style>\n";
$combinedHtml .= "    body { font-family: 'Inter', sans-serif; }\n";
$combinedHtml .= "    ::-webkit-scrollbar { width: 6px; height: 6px; }\n";
$combinedHtml .= "    ::-webkit-scrollbar-track { background: #f1f5f9; }\n";
$combinedHtml .= "    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }\n";
$combinedHtml .= "    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }\n";
$combinedHtml .= "    .sidebar-active { background-color: rgba(255,255,255,0.1); }\n";
$combinedHtml .= "    .dropdown-menu { opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.2s ease; }\n";
$combinedHtml .= "    .dropdown-menu.show { opacity: 1; visibility: visible; transform: translateY(0); }\n";
$combinedHtml .= "    .modal-overlay { background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); }\n";
$combinedHtml .= "    .modal-content { transition: all 0.2s ease-out; opacity: 0; transform: scale(0.95); pointer-events: none; }\n";
$combinedHtml .= "    .modal-content.show { opacity: 1; transform: scale(1); pointer-events: auto; }\n";
$combinedHtml .= "    .promo-gradient { background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%); }\n";
$combinedHtml .= "    .promo-gradient-alt { background: linear-gradient(135deg, #fbbf24 0%, #f97316 100%); }\n";
$combinedHtml .= "    .tab-content { display: none; }\n";
$combinedHtml .= "    .tab-content.active { display: flex; }\n";
$combinedHtml .= "  </style>\n";
$combinedHtml .= "</head>\n";
$combinedHtml .= "<body class=\"bg-gray-50 text-slate-800 h-screen flex overflow-hidden\">\n";

// Get Sidebar from dashboard.php
$dashboardContent = file_get_contents($files['dashboard']);
preg_match('/<!-- Sidebar -->(.*?)<!-- Main Content -->/s', $dashboardContent, $sidebarMatches);
$sidebar = $sidebarMatches[1];

// Update Sidebar Links to use onclick
$sidebar = preg_replace('/href="#"\s+class="sidebar-active(.*?)"/', 'href="#" onclick="showTab(\'dashboard\'); return false;" class="sidebar-item sidebar-active$1" id="nav-dashboard"', $sidebar);
$sidebar = preg_replace('/href="#"\s+class="(.*?)"(.*?)(<span.*?>Pendaftaran<\/span>)/s', 'href="#" onclick="showTab(\'pendaftaran\'); return false;" class="sidebar-item $1"$2$3', $sidebar);
$sidebar = preg_replace('/href="#"\s+class="(.*?)"(.*?)(<span.*?>Paket Internet<\/span>)/s', 'href="#" onclick="showTab(\'paket\'); return false;" class="sidebar-item $1"$2$3', $sidebar);
$sidebar = preg_replace('/href="#"\s+class="(.*?)"(.*?)(<span.*?>Pengumuman<\/span>)/s', 'href="#" onclick="showTab(\'pengumuman\'); return false;" class="sidebar-item $1"$2$3', $sidebar);
$sidebar = preg_replace('/href="#"\s+class="(.*?)"(.*?)(<span.*?>Promosi<\/span>)/s', 'href="#" onclick="showTab(\'promosi\'); return false;" class="sidebar-item $1"$2$3', $sidebar);

// We need to add IDs to sidebar items for easy active class toggling
$sidebar = str_replace('sidebar-item flex', 'sidebar-item flex', $sidebar);
$sidebar = preg_replace('/onclick="showTab\(\'([a-z]+)\'\); return false;" class="sidebar-item/', 'onclick="showTab(\'$1\'); return false;" id="nav-$1" class="sidebar-item', $sidebar);


$combinedHtml .= "  <!-- Sidebar -->\n" . $sidebar . "\n";
$combinedHtml .= "  <!-- Main Content Area -->\n";
$combinedHtml .= "  <main class=\"flex-1 flex flex-col overflow-hidden relative\">\n";

// Get Header from dashboard.php
preg_match('/<!-- Header -->(.*?)<!-- Scrollable Content/s', $dashboardContent, $headerMatches);
$header = $headerMatches[1];
$combinedHtml .= "    <!-- Header -->\n" . $header . "\n";

$combinedScripts = "";

// Extract Content and Modals and Scripts
foreach ($files as $tabId => $file) {
    $content = file_get_contents($file);

    // Extract main scrollable content
    preg_match('/<!-- Scrollable Content.*?-->(.*?)<\/main>/s', $content, $mainMatches);
    $mainContent = isset($mainMatches[1]) ? trim($mainMatches[1]) : '';

    // Extract Modals (anything between </main> and <script>)
    preg_match('/<\/main>(.*?)<script>/s', $content, $modalMatches);
    $modals = isset($modalMatches[1]) ? trim($modalMatches[1]) : '';

    // Rename modal IDs to prevent collision
    $modals = str_replace('id="formModal"', 'id="formModal_' . $tabId . '"', $modals);
    $modals = str_replace('id="deleteModal"', 'id="deleteModal_' . $tabId . '"', $modals);
    $modals = str_replace('id="detailModal"', 'id="detailModal_' . $tabId . '"', $modals);

    $modals = str_replace("openModal('formModal')", "openModal('formModal_" . $tabId . "')", $modals);
    $modals = str_replace("closeModal('formModal')", "closeModal('formModal_" . $tabId . "')", $modals);
    $modals = str_replace("openModal('deleteModal')", "openModal('deleteModal_" . $tabId . "')", $modals);
    $modals = str_replace("closeModal('deleteModal')", "closeModal('deleteModal_" . $tabId . "')", $modals);
    $modals = str_replace("openModal('detailModal')", "openModal('detailModal_" . $tabId . "')", $modals);
    $modals = str_replace("closeModal('detailModal')", "closeModal('detailModal_" . $tabId . "')", $modals);

    // Extract Script
    preg_match('/<script>(.*?)<\/script>/s', $content, $scriptMatches);
    $script = isset($scriptMatches[1]) ? trim($scriptMatches[1]) : '';

    // Fix modal references in scripts
    $script = str_replace("'formModal'", "'formModal_" . $tabId . "'", $script);
    $script = str_replace("'deleteModal'", "'deleteModal_" . $tabId . "'", $script);
    $script = str_replace("'detailModal'", "'detailModal_" . $tabId . "'", $script);

    // Remove duplicate modal logic from scripts (keep only one)
    if ($tabId != 'dashboard') {
        $script = preg_replace('/function openModal\(modalId\).*?\}\s*function closeModal\(modalId\).*?\}/s', '', $script);
    }

    // Wrap script in IIFE to prevent variable collisions
    $combinedScripts .= "\n    // --- Script for $tabId ---\n";
    $combinedScripts .= "    (function() {\n";
    $combinedScripts .= "      " . str_replace("\n", "\n      ", $script) . "\n";
    $combinedScripts .= "    })();\n";

    $activeClass = ($tabId == 'dashboard') ? 'active' : '';

    $combinedHtml .= "    <!-- Tab Content: $tabId -->\n";
    $combinedHtml .= "    <div id=\"tab-$tabId\" class=\"tab-content flex-1 overflow-y-auto flex-col $activeClass w-full\">\n";
    $combinedHtml .= "      " . $mainContent . "\n";
    $combinedHtml .= "    </div>\n\n";

    if ($modals) {
        $combinedHtml .= "    <!-- Modals for $tabId -->\n";
        $combinedHtml .= "    <div id=\"modals-$tabId\" class=\"tab-content flex-col $activeClass\">\n";
        $combinedHtml .= "      " . $modals . "\n";
        $combinedHtml .= "    </div>\n\n";
    }
}

$combinedHtml .= "  </main>\n";

// Modal functions
$baseModalScript = "
    function openModal(modalId) {
      const overlay = document.getElementById(modalId);
      if(!overlay) return;
      const modal = overlay.querySelector('.modal-content');
      overlay.classList.remove('hidden');
      setTimeout(() => {
        if(modal) modal.classList.add('show');
      }, 10);
    }

    function closeModal(modalId) {
      const overlay = document.getElementById(modalId);
      if(!overlay) return;
      const modal = overlay.querySelector('.modal-content');
      if(modal) modal.classList.remove('show');
      setTimeout(() => {
        overlay.classList.add('hidden');
      }, 200);
    }

    function showTab(tabId) {
      // Hide all tabs
      document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.remove('active');
      });
      // Show target tab and its modals
      const targetTab = document.getElementById('tab-' + tabId);
      if(targetTab) targetTab.classList.add('active');
      const targetModals = document.getElementById('modals-' + tabId);
      if(targetModals) targetModals.classList.add('active');

      // Update sidebar active state
      document.querySelectorAll('.sidebar-item').forEach(el => {
        el.classList.remove('sidebar-active');
        el.classList.remove('bg-white', 'bg-opacity-10');
      });
      const activeNav = document.getElementById('nav-' + tabId);
      if(activeNav) {
        activeNav.classList.add('sidebar-active');
      }

      // Update Title
      const titles = {
        'dashboard': 'Dasbor',
        'pendaftaran': 'Pendaftaran',
        'paket': 'Paket Internet',
        'pengumuman': 'Pengumuman',
        'promosi': 'Promosi'
      };
      const headerTitle = document.querySelector('header h2');
      if(headerTitle && titles[tabId]) headerTitle.innerText = titles[tabId];
    }
";

$combinedHtml .= "  <script>\n" . $baseModalScript . $combinedScripts . "\n  </script>\n";
$combinedHtml .= "</body>\n</html>";

file_put_contents('resources/views/admin.blade.php', $combinedHtml);
echo "Berhasil menggabungkan file ke resources/views/admin.blade.php\n";

?>
