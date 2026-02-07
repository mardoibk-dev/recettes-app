<x-app-layout>
    <div class="container py-4 px-3 px-md-4">

        <!-- Header amélioré avec gradient -->
        <div class="recipe-header mb-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="fw-bold display-6 gradient-text mb-2">Toutes les Recettes</h1>
                    <p class="text-muted fs-5">Découvrez et gérez vos créations culinaires</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('recipes.create') }}" class="btn btn-primary btn-lg px-4 py-3 add-recipe-btn">
                        <i class="bi bi-plus-circle me-2"></i>
                        Ajouter une recette
                    </a>
                </div>
            </div>
            
            <!-- Statistiques en haut -->
            <div class="stats-banner mt-4">
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <div class="stat-item text-center p-2">
                            <div class="stat-number">{{ count($recipes) }}</div>
                            <div class="stat-label">Recettes</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        @php
                            $easyCount = 0;
                            foreach($recipes as $recipe) {
                                if($recipe->difficulty == 'Facile') $easyCount++;
                            }
                        @endphp
                        <div class="stat-item text-center p-2">
                            <div class="stat-number">{{ $easyCount }}</div>
                            <div class="stat-label">Faciles</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        @php
                            $mediumCount = 0;
                            foreach($recipes as $recipe) {
                                if($recipe->difficulty == 'Moyenne') $mediumCount++;
                            }
                        @endphp
                        <div class="stat-item text-center p-2">
                            <div class="stat-number">{{ $mediumCount }}</div>
                            <div class="stat-label">Moyennes</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        @php
                            $hardCount = 0;
                            foreach($recipes as $recipe) {
                                if($recipe->difficulty == 'Difficile') $hardCount++;
                            }
                        @endphp
                        <div class="stat-item text-center p-2">
                            <div class="stat-number">{{ $hardCount }}</div>
                            <div class="stat-label">Difficiles</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages succès amélioré -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Succès !</h6>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        <!-- Liste des recettes avec design amélioré -->
        @if(count($recipes) > 0)
            <div class="row g-4 recipe-grid">
                @foreach($recipes as $recipe)
                    <div class="col-lg-4 col-md-6">
                        <div class="recipe-card card border-0 shadow-lg overflow-hidden">
                            <!-- Image avec overlay -->
                            <div class="recipe-image-wrapper position-relative">
                                @if($recipe->image && file_exists(storage_path('app/public/' . $recipe->image)))
                                    <img src="{{ asset('storage/' . $recipe->image) }}" 
                                         class="recipe-img"
                                         alt="{{ $recipe->title }}"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIGZpbGw9IiNGMEYyRjQiLz48cGF0aCBkPSJNMzUgNDBDMzUgMzQuNDc3MiAzOS40NzcyIDMwIDQ1IDMwQzUwLjUyMjggMzAgNTUgMzQuNDc3MiA1NSA0MEM1NSA0NS41MjI4IDUwLjUyMjggNTAgNDUgNTBDMzkuNDc3MiA1MCAzNSA0NS41MjI4IDM1IDQwWiIgZmlsbD0iI0NBQ0JDMiIvPjxwYXRoIGQ9Ik03MCA3MEM3MCA3MCA2MCA4MCA0NSA4MEMzMCA4MCAyMCA3MCAyMCA3MEwyMCA2MEMyMCA1NSA0MCA1MCA1MCA1MEM2MCA1MCA4MCA1NSA4MCA2MEw3MCA3MFoiIGZpbGw9IiNDQUNCQzIiLz48L3N2Zz4=';">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="bi bi-cup-hot text-white display-1"></i>
                                        <span class="mt-2">Recette</span>
                                    </div>
                                @endif
                                
                                <!-- Badge de difficulté -->
                                <span class="difficulty-badge difficulty-{{ strtolower($recipe->difficulty) }}">
                                    {{ $recipe->difficulty }}
                                </span>
                                
                                <!-- Overlay d'actions -->
                                <div class="recipe-overlay">
                                    <div class="overlay-content">
                                        <a href="{{ route('recipes.show', $recipe) }}" 
                                           class="btn btn-light btn-sm overlay-btn">
                                            <i class="bi bi-eye me-1"></i>Voir
                                        </a>
                                        <a href="{{ route('recipes.edit', $recipe) }}" 
                                           class="btn btn-light btn-sm overlay-btn">
                                            <i class="bi bi-pencil me-1"></i>Modifier
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Contenu de la carte -->
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title fw-bold mb-0 recipe-title">{{ $recipe->title }}</h5>
                                    <form action="{{ route('recipes.favorite', $recipe) }}" method="POST" class="favorite-form">
                                        @csrf
                                        <button type="submit" 
                                                class="favorite-btn {{ auth()->user()->favorites->contains($recipe) ? 'active' : '' }}"
                                                title="{{ auth()->user()->favorites->contains($recipe) ? 'Retirer des favoris' : 'Ajouter aux favoris' }}">
                                            <i class="bi bi-heart{{ auth()->user()->favorites->contains($recipe) ? '-fill' : '' }}"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <p class="card-text text-muted mb-4 recipe-description">
                                    {{ Str::limit($recipe->description, 100) }}
                                </p>
                                
                                <div class="recipe-meta d-flex justify-content-between align-items-center">
                                    <div class="meta-item">
                                        <i class="bi bi-clock text-primary me-1"></i>
                                        <span class="fw-medium">{{ $recipe->prep_time }} min</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-bar-chart text-primary me-1"></i>
                                        <span class="fw-medium">{{ $recipe->difficulty }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-calendar text-primary me-1"></i>
                                        <span class="fw-medium">{{ $recipe->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                
                                <!-- Boutons d'action -->
                                <div class="recipe-actions mt-4 pt-3 border-top">
                                    <div class="d-flex justify-content-between">
                                        <div class="btn-group">
                                            <a href="{{ route('recipes.show', $recipe) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i>Détails
                                            </a>
                                            <a href="{{ route('recipes.edit', $recipe) }}" 
                                               class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil me-1"></i>Modifier
                                            </a>
                                        </div>
                                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" 
                                              class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-sm delete-btn">
                                                <i class="bi bi-trash me-1"></i>Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination simple -->
            @if($recipes instanceof \Illuminate\Pagination\LengthAwarePaginator && $recipes->hasPages())
                <div class="mt-5">
                    <nav aria-label="Pagination des recettes">
                        {{ $recipes->links() }}
                    </nav>
                </div>
            @endif
        @else
            <!-- État vide amélioré -->
            <div class="empty-state text-center py-5">
                <div class="empty-icon mb-4">
                    <i class="bi bi-journal-text display-1 text-muted"></i>
                </div>
                <h4 class="fw-bold mb-3">Aucune recette trouvée</h4>
                <p class="text-muted mb-4">Commencez votre collection de recettes dès maintenant !</p>
                <a href="{{ route('recipes.create') }}" class="btn btn-primary btn-lg px-4 py-3">
                    <i class="bi bi-plus-circle me-2"></i>
                    Créer votre première recette
                </a>
            </div>
        @endif
    </div>

    <!-- Styles améliorés -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --easy-color: #10b981;
            --medium-color: #f59e0b;
            --hard-color: #ef4444;
            --shadow-light: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 8px 24px rgba(0, 0, 0, 0.12);
            --shadow-hover: 0 12px 32px rgba(0, 0, 0, 0.15);
        }

        .gradient-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .recipe-header {
            animation: slideDown 0.6s ease-out;
        }

        .stats-banner {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-light);
            animation: fadeIn 0.8s ease-out;
        }

        .stat-item {
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-3px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .add-recipe-btn {
            background: var(--primary-gradient);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .add-recipe-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .recipe-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 16px;
            overflow: hidden;
            background: white;
            animation: cardAppear 0.6s ease-out forwards;
            opacity: 0;
        }

        .recipe-grid .col-lg-4:nth-child(1) .recipe-card { animation-delay: 0.1s; }
        .recipe-grid .col-lg-4:nth-child(2) .recipe-card { animation-delay: 0.2s; }
        .recipe-grid .col-lg-4:nth-child(3) .recipe-card { animation-delay: 0.3s; }
        .recipe-grid .col-lg-4:nth-child(4) .recipe-card { animation-delay: 0.4s; }
        .recipe-grid .col-lg-4:nth-child(5) .recipe-card { animation-delay: 0.5s; }
        .recipe-grid .col-lg-4:nth-child(6) .recipe-card { animation-delay: 0.6s; }

        .recipe-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover) !important;
        }

        .recipe-image-wrapper {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .recipe-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .recipe-card:hover .recipe-img {
            transform: scale(1.05);
        }

        .no-image-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea30 0%, #764ba230 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .difficulty-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
            z-index: 2;
        }

        .difficulty-facile {
            background-color: var(--easy-color);
        }

        .difficulty-moyenne {
            background-color: var(--medium-color);
        }

        .difficulty-difficile {
            background-color: var(--hard-color);
        }

        .recipe-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .recipe-card:hover .recipe-overlay {
            opacity: 1;
        }

        .overlay-content {
            display: flex;
            gap: 8px;
        }

        .overlay-btn {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .recipe-card:hover .overlay-btn:nth-child(1) {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.1s;
        }

        .recipe-card:hover .overlay-btn:nth-child(2) {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.2s;
        }

        .recipe-title {
            font-size: 1.25rem;
            color: #2d3748;
            transition: color 0.3s ease;
        }

        .recipe-card:hover .recipe-title {
            color: #667eea;
        }

        .recipe-description {
            line-height: 1.5;
            min-height: 48px;
        }

        .recipe-meta {
            font-size: 0.85rem;
            color: #718096;
        }

        .meta-item {
            display: flex;
            align-items: center;
        }

        .favorite-btn {
            background: none;
            border: none;
            color: #d1d5db;
            font-size: 1.25rem;
            padding: 4px;
            transition: all 0.3s ease;
            cursor: pointer;
            line-height: 1;
        }

        .favorite-btn:hover {
            transform: scale(1.2);
            color: #ef4444;
        }

        .favorite-btn.active {
            color: #ef4444;
            animation: heartBeat 0.6s ease;
        }

        .recipe-actions {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .delete-btn {
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #dc3545;
            color: white;
        }

        .empty-state {
            animation: fadeInUp 0.8s ease-out;
        }

        .empty-icon {
            animation: bounceIn 1s ease;
        }

        .alert-success {
            background: linear-gradient(135deg, #10b98110 0%, #10b98130 100%);
            border: none;
            border-left: 4px solid #10b981;
            border-radius: 12px;
            animation: slideInRight 0.5s ease-out;
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes heartBeat {
            0% {
                transform: scale(1);
            }
            25% {
                transform: scale(1.3);
            }
            50% {
                transform: scale(1);
            }
            75% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .recipe-header .row {
                text-align: center;
            }
            
            .recipe-header .col-md-8,
            .recipe-header .col-md-4 {
                width: 100%;
                text-align: center;
            }
            
            .add-recipe-btn {
                width: 100%;
                margin-top: 1rem;
            }
            
            .stats-banner .col-md-3 {
                width: 50%;
            }
            
            .recipe-meta {
                flex-wrap: wrap;
                gap: 8px;
            }
            
            .recipe-actions .btn-group {
                margin-bottom: 8px;
            }
            
            .recipe-actions .d-flex {
                flex-direction: column;
                gap: 8px;
            }
            
            .recipe-actions .btn-group,
            .recipe-actions .delete-form {
                width: 100%;
            }
            
            .recipe-actions .btn {
                width: 100%;
            }
        }

        /* Pagination */
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-link {
            border: none;
            margin: 0 2px;
            border-radius: 8px;
            color: #4a5568;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-gradient);
            border: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la suppression avec confirmation
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Êtes-vous sûr de vouloir supprimer cette recette ? Cette action est irréversible.')) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                });
            });
            
            // Animation des favoris
            const favoriteButtons = document.querySelectorAll('.favorite-btn');
            favoriteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const icon = this.querySelector('i');
                    if (icon.classList.contains('bi-heart')) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                        this.classList.add('active');
                    } else {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                        this.classList.remove('active');
                    }
                });
            });
            
            // Tooltips simples
            const favoriteForms = document.querySelectorAll('.favorite-form');
            favoriteForms.forEach(form => {
                const button = form.querySelector('.favorite-btn');
                button.addEventListener('mouseenter', function() {
                    const isFavorite = this.querySelector('i').classList.contains('bi-heart-fill');
                    this.setAttribute('title', isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris');
                });
            });
        });
    </script>
</x-app-layout>