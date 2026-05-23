{{-- resources/views/admin/hotspots.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PeaceLink | Zones sensibles</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: #F1F5F9;
        }
        
        /* Sidebar styles */
        .sidebar {
            background: linear-gradient(180deg, #0F172A 0%, #1E293B 100%);
            transition: all 0.3s ease;
        }
        
        .sidebar-link {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        
        .sidebar-link:hover {
            background: rgba(249, 115, 22, 0.1);
            border-left-color: #F97316;
        }
        
        .sidebar-link.active {
            background: rgba(249, 115, 22, 0.15);
            border-left-color: #F97316;
            color: #F97316;
        }
        
        #map {
            height: 550px;
            border-radius: 20px;
            z-index: 1;
        }
        
        /* Pulse animation pour les nouveaux marqueurs */
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.3);
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .pulse-marker {
            animation: pulse 0.8s ease-in-out 2;
        }
        
        /* Live indicator */
        .live-badge {
            animation: blink 1.5s infinite;
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        
        /* Scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #F97316;
            border-radius: 10px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .menu-toggle {
                display: block;
            }
            #map {
                height: 400px;
            }
        }
        
        @media (min-width: 769px) {
            .menu-toggle {
                display: none;
            }
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    
    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar w-72 flex-shrink-0 text-white flex flex-col h-full overflow-y-auto fixed md:relative z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <!-- Logo -->
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#F97316]/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shield-alt text-[#F97316] text-xl"></i>
                </div>
                <div>
                    <div class="text-xl font-bold">
                        <span class="text-[#F97316]">Peace</span>Link
                    </div>
                    <div class="text-xs text-gray-400">Administration</div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 py-6">
            <div class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Principal</div>
            <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="{{ route('admin.signals') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-flag w-5"></i>
                <span>Signalements</span>
            </a>
            <a href="{{ route('admin.hotspots') }}" class="sidebar-link active flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-map-marker-alt w-5"></i>
                <span>Zones sensibles</span>
            </a>
            <a href="{{ route('admin.artisans') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-users w-5"></i>
                <span>Artisans de la paix</span>
            </a>
            
            <div class="px-4 mt-6 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Analyse</div>
            <a href="{{ route('admin.statistics') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-chart-line w-5"></i>
                <span>Statistiques</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-download w-5"></i>
                <span>Rapports</span>
            </a>
            
            <div class="px-4 mt-6 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Administration</div>
            <a href="{{ route('admin.admins') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-user-shield w-5"></i>
                <span>Administrateurs</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-cog w-5"></i>
                <span>Paramètres</span>
            </a>
        </nav>
        
        <!-- Footer sidebar -->
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-[#F97316]/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-[#F97316] text-sm"></i>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-semibold">{{ Auth::user()->name ?? 'Administrateur' }}</div>
                    <div class="text-xs text-gray-400">{{ Auth::user()->email ?? 'admin@peacelink.tg' }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-white transition">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>
    
    <!-- Bouton menu mobile -->
    <button id="menuToggle" class="menu-toggle fixed top-4 left-4 z-50 bg-[#F97316] p-2 rounded-lg shadow-lg text-white">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto bg-[#F8FAFC] w-full">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
            <div class="px-4 md:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-[#0F172A]">Zones sensibles</h1>
                        <p class="text-xs md:text-sm text-gray-500 mt-1">Visualisation temps réel des zones à risque</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 bg-green-100 px-3 py-1 rounded-full">
                            <span class="live-badge w-2 h-2 bg-green-500 rounded-full"></span>
                            <span class="text-xs text-green-700 font-semibold">Temps réel</span>
                        </div>
                        <div class="relative">
                            <i class="fas fa-bell text-gray-400 cursor-pointer hover:text-[#F97316] transition"></i>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                        </div>
                        <div class="hidden md:flex items-center gap-2">
                            <div class="text-right">
                                <div class="text-xs text-gray-400">Dernière mise à jour</div>
                                <div class="text-sm font-semibold" id="lastUpdate">--:--:--</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="px-4 md:px-8 py-6">
            
            <!-- STATS CARDS EN TEMPS RÉEL -->
            <div class="grid md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-4 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-xs">Total signalements</p>
                            <h2 class="text-2xl font-bold text-[#0F172A]" id="totalReports">0</h2>
                        </div>
                        <i class="fas fa-flag text-3xl text-[#F97316] opacity-30"></i>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-4 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-xs">Zones critiques</p>
                            <h2 class="text-2xl font-bold text-red-500" id="criticalReports">0</h2>
                        </div>
                        <i class="fas fa-radiation text-3xl text-red-500 opacity-30"></i>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-4 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-xs">Zones à risque</p>
                            <h2 class="text-2xl font-bold text-orange-500" id="highReports">0</h2>
                        </div>
                        <i class="fas fa-exclamation-triangle text-3xl text-orange-500 opacity-30"></i>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-4 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-xs">Zones modérées</p>
                            <h2 class="text-2xl font-bold text-yellow-500" id="mediumReports">0</h2>
                        </div>
                        <i class="fas fa-chart-line text-3xl text-yellow-500 opacity-30"></i>
                    </div>
                </div>
            </div>
            
            <!-- LÉGENDE -->
            <div class="bg-white rounded-xl shadow-sm p-3 mb-4 flex flex-wrap items-center justify-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-red-500"></div>
                    <span class="text-xs text-gray-600">Critique (≥80%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-orange-500"></div>
                    <span class="text-xs text-gray-600">Élevé (60-79%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-yellow-500"></div>
                    <span class="text-xs text-gray-600">Modéré (30-59%)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-green-500"></div>
                    <span class="text-xs text-gray-600">Faible (&lt;30%)</span>
                </div>
                <div class="flex items-center gap-2 ml-4 border-l pl-4 border-gray-200">
                    <i class="fas fa-circle text-blue-500 text-xs"></i>
                    <span class="text-xs text-gray-600">Nouveau signalement</span>
                </div>
            </div>
            
            <!-- MAP -->
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <div id="map"></div>
            </div>
            
            <!-- DERNIERS SIGNALEMENTS EN TEMPS RÉEL -->
            <div class="bg-white rounded-xl shadow-sm mt-6">
                <div class="p-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-[#0F172A]">
                            <i class="fas fa-clock text-[#F97316] mr-2"></i>
                            Derniers signalements en temps réel
                        </h3>
                        <span class="text-xs text-gray-400" id="recentListUpdate">--:--:--</span>
                    </div>
                </div>
                <div class="p-4 max-h-64 overflow-y-auto" id="recentReportsList">
                    <div class="text-center py-4 text-gray-500">Chargement...</div>
                </div>
            </div>
            
        </div>
    </main>
    
    <script>
        // Menu mobile toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
            
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 768) {
                    if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                        sidebar.classList.add('-translate-x-full');
                    }
                }
            });
        }
        
        // Configuration de la carte
        const map = L.map('map').setView([6.1319, 1.2228], 7);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributeurs',
            maxZoom: 19
        }).addTo(map);
        
        // Stockage des marqueurs
        let markers = {};
        let lastUpdateTime = null;
        let refreshInterval = null;
        
        // Fonction pour obtenir la couleur en fonction du niveau de danger
        function getColorByDangerLevel(dangerLevel) {
            if (dangerLevel >= 80) return 'red';
            if (dangerLevel >= 60) return 'orange';
            if (dangerLevel >= 30) return 'yellow';
            return 'green';
        }
        
        // Fonction pour obtenir la taille en fonction du niveau de danger
        function getRadiusByDangerLevel(dangerLevel) {
            if (dangerLevel >= 80) return 16;
            if (dangerLevel >= 60) return 13;
            if (dangerLevel >= 30) return 10;
            return 8;
        }
        
        // Mettre à jour l'heure de dernière mise à jour
        function updateLastUpdateTime() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('fr-FR');
            document.getElementById('lastUpdate').innerText = timeStr;
            document.getElementById('recentListUpdate').innerText = timeStr;
        }
        
        // Mettre à jour les statistiques
        function updateStats(reports) {
            const total = reports.length;
            const critical = reports.filter(r => r.danger_level >= 80).length;
            const high = reports.filter(r => r.danger_level >= 60 && r.danger_level < 80).length;
            const medium = reports.filter(r => r.danger_level >= 30 && r.danger_level < 60).length;
            
            document.getElementById('totalReports').innerText = total;
            document.getElementById('criticalReports').innerText = critical;
            document.getElementById('highReports').innerText = high;
            document.getElementById('mediumReports').innerText = medium;
        }
        
        // Mettre à jour la liste des derniers signalements
        function updateRecentReportsList(reports) {
            const container = document.getElementById('recentReportsList');
            const recentReports = [...reports]
                .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                .slice(0, 10);
            
            if (recentReports.length === 0) {
                container.innerHTML = '<div class="text-center py-4 text-gray-500">Aucun signalement récent</div>';
                return;
            }
            
            container.innerHTML = recentReports.map(report => {
                let dangerClass = '';
                if (report.danger_level >= 80) dangerClass = 'text-red-600 bg-red-50';
                else if (report.danger_level >= 60) dangerClass = 'text-orange-600 bg-orange-50';
                else if (report.danger_level >= 30) dangerClass = 'text-yellow-600 bg-yellow-50';
                else dangerClass = 'text-green-600 bg-green-50';
                
                const date = new Date(report.created_at);
                const timeStr = date.toLocaleTimeString('fr-FR');
                const dateStr = date.toLocaleDateString('fr-FR');
                
                return `
                    <div class="border-b border-gray-100 last:border-0 py-3 hover:bg-gray-50 transition cursor-pointer" onclick="zoomToReport(${report.latitude}, ${report.longitude})">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-semibold text-gray-500">#${report.id}</span>
                                    <span class="text-sm font-semibold text-[#0F172A]">${escapeHtml(report.type)}</span>
                                    <span class="text-xs text-gray-400">${escapeHtml(report.zone)} - ${escapeHtml(report.district)}</span>
                                </div>
                                <p class="text-sm text-gray-600 line-clamp-1">${escapeHtml(report.description.substring(0, 80))}${report.description.length > 80 ? '...' : ''}</p>
                            </div>
                            <div class="ml-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold ${dangerClass}">${report.danger_level}%</span>
                            </div>
                        </div>
                        <div class="text-xs text-gray-400 mt-1">
                            <i class="far fa-clock mr-1"></i>${dateStr} à ${timeStr}
                        </div>
                    </div>
                `;
            }).join('');
        }
        
        // Mettre à jour la carte
        function updateMap(reports, newReportIds = []) {
            const currentMarkerIds = new Set(Object.keys(markers));
            const newMarkerIds = new Set();
            
            reports.forEach(report => {
                newMarkerIds.add(report.id.toString());
                const id = report.id;
                const lat = parseFloat(report.latitude);
                const lng = parseFloat(report.longitude);
                const color = getColorByDangerLevel(report.danger_level);
                const radius = getRadiusByDangerLevel(report.danger_level);
                
                if (markers[id]) {
                    // Mettre à jour le marqueur existant
                    markers[id].setStyle({
                        fillColor: color,
                        radius: radius
                    });
                    markers[id]._popup.setContent(getPopupContent(report));
                } else {
                    // Créer un nouveau marqueur
                    const marker = L.circleMarker([lat, lng], {
                        radius: radius,
                        fillColor: color,
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.9
                    }).addTo(map);
                    
                    marker.bindPopup(getPopupContent(report));
                    
                    // Ajouter une animation pulse pour les nouveaux signalements
                    if (newReportIds.includes(id)) {
                        marker._icon.classList.add('pulse-marker');
                        setTimeout(() => {
                            marker._icon.classList.remove('pulse-marker');
                        }, 1000);
                    }
                    
                    markers[id] = marker;
                }
            });
            
            // Supprimer les marqueurs qui n'existent plus
            for (const id of currentMarkerIds) {
                if (!newMarkerIds.has(id)) {
                    map.removeLayer(markers[id]);
                    delete markers[id];
                }
            }
        }
        
        // Générer le contenu de la popup
        function getPopupContent(report) {
            let riskColor = '';
            let riskText = '';
            if (report.danger_level >= 80) { riskColor = '#DC2626'; riskText = 'Critique'; }
            else if (report.danger_level >= 60) { riskColor = '#EA580C'; riskText = 'Élevé'; }
            else if (report.danger_level >= 30) { riskColor = '#D97706'; riskText = 'Modéré'; }
            else { riskColor = '#059669'; riskText = 'Faible'; }
            
            const date = new Date(report.created_at);
            const dateStr = date.toLocaleDateString('fr-FR');
            const timeStr = date.toLocaleTimeString('fr-FR');
            
            return `
                <div style="width: 260px; font-family: Inter, sans-serif;">
                    <h3 style="font-weight: bold; font-size: 16px; margin-bottom: 8px; color: #0F172A;">
                        ${escapeHtml(report.type)}
                    </h3>
                    <div style="margin-bottom: 8px;">
                        <span style="background: ${riskColor}20; color: ${riskColor}; padding: 2px 8px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                            ⚠️ ${riskText} - ${report.danger_level}%
                        </span>
                    </div>
                    <p style="margin: 8px 0; font-size: 13px; color: #475569;">
                        <i class="fas fa-map-marker-alt" style="color: #F97316; margin-right: 6px;"></i>
                        ${escapeHtml(report.zone)} - ${escapeHtml(report.district)}
                    </p>
                    <p style="margin: 8px 0; font-size: 13px; color: #475569;">
                        <i class="fas fa-align-left" style="color: #F97316; margin-right: 6px;"></i>
                        ${escapeHtml(report.description.substring(0, 100))}${report.description.length > 100 ? '...' : ''}
                    </p>
                    <p style="margin-top: 8px; font-size: 11px; color: #94A3B8;">
                        <i class="far fa-calendar-alt"></i> ${dateStr} à ${timeStr}
                    </p>
                    <hr style="margin: 8px 0; border-color: #E2E8F0;">
                    <button onclick="window.location.href='/admin/signalements/${report.id}'" style="background: #F97316; color: white; border: none; padding: 4px 12px; border-radius: 20px; font-size: 11px; cursor: pointer; width: 100%;">
                        Voir les détails →
                    </button>
                </div>
            `;
        }
        
        // Fonction pour zoomer sur un signalement
        function zoomToReport(lat, lng) {
            map.setView([lat, lng], 15);
        }
        
        // Échappement HTML
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Charger les données depuis l'API
        let lastReportIds = [];
        
        async function fetchHotspotsData() {
            try {
                const response = await fetch('/admin/api/hotspots-data');
                const data = await response.json();
                
                if (data.success) {
                    // Détecter les nouveaux signalements
                    const newReportIds = [];
                    if (lastReportIds.length > 0 && data.reports) {
                        const currentIds = new Set(data.reports.map(r => r.id));
                        for (const id of currentIds) {
                            if (!lastReportIds.includes(id)) {
                                newReportIds.push(id);
                            }
                        }
                    }
                    lastReportIds = data.reports.map(r => r.id);
                    
                    updateStats(data.reports);
                    updateRecentReportsList(data.reports);
                    updateMap(data.reports, newReportIds);
                    updateLastUpdateTime();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des données:', error);
            }
        }
        
        // Initialisation et rafraîchissement automatique (toutes les 10 secondes)
        fetchHotspotsData();
        refreshInterval = setInterval(fetchHotspotsData, 10000);
        
        // Nettoyer l'intervalle lors de la fermeture de la page
        window.addEventListener('beforeunload', () => {
            if (refreshInterval) clearInterval(refreshInterval);
        });
        
        // Exposer zoomToReport globalement
        window.zoomToReport = zoomToReport;
    </script>
</body>
</html>