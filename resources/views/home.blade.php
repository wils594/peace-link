<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeaceLink | Plateforme togolaise de prévention des conflits</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        
        /* Styles pour le carrousel */
        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
            background-size: cover;
            background-position: center;
        }
        
        .hero-slide.active {
            opacity: 1;
        }
        
        .hero-gradient-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, rgba(15, 23, 42, 0.88) 0%, rgba(15, 23, 42, 0.75) 100%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-scale:hover {
            transform: translateY(-4px);
        }
        
        .section-badge {
            display: inline-block;
            padding: 6px 14px;
            background: rgba(249, 115, 22, 0.1);
            color: #F97316;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            margin-bottom: 1rem;
        }
        
        .card-shadow {
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.05);
        }
        
        .feature-icon {
            background: linear-gradient(135deg, #FEF3C7 0%, #FFEDD5 100%);
        }
        
        .feature-icon-blue {
            background: linear-gradient(135deg, #DBEAFE 0%, #EFF6FF 100%);
        }
        
        .feature-icon-dark {
            background: linear-gradient(135deg, #E0E7FF 0%, #EDF2F7 100%);
        }
        
        .btn-primary {
            background: #F97316;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background: #EA580C;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.3);
        }
        
        .btn-outline {
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
        }
        
        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }
        
        .nav-link {
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: #F97316;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Indicateurs du carrousel */
        .carousel-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .carousel-dot.active {
            width: 28px;
            border-radius: 5px;
            background: #F97316;
        }
        
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
            animation: fadeInUp 0.8s ease-out;
        }
        
        /* Compteur animé */
        .counter-value {
            transition: all 0.3s ease;
        }
        
        /* Sélecteur de langue */
        .lang-selector {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: white;
        }
        
        .lang-selector:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .lang-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: #1E293B;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
            min-width: 140px;
            display: none;
            z-index: 100;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .lang-item {
            padding: 12px 16px;
            cursor: pointer;
            transition: background 0.2s;
            color: #E2E8F0;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .lang-item:hover {
            background: #F97316;
            color: white;
        }
        
        /* Admin buttons */
        .admin-login-btn {
            background: rgba(249, 115, 22, 0.15);
            border: 1px solid rgba(249, 115, 22, 0.3);
            transition: all 0.2s ease;
        }
        
        .admin-login-btn:hover {
            background: rgba(249, 115, 22, 0.25);
            border-color: rgba(249, 115, 22, 0.5);
        }
        
        .admin-register-btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.2s ease;
        }
        
        .admin-register-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>

    <!-- Navigation nationale -->
    <nav class="bg-[#0F172A]/95 backdrop-blur-md text-white py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50 border-b border-white/10">
        <div class="text-2xl font-bold flex items-center gap-2 tracking-tight">
            <span class="text-[#F97316]">Peace</span>
            <span>Link</span>
            <span class="text-xs bg-[#F97316] px-2 py-0.5 rounded-full ml-2 font-normal text-white">Beta</span>
        </div>
        
        <ul class="hidden md:flex gap-10 font-medium text-sm">
            <li><a href="#accueil" class="nav-link hover:text-[#F97316] transition">Accueil</a></li>
            <li><a href="#mission" class="nav-link hover:text-[#F97316] transition">Notre mission</a></li>
            <li><a href="#action" class="nav-link hover:text-[#F97316] transition">Notre action</a></li>
            <li><a href="#engagement" class="nav-link hover:text-[#F97316] transition">Engagement</a></li>
            <li><a href="#partenaires" class="nav-link hover:text-[#F97316] transition">Partenaires</a></li>
        </ul>

        <div class="flex gap-3 items-center">
<!-- Boutons Admin -->
<div class="hidden md:flex gap-2 mr-2">

    <a href="{{ route('login') }}"
       class="admin-login-btn px-4 py-2 rounded-full font-semibold text-sm transition flex items-center gap-2 text-[#F97316]">

        <i class="fas fa-user-shield text-xs"></i>

        <span>Admin</span>

    </a>

    <a href="{{ route('register') }}"
       class="admin-register-btn px-4 py-2 rounded-full font-semibold text-sm transition flex items-center gap-2 text-white">

        <i class="fas fa-user-plus text-xs"></i>

        <span>Register</span>

    </a>

</div>
            
            <div class="relative">
                <div class="lang-selector flex items-center gap-2" onclick="toggleLang()">
                    <i class="fas fa-globe text-xs"></i>
                    <span>FR</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>
                <div class="lang-dropdown" id="langDropdown">
                    <div class="lang-item" onclick="selectLang('FR')">🇫🇷 Français</div>
                    <div class="lang-item" onclick="selectLang('EN')">🇬🇧 English</div>
                    <div class="lang-item" onclick="selectLang('ES')">🇪🇸 Español</div>
                    <div class="lang-item" onclick="selectLang('DE')">🇩🇪 Deutsch</div>
                </div>
            </div>
            <a href="#signaler" class="bg-[#F97316] hover:bg-orange-600 px-6 py-2 rounded-full font-semibold text-sm transition shadow-lg shadow-orange-500/20">
                Signaler
            </a>
        </div>
    </nav>

    <!-- Hero section avec carrousel d'images -->
    <section id="accueil" class="relative h-[85vh] overflow-hidden">
        <!-- Slides du carrousel -->
        <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=1920')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?auto=format&fit=crop&q=80&w=1920')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?auto=format&fit=crop&q=80&w=1920')"></div>
        
        <div class="hero-gradient-overlay"></div>
        
        <div class="relative h-full flex items-center justify-center text-center text-white px-6 z-10 max-w-7xl mx-auto">
            <div class="max-w-4xl animate-fadeInUp">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-6 text-sm">
                    <span class="w-2 h-2 bg-[#F97316] rounded-full animate-pulse"></span>
                    <span>Plateforme nationale · Prévention des conflits au Togo</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6 tracking-tight">
                    Ensemble pour un 
                    <span class="text-[#F97316] relative inline-block">
                        Togo uni et paisible
                        <svg class="absolute -bottom-2 left-0 w-full" height="8" viewBox="0 0 200 8" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 4 L200 4" stroke="#F97316" stroke-width="3" stroke-dasharray="6 6" fill="none"/>
                        </svg>
                    </span>
                </h1>
                <p class="text-xl text-gray-200 mb-10 leading-relaxed max-w-2xl mx-auto">
                    PeaceLink Togo est la première plateforme citoyenne pour signaler anonymement les tensions 
                    communautaires et prévenir l'escalade des conflits sur l'ensemble du territoire national.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="btn-primary px-8 py-4 rounded-xl font-bold text-lg flex items-center justify-center gap-2">
                        Faire un signalement anonyme
                    </button>
                    <button class="btn-outline px-8 py-4 rounded-xl font-bold text-lg flex items-center justify-center gap-2">
                        Découvrir la plateforme
                    </button>
                </div>
                <div class="mt-8 text-sm text-gray-300">
                    <i class="fas fa-lock mr-1"></i> 100% anonyme · <i class="fas fa-clock ml-2 mr-1"></i> Intervention sous 48h · <i class="fas fa-map-marker-alt ml-2 mr-1"></i> Disponible dans toutes les régions du Togo
                </div>
            </div>
        </div>
        
        <!-- Indicateurs du carrousel -->
        <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-2 z-20">
            <div class="carousel-dot active" onclick="goToSlide(0)"></div>
            <div class="carousel-dot" onclick="goToSlide(1)"></div>
            <div class="carousel-dot" onclick="goToSlide(2)"></div>
        </div>
        
        <!-- Flèches de navigation -->
        <button class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 rounded-full p-3 z-20 transition" onclick="prevSlide()">
            <i class="fas fa-chevron-left text-white text-xl"></i>
        </button>
        <button class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 rounded-full p-3 z-20 transition" onclick="nextSlide()">
            <i class="fas fa-chevron-right text-white text-xl"></i>
        </button>
        
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" fill="#F8FAFC">
                <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,80L1360,80C1280,80,1120,80,960,80C800,80,640,80,480,80C320,80,160,80,80,80L0,80Z"></path>
            </svg>
        </div>
    </section>

    <!-- Section Notre mission -->
    <section id="mission" class="py-24 px-6 md:px-12 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="section-badge">
                    Notre raison d'être
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-[#0F172A] mb-4 tracking-tight">
                    Une mission nationale au service de la paix
                </h2>
                <p class="text-[#64748B] text-lg max-w-2xl mx-auto">
                    PeaceLink Togo œuvre pour la prévention des conflits et la cohésion sociale sur l'ensemble du territoire togolais
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="glass-card rounded-2xl p-8 card-shadow hover-scale transition-all group">
                    <div class="feature-icon w-14 h-14 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-shield-alt text-2xl text-[#F97316]"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-[#0F172A]">Protection et anonymat</h3>
                    <p class="text-[#64748B] leading-relaxed">
                        Signalez des incidents en toute sécurité sans crainte de représailles. 
                        Notre système garantit la protection absolue de votre identité.
                    </p>
                </div>

                <div class="glass-card rounded-2xl p-8 card-shadow hover-scale transition-all group">
                    <div class="feature-icon-blue w-14 h-14 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-hand-peace text-2xl text-[#2563EB]"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-[#0F172A]">Médiation professionnelle</h3>
                    <p class="text-[#64748B] leading-relaxed">
                        Une équipe de médiateurs togolais certifiés intervient pour désamorcer 
                        les tensions et rétablir le dialogue entre les communautés.
                    </p>
                </div>

                <div class="glass-card rounded-2xl p-8 card-shadow hover-scale transition-all group">
                    <div class="feature-icon-dark w-14 h-14 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <i class="fas fa-chart-line text-2xl text-[#1E3A8A]"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-[#0F172A]">Analyse et prévention</h3>
                    <p class="text-[#64748B] leading-relaxed">
                        Des données anonymisées pour comprendre les dynamiques de tension 
                        et anticiper les risques sur le territoire togolais.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Notre action -->
    <section id="action" class="py-24 px-6 md:px-12 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="section-badge">
                        Comment nous agissons
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-[#0F172A] mb-4 tracking-tight">
                        Une approche innovante de prévention
                    </h2>
                    <p class="text-[#64748B] text-lg mb-8 leading-relaxed">
                        Notre plateforme combine technologie de pointe et expertise humaine pour offrir 
                        une réponse rapide et efficace face aux tensions communautaires au Togo.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-[#FEF3C7] transition">
                            <div class="w-10 h-10 bg-[#F97316]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone-alt text-[#F97316]"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#0F172A] mb-1">Signalement multicanal</h3>
                                <p class="text-[#64748B] text-sm">Web, mobile, SMS ou ligne verte - un accès simplifié pour tous les Togolais</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-[#DBEAFE] transition">
                            <div class="w-10 h-10 bg-[#2563EB]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-[#2563EB]"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#0F172A] mb-1">Intervention sous 48h</h3>
                                <p class="text-[#64748B] text-sm">Une équipe de médiateurs mobilisable rapidement sur tout le territoire</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-[#E0E7FF] transition">
                            <div class="w-10 h-10 bg-[#1E3A8A]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-chart-simple text-[#1E3A8A]"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#0F172A] mb-1">Suivi et évaluation</h3>
                                <p class="text-[#64748B] text-sm">Un reporting transparent sur l'impact de nos actions au Togo</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="relative" id="programmePilote">
                    <div class="bg-gradient-to-br from-[#FEF3C7] to-[#DBEAFE] rounded-3xl p-8 shadow-xl">
                        <div class="bg-white rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
                                <div class="w-10 h-10 bg-[#F97316] rounded-full flex items-center justify-center">
                                    <i class="fas fa-chart-line text-white text-sm"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-[#0F172A]">Programme pilote Togo</div>
                                    <div class="text-xs text-[#64748B]">Chiffres clés - Mis à jour en temps réel</div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-[#64748B]">Signalements traités</span>
                                        <span class="font-bold text-[#0F172A] text-xl" id="signalementsCount">0</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-[#F97316] h-2 rounded-full transition-all duration-1000" style="width: 0%" id="signalementsBar"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-[#64748B]">Taux de résolution</span>
                                        <span class="font-bold text-[#0F172A] text-xl" id="resolutionCount">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-[#2563EB] h-2 rounded-full transition-all duration-1000" style="width: 0%" id="resolutionBar"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-[#64748B]">Régions couvertes</span>
                                        <span class="font-bold text-[#0F172A] text-xl" id="regionsCount">0</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-[#1E3A8A] h-2 rounded-full transition-all duration-1000" style="width: 0%" id="regionsBar"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-[#64748B]">Médiateurs actifs</span>
                                        <span class="font-bold text-[#0F172A] text-xl" id="mediateursCount">0</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-[#22C55E] h-2 rounded-full transition-all duration-1000" style="width: 0%" id="mediateursBar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-[#F97316] rounded-full opacity-20 blur-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Engagement national -->
    <section id="engagement" class="py-24 px-6 md:px-12 bg-[#0F172A] text-white">
        <div class="max-w-7xl mx-auto text-center">
            <div class="inline-block bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 text-sm mb-4">
                Notre engagement
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">
                Opérationnel dans toutes les régions du Togo
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto mb-12 leading-relaxed">
                PeaceLink Togo déploie ses actions dans les 5 régions du pays, avec une équipe de médiateurs locaux 
                et des partenaires de confiance pour une couverture nationale optimale.
            </p>
            
            <div class="grid md:grid-cols-5 gap-6 text-left">
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-5 border border-white/10 hover:bg-white/10 transition">
                    <i class="fas fa-map-marker-alt text-[#F97316] text-2xl mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">Maritime</h3>
                    <p class="text-gray-400 text-xs">Région de Lomé, Tsévié, Aného</p>
                </div>
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-5 border border-white/10 hover:bg-white/10 transition">
                    <i class="fas fa-map-marker-alt text-[#F97316] text-2xl mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">Plateaux</h3>
                    <p class="text-gray-400 text-xs">Atakpamé, Kpalimé, Badou</p>
                </div>
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-5 border border-white/10 hover:bg-white/10 transition">
                    <i class="fas fa-map-marker-alt text-[#F97316] text-2xl mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">Centrale</h3>
                    <p class="text-gray-400 text-xs">Sokodé, Tchamba, Sotouboua</p>
                </div>
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-5 border border-white/10 hover:bg-white/10 transition">
                    <i class="fas fa-map-marker-alt text-[#F97316] text-2xl mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">Kara</h3>
                    <p class="text-gray-400 text-xs">Kara, Niamtougou, Kandé</p>
                </div>
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-5 border border-white/10 hover:bg-white/10 transition">
                    <i class="fas fa-map-marker-alt text-[#F97316] text-2xl mb-3"></i>
                    <h3 class="font-bold text-lg mb-1">Savanes</h3>
                    <p class="text-gray-400 text-xs">Dapaong, Mango, Cinkassé</p>
                </div>
            </div>
            
            <!-- Carte simplifiée du Togo -->
            <div class="mt-12 bg-white/5 rounded-2xl p-6 border border-white/10">
                <div class="flex justify-center">
                    <svg width="400" height="300" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0" y="0" width="400" height="300" rx="12" fill="rgba(255,255,255,0.05)"/>
                        <text x="200" y="45" text-anchor="middle" fill="#F97316" font-size="14" font-weight="bold">TOGO</text>
                        <path d="M200 70 L220 80 L215 100 L230 115 L225 130 L240 145 L235 160 L245 175 L240 190 L250 205 L245 215 L230 210 L220 220 L210 215 L200 220 L190 215 L180 220 L170 210 L155 215 L145 205 L155 190 L150 175 L160 160 L155 145 L170 130 L165 115 L180 100 L175 80 L195 70 L200 70Z" 
                              fill="rgba(249,115,22,0.2)" stroke="#F97316" stroke-width="2"/>
                        <circle cx="200" cy="145" r="3" fill="#F97316"/>
                        <circle cx="200" cy="130" r="4" fill="#F97316" />
                        <text x="205" y="128" fill="white" font-size="9">Lomé</text>
                        <circle cx="195" cy="170" r="4" fill="#F97316" />
                        <text x="200" y="168" fill="white" font-size="9">Atakpamé</text>
                        <circle cx="215" cy="190" r="4" fill="#F97316" />
                        <text x="220" y="188" fill="white" font-size="9">Sokodé</text>
                        <circle cx="210" cy="215" r="4" fill="#F97316" />
                        <text x="215" y="213" fill="white" font-size="9">Kara</text>
                        <circle cx="225" cy="240" r="4" fill="#F97316" />
                        <text x="230" y="238" fill="white" font-size="9">Dapaong</text>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Partenaires -->
    <section id="partenaires" class="py-20 px-6 md:px-12 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <div class="section-badge">
                    Ils nous font confiance
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-[#0F172A] mb-4">Nos partenaires institutionnels</h2>
                <p class="text-[#64748B] text-lg max-w-2xl mx-auto">
                    Une reconnaissance nationale et internationale pour une cause universelle
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-items-center">
                <div class="opacity-70 hover:opacity-100 transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Flag_of_Togo.svg/200px-Flag_of_Togo.svg.png" alt="République Togolaise" class="h-16 object-contain">
                </div>
                <div class="opacity-70 hover:opacity-100 transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/ef/United_Nations_Logo.svg/200px-United_Nations_Logo.svg.png" alt="ONU" class="h-16 object-contain">
                </div>
                <div class="opacity-70 hover:opacity-100 transition">
                    <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/a/a8/Logo_OIF.svg/200px-Logo_OIF.svg.png" alt="OIF" class="h-16 object-contain">
                </div>
                <div class="opacity-70 hover:opacity-100 transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/African_Union_logo.svg/200px-African_Union_logo.svg.png" alt="Union Africaine" class="h-16 object-contain">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer national -->
    <footer class="bg-[#0F172A] text-white pt-16 pb-8 px-6 md:px-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="text-2xl font-bold mb-4 flex items-center gap-2">
                        <span class="text-[#F97316]">Peace</span>Link
                        <span class="text-xs bg-[#F97316]/20 px-2 py-0.5 rounded-full">Togo</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        La technologie au service de la cohésion sociale et de la prévention des crises au Togo.
                    </p>
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#F97316] transition">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#F97316] transition">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#F97316] transition">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4 text-sm uppercase tracking-wider text-gray-400">Plateforme</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Accueil</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Faire un signalement</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Notre méthode</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Études d'impact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4 text-sm uppercase tracking-wider text-gray-400">Ressources</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Guide du signalement</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Devenir médiateur</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Rapports annuels</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4 text-sm uppercase tracking-wider text-gray-400">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="text-gray-400"><i class="fas fa-envelope mr-2"></i> contact@peacelink.tg</li>
                        <li class="text-gray-400"><i class="fas fa-phone-alt mr-2"></i> +228 22 23 45 67</li>
                        <li class="text-gray-400"><i class="fas fa-map-marker-alt mr-2"></i> Lomé, Togo</li>
                        <li class="text-gray-400"><i class="fas fa-clock mr-2"></i> Lun-Ven: 8h-18h</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                <div>&copy; 2026 PeaceLink Togo. Tous droits réservés.</div>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition">Confidentialité</a>
                    <a href="#" class="hover:text-white transition">Conditions d'utilisation</a>
                    <a href="#" class="hover:text-white transition">Accessibilité</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Carrousel automatique
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        let autoSlideInterval;
        
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            currentSlide = index;
        }
        
        function nextSlide() {
            let next = currentSlide + 1;
            if (next >= slides.length) next = 0;
            showSlide(next);
            resetAutoSlide();
        }
        
        function prevSlide() {
            let prev = currentSlide - 1;
            if (prev < 0) prev = slides.length - 1;
            showSlide(prev);
            resetAutoSlide();
        }
        
        function goToSlide(index) {
            showSlide(index);
            resetAutoSlide();
        }
        
        function startAutoSlide() {
            autoSlideInterval = setInterval(() => {
                nextSlide();
            }, 5000);
        }
        
        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }
        
        startAutoSlide();
        
        // Compteurs animés dynamiques
        function animateValue(element, start, end, duration, suffix = '') {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const value = Math.floor(progress * (end - start) + start);
                element.innerHTML = value + suffix;
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }
        
        function updateBars() {
            const signalements = document.getElementById('signalementsCount');
            const resolution = document.getElementById('resolutionCount');
            const regions = document.getElementById('regionsCount');
            const mediateurs = document.getElementById('mediateursCount');
            
            const signalementsBar = document.getElementById('signalementsBar');
            const resolutionBar = document.getElementById('resolutionBar');
            const regionsBar = document.getElementById('regionsBar');
            const mediateursBar = document.getElementById('mediateursBar');
            
            const targetSignalements = 847;
            const targetResolution = 92;
            const targetRegions = 5;
            const targetMediateurs = 48;
            
            animateValue(signalements, 0, targetSignalements, 2000, '');
            animateValue(resolution, 0, targetResolution, 2000, '%');
            animateValue(regions, 0, targetRegions, 2000, '');
            animateValue(mediateurs, 0, targetMediateurs, 2000, '');
            
            setTimeout(() => {
                signalementsBar.style.width = '84%';
                resolutionBar.style.width = '92%';
                regionsBar.style.width = '100%';
                mediateursBar.style.width = '78%';
            }, 500);
        }
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateBars();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });
        
        const programmeSection = document.getElementById('programmePilote');
        if (programmeSection) {
            observer.observe(programmeSection);
        }
        
        // Sélecteur de langue
        function toggleLang() {
            const dropdown = document.getElementById('langDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
        
        function selectLang(lang) {
            const langSpan = document.querySelector('.lang-selector span');
            langSpan.textContent = lang;
            document.getElementById('langDropdown').style.display = 'none';
        }
        
        document.addEventListener('click', function(event) {
            const selector = document.querySelector('.lang-selector');
            const dropdown = document.getElementById('langDropdown');
            if (selector && !selector.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });
        
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>