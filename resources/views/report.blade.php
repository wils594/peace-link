{{-- resources/views/report.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PeaceLink | Signalement citoyen</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
            min-height: 100vh;
        }

        #map {
            height: 400px;
            width: 100%;
            border-radius: 20px;
            z-index: 1;
            border: 2px solid #F97316;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Animation d'entrée */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Style des champs de formulaire */
        .form-input {
            transition: all 0.2s ease;
            border: 1.5px solid #E2E8F0;
        }

        .form-input:focus {
            border-color: #F97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
            outline: none;
        }

        /* Style pour le bouton */
        .btn-submit {
            transition: all 0.2s ease;
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }
        
        /* Style pour le bouton de recherche */
        .search-btn {
            transition: all 0.2s ease;
            background: #0F172A;
        }
        
        .search-btn:hover {
            background: #F97316;
            transform: translateY(-1px);
        }
        
        /* Conteneur de recherche personnalisé */
        .search-container {
            position: relative;
            z-index: 10;
            margin-bottom: 1rem;
        }
        
        /* Barre de recherche dédiée */
        .search-bar {
            background: white;
            border: 2px solid #E2E8F0;
            border-radius: 50px;
            padding: 4px 4px 4px 20px;
            transition: all 0.2s ease;
        }
        
        .search-bar:focus-within {
            border-color: #F97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        
        .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 0.95rem;
            background: transparent;
        }
        
        .search-bar button {
            background: #F97316;
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .search-bar button:hover {
            background: #EA580C;
            transform: scale(1.02);
        }
        
        /* Suggestions de villes */
        .suggestions-box {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            border: 1px solid #E2E8F0;
            margin-top: 8px;
        }
        
        .suggestion-item {
            padding: 12px 20px;
            cursor: pointer;
            transition: background 0.2s;
            border-bottom: 1px solid #F1F5F9;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .suggestion-item:hover {
            background: #FEF3C7;
        }
        
        .suggestion-item i {
            color: #F97316;
            width: 20px;
        }
        
        .suggestion-item .city-name {
            font-weight: 600;
            color: #0F172A;
        }
        
        .suggestion-item .country-name {
            font-size: 0.75rem;
            color: #64748B;
            margin-left: 8px;
        }

        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #F1F5F9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #F97316;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #EA580C;
        }
        
        /* Indicateur de chargement */
        .search-loading {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            display: none;
        }
    </style>
</head>
<body>

<div class="min-h-screen py-8 md:py-12 px-4">

    <div class="max-w-5xl mx-auto animate-fadeInUp">

        {{-- HEADER --}}
        <div class="mb-8 text-center md:text-left">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-[#F97316]/10 rounded-2xl mb-4 md:mb-0 md:mr-4 md:float-left">
                <i class="fas fa-flag text-[#F97316] text-2xl"></i>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-[#0F172A] mb-2">
                    Signalement citoyen
                </h1>
                <p class="text-gray-600 text-sm md:text-base">
                    <i class="fas fa-shield-alt text-[#F97316] mr-2"></i>
                    Signalez anonymement une situation à risque afin d'aider à la prévention des conflits.
                    Votre signalement est entièrement anonyme et sécurisé.
                </p>
            </div>
        </div>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-5 py-4 rounded-2xl mb-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- BARRE DE RECHERCHE DÉDIÉE --}}
        <div class="bg-white rounded-2xl shadow-md p-4 mb-6">
            <div class="flex items-center gap-2 mb-3">
                <i class="fas fa-search text-[#F97316]"></i>
                <span class="font-semibold text-gray-700">Rechercher une ville</span>
            </div>
            <div class="search-container">
                <div class="search-bar flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                    <input type="text" 
                           id="citySearchInput" 
                           placeholder="Ex: Lomé, Kara, Sokodé, Atakpamé..." 
                           class="flex-1"
                           autocomplete="off">
                    <button id="searchCityBtn" class="text-white">
                        <i class="fas fa-search mr-1"></i> Rechercher
                    </button>
                </div>
                <div id="suggestionsBox" class="suggestions-box"></div>
            </div>
            <p class="text-xs text-gray-400 mt-2">
                <i class="fas fa-info-circle"></i> Saisissez le nom d'une ville pour recentrer la carte
            </p>
        </div>

        {{-- FORM --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

            <div class="p-6 md:p-8">

                <form action="{{ route('report.store') }}"
                      method="POST"
                      id="reportForm">

                    @csrf

                    <div class="grid md:grid-cols-2 gap-6">

                        {{-- TYPE --}}
                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                <i class="fas fa-exclamation-triangle text-[#F97316] mr-2 text-sm"></i>
                                Type de signalement
                            </label>
                            <select name="type"
                                    class="form-input w-full rounded-xl px-4 py-3 bg-white focus:ring-0"
                                    required>
                                <option value="">Sélectionner un type</option>
                                <option value="Violence"> Violence</option>
                                <option value="Discours haineux"> Discours haineux</option>
                                <option value="Conflit communautaire"> Conflit communautaire</option>
                                <option value="Manifestation">Manifestation</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>

                        {{-- DANGER LEVEL --}}
                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                <i class="fas fa-chart-line text-[#F97316] mr-2 text-sm"></i>
                                Niveau de danger (%)
                            </label>
                            <div class="relative">
                                <input type="number"
                                       name="danger_level"
                                       min="1"
                                       max="100"
                                       class="form-input w-full rounded-xl px-4 py-3"
                                       placeholder="Ex: 80">
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">
                                    %
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Évaluez la gravité de 1 à 100%</p>
                        </div>

                        {{-- ZONE --}}
                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                <i class="fas fa-city text-[#F97316] mr-2 text-sm"></i>
                                Ville / Zone
                            </label>
                            <input type="text"
                                   name="zone"
                                   id="cityField"
                                   class="form-input w-full rounded-xl px-4 py-3"
                                   placeholder="Ex: Lomé, Kara, Sokodé..."
                                   required>
                        </div>

                        {{-- DISTRICT --}}
                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                <i class="fas fa-home text-[#F97316] mr-2 text-sm"></i>
                                Quartier / Lieu-dit
                            </label>
                            <input type="text"
                                   name="district"
                                   class="form-input w-full rounded-xl px-4 py-3"
                                   placeholder="Ex: Bè, Nyékonakpoè..."
                                   required>
                        </div>

                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mt-6">
                        <label class="block mb-2 font-semibold text-gray-700">
                            <i class="fas fa-align-left text-[#F97316] mr-2 text-sm"></i>
                            Description détaillée
                        </label>
                        <textarea name="description"
                                  rows="5"
                                  class="form-input w-full rounded-xl px-4 py-3 resize-none"
                                  placeholder="Décrivez précisément la situation, les acteurs impliqués, le contexte... (Minimum 10 caractères)"
                                  required></textarea>
                        <p class="text-xs text-gray-500 mt-1">Plus votre description est précise, plus l'intervention sera efficace.</p>
                    </div>

                    {{-- MAP --}}
                    <div class="mt-8">
                        <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
                            <h2 class="font-bold text-xl text-[#0F172A]">
                                <i class="fas fa-map-marker-alt text-[#F97316] mr-2"></i>
                                Sélectionner la zone sur la carte
                            </h2>
                            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                <i class="fas fa-mouse-pointer mr-1"></i> Cliquez sur la carte
                            </span>
                        </div>
                        <div id="map"></div>
                        <p class="text-xs text-gray-500 mt-2 text-center">
                            <i class="fas fa-info-circle text-[#F97316] mr-1"></i>
                            Cliquez directement sur la carte pour géolocaliser précisément l'incident
                        </p>
                    </div>

                    {{-- HIDDEN GPS --}}
                    <input type="hidden"
                           name="latitude"
                           id="latitude"
                           required>

                    <input type="hidden"
                           name="longitude"
                           id="longitude"
                           required>

                    {{-- SUBMIT --}}
                    <div class="mt-8">
                        <button type="submit"
                                class="btn-submit w-full text-white font-bold py-4 rounded-2xl transition flex items-center justify-center gap-3">
                            <i class="fas fa-paper-plane"></i>
                            Envoyer le signalement anonyme
                            <i class="fas fa-shield-alt opacity-75"></i>
                        </button>
                        <p class="text-center text-xs text-gray-400 mt-3">
                            <i class="fas fa-lock"></i> Aucune donnée personnelle n'est collectée. Votre anonymat est garanti.
                        </p>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
    /*
    |--------------------------------------------------------------------------
    | MAP - Configuration avec recherche de villes
    |--------------------------------------------------------------------------
    */

    // Configuration de la carte (centrée sur Lomé par défaut)
    const defaultLat = 6.1319;
    const defaultLng = 1.2228;
    
    const map = L.map('map').setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributeurs',
        maxZoom: 19
    }).addTo(map);

    let marker;
    let currentSearchMarker;

    // Fonction pour recentrer la carte sur des coordonnées
    function centerMapOnLocation(lat, lng, locationName) {
        map.setView([lat, lng], 14);
        
        // Supprimer l'ancien marqueur de recherche si existant
        if (currentSearchMarker) {
            map.removeLayer(currentSearchMarker);
        }
        
        // Ajouter un marqueur temporaire pour la recherche
        currentSearchMarker = L.marker([lat, lng]).addTo(map);
        currentSearchMarker.bindPopup(`
            <div style="font-family: Inter; text-align: center;">
                <strong> ${locationName}</strong><br>
                Cliquez sur la carte pour préciser l'emplacement exact
            </div>
        `).openPopup();
        
        // Supprimer le marqueur temporaire après 4 secondes
        setTimeout(() => {
            if (currentSearchMarker && !marker) {
                map.removeLayer(currentSearchMarker);
                currentSearchMarker = null;
            } else if (currentSearchMarker && marker) {
                map.removeLayer(currentSearchMarker);
                currentSearchMarker = null;
            }
        }, 4000);
    }

    // Fonction de géocodage (recherche de ville)
    async function searchLocation(query) {
        if (!query || query.length < 2) return [];
        
        try {
            const response = await fetch(
                `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=8&countrycodes=tg,bf,bj,gh,ci,sn,ml,ne,ng,cm`
            );
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erreur de recherche:', error);
            return [];
        }
    }

    // Éléments DOM
    const searchInput = document.getElementById('citySearchInput');
    const searchBtn = document.getElementById('searchCityBtn');
    const cityField = document.getElementById('cityField');
    const suggestionsBox = document.getElementById('suggestionsBox');

    // Afficher les suggestions
    function showSuggestions(suggestions) {
        if (!suggestionsBox) return;
        
        if (suggestions.length === 0) {
            suggestionsBox.style.display = 'none';
            return;
        }
        
        suggestionsBox.innerHTML = '';
        
        suggestions.forEach(suggestion => {
            const item = document.createElement('div');
            item.className = 'suggestion-item';
            const cityName = suggestion.display_name.split(',')[0];
            const countryName = suggestion.display_name.split(',').pop() || '';
            item.innerHTML = `
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <span class="city-name">${cityName}</span>
                    <span class="country-name">${countryName}</span>
                    <div class="text-xs text-gray-500 mt-0.5">${suggestion.display_name.substring(0, 60)}...</div>
                </div>
            `;
            
            item.addEventListener('click', () => {
                searchInput.value = cityName;
                cityField.value = cityName;
                centerMapOnLocation(parseFloat(suggestion.lat), parseFloat(suggestion.lon), cityName);
                suggestionsBox.style.display = 'none';
            });
            
            suggestionsBox.appendChild(item);
        });
        
        suggestionsBox.style.display = 'block';
    }
    
    // Gestionnaire de saisie pour la recherche
    let searchTimeout;
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();
        
        if (query.length < 2) {
            suggestionsBox.style.display = 'none';
            return;
        }
        
        searchTimeout = setTimeout(async () => {
            const results = await searchLocation(query);
            showSuggestions(results);
        }, 500);
    });
    
    // Recherche au clic sur le bouton
    searchBtn.addEventListener('click', async () => {
        const query = searchInput.value.trim();
        if (query.length < 2) {
            alert('Veuillez saisir au moins 2 caractères');
            return;
        }
        
        searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Recherche...';
        searchBtn.disabled = true;
        
        const results = await searchLocation(query);
        
        searchBtn.innerHTML = '<i class="fas fa-search mr-1"></i> Rechercher';
        searchBtn.disabled = false;
        
        if (results.length > 0) {
            const firstResult = results[0];
            const cityName = firstResult.display_name.split(',')[0];
            cityField.value = cityName;
            centerMapOnLocation(parseFloat(firstResult.lat), parseFloat(firstResult.lon), cityName);
            suggestionsBox.style.display = 'none';
        } else {
            alert('Aucune ville trouvée. Vérifiez l\'orthographe.');
        }
    });
    
    // Recherche au clavier (Entrée)
    searchInput.addEventListener('keypress', async (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchBtn.click();
        }
    });
    
    // Fermer les suggestions en cliquant ailleurs
    document.addEventListener('click', function(e) {
        if (suggestionsBox && !searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.style.display = 'none';
        }
    });

    // Gestion du clic sur la carte
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        // Supprimer le marqueur de recherche s'il existe
        if (currentSearchMarker) {
            map.removeLayer(currentSearchMarker);
            currentSearchMarker = null;
        }

        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lng]).addTo(map);
        
        marker.bindPopup(`
            <div style="font-family: Inter; text-align: center;">
                <strong>📍 Position sélectionnée</strong><br>
                Lat: ${lat.toFixed(6)}<br>
                Lng: ${lng.toFixed(6)}
            </div>
        `).openPopup();
        
        // Effet visuel
        document.getElementById('latitude').style.borderColor = '#F97316';
        document.getElementById('longitude').style.borderColor = '#F97316';
        
        setTimeout(() => {
            document.getElementById('latitude').style.borderColor = '';
            document.getElementById('longitude').style.borderColor = '';
        }, 2000);
    });

    // Validation avant soumission
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;
        
        if (!lat || !lng) {
            e.preventDefault();
            alert('⚠️ Veuillez sélectionner une localisation sur la carte avant de soumettre le signalement.');
            return false;
        }
        
        const type = document.querySelector('select[name="type"]').value;
        if (!type) {
            e.preventDefault();
            alert('⚠️ Veuillez sélectionner un type de signalement.');
            return false;
        }
        
        const zone = document.querySelector('input[name="zone"]').value;
        if (!zone) {
            e.preventDefault();
            alert('⚠️ Veuillez indiquer la ville / zone.');
            return false;
        }
        
        const district = document.querySelector('input[name="district"]').value;
        if (!district) {
            e.preventDefault();
            alert('⚠️ Veuillez indiquer le quartier / lieu-dit.');
            return false;
        }
        
        const description = document.querySelector('textarea[name="description"]').value;
        if (!description || description.length < 10) {
            e.preventDefault();
            alert('⚠️ Veuillez fournir une description détaillée (minimum 10 caractères).');
            return false;
        }
        
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';
        
        setTimeout(() => {
            if (btn.disabled) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Envoyer le signalement anonyme <i class="fas fa-shield-alt opacity-75"></i>';
            }
        }, 10000);
    });
</script>

</body>
</html>