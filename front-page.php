<?php
/**
 * Template Name: Front Page
 */
get_header(); 
?>

<main class="flex-grow">
    <!-- Hero Section -->
    <section class="relative w-full bg-custom-bg dark:bg-custom-darkbg py-20 lg:py-32 flex items-center overflow-hidden transition-colors duration-500">
        <div class="container mx-auto px-6 reveal relative z-10 grid lg:grid-cols-2 gap-12 items-center">
            <div class="max-w-2xl">
                <h1 class="font-title text-5xl md:text-6xl text-custom-text dark:text-custom-darktext leading-tight mb-6">
                    Diseño en madera personalizado
                </h1>
                <p class="font-sans text-lg md:text-xl text-custom-subtext dark:text-custom-darktext/80 mb-8 font-light leading-relaxed">
                    Creamos piezas únicas para tu hogar y los más chicos. Cada nudo, cada veta, cuenta la historia de un mobiliario hecho especialmente para vos.
                </p>
                <a href="#productos" class="inline-flex items-center gap-2 bg-custom-primary text-custom-white px-8 py-4 rounded-full font-medium shadow-md shadow-custom-primary/30 hover:bg-custom-primary/90 hover:-translate-y-1 transition-all duration-300">
                    Ver Productos
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <!-- IMAGEN HERO -->
             <div class="relative h-96 w-full rounded-[2rem] bg-custom-accent/10 dark:bg-custom-darkcards overflow-hidden flex items-center justify-center border-4 border-custom-white dark:border-custom-darkcards shadow-2xl">
                 <img src="<?php echo get_template_directory_uri(); ?>/assets/hero-placeholder.jpg" alt="Deco Madera" class="absolute inset-0 w-full h-full object-cover opacity-80 mix-blend-multiply dark:mix-blend-normal" onerror="this.style.display='none'" />
                 <div class="absolute inset-0 bg-gradient-to-tr from-custom-primary/40 to-transparent"></div>
             </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-24 bg-custom-white dark:bg-custom-darkcards transition-colors duration-500">
        <div class="container mx-auto px-6 reveal">
            <h2 class="font-title text-4xl text-center text-custom-text dark:text-custom-darktext mb-14">Descubrí nuestras Categorías</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <?php 
                $categorias = [
                    ['title' => 'Infantil', 'desc' => 'Para jugar y soñar. Juguetes Waldorf, mobiliario Montessori y accesorios de pura madera.'],
                    ['title' => 'Deco Hogar', 'desc' => 'Calidez en cada rincón. Mesas, sillas, repisas y adornos hechos a mano para tu casa.'],
                    ['title' => 'Personalizados', 'desc' => 'Hecho a tu medida. Traenos tu idea, y la tallamos a la perfección para vos.']
                ];
                foreach ($categorias as $cat): ?>
                <div class="group relative overflow-hidden rounded-3xl bg-custom-bg dark:bg-custom-darkbg p-10 text-center cursor-pointer shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-transparent hover:border-custom-accent/30 flex flex-col items-center justify-center h-72">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-10 bg-gradient-to-br from-custom-primary to-custom-accent transition-opacity duration-300"></div>
                    <div class="w-16 h-16 rounded-full bg-custom-white dark:bg-custom-darkcards flex items-center justify-center mb-6 shadow-sm text-2xl text-custom-primary">🪵</div>
                    <h3 class="font-title text-2xl text-custom-text dark:text-custom-darktext mb-3 relative z-10"><?php echo $cat['title']; ?></h3>
                    <p class="text-custom-subtext dark:text-custom-darktext/70 relative z-10 text-sm leading-relaxed"><?php echo $cat['desc']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Products (WooCommerce) -->
    <section id="productos" class="py-24 bg-custom-bg dark:bg-custom-darkbg transition-colors duration-500 relative">
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-custom-primary/20 to-transparent"></div>
        <div class="container mx-auto px-6 reveal">
            <h2 class="font-title text-4xl text-center text-custom-text dark:text-custom-darktext mb-4">Productos Destacados</h2>
            <p class="text-center text-custom-subtext dark:text-custom-darktext/70 mb-16 max-w-2xl mx-auto">Nuestra selección de piezas en madera favoritas por nuestros clientes.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php 
                if ( class_exists( 'WooCommerce' ) ) {
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 8,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );
                    $loop = new WP_Query( $args );
                    if ( $loop->have_posts() ) {
                        while ( $loop->have_posts() ) : $loop->the_post();
                            global $product;
                            ?>
                            <div class="bg-custom-white dark:bg-custom-darkcards rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 flex flex-col group hover:-translate-y-1">
                                <div class="relative pt-[100%] overflow-hidden bg-custom-bg dark:bg-[#222]">
                                    <?php if ( has_post_thumbnail() ) {
                                        echo get_the_post_thumbnail( $loop->post->ID, 'woocommerce_thumbnail', array( 'class' => 'absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700' ) );
                                    } else {
                                        echo '<div class="absolute inset-0 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-custom-subtext/20 dark:text-custom-darktext/10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                              </div>';
                                    }
                                    ?>
                                </div>
                                <div class="p-6 flex-grow flex flex-col">
                                    <h3 class="font-sans font-semibold text-lg text-custom-text dark:text-custom-darktext mb-2 line-clamp-2"><?php the_title(); ?></h3>
                                    <div class="text-custom-primary dark:text-custom-accent font-title font-bold text-xl mb-6 mt-auto">
                                        <?php echo $product->get_price_html(); ?>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="block w-full py-3 px-4 text-center text-sm font-medium border-2 border-custom-primary text-custom-primary dark:border-custom-accent dark:text-custom-accent rounded-full hover:bg-custom-primary hover:text-custom-white dark:hover:bg-custom-accent dark:hover:text-custom-darkbg transition-colors duration-300">
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                            <?php
                        endwhile;
                    } else {
                        echo '<p class="col-span-12 text-center py-20 text-custom-subtext dark:text-custom-darktext/70 bg-custom-white dark:bg-custom-darkcards rounded-2xl">Aún no hay productos disponibles. Usa la herramienta del Panel CustoMisiones para auto-generar algunos productos de prueba.</p>';
                    }
                    wp_reset_postdata();
                } else {
                    echo '<p class="col-span-12 text-center py-20 text-red-500 bg-red-50 dark:bg-red-900/10 rounded-2xl">WooCommerce no está activo.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Differentials -->
    <section class="py-24 bg-custom-primary text-custom-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, #000 0, #000 2px, transparent 2px, transparent 8px);"></div>
        
        <div class="container mx-auto px-6 reveal relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-16 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 bg-custom-white/10 rounded-full flex items-center justify-center text-4xl mb-6 backdrop-blur-sm border border-custom-white/20 shadow-lg">⚒️</div>
                    <h3 class="font-title text-2xl mb-3">100% Hecho a Mano</h3>
                    <p class="font-light text-custom-white/80 leading-relaxed max-w-xs">Procesos artesanales y dedicación en cada pequeño detalle de nuestra madera.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 bg-custom-white/10 rounded-full flex items-center justify-center text-4xl mb-6 backdrop-blur-sm border border-custom-white/20 shadow-lg">✏️</div>
                    <h3 class="font-title text-2xl mb-3">Totalmente Personalizado</h3>
                    <p class="font-light text-custom-white/80 leading-relaxed max-w-xs">Adaptamos las medidas, colores y terminaciones a tu propio espacio.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 bg-custom-white/10 rounded-full flex items-center justify-center text-4xl mb-6 backdrop-blur-sm border border-custom-white/20 shadow-lg">📦</div>
                    <h3 class="font-title text-2xl mb-3">Envíos a todo el país</h3>
                    <p class="font-light text-custom-white/80 leading-relaxed max-w-xs">Llevamos nuestros diseños bien embalados a donde sea que estés.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Galeria & CTA -->
    <section class="py-32 bg-custom-bg dark:bg-custom-darkcards text-center transition-colors duration-500">
        <div class="container mx-auto px-6 reveal">
            <div class="max-w-2xl mx-auto">
                <div class="text-custom-accent mb-4">
                    <svg viewBox="0 0 24 24" class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A11.954 11.954 0 0112 15.5c-2.998 0-5.74-1.1-7.843-2.918m0 0A8.96 8.96 0 013 12c0-.778.099-1.533.284-2.253" />
                    </svg>
                </div>
                <h2 class="font-title text-5xl text-custom-text dark:text-custom-darktext mb-6">Pedí tu diseño personalizado</h2>
                <p class="text-custom-subtext dark:text-custom-darktext/70 mb-10 text-lg leading-relaxed">Creamos piezas únicas en madera para hacer tu hogar más cálido e irrepetible. Escribinos para contarnos tu idea, nosotros la hacemos realidad.</p>
                <a href="https://wa.me/1234567890" target="_blank" class="inline-flex items-center gap-3 bg-[#25D366] text-white px-10 py-5 rounded-full font-medium shadow-xl hover:bg-[#1ebe57] hover:scale-105 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                    </svg>
                    Contactar por WhatsApp
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
