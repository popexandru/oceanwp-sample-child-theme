<?php

    add_action( 'ocean_before_single_product_quantity-button', function(){

        $table_sizes        = get_option( 's360-table-sizes' );

        if( empty($table_sizes) || !is_array($table_sizes) )
            return;

        $cat_ids            = [];
        $table_sizes_       = [];
        $product_cat_ids    = [];

        foreach( $table_sizes as $table_size ){
            $cat_id = $table_size['category'];
            $table_sizes_[$cat_id] = $table_size;

            if( !in_array($cat_id, $cat_ids) )
                $cat_ids[] = $cat_id;
        }

        if( is_singular( 'product' ) ){

            global $product;

	        $terms = get_the_terms( $product -> get_id(), 'product_cat' );
	        $exists_table_sizes = false;

	        foreach( $terms as $t ){
	            $product_cat_ids[] = $t -> term_id;

	            if( in_array( $t -> term_id, $cat_ids) )
	                $exists_table_sizes = true;
	        }

	        if( !$exists_table_sizes )
	            return;

            echo '<div class="s360-sizes-wrapper s360-light-box-wrapper">';
            echo '<div class="s360-light-box-inner">';
            echo '<div class="flex-container valign-middle">';
            echo '<div class="s360-shadow"></div>';
            echo '<a href="javascript:void(null);" class="s360-close">×</a>';
            echo '<div class="flex-item">';
            echo '<div class="s360-sizes-content item-content">';

            $s360_display_mode = get_option( 's360-table-sizes-display-mode' );

            if( $s360_display_mode === 'all-table-sizes' ){

                $tab_nav = '';
                $tab_content = '';

                foreach( $table_sizes_ as $cat_id => $table_size ){

                    $classes = '';

                    if( in_array( $cat_id, $product_cat_ids) )
                        $classes = 'current';

                    $tab_nav .= '<li class="' . esc_attr($classes) . '">';
                    $tab_nav .= '<a href="javascript:void(null);">';

                    if( !empty($table_size['icon']) )
                        $tab_nav .= '<img src="' . esc_url($table_size['icon']) . '"  alt="' . esc_attr($table_size['title']) . '">';

                    $tab_nav .= '<span>' . esc_html($table_size['title']) . '</span>';

                    $tab_nav .= '</a>';
                    $tab_nav .= '</li>';

                    $tab_content .= '<div class="s360-tab ' . esc_attr($classes) . '">';

                    if( !empty($table_size['image']) ){
                        $tab_content .= '<img src="' . esc_url($table_size['image']) . '"  alt="' . esc_attr($table_size['title']) . '">';
                    }

                    if( !empty($table_size['content']) ){
                        $tab_content .= apply_filters( 'the_content', $table_size['content'] );
                    }

                    $tab_content .= '</div>';
                }

                echo '<div class="s360-tabs-wrapper">';

                echo '<nav class="s360-tab-nav">';
                echo '<ul>';
                echo $tab_nav;
                echo '</ul>';
                echo '</nav>';

                echo '<div class="s360-tabs">';
                echo do_shortcode($tab_content);
                echo '</div>';

                echo '</div>';
            }

            else{
                foreach( $terms as $t ){
                    if( isset($table_sizes_[$t -> term_id]) ){

                        $table_size = $table_sizes_[$t -> term_id];

                        if( !empty($table_size['image']) ){
                            echo '<img src="' . esc_url($table_size['image']) . '" alt="' . esc_attr($table_size['title']) . '">';
                        }

                        if( !empty($table_size['content']) ){
                            echo apply_filters( 'the_content', $table_size['content'] );
                        }
                    }
                }
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    });
?>
