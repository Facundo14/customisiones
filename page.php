<?php
/**
 * Template para páginas estáticas de WordPress (Carrito, Checkout, Mi Cuenta, etc.)
 */
get_header();
?>

<main class="flex-grow bg-custom-bg dark:bg-custom-darkbg transition-colors duration-500 py-12 lg:py-20">
    <div class="container mx-auto px-4 md:px-6 reveal">

        <div class="bg-custom-white dark:bg-custom-darkcards rounded-3xl shadow-xl overflow-hidden p-6 md:p-12 lg:p-16 border border-custom-primary/5 dark:border-custom-accent/10">
            
            <?php while ( have_posts() ) : the_post(); ?>
            
                <div class="woocommerce-custom-wrapper text-custom-text dark:text-custom-darktext font-sans">
                    <?php the_content(); ?>
                </div>

            <?php endwhile; ?>

        </div>

    </div>
</main>

<style>
/* Heredar estilos de WooCommerce para las páginas con shortcodes */
.woocommerce-custom-wrapper h1,
.woocommerce-custom-wrapper h2,
.woocommerce-custom-wrapper h3 {
    font-family: "Playfair Display", serif;
    color: inherit;
}
.woocommerce-custom-wrapper a {
    color: #7A4F3A;
    transition: color 0.3s;
}
.woocommerce-custom-wrapper a:hover {
    color: #D4A65A;
}
html.dark .woocommerce-custom-wrapper a {
    color: #D4A65A;
}
html.dark .woocommerce-custom-wrapper a:hover {
    color: #F5F2EC;
}

/* Botones */
.woocommerce-custom-wrapper .button,
.woocommerce-custom-wrapper button[type="submit"],
.woocommerce-custom-wrapper input[type="submit"] {
    background-color: #7A4F3A !important;
    color: #FFFFFF !important;
    border-radius: 9999px !important;
    padding: 0.75rem 2rem !important;
    font-weight: 500 !important;
    border: none !important;
    cursor: pointer !important;
    transition: all 0.3s !important;
}
.woocommerce-custom-wrapper .button:hover,
.woocommerce-custom-wrapper button[type="submit"]:hover,
.woocommerce-custom-wrapper input[type="submit"]:hover {
    background-color: #D4A65A !important;
    transform: translateY(-2px);
}

/* Precios */
.woocommerce-custom-wrapper span.price,
.woocommerce-custom-wrapper .order-total .amount,
.woocommerce-custom-wrapper .cart-subtotal .amount {
    color: #D4A65A !important;
    font-weight: bold;
}

/* Tabla del carrito */
html.dark .woocommerce-custom-wrapper table.shop_table,
html.dark .woocommerce-custom-wrapper table.shop_table th,
html.dark .woocommerce-custom-wrapper table.shop_table td {
    border-color: rgba(212, 166, 90, 0.2) !important;
    color: #F5F2EC !important;
    background-color: transparent !important;
}
html.dark .woocommerce-custom-wrapper table.shop_table thead th {
    background-color: rgba(212, 166, 90, 0.08) !important;
}

/* Input de cantidad */
.woocommerce-custom-wrapper .quantity input[type="number"],
.woocommerce-custom-wrapper input.qty {
    background-color: #FFFFFF;
    color: #2B2B2B;
    border: 1px solid #d1c5b8;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    font-size: 1rem;
    width: 70px;
    text-align: center;
    transition: border-color 0.3s, background-color 0.3s, color 0.3s;
}
html.dark .woocommerce-custom-wrapper .quantity input[type="number"],
html.dark .woocommerce-custom-wrapper input.qty {
    background-color: #1E1E1E !important;
    color: #F5F2EC !important;
    border: 1px solid #D4A65A !important;
}

/* Inputs del checkout */
html.dark .woocommerce-custom-wrapper input[type="text"],
html.dark .woocommerce-custom-wrapper input[type="email"],
html.dark .woocommerce-custom-wrapper input[type="tel"],
html.dark .woocommerce-custom-wrapper input[type="password"],
html.dark .woocommerce-custom-wrapper textarea,
html.dark .woocommerce-custom-wrapper select {
    background-color: #1E1E1E !important;
    color: #F5F2EC !important;
    border: 1px solid rgba(212, 166, 90, 0.4) !important;
    border-radius: 8px !important;
}
html.dark .woocommerce-custom-wrapper input:focus,
html.dark .woocommerce-custom-wrapper textarea:focus,
html.dark .woocommerce-custom-wrapper select:focus {
    border-color: #D4A65A !important;
    outline: none !important;
    box-shadow: 0 0 0 2px rgba(212, 166, 90, 0.2) !important;
}

/* Labels en dark */
html.dark .woocommerce-custom-wrapper label {
    color: #F5F2EC !important;
}

/* Notices / mensajes */
html.dark .woocommerce-custom-wrapper .woocommerce-message,
html.dark .woocommerce-custom-wrapper .woocommerce-info {
    background: rgba(212, 166, 90, 0.1);
    border-left-color: #D4A65A;
    color: #F5F2EC;
}
</style>

<?php get_footer(); ?>
