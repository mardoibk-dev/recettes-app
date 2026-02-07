<x-app-layout>
    <div class="container py-4 px-3 px-md-4">

        <!-- Header avec design moderne -->
        <div class="form-header text-center mb-5">
            <div class="form-icon mb-3">
                <i class="bi bi-journal-plus display-3 text-primary"></i>
            </div>
            <h1 class="fw-bold gradient-text display-5 mb-2">Créer une nouvelle recette</h1>
            <p class="text-muted fs-5">Partagez votre création culinaire avec la communauté</p>
        </div>

        <!-- Form Card avec design moderne -->
        <div class="form-card card border-0 shadow-lg overflow-hidden">
            <div class="card-body p-4 p-md-5">
                
                <!-- Affichage des erreurs amélioré -->
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

                <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" id="recipe-form">
                    @csrf

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
                            <input type="text" name="title" class="form-control border-start-0 ps-0" 
                                   placeholder="Ex : Poulet rôti aux herbes de Provence" 
                                   value="{{ old('title') }}"
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
                            <textarea name="description" class="form-control" id="description" 
                                      style="height: 120px" placeholder="Une courte description...">{{ old('description') }}</textarea>
                            <label for="description">Décrivez votre recette en quelques mots...</label>
                        </div>
                        <div class="form-text text-end mt-2">
                            <span id="char-count">0</span>/500 caractères
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
                                        <input type="number" name="prep_time" class="form-control" 
                                               min="1" max="1440" value="{{ old('prep_time') }}" required>
                                        <span class="input-group-text bg-light">minutes</span>
                                    </div>
                                    <div class="form-text">Entre 1 et 1440 minutes</div>
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
                                                   {{ old('difficulty') == 'Facile' ? 'checked' : 'checked' }}>
                                            <label class="btn btn-outline-success" for="facile">
                                                <i class="bi bi-check-circle me-1"></i>Facile
                                            </label>
                                            
                                            <input type="radio" class="btn-check" name="difficulty" 
                                                   id="moyenne" value="Moyenne"
                                                   {{ old('difficulty') == 'Moyenne' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="moyenne">
                                                <i class="bi bi-dash-circle me-1"></i>Moyenne
                                            </label>
                                            
                                            <input type="radio" class="btn-check" name="difficulty" 
                                                   id="difficile" value="Difficile"
                                                   {{ old('difficulty') == 'Difficile' ? 'checked' : '' }}>
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
                        <div class="section-header mb-3">
                            <i class="bi bi-image me-2 text-primary"></i>
                            <h4 class="fw-bold mb-0">Image de la recette</h4>
                        </div>
                        <div class="image-upload-wrapper">
                            <div class="upload-area" id="upload-area">
                                <i class="bi bi-cloud-arrow-up display-4 text-muted mb-3"></i>
                                <p class="mb-2">Glissez-déposez votre image ici</p>
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

                    <!-- Section Fonctionnalités à venir -->
                    <div class="coming-soon-section">
                        <div class="section-header mb-3">
                            <i class="bi bi-hourglass-split me-2 text-primary"></i>
                            <h4 class="fw-bold mb-0">Fonctionnalités à venir</h4>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="coming-soon-card">
                                    <div class="coming-soon-icon">
                                        <i class="bi bi-cart-check text-muted"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Ingrédients détaillés</h6>
                                    <p class="text-muted small mb-0">Ajoutez vos ingrédients avec quantités</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="coming-soon-card">
                                    <div class="coming-soon-icon">
                                        <i class="bi bi-list-ol text-muted"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Étapes de préparation</h6>
                                    <p class="text-muted small mb-0">Détaillez chaque étape de votre recette</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="form-actions mt-5 pt-4 border-top">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                            <a href="{{ route('recipes.index') }}" class="btn btn-outline-secondary btn-lg w-100">
                                <i class="bi bi-arrow-left me-2"></i>
                                Retour aux recettes
                            </a>
                            <button type="submit" class="btn btn-success btn-lg w-100 submit-btn">
                                <i class="bi bi-plus-circle me-2"></i>
                                Créer la recette
                                <span class="spinner-border spinner-border-sm d-none ms-2" id="submit-spinner"></span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <!-- Styles améliorés -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .form-header {
            animation: slideDown 0.6s ease-out;
        }

        .form-icon {
            animation: bounceIn 1s ease;
        }

        .gradient-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-card {
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
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }

        .section-header {
            display: flex;
            align-items: center;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .input-wrapper {
            position: relative;
        }

        .input-group {
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
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

        .image-upload-wrapper {
            position: relative;
        }

        .upload-area {
            border: 3px dashed #d1d5db;
            border-radius: 16px;
            padding: 3rem 2rem;
            text-align: center;
            background: #f9fafb;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: #667eea;
            background: #f0f5ff;
        }

        .upload-area.dragover {
            border-color: #10b981;
            background: #f0fdf4;
            transform: scale(1.02);
        }

        .image-preview .preview-container {
            position: relative;
            max-width: 300px;
            margin: 0 auto;
        }

        .preview-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .preview-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .preview-close:hover {
            opacity: 1;
        }

        .coming-soon-section {
            opacity: 0.8;
            filter: grayscale(0.5);
        }

        .coming-soon-card {
            background: #f8fafc;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
        }

        .coming-soon-card:hover {
            transform: translateY(-4px);
            border-color: #94a3b8;
        }

        .coming-soon-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .form-actions .btn {
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .submit-btn {
            background: var(--success-gradient);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn::after {
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

        .submit-btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
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

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .form-card {
                margin-left: -0.75rem;
                margin-right: -0.75rem;
                border-radius: 0;
            }
            
            .form-section {
                padding: 1rem;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .btn-group .btn {
                border-radius: 8px !important;
                margin-bottom: 0.5rem;
            }
        }

        /* Validation states */
        .was-validated .form-control:valid {
            border-color: #10b981;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        }

        .was-validated .form-control:invalid {
            border-color: #ef4444;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ef4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ef4444' stroke='none'/%3e%3c/svg%3e");
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Compteur de caractères pour la description
            const description = document.getElementById('description');
            const charCount = document.getElementById('char-count');
            
            if (description && charCount) {
                charCount.textContent = description.value.length;
                
                description.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                    
                    // Changer la couleur selon le nombre de caractères
                    if (this.value.length > 450) {
                        charCount.classList.add('text-danger');
                        charCount.classList.remove('text-warning');
                    } else if (this.value.length > 400) {
                        charCount.classList.add('text-warning');
                        charCount.classList.remove('text-danger');
                    } else {
                        charCount.classList.remove('text-danger', 'text-warning');
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
            
            // Ouvrir le sélecteur de fichiers
            if (browseBtn && imageInput) {
                browseBtn.addEventListener('click', () => imageInput.click());
                uploadArea.addEventListener('click', () => imageInput.click());
            }
            
            // Drag and drop
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
            
            // Gestion du changement de fichier
            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        handleImage(this.files[0]);
                    }
                });
            }
            
            function handleImage(file) {
                // Validation basique du fichier
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const maxSize = 5 * 1024 * 1024; // 5MB
                
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
                    uploadArea.classList.add('d-none');
                };
                reader.readAsDataURL(file);
            }
            
            // Supprimer l'image
            if (removeImageBtn) {
                removeImageBtn.addEventListener('click', function() {
                    imageInput.value = '';
                    imagePreview.classList.add('d-none');
                    uploadArea.classList.remove('d-none');
                });
            }
            
            // Soumission du formulaire
            const form = document.getElementById('recipe-form');
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
                        Création en cours...
                        <span class="spinner-border spinner-border-sm ms-2" id="submit-spinner"></span>
                    `;
                });
            }
            
            // Validation en temps réel
            const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    this.classList.add('touched');
                    validateField(this);
                });
                
                input.addEventListener('input', function() {
                    if (this.classList.contains('touched')) {
                        validateField(this);
                    }
                });
            });
            
            function validateField(field) {
                if (field.value.trim() === '') {
                    field.classList.add('is-invalid');
                    field.classList.remove('is-valid');
                } else {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                }
            }
            
            // Animation des sections
            const sections = document.querySelectorAll('.form-section');
            sections.forEach((section, index) => {
                section.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</x-app-layout>