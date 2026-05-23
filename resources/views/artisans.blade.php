{{-- resources/views/admin/artisans.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PeaceLink | Gestion des artisans de la paix</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
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
        
        /* Table styles */
        .artisan-table tbody tr {
            transition: all 0.2s ease;
        }
        
        .artisan-table tbody tr:hover {
            background: #F8FAFC;
        }
        
        /* Badge styles */
        .badge-approved {
            background: #D1FAE5;
            color: #059669;
        }
        
        .badge-pending {
            background: #FEF3C7;
            color: #D97706;
        }
        
        .badge-rejected {
            background: #FEE2E2;
            color: #DC2626;
        }
        
        /* Filter input */
        .filter-input {
            transition: all 0.2s ease;
            border: 1.5px solid #E2E8F0;
        }
        
        .filter-input:focus {
            border-color: #F97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
            outline: none;
        }
        
        /* Buttons */
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
        
        .btn-view {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
            transition: all 0.2s ease;
        }
        
        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
            <a href="{{ route('admin.hotspots') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
                <i class="fas fa-map-marker-alt w-5"></i>
                <span>Zones sensibles</span>
            </a>
            <a href="{{ route('artisans') }}" class="sidebar-link active flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
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
                        <h1 class="text-xl md:text-2xl font-bold text-[#0F172A]">Artisans de la paix</h1>
                        <p class="text-xs md:text-sm text-gray-500 mt-1">Gestion complète des artisans de la paix</p>
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 animate-fadeIn">
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Total artisans</p>
                            <p class="text-2xl font-bold text-[#0F172A]" id="totalArtisans">{{ $totalArtisans ?? $artisans->total() ?? 0 }}</p>
                        </div>
                        <i class="fas fa-users text-[#F97316] text-2xl opacity-50"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Validés</p>
                            <p class="text-2xl font-bold text-green-600" id="approvedArtisans">{{ $approvedCount ?? 0 }}</p>
                        </div>
                        <i class="fas fa-check-circle text-green-600 text-2xl opacity-50"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">En attente</p>
                            <p class="text-2xl font-bold text-orange-500" id="pendingArtisans">{{ $pendingCount ?? 0 }}</p>
                        </div>
                        <i class="fas fa-clock text-orange-500 text-2xl opacity-50"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Refusés</p>
                            <p class="text-2xl font-bold text-red-600" id="rejectedArtisans">{{ $rejectedCount ?? 0 }}</p>
                        </div>
                        <i class="fas fa-times-circle text-red-600 text-2xl opacity-50"></i>
                    </div>
                </div>
            </div>
            
            <!-- FILTRES ET RECHERCHE EN TEMPS RÉEL -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6 animate-fadeIn">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Recherche -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-search text-[#F97316] mr-1"></i> Rechercher
                        </label>
                        <input type="text" 
                               id="searchInput" 
                               placeholder="Rechercher par nom, email, organisation..." 
                               class="filter-input w-full rounded-xl px-4 py-2"
                               value="{{ $search ?? '' }}">
                    </div>
                    
                    <!-- Filtre par statut -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-filter text-[#F97316] mr-1"></i> Statut
                        </label>
                        <select id="statusFilter" class="filter-input w-full rounded-xl px-4 py-2">
                            <option value="">Tous les statuts</option>
                            <option value="approved" {{ ($status ?? '') == 'approved' ? 'selected' : '' }}>Validés</option>
                            <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="rejected" {{ ($status ?? '') == 'rejected' ? 'selected' : '' }}>Refusés</option>
                        </select>
                    </div>
                    
                    <!-- Filtre par pays -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-globe-africa text-[#F97316] mr-1"></i> Pays
                        </label>
                        <select id="countryFilter" class="filter-input w-full rounded-xl px-4 py-2">
                            <option value="">Tous les pays</option>
                            <option value="Togo">Togo</option>
                            <option value="Bénin">Bénin</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                            <option value="Sénégal">Sénégal</option>
                        </select>
                    </div>
                </div>
                
                <!-- Boutons d'action rapide -->
                <div class="flex flex-wrap gap-3 mt-4 pt-3 border-t border-gray-100">
                    <button onclick="resetFilters()" class="text-sm text-gray-500 hover:text-[#F97316] transition px-3 py-1 rounded-lg">
                        <i class="fas fa-undo-alt mr-1"></i> Réinitialiser
                    </button>
                    <button onclick="exportArtisans()" class="text-sm text-gray-500 hover:text-[#F97316] transition px-3 py-1 rounded-lg">
                        <i class="fas fa-download mr-1"></i> Exporter CSV
                    </button>
                </div>
            </div>
            
            <!-- TABLEAU DES ARTISANS -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden animate-fadeIn">
                <div class="overflow-x-auto">
                    <table class="artisan-table w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-user text-[#F97316] mr-1"></i> Nom
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-envelope text-[#F97316] mr-1"></i> Email
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-phone text-[#F97316] mr-1"></i> Téléphone
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-map-marker-alt text-[#F97316] mr-1"></i> Localisation
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-building text-[#F97316] mr-1"></i> Organisation
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-tag text-[#F97316] mr-1"></i> Spécialisation
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-info-circle text-[#F97316] mr-1"></i> Statut
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-calendar text-[#F97316] mr-1"></i> Date
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-cog text-[#F97316] mr-1"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody id="artisansTableBody">
                            @forelse($artisans as $artisan)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition" data-id="{{ $artisan->id }}">
                                <td class="py-3 px-4 md:px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-[#F97316]/10 rounded-full flex items-center justify-center">
                                            <i class="fas fa-hand-peace text-[#F97316] text-sm"></i>
                                        </div>
                                        <span class="font-semibold text-sm">{{ $artisan->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 md:px-6 text-sm">{{ $artisan->email }}</td>
                                <td class="py-3 px-4 md:px-6 text-sm">{{ $artisan->phone ?? '-' }}</td>
                                <td class="py-3 px-4 md:px-6 text-sm">
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-flag text-gray-400 text-xs"></i>
                                        <span>{{ $artisan->country ?? 'Togo' }}</span>
                                        <span class="text-gray-400">/</span>
                                        <span>{{ $artisan->city ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 md:px-6 text-sm">{{ $artisan->organization_name ?? '-' }}</td>
                                <td class="py-3 px-4 md:px-6 text-sm">{{ $artisan->specialization ?? '-' }}</td>
                                <td class="py-3 px-4 md:px-6">
                                    @if($artisan->status === 'approved')
                                        <span class="badge-approved px-2 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check-circle mr-1"></i> Validé
                                        </span>
                                    @elseif($artisan->status === 'pending')
                                        <span class="badge-pending px-2 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-clock mr-1"></i> En attente
                                        </span>
                                    @else
                                        <span class="badge-rejected px-2 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-times-circle mr-1"></i> Refusé
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 md:px-6 text-sm text-gray-500">
                                    {{ $artisan->created_at->format('d/m/Y') }}
                                </td>
                                <td class="py-3 px-4 md:px-6">
                                    <div class="flex items-center gap-2">
                                        <button onclick="viewArtisan({{ $artisan->id }})" 
                                                class="btn-view text-white px-3 py-1 rounded-lg text-xs flex items-center gap-1" 
                                                title="Voir détails">
                                            <i class="fas fa-eye"></i> Voir
                                        </button>
                                        @if($artisan->status === 'pending')
                                        <button onclick="approveArtisan({{ $artisan->id }})" 
                                                class="btn-accept text-white px-3 py-1 rounded-lg text-xs flex items-center gap-1" 
                                                title="Accepter">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button onclick="rejectArtisan({{ $artisan->id }})" 
                                                class="btn-reject text-white px-3 py-1 rounded-lg text-xs flex items-center gap-1" 
                                                title="Refuser">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-10 text-gray-500">
                                    <i class="fas fa-users text-4xl mb-3 block opacity-30"></i>
                                    Aucun artisan trouvé
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- PAGINATION -->
                @if(isset($artisans) && method_exists($artisans, 'links'))
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $artisans->links() }}
                </div>
                @endif
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
        
        // Filtres en temps réel
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const countryFilter = document.getElementById('countryFilter');
        const tableBody = document.getElementById('artisansTableBody');
        
        let debounceTimeout;
        
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusTerm = statusFilter.value.toLowerCase();
            const countryTerm = countryFilter.value.toLowerCase();
            
            const rows = tableBody.querySelectorAll('tr');
            
            rows.forEach(row => {
                if (row.cells) {
                    const name = row.cells[0]?.textContent.toLowerCase() || '';
                    const email = row.cells[1]?.textContent.toLowerCase() || '';
                    const location = row.cells[3]?.textContent.toLowerCase() || '';
                    const status = row.cells[6]?.textContent.toLowerCase() || '';
                    
                    const searchMatch = !searchTerm || 
                        name.includes(searchTerm) || 
                        email.includes(searchTerm) ||
                        location.includes(searchTerm);
                    
                    const statusMatch = !statusTerm || status.includes(statusTerm);
                    const countryMatch = !countryTerm || location.includes(countryTerm);
                    
                    if (searchMatch && statusMatch && countryMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
            
            // Mettre à jour les compteurs affichés
            updateVisibleCounters();
        }
        
        function updateVisibleCounters() {
            const rows = tableBody.querySelectorAll('tr');
            let visible = 0;
            rows.forEach(row => {
                if (row.style.display !== 'none' && row.cells) visible++;
            });
            
            // Mettre à jour l'affichage du compteur
            const totalSpan = document.getElementById('visibleCount');
            if (totalSpan) totalSpan.innerText = visible;
        }
        
        // Debounce pour la recherche
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(filterTable, 300);
        });
        
        statusFilter.addEventListener('change', filterTable);
        countryFilter.addEventListener('change', filterTable);
        
        function resetFilters() {
            searchInput.value = '';
            statusFilter.value = '';
            countryFilter.value = '';
            filterTable();
        }
        
        function viewArtisan(id) {
            window.location.href = `/admin/artisans/${id}`;
        }
        
        function approveArtisan(id) {
            if (confirm('Êtes-vous sûr de vouloir accepter cet artisan ?')) {
                fetch(`/admin/artisans/${id}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erreur lors de l\'approbation');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        }
        
        function rejectArtisan(id) {
            if (confirm('Êtes-vous sûr de vouloir refuser cet artisan ?')) {
                fetch(`/admin/artisans/${id}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erreur lors du refus');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        }
        
        function exportArtisans() {
            window.location.href = '/admin/artisans/export';
        }
        
        // Initialisation des filtres avec les valeurs de l'URL si présentes
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search');
            const statusParam = urlParams.get('status');
            
            if (searchParam) searchInput.value = searchParam;
            if (statusParam) statusFilter.value = statusParam;
            
            filterTable();
        });
        
        // Rafraîchissement automatique toutes les 30 secondes (optionnel)
        let refreshInterval = setInterval(() => {
            fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTableBody = doc.getElementById('artisansTableBody');
                    if (newTableBody) {
                        tableBody.innerHTML = newTableBody.innerHTML;
                        filterTable();
                    }
                })
                .catch(error => console.error('Erreur rafraîchissement:', error));
        }, 30000);
        
        // Nettoyer l'intervalle lors de la fermeture
        window.addEventListener('beforeunload', () => {
            if (refreshInterval) clearInterval(refreshInterval);
        });
    </script>
</body>
</html>