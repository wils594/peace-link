{{-- resources/views/admin/register.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PeaceLink | Inscription Administrateur</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        html, body {
            height: 100%;
            width: 100%;
        }
        
        body {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #0F172A 100%);
            position: relative;
            overflow-x: hidden;
        }
        
        /* Effet de fond */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
            pointer-events: none;
        }
        
        .admin-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.3);
        }
        
        .input-field {
            transition: all 0.2s ease;
            border: 1.5px solid #E2E8F0;
            background-color: white;
        }
        
        .input-field:focus {
            border-color: #F97316;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
            outline: none;
        }
        
        .input-field.error {
            border-color: #EF4444;
            animation: shake 0.3s ease-in-out;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-primary:active::after {
            width: 300px;
            height: 300px;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .animate-left {
            animation: fadeInLeft 0.6s ease-out;
        }
        
        .animate-right {
            animation: fadeInRight 0.6s ease-out;
        }
        
        /* Scrollbar personnalisée */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #F97316;
            border-radius: 10px;
        }
    </style>
</head>
<body class="overflow-hidden">
    <div class="flex flex-col md:flex-row h-screen overflow-hidden">
        
        <!-- PARTIE GAUCHE - Branding et informations -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-12 overflow-y-auto animate-left">
            <div class="max-w-md text-center md:text-left">
                <!-- Logo -->
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#F97316]/20 to-[#EA580C]/20 rounded-2xl mb-6 mx-auto md:mx-0">
                    <i class="fas fa-shield-alt text-3xl text-[#F97316]"></i>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    <span class="text-[#F97316]">Peace</span>Link
                    <span class="text-xs bg-[#F97316] px-2 py-0.5 rounded-full ml-2 align-middle">Admin</span>
                </h1>
                
                <h2 class="text-xl md:text-2xl font-semibold text-white mb-4">
                    Espace d'administration sécurisé
                </h2>
                
                <p class="text-gray-300 text-base mb-8 leading-relaxed">
                    Accédez à la plateforme de gestion et de modération des signalements. 
                    Cet espace est strictement réservé au personnel autorisé.
                </p>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-3 text-gray-300">
                        <i class="fas fa-check-circle text-[#F97316]"></i>
                        <span>Gestion des signalements</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-300">
                        <i class="fas fa-check-circle text-[#F97316]"></i>
                        <span>Modération des utilisateurs</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-300">
                        <i class="fas fa-check-circle text-[#F97316]"></i>
                        <span>Statistiques et rapports</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-300">
                        <i class="fas fa-check-circle text-[#F97316]"></i>
                        <span>Support et médiation</span>
                    </div>
                </div>
                
                <!-- Footer sécurisé côté gauche -->
                <div class="mt-12 pt-6 border-t border-white/10">
                    <div class="flex flex-wrap items-center gap-4 text-gray-400 text-xs">
                        <i class="fas fa-shield-alt"></i>
                        <span>Accès restreint</span>
                        <i class="fas fa-circle text-[4px]"></i>
                        <span>Chiffrement SSL</span>
                        <i class="fas fa-circle text-[4px]"></i>
                        <span>Protection anti-fraude</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- PARTIE DROITE - Formulaire d'inscription -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-6 md:p-8 overflow-y-auto animate-right bg-white/5 backdrop-blur-sm">
            <div class="w-full max-w-md">
                <!-- Formulaire d'inscription -->
                <div class="admin-card rounded-2xl shadow-2xl p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                        <div class="w-12 h-12 bg-[#F97316]/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-shield text-[#F97316] text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-[#0F172A]">Créer un compte</h2>
                            <p class="text-sm text-gray-500">Remplissez tous les champs pour vous inscrire</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        
                        <!-- Nom complet -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                <i class="fas fa-user mr-2 text-[#F97316] text-xs"></i>Nom complet
                            </label>
                            <input id="name" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus
                                   class="w-full px-4 py-3 rounded-xl input-field @error('name') error @enderror"
                                   placeholder="Anani DOSSEH">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                <i class="fas fa-envelope mr-2 text-[#F97316] text-xs"></i>Adresse email
                            </label>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   class="w-full px-4 py-3 rounded-xl input-field @error('email') error @enderror"
                                   placeholder="admin@peacelink.tg">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                <i class="fas fa-lock mr-2 text-[#F97316] text-xs"></i>Mot de passe
                            </label>
                            <div class="relative">
                                <input id="password" 
                                       type="password" 
                                       name="password" 
                                       required
                                       class="w-full px-4 py-3 rounded-xl input-field @error('password') error @enderror"
                                       placeholder="••••••••">
                                <button type="button" 
                                        onclick="togglePassword('password')" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F97316] transition">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères, une majuscule et un chiffre</p>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                <i class="fas fa-check-circle mr-2 text-[#F97316] text-xs"></i>Confirmer le mot de passe
                            </label>
                            <div class="relative">
                                <input id="password_confirmation" 
                                       type="password" 
                                       name="password_confirmation" 
                                       required
                                       class="w-full px-4 py-3 rounded-xl input-field"
                                       placeholder="••••••••">
                                <button type="button" 
                                        onclick="togglePassword('password_confirmation')" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F97316] transition">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Admin Secret Key -->
                        <div class="mb-6">
                            <label for="admin_secret_key" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                <i class="fas fa-key mr-2 text-[#F97316] text-xs"></i>Clé d'inscription administrateur
                            </label>
                            <input id="admin_secret_key" 
                                   type="password" 
                                   name="admin_secret_key" 
                                   required
                                   class="w-full px-4 py-3 rounded-xl input-field @error('admin_secret_key') error @enderror"
                                   placeholder="Clé secrète requise">
                            @error('admin_secret_key')
                                <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Buttons -->
                        <div class="flex flex-col gap-3">
                            <button type="submit" class="btn-primary w-full py-3 rounded-xl font-bold text-white transition flex items-center justify-center gap-2">
                                <i class="fas fa-user-plus"></i>
                                S'inscrire
                            </button>
                            
                            <a href="{{ route('login') }}" 
                               class="text-center text-sm text-gray-500 hover:text-[#F97316] transition flex items-center justify-center gap-1">
                                <i class="fas fa-arrow-left text-xs"></i>
                                Déjà inscrit ? Se connecter
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling?.querySelector('i') || field.parentElement?.querySelector('button i');
            
            if (field.type === 'password') {
                field.type = 'text';
                if (icon) icon.classList.remove('fa-eye');
                if (icon) icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                if (icon) icon.classList.remove('fa-eye-slash');
                if (icon) icon.classList.add('fa-eye');
            }
        }
        
        // Validation en temps réel
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const secretKey = document.getElementById('admin_secret_key').value;
            
            if (password !== confirm) {
                e.preventDefault();
                alert(' Les mots de passe ne correspondent pas');
                document.getElementById('password_confirmation').classList.add('error');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert(' Le mot de passe doit contenir au moins 8 caractères');
                document.getElementById('password').classList.add('error');
                return false;
            }
            
            if (!secretKey) {
                e.preventDefault();
                alert(' La clé d\'inscription est requise');
                document.getElementById('admin_secret_key').classList.add('error');
                return false;
            }
            
            // Animation du bouton
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Inscription en cours...';
            btn.disabled = true;
            
            setTimeout(() => {
                if (btn.disabled) {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            }, 10000);
        });
        
        // Supprimer la classe error au focus
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('error');
                const parent = this.parentElement;
                if (parent && parent.parentElement) {
                    const errorMsg = parent.parentElement.querySelector('.text-red-500');
                    if (errorMsg && !errorMsg.querySelector('input')) {
                        errorMsg.remove();
                    }
                }
            });
        });
        
        // Réinitialiser après soumission
        @if(session('success'))
            alert(' Inscription réussie ! Vous pouvez maintenant vous connecter.');
        @endif
    </script>
</body>
</html>