{{-- resources/views/artisan/pending.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PeaceLink | Inscription en attente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .pending-card {
            max-width: 550px;
            width: 100%;
            background: white;
            border-radius: 48px;
            padding: 48px 40px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 0.6s ease-out;
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
        .icon-circle {
            width: 90px;
            height: 90px;
            background: rgba(249, 115, 22, 0.1);
            border-radius: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #E2E8F0;
            border-top-color: #F97316;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        @media (max-width: 640px) {
            .pending-card {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="pending-card">
        <div class="icon-circle">
            <i class="fas fa-hourglass-half text-4xl text-[#F97316]"></i>
        </div>
        
        <h1 class="text-2xl md:text-3xl font-bold text-[#0F172A] mb-3">
            Inscription en attente
        </h1>
        
        <div class="spinner"></div>
        
        <p class="text-gray-600 mb-4">
            Votre demande d'inscription en tant qu'<strong class="text-[#F97316]">Artisan de la paix</strong> a bien été enregistrée.
        </p>
        
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-6">
            <i class="fas fa-shield-alt text-amber-600 mr-2"></i>
            <span class="text-amber-800 text-sm">
                Votre compte sera activé après validation par notre équipe.
            </span>
        </div>
        
        <div class="space-y-3 text-left bg-gray-50 rounded-2xl p-5 mb-6">
            <p class="text-sm text-gray-600 flex items-center gap-2">
                <i class="fas fa-envelope text-[#F97316]"></i>
                Un email de confirmation vous a été envoyé
            </p>
            <p class="text-sm text-gray-600 flex items-center gap-2">
                <i class="fas fa-clock text-[#F97316]"></i>
                Délai de traitement : 24 à 48 heures
            </p>
            <p class="text-sm text-gray-600 flex items-center gap-2">
                <i class="fas fa-bell text-[#F97316]"></i>
                Vous serez notifié dès l'activation de votre compte
            </p>
        </div>
        
        <a href="{{ route('login') }}" class="btn-primary w-full py-3 rounded-xl font-bold text-white transition flex items-center justify-center gap-2 bg-[#F97316] hover:bg-[#EA580C]">
            <i class="fas fa-arrow-left"></i>
            Retour à la connexion
        </a>
        
        <p class="text-xs text-gray-400 mt-6">
            PeaceLink – Réseau des artisans de la paix
        </p>
    </div>
</body>
</html>