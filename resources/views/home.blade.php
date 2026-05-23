<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PeaceLink | Plateforme togolaise de prévention des conflits</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%230F172A'/%3E%3Cpath d='M50 25 L65 40 L60 55 L50 60 L40 55 L35 40 L50 25Z' fill='%23F97316'/%3E%3Cpath d='M50 60 L50 75' stroke='white' stroke-width='3' fill='none'/%3E%3Ccircle cx='50' cy='75' r='5' fill='white'/%3E%3C/svg%3E">
    <link rel="apple-touch-icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%230F172A'/%3E%3Cpath d='M50 25 L65 40 L60 55 L50 60 L40 55 L35 40 L50 25Z' fill='%23F97316'/%3E%3Cpath d='M50 60 L50 75' stroke='white' stroke-width='3' fill='none'/%3E%3Ccircle cx='50' cy='75' r='5' fill='white'/%3E%3C/svg%3E">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background-color: #F8FAFC; overflow-x: hidden; }
        
        /* Hero carrousel */
        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
        }
        .hero-slide.active { opacity: 1; }
        
        .hero-gradient-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.7) 0%, rgba(15, 23, 42, 0.5) 50%, rgba(15, 23, 42, 0.3) 100%);
        }
        
        .hero-content {
            position: relative;
            z-index: 10;
            max-width: 700px;
            margin: 0 auto;
            text-align: center;
            padding-top: 8rem;
        }
        
        .citation-text {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            text-shadow: 0 2px 15px rgba(0,0,0,0.3);
        }
        .citation-author {
            font-size: 1rem;
            opacity: 0.8;
            margin-top: 1rem;
            letter-spacing: 1px;
        }
        
        /* Boutons centrés juste sous le texte */
        .hero-buttons {
            position: relative;
            z-index: 20;
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.3s ease;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 60px;
            box-shadow: 0 10px 30px -5px rgba(249, 115, 22, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }
        .btn-primary:hover { transform: translateY(-4px); box-shadow: 0 20px 35px -8px rgba(249, 115, 22, 0.5); }
        
        .btn-outline {
            border: 2px solid white;
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.1);
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 60px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }
        .btn-outline:hover { background: rgba(255, 255, 255, 0.25); transform: translateY(-4px); }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card:hover { transform: translateY(-6px); box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.1); }
        
        .section-badge {
            display: inline-block;
            padding: 6px 14px;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.1) 0%, rgba(249, 115, 22, 0.05) 100%);
            color: #F97316;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .feature-icon {
            background: linear-gradient(135deg, #FEF3C7 0%, #FFEDD5 100%);
            transition: all 0.3s ease;
        }
        .feature-icon-blue { background: linear-gradient(135deg, #DBEAFE 0%, #EFF6FF 100%); }
        .feature-icon-dark { background: linear-gradient(135deg, #E0E7FF 0%, #EDF2F7 100%); }
        
        /* Navbar */
        .navbar-container { max-width: 1400px; margin: 0 auto; padding: 0 20px; }
        .navbar-wrapper {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 60px;
            margin: 16px 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .nav-link { position: relative; }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 0;
            height: 2px;
            background: #F97316;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }
        
        .carousel-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .carousel-dot.active { width: 28px; border-radius: 5px; background: #F97316; }
        
        .region-card { transition: all 0.3s ease; cursor: pointer; }
        .region-card:hover { transform: translateY(-4px); background: rgba(249, 115, 22, 0.15); border-color: #F97316; }
        
        .lang-selector {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: white;
        }
        .lang-selector:hover { background: rgba(255, 255, 255, 0.2); }
        .lang-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: #1E293B;
            border-radius: 12px;
            min-width: 140px;
            display: none;
            z-index: 100;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .lang-item { padding: 12px 16px; cursor: pointer; transition: background 0.2s; color: #E2E8F0; font-size: 14px; display: flex; align-items: center; gap: 8px; }
        .lang-item:hover { background: #F97316; color: white; }
        
        .scroll-progress { position: fixed; top: 0; left: 0; width: 0%; height: 3px; background: linear-gradient(90deg, #F97316, #EA580C); z-index: 1000; transition: width 0.1s ease; }
        
        .wave-divider { position: relative; bottom: 0; left: 0; width: 100%; overflow: hidden; line-height: 0; }
        .wave-divider svg { position: relative; display: block; width: calc(100% + 1.3px); height: 70px; }
        
        /* Carte Leaflet */
        #togoMap {
            height: 450px;
            width: 100%;
            border-radius: 24px;
            z-index: 1;
        }
        
        /* Mobile menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 320px;
            height: 100vh;
            background: #0F172A;
            z-index: 1000;
            transition: right 0.3s ease;
            padding: 80px 24px 24px;
            box-shadow: -5px 0 30px rgba(0,0,0,0.3);
        }
        .mobile-menu.open { right: 0; }
        .menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }
        .menu-overlay.open { display: block; }
        
        .partner-card { transition: all 0.4s ease; }
        .partner-card:hover { transform: translateY(-6px); }
        
        /* Footer sans bordure */
        footer .border-t {
            border-top: none !important;
        }
        
        @media (max-width: 768px) {
            .hero-content { padding-top: 4rem; }
            .citation-text { font-size: 1.5rem; }
            .hero-buttons { margin-top: 1.5rem; flex-direction: column; align-items: center; width: 100%; padding: 0 20px; gap: 1rem; }
            .btn-primary, .btn-outline { width: 100%; max-width: 280px; padding: 0.9rem 1.5rem; font-size: 1rem; justify-content: center; }
            .navbar-wrapper { margin: 12px 12px; border-radius: 40px; }
            .wave-divider svg { height: 35px; }
            #togoMap { height: 350px; }
        }
        
        @media (max-width: 480px) {
            .citation-text { font-size: 1.2rem; }
            .wave-divider svg { height: 25px; }
            #togoMap { height: 280px; }
            .btn-primary, .btn-outline { padding: 0.8rem 1.2rem; font-size: 0.9rem; }
        }
    </style>
</head>
<body>

    <div class="scroll-progress" id="scrollProgress"></div>

    <!-- Mobile Menu -->
    <div class="menu-overlay" id="menuOverlay" onclick="closeMobileMenu()"></div>
    <div class="mobile-menu" id="mobileMenu">
        <div class="flex flex-col gap-4">
            <a href="#accueil" class="text-white py-2 border-b border-white/10" onclick="closeMobileMenu()">Accueil</a>
            <a href="#mission" class="text-white py-2 border-b border-white/10" onclick="closeMobileMenu()">Mission</a>
            <a href="#action" class="text-white py-2 border-b border-white/10" onclick="closeMobileMenu()">Action</a>
            <a href="#engagement" class="text-white py-2 border-b border-white/10" onclick="closeMobileMenu()">Engagement</a>
            <a href="#partenaires" class="text-white py-2 border-b border-white/10" onclick="closeMobileMenu()">Partenaires</a>
            <a href="#forum" class="text-white py-2 border-b border-white/10" onclick="closeMobileMenu()">Forum</a>
            <div class="pt-4 flex flex-col gap-3">
                <a href="{{ route('login') }}" class="text-center text-[#F97316] border border-[#F97316]/30 rounded-full py-2">Admin</a>
                <a href="{{ route('register') }}" class="text-center text-white bg-white/10 rounded-full py-2">Artisan</a>
                <a href="{{ route('report.create') }}" class="text-center bg-[#F97316] rounded-full py-2">Signaler</a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="sticky top-4 z-50">
        <div class="navbar-wrapper">
            <nav class="text-white py-3">
                <div class="navbar-container">
                    <div class="flex justify-between items-center">
                        <div class="text-xl md:text-2xl font-bold flex items-center gap-2">
                            <span class="text-[#F97316]">Peace</span><span>Link</span>
                            <span class="text-xs bg-[#F97316] px-2 py-0.5 rounded-full">Togo</span>
                        </div>
                        <ul class="hidden md:flex gap-6 lg:gap-8 font-medium text-sm">
                            <li><a href="#accueil" class="nav-link">Accueil</a></li>
                            <li><a href="#mission" class="nav-link">Mission</a></li>
                            <li><a href="#action" class="nav-link">Action</a></li>
                            <li><a href="#engagement" class="nav-link">Engagement</a></li>
                            <li><a href="#partenaires" class="nav-link">Partenaires</a></li>
                            <li><a href="#forum" class="nav-link">Forum</a></li>
                        </ul>
                        <div class="hidden md:flex gap-3 items-center">
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-full text-sm text-[#F97316] bg-[#F97316]/15 border border-[#F97316]/30 hover:bg-[#F97316]/25 transition"><i class="fas fa-user-shield text-xs mr-1"></i> Admin</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-full text-sm text-white bg-white/10 border border-white/20 hover:bg-white/20 transition"><i class="fas fa-hand-peace text-xs mr-1"></i> Artisan</a>
                            <div class="relative">
                                <div class="lang-selector flex items-center gap-2" onclick="toggleLang()"><i class="fas fa-globe text-xs"></i><span>FR</span><i class="fas fa-chevron-down text-xs"></i></div>
                                <div class="lang-dropdown" id="langDropdown">
                                    <div class="lang-item" onclick="selectLang('FR')">🇫🇷 Français</div>
                                    <div class="lang-item" onclick="selectLang('EN')">🇬🇧 English</div>
                                    <div class="lang-item" onclick="selectLang('ES')">🇪🇸 Español</div>
                                </div>
                            </div>
                            <a href="{{ route('report.create') }}" class="bg-[#F97316] hover:bg-orange-600 px-5 py-2 rounded-full text-sm transition shadow-lg shadow-orange-500/25"><i class="fas fa-flag mr-1"></i> Signaler</a>
                        </div>
                        <button class="md:hidden text-white text-2xl" onclick="openMobileMenu()"><i class="fas fa-bars"></i></button>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Hero Section avec boutons juste sous le texte -->
    <section id="accueil" class="relative h-[90vh] overflow-hidden">
        <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1507126882445-434b04530d1a?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cGVhY2UlMjBkb3ZlfGVufDB8fDB8fHww')"></div>
        <div class="hero-slide" style="background-image: url('https://t4.ftcdn.net/jpg/03/11/72/27/240_F_311722772_Y8e82IcE8WAXTdBphqus6N24GE1gFXwe.jpg')"></div>
        <div class="hero-slide" style="background-image: url('https://t3.ftcdn.net/jpg/05/97/86/54/240_F_597865455_epy0yoJtM172EBa8EJ8mrAgFaSSqE3OH.jpg')"></div>
        <div class="hero-gradient-overlay"></div>
        
        <div class="hero-content text-white">
            <div class="citation-text" id="quoteText">"La paix n'est pas seulement l'absence de conflit, mais la présence de justice et de dialogue."</div>
            <div class="citation-author" id="quoteAuthor">— Proverbe togolais</div>
            
            <!-- Boutons juste sous le texte -->
            <div class="hero-buttons">
                <a href="{{ route('report.create') }}" class="btn-primary"><i class="fas fa-shield-alt text-xl"></i> Faire un signalement anonyme</a>
                <button class="btn-outline" onclick="document.getElementById('mission').scrollIntoView({behavior:'smooth'})"><i class="fas fa-info-circle text-xl"></i> Découvrir la plateforme</button>
            </div>
        </div>
        
        <div class="absolute bottom-20 left-0 right-0 flex justify-center gap-2 z-20">
            <div class="carousel-dot active" onclick="goToSlide(0)"></div>
            <div class="carousel-dot" onclick="goToSlide(1)"></div>
            <div class="carousel-dot" onclick="goToSlide(2)"></div>
        </div>
        
        <button class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 rounded-full p-3 z-20 transition" onclick="prevSlide()"><i class="fas fa-chevron-left text-white text-xl"></i></button>
        <button class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 rounded-full p-3 z-20 transition" onclick="nextSlide()"><i class="fas fa-chevron-right text-white text-xl"></i></button>
        
        <div class="wave-divider absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="#F8FAFC">
                <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
            </svg>
        </div>
    </section>

    <!-- Section Mission -->
    <section id="mission" class="relative py-20 px-4 md:px-12 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12" data-aos="fade-up">
                <div class="section-badge"><i class="fas fa-heart mr-1"></i> Notre raison d'être</div>
                <h2 class="text-3xl md:text-5xl font-bold text-[#0F172A] mb-4">Une mission nationale au service de la paix</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">PeaceLink Togo œuvre pour la prévention des conflits et la cohésion sociale sur l'ensemble du territoire togolais</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="glass-card rounded-2xl p-8" data-aos="fade-up" data-aos-delay="0">
                    <div class="feature-icon w-14 h-14 rounded-xl flex items-center justify-center mb-6"><i class="fas fa-shield-alt text-2xl text-[#F97316]"></i></div>
                    <h3 class="text-2xl font-bold mb-3 text-[#0F172A]">Protection et anonymat</h3>
                    <p class="text-gray-600">Signalez des incidents en toute sécurité sans crainte de représailles.</p>
                </div>
                <div class="glass-card rounded-2xl p-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-icon-blue w-14 h-14 rounded-xl flex items-center justify-center mb-6"><i class="fas fa-hand-peace text-2xl text-[#2563EB]"></i></div>
                    <h3 class="text-2xl font-bold mb-3 text-[#0F172A]">Médiation professionnelle</h3>
                    <p class="text-gray-600">Une équipe de médiateurs togolais certifiés intervient pour désamorcer les tensions.</p>
                </div>
                <div class="glass-card rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-icon-dark w-14 h-14 rounded-xl flex items-center justify-center mb-6"><i class="fas fa-chart-line text-2xl text-[#1E3A8A]"></i></div>
                    <h3 class="text-2xl font-bold mb-3 text-[#0F172A]">Analyse et prévention</h3>
                    <p class="text-gray-600">Des données anonymisées pour comprendre les dynamiques de tension.</p>
                </div>
            </div>
        </div>
        <div class="wave-divider absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="#FFFFFF">
                <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
            </svg>
        </div>
    </section>

    <!-- Section Action -->
    <section id="action" class="relative py-20 px-4 md:px-12 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div data-aos="fade-right">
                    <div class="section-badge"><i class="fas fa-bolt mr-1"></i> Comment nous agissons</div>
                    <h2 class="text-4xl md:text-5xl font-bold text-[#0F172A] mb-4">Une approche innovante de prévention</h2>
                    <p class="text-gray-600 text-lg mb-8">Notre plateforme combine technologie de pointe et expertise humaine pour offrir une réponse rapide et efficace.</p>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-[#FEF3C7] transition"><div class="w-10 h-10 bg-[#F97316]/10 rounded-lg flex items-center justify-center"><i class="fas fa-phone-alt text-[#F97316]"></i></div><div><h3 class="font-bold text-[#0F172A]">Signalement multicanal</h3><p class="text-gray-500 text-sm">Web, mobile, SMS - un accès simplifié pour tous</p></div></div>
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-[#DBEAFE] transition"><div class="w-10 h-10 bg-[#2563EB]/10 rounded-lg flex items-center justify-center"><i class="fas fa-clock text-[#2563EB]"></i></div><div><h3 class="font-bold text-[#0F172A]">Intervention sous 48h</h3><p class="text-gray-500 text-sm">Médiateurs mobilisables rapidement</p></div></div>
                        <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-[#E0E7FF] transition"><div class="w-10 h-10 bg-[#1E3A8A]/10 rounded-lg flex items-center justify-center"><i class="fas fa-chart-simple text-[#1E3A8A]"></i></div><div><h3 class="font-bold text-[#0F172A]">Suivi et évaluation</h3><p class="text-gray-500 text-sm">Reporting transparent sur l'impact</p></div></div>
                    </div>
                </div>
                <div id="programmePilote" data-aos="fade-left">
                    <div class="bg-gradient-to-br from-[#FEF3C7] to-[#DBEAFE] rounded-3xl p-8 shadow-xl">
                        <div class="bg-white rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100"><div class="w-10 h-10 bg-[#F97316] rounded-full flex items-center justify-center"><i class="fas fa-chart-line text-white text-sm"></i></div><div><div class="font-bold text-[#0F172A]">Programme pilote Togo</div><div class="text-xs text-gray-500">Chiffres clés en temps réel</div></div></div>
                            <div class="space-y-5">
                                <div><div class="flex justify-between mb-2"><span class="text-sm text-gray-500">Signalements traités</span><span class="font-bold text-2xl text-[#0F172A]" id="signalementsCount">0</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-[#F97316] h-2 rounded-full transition-all duration-1000" style="width:0%" id="signalementsBar"></div></div></div>
                                <div><div class="flex justify-between mb-2"><span class="text-sm text-gray-500">Taux de résolution</span><span class="font-bold text-2xl text-[#0F172A]" id="resolutionCount">0%</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-[#2563EB] h-2 rounded-full transition-all duration-1000" style="width:0%" id="resolutionBar"></div></div></div>
                                <div><div class="flex justify-between mb-2"><span class="text-sm text-gray-500">Régions couvertes</span><span class="font-bold text-2xl text-[#0F172A]" id="regionsCount">0</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-[#1E3A8A] h-2 rounded-full transition-all duration-1000" style="width:0%" id="regionsBar"></div></div></div>
                                <div><div class="flex justify-between mb-2"><span class="text-sm text-gray-500">Médiateurs actifs</span><span class="font-bold text-2xl text-[#0F172A]" id="mediateursCount">0</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-[#22C55E] h-2 rounded-full transition-all duration-1000" style="width:0%" id="mediateursBar"></div></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wave-divider absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="#0F172A">
                <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
            </svg>
        </div>
    </section>

    <!-- Section Engagement avec carte réelle du Togo -->
    <section id="engagement" class="relative py-20 px-4 md:px-12 bg-[#0F172A] text-white">
        <div class="max-w-7xl mx-auto text-center">
            <div class="inline-block bg-white/10 rounded-full px-4 py-1.5 text-sm mb-4">🇹🇬 Notre engagement</div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Opérationnel dans toutes les régions du Togo</h2>
            <p class="text-gray-300 max-w-3xl mx-auto mb-12">PeaceLink Togo déploie ses actions dans les 5 régions du pays, avec une équipe de médiateurs locaux pour une couverture nationale optimale.</p>
            
            <div class="mb-12">
                <div id="togoMap"></div>
                <p class="text-center text-gray-400 text-sm mt-4">Cliquez sur les marqueurs pour voir les informations sur chaque région</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="region-card bg-white/5 rounded-2xl p-4 border border-white/10" onclick="zoomToRegion(6.1319, 1.2228)">
                    <i class="fas fa-map-marker-alt text-[#F97316] text-2xl mb-2"></i>
                    <h3 class="font-bold">Maritime</h3>
                    <p class="text-gray-400 text-xs">Lomé, Tsévié, Aného</p>
                </div>
                <div class="region-card bg-white/5 rounded-2xl p-4 border border-white/10" onclick="zoomToRegion(7.5333, 1.1333)">
                    <i class="fas fa-map-marker-alt text-[#F97316] text-2xl mb-2"></i>
                    <h3 class="font-bold">Plateaux</h3>
                    <p class="text-gray-400 text-xs">Atakpamé, Kpalimé, Badou</p>
                </div>
                <div class="region-card bg-white/5 rounded-2xl p-4 border border-white/10" onclick="zoomToRegion(8.9833, 1.1333)">
                    <i class="fas fa-map-marker-alt text-[#F97316] text-2xl mb-2"></i>
                    <h3 class="font-bold">Centrale</h3>
                    <p class="text-gray-400 text-xs">Sokodé, Tchamba, Sotouboua</p>
                </div>
                <div class="region-card bg-white/5 rounded-2xl p-4 border border-white/10" onclick="zoomToRegion(9.5500, 1.1833)">
                    <i class="fas fa-map-marker-alt text-[#F97316] text-2xl mb-2"></i>
                    <h3 class="font-bold">Kara</h3>
                    <p class="text-gray-400 text-xs">Kara, Niamtougou, Kandé</p>
                </div>
                <div class="region-card bg-white/5 rounded-2xl p-4 border border-white/10" onclick="zoomToRegion(10.8667, 0.2000)">
                    <i class="fas fa-map-marker-alt text-[#F97316] text-2xl mb-2"></i>
                    <h3 class="font-bold">Savanes</h3>
                    <p class="text-gray-400 text-xs">Dapaong, Mango, Cinkassé</p>
                </div>
            </div>
        </div>
        <div class="wave-divider absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="#FFFFFF">
                <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
            </svg>
        </div>
    </section>

    <!-- Section Partenaires -->
    <section id="partenaires" class="relative py-20 px-4 md:px-12 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12"><div class="section-badge"><i class="fas fa-handshake mr-1"></i> Ils nous font confiance</div><h2 class="text-4xl md:text-5xl font-bold text-[#0F172A] mb-4">Nos partenaires</h2><p class="text-gray-500">Une reconnaissance nationale et internationale</p></div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-items-center">
                <div class="partner-card bg-gray-50 p-6 rounded-2xl w-full text-center"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Flag_of_Togo.svg/200px-Flag_of_Togo.svg.png" alt="Togo" class="h-16 object-contain mx-auto"><p class="text-xs text-gray-500 mt-3">République Togolaise</p></div>
                <div class="partner-card bg-gray-50 p-6 rounded-2xl w-full text-center"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/ef/United_Nations_Logo.svg/200px-United_Nations_Logo.svg.png" alt="ONU" class="h-16 object-contain mx-auto"><p class="text-xs text-gray-500 mt-3">Nations Unies</p></div>
                <div class="partner-card bg-gray-50 p-6 rounded-2xl w-full text-center"><img src="https://upload.wikimedia.org/wikipedia/fr/thumb/a/a8/Logo_OIF.svg/200px-Logo_OIF.svg.png" alt="OIF" class="h-16 object-contain mx-auto"><p class="text-xs text-gray-500 mt-3">OIF</p></div>
                <div class="partner-card bg-gray-50 p-6 rounded-2xl w-full text-center"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/African_Union_logo.svg/200px-African_Union_logo.svg.png" alt="UA" class="h-16 object-contain mx-auto"><p class="text-xs text-gray-500 mt-3">Union Africaine</p></div>
            </div>
        </div>
        <div class="wave-divider absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="#FEF3C7">
                <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
            </svg>
        </div>
    </section>

    <!-- Section Forum -->
    <section id="forum" class="py-20 px-4 md:px-12 bg-gradient-to-br from-[#FEF3C7] to-[#FFEDD5]">
        <div class="max-w-7xl mx-auto text-center">
            <div class="section-badge bg-white"><i class="fas fa-comments mr-1"></i> Espace citoyen</div>
            <h2 class="text-4xl md:text-5xl font-bold text-[#0F172A] mb-4">Rejoignez le Forum citoyen</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto mb-8">Échangez avec d'autres citoyens et contribuez à une communauté plus sereine.</p>
            <a href="/forum" class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-xl font-bold text-lg">Accéder au forum -></a>
        </div>
    </section>

    <!-- Footer sans bordure -->
    <footer class="bg-[#0F172A] text-white pt-16 pb-8 px-4 md:px-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div><div class="text-2xl font-bold mb-4"><span class="text-[#F97316]">Peace</span>Link <span class="text-xs bg-[#F97316]/20 px-2 py-0.5 rounded-full">Togo</span></div><p class="text-gray-400 text-sm">La technologie au service de la cohésion sociale au Togo.</p><div class="flex gap-4 mt-4"><a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#F97316] transition"><i class="fab fa-linkedin-in"></i></a><a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#F97316] transition"><i class="fab fa-twitter"></i></a><a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#F97316] transition"><i class="fab fa-facebook-f"></i></a></div></div>
                <div><h4 class="font-semibold mb-4 text-sm text-gray-400">Plateforme</h4><ul class="space-y-2 text-sm"><li><a href="#accueil" class="text-gray-400 hover:text-white">Accueil</a></li><li><a href="{{ route('report.create') }}" class="text-gray-400 hover:text-white">Signaler</a></li><li><a href="#mission" class="text-gray-400 hover:text-white">Notre méthode</a></li></ul></div>
                <div><h4 class="font-semibold mb-4 text-sm text-gray-400">Ressources</h4><ul class="space-y-2 text-sm"><li><a href="#" class="text-gray-400 hover:text-white">Guide</a></li><li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li><li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white">Devenir médiateur</a></li></ul></div>
                <div><h4 class="font-semibold mb-4 text-sm text-gray-400">Contact</h4><ul class="space-y-2 text-sm"><li class="text-gray-400"><i class="fas fa-envelope mr-2"></i> contact@peacelink.tg</li><li class="text-gray-400"><i class="fas fa-phone-alt mr-2"></i> +228 22 23 45 67</li><li class="text-gray-400"><i class="fas fa-map-marker-alt mr-2"></i> Lomé, Togo</li></ul></div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                <div>&copy; 2026 PeaceLink Togo. Tous droits réservés.</div>
                <div class="flex gap-6"><a href="#" class="hover:text-white transition">Confidentialité</a><a href="#" class="hover:text-white transition">Conditions</a></div>
            </div>
        </div>
    </footer>

    <script>
        let togoMap;
        
        function initTogoMap() {
            togoMap = L.map('togoMap').setView([8.5, 1.1], 7);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 19
            }).addTo(togoMap);
            
            const regions = [
                { name: "Maritime", lat: 6.1319, lng: 1.2228, capital: "Lomé", cities: "Lomé, Tsévié, Aného" },
                { name: "Plateaux", lat: 7.5333, lng: 1.1333, capital: "Atakpamé", cities: "Atakpamé, Kpalimé, Badou" },
                { name: "Centrale", lat: 8.9833, lng: 1.1333, capital: "Sokodé", cities: "Sokodé, Tchamba, Sotouboua" },
                { name: "Kara", lat: 9.5500, lng: 1.1833, capital: "Kara", cities: "Kara, Niamtougou, Kandé" },
                { name: "Savanes", lat: 10.8667, lng: 0.2000, capital: "Dapaong", cities: "Dapaong, Mango, Cinkassé" }
            ];
            
            regions.forEach(region => {
                const marker = L.marker([region.lat, region.lng]).addTo(togoMap);
                marker.bindPopup(`
                    <div style="font-family: Inter;">
                        <strong style="color:#F97316; font-size:16px;">${region.name}</strong><br>
                        <strong>Chef-lieu :</strong> ${region.capital}<br>
                        <strong>Villes principales :</strong> ${region.cities}<br>
                        <hr style="margin:8px 0">
                        <em>PeaceLink actif dans toute la région</em>
                    </div>
                `);
            });
        }
        
        function zoomToRegion(lat, lng) {
            togoMap.setView([lat, lng], 10);
        }
        
        AOS.init({ duration: 800, once: true, offset: 100 });
        
        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            document.getElementById('scrollProgress').style.width = (winScroll / height) * 100 + '%';
        });
        
        const quotes = [
            { text: '"La paix n\'est pas seulement l\'absence de conflit, mais la présence de justice et de dialogue."', author: "— Proverbe togolais" },
            { text: '"L\'union fait la force. Ensemble, nous sommes plus forts pour construire un Togo de paix."', author: "— Sagesse togolaise" },
            { text: '"Un Togo uni est un Togo qui avance. La paix est notre plus belle richesse."', author: "— Valeurs togolaises" }
        ];
        
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        let autoSlideInterval;
        
        function showSlide(index) {
            slides.forEach((s, i) => s.classList.toggle('active', i === index));
            dots.forEach((d, i) => d.classList.toggle('active', i === index));
            document.getElementById('quoteText').textContent = quotes[index].text;
            document.getElementById('quoteAuthor').textContent = quotes[index].author;
            currentSlide = index;
        }
        function nextSlide() { let n = currentSlide + 1; if (n >= slides.length) n = 0; showSlide(n); resetAuto(); }
        function prevSlide() { let p = currentSlide - 1; if (p < 0) p = slides.length - 1; showSlide(p); resetAuto(); }
        function goToSlide(i) { showSlide(i); resetAuto(); }
        function startAuto() { autoSlideInterval = setInterval(() => nextSlide(), 6000); }
        function resetAuto() { clearInterval(autoSlideInterval); startAuto(); }
        startAuto();
        
        function animateValue(el, start, end, duration, suffix='') {
            let startT = null;
            const step = (ts) => {
                if (!startT) startT = ts;
                const progress = Math.min((ts - startT) / duration, 1);
                el.innerHTML = Math.floor(progress * (end - start) + start) + suffix;
                if (progress < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        }
        
        async function fetchStats() {
            try {
                const res = await fetch('/api/stats');
                const data = await res.json();
                const s = data.signalements || 847, r = data.resolution || 92, reg = data.regions || 5, m = data.mediateurs || 48;
                animateValue(document.getElementById('signalementsCount'), 0, s, 2000, '');
                animateValue(document.getElementById('resolutionCount'), 0, r, 2000, '%');
                animateValue(document.getElementById('regionsCount'), 0, reg, 2000, '');
                animateValue(document.getElementById('mediateursCount'), 0, m, 2000, '');
                setTimeout(() => {
                    document.getElementById('signalementsBar').style.width = Math.min((s/1000)*100,100)+'%';
                    document.getElementById('resolutionBar').style.width = r+'%';
                    document.getElementById('regionsBar').style.width = (reg/5)*100+'%';
                    document.getElementById('mediateursBar').style.width = Math.min((m/100)*100,100)+'%';
                }, 500);
            } catch(e) { console.error(e); }
        }
        
        const obs = new IntersectionObserver((entries) => { entries.forEach(e => { if(e.isIntersecting){ fetchStats(); obs.unobserve(e.target); } }); }, { threshold: 0.3 });
        const prog = document.getElementById('programmePilote'); if(prog) obs.observe(prog);
        
        function toggleLang() { document.getElementById('langDropdown').style.display = document.getElementById('langDropdown').style.display === 'block' ? 'none' : 'block'; }
        function selectLang(l) { document.querySelector('.lang-selector span').textContent = l; document.getElementById('langDropdown').style.display = 'none'; }
        document.addEventListener('click', (e) => { const s = document.querySelector('.lang-selector'); const d = document.getElementById('langDropdown'); if(s && !s.contains(e.target)) d.style.display = 'none'; });
        
        function openMobileMenu() { document.getElementById('mobileMenu').classList.add('open'); document.getElementById('menuOverlay').classList.add('open'); }
        function closeMobileMenu() { document.getElementById('mobileMenu').classList.remove('open'); document.getElementById('menuOverlay').classList.remove('open'); }
        
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', function(e) {
                e.preventDefault(); closeMobileMenu();
                const t = document.querySelector(this.getAttribute('href'));
                if(t) t.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
        
        initTogoMap();
    </script>
</body>
</html>