{{-- resources/views/artisan/register.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>PeaceLink | Inscription Artisan de la paix</title>
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
            margin: 0;
            padding: 0;
        }
        
        body {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #0F172A 100%);
            position: relative;
            overflow: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Motif de fond discret */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }
        
        .center-container {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        /* Carte principale */
        .main-card {
            max-width: 1300px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 48px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
        }
        
        /* Panneau gauche - Bannière Artisan */
        .left-panel {
            flex: 1.1;
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            padding: 48px;
            position: relative;
            border-radius: 0 60px 60px 0;
        }
        
        .left-panel::before {
            content: '🕊️';
            position: absolute;
            bottom: 30px;
            right: 30px;
            font-size: 120px;
            opacity: 0.08;
            pointer-events: none;
        }
        
        /* Panneau droit - Formulaire */
        .right-panel {
            flex: 1.9;
            padding: 48px;
            background: white;
            overflow-y: auto;
            max-height: 90vh;
        }
        
        .right-panel::-webkit-scrollbar {
            width: 6px;
        }
        
        .right-panel::-webkit-scrollbar-track {
            background: #E2E8F0;
            border-radius: 10px;
        }
        
        .right-panel::-webkit-scrollbar-thumb {
            background: #F97316;
            border-radius: 10px;
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
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-left {
            animation: slideInLeft 0.5s ease-out;
        }
        
        .animate-right {
            animation: slideInRight 0.5s ease-out;
        }
        
        @media (max-width: 968px) {
            .main-card {
                flex-direction: column;
                border-radius: 32px;
            }
            .left-panel {
                border-radius: 0 0 40px 40px;
                padding: 32px;
                text-align: center;
            }
            .right-panel {
                padding: 28px;
                max-height: 60vh;
            }
            .features-list {
                justify-content: center;
            }
        }
        
        @media (max-width: 640px) {
            .left-panel, .right-panel {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="center-container">
        <div class="main-card">
            
            <!-- PANEL GAUCHE - Présentation Artisan -->
            <div class="left-panel animate-left">
                <div class="h-full flex flex-col justify-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#F97316]/20 to-[#EA580C]/20 rounded-2xl mb-6">
                        <i class="fas fa-hand-peace text-3xl text-[#F97316]"></i>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">
                        <span class="text-[#F97316]">Peace</span>Link
                    </h1>
                    
                    <h2 class="text-xl md:text-2xl font-semibold text-white mb-4">
                        Artisan de la paix
                    </h2>
                    
                    <p class="text-gray-300 text-base mb-6 leading-relaxed">
                        Rejoignez le réseau des artisans de la paix au Togo. Ensemble, construisons des communautés plus sereines grâce à la médiation et la prévention.
                    </p>
                    
                    <div class="space-y-3 features-list">
                        <div class="flex items-center gap-3 text-gray-300">
                            <i class="fas fa-check-circle text-[#F97316] text-sm"></i>
                            <span>Signaler des tensions communautaires</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-300">
                            <i class="fas fa-check-circle text-[#F97316] text-sm"></i>
                            <span>Publier vos actions de paix</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-300">
                            <i class="fas fa-check-circle text-[#F97316] text-sm"></i>
                            <span>Participer au forum citoyen</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-300">
                            <i class="fas fa-check-circle text-[#F97316] text-sm"></i>
                            <span>Accéder aux statistiques locales</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-300">
                            <i class="fas fa-check-circle text-[#F97316] text-sm"></i>
                            <span>Bénéficier de formations certifiantes</span>
                        </div>
                    </div>
                    
                    <div class="mt-10 pt-6 border-t border-white/10">
                        <div class="flex flex-wrap items-center gap-4 text-gray-400 text-xs">
                            <i class="fas fa-shield-alt"></i>
                            <span>Données sécurisées</span>
                            <i class="fas fa-circle text-[3px]"></i>
                            <span>Chiffrement SSL</span>
                            <i class="fas fa-circle text-[3px]"></i>
                            <span>Anonymat garanti</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PANEL DROIT - Formulaire d'inscription Artisan -->
            <div class="right-panel animate-right">
                <div class="w-full">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                        <div class="w-12 h-12 bg-[#F97316]/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-plus text-[#F97316] text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-[#0F172A]">Devenir Artisan de la paix</h2>
                            <p class="text-sm text-gray-500">Créez votre compte et rejoignez le réseau</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        <input type="hidden" name="role" value="artisan">
                        
                        <!-- 2 colonnes pour les infos personnelles -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            
                            <!-- Colonne gauche -->
                            <div>
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                        <i class="fas fa-user mr-2 text-[#F97316] text-xs"></i>Nom complet
                                    </label>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                           class="w-full px-4 py-3 rounded-xl input-field @error('name') error @enderror"
                                           placeholder="Anani DOSSEH">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                        <i class="fas fa-envelope mr-2 text-[#F97316] text-xs"></i>Email
                                    </label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                           class="w-full px-4 py-3 rounded-xl input-field @error('email') error @enderror"
                                           placeholder="contact@artisan.tg">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="phone" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                        <i class="fas fa-phone mr-2 text-[#F97316] text-xs"></i>Téléphone
                                    </label>
                                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required
                                           class="w-full px-4 py-3 rounded-xl input-field"
                                           placeholder="+228 XX XX XX XX">
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="country" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                        <i class="fas fa-globe-africa mr-2 text-[#F97316] text-xs"></i>Pays
                                    </label>
                                    <select id="country" name="country" class="w-full px-4 py-3 rounded-xl input-field">
                                        <option value="Togo" selected>Togo</option>
                                        <option value="Bénin">Bénin</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                        <option value="Sénégal">Sénégal</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="city" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                        <i class="fas fa-city mr-2 text-[#F97316] text-xs"></i>Ville / Préfecture
                                    </label>
                                    <input id="city" type="text" name="city" value="{{ old('city') }}" required
                                           class="w-full px-4 py-3 rounded-xl input-field"
                                           placeholder="Lomé, Kara, Sokodé...">
                                    @error('city')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Colonne droite -->
                            <div>
                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                        <i class="fas fa-lock mr-2 text-[#F97316] text-xs"></i>Mot de passe
                                    </label>
                                    <div class="relative">
                                        <input id="password" type="password" name="password" required
                                               class="w-full px-4 py-3 rounded-xl input-field @error('password') error @enderror"
                                               placeholder="••••••••">
                                        <button type="button" onclick="togglePassword('password')" 
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F97316]">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères, une majuscule et un chiffre</p>
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password_confirmation" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                        <i class="fas fa-check-circle mr-2 text-[#F97316] text-xs"></i>Confirmer le mot de passe
                                    </label>
                                    <div class="relative">
                                        <input id="password_confirmation" type="password" name="password_confirmation" required
                                               class="w-full px-4 py-3 rounded-xl input-field"
                                               placeholder="••••••••">
                                        <button type="button" onclick="togglePassword('password_confirmation')" 
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#F97316]">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SECTION SPÉCIFIQUE ARTISAN -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-base font-semibold text-[#F97316] mb-4">
                                <i class="fas fa-hand-peace mr-2"></i>Informations Artisan de la paix
                            </p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <div class="mb-4">
                                        <label for="organization_name" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                            <i class="fas fa-building mr-2 text-[#F97316] text-xs"></i>Nom de l'organisation
                                        </label>
                                        <input id="organization_name" type="text" name="organization_name" value="{{ old('organization_name') }}"
                                               class="w-full px-4 py-3 rounded-xl input-field"
                                               placeholder="Association, ONG, Collectif...">
                                        @error('organization_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="specialization" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                            <i class="fas fa-star-of-life mr-2 text-[#F97316] text-xs"></i>Domaine d'intervention
                                        </label>
                                        <select id="specialization" name="specialization" class="w-full px-4 py-3 rounded-xl input-field">
                                            <option value="">Sélectionnez votre domaine</option>
                                            <option value="mediation">Médiation communautaire</option>
                                            <option value="prevention">Prévention des conflits</option>
                                            <option value="education">Éducation à la paix</option>
                                            <option value="dialogue">Dialogue interreligieux</option>
                                            <option value="droits_humains">Droits humains</option>
                                            <option value="jeunesse">Jeunesse et paix</option>
                                            <option value="femmes">Femmes et cohésion sociale</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="years_experience" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                            <i class="fas fa-calendar-alt mr-2 text-[#F97316] text-xs"></i>Années d'expérience
                                        </label>
                                        <select id="years_experience" name="years_experience" class="w-full px-4 py-3 rounded-xl input-field">
                                            <option value="0">Moins d'1 an</option>
                                            <option value="1">1 - 2 ans</option>
                                            <option value="3">3 - 5 ans</option>
                                            <option value="6">6 - 10 ans</option>
                                            <option value="10">Plus de 10 ans</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="mb-4">
                                        <label for="organization_desc" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                            <i class="fas fa-file-alt mr-2 text-[#F97316] text-xs"></i>Description de l'organisation
                                        </label>
                                        <textarea id="organization_desc" name="organization_desc" rows="3"
                                                  class="w-full px-4 py-3 rounded-xl input-field resize-none"
                                                  placeholder="Présentez brièvement votre organisation, ses objectifs et actions...">{{ old('organization_desc') }}</textarea>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="motivation" class="block text-sm font-semibold text-[#0F172A] mb-2">
                                            <i class="fas fa-heart mr-2 text-[#F97316] text-xs"></i>Motivation personnelle
                                        </label>
                                        <textarea id="motivation" name="motivation" rows="2"
                                                  class="w-full px-4 py-3 rounded-xl input-field resize-none"
                                                  placeholder="Pourquoi souhaitez-vous devenir artisan de la paix ?">{{ old('motivation') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CONDITIONS D'UTILISATION -->
                        <div class="mt-5 mb-4">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="terms" value="1" required class="mt-1 w-5 h-5 rounded border-gray-300 text-[#F97316] focus:ring-[#F97316]">
                                <span class="text-sm text-gray-600">
                                    J'accepte les <a href="#" class="text-[#F97316] hover:underline">conditions générales d'utilisation</a> et m'engage à respecter la charte de l'artisan de la paix.
                                </span>
                            </label>
                        </div>
                        
                        <!-- BOUTON D'INSCRIPTION -->
                        <button type="submit" class="btn-primary w-full py-3 rounded-xl font-bold text-white transition flex items-center justify-center gap-2 mt-2">
                            <i class="fas fa-hand-peace"></i>
                            Devenir Artisan de la paix
                        </button>
                        
                        <div class="text-center mt-5">
                            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#F97316] transition flex items-center justify-center gap-1">
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
            const icon = field.parentElement.querySelector('button i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const terms = document.querySelector('input[name="terms"]').checked;
            
            if (password !== confirm) {
                e.preventDefault();
                alert('❌ Les mots de passe ne correspondent pas');
                document.getElementById('password_confirmation').classList.add('error');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('❌ Le mot de passe doit contenir au moins 8 caractères');
                document.getElementById('password').classList.add('error');
                return false;
            }
            
            if (!terms) {
                e.preventDefault();
                alert('❌ Vous devez accepter les conditions générales d\'utilisation');
                return false;
            }
            
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
        
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('error');
            });
        });
        
        @if(session('success'))
            alert(' Inscription réussie ! Vous pouvez maintenant vous connecter.');
        @endif
        
        @if($errors->any())
            console.log('Erreurs de validation présentes');
        @endif
    </script>
</body>
</html>