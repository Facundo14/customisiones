<?php
/**
 * Plantilla principal de integración para WooCommerce.
 * Envuelve el contenido en los estilos de Tailwind.
 */
get_header(); 
?>

<main class="flex-grow bg-custom-bg dark:bg-custom-darkbg transition-colors duration-500 py-12 lg:py-20">
    <div class="container mx-auto px-4 md:px-6 reveal">
        
        <!-- Contenedor premium estilo tarjeta para las páginas de Producto, Carrito, y Tienda -->
        <div class="bg-custom-white dark:bg-custom-darkcards rounded-3xl shadow-xl overflow-hidden p-6 md:p-12 lg:p-16 border border-custom-primary/5 dark:border-custom-accent/10">
            
            <?php 
            // Inyecta el breadcrumb estandar de WooCommerce si lo requiere (opcional, WooCommerce ya lo inyecta a veces en content)
            ?>

            <div class="woocommerce-custom-wrapper text-custom-text dark:text-custom-darktext font-sans">
                <?php woocommerce_content(); ?>
            </div>

        </div>

    </div>
</main>

<style>
/* 
 * Reglas CSS incrustadas rápidas para forzar que WooCommerce 
 * herede tipografía y colores de nuestro Tailwind Theme 
 */
.woocommerce-custom-wrapper h1,
.woocommerce-custom-wrapper h2,
.woocommerce-custom-wrapper h3 {
    font-family: "Playfair Display", serif;
    color: inherit;
}
.woocommerce-custom-wrapper a {
    color: #7A4F3A; /* custom-primary */
    transition: color 0.3s;
}
.woocommerce-custom-wrapper a:hover {
    color: #D4A65A; /* custom-accent */
}
html.dark .woocommerce-custom-wrapper a {
    color: #D4A65A;
}
html.dark .woocommerce-custom-wrapper a:hover {
    color: #F5F2EC;
}
.woocommerce-custom-wrapper .button,
.woocommerce-custom-wrapper button.button {
    background-color: #7A4F3A !important;
    color: #FFFFFF !important;
    border-radius: 9999px !important;
    padding: 0.75rem 2rem !important;
    font-weight: 500 !important;
    transition: all 0.3s !important;
}
.woocommerce-custom-wrapper .button:hover,
.woocommerce-custom-wrapper button.button:hover {
    background-color: #D4A65A !important;
    transform: translateY(-2px);
}
.woocommerce-custom-wrapper span.price {
    color: #D4A65A !important;
    font-weight: bold;
    font-size: 1.25rem;
}
</style>

<?php get_footer(); ?>
