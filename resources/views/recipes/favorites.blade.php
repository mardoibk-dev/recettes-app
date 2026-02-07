<x-app-layout>
    <div class="container py-4 px-3 px-md-4">

        <!-- Header avec animation -->
        <div class="favorites-header text-center mb-5">
            <div class="heart-icon mb-3">
                <div class="heart-container">
                    <i class="bi bi-heart-fill heart-beat"></i>
                </div>
            </div>
            <h1 class="fw-bold gradient-text display-5 mb-2">Mes Recettes Favorites</h1>
            <p class="text-muted fs-5">Vos coups de cœur culinaires en un seul endroit</p>
            
            <!-- Badge de compteur -->
            <div class="favorites-count-badge mt-3">
                <span class="badge bg-pink px-3 py-2 fs-6">
                    <i class="bi bi-heart me-1"></i>
                    {{ $recipes->count() }} recette{{ $recipes->count() > 1 ? 's' : '' }} favorite{{ $recipes->count() > 1 ? 's' : '' }}
                </span>
            </div>
        </div>

        @if($recipes->isEmpty())
            <!-- État vide amélioré -->
            <div class="empty-favorites text-center py-5">
                <div class="empty-icon mb-4">
                    <div class="heart-empty-animation">
                        <i class="bi bi-heart display-1 text-muted"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-3">Aucune recette favorite pour le moment</h4>
                <p class="text-muted mb-4">Les recettes que vous ajoutez à vos favoris apparaîtront ici.</p>
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="{{ route('recipes.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-card-list me-2"></i>
                        Explorer les recettes
                    </a>
                    <a href="{{ route('recipes.create') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>
                        Créer une recette
                    </a>
                </div>
            </div>
        @else
            <!-- Filtres et tri (optionnel) -->
            <div class="filters-section mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary btn-sm filter-btn active" data-filter="all">
                                Toutes
                            </button>
                            <button class="btn btn-outline-success btn-sm filter-btn" data-filter="facile">
                                <i class="bi bi-check-circle me-1"></i>Facile
                            </button>
                            <button class="btn btn-outline-warning btn-sm filter-btn" data-filter="moyenne">
                                <i class="bi bi-dash-circle me-1"></i>Moyenne
                            </button>
                            <button class="btn btn-outline-danger btn-sm filter-btn" data-filter="difficile">
                                <i class="bi bi-x-circle me-1"></i>Difficile
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="input-group input-group-sm" style="max-width: 250px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search text-primary"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" 
                                   placeholder="Rechercher..." id="search-favorites">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grille de recettes favorites -->
            <div class="row g-4 favorites-grid" id="favorites-grid">
                @foreach($recipes as $recipe)
                    <div class="col-lg-4 col-md-6 favorite-item" 
                         data-difficulty="{{ strtolower($recipe->difficulty) }}"
                         data-title="{{ strtolower($recipe->title) }}">
                        <div class="favorite-card card border-0 shadow-lg overflow-hidden">
                            <!-- Badge "Favorite" -->
                            <div class="favorite-badge">
                                <i class="bi bi-heart-fill"></i>
                                Favorite
                            </div>
                            
                            <!-- Image -->
                            <div class="recipe-image-wrapper position-relative">
                                @if($recipe->image && file_exists(storage_path('app/public/' . $recipe->image)))
                                    <img src="{{ asset('storage/' . $recipe->image) }}" 
                                         class="favorite-img"
                                         alt="{{ $recipe->title }}"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIGZpbGw9IiNGRjFGRjMiLz48cGF0aCBkPSJNNTAgMjVDNDAgMzAgMzAgNDAgMjUgNTBDMjAgNjAgMjUgNzUgMzUgODBDNDUgODUgNTUgOTAgNjUgODVDNzUgODAgODAgNzAgNzUgNjBDNzAgNTAgNjAgNDAgNTAgMzVWNDBaIiBmaWxsPSIjRkE1QjVDIi8+PC9zdmc+'">
                                @else
                                    <div class="no-image-placeholder favorite-placeholder">
                                        <i class="bi bi-heart text-white display-3"></i>
                                        <span class="mt-2">Favorite</span>
                                    </div>
                                @endif
                                
                                <!-- Overlay d'actions -->
                                <div class="recipe-overlay">
                                    <div class="overlay-content">
                                        <a href="{{ route('recipes.show', $recipe) }}" 
                                           class="btn btn-light btn-sm overlay-btn">
                                            <i class="bi bi-eye me-1"></i>Voir
                                        </a>
                                        <form method="POST" action="{{ route('recipes.favorite', $recipe) }}" 
                                              class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-light btn-sm overlay-btn">
                                                <i class="bi bi-heart-fill me-1"></i>Retirer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Contenu -->
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title fw-bold mb-0 favorite-title">{{ $recipe->title }}</h5>
                                    <span class="badge difficulty-badge difficulty-{{ strtolower($recipe->difficulty) }}">
                                        {{ $recipe->difficulty }}
                                    </span>
                                </div>
                                
                                <p class="card-text text-muted mb-3 favorite-description">
                                    {{ Str::limit($recipe->description, 80) }}
                                </p>
                                
                                <!-- Métadonnées -->
                                <div class="recipe-meta d-flex justify-content-between align-items-center mb-3">
                                    <div class="meta-item">
                                        <i class="bi bi-clock text-primary me-1"></i>
                                        <span>{{ $recipe->prep_time }} min</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-calendar text-primary me-1"></i>
                                        <span>Ajouté le {{ $recipe->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                
                                <!-- Boutons d'action -->
                                <div class="recipe-actions d-flex justify-content-between">
                                    <a href="{{ route('recipes.show', $recipe) }}" 
                                       class="btn btn-outline-primary btn-sm w-100 me-2">
                                        <i class="bi bi-eye me-1"></i>Voir la recette
                                    </a>
                                    <form method="POST" action="{{ route('recipes.favorite', $recipe) }}" 
                                          class="remove-favorite-form w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                            <i class="bi bi-heart-fill me-1"></i>Retirer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Message lorsque aucun résultat de filtrage -->
            <div class="no-results text-center py-5 d-none" id="no-results">
                <i class="bi bi-search display-1 text-muted mb-3"></i>
                <h4 class="fw-bold mb-3">Aucun résultat trouvé</h4>
                <p class="text-muted mb-4">Essayez de modifier vos critères de recherche ou de filtrage.</p>
                <button class="btn btn-outline-primary btn-lg" id="reset-filters">
                    <i class="bi bi-arrow-clockwise me-2"></i>
                    Réinitialiser les filtres
                </button>
            </div>

            <!-- Actions globales -->
            <div class="global-actions mt-5 pt-4 border-top text-center">
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="{{ route('recipes.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>
                        Retour aux recettes
                    </a>
                    <button class="btn btn-danger btn-lg" id="remove-all-favorites" 
                            data-bs-toggle="modal" data-bs-target="#confirmRemoveAllModal">
                        <i class="bi bi-trash me-2"></i>
                        Vider tous les favoris
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de confirmation pour vider tous les favoris -->
    <div class="modal fade" id="confirmRemoveAllModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="warning-icon mb-3">
                        <i class="bi bi-exclamation-triangle-fill display-3 text-danger"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Vider tous les favoris ?</h4>
                    <p class="text-muted mb-4">
                        Cette action supprimera toutes les recettes de vos favoris. 
                        Cette action est irréversible.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                            Annuler
                        </button>
                        <button type="button" class="btn btn-danger btn-lg" id="confirm-remove-all">
                            <i class="bi bi-trash me-2"></i>
                            Tout supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles améliorés -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --pink-gradient: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            --heart-color: #ec4899;
            --shadow-light: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 8px 24px rgba(0, 0, 0, 0.12);
            --shadow-hover: 0 12px 32px rgba(0, 0, 0, 0.15);
        }

        body {
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);
            min-height: 100vh;
        }

        .favorites-header {
            animation: slideDown 0.6s ease-out;
        }

        .heart-container {
            display: inline-block;
            padding: 1rem;
            background: var(--pink-gradient);
            border-radius: 50%;
            box-shadow: 0 8px 24px rgba(236, 72, 153, 0.3);
        }

        .heart-beat {
            font-size: 3rem;
            color: white;
            animation: heartBeat 1.5s ease-in-out infinite;
        }

        .gradient-text {
            background: var(--pink-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .badge.bg-pink {
            background: var(--pink-gradient) !important;
            color: white;
            border-radius: 50px;
            font-weight: 500;
        }

        .filters-section {
            animation: fadeIn 0.8s ease-out;
        }

        .filter-btn {
            border-radius: 50px;
            padding: 0.5rem 1.25rem;
            transition: all 0.3s ease;
        }

        .filter-btn.active {
            background: var(--pink-gradient);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
        }

        .filter-btn:hover:not(.active) {
            transform: translateY(-2px);
            box-shadow: var(--shadow-light);
        }

        .favorite-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 20px;
            overflow: hidden;
            background: white;
            animation: cardAppear 0.6s ease-out forwards;
            opacity: 0;
            position: relative;
        }

        .favorites-grid .col-lg-4:nth-child(1) .favorite-card { animation-delay: 0.1s; }
        .favorites-grid .col-lg-4:nth-child(2) .favorite-card { animation-delay: 0.2s; }
        .favorites-grid .col-lg-4:nth-child(3) .favorite-card { animation-delay: 0.3s; }

        .favorite-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover) !important;
        }

        .favorite-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--pink-gradient);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .recipe-image-wrapper {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .favorite-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .favorite-card:hover .favorite-img {
            transform: scale(1.05);
        }

        .favorite-placeholder {
            width: 100%;
            height: 100%;
            background: var(--pink-gradient);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .no-image-placeholder {
            background: linear-gradient(135deg, #ec489930 0%, #db277730 100%);
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

        .favorite-card:hover .recipe-overlay {
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

        .favorite-card:hover .overlay-btn:nth-child(1) {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.1s;
        }

        .favorite-card:hover .overlay-btn:nth-child(2) {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.2s;
        }

        .favorite-title {
            font-size: 1.25rem;
            color: #2d3748;
            transition: color 0.3s ease;
        }

        .favorite-card:hover .favorite-title {
            color: #ec4899;
        }

        .difficulty-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .difficulty-facile {
            background-color: #10b981;
            color: white;
        }

        .difficulty-moyenne {
            background-color: #f59e0b;
            color: white;
        }

        .difficulty-difficile {
            background-color: #ef4444;
            color: white;
        }

        .recipe-meta {
            font-size: 0.85rem;
            color: #718096;
        }

        .meta-item {
            display: flex;
            align-items: center;
        }

        .recipe-actions .btn {
            transition: all 0.3s ease;
            border-radius: 12px;
            padding: 0.5rem 1rem;
        }

        .recipe-actions .btn:hover {
            transform: translateY(-2px);
        }

        .remove-favorite-form button:hover {
            background-color: #dc3545;
            color: white;
        }

        .empty-favorites {
            animation: fadeInUp 0.8s ease-out;
        }

        .heart-empty-animation {
            animation: pulse 2s ease-in-out infinite;
        }

        .global-actions .btn {
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .global-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
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

        @keyframes heartBeat {
            0%, 100% {
                transform: scale(1);
            }
            25% {
                transform: scale(1.1);
            }
            50% {
                transform: scale(1);
            }
            75% {
                transform: scale(1.05);
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 0.5;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.1);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .filters-section .col-md-8 {
                width: 100%;
                margin-bottom: 1rem;
            }
            
            .filters-section .col-md-4 {
                width: 100%;
            }
            
            .recipe-actions {
                flex-direction: column;
                gap: 8px;
            }
            
            .recipe-actions .btn {
                width: 100% !important;
                margin: 0 !important;
            }
            
            .global-actions .btn {
                width: 100%;
            }
            
            .d-flex.flex-sm-row {
                flex-direction: column;
            }
        }

        /* Transitions pour filtrage */
        .favorite-item {
            transition: all 0.4s ease;
        }

        .favorite-item.hidden {
            opacity: 0;
            transform: scale(0.8);
            height: 0;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filtrage par difficulté
            const filterButtons = document.querySelectorAll('.filter-btn');
            const favoriteItems = document.querySelectorAll('.favorite-item');
            const noResults = document.getElementById('no-results');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Mettre à jour l'état actif
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    const filter = this.dataset.filter;
                    
                    // Filtrer les éléments
                    let visibleCount = 0;
                    favoriteItems.forEach(item => {
                        const difficulty = item.dataset.difficulty;
                        const shouldShow = filter === 'all' || difficulty === filter;
                        
                        if (shouldShow) {
                            item.classList.remove('hidden');
                            visibleCount++;
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                    
                    // Afficher/masquer le message "aucun résultat"
                    if (visibleCount === 0) {
                        noResults.classList.remove('d-none');
                    } else {
                        noResults.classList.add('d-none');
                    }
                });
            });
            
            // Recherche en temps réel
            const searchInput = document.getElementById('search-favorites');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    
                    let visibleCount = 0;
                    favoriteItems.forEach(item => {
                        const title = item.dataset.title;
                        const shouldShow = title.includes(searchTerm);
                        
                        if (shouldShow) {
                            item.classList.remove('hidden');
                            visibleCount++;
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                    
                    // Afficher/masquer le message "aucun résultat"
                    if (visibleCount === 0 && searchTerm !== '') {
                        noResults.classList.remove('d-none');
                    } else {
                        noResults.classList.add('d-none');
                    }
                });
            }
            
            // Réinitialiser les filtres
            const resetButton = document.getElementById('reset-filters');
            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    filterButtons.forEach(btn => {
                        if (btn.dataset.filter === 'all') {
                            btn.classList.add('active');
                        } else {
                            btn.classList.remove('active');
                        }
                    });
                    
                    if (searchInput) searchInput.value = '';
                    
                    favoriteItems.forEach(item => {
                        item.classList.remove('hidden');
                    });
                    
                    noResults.classList.add('d-none');
                });
            }
            
            // Confirmation pour retirer un favori
            const removeForms = document.querySelectorAll('.remove-favorite-form');
            removeForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Retirer cette recette de vos favoris ?')) {
                        e.preventDefault();
                    }
                });
            });
            
            // Gestion du bouton "Vider tous les favoris"
            const confirmRemoveAllBtn = document.getElementById('confirm-remove-all');
            if (confirmRemoveAllBtn) {
                confirmRemoveAllBtn.addEventListener('click', function() {
                    // Ici, vous devriez implémenter la logique backend pour supprimer tous les favoris
                    // Pour l'instant, on simule avec une alerte
                    alert('Fonctionnalité à implémenter : Suppression de tous les favoris');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('confirmRemoveAllModal'));
                    modal.hide();
                });
            }
            
            // Animation au survol des cœurs
            const heartButtons = document.querySelectorAll('.remove-favorite-form button');
            heartButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    const icon = this.querySelector('i');
                    icon.style.transform = 'scale(1.2)';
                });
                
                button.addEventListener('mouseleave', function() {
                    const icon = this.querySelector('i');
                    icon.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</x-app-layout>