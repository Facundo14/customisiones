<?php
/**
 * CustoMisiones Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ─── SETUP THEME ───────────────────────────────────────────────────────────────
function customisiones_setup_theme() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    register_nav_menus( array(
        'primary' => __( 'Menú Principal', 'customisiones' ),
    ) );
}
add_action( 'after_setup_theme', 'customisiones_setup_theme' );

// ─── ENQUEUE SCRIPTS ───────────────────────────────────────────────────────────
function customisiones_enqueue_scripts() {
    wp_enqueue_style( 'customisiones-style', get_template_directory_uri() . '/style.css', array(), '1.0.0' );
    $output_css = get_template_directory() . '/assets/css/output.css';
    if ( file_exists( $output_css ) ) {
        wp_enqueue_style( 'customisiones-tailwind', get_template_directory_uri() . '/assets/css/output.css', array(), filemtime( $output_css ) );
    }
    // Script AJAX para actualizar el carrito en tiempo real
    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_script( 'customisiones-cart', get_template_directory_uri() . '/assets/js/cart.js', array( 'jquery' ), '1.0.0', true );
        wp_localize_script( 'customisiones-cart', 'customisionesvars', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'customisiones_enqueue_scripts' );

// ─── FRAGMENTOS CARRITO AJAX ────────────────────────────────────────────────────
function customisiones_cart_fragment( $fragments ) {
    ob_start();
    customisiones_cart_icon_html();
    $fragments['.cart-icon-wrapper'] = ob_get_clean();
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'customisiones_cart_fragment' );

function customisiones_cart_icon_html() {
    $count = class_exists('WooCommerce') ? WC()->cart->get_cart_contents_count() : 0;
    $cart_url = class_exists('WooCommerce') ? wc_get_cart_url() : '#';
    ?>
    <a href="<?php echo esc_url( $cart_url ); ?>" class="cart-icon-wrapper relative p-2 text-custom-primary dark:text-custom-darktext hover:text-custom-accent transition-colors" aria-label="Ver carrito">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <?php if ( $count > 0 ) : ?>
        <span class="absolute -top-1 -right-1 bg-custom-accent text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center leading-none">
            <?php echo esc_html( $count ); ?>
        </span>
        <?php endif; ?>
    </a>
    <?php
}

// ─── ADMIN MENU ────────────────────────────────────────────────────────────────
function customisiones_add_admin_menu() {
    add_menu_page(
        'CustoMisiones Ajustes',
        'CustoMisiones',
        'manage_options',
        'customisiones_settings',
        'customisiones_settings_page',
        'dashicons-admin-customizer',
        59
    );
}
add_action( 'admin_menu', 'customisiones_add_admin_menu' );

function customisiones_settings_init() {
    register_setting( 'customisiones_settings_group', 'customisiones_coming_soon' );
}
add_action( 'admin_init', 'customisiones_settings_init' );

// ─── HANDLERS ADMIN ────────────────────────────────────────────────────────────
function customisiones_handle_admin_actions() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    // Generar productos
    if ( isset( $_POST['customisiones_generate_products'] ) && class_exists( 'WooCommerce' ) ) {
        customisiones_generate_dummy_products();
        add_settings_error( 'customisiones_messages', 'products_ok', '✅ Se generaron 20 productos de prueba en WooCommerce.', 'updated' );
    }

    // Setup de páginas y menú
    if ( isset( $_POST['customisiones_setup_pages'] ) ) {
        $result = customisiones_create_pages_and_menu();
        add_settings_error( 'customisiones_messages', 'pages_ok', '✅ ' . $result, 'updated' );
    }
}
add_action( 'admin_init', 'customisiones_handle_admin_actions' );

// ─── SETTINGS PAGE HTML ────────────────────────────────────────────────────────
function customisiones_settings_page() {
    ?>
    <div class="wrap">
        <h1 style="display:flex;align-items:center;gap:10px;">
            <span style="font-size:28px;">🪵</span> Ajustes del Tema CustoMisiones
        </h1>
        <?php settings_errors( 'customisiones_messages' ); ?>

        <div style="display:flex; gap: 24px; flex-wrap:wrap; margin-top:20px;">

            <!-- Configuración básica -->
            <div style="background:#fff;padding:24px;border:1px solid #e0e0e0;max-width:380px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06)">
                <h3 style="margin-top:0">⚙️ Configuración Básica</h3>
                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'customisiones_settings_group' );
                    $coming_soon = get_option( 'customisiones_coming_soon' );
                    ?>
                    <label style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                        <input type="checkbox" name="customisiones_coming_soon" value="1" <?php checked( 1, $coming_soon, true ); ?> />
                        Activar Modo "Coming Soon"
                    </label>
                    <p style="color:#666;font-size:12px;">Los visitantes verán la pantalla en construcción. Los admins logueados ven el sitio completo.</p>
                    <?php submit_button( 'Guardar Cambios' ); ?>
                </form>
            </div>

            <!-- Setup automático de páginas -->
            <div style="background:#fff;padding:24px;border:1px solid #e0e0e0;max-width:380px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06)">
                <h3 style="margin-top:0">📄 Crear Páginas del Sitio</h3>
                <p>Crea automáticamente todas las páginas esenciales del e-commerce y configura el menú de navegación principal.</p>
                <ul style="font-size:13px;color:#555;margin-bottom:16px;line-height:1.8">
                    <li>🏠 Inicio · 🛍 Tienda · 🛒 Carrito · 💳 Finalizar compra · 👤 Mi cuenta</li>
                    <li>🪵 Nosotros · ⚒️ Cómo lo hacemos · 📬 Contacto · ❓ Preguntas Frecuentes</li>
                    <li>📜 Términos · 🔒 Privacidad · 📦 Envíos y Devoluciones</li>
                </ul>
                <form method="post" action="">
                    <input type="hidden" name="customisiones_setup_pages" value="1">
                    <?php submit_button( '🚀 Crear Páginas y Menú', 'primary' ); ?>
                </form>
            </div>

            <!-- Herramientas de desarrollo -->
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
            <div style="background:#fff;padding:24px;border:1px solid #e0e0e0;max-width:380px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06)">
                <h3 style="margin-top:0">🛠️ Herramientas de Desarrollo</h3>
                <p>Genera 20 productos de madera de prueba para ver la tienda en funcionamiento desde el primer momento.</p>
                <form method="post" action="">
                    <input type="hidden" name="customisiones_generate_products" value="1">
                    <?php submit_button( 'Generar 20 Productos de Prueba', 'secondary' ); ?>
                </form>
            </div>
            <?php else : ?>
            <div style="background:#fff3f3;padding:24px;border:1px solid #ffcccc;max-width:380px;border-radius:12px;">
                <h3 style="margin-top:0">🛠️ Herramientas de Desarrollo</h3>
                <p style="color:red;">⚠️ Instalá y activá <strong>WooCommerce</strong> para usar estas herramientas.</p>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <?php
}

// ─── CREAR PÁGINAS Y MENÚ ──────────────────────────────────────────────────────
function customisiones_create_pages_and_menu() {
    $pages_created = 0;
    $pages_existed = 0;

    // Definición de todas las páginas a crear
    $pages = array(
        // Páginas de marca
        array( 'title' => 'Nosotros',              'slug' => 'nosotros',              'content' => '<!-- Página Nosotros -->' ),
        array( 'title' => 'Cómo lo hacemos',       'slug' => 'proceso',               'content' => '<!-- Página Proceso -->' ),
        array( 'title' => 'Contacto',              'slug' => 'contacto',              'content' => '<!-- Página Contacto -->' ),
        array( 'title' => 'Preguntas Frecuentes',  'slug' => 'preguntas-frecuentes',  'content' => '<!-- Página FAQ -->' ),
        // Páginas legales
        array( 'title' => 'Términos y Condiciones',          'slug' => 'terminos',               'content' => '<!-- Términos -->' ),
        array( 'title' => 'Política de Privacidad',          'slug' => 'privacidad',             'content' => '<!-- Privacidad -->' ),
        array( 'title' => 'Envíos y Devoluciones',           'slug' => 'envios-y-devoluciones',  'content' => '<!-- Envíos -->' ),
    );

    // Páginas de WooCommerce
    $woo_pages = array(
        array( 'title' => 'Tienda',               'slug' => 'tienda',               'option' => 'woocommerce_shop_page_id' ),
        array( 'title' => 'Carrito',              'slug' => 'carrito',              'option' => 'woocommerce_cart_page_id' ),
        array( 'title' => 'Finalizar compra',     'slug' => 'finalizar-compra',     'option' => 'woocommerce_checkout_page_id' ),
        array( 'title' => 'Mi cuenta',            'slug' => 'mi-cuenta',            'option' => 'woocommerce_myaccount_page_id' ),
    );

    $created_page_ids = array();

    // Crear páginas de marca
    foreach ( $pages as $page ) {
        $existing = get_page_by_path( $page['slug'] );
        if ( $existing ) {
            $created_page_ids[ $page['slug'] ] = $existing->ID;
            $pages_existed++;
        } else {
            $id = wp_insert_post( array(
                'post_title'   => $page['title'],
                'post_name'    => $page['slug'],
                'post_content' => $page['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ) );
            $created_page_ids[ $page['slug'] ] = $id;
            $pages_created++;
        }
    }

    // Crear páginas de WooCommerce y asignarlas
    foreach ( $woo_pages as $page ) {
        $existing_id = get_option( $page['option'] );
        if ( $existing_id && get_post( $existing_id ) ) {
            $created_page_ids[ $page['slug'] ] = $existing_id;
            $pages_existed++;
        } else {
            $existing = get_page_by_path( $page['slug'] );
            if ( $existing ) {
                $id = $existing->ID;
                $pages_existed++;
            } else {
                $id = wp_insert_post( array(
                    'post_title'   => $page['title'],
                    'post_name'    => $page['slug'],
                    'post_content' => '',
                    'post_status'  => 'publish',
                    'post_type'    => 'page',
                ) );
                $pages_created++;
            }
            update_option( $page['option'], $id );
            $created_page_ids[ $page['slug'] ] = $id;
        }
    }

    // Crear/actualizar el menú principal
    $menu_name = 'Menú Principal';
    $menu_id   = null;
    $menus     = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
    foreach ( $menus as $menu ) {
        if ( $menu->name === $menu_name ) {
            $menu_id = $menu->term_id;
            break;
        }
    }
    if ( ! $menu_id ) {
        $menu_id = wp_create_nav_menu( $menu_name );
    }

    // Limpiar items del menú existentes antes de re-crear
    $existing_items = wp_get_nav_menu_items( $menu_id );
    if ( $existing_items ) {
        foreach ( $existing_items as $item ) {
            wp_delete_post( $item->ID, true );
        }
    }

    // Items del menú en orden — las categorías las agrega el usuario desde WP Admin
    $menu_items = array(
        array( 'title' => 'Inicio',                  'slug' => home_url('/') ),
        array( 'title' => 'Tienda',                  'slug' => get_permalink( $created_page_ids['tienda'] ?? 0 ) ),
        array( 'title' => 'Nosotros',                'slug' => get_permalink( $created_page_ids['nosotros'] ?? 0 ) ),
        array( 'title' => 'Cómo lo hacemos',         'slug' => get_permalink( $created_page_ids['proceso'] ?? 0 ) ),
        array( 'title' => 'Contacto',                'slug' => get_permalink( $created_page_ids['contacto'] ?? 0 ) ),
    );

    foreach ( $menu_items as $order => $item ) {
        if ( ! $item['slug'] ) continue;
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'   => $item['title'],
            'menu-item-url'     => $item['slug'],
            'menu-item-status'  => 'publish',
            'menu-item-type'    => 'custom',
            'menu-item-position' => $order + 1,
        ) );
    }

    // Asignar el menú a la ubicación primary
    $locations = get_theme_mod( 'nav_menu_locations', array() );
    $locations['primary'] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );

    return "Páginas creadas: {$pages_created} nuevas, {$pages_existed} ya existían. Menú principal configurado con Inicio, Tienda, Nosotros, Cómo lo hacemos y Contacto.";
}

// ─── AUTO SETUP AL ACTIVAR EL TEMA ─────────────────────────────────────────────
function customisiones_on_theme_activation() {
    customisiones_create_pages_and_menu();
}
add_action( 'after_switch_theme', 'customisiones_on_theme_activation' );

// ─── GENERAR PRODUCTOS DE PRUEBA ────────────────────────────────────────────────
function customisiones_generate_dummy_products() {
    $wood_products = array(
        'Silla Infantil de Madera', 'Mesa Rústica de Roble', 'Juguete Apilable de Pino', 'Cuna de Madera Natural', 'Sillón de Jardín (Madera)',
        'Caja Organizadora de Madera', 'Perchero de Pie Custom', 'Espejo con Marco de Bambú', 'Bandeja de Desayuno', 'Reloj de Pared de Castaño',
        'Set de Bloques de Construcción', 'Caballete de Pintura Kids', 'Repisa Flotante Minimalista', 'Soporte para Notebook', 'Lampara de Mesa Base Madera',
        'Juego de Ajedrez Artesanal', 'Posavasos Madera Grabada', 'Caballo Mecedor Infantil', 'Bodega de Vinos Rústica', 'Cartel Personalizado Deco'
    );
    foreach ( $wood_products as $title ) {
        $product = new WC_Product_Simple();
        $product->set_name( $title );
        $product->set_status( 'publish' );
        $product->set_catalog_visibility( 'visible' );
        $product->set_description( 'Un producto único, artesanal y pensado para darle calidez a tu hogar o hacer volar la imaginación de los más chicos. Hecho 100% de maderas seleccionadas de CustoMisiones.' );
        $product->set_short_description( 'Calidad premium y hecho a mano.' );
        $product->set_regular_price( rand( 15000, 60000 ) );
        $product->save();
    }
}

// ─── COMING SOON ─────────────────────────────────────────────────────────────
function customisiones_coming_soon_redirect() {
    $is_coming_soon = get_option( 'customisiones_coming_soon' );
    if ( ! $is_coming_soon ) return;
    if ( is_user_logged_in() || is_admin() || in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) return;
    status_header( 503 );
    $file = get_template_directory() . '/coming-soon.php';
    if ( file_exists( $file ) ) {
        include $file;
        exit;
    }
}
add_action( 'template_redirect', 'customisiones_coming_soon_redirect' );

// ─── TRADUCCIÓN FORZADA BLOQUES WOOCOMMERCE (JS) ───────────────────────────────
// Los bloques de Gutenberg de WooCommerce (carrito/checkout) usan React y
// no respetan el gettext de PHP. Este fix los traduce directamente en el DOM.
add_action( 'wp_footer', function() {
    if ( ! class_exists( 'WooCommerce' ) ) return;
    ?>
    <script>
    (function() {
        var translations = {
            'Add coupons':    'Agregar cupones',
            'Estimated total': 'Total estimado',
            'Subtotal':        'Subtotal',
            'Shipping':        'Envío',
            'Tax':             'Impuestos',
            'Total':           'Total',
            'Remove item':     'Eliminar artículo',
            'Coupon code':     'Código de cupón',
            'Apply coupon':    'Aplicar cupón',
            'Place order':     'Realizar pedido',
            'Proceed to checkout': 'Finalizar compra',
        };

        function translateNode(node) {
            if (node.nodeType === Node.TEXT_NODE) {
                var txt = node.textContent.trim();
                if (translations[txt]) {
                    node.textContent = node.textContent.replace(txt, translations[txt]);
                }
            }
        }

        function translateAll() {
            // Selectores específicos de WooCommerce blocks
            var selectors = [
                '.wc-block-components-panel__button',
                '.wc-block-components-totals-item__label',
                '.wc-block-components-totals-footer-item .wc-block-components-totals-item__label',
                '.wc-block-cart__submit-button',
                '.wc-block-components-checkout-place-order-button',
                '.wp-block-woocommerce-proceed-to-checkout-block a',
            ];
            selectors.forEach(function(sel) {
                document.querySelectorAll(sel).forEach(function(el) {
                    el.childNodes.forEach(translateNode);
                    if (translations[el.textContent.trim()]) {
                        el.textContent = translations[el.textContent.trim()];
                    }
                });
            });
        }

        // Ejecutar al cargar y observar cambios del DOM (bloques React se renderizan después)
        document.addEventListener('DOMContentLoaded', function() {
            translateAll();
            var observer = new MutationObserver(translateAll);
            observer.observe(document.body, { childList: true, subtree: true, characterData: false });
        });
    })();
    </script>
    <?php
} );
