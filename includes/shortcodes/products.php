<?php

    global $s360_shortcode_products_index;

    $s360_shortcode_products_index = 0;

    add_shortcode('s360_products', function( $_attr, $_content ){

        global $s360_shortcode_products_index;


        $s360_shortcode_products_index++;

        $attr = shortcode_atts([
            'id'                    => null,
            'style'                 => null,

            'sl_arrows'             => 1,
            'sl_dots'               => 1,

            'view'                  => 'grid',

            'columns'				=> 4,
            'lg-columns'            => 4,   // 1199
            'md-columns'            => 3,   // 991
            'sm-columns'            => 2,   // 767
            'xs-columns'            => 1,   // 580

            'posts_per_page' 		=> absint(get_option('posts_per_page')),

            'cat'                   => null,
            'category__in'          => null,
            'category__not_in'      => null,

            'order'                 => 'DESC',

        ], $_attr);

        $columns    = [ 2, 3, 4, 5 ];
        $order      = [ 'ASC', 'DESC' ];
        $styles     = [ 'slideshow', 'masonry' ];
        $views      = [ 'grid', 'card', 'popup', 'classic', 'list' ];

        $id         = esc_attr($attr['id']);

        if( empty($id) )
            $id = 's360-products-' . $s360_shortcode_products_index;

        $col = absint($attr['columns']);

        if( !in_array( $col, $columns ) )
            $col = 4;

        $lg_col = absint($attr['lg-columns']);

        if( !in_array( $lg_col, $columns ) )
            $lg_col = 3;

        $md_col = absint($attr['md-columns']);

        if( !in_array( $md_col, $columns ) )
            $md_col = 3;

        $sm_col = absint($attr['sm-columns']);

        if( !in_array( $sm_col, $columns ) )
            $sm_col = 2;

        $xs_col = absint($attr['xs-columns']);

        if( !in_array( $xs_col, $columns ) )
            $xs_col = 1;

        $args = [
            'post_type'             => 'product',
            'posts_per_page'        => absint($attr['posts_per_page']),
			'orderby' 				=> 'menu-order',
			'tax_query' 			=> [
				[
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'exclude-from-catalog',
					'operator' => 'NOT IN',
				]
			]
		];

        // CATEGORIES
        if( !empty($attr['cat']) && absint($attr['cat']) )
            $args['cat'] = absint($attr['cat']);

        $category__in = $attr['category__in'];

		if( !is_numeric($attr['category__in']) )
        	$category__in = s360_unique_ids($attr['category__in']);

        if( !empty($category__in) ){

			if( !isset($args['tax_query']) )
				$args['tax_query'] = [];

			$args['tax_query'][] = [
				'taxonomy'      => 'product_cat',
				'field' 		=> 'term_id',
				'terms'         => $category__in,
				'operator'      => 'IN'
			];
		}

        $category__not_in = $attr['category__not_in'];

		if( !is_numeric($attr['category__not_in']) )
        	$category__not_in = s360_unique_ids($attr['category__not_in']);

        if( !empty($category__not_in) ){
			if( !isset($args['tax_query']) )
				$args['tax_query'] = [];

			$args['tax_query'][] = [
				'taxonomy'      => 'product_cat',
				'field' 		=> 'term_id',
				'terms'         => $category__not_in,
				'operator'      => 'NOT IN'
			];
		}

        $args['order'] = $attr['order'];

        if( !in_array($args['order'], $order) )
            $args['order'] = 'DESC';

        if( absint($attr['best_sale']) ){
			$args['meta_key'] 	= 'total_sales';
			$args['orderby'] 	= 'meta_value_num';
		}

        $ret    = null;
        $query  = new WP_Query($args);

        $ret .= '<div id="' . esc_attr($id) . '" class="s360-products-wrapper">';

        if( $query -> have_posts() ){
            $ret .= '<div class="s360-products cols-' . absint($col) . '">';
            foreach($query -> posts as $p){

                $product = wc_get_product($p -> ID);

                $ret .= '<div class="product">';
                $ret .= '<div class="product-inner">';

                $ret .= '<div class="thumbnail">';

                if ( $product -> is_on_sale() )
                	$ret .= apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'S360_THEME_SLUG' ) . '</span>', $p, $product );

                $ret .= '<a href="' . get_permalink($p) . '" title="' . get_the_title($p) . '">';

                $thumbnail          = get_post( get_post_thumbnail_id($p) );
                $has_post_thumbnail = has_post_thumbnail($p) && isset($thumbnail -> ID) && wp_attachment_is( 'image', $thumbnail );

                if( !$has_post_thumbnail ){
                    $ret .= '<img src="' . get_stylesheet_directory_uri() . '/public/img/no-image-300x300.jpg" title="' . esc_attr( get_the_title($p) ) . '">';
                }

                else{
                    // Display post thumbnail
                    $ret .= get_the_post_thumbnail( $p -> ID, 'woocommerce_thumbnail', [
                        'alt' => esc_attr( get_the_title($p) )
                    ]);
                }

                $ret .= '</a>';
                $ret .= '</div>';

                $ret .= '<div class="content">';

                // title
                $ret .= '<h3><a href="' . get_permalink($p) . '" title="' . esc_attr(get_the_title($p)) . '">' . get_the_title($p) . '</a></h3>';

                // sku
                $ret .= '<span class="sku"><strong>' . esc_html__( 'COD:', 'S360_THEME_SLUG' ) . '</strong> ' . esc_html( $product -> get_sku() ) . '</span>';

                // price
                $ret .= '<span class="price">';
                $ret .= $product -> get_price_html();
                $ret .= '</span>';

                // add to cart button
                $url        = esc_url( $product -> add_to_cart_url() );
                $sku        = esc_attr( $product -> get_sku() );
                $classes    = 's360-btn ' . ($product -> is_purchasable() ? 'add_to_cart_button' : '') . ' product_type_' .  esc_attr( get_the_terms( $p -> ID, 'product_type' )[0] -> slug );
                $text       = esc_html( $product->add_to_cart_text() );

                $ret .= '<a href="' . esc_url($url) . '" rel="nofollow" data-product_id="' . absint($p -> ID) . '" data-product_sku="' . esc_attr($sku) . '" class="' . esc_attr($classes) . '">';
                $ret .= esc_html($text);
                $ret .= '</a>';

                $ret .= '</div>';

                $ret .= '</div>';
                $ret .= '</div>';
            }
            $ret .= '</div>';
        }

        $ret .= '</div>';


        if(!empty($attr['style']) && $attr['style'] == 'masonry' ){
            ob_start();
            ?>
            <script tyle="text/javascript">
                jQuery(function(){
                    jQuery('div#<?php echo esc_attr($id); ?> .s360-products').masonry();
                });
            </script>
            <?php

            $ret .= ob_get_clean();
        }

        if(!empty($attr['style']) && $attr['style'] == 'slideshow' ){
            ob_start();

            ?>
            <script tyle="text/javascript">
                jQuery(function(){
                    jQuery('div#<?php echo esc_attr($id); ?> .s360-products').slick({
                        centerMode: false,
                        focusOnSelect: false,
                        initialSlide: 0,
                        infinite: false,
                        centerPadding: '0px',
                        slidesToShow: <?php echo absint($col); ?>,
                        arrows: <?php echo absint($attr['sl_arrows']) ? 'true' : 'false'; ?>,
                        dots : <?php echo absint($attr['sl_dots']) ? 'true' : 'false'; ?>,
                        prevArrow: '<a href="javascript:void(null);" class="slick-arrow left-arrow">←</a>', // ← ‹ «
                        nextArrow: '<a href="javascript:void(null);" class="slick-arrow right-arrow">→</a>', // → › »
                        adaptiveHeight: true,
                        responsive: [{
                            breakpoint: 1199,
                            settings: {
                                slidesToShow: <?php echo absint($lg_col); ?>,
                            }
                        },{
                            breakpoint: 991,
                            settings: {
                                slidesToShow: <?php echo absint($md_col); ?>,
                            }
                        },{
                            breakpoint: 767,
                            settings: {
                                slidesToShow: <?php echo absint($sm_col); ?>,
                            }
                        },{
                            breakpoint: 580,
                            settings: {
                                slidesToShow: <?php echo absint($xs_col); ?>,
                            }
                        }]
                    });
                });
            </script>
            <?php

            $ret .= ob_get_clean();
        }

        return $ret;
    });
?>
