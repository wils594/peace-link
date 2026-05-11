<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeaceLink | Demande envoyée</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #0F172A 100%);
            position: relative;
            overflow: hidden;
        }
        
        /* Effet de particules animées */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
            pointer-events: none;
        }
        
        /* Animation de flottement pour les objets 3D */
        @keyframes float1 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes float2 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(15px) rotate(-3deg); }
        }
        
        @keyframes float3 {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-10px) scale(1.05); }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        
        .object-3d-1 {
            animation: float1 6s ease-in-out infinite;
        }
        
        .object-3d-2 {
            animation: float2 7s ease-in-out infinite;
        }
        
        .object-3d-3 {
            animation: float3 5s ease-in-out infinite;
        }
        
        .glow-effect {
            box-shadow: 0 0 30px rgba(249, 115, 22, 0.2);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    
    <!-- Objets 3D décoratifs en arrière-plan -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Objet 1 - Sphère / Globe -->
        <div class="object-3d-1 absolute top-10 left-10 w-32 h-32 md:w-48 md:h-48 opacity-20">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" stroke="#F97316" stroke-width="1.5" fill="none"/>
                <ellipse cx="50" cy="50" rx="25" ry="45" stroke="#F97316" stroke-width="1" fill="none" opacity="0.5"/>
                <ellipse cx="50" cy="50" rx="45" ry="25" stroke="#F97316" stroke-width="1" fill="none" opacity="0.5"/>
                <circle cx="50" cy="50" r="8" fill="#F97316" opacity="0.3"/>
                <path d="M50 5 L50 95 M5 50 L95 50" stroke="#F97316" stroke-width="0.8" opacity="0.3"/>
            </svg>
        </div>
        
        <!-- Objet 2 - Pyramide / Triangle -->
        <div class="object-3d-2 absolute bottom-20 right-10 w-40 h-40 md:w-56 md:h-56 opacity-20">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="50,10 10,80 90,80" stroke="#3B82F6" stroke-width="1.5" fill="none"/>
                <line x1="50" y1="10" x2="50" y2="80" stroke="#3B82F6" stroke-width="0.8" opacity="0.5"/>
                <line x1="30" y1="45" x2="70" y2="45" stroke="#3B82F6" stroke-width="0.8" opacity="0.5"/>
                <line x1="20" y1="62" x2="80" y2="62" stroke="#3B82F6" stroke-width="0.8" opacity="0.5"/>
                <circle cx="50" cy="45" r="5" fill="#3B82F6" opacity="0.3"/>
            </svg>
        </div>
        
        <!-- Objet 3 - Hexagone / Bouclier -->
        <div class="object-3d-3 absolute top-1/3 right-20 w-28 h-28 md:w-40 md:h-40 opacity-20">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="50,5 85,25 85,65 50,85 15,65 15,25" stroke="#10B981" stroke-width="1.5" fill="none"/>
                <polygon points="50,15 75,30 75,60 50,75 25,60 25,30" stroke="#10B981" stroke-width="0.8" fill="none" opacity="0.5"/>
                <circle cx="50" cy="45" r="10" stroke="#10B981" stroke-width="1" fill="none" opacity="0.6"/>
                <circle cx="50" cy="45" r="4" fill="#10B981" opacity="0.4"/>
            </svg>
        </div>
        
        <!-- Effet de brillance supplémentaire -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full bg-[#F97316] opacity-5 blur-3xl"></div>
    </div>
    
    <!-- Carte principale -->
    <div class="relative z-10 max-w-lg w-full">
        <div class="bg-white rounded-3xl p-8 md:p-10 text-center shadow-2xl card-hover">
            
            <!-- Objets 3D dans la carte -->
            <div class="flex justify-center gap-4 mb-8">
                <!-- Objet 1 - Sphère flottante -->
                <div class="object-3d-1 w-16 h-16 md:w-20 md:h-20">
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="42" stroke="#F97316" stroke-width="2" fill="none"/>
                        <ellipse cx="50" cy="50" rx="22" ry="42" stroke="#F97316" stroke-width="1.5" fill="none" opacity="0.6"/>
                        <ellipse cx="50" cy="50" rx="42" ry="22" stroke="#F97316" stroke-width="1.5" fill="none" opacity="0.6"/>
                        <circle cx="50" cy="50" r="6" fill="#F97316" opacity="0.4"/>
                        <path d="M50 8 L50 92 M8 50 L92 50" stroke="#F97316" stroke-width="1" opacity="0.3"/>
                    </svg>
                </div>
                
                <!-- Objet 2 - Pyramide -->
                <div class="object-3d-2 w-16 h-16 md:w-20 md:h-20">
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="50,15 15,80 85,80" stroke="#3B82F6" stroke-width="2" fill="none"/>
                        <line x1="50" y1="15" x2="50" y2="80" stroke="#3B82F6" stroke-width="1" opacity="0.5"/>
                        <line x1="32" y1="47" x2="68" y2="47" stroke="#3B82F6" stroke-width="1" opacity="0.5"/>
                        <line x1="23" y1="63" x2="77" y2="63" stroke="#3B82F6" stroke-width="1" opacity="0.5"/>
                        <circle cx="50" cy="47" r="4" fill="#3B82F6" opacity="0.3"/>
                    </svg>
                </div>
                
                <!-- Objet 3 - Hexagone -->
                <div class="object-3d-3 w-16 h-16 md:w-20 md:h-20">
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="50,8 84,27 84,65 50,84 16,65 16,27" stroke="#10B981" stroke-width="2" fill="none"/>
                        <polygon points="50,18 74,32 74,58 50,72 26,58 26,32" stroke="#10B981" stroke-width="1" fill="none" opacity="0.5"/>
                        <circle cx="50" cy="45" r="8" stroke="#10B981" stroke-width="1.5" fill="none" opacity="0.6"/>
                        <circle cx="50" cy="45" r="3" fill="#10B981" opacity="0.4"/>
                    </svg>
                </div>
            </div>
            
            <!-- Titre -->
            <h1 class="text-2xl md:text-3xl font-bold text-[#0F172A] mb-4">
                Demande envoyée avec succès
            </h1>
            
            <!-- Message principal -->
            <p class="text-gray-600 leading-relaxed mb-6">
                Votre inscription en tant qu'artisan de paix a bien été enregistrée.
                Notre équipe va analyser votre organisation et valider votre accès.
            </p>
            
            <!-- Encadré informatif avec objet 3D intégré -->
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-2xl p-5 mb-6">
                <div class="flex items-center justify-center gap-3 mb-3">
                    <div class="w-8 h-8">
                        <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="42" stroke="#F97316" stroke-width="1.5" fill="none" opacity="0.6"/>
                            <path d="M50 25 L50 50 L65 60" stroke="#F97316" stroke-width="2" fill="none" stroke-linecap="round"/>
                            <circle cx="50" cy="50" r="3" fill="#F97316" opacity="0.5"/>
                        </svg>
                    </div>
                    <p class="text-orange-700 font-semibold">
                        Revenez dans environ 30 minutes pour accéder à votre espace dashboard.
                    </p>
                </div>
            </div>
            
            <!-- Bouton avec effet -->
            <a href="/"
               class="group relative bg-[#F97316] text-white px-8 py-3 rounded-xl font-semibold inline-flex items-center justify-center gap-2 transition-all duration-300 hover:bg-orange-600 hover:scale-105 shadow-lg shadow-orange-500/20">
                <span>Retour à l'accueil</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            
            <!-- Informations supplémentaires -->
            <p class="text-xs text-gray-400 mt-6">
                Un email de confirmation vous a été envoyé
            </p>
        </div>
    </div>
    
    <!-- Animation subtile au chargement -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const card = document.querySelector('.bg-white');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>