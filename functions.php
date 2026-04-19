<?php
/**
 * CustoMisiones Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Soporte para WooCommerce y Menús
function customisiones_setup_theme() {
    add_theme_support( 'woocommerce' );
    register_nav_menus( array(
        'primary' => __( 'Menú Principal', 'customisiones' ),
    ) );
}
add_action( 'after_setup_theme', 'customisiones_setup_theme' );

// 1. Encolar los estilos compilados por Tailwind
function customisiones_enqueue_scripts() {
    wp_enqueue_style( 'customisiones-style', get_template_directory_uri() . '/style.css', array(), '1.0.0' );
    
    // Si Tailwind Output existe, encolarlo. (evita el error si aún no corrió build)
    $output_css = get_template_directory() . '/assets/css/output.css';
    if( file_exists($output_css) ) {
        wp_enqueue_style( 'customisiones-tailwind', get_template_directory_uri() . '/assets/css/output.css', array(), filemtime($output_css) );
    }
}
add_action( 'wp_enqueue_scripts', 'customisiones_enqueue_scripts' );

// 2. Crear menú de opciones para el Theme en el Panel de Administración
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

// Registrar el campo/ajuste en la BD
function customisiones_settings_init() {
    register_setting( 'customisiones_settings_group', 'customisiones_coming_soon' );
}
add_action( 'admin_init', 'customisiones_settings_init' );

// Manejador del botón oculto para generar productos
function customisiones_handle_generate_products() {
    if ( isset($_POST['customisiones_generate_products']) && current_user_can('manage_options') && class_exists('WooCommerce') ) {
        customisiones_generate_dummy_products();
        add_settings_error('customisiones_messages', 'customisiones_message', 'Se generaron 20 productos de prueba en WooCommerce.', 'updated');
    }
}
add_action('admin_init', 'customisiones_handle_generate_products');

// HTML de la página de opciones
function customisiones_settings_page() {
    ?>
    <div class="wrap">
        <h1>Ajustes del Tema CustoMisiones</h1>
        <?php settings_errors('customisiones_messages'); ?>

        <div style="display:flex; gap: 30px; flex-wrap:wrap;">
            
            <div style="background: #fff; padding: 20px; border: 1px solid #ccc; max-width: 400px; border-radius: 8px;">
                <h3>⚙️ Configuración Básica</h3>
                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'customisiones_settings_group' );
                    do_settings_sections( 'customisiones_settings_group' );
                    $coming_soon = get_option( 'customisiones_coming_soon' );
                    ?>
                    <table class="form-table" style="margin-bottom:20px;">
                        <tr valign="top">
                            <th scope="row" style="width:100%; display:block; padding-bottom:10px;">Activar Modo "Coming Soon"</th>
                            <td>
                                <input type="checkbox" name="customisiones_coming_soon" value="1" <?php checked( 1, $coming_soon, true ); ?> />
                                <br/>
                                <span class="description">Si está activado, los visitantes verán una pantalla de "En construcción".</span>
                            </td>
                        </tr>
                    </table>
                    <?php submit_button('Guardar Cambios'); ?>
                </form>
            </div>

            <?php if ( class_exists('WooCommerce') ) : ?>
            <div style="background: #fff; padding: 20px; border: 1px solid #ccc; max-width: 400px; border-radius: 8px;">
                <h3>🪵 Herramientas de Desarrollo</h3>
                <p>Genera 20 productos genéricos de madera en WooCommerce para poder visualizar la tienda de ejemplo rápidamente.</p>
                <form method="post" action="">
                    <input type="hidden" name="customisiones_generate_products" value="1">
                    <?php submit_button('Generar 20 Productos de Prueba', 'secondary'); ?>
                </form>
            </div>
            <?php else: ?>
                <div style="background: #fff; padding: 20px; border: 1px solid #ccc; max-width: 400px; border-radius: 8px;">
                    <h3>🪵 Herramientas de Desarrollo</h3>
                    <p style="color:red;">⚠️ Debes instalar y activar el plugin de <strong>WooCommerce</strong> para poder generar productos de prueba.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <?php
}

// Función para generar productos automáticos de Madera
function customisiones_generate_dummy_products() {
    $wood_products = array(
        'Silla Infantil de Madera', 'Mesa Rústica de Roble', 'Juguete Apilable de Pino', 'Cuna de Madera Natural', 'Sillón de Jardín (Madera)',
        'Caja Organizadora de Madera', 'Perchero de Pie Custom', 'Espejo con Marco de Bambú', 'Bandeja de Desayuno', 'Reloj de Pared de Castaño',
        'Set de Bloques de Construcción', 'Caballete de Pintura Kids', 'Repisa Flotante Minimalista', 'Soporte para Notebook', 'Lampara de Mesa Base Madera',
        'Juego de Ajedrez Artesanal', 'Posavasos Madera Grabada', 'Caballo Mecedor Infantil', 'Bodega de Vinos Rústica', 'Cartel Personalizado Deco'
    );

    foreach ( $wood_products as $idx => $title ) {
        $product = new WC_Product_Simple();
        
        $product->set_name( $title );
        $product->set_status( 'publish' );
        $product->set_catalog_visibility( 'visible' );
        $product->set_description( 'Un producto único, artesanal y pensado para darle calidez a tu hogar o hacer volar la imaginación de los más chicos. Hecho 100% de maderas seleccionadas de CustoMisiones.' );
        $product->set_short_description( 'Calidad premium y hecho a mano.' );
        $product->set_regular_price( rand(15000, 60000) ); // Precio entre 15k y 60k
        
        // Asignar imagen destacada placehold de madera (via URL externa)
        // No bajaremos la imagen, solo un placehold u otra forma. Como WooCommerce necesita un attachment ID, no podemos poner una URL externa asi nomas.
        // Lo dejamos sin imagen o si la necesita, WP/WC le pondrá su placeholder por defecto.
        $product->save();
    }
}

// 3. Lógica para interceptar la carga y mostrar la pantalla Coming Soon
function customisiones_coming_soon_redirect() {
    $is_coming_soon = get_option( 'customisiones_coming_soon' );
    
    if ( ! $is_coming_soon ) {
        return;
    }

    if ( is_user_logged_in() || is_admin() || in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
        return;
    }

    status_header(503);
    
    $file = get_template_directory() . '/coming-soon.php';
    if ( file_exists( $file ) ) {
        include $file;
        exit;
    }
}
add_action( 'template_redirect', 'customisiones_coming_soon_redirect' );

// Crear imagen placeholder al vuelo no es viable, usaremos WC placeholder por defecto.
