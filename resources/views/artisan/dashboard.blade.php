{{-- resources/views/artisan/dashboard.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeaceLink | Dashboard Artisan</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        *{
            font-family: 'Inter', sans-serif;
        }

        body{
            background: #F8FAFC;
        }

        /* Couleurs officielles PeaceLink */
        :root {
            --primary: #0F172A;
            --secondary: #F97316;
            --light-bg: #F8FAFC;
            --text-secondary: #64748B;
            --success: #22C55E;
            --alert: #EF4444;
        }

        .sidebar{
            background: linear-gradient(180deg, #0F172A 0%, #1E293B 100%);
        }

        .card{
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            border: 1px solid #E2E8F0;
        }

        .input{
            border: 1.5px solid #E2E8F0;
            transition: .2s;
        }

        .input:focus{
            outline: none;
            border-color: #F97316;
            box-shadow: 0 0 0 4px rgba(249,115,22,.1);
        }

        .btn{
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: .2s;
        }

        .btn:hover{
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(249,115,22,.25);
        }

        .btn-outline{
            border: 2px solid #F97316;
            background: transparent;
            transition: .2s;
        }

        .btn-outline:hover{
            background: #F97316;
            color: white;
            transform: translateY(-2px);
        }

        /* Animation hover pour les cartes */
        .stat-card{
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover{
            transform: translateY(-4px);
            box-shadow: 0 20px 35px -12px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="sidebar w-[280px] text-white p-6 hidden lg:flex flex-col justify-between">

        <div>

            <div class="flex items-center gap-3 mb-10">

                <div class="w-14 h-14 rounded-2xl bg-orange-500/20 flex items-center justify-center">
                    <i class="fas fa-hand-peace text-2xl text-orange-500"></i>
                </div>

                <div>
                    <h1 class="text-2xl font-black">
                        <span class="text-orange-500">Peace</span>Link
                    </h1>

                    <p class="text-xs text-gray-400">
                        Artisan Dashboard
                    </p>
                </div>

            </div>

            <!-- PROFILE -->
            <div class="bg-white/5 rounded-2xl p-4 mb-8">

                <div class="flex items-center gap-3">

                    <div class="w-14 h-14 rounded-full bg-orange-500 flex items-center justify-center text-xl font-bold">
                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                    </div>

                    <div>
                        <h3 class="font-bold">
                            {{ Auth::user()->name }}
                        </h3>

                        <p class="text-sm text-gray-400">
                            {{ Auth::user()->organization_name ?? 'Artisan de paix' }}
                        </p>
                    </div>

                </div>

            </div>

            <!-- MENU COMPLET -->
            <nav class="space-y-2">

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-orange-500 text-white">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    Dashboard
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition">
                    <i class="fas fa-newspaper w-5"></i>
                    Mes publications
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition">
                    <i class="fas fa-plus-circle w-5"></i>
                    Nouvelle publication
                </a>

                <a href="/forum" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition">
                    <i class="fas fa-comments w-5"></i>
                    Forum public
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition">
                    <i class="fas fa-chart-line w-5"></i>
                    Statistiques
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition">
                    <i class="fas fa-credit-card w-5"></i>
                    Abonnement
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition">
                    <i class="fas fa-user w-5"></i>
                    Mon profil
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition">
                    <i class="fas fa-cog w-5"></i>
                    Paramètres
                </a>

            </nav>

        </div>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="w-full bg-red-500/20 hover:bg-red-500 transition py-3 rounded-xl font-semibold text-red-300 hover:text-white border border-red-500/30">
                <i class="fas fa-sign-out-alt mr-2"></i>
                Déconnexion
            </button>
        </form>

    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-6 lg:p-10">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>
                <h2 class="text-3xl font-black text-slate-800">
                    Bonjour {{ explode(' ', Auth::user()->name)[0] }}
                </h2>

                <p class="text-slate-500 mt-1">
                    Bienvenue sur votre espace artesan. Publiez vos actions pour la paix et la cohésion sociale.
                </p>
            </div>

            <div class="card px-5 py-4">
                <p class="text-sm text-slate-500">
                    Statut du compte
                </p>

                <div class="flex items-center gap-2 mt-1">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>

                    <span class="font-semibold text-slate-700">
                        Compte approuvé
                    </span>
                </div>
            </div>

        </div>

        <!-- ALERT SUCCESS -->
        @if(session('success'))

            <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>

        @endif

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <div class="card p-6 stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">
                            Mes publications
                        </p>

                        <h3 class="text-3xl font-black text-slate-800 mt-2">
                            {{ $postsCount ?? 0 }}
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-newspaper text-orange-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="card p-6 stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">
                            Vues totales
                        </p>

                        <h3 class="text-3xl font-black text-slate-800 mt-2">
                            {{ $totalViews ?? 0 }}
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-eye text-blue-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="card p-6 stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">
                            Impact social
                        </p>

                        <h3 class="text-3xl font-black text-slate-800 mt-2">
                            {{ $impactScore ?? 0 }}%
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center">
                        <i class="fas fa-heart text-green-500 text-2xl"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- SECTION : MES DERNIÈRES PUBLICATIONS -->
        @if(isset($recentPosts) && $recentPosts->count() > 0)
        <div class="card p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-history text-blue-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800">
                            Dernières publications
                        </h3>
                        <p class="text-slate-500 text-sm">
                            Vos actions récentes pour la paix
                        </p>
                    </div>
                </div>
                <a href="#" class="text-orange-500 hover:text-orange-600 font-semibold text-sm">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="space-y-4">
                @foreach($recentPosts as $post)
                <div class="border border-slate-200 rounded-2xl p-4 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-bold text-slate-800 mb-1">{{ $post->title }}</h4>
                            <p class="text-slate-500 text-sm line-clamp-2">{{ Str::limit($post->content, 100) }}</p>
                            <p class="text-xs text-slate-400 mt-2">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $post->created_at->format('d/m/Y H:i') }}
                                <span class="mx-2">•</span>
                                <i class="far fa-eye mr-1"></i>
                                {{ $post->views_count ?? 0 }} vues
                            </p>
                        </div>
                        <div class="flex gap-2 ml-4">
                            <button class="text-slate-400 hover:text-orange-500 transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-slate-400 hover:text-red-500 transition">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- CREATE POST FORM -->
        <div class="card p-6">

            <div class="flex items-center gap-3 mb-6">

                <div class="w-12 h-12 rounded-2xl bg-orange-100 flex items-center justify-center">
                    <i class="fas fa-pen text-orange-500 text-xl"></i>
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-slate-800">
                        Nouvelle publication
                    </h3>

                    <p class="text-slate-500 text-sm">
                        Partagez une initiative, un événement ou un message de paix avec la communauté.
                    </p>
                </div>

            </div>

            <form action="{{ route('posts.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <!-- TITLE -->
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Titre de la publication
                    </label>

                    <input type="text"
                           name="title"
                           class="input w-full rounded-2xl px-5 py-4"
                           placeholder="Ex: Journée de la paix dans mon quartier"
                           required>

                </div>

                <!-- CONTENT -->
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Contenu
                    </label>

                    <textarea name="content"
                              rows="6"
                              required
                              class="input w-full rounded-2xl px-5 py-4 resize-none"
                              placeholder="Décrivez votre initiative, action de paix, médiation, événement..."></textarea>

                </div>

                <!-- IMAGE -->
                <div class="mb-6">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Image (optionnel)
                    </label>

                    <input type="file"
                           name="image"
                           accept="image/*"
                           class="w-full bg-slate-100 rounded-2xl p-4 border-2 border-dashed border-slate-300 hover:border-orange-400 transition cursor-pointer">

                    <p class="text-xs text-slate-400 mt-2">
                        Formats acceptés : JPG, PNG, GIF. Max 5 Mo.
                    </p>

                </div>

                <!-- BUTTONS -->
                <div class="flex gap-4">
                    <button type="submit"
                            class="btn text-white px-8 py-4 rounded-2xl font-bold">

                        <i class="fas fa-paper-plane mr-2"></i>
                        Publier maintenant

                    </button>

                    <button type="reset"
                            class="btn-outline px-8 py-4 rounded-2xl font-bold text-orange-600">

                        <i class="fas fa-undo-alt mr-2"></i>
                        Réinitialiser

                    </button>
                </div>

            </form>

        </div>

        <!-- PETITE SECTION D'INSPIRATION -->
        <div class="mt-8 bg-gradient-to-r from-orange-50 to-amber-50 rounded-2xl p-6 border border-orange-200">
            <div class="flex items-center gap-4 flex-wrap md:flex-nowrap">
                <div class="w-16 h-16 rounded-full bg-orange-200 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-lightbulb text-orange-600 text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 mb-1">Astuce PeaceLink</h4>
                    <p class="text-slate-600 text-sm">
                        Plus vous publiez régulièrement vos actions de paix, plus vous inspirez d'autres artisans et citoyens.
                        La prévention communautaire se fait ensemble !
                    </p>
                </div>
            </div>
        </div>

    </main>

</div>

<!-- Script pour preview image (optionnel) -->
<script>
    document.querySelector('input[type="file"]')?.addEventListener('change', function(e) {
        if(e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            const info = document.createElement('p');
            info.className = 'text-xs text-green-600 mt-2';
            info.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Fichier sélectionné : ' + fileName;
            const oldInfo = e.target.parentNode.querySelector('.file-info');
            if(oldInfo) oldInfo.remove();
            const newInfo = document.createElement('div');
            newInfo.className = 'file-info';
            newInfo.innerHTML = '<p class="text-xs text-green-600 mt-2"><i class="fas fa-check-circle mr-1"></i> ' + fileName + '</p>';
            e.target.parentNode.appendChild(newInfo);
        }
    });
</script>

</body>
</html>