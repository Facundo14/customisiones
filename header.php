<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <!-- Google Fonts: Playfair Display & Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <style>
      /* Comportamientos suaves nativos */
      html {
        scroll-behavior: smooth;
      }
      /* Clases para animación con scroll */
      .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
      }
      .reveal.active {
        opacity: 1;
        transform: translateY(0);
      }
      /* Estilos básicos para el menú que inyectará WordPress */
      .primary-menu-nav ul {
          display: flex;
          list-style: none;
          padding: 0;
          margin: 0;
      }
      .primary-menu-nav-desktop ul {
          gap: 2rem;
      }
      .primary-menu-nav-mobile ul {
          flex-direction: column;
          gap: 1rem;
      }
      .primary-menu-nav li a {
          transition: color 0.3s;
      }
      .primary-menu-nav li a:hover {
          color: #D4A65A; /* custom-accent */
      }
    </style>
    <script>
      // Toggle dark mode basado en OS o localStorage
      if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }

      document.addEventListener('DOMContentLoaded', () => {
          // JS para Animaciones de Scroll (Intersecton Observer)
          const reveals = document.querySelectorAll('.reveal');
          const revealObserver = new IntersectionObserver((entries, observer) => {
              entries.forEach(entry => {
                  if (entry.isIntersecting) {
                      entry.target.classList.add('active');
                      observer.unobserve(entry.target);
                  }
              });
          }, { rootMargin: "0px 0px -100px 0px" });

          reveals.forEach(el => revealObserver.observe(el));

          // JS para Menú Móvil
          const mobileMenuBtn = document.getElementById('mobile-menu-btn');
          const mobileMenuInfo = document.getElementById('mobile-menu');
          if (mobileMenuBtn && mobileMenuInfo) {
              mobileMenuBtn.addEventListener('click', () => {
                  mobileMenuInfo.classList.toggle('hidden');
              });
          }
      });
    </script>
</head>
<body <?php body_class('bg-custom-bg dark:bg-custom-darkbg text-custom-text dark:text-custom-darktext antialiased font-sans flex flex-col min-h-screen transition-colors duration-500 overflow-x-hidden'); ?>>
<?php wp_body_open(); ?>

<!-- Navbar minimalista con Toggle y Menú -->
<header class="w-full bg-custom-bg/90 dark:bg-custom-darkbg/90 backdrop-blur-md sticky top-0 transition-colors duration-500 z-50 shadow-sm">
    <div class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            
            <!-- BRANDING LOGO -->
            <a href="<?php echo home_url('/'); ?>" class="flex flex-col items-center hover:opacity-90 transition-opacity z-10">
                <div class="text-3xl font-bold font-title tracking-tight flex items-baseline leading-none drop-shadow-md">
                    <span class="text-white">CustoM</span>
                    <span class="text-custom-accent">isiones</span>
                </div>
                <div class="text-[0.65rem] tracking-[0.3em] font-medium text-custom-subtext dark:text-custom-darktext/70 uppercase text-center mt-1 w-full relative flex items-center justify-center">
                    <span class="h-px bg-custom-subtext/30 flex-grow mx-2 dark:bg-custom-darktext/20"></span>
                    HOGAR & DECO
                    <span class="h-px bg-custom-subtext/30 flex-grow mx-2 dark:bg-custom-darktext/20"></span>
                </div>
            </a>
            
            <!-- Menu Desktop -->
            <nav class="hidden md:flex flex-grow justify-center primary-menu-nav primary-menu-nav-desktop items-center font-medium font-sans">
                <?php 
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'depth' => 1,
                    ) ); 
                } else {
                    // Fallback visual si todavía no asignó menú
                    echo '<ul class="flex gap-8"><li class="text-custom-subtext italic text-sm">Crea tu menú en Apariencia > Menús</li></ul>';
                }
                ?>
            </nav>

            <!-- Menu Right (Dark Mode Switcher & Hamburger) -->
            <div class="flex items-center gap-2 md:gap-4 z-10">
                <!-- Dark Mode Toggle -->
                <button id="theme-toggle-btn" class="p-2 rounded-full hover:bg-custom-text/5 dark:hover:bg-custom-darktext/5 transition-colors text-custom-primary dark:text-custom-darktext focus:outline-none" aria-label="Toggle Dark Mode">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="theme-toggle-svg">
                        <mask id="moon-mask">
                            <rect x="0" y="0" width="100%" height="100%" fill="white" />
                            <circle cx="24" cy="0" r="6" fill="black" class="moon-mask-hole" />
                        </mask>
                        <circle cx="12" cy="12" r="5" fill="currentColor" mask="url(#moon-mask)" class="sun-core" />
                        <g class="sun-rays">
                            <line x1="12" y1="1" x2="12" y2="3" />
                            <line x1="12" y1="21" x2="12" y2="23" />
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                            <line x1="1" y1="12" x2="3" y2="12" />
                            <line x1="21" y1="12" x2="23" y2="12" />
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
                        </g>
                    </svg>
                </button>

                <!-- Hamburger Icon -->
                <button id="mobile-menu-btn" class="md:hidden p-2 text-custom-primary dark:text-custom-white rounded-md focus:outline-none focus:ring-2 focus:ring-custom-accent">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            
        </div>
        
        <!-- Menu Mobile -->
        <div id="mobile-menu" class="hidden md:hidden mt-6 pb-4 border-t border-custom-primary/10 dark:border-custom-darktext/10 pt-4 primary-menu-nav primary-menu-nav-mobile text-center font-medium font-sans">
            <?php 
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'depth' => 1,
                ) ); 
            } else {
                echo '<ul><li class="text-custom-subtext italic mb-2">Asigna tu menú desde WP Admin</li></ul>';
            }
            ?>
        </div>
    </div>
</header>
