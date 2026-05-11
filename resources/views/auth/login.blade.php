{{-- resources/views/admin/login.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PeaceLink | Connexion Administrateur</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #0F172A 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
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
        
        .btn-login {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login::after {
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
        
        .btn-login:active::after {
            width: 300px;
            height: 300px;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .alert-success {
            animation: slideDown 0.3s ease-out;
        }
        
        .alert-error {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .admin-card {
                margin: 0 16px;
            }
        }
        
        /* Password strength indicator */
        .strength-bar {
            height: 3px;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4 md:p-6">
    <div class="w-full max-w-md mx-auto relative z-10">
        <!-- Logo et en-tête -->
        <div class="text-center mb-6 md:mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-[#F97316]/20 to-[#EA580C]/20 rounded-2xl mb-4">
                <i class="fas fa-shield-alt text-3xl md:text-4xl text-[#F97316]"></i>
            </div>
            <div class="text-2xl md:text-3xl font-bold text-white mb-2">
                <span class="text-[#F97316]">Peace</span>Link
                <span class="text-xs bg-[#F97316] px-2 py-0.5 rounded-full ml-2 align-middle">Admin</span>
            </div>
            <p class="text-gray-300 text-sm md:text-base">Espace d'administration sécurisé</p>
        </div>
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert-success mb-4 p-3 md:p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm flex items-center gap-2">
                <i class="fas fa-check-circle text-green-500"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert-error mb-4 p-3 md:p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm flex items-start gap-2">
                <i class="fas fa-exclamation-triangle text-red-500 mt-0.5"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Formulaire de connexion -->
        <div class="admin-card rounded-2xl shadow-2xl p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                <div class="w-10 h-10 bg-[#F97316]/10 rounded-xl flex items-center justify-center">
                    <i class="fas fa-lock text-[#F97316] text-lg"></i>
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-[#0F172A]">Connexion administrateur</h2>
                    <p class="text-xs text-gray-500">Accès réservé au personnel autorisé</p>
                </div>
            </div>
            
       <a href="{{ route('login') }}"
                @csrf
                
                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-[#0F172A] mb-2">
                        <i class="fas fa-envelope mr-2 text-[#F97316] text-xs"></i>Adresse email
                    </label>
                    <div class="relative">
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               class="w-full px-4 py-3 rounded-xl input-field @error('email') error @enderror"
                               placeholder="admin@peacelink.tg">
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-[#0F172A] mb-2">
                        <i class="fas fa-key mr-2 text-[#F97316] text-xs"></i>Mot de passe
                    </label>
                    <div class="relative">
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               class="w-full px-4 py-3 rounded-xl input-field @error('password') error @enderror"
                               placeholder="••••••••">
                        <button type="button" 
                                onclick="togglePassword()" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F97316] transition">
                            <i id="passwordEye" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   name="remember" 
                                   class="sr-only peer">
                            <div class="w-5 h-5 border-2 border-gray-300 rounded-md peer-checked:bg-[#F97316] peer-checked:border-[#F97316] transition-all"></div>
                            <i class="fas fa-check text-white text-xs absolute left-1.5 top-1 opacity-0 peer-checked:opacity-100 transition"></i>
                        </div>
                        <span class="ms-3 text-sm text-gray-600 cursor-pointer">Se souvenir de moi</span>
                    </label>
                    
                    @if (Route::has('admin.password.request'))
                        <a href="{{ route('admin.password.request') }}" 
                           class="text-sm text-[#F97316] hover:text-[#EA580C] transition flex items-center gap-1">
                            <i class="fas fa-question-circle"></i>
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login w-full py-3 rounded-xl font-bold text-white transition flex items-center justify-center gap-2 mt-6">
                    <i class="fas fa-sign-in-alt"></i>
                    Se connecter
                </button>
                
                <!-- Lien vers inscription -->
                <p class="text-sm text-gray-500">
    Pas encore de compte administrateur ?

    <a href="{{ route('register') }}"
       class="text-[#F97316] hover:text-[#EA580C] font-semibold transition">
        Créer un compte
    </a>
</p>
        
        <!-- Footer sécurisé -->
        <div class="text-center mt-6 md:mt-8">
            <div class="flex flex-col items-center gap-2">
                <div class="flex items-center gap-3 text-gray-400 text-xs">
                    <i class="fas fa-shield-alt"></i>
                    <span>Connexion sécurisée</span>
                    <i class="fas fa-circle text-[4px]"></i>
                    <span>Chiffrement SSL</span>
                    <i class="fas fa-circle text-[4px]"></i>
                    <span>Protection anti-bruteforce</span>
                </div>
                <p class="text-gray-500/60 text-[11px]">
                    <i class="fas fa-clock mr-1"></i>Dernière connexion : {{ now()->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('passwordEye');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
        
        // Animation de chargement au submit
        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Connexion en cours...';
            submitBtn.disabled = true;
            
            // Reset button if validation fails (timeout)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 5000);
        });
        
        // Supprimer la classe error au focus
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('error');
                const errorMsg = this.parentElement?.parentElement?.querySelector('.text-red-500');
                if (errorMsg) errorMsg.remove();
            });
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert-success, .alert-error').forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.3s';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
</body>
</html>