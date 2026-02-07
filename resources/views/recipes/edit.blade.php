<x-app-layout>
    <div class="container py-4 px-3 px-md-4">

        <!-- Header avec design moderne -->
        <div class="edit-header mb-5">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-secondary btn-sm me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="fw-bold gradient-text display-5 mb-1">Modifier la recette</h1>
                    <p class="text-muted fs-5">{{ $recipe->title }}</p>
                </div>
            </div>
            
            <!-- Barre de progression -->
            <div class="progress-steps">
                <div class="steps">
                    <div class="step active">
                        <div class="step-icon">
                            <i class="bi bi-pencil"></i>
                        </div>
                        <div class="step-label">Édition</div>
                    </div>
                    <div class="step">
                        <div class="step-icon">
                            <i class="bi bi-eye"></i>
                        </div>
                        <div class="step-label">Aperçu</div>
                    </div>
                    <div class="step">
                        <div class="step-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="step-label">Terminé</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages améliorés -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Recette mise à jour !</h6>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Veuillez corriger les erreurs suivantes :</h6>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulaire d'édition -->
        <div class="row">
            <div class="col-lg-8">
                <div class="edit-form-card card border-0 shadow-lg overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data" id="edit-form">
                            @csrf
                            @method('PUT')

                            <!-- Section Titre -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <i class="bi bi-card-heading me-2 text-primary"></i>
                                    <h4 class="fw-bold mb-0">Titre de la recette</h4>
                                </div>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-pencil text-primary"></i>
                                    </span>
                                    <input type="text" name="title" id="title" 
                                           class="form-control border-start-0 ps-0" 
                                           value="{{ old('title', $recipe->title) }}"
                                           placeholder="Ex : Poulet rôti aux herbes de Provence"
                                           required>
                                </div>
                            </div>

                            <!-- Section Description -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <i class="bi bi-chat-left-text me-2 text-primary"></i>
                                    <h4 class="fw-bold mb-0">Description</h4>
                                </div>
                                <div class="form-floating">
                                    <textarea name="description" id="description" 
                                              class="form-control" 
                                              style="height: 120px" 
                                              placeholder="Décrivez votre recette...">{{ old('description', $recipe->description) }}</textarea>
                                    <label for="description">Description détaillée de votre recette...</label>
                                </div>
                                <div class="form-text text-end mt-2">
                                    <span id="char-count">{{ strlen(old('description', $recipe->description)) }}</span>/500 caractères
                                </div>
                            </div>

                            <!-- Section Informations -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <i class="bi bi-info-circle me-2 text-primary"></i>
                                    <h4 class="fw-bold mb-0">Informations</h4>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <label class="form-label fw-semibold mb-2">
                                                <i class="bi bi-clock me-1 text-primary"></i>
                                                Temps de préparation
                                            </label>
                                            <div class="input-group">
                                                <input type="number" name="prep_time" id="prep_time" 
                                                       class="form-control" 
                                                       value="{{ old('prep_time', $recipe->prep_time) }}"
                                                       min="1" max="1440" required>
                                                <span class="input-group-text bg-light">minutes</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <label class="form-label fw-semibold mb-2">
                                                <i class="bi bi-speedometer2 me-1 text-primary"></i>
                                                Niveau de difficulté
                                            </label>
                                            <div class="difficulty-selector">
                                                <div class="btn-group w-100" role="group">
                                                    <input type="radio" class="btn-check" name="difficulty" 
                                                           id="facile" value="Facile" 
                                                           {{ old('difficulty', $recipe->difficulty) == 'Facile' ? 'checked' : '' }}>
                                                    <label class="btn btn-outline-success" for="facile">
                                                        <i class="bi bi-check-circle me-1"></i>Facile
                                                    </label>
                                                    
                                                    <input type="radio" class="btn-check" name="difficulty" 
                                                           id="moyenne" value="Moyenne"
                                                           {{ old('difficulty', $recipe->difficulty) == 'Moyenne' ? 'checked' : '' }}>
                                                    <label class="btn btn-outline-warning" for="moyenne">
                                                        <i class="bi bi-dash-circle me-1"></i>Moyenne
                                                    </label>
                                                    
                                                    <input type="radio" class="btn-check" name="difficulty" 
                                                           id="difficile" value="Difficile"
                                                           {{ old('difficulty', $recipe->difficulty) == 'Difficile' ? 'checked' : '' }}>
                                                    <label class="btn btn-outline-danger" for="difficile">
                                                        <i class="bi bi-x-circle me-1"></i>Difficile
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section Image -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-image me-2 text-primary"></i>
                                        <h4 class="fw-bold mb-0">Image de la recette</h4>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="change-image-toggle">
                                        <label class="form-check-label small" for="change-image-toggle">
                                            Modifier l'image
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Image actuelle -->
                                <div class="current-image mb-4" id="current-image">
                                    @if($recipe->image && file_exists(storage_path('app/public/' . $recipe->image)))
                                        <div class="image-container">
                                            <img src="{{ asset('storage/' . $recipe->image) }}" 
                                                 class="current-img rounded"
                                                 alt="{{ $recipe->title }}"
                                                 onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIGZpbGw9IiNGMEYyRjQiLz48cGF0aCBkPSJNMzUgNDBDMzUgMzQuNDc3MiAzOS40NzcyIDMwIDQ1IDMwQzUwLjUyMjggMzAgNTUgMzQuNDc3MiA1NSA0MEM1NSA0NS41MjI4IDUwLjUyMjggNTAgNDUgNTBDMzkuNDc3MiA1MCAzNSA0NS41MjI4IDM1IDQwWiIgZmlsbD0iI0NBQ0JDMiIvPjxwYXRoIGQ9Ik03MCA3MEM3MCA3MCA2MCA4MCA0NSA4MEMzMCA4MCAyMCA3MCAyMCA3MEwyMCA2MEMyMCA1NSA0MCA1MCA1MCA1MEM2MCA1MCA4MCA1NSA4MCA2MEw3MCA3MFoiIGZpbGw9IiNDQUNCQzIiLz48L3N2Zz4=';">
                                            <div class="image-overlay">
                                                <span class="badge bg-info">
                                                    <i class="bi bi-image me-1"></i>Image actuelle
                                                </span>
                                            </div>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Laissez le champ vide pour conserver cette image.
                                        </p>
                                    @else
                                        <div class="no-current-image text-center p-4 border rounded">
                                            <i class="bi bi-image display-4 text-muted mb-3"></i>
                                            <p class="text-muted mb-0">Aucune image associée à cette recette</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Upload de nouvelle image -->
                                <div class="new-image-upload d-none" id="new-image-upload">
                                    <div class="upload-area" id="upload-area">
                                        <i class="bi bi-cloud-arrow-up display-4 text-muted mb-3"></i>
                                        <p class="mb-2">Glissez-déposez votre nouvelle image ici</p>
                                        <p class="text-muted small mb-3">ou cliquez pour parcourir</p>
                                        <input type="file" name="image" id="image-input" class="d-none" accept="image/*">
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="browse-btn">
                                            <i class="bi bi-folder2-open me-1"></i>Choisir un fichier
                                        </button>
                                    </div>
                                    <div class="image-preview mt-3 d-none" id="image-preview">
                                        <div class="preview-container">
                                            <img id="preview-image" class="preview-img">
                                            <button type="button" class="btn-close preview-close" id="remove-image"></button>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Formats acceptés : JPG, PNG, GIF • Max : 5MB
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="form-actions mt-5 pt-4 border-top">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                                    <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-secondary btn-lg w-100">
                                        <i class="bi bi-eye me-2"></i>
                                        Voir la recette
                                    </a>
                                    <div class="d-flex gap-3 w-100">
                                        <a href="{{ route('recipes.index') }}" class="btn btn-outline-secondary btn-lg w-50">
                                            <i class="bi bi-x-circle me-2"></i>
                                            Annuler
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-lg w-50 submit-btn">
                                            <i class="bi bi-check-circle me-2"></i>
                                            Enregistrer
                                            <span class="spinner-border spinner-border-sm d-none ms-2" id="submit-spinner"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar d'aperçu -->
            <div class="col-lg-4">
                <div class="preview-sidebar sticky-top">
                    <!-- Aperçu de la recette -->
                    <div class="preview-card card border-0 shadow-lg overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-eye me-2 text-primary"></i>
                                Aperçu en direct
                            </h5>
                            
                            <!-- Image d'aperçu -->
                            <div class="preview-image mb-3">
                                <div class="preview-img-container rounded overflow-hidden">
                                    @if($recipe->image && file_exists(storage_path('app/public/' . $recipe->image)))
                                        <img src="{{ asset('storage/' . $recipe->image) }}" 
                                             id="preview-current-image"
                                             class="w-100"
                                             alt="Aperçu"
                                             style="height: 180px; object-fit: cover;">
                                    @else
                                        <div class="no-preview-image bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 180px;">
                                            <i class="bi bi-image text-muted display-4"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Titre d'aperçu -->
                            <h6 id="preview-title" class="fw-bold mb-2">{{ $recipe->title }}</h6>
                            
                            <!-- Description d'aperçu -->
                            <p id="preview-description" class="text-muted small mb-3">
                                {{ Str::limit($recipe->description, 100) }}
                            </p>
                            
                            <!-- Métadonnées d'aperçu -->
                            <div class="preview-meta d-flex justify-content-between small">
                                <div>
                                    <i class="bi bi-clock text-primary me-1"></i>
                                    <span id="preview-time">{{ $recipe->prep_time }}</span> min
                                </div>
                                <div>
                                    <i class="bi bi-speedometer2 text-primary me-1"></i>
                                    <span id="preview-difficulty">{{ $recipe->difficulty }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions rapides -->
                    <div class="quick-actions mt-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-3">Actions rapides</h6>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye me-2"></i>Voir en public
                                    </a>
                                    <button type="button" class="btn btn-outline-warning btn-sm" id="reset-form">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="bi bi-trash me-2"></i>Supprimer la recette
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="warning-icon mb-3">
                        <i class="bi bi-exclamation-triangle-fill display-3 text-danger"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Supprimer cette recette ?</h4>
                    <p class="text-muted mb-4">
                        Cette action est irréversible. La recette sera définitivement supprimée.
                    </p>
                    <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="bi bi-trash me-2"></i>
                                Supprimer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles améliorés -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .edit-header {
            animation: slideDown 0.6s ease-out;
        }

        .gradient-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .progress-steps {
            max-width: 400px;
            margin-top: 2rem;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 24px;
            left: 20px;
            right: 20px;
            height: 2px;
            background: #e5e7eb;
            z-index: 1;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .step-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: white;
            border: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .step.active .step-icon {
            background: var(--primary-gradient);
            border-color: transparent;
            color: white;
            transform: scale(1.1);
        }

        .step-label {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 500;
        }

        .step.active .step-label {
            color: #3b82f6;
            font-weight: 600;
        }

        .edit-form-card {
            border-radius: 20px;
            animation: fadeInUp 0.8s ease-out;
        }

        .form-section {
            padding: 1.5rem;
            background: white;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
        }

        .section-header {
            display: flex;
            align-items: center;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .input-group:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
            border-radius: 8px;
        }

        .difficulty-selector .btn {
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .difficulty-selector .btn-check:checked + .btn {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-check:checked + .btn-outline-success {
            background: var(--success-gradient);
            color: white;
            border-color: transparent;
        }

        .btn-check:checked + .btn-outline-warning {
            background: var(--warning-gradient);
            color: white;
            border-color: transparent;
        }

        .btn-check:checked + .btn-outline-danger {
            background: var(--danger-gradient);
            color: white;
            border-color: transparent;
        }

        .current-image .image-container {
            position: relative;
            max-width: 100%;
            height: 200px;
            overflow: hidden;
            border-radius: 12px;
        }

        .current-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-overlay {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .upload-area {
            border: 3px dashed #d1d5db;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            background: #f9fafb;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: #3b82f6;
            background: #f0f7ff;
        }

        .upload-area.dragover {
            border-color: #10b981;
            background: #f0fdf4;
            transform: scale(1.02);
        }

        .preview-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .preview-sidebar {
            top: 20px;
        }

        .preview-card {
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .preview-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15) !important;
        }

        .quick-actions .btn {
            transition: all 0.3s ease;
        }

        .quick-actions .btn:hover {
            transform: translateY(-2px);
        }

        .form-actions .btn {
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .submit-btn {
            background: var(--primary-gradient);
            border: none;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
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

        /* Responsive */
        @media (max-width: 992px) {
            .preview-sidebar {
                position: static !important;
                margin-top: 2rem;
            }
            
            .form-actions .d-flex {
                flex-direction: column;
            }
            
            .form-actions .btn {
                width: 100% !important;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .difficulty-selector .btn-group {
                flex-direction: column;
            }
            
            .difficulty-selector .btn {
                border-radius: 8px !important;
                margin-bottom: 0.5rem;
            }
            
            .progress-steps {
                max-width: 100%;
            }
            
            .steps::before {
                display: none;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Compteur de caractères pour la description
            const description = document.getElementById('description');
            const charCount = document.getElementById('char-count');
            
            if (description && charCount) {
                description.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                    
                    // Mettre à jour l'aperçu
                    updatePreview();
                });
            }
            
            // Mise à jour de l'aperçu en temps réel
            function updatePreview() {
                const title = document.getElementById('title');
                const prepTime = document.getElementById('prep_time');
                const difficultyElements = document.querySelectorAll('input[name="difficulty"]:checked');
                
                if (title) {
                    document.getElementById('preview-title').textContent = title.value || 'Titre de la recette';
                }
                
                if (description) {
                    document.getElementById('preview-description').textContent = 
                        description.value.substring(0, 100) + (description.value.length > 100 ? '...' : '');
                }
                
                if (prepTime) {
                    document.getElementById('preview-time').textContent = prepTime.value;
                }
                
                if (difficultyElements.length > 0) {
                    document.getElementById('preview-difficulty').textContent = difficultyElements[0].value;
                }
            }
            
            // Ajouter les écouteurs d'événements pour la mise à jour de l'aperçu
            document.getElementById('title')?.addEventListener('input', updatePreview);
            document.getElementById('prep_time')?.addEventListener('input', updatePreview);
            document.querySelectorAll('input[name="difficulty"]').forEach(radio => {
                radio.addEventListener('change', updatePreview);
            });
            
            // Gestion du toggle d'image
            const imageToggle = document.getElementById('change-image-toggle');
            const currentImage = document.getElementById('current-image');
            const newImageUpload = document.getElementById('new-image-upload');
            
            if (imageToggle) {
                imageToggle.addEventListener('change', function() {
                    if (this.checked) {
                        currentImage.classList.add('d-none');
                        newImageUpload.classList.remove('d-none');
                    } else {
                        currentImage.classList.remove('d-none');
                        newImageUpload.classList.add('d-none');
                    }
                });
            }
            
            // Gestion de l'upload d'image
            const uploadArea = document.getElementById('upload-area');
            const imageInput = document.getElementById('image-input');
            const browseBtn = document.getElementById('browse-btn');
            const imagePreview = document.getElementById('image-preview');
            const previewImage = document.getElementById('preview-image');
            const removeImageBtn = document.getElementById('remove-image');
            
            if (browseBtn && imageInput) {
                browseBtn.addEventListener('click', () => imageInput.click());
                uploadArea.addEventListener('click', () => imageInput.click());
            }
            
            if (uploadArea) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, preventDefaults, false);
                });
                
                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                
                ['dragenter', 'dragover'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, highlight, false);
                });
                
                ['dragleave', 'drop'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, unhighlight, false);
                });
                
                function highlight() {
                    uploadArea.classList.add('dragover');
                }
                
                function unhighlight() {
                    uploadArea.classList.remove('dragover');
                }
                
                uploadArea.addEventListener('drop', handleDrop, false);
                
                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    imageInput.files = files;
                    handleImage(files[0]);
                }
            }
            
            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        handleImage(this.files[0]);
                    }
                });
            }
            
            function handleImage(file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const maxSize = 5 * 1024 * 1024;
                
                if (!validTypes.includes(file.type)) {
                    alert('Format de fichier non supporté. Utilisez JPG, PNG ou GIF.');
                    return;
                }
                
                if (file.size > maxSize) {
                    alert('Fichier trop volumineux. Taille maximum : 5MB.');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
            
            if (removeImageBtn) {
                removeImageBtn.addEventListener('click', function() {
                    imageInput.value = '';
                    imagePreview.classList.add('d-none');
                });
            }
            
            // Réinitialiser le formulaire
            const resetButton = document.getElementById('reset-form');
            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    if (confirm('Réinitialiser toutes les modifications ?')) {
                        document.getElementById('edit-form').reset();
                        
                        // Réinitialiser les boutons radio de difficulté
                        const originalDifficulty = '{{ $recipe->difficulty }}';
                        document.querySelectorAll('input[name="difficulty"]').forEach(radio => {
                            radio.checked = radio.value === originalDifficulty;
                        });
                        
                        // Réinitialiser le toggle d'image
                        if (imageToggle) {
                            imageToggle.checked = false;
                            currentImage.classList.remove('d-none');
                            newImageUpload.classList.add('d-none');
                        }
                        
                        // Mettre à jour l'aperçu
                        updatePreview();
                    }
                });
            }
            
            // Soumission du formulaire
            const form = document.getElementById('edit-form');
            const submitBtn = document.querySelector('.submit-btn');
            const submitSpinner = document.getElementById('submit-spinner');
            
            if (form && submitBtn) {
                form.addEventListener('submit', function() {
                    submitBtn.disabled = true;
                    if (submitSpinner) {
                        submitSpinner.classList.remove('d-none');
                    }
                    submitBtn.innerHTML = `
                        <i class="bi bi-hourglass-split me-2"></i>
                        Enregistrement...
                        <span class="spinner-border spinner-border-sm ms-2"></span>
                    `;
                });
            }
        });
    </script>
</x-app-layout>