<?php

    global $s360_shortcode_team_index;

    $s360_shortcode_team_index = 0;

    add_shortcode( 's360_team', function( $_attr, $_content ){

        global $s360_shortcode_team_index;

        $s360_shortcode_team_index++;

        $attr = shortcode_atts([
            'id'                    => null,
            'style'                 => null,

            'sl_arrows'             => 1,
            'sl_dots'               => 1,

            'length'                => 130,
            'columns'				=> 4,
            'lg-columns'			=> 3,   // 1199
            'md-columns'            => 2,   // 991
            'sm-columns'            => 2,   // 767
            'xs-columns'            => 1,   // 580

            'posts_per_page' 		=> -1,

            'readmore'              => esc_html__( 'See more →', 'S360_THEME_SLUG' )
        ], $_attr);

        $ret = null;

        $columns    = [ 2, 3, 4, 5 ];
        $styles     = [ 'slideshow', 'masonry' ];

        $id         = esc_attr($attr['id']);

        if( empty($id) )
            $id = 's360-tm-' . $s360_shortcode_team_index;

        $ln = absint($attr['length']);

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

        $query = new WP_Query([
            'post_type'         => 'team-member',
            'posts_per_page'    => intval($attr['posts_per_page']),
        ]);

        if( $query -> have_posts() ){
            $ret .= '<div id="' . esc_attr($id) . '" class="s360-tm-wrapper">';
            $ret .= '<div class="s360-tm cols-' . absint($col) . '">';

            foreach( $query -> posts as $p ) {

                $ret .= '<div class="s360-tm-member-wrapper col">';
                $ret .= '<div class="s360-tm-member">';

                $excerpt = trim(strip_tags($p -> post_excerpt));

                if( $ln < strlen($excerpt) )
                    $ret .= '<a href="javascript:void(null);" class="s360-tm-close">&times;</a>';

                $url = esc_url(get_post_meta( $p -> ID, 's360-tm-url', true ));

                $thumbnail          = get_post( get_post_thumbnail_id( $p ) );
                $has_post_thumbnail = has_post_thumbnail( $p ) && isset( $thumbnail -> ID ) && wp_attachment_is( 'image', $thumbnail );

                if( $has_post_thumbnail ){
                    if( !empty($url) ){
                        $ret .= '<div class="s360-tm-avatar">';
                        $ret .= '<a href="' . esc_url($url) . '" title="' . esc_attr( get_the_title( $p ) ) . '">';
                        $ret .= get_the_post_thumbnail( $p, [100, 100] );
                        $ret .= '</a>';
                        $ret .= '</div>';
                    }
                    else{
                        $ret .= '<div class="s360-tm-avatar">';
                        $ret .= get_the_post_thumbnail( $p, [100, 100] );
                        $ret .= '</div>';
                    }
                }

                $ret .= '<div class="s360-tm-head">';

                if( !empty($url) ){
                    $ret .= '<h3 class="s360-tm-title">';
                    $ret .= '<a href="' . esc_url($url) . '" title="' . esc_attr( get_the_title( $p ) ) . '">' . get_the_title( $p ) . '</a>';
                    $ret .= '</h3>';
                }

                else{
                    $ret .= '<h3 class="s360-tm-title">' . get_the_title( $p ) . '</h3>';
                }

                $occupation = esc_html(trim(get_post_meta( $p -> ID, 's360-tm-occupation', true )));

                if( !empty($occupation) )
                    $ret .= '<div class="s360-tm-ocupation">' . esc_html($occupation) . '</div>';

                $phone = esc_html(get_post_meta( $p -> ID, 's360-tm-phone', true ));

                if( !empty($phone) )
                    $ret .= '<div class="s360-tm-phone"><i class="fa fa-mobile-alt"></i>' . esc_html($phone) . '</div>';

                $email = is_email(get_post_meta( $p -> ID, 's360-tm-email', true ));

                if( !empty($email) ){
                    $ret .= '<div class="s360-tm-email">';
                    $ret .= '<a href="mailto:' . is_email($email) . '"><i class="fa fa-at"></i>' . is_email($email) . '</a>';
                    $ret .= '</div>';
                }

                $ret .= '</div>';

                $ret .= '<div class="s360-tm-body">';
                $ret .= '<p>';

                if( $ln < strlen($excerpt) ){
                    $ret .= mb_substr($excerpt, 0, $ln);
                    $ret .= '<span class="s360-tm-excerpt-wrapper">';
                    $ret .= '<span class="s360-tm-excerpt">';
                    $ret .= mb_substr($excerpt, $ln, -1);
                    $ret .= '</span>';
                    $ret .= '<span class="s360-tm-readmore"><a href="javascript:void(null);">' . esc_html( $attr['readmore'] ) . '</a></span>';
                    $ret .= '</span>';
                }

                else{
                    $ret .= $excerpt;
                }

                $ret .= '</p>';
                $ret .= '</div>';

                $facebook   = esc_url(get_post_meta( $p -> ID, 's360-tm-facebook', true ));
                $twitter    = esc_url(get_post_meta( $p -> ID, 's360-tm-twitter', true ));
                $instagram  = esc_url(get_post_meta( $p -> ID, 's360-tm-instagram', true ));

                if( !(empty($facebook) && empty($twitter) && empty($instagram)) ){
                    $ret .= '<div class="s360-tm-socials">';

                    if( !empty($facebook) )
                        $ret .= '<a href="' . esc_url($facebook) . '" class="facebook"><i class="fab fa-facebook-f"></i></a>';

                    if( !empty($twitter) )
                        $ret .= '<a href="' . esc_url($twitter) . '" class="twitter"><i class="fab fa-twitter"></i></a>';

                    if( !empty($instagram) )
                        $ret .= '<a href="' . esc_url($instagram) . '" class="instagram"><i class="fab fa-instagram"></i></a>';

                    $ret .= '</div>';
                }

                $ret .= '</div>';
                $ret .= '</div>';

            }

            $ret .= '</div>';
            $ret .= '</div>';

            $args = [
                'mid_size'              => 2,
                'prev_text'             => '&larr;',
                'next_text'             => '&rarr;',
                'screen_reader_text'    => ''
            ];

            $pagination = get_the_posts_pagination( $args );

            if( !empty( $pagination ) && $attr['style'] == 'masonry' ){
                $ret .= '<div class="s360-tm-pagination">';
                $ret .= $pagination;
                $ret .= '</div>';
            }

            if(!empty($attr['style']) && $attr['style'] == 'masonry' ){
                ob_start();
                ?>
                <script tyle="text/javascript">
                    jQuery(function(){
                        jQuery('div#<?php echo esc_attr($id); ?> .s360-tm').masonry();
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
                        jQuery('div#<?php echo esc_attr($id); ?> .s360-tm').slick({
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
        }
        else{
            $ret .= '<h2>' . esc_html__( 'Not found results.', 'S360_THEME_SLUG' ) . '</h2>';
        }

        return $ret;
    });
?>
