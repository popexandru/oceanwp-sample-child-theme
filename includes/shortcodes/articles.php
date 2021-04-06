<?php

    global $s360_shortcode_articles_index;

    $s360_shortcode_articles_index = 0;

    /*add_action( 'after_setup_theme', function(){

        add_image_size( 's360-580x435', 580, 435, true );
        add_image_size( 's360-690x520', 690, 520, true );
    });*/

    add_shortcode('s360_articles', function( $_attr, $_content ){

        global $s360_shortcode_articles_index;

        $s360_shortcode_articles_index++;

        $attr = shortcode_atts([
            'id'                    => null,
            'style'                 => null,

            'sl_arrows'             => 1,
            'sl_dots'               => 1,

            'view'                  => 'grid',

            'columns'				=> 4,
            'lg-columns'			=> 3,   // 1199
            'md-columns'            => 2,   // 991
            'sm-columns'            => 2,   // 767
            'xs-columns'            => 1,   // 580

            'posts_per_page' 		=> absint(get_option('posts_per_page')),

            'cat'                   => null,
            'category__in'          => null,
            'category__not_in'      => null,

            'tag'                   => null,
            'tag__in'               => null,
            'tag__not_in'           => null,

            'order'                 => 'DESC',

        ], $_attr);

        $columns    = [ 2, 3, 4, 5 ];
        $order      = [ 'ASC', 'DESC' ];
        $styles     = [ 'slideshow', 'masonry' ];
        $views      = [ 'grid', 'card', 'popup', 'classic', 'list' ];

        $id         = esc_attr($attr['id']);

        if( empty($id) )
            $id = 's360-articles-' . $s360_shortcode_articles_index;

        // Columns
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
            'post_type'             => 'post',
            'posts_per_page'        => absint($attr['posts_per_page']),
            'ignore_sticky_posts' 	=> 1
        ];

        // CATEGORIES
        if( !empty($attr['cat']) && absint($attr['cat']) )
            $args['cat'] = absint($attr['cat']);

        // category_in
        $category__in = $attr['category__in'];

        if( !is_numerc($attr['category__in']) )
            $category__in = s360_unique_ids($attr['category__in']);

        if( !empty($category__in) )
            $args['category__in'] = $category__in;

        // category_not_in
        $category__not_in = $attr['category__not_in'];

        if( !is_numerc($attr['category__not_in']) )
            $category__not_in = s360_unique_ids($attr['category__not_in']);

        if( !empty($category__not_in) )
            $args['category__not_in'] = $category__not_in;

        // TAGS
        if( !empty($attr['tag']) & absint($attr['tag']) )
            $args['tag'] = absint($attr['tag']);

        // tag__in
        $tag__in = $attr['tag__in'];

        if( !is_numerc($attr['tag__in']) )
            $tag__in = s360_unique_ids($attr['tag__in']);

        if( !empty($tag__in) )
            $args['tag__in'] = $tag__in;

        // tag__not_in
        $tag__not_in = $attr['tag__not_in'];

        if( !is_numerc($attr['tag__not_in']) )
            $tag__not_in = s360_unique_ids($attr['tag__not_in']);

        if( !empty($tag__not_in) )
            $args['tag__not_in'] = $tag__not_in;

        // order
        $args['order'] = $attr['order'];

        if( !in_array( $args['order'], $order ) )
            $args['order'] = 'DESC';

        $ret    = null;
        $query  = new WP_Query($args);

        $ret .= '<div id="' . esc_attr($id) . '" class="s360-articles-wrapper">';

        if($query -> have_posts()){
            $ret .= '<div class="s360-articles cols-' . absint($col) . '">';
            foreach($query -> posts as $p){
                $ret .= '<article class="post">';
                $ret .= '<div class="post-inner">';

                $ret .= '<div class="thumbnail">';
                $ret .= '<a href="' . get_permalink($p) . '" title="' . get_the_title($p) . '">';

                $thumbnail          = get_post( get_post_thumbnail_id( $p ) );
                $has_post_thumbnail = has_post_thumbnail( $p ) && isset( $thumbnail -> ID ) && wp_attachment_is( 'image', $thumbnail );

                if( !$has_post_thumbnail ){
                    $ret .= '<img src="' . get_stylesheet_directory_uri() . '/public/img/no-image-690x520.jpg" title="' . esc_attr(get_the_title($p)) . '">';
                }

                else{
                    // Display post thumbnail
                    $ret .= get_the_post_thumbnail( $p -> ID, 's360-690x520', [
                        'alt' => esc_attr( get_the_title($p) )
                    ]);
                }

                $ret .= '</a>';
                $ret .= '</div>';

                $ret .= '<div class="content">';

                // title
                $ret .= '<h3><a href="' . get_permalink($p) . '" title="' . esc_attr(get_the_title($p)) . '">' . get_the_title($p) . '</a></h3>';

                // meta
                $ret .= '<div class="meta">';
                $name = get_the_author_meta( 'display_name' , $p -> post_author );

                $ret .= '<a class="author" href="' . esc_url( get_author_posts_url( $p -> post_author ) ) . '" title="' . sprintf( esc_attr__( 'Posted by %1$s' , 'S360_THEME_SLUG' ) , esc_attr( $name ) ) . '">';
                $ret .= get_avatar( $p -> post_author, 20, get_stylesheet_directory_uri() . '/public/img/default-avatar-20.jpg' ) . ' ' . esc_html( $name );
                $ret .= '</a>';

                $dtime  = get_post_time( 'Y-m-d', false, $p );
                $ptime  = get_post_time( esc_attr( get_option( 'date_format' ) ), false, $p, true );

                $ret .= '<time datetime="' . esc_attr( $dtime ) . '"><i class="far fa-calendar"></i> ' . esc_html( $ptime ) . '</time>';

                $ret .= '</div>';

                $excerpt = trim($p -> post_excerpt);

                if( !empty( $excerpt ) ){
                    $ret .= '<p>' . mb_substr( strip_shortcodes( strip_tags( $excerpt ) ) ) . ' ... </p>';
                }
                else{
                    $ret .= '<p>' . mb_substr( strip_shortcodes( strip_tags( $p -> post_content ) ), 0, 150 ) . ' ... </p>';
                }

                $ret .= '<div class="read-more">';
                $ret .= '<a href="' . esc_url( get_permalink( $p -> ID ) ) . '" class="more-link" title="' . esc_attr( get_the_title( $p ) ) . '">';
                $ret .= esc_html__( 'Citește în continuare &rsaquo;', 'S360_THEME_SLUG' );
                $ret .= '</a>';
                $ret .= '</div>';

                $ret .= '</div>';

                $ret .= '</div>';
                $ret .= '</article>';
            }
            $ret .= '</div>';
        }
        $ret .= '</div>';


        if(!empty($attr['style']) && $attr['style'] == 'masonry' ){
            ob_start();
            ?>
            <script tyle="text/javascript">
                jQuery(function(){
                    jQuery('div#<?php echo esc_attr($id); ?> .s360-articles').masonry();
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
                    jQuery('div#<?php echo esc_attr($id); ?> .s360-articles').slick({
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
