<x-app-layout>
    @php
        // Récupérer les statistiques réelles
        $user = Auth::user();
        
        // Version 1: Compte toutes les recettes (si pas de user_id)
        // $recipesCount = \App\Models\Recipe::count();
        
        // Version 2: Compte les recettes de l'utilisateur (si vous avez user_id)
        // $recipesCount = \App\Models\Recipe::where('user_id', $user->id)->count();
        
        // Version 3: Debug - Vérifiez ce qui est dans la table
        $allRecipes = \App\Models\Recipe::all();
        $recipesCount = $allRecipes->count();
        
        // Pour voir ce qui se passe, vous pouvez logger:
        // \Log::info('Nombre total de recettes: ' . $recipesCount);
        // \Log::info('Recettes: ', $allRecipes->toArray());
        
        $favoritesCount = \App\Models\Favorite::where('user_id', $user->id)->count();
        
        // Pour "en préparation", comptez simplement toutes les recettes pour l'instant
        // ou ajustez selon votre logique métier
        $inProgressCount = \App\Models\Recipe::count(); // Ou une autre logique
    @endphp

    <div class="container py-4 px-3 px-md-4">

        <!-- En-tête personnalisé -->
        <div class="dashboard-header mb-5">
            <div class="welcome-section text-center">
                <div class="avatar-placeholder mb-3">
                    <div class="avatar-circle">
                        <span class="avatar-text">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </div>
                <h2 class="fw-bold gradient-text">Bonjour, {{ Auth::user()->name }} 👋</h2>
                <p class="text-muted fs-5 mt-2 animate-typing">Bienvenue sur votre espace personnel. Explorez et gérez vos recettes facilement !</p>
                
                <!-- Debug info (à enlever en production) -->
                @if($recipesCount === 0)
                    <div class="alert alert-info mt-3">
                        <small>Debug: {{ $allRecipes->count() }} recettes trouvées dans la base</small>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cards principales avec design amélioré -->
        <div class="row g-4 justify-content-center">

            <!-- Toutes les recettes -->
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('recipes.index') }}"
                    class="dashboard-card card border-0 shadow-lg h-100 text-decoration-none text-dark">
                    <div class="card-body text-center p-4 position-relative">
                        <div class="card-icon-wrapper mb-3">
                            <i class="bi bi-card-list display-4 card-icon"></i>
                            <div class="icon-bg"></div>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Toutes les recettes</h4>
                        <p class="card-text text-muted mb-0">Voir toutes les recettes publiées</p>
                        <div class="card-hover-content">
                            <span class="badge bg-primary mt-3">Accéder <i class="bi bi-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Ajouter une recette -->
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('recipes.create') }}"
                    class="dashboard-card card border-0 shadow-lg h-100 text-decoration-none text-dark card-primary">
                    <div class="card-body text-center p-4 position-relative">
                        <div class="card-icon-wrapper mb-3">
                            <i class="bi bi-plus-circle display-4 card-icon"></i>
                            <div class="icon-bg"></div>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Ajouter une recette</h4>
                        <p class="card-text text-muted mb-0">Créer une nouvelle recette</p>
                        <div class="card-hover-content">
                            <span class="badge bg-success mt-3">Commencer <i class="bi bi-plus-lg ms-1"></i></span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Mes favoris -->
            <div class="col-md-4 col-lg-3">
                <a href="{{ route('recipes.favorites') }}"
                    class="dashboard-card card border-0 shadow-lg h-100 text-decoration-none text-dark">
                    <div class="card-body text-center p-4 position-relative">
                        <div class="card-icon-wrapper mb-3">
                            <i class="bi bi-heart display-4 card-icon"></i>
                            <div class="icon-bg"></div>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Mes favoris</h4>
                        <p class="card-text text-muted mb-0">Accédez à vos recettes préférées</p>
                        <div class="card-hover-content">
                            <span class="badge bg-pink mt-3">Voir <i class="bi bi-heart-fill ms-1"></i></span>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Statistiques réelles -->
        <div class="stats-section mt-5">
            <div class="row g-3 justify-content-center">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card p-3 rounded-3 text-center">
                        <i class="bi bi-journal-text display-6 text-primary mb-2"></i>
                        <h5 class="fw-bold mb-1">{{ $recipesCount }}</h5>
                        <p class="text-muted small mb-0">Recettes créées</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card p-3 rounded-3 text-center">
                        <i class="bi bi-star display-6 text-warning mb-2"></i>
                        <h5 class="fw-bold mb-1">{{ $favoritesCount }}</h5>
                        <p class="text-muted small mb-0">Favoris</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card p-3 rounded-3 text-center">
                        <i class="bi bi-clock display-6 text-info mb-2"></i>
                        <h5 class="fw-bold mb-1">{{ $inProgressCount }}</h5>
                        <p class="text-muted small mb-0">En préparation</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Debug section (à enlever en production) -->
        <div class="debug-info mt-4 text-center">
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#debugDetails">
                <i class="bi bi-bug"></i> Détails de débogage
            </button>
            
            <div class="collapse mt-3" id="debugDetails">
                <div class="card card-body">
                    <h6>Informations de débogage :</h6>
                    <ul class="list-unstyled">
                        <li>User ID: {{ $user->id }}</li>
                        <li>Nombre total de recettes: {{ \App\Models\Recipe::count() }}</li>
                        <li>Recettes avec user_id={{ $user->id }}: {{ \App\Models\Recipe::where('user_id', $user->id)->count() }}</li>
                        <li>Premières recettes:
                            @foreach($allRecipes->take(3) as $recipe)
                                <br>- {{ $recipe->title }} (ID: {{ $recipe->id }})
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Déconnexion avec design amélioré -->
        <div class="logout-section mt-5 pt-4 text-center">
            <div class="logout-wrapper d-inline-block position-relative">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-lg px-4 py-3 logout-btn">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- Styles améliorés -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #4cc9f0;
            --pink-color: #f72585;
            --gradient-primary: linear-gradient(135deg, #4361ee, #3a0ca3);
            --gradient-success: linear-gradient(135deg, #4cc9f0, #4361ee);
            --gradient-pink: linear-gradient(135deg, #f72585, #b5179e);
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .dashboard-header {
            animation: fadeInDown 0.8s ease-out;
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            transition: transform 0.3s ease;
        }

        .avatar-circle:hover {
            transform: scale(1.05);
        }

        .avatar-text {
            font-size: 2rem;
            font-weight: bold;
            color: white;
        }

        .gradient-text {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .animate-typing {
            overflow: hidden;
            white-space: nowrap;
            animation: typing 3.5s steps(40, end);
        }

        .dashboard-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover::before {
            transform: scaleX(1);
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }

        .card-primary::before {
            background: var(--gradient-success);
        }

        .card-icon-wrapper {
            position: relative;
            display: inline-block;
        }

        .card-icon {
            position: relative;
            z-index: 2;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .icon-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70px;
            height: 70px;
            background: rgba(67, 97, 238, 0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover .card-icon {
            transform: scale(1.2);
            color: var(--secondary-color);
        }

        .dashboard-card:hover .icon-bg {
            background: rgba(67, 97, 238, 0.2);
            transform: translate(-50%, -50%) scale(1.2);
        }

        .card-hover-content {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .dashboard-card:hover .card-hover-content {
            opacity: 1;
            transform: translateY(0);
        }

        .badge.bg-pink {
            background: var(--gradient-pink) !important;
            color: white;
        }

        .stat-card {
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }

        .logout-btn {
            border-width: 2px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.2);
            background-color: #dc3545;
            color: white;
        }

        .logout-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .logout-btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            20% {
                transform: scale(25, 25);
                opacity: 0.3;
            }
            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
        }

        /* Animation d'apparition des cartes */
        .dashboard-card {
            animation: cardSlideUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .dashboard-card:nth-child(1) { animation-delay: 0.1s; }
        .dashboard-card:nth-child(2) { animation-delay: 0.2s; }
        .dashboard-card:nth-child(3) { animation-delay: 0.3s; }

        @keyframes cardSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .dashboard-card {
                margin-bottom: 1rem;
            }
            
            .avatar-circle {
                width: 60px;
                height: 60px;
            }
            
            .avatar-text {
                font-size: 1.5rem;
            }
        }
    </style>
</x-app-layout>