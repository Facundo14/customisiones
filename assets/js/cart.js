// Actualizar el contador del carrito cuando se agrega un producto
jQuery(function($) {
    $(document.body).on('added_to_cart', function() {
        // WooCommerce ya maneja los fragmentos via woocommerce_add_to_cart_fragments
        // Este script es por si se necesita lógica extra
    });
});
