{{-- resources/views/admin/signals.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PeaceLink | Gestion des signalements</title>
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
        
        .badge-in-progress {
            background: #DBEAFE;
            color: #2563EB;
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
        
        /* Pagination */
        .pagination-link {
            transition: all 0.2s ease;
        }
        
        .pagination-link:hover {
            background: #F97316;
            color: white;
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
            <a href="{{ route('admin.signals') }}" class="sidebar-link active flex items-center gap-3 px-6 py-3 text-gray-300 hover:text-white transition">
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
                        <h1 class="text-xl md:text-2xl font-bold text-[#0F172A]">Gestion des signalements</h1>
                        <p class="text-xs md:text-sm text-gray-500 mt-1">Consultez et gérez tous les signalements citoyens</p>
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
            
            <!-- FILTRES ET RECHERCHE -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6 animate-fadeIn">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Recherche -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-search text-[#F97316] mr-1"></i> Rechercher
                        </label>
                        <input type="text" 
                               id="searchInput" 
                               placeholder="Rechercher par zone, quartier ou description..." 
                               class="filter-input w-full rounded-xl px-4 py-2">
                    </div>
                    
                    <!-- Filtre par type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-filter text-[#F97316] mr-1"></i> Type de signalement
                        </label>
                        <select id="typeFilter" class="filter-input w-full rounded-xl px-4 py-2">
                            <option value="">Tous les types</option>
                            <option value="Violence">Violence</option>
                            <option value="Discours haineux">Discours haineux</option>
                            <option value="Conflit communautaire">Conflit communautaire</option>
                            <option value="Manifestation">Manifestation</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    
                    <!-- Filtre par statut -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-chart-line text-[#F97316] mr-1"></i> Statut
                        </label>
                        <select id="statusFilter" class="filter-input w-full rounded-xl px-4 py-2">
                            <option value="">Tous les statuts</option>
                            <option value="pending">En attente</option>
                            <option value="in_progress">En cours</option>
                            <option value="resolved">Résolu</option>
                        </select>
                    </div>
                </div>
                
                <!-- Boutons d'action rapide -->
                <div class="flex flex-wrap gap-3 mt-4 pt-3 border-t border-gray-100">
                    <button onclick="resetFilters()" class="text-sm text-gray-500 hover:text-[#F97316] transition px-3 py-1 rounded-lg">
                        <i class="fas fa-undo-alt mr-1"></i> Réinitialiser
                    </button>
                    <button onclick="exportData()" class="text-sm text-gray-500 hover:text-[#F97316] transition px-3 py-1 rounded-lg">
                        <i class="fas fa-download mr-1"></i> Exporter CSV
                    </button>
                </div>
            </div>
            
            <!-- TABLEAU DES SIGNALEMENTS -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden animate-fadeIn">
                <div class="overflow-x-auto">
                    <table class="signal-table w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-hashtag text-[#F97316] mr-1"></i> ID
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-tag text-[#F97316] mr-1"></i> Type
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-map-marker-alt text-[#F97316] mr-1"></i> Zone
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-home text-[#F97316] mr-1"></i> Quartier
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-chart-line text-[#F97316] mr-1"></i> Danger
                                </th>
                                <th class="text-left py-3 md:py-4 px-4 md:px-6 text-xs md:text-sm font-semibold text-gray-600">
                                    <i class="fas fa-align-left text-[#F97316] mr-1"></i> Description
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
                        <tbody id="reportsTableBody">
                            @forelse($reports as $report)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition" data-id="{{ $report->id }}">
                                <td class="py-3 px-4 md:px-6 text-sm text-gray-600 font-mono">#{{ $report->id }}</td>
                                <td class="py-3 px-4 md:px-6">
                                    <span class="text-sm font-medium">{{ $report->type }}</span>
                                </td>
                                <td class="py-3 px-4 md:px-6">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt text-[#F97316] text-xs"></i>
                                        <span class="text-sm">{{ $report->zone }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 md:px-6 text-sm">{{ $report->district }}</td>
                                <td class="py-3 px-4 md:px-6">
                                    @php
                                        $dangerLevel = $report->danger_level;
                                        $badgeClass = 'low';
                                        if ($dangerLevel >= 80) $badgeClass = 'critical';
                                        elseif ($dangerLevel >= 60) $badgeClass = 'high';
                                        elseif ($dangerLevel >= 30) $badgeClass = 'medium';
                                        else $badgeClass = 'low';
                                    @endphp
                                    <span class="badge-{{ $badgeClass }} px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ $dangerLevel }}%
                                    </span>
                                </td>
                                <td class="py-3 px-4 md:px-6 max-w-xs">
                                    <p class="text-sm text-gray-600 truncate" title="{{ $report->description }}">
                                        {{ Str::limit($report->description, 60) }}
                                    </p>
                                </td>
                                <td class="py-3 px-4 md:px-6">
                                    @php
                                        $statusClass = 'pending';
                                        $statusText = 'En attente';
                                        if ($report->status == 'in_progress') {
                                            $statusClass = 'in-progress';
                                            $statusText = 'En cours';
                                        } elseif ($report->status == 'resolved') {
                                            $statusClass = 'resolved';
                                            $statusText = 'Résolu';
                                        }
                                    @endphp
                                    <span class="badge-{{ $statusClass }} px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 md:px-6 text-sm text-gray-500">
                                    {{ $report->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-3 px-4 md:px-6">
                                    <div class="flex items-center gap-2">
                                        <button onclick="viewReport({{ $report->id }})" 
                                                class="text-[#F97316] hover:text-orange-600 transition p-1" 
                                                title="Voir détails">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="updateStatus({{ $report->id }})" 
                                                class="text-blue-500 hover:text-blue-700 transition p-1" 
                                                title="Modifier le statut">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteReport({{ $report->id }})" 
                                                class="text-red-500 hover:text-red-700 transition p-1" 
                                                title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-10 text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3 block"></i>
                                    Aucun signalement trouvé
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- PAGINATION -->
                @if(isset($reports) && method_exists($reports, 'links'))
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $reports->links() }}
                </div>
                @endif
            </div>
            
            <!-- STATISTIQUES RAPIDES -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6 animate-fadeIn">
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Total signalements</p>
                            <p class="text-2xl font-bold text-[#0F172A]">{{ $totalReports ?? $reports->total() ?? 0 }}</p>
                        </div>
                        <i class="fas fa-flag text-[#F97316] text-2xl opacity-50"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">En attente</p>
                            <p class="text-2xl font-bold text-orange-500">{{ $pendingCount ?? 0 }}</p>
                        </div>
                        <i class="fas fa-clock text-orange-500 text-2xl opacity-50"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">En cours</p>
                            <p class="text-2xl font-bold text-blue-500">{{ $inProgressCount ?? 0 }}</p>
                        </div>
                        <i class="fas fa-spinner fa-pulse text-blue-500 text-2xl opacity-50"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Résolus</p>
                            <p class="text-2xl font-bold text-green-600">{{ $resolvedCount ?? 0 }}</p>
                        </div>
                        <i class="fas fa-check-circle text-green-600 text-2xl opacity-50"></i>
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
        
        // Filtres en temps réel
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const statusFilter = document.getElementById('statusFilter');
        const tableBody = document.getElementById('reportsTableBody');
        
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const typeTerm = typeFilter.value.toLowerCase();
            const statusTerm = statusFilter.value.toLowerCase();
            
            const rows = tableBody.querySelectorAll('tr');
            
            rows.forEach(row => {
                if (row.cells) {
                    const type = row.cells[1]?.textContent.toLowerCase() || '';
                    const zone = row.cells[2]?.textContent.toLowerCase() || '';
                    const district = row.cells[3]?.textContent.toLowerCase() || '';
                    const description = row.cells[5]?.textContent.toLowerCase() || '';
                    const status = row.cells[6]?.textContent.toLowerCase() || '';
                    
                    let statusMatch = true;
                    if (statusTerm) {
                        if (statusTerm === 'en attente') statusMatch = status.includes('attente');
                        else if (statusTerm === 'en cours') statusMatch = status.includes('cours');
                        else if (statusTerm === 'résolu') statusMatch = status.includes('résolu');
                        else statusMatch = status.includes(statusTerm);
                    }
                    
                    const typeMatch = !typeTerm || type.includes(typeTerm);
                    const searchMatch = !searchTerm || 
                        zone.includes(searchTerm) || 
                        district.includes(searchTerm) || 
                        description.includes(searchTerm);
                    
                    if (typeMatch && searchMatch && statusMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        }
        
        searchInput.addEventListener('input', filterTable);
        typeFilter.addEventListener('change', filterTable);
        statusFilter.addEventListener('change', filterTable);
        
        function resetFilters() {
            searchInput.value = '';
            typeFilter.value = '';
            statusFilter.value = '';
            filterTable();
        }
        
        function viewReport(id) {
            window.location.href = `/admin/signalements/${id}`;
        }
        
        function updateStatus(id) {
            const newStatus = prompt('Changer le statut du signalement :\n1 - En attente\n2 - En cours\n3 - Résolu', '2');
            if (newStatus) {
                let status = '';
                if (newStatus === '1') status = 'pending';
                else if (newStatus === '2') status = 'in_progress';
                else if (newStatus === '3') status = 'resolved';
                else return;
                
                fetch(`/admin/signalements/${id}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erreur lors de la mise à jour');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        }
        
        function deleteReport(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce signalement ? Cette action est irréversible.')) {
                fetch(`/admin/signalements/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        }
        
        function exportData() {
            window.location.href = '/admin/signalements/export';
        }
    </script>
</body>
</html>