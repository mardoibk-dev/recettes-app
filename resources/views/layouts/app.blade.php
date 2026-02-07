<!DOCTYPE html>
<html lang="fr" class="h-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Gestionnaire de recettes culinaires">
  <title>@yield('title', 'Dashboard - Recettes')</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Styles personnalisés -->
  <style>
    :root {
      --primary-color: #ff6b6b;
      --primary-dark: #ff4757;
      --secondary-color: #4ecdc4;
      --dark-color: #2d3436;
      --light-color: #f9f9f9;
      --gradient-primary: linear-gradient(135deg, #ff6b6b 0%, #ff4757 100%);
      --gradient-secondary: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
      --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
      --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
      --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.15);
    }
    
    * {
      font-family: 'Poppins', sans-serif;
    }
    
    body {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    
    .brand-font {
      font-family: 'Dancing Script', cursive;
      font-weight: 700;
    }
    
    .logo-icon {
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    /* Navbar améliorée */
    .navbar-main {
      background: rgba(255, 255, 255, 0.95) !important;
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(0, 0, 0, 0.08);
      box-shadow: var(--shadow-sm);
      padding: 0.75rem 0;
      transition: all 0.3s ease;
    }
    
    .navbar-main.scrolled {
      background: rgba(255, 255, 255, 0.98) !important;
      box-shadow: var(--shadow-md);
      padding: 0.5rem 0;
    }
    
    .navbar-brand {
      font-size: 1.8rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .brand-text {
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-size: 1.6rem;
    }
    
    .nav-link {
      position: relative;
      padding: 0.5rem 1rem !important;
      margin: 0 0.25rem;
      border-radius: 50px;
      font-weight: 500;
      transition: all 0.3s ease;
      color: var(--dark-color) !important;
    }
    
    .nav-link:hover {
      background: rgba(255, 107, 107, 0.1);
      color: var(--primary-color) !important;
      transform: translateY(-2px);
    }
    
    .nav-link.active {
      background: var(--gradient-primary);
      color: white !important;
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
    }
    
    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: var(--gradient-primary);
      transition: all 0.3s ease;
      transform: translateX(-50%);
    }
    
    .nav-link:hover::after {
      width: 70%;
    }
    
    .nav-link.active::after {
      display: none;
    }
    
    .favorites-nav {
      position: relative;
    }
    
    .favorites-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background: var(--gradient-primary);
      color: white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      font-size: 0.6rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .logout-btn {
      background: var(--gradient-primary);
      border: none;
      padding: 0.5rem 1.5rem;
      border-radius: 50px;
      font-weight: 500;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.2);
    }
    
    .logout-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 107, 107, 0.3);
    }
    
    .navbar-toggler {
      border: none;
      padding: 0.5rem;
      border-radius: 8px;
      background: rgba(255, 107, 107, 0.1);
    }
    
    .navbar-toggler:focus {
      box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.25);
    }
    
    /* User dropdown */
    .user-dropdown .dropdown-toggle {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      background: rgba(255, 107, 107, 0.1);
      border: none;
      color: var(--dark-color);
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .user-dropdown .dropdown-toggle:hover {
      background: rgba(255, 107, 107, 0.2);
      color: var(--primary-color);
    }
    
    .user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--gradient-primary);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      font-size: 1rem;
    }
    
    .dropdown-menu {
      border: none;
      border-radius: 12px;
      box-shadow: var(--shadow-lg);
      padding: 0.5rem;
      margin-top: 0.5rem;
      animation: dropdownSlide 0.3s ease;
    }
    
    .dropdown-item {
      padding: 0.75rem 1rem;
      border-radius: 8px;
      margin: 0.125rem 0;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .dropdown-item:hover {
      background: rgba(255, 107, 107, 0.1);
      color: var(--primary-color);
      transform: translateX(5px);
    }
    
    /* Main content */
    main {
      flex: 1;
      padding-top: 1rem;
    }
    
    /* Footer */
    .footer {
      background: rgba(255, 255, 255, 0.95);
      border-top: 1px solid rgba(0, 0, 0, 0.08);
      padding: 2rem 0;
      margin-top: auto;
    }
    
    .footer-brand {
      font-size: 1.8rem;
      font-weight: 700;
    }
    
    .footer-links a {
      color: #6c757d;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    
    .footer-links a:hover {
      color: var(--primary-color);
      transform: translateX(5px);
    }
    
    .social-links a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255, 107, 107, 0.1);
      color: var(--primary-color);
      margin: 0 0.25rem;
      transition: all 0.3s ease;
    }
    
    .social-links a:hover {
      background: var(--gradient-primary);
      color: white;
      transform: translateY(-3px);
    }
    
    /* Animations */
    @keyframes dropdownSlide {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .fade-in {
      animation: fadeIn 0.6s ease-out;
    }
    
    /* Responsive */
    @media (max-width: 991.98px) {
      .navbar-collapse {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: var(--shadow-lg);
        margin-top: 1rem;
      }
      
      .nav-link {
        margin: 0.25rem 0;
      }
      
      .logout-btn {
        margin-top: 1rem;
        width: 100%;
      }
      
      .user-dropdown {
        margin-top: 1rem;
      }
      
      .user-dropdown .dropdown-toggle {
        width: 100%;
        justify-content: center;
      }
    }
    
    @media (max-width: 767.98px) {
      .navbar-brand {
        font-size: 1.5rem;
      }
      
      .footer {
        text-align: center;
      }
      
      .footer-links {
        margin: 1rem 0;
      }
      
      .social-links {
        justify-content: center !important;
        margin-top: 1rem;
      }
    }
    
    /* Notification badge */
    .notification-badge {
      position: absolute;
      top: 5px;
      right: 5px;
      width: 8px;
      height: 8px;
      background: var(--secondary-color);
      border-radius: 50%;
      border: 2px solid white;
    }
    
    /* Active page detection */
    .nav-item .active {
      background: var(--gradient-primary);
      color: white !important;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg fixed-top" id="mainNavbar">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand" href="{{ route('dashboard') }}">
        <span class="logo-icon">
          <i class="bi bi-cup-hot-fill"></i>
        </span>
        <span class="brand-text brand-font">Recettes</span>
      </a>
      
      <!-- Mobile Toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <!-- Navbar Content -->
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav mx-auto">
          <!-- Dashboard -->
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
              <i class="bi bi-speedometer2 me-1"></i>Dashboard
            </a>
          </li>
          
          <!-- Toutes les recettes -->
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('recipes.index') ? 'active' : '' }}" href="{{ route('recipes.index') }}">
              <i class="bi bi-card-checklist me-1"></i>Toutes les recettes
            </a>
          </li>
          
          <!-- Ajouter une recette -->
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('recipes.create') ? 'active' : '' }}" href="{{ route('recipes.create') }}">
              <i class="bi bi-plus-circle me-1"></i>Ajouter une recette
            </a>
          </li>
          
          <!-- Favoris -->
          <li class="nav-item favorites-nav">
            <a class="nav-link {{ request()->routeIs('recipes.favorites') ? 'active' : '' }}" href="{{ route('recipes.favorites') }}">
              <i class="bi bi-heart me-1"></i>Favoris
              @auth
                @php
                  $favoritesCount = auth()->user()->favorites->count();
                @endphp
                @if($favoritesCount > 0)
                  <span class="favorites-badge">{{ $favoritesCount }}</span>
                @endif
              @endauth
            </a>
          </li>
        </ul>
        
        <!-- User Menu & Logout -->
        <div class="d-flex align-items-center gap-2">
          <!-- User Dropdown -->
          <div class="dropdown user-dropdown">
            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
              <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
              </div>
              <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
              <i class="bi bi-chevron-down"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="{{ route('dashboard') }}">
                  <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('recipes.index') }}">
                  <i class="bi bi-card-checklist me-2"></i>Mes recettes
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('recipes.favorites') }}">
                  <i class="bi bi-heart me-2"></i>Mes favoris
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                  </button>
                </form>
              </li>
            </ul>
          </div>
          
          <!-- Logout Button (visible on mobile) -->
          <form method="POST" action="{{ route('logout') }}" class="d-lg-none">
            @csrf
            <button type="submit" class="btn logout-btn btn-sm">
              <i class="bi bi-box-arrow-right"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </nav>
  
  <!-- Spacer pour le contenu (à cause de la navbar fixed) -->
  <div class="navbar-spacer" style="height: 80px;"></div>

  <!-- Contenu principal -->
  <main class="container my-4 fade-in">
    {{ $slot }}
  </main>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4">
          <a href="{{ route('dashboard') }}" class="footer-brand text-decoration-none">
            <span class="brand-text brand-font">Recettes</span>
          </a>
          <p class="text-muted small mt-2">Votre compagnon culinaire au quotidien</p>
        </div>
        
        <div class="col-md-4">
          <div class="footer-links">
            <div class="row">
              <div class="col-6">
                <ul class="list-unstyled">
                  <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                  <li><a href="{{ route('recipes.index') }}">Recettes</a></li>
                  <li><a href="{{ route('recipes.create') }}">Créer</a></li>
                </ul>
              </div>
              <div class="col-6">
                <ul class="list-unstyled">
                  <li><a href="{{ route('recipes.favorites') }}">Favoris</a></li>
                  <li><a href="#">À propos</a></li>
                  <li><a href="#">Contact</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="social-links d-flex justify-content-md-end">
            <a href="#" title="Facebook">
              <i class="bi bi-facebook"></i>
            </a>
            <a href="#" title="Instagram">
              <i class="bi bi-instagram"></i>
            </a>
            <a href="#" title="Twitter">
              <i class="bi bi-twitter"></i>
            </a>
            <a href="#" title="GitHub">
              <i class="bi bi-github"></i>
            </a>
          </div>
          <p class="text-muted small text-md-end mt-3">
            &copy; {{ date('Y') }} Recettes. Tous droits réservés.
          </p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Scripts personnalisés -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Navbar scroll effect
      const navbar = document.getElementById('mainNavbar');
      window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
      });
      
      // Active nav link based on current page
      const currentPath = window.location.pathname;
      document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
          link.classList.add('active');
        }
      });
      
      // Tooltip initialization
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
      
      // Mobile menu close on click
      const navLinks = document.querySelectorAll('.nav-link');
      const navbarCollapse = document.querySelector('.navbar-collapse');
      const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
      
      navLinks.forEach(link => {
        link.addEventListener('click', () => {
          if (bsCollapse && window.innerWidth < 992) {
            bsCollapse.hide();
          }
        });
      });
      
      // Dropdown hover effect for desktop
      const dropdowns = document.querySelectorAll('.dropdown');
      if (window.innerWidth >= 992) {
        dropdowns.forEach(dropdown => {
          dropdown.addEventListener('mouseenter', function() {
            const dropdownMenu = this.querySelector('.dropdown-menu');
            if (dropdownMenu) {
              dropdownMenu.classList.add('show');
            }
          });
          
          dropdown.addEventListener('mouseleave', function() {
            const dropdownMenu = this.querySelector('.dropdown-menu');
            if (dropdownMenu) {
              dropdownMenu.classList.remove('show');
            }
          });
        });
      }
      
      // Smooth scrolling for anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          const href = this.getAttribute('href');
          if (href === '#') return;
          
          e.preventDefault();
          const target = document.querySelector(href);
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        });
      });
      
      // Notification dot animation
      const notificationBadge = document.querySelector('.notification-badge');
      if (notificationBadge) {
        setInterval(() => {
          notificationBadge.style.transform = 'scale(1.2)';
          setTimeout(() => {
            notificationBadge.style.transform = 'scale(1)';
          }, 300);
        }, 3000);
      }
    });
    
    // Page transition
    window.addEventListener('beforeunload', function() {
      document.body.classList.add('fade-out');
    });
  </script>
</body>

</html>