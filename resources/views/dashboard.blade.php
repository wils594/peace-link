{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PeaceLink | Dashboard Administrateur</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
        
        /* Stats cards */
        .stat-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }
        
        /* Artisan cards */
        .artisan-card {
            transition: all 0.2s ease;
            border: 1px solid #E2E8F0;
        }
        
        .artisan-card:hover {
            border-color: #F97316;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .btn-accept {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            transition: all 0.2s ease;
        }
        
        .btn-accept:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .btn-reject {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            transition: all 0.2s ease;
        }
        
        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        /* Table styles */
        .signal-table tbody tr {
            transition: all 0.2s ease;
        }
        
        .signal-table tbody tr:hover {
            background: #F8FAFC;
        }
        
        /* Badge styles */
        .badge-critical {
            background: #FEE2E2;
            color: #DC2626;
        }
        
        .badge-high {
            background: #FFEDD5;
            color: #EA580C;
        }
        
        .badge-medium {
            background: #FEF3C7;
            color: #D97706;
        }
        
        .badge-low {
            background: #D1FAE5;
            color: #059669;
        }
        
        .badge-pending {
            background: #FEF3C7;
            color: #D97706;
        }
        
        .badge-resolved {
            background: #D1FAE5;
            color: #059669;
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
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out;
        }
        
        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #F97316;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
            <a href="{{ route('dashboard') }}" class="sidebar-link active flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="{{ route('admin.signals') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-flag w-5"></i>
                <span>Signalements</span>
            </a>
            <a href="{{ route('admin.hotspots') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-map-marker-alt w-5"></i>
                <span>Zones sensibles</span>
            </a>
            <a href="{{ route('artisans') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
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
                        <h1 class="text-xl md:text-2xl font-bold text-[#0F172A]">Tableau de bord</h1>
                        <p class="text-xs md:text-sm text-gray-500 mt-1">Vue d'ensemble des signalements et activités</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <i class="fas fa-bell text-gray-400 cursor-pointer hover:text-[#F97316] transition"></i>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                        </div>
                        <div class="hidden md:flex items-center gap-2">
                            <div class="text-right">
                                <div class="text-xs text-gray-400">Dernière connexion</div>
                                <div class="text-sm font-semibold">{{ now()->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="px-4 md:px-8 py-6">
            
            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8 animate-fadeIn">
                <div class="stat-card bg-white rounded-xl p-4 md:p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 mb-1">Total signalements</p>
                            <p class="text-2xl md:text-3xl font-bold text-[#0F172A]" id="totalReports">0</p>
                            <p class="text-xs text-green-600 mt-2" id="reportGrowthText">
                                <i class="fas fa-chart-line"></i> <span id="reportGrowth">0</span>% vs mois dernier
                            </p>
                        </div>
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-flag text-[#F97316] text-lg md:text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-xl p-4 md:p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 mb-1">Signalements résolus</p>
                            <p class="text-2xl md:text-3xl font-bold text-green-600" id="resolvedReports">0</p>
                            <p class="text-xs text-gray-500 mt-2">Taux de résolution: <span id="resolutionRate">0</span>%</p>
                        </div>
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-lg md:text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-xl p-4 md:p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 mb-1">En cours de traitement</p>
                            <p class="text-2xl md:text-3xl font-bold text-orange-500" id="pendingReports">0</p>
                            <p class="text-xs text-gray-500 mt-2">Délai moyen: <span id="avgResponseTime">0</span>h</p>
                        </div>
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-spinner text-orange-500 text-lg md:text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card bg-white rounded-xl p-4 md:p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 mb-1">Artisans de la paix</p>
                            <p class="text-2xl md:text-3xl font-bold text-blue-600" id="activeArtisans">0</p>
                            <p class="text-xs text-gray-500 mt-2">+<span id="newArtisans">0</span> ce mois</p>
                        </div>
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-hand-peace text-blue-600 text-lg md:text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- DEMANDES ARTISANS DE PAIX EN ATTENTE -->
            <div class="bg-white rounded-xl shadow-sm animate-fadeIn mb-8">
                <div class="p-4 md:p-6 border-b border-gray-100">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <h3 class="font-bold text-[#0F172A] text-lg md:text-xl">Demandes artisans de paix</h3>
                            <p class="text-xs md:text-sm text-gray-500 mt-1">Candidatures en attente de validation</p>
                        </div>
                        <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-semibold" id="pendingCount">0 en attente</span>
                    </div>
                </div>
                <div class="p-4 md:p-6" id="pendingArtisansList">
                    <div class="text-center py-8">
                        <div class="loading-spinner"></div>
                        <p class="text-gray-500 mt-3">Chargement des demandes...</p>
                    </div>
                </div>
            </div>
            
            <!-- CHARTS SECTION -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-8 animate-fadeIn">
                <div class="bg-white rounded-xl p-4 md:p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
                        <h3 class="font-bold text-[#0F172A]">Évolution des signalements</h3>
                        <select id="chartPeriod" class="text-sm border border-gray-200 rounded-lg px-3 py-1">
                            <option value="7">7 derniers jours</option>
                            <option value="30" selected>30 derniers jours</option>
                            <option value="90">90 derniers jours</option>
                        </select>
                    </div>
                    <canvas id="trendChart" height="250"></canvas>
                </div>
                
                <div class="bg-white rounded-xl p-4 md:p-6 shadow-sm">
                    <h3 class="font-bold text-[#0F172A] mb-4">Répartition par type de conflit</h3>
                    <canvas id="typeChart" height="250"></canvas>
                </div>
            </div>
            
            <!-- RECENT SIGNALS TABLE -->
            <div class="bg-white rounded-xl shadow-sm animate-fadeIn">
                <div class="p-4 md:p-6 border-b border-gray-100">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <h3 class="font-bold text-[#0F172A] text-lg md:text-xl">Signalements récents</h3>
                            <p class="text-xs md:text-sm text-gray-500 mt-1">Les derniers signalements en attente de traitement</p>
                        </div>
                        <a href="{{ route('admin.signals') }}" class="text-sm text-[#F97316] hover:text-orange-600 transition">Voir tous →</a>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="signal-table w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">ID</th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">Lieu</th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">Type</th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">Gravité</th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">Date</th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">Statut</th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">Action</th>
                            </tr>
                        </thead>
                        <tbody id="recentReportsTable">
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">
                                    <div class="loading-spinner"></div>
                                    <span class="ml-2">Chargement des signalements...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- HOTSPOTS MAP SECTION -->
            <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden animate-fadeIn">
                <div class="p-4 md:p-6 border-b border-gray-100">
                    <h3 class="font-bold text-[#0F172A] text-lg md:text-xl">Zones sensibles - Togo</h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-1">Visualisation des zones à risque par région</p>
                </div>
                <div class="p-4 md:p-6">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 md:gap-4" id="regionsGrid">
                        @foreach(['Maritime', 'Plateaux', 'Centrale', 'Kara', 'Savanes'] as $region)
                        <div class="text-center p-3 md:p-4 bg-gray-50 rounded-lg hover:bg-orange-50 transition cursor-pointer region-card" data-region="{{ $region }}">
                            <i class="fas fa-map-marker-alt text-[#F97316] text-lg md:text-xl mb-2"></i>
                            <p class="font-semibold text-xs md:text-sm">{{ $region }}</p>
                            <p class="text-xl md:text-2xl font-bold text-[#0F172A] region-count" id="region-{{ $region }}">0</p>
                            <p class="text-xs text-gray-500">signalements</p>
                        </div>
                        @endforeach
                    </div>
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
        
        // Chart instances
        let trendChart = null;
        let typeChart = null;
        
        // Fonction pour charger toutes les données du dashboard
        async function loadAllDashboardData() {
            await loadStats();
            await loadPendingArtisans();
            await loadRecentReports();
            await loadRegionsData();
        }
        
        // Charger les statistiques
        async function loadStats() {
            try {
                const response = await fetch('/admin/api/stats');
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('totalReports').innerText = data.stats.total || 0;
                    document.getElementById('resolvedReports').innerText = data.stats.resolved || 0;
                    document.getElementById('pendingReports').innerText = data.stats.pending || 0;
                    document.getElementById('activeArtisans').innerText = data.stats.artisans || 0;
                    
                    const resolutionRate = data.stats.total > 0 ? Math.round((data.stats.resolved / data.stats.total) * 100) : 0;
                    document.getElementById('resolutionRate').innerText = resolutionRate;
                    document.getElementById('avgResponseTime').innerText = data.stats.avgResponseTime || 0;
                    document.getElementById('reportGrowth').innerText = data.stats.growth || 0;
                    document.getElementById('newArtisans').innerText = data.stats.newArtisans || 0;
                }
            } catch (error) {
                console.error('Erreur chargement stats:', error);
            }
        }
        
        // Charger les artisans en attente
        async function loadPendingArtisans() {
            try {
                const response = await fetch('/admin/api/pending-artisans');
                const data = await response.json();
                const container = document.getElementById('pendingArtisansList');
                const pendingCountSpan = document.getElementById('pendingCount');
                
                if (data.success && data.artisans.length > 0) {
                    pendingCountSpan.innerText = data.artisans.length + ' en attente';
                    container.innerHTML = '';
                    
                    data.artisans.forEach(artisan => {
                        const card = document.createElement('div');
                        card.className = 'artisan-card rounded-xl p-4 md:p-5 mb-4 bg-white border';
                        card.innerHTML = `
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-12 h-12 bg-[#F97316]/10 rounded-full flex items-center justify-center">
                                            <i class="fas fa-hand-peace text-[#F97316] text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-[#0F172A] text-lg">${escapeHtml(artisan.name)}</h4>
                                            <p class="text-sm text-gray-500">${escapeHtml(artisan.organization_name || 'Indépendant')}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                        <div>
                                            <p class="text-xs text-gray-500">Email</p>
                                            <p class="text-sm font-medium text-[#0F172A]">${escapeHtml(artisan.email)}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Téléphone</p>
                                            <p class="text-sm font-medium text-[#0F172A]">${escapeHtml(artisan.phone || 'Non renseigné')}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Pays / Ville</p>
                                            <p class="text-sm font-medium text-[#0F172A]">${escapeHtml(artisan.country || 'Togo')} / ${escapeHtml(artisan.city || 'Non renseignée')}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Spécialisation</p>
                                            <p class="text-sm font-medium text-[#0F172A]">${escapeHtml(artisan.specialization || 'Non renseignée')}</p>
                                        </div>
                                    </div>
                                    
                                    ${artisan.motivation ? `
                                    <div class="mb-3">
                                        <p class="text-xs text-gray-500">Motivation</p>
                                        <p class="text-sm text-[#0F172A] bg-gray-50 p-2 rounded-lg mt-1">${escapeHtml(artisan.motivation)}</p>
                                    </div>
                                    ` : ''}
                                </div>
                                
                                <div class="flex flex-row md:flex-col gap-2">
                                    <form method="POST" action="/admin/artisans/${artisan.id}/approve" onsubmit="return confirm('Accepter cet artisan ?')">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn-accept w-full px-4 py-2 rounded-lg text-white font-semibold text-sm flex items-center justify-center gap-2">
                                            <i class="fas fa-check"></i> Accepter
                                        </button>
                                    </form>
                                    <form method="POST" action="/admin/artisans/${artisan.id}/reject" onsubmit="return confirm('Refuser cet artisan ?')">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn-reject w-full px-4 py-2 rounded-lg text-white font-semibold text-sm flex items-center justify-center gap-2">
                                            <i class="fas fa-times"></i> Refuser
                                        </button>
                                    </form>
                                </div>
                            </div>
                        `;
                        container.appendChild(card);
                    });
                } else {
                    pendingCountSpan.innerText = '0 en attente';
                    container.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                            <p class="text-gray-500">Aucune demande en attente</p>
                            <p class="text-sm text-gray-400 mt-1">Toutes les candidatures ont été traitées</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Erreur chargement artisans:', error);
            }
        }
        
        // Charger les signalements récents
        async function loadRecentReports() {
            try {
                const response = await fetch('/admin/api/recent-reports');
                const data = await response.json();
                const tbody = document.getElementById('recentReportsTable');
                
                if (data.success && data.reports.length > 0) {
                    tbody.innerHTML = '';
                    
                    data.reports.forEach(report => {
                        const row = document.createElement('tr');
                        row.className = 'border-b border-gray-50 hover:bg-gray-50 transition';
                        
                        let severityClass = 'medium';
                        let severityText = 'Moyen';
                        if (report.danger_level >= 80) { severityClass = 'critical'; severityText = 'Critique'; }
                        else if (report.danger_level >= 60) { severityClass = 'high'; severityText = 'Élevé'; }
                        else if (report.danger_level >= 30) { severityClass = 'medium'; severityText = 'Moyen'; }
                        else { severityClass = 'low'; severityText = 'Faible'; }
                        
                        row.innerHTML = `
                            <td class="py-3 px-4 md:px-6 text-sm text-gray-600">#${report.id}</td>
                            <td class="py-3 px-4 md:px-6">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-[#F97316] text-xs"></i>
                                    <span class="text-sm font-medium">${escapeHtml(report.zone || report.city || 'Non spécifié')}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 md:px-6"><span class="text-sm">${escapeHtml(report.type)}</span></td>
                            <td class="py-3 px-4 md:px-6">
                                <span class="badge-${severityClass} px-2 py-1 rounded-full text-xs font-semibold">${severityText}</span>
                            </td>
                            <td class="py-3 px-4 md:px-6 text-sm text-gray-500">${new Date(report.created_at).toLocaleString('fr-FR')}</td>
                            <td class="py-3 px-4 md:px-6">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold badge-pending">En attente</span>
                            </td>
                            <td class="py-3 px-4 md:px-6">
                                <button onclick="viewReport(${report.id})" class="text-[#F97316] hover:text-orange-600 transition">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                } else {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-500">
                                <i class="fas fa-inbox mr-2"></i>Aucun signalement récent
                            </td>
                        </tr>
                    `;
                }
            } catch (error) {
                console.error('Erreur chargement signalements:', error);
            }
        }
        
        // Charger les données des régions
        async function loadRegionsData() {
            try {
                const response = await fetch('/admin/api/regions-stats');
                const data = await response.json();
                
                if (data.success) {
                    for (const [region, count] of Object.entries(data.regions)) {
                        const element = document.getElementById(`region-${region}`);
                        if (element) element.innerText = count;
                    }
                }
            } catch (error) {
                console.error('Erreur chargement régions:', error);
            }
        }
        
        // Charger les graphiques
        async function loadCharts(period = 30) {
            try {
                const response = await fetch(`/admin/api/charts-data?period=${period}`);
                const data = await response.json();
                
                if (data.success) {
                    initTrendChart(data.trend);
                    initTypeChart(data.types);
                }
            } catch (error) {
                console.error('Erreur chargement graphiques:', error);
            }
        }
        
        function initTrendChart(data) {
            const ctx = document.getElementById('trendChart').getContext('2d');
            if (trendChart) trendChart.destroy();
            
            trendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data?.labels || [],
                    datasets: [{
                        label: 'Signalements',
                        data: data?.values || [],
                        borderColor: '#F97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.05)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#F97316',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: { 
                        y: { beginAtZero: true, grid: { color: '#E2E8F0' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
        
        function initTypeChart(data) {
            const ctx = document.getElementById('typeChart').getContext('2d');
            if (typeChart) typeChart.destroy();
            
            typeChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data?.labels || [],
                    datasets: [{
                        data: data?.values || [],
                        backgroundColor: ['#F97316', '#3B82F6', '#8B5CF6', '#10B981', '#EC4899'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { size: 11 } } }
                    }
                }
            });
        }
        
        function viewReport(id) {
            window.location.href = `/admin/signalements/${id}`;
        }
        
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Initialisation
        document.addEventListener('DOMContentLoaded', () => {
            loadAllDashboardData();
            loadCharts(30);
            
            const periodSelect = document.getElementById('chartPeriod');
            if (periodSelect) {
                periodSelect.addEventListener('change', (e) => {
                    loadCharts(e.target.value);
                });
            }
            
            // Rafraîchissement automatique toutes les 30 secondes
            setInterval(() => {
                loadStats();
                loadPendingArtisans();
                loadRecentReports();
            }, 30000);
        });
    </script>
</body>
</html>