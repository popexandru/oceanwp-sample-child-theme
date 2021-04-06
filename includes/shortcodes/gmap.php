<?php
    global $s360_shortcode_gmap_index, $s360_shortcode_marker_index;

    $s360_shortcode_gmap_index      = 0;
    $s360_shortcode_marker_index    = 0;

    add_shortcode('s360_gmap', function( $_attr, $_content ){

        global $s360_shortcode_gmap_index;


        $s360_shortcode_gmap_index++;

        $attr = shortcode_atts([
            'id'            => null,
            'lat'           => 44.443228,
            'lng'           => 26.097716,
            'zoom'          => 18,
            'height'        => '400px',
            'lg-height'     => null,    // 1200
            'md-height'     => null,    // 992
            'sm-height'     => null,    // 768
            'xs-height'     => null,    // 581

        ], $_attr);

        $id         = esc_attr($attr['id']);
        $lat        = floatval($attr['lat']);
        $lng        = floatval($attr['lng']);
        $zoom       = absint($attr['zoom']);
        $height     = esc_attr($attr['height']);
        $lg_height  = esc_attr($attr['lg-height']);
        $md_height  = esc_attr($attr['md-height']);
        $sm_height  = esc_attr($attr['sm-height']);
        $xs_height  = esc_attr($attr['xs-height']);

        $content    = trim($_content);

        if( empty($id) )
            $id = 's360-gmap-' . $s360_shortcode_gmap_index;

        ob_start();

        ?>
            <style>
                <?php echo '#' . esc_attr($id) ?>{
                    height: <?php echo esc_attr( $height ); ?>;
                }

                <?php if( !empty($lg_height) ) : ?>
                    @media (min-width: 1200px){
                        <?php echo '#' . esc_attr($id) ?>{
                            height: <?php echo esc_attr( $lg_height ); ?>;
                        }
                    }
                <?php endif; ?>

                <?php if( !empty($md_height) ) : ?>
                    @media (min-width: 992px){
                        <?php echo '#' . esc_attr($id) ?>{
                            height: <?php echo esc_attr( $md_height ); ?>;
                        }
                    }
                <?php endif; ?>

                <?php if( !empty($sm_height) ) : ?>
                    @media (min-width: 768px){
                        <?php echo '#' . esc_attr($id) ?>{
                            height: <?php echo esc_attr( $sm_height ); ?>;
                        }
                    }
                <?php endif; ?>

                <?php if( !empty($xs_height) ) : ?>
                    @media (min-width: 581px){
                        <?php echo '#' . esc_attr($id) ?>{
                            height: <?php echo esc_attr( $xs_height ); ?>;
                        }
                    }
                <?php endif; ?>
            </style>
            <div id="<?php echo esc_attr( $id ); ?>"></div>

            <?php $key = get_theme_mod( 's360-gmap-key', null ); ?>

            <?php if( empty( $key ) ) : ?>
                <script>
                    var map;

                    function S360InitMap() {
                        map = new google.maps.Map( document.getElementById( '<?php echo $id; ?>' ), {
                            center : new google.maps.LatLng( <?php echo esc_attr($lat); ?>, <?php echo esc_attr($lng); ?> ),
                            zoom : <?php echo absint($zoom); ?>,

                            //zoomControl: false,
                            //scaleControl: false,
                            scrollwheel: false,
                            //disableDoubleClickZoom: true
                        });

                        <?php if( empty($content)) : ?>

                            new google.maps.Marker({
                                position : new google.maps.LatLng( <?php echo floatval($lat); ?>, <?php echo floatval($lng); ?> ),
                                map : map,
                                animation : google.maps.Animation.DROP
                            });

                        <?php else : ?>
                            <?php echo do_shortcode( strip_tags( trim($_content), '<a><strong><b><p>') ); ?>
                        <?php endif; ?>
                    }
                </script>
                <script defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc_attr($key); ?>&callback=S360InitMap"></script>
            <?php else : ?>
                <div><pre><?php esc_html_e( 'Please setup Google Map Key', 'S360_THEME_SLUG' ); ?></pre></div>
            <?php endif; ?>
        <?php

        return ob_get_clean();
    });

    add_shortcode('s360_marker', function( $_attr, $_content ){

        global $s360_shortcode_marker_index;

        $s360_shortcode_marker_index++;

        $attr = shortcode_atts([
            'lat'           => 44.443228,
            'lng'           => 26.097716,
            'pin'           => null,
            'title'         => null
        ], $_attr);


        $lat        = floatval($attr['lat']);
        $lng        = floatval($attr['lng']);
        $pin        = esc_url($attr['pin']);
        $title      = esc_html($attr['title']);
        $_content   = trim($_content);

        $content    = '';

        if( !empty($title))
            $content .= '<h3>' . esc_html($title) . '</h3>';

        if( !empty($_content) )
            $content .= apply_filters( 'the_content', $_content );


        ob_start();
        ?>
            var marker_<?php echo absint($s360_shortcode_marker_index); ?> = new google.maps.Marker({
                position : new google.maps.LatLng( <?php echo floatval($lat); ?>, <?php echo floatval($lng); ?> ),

                <?php if( !empty($pin) ) : ?>
                    icon : '<?php echo esc_url($pin); ?>',
                <?php endif; ?>

                map : map,

                <?php if( !empty($title) ) : ?>
                    title : '<?php echo esc_html($title); ?>',
                <?php endif; ?>

                animation : google.maps.Animation.DROP
            });

            <?php if( !empty($content) ) : ?>

                var infowindow_<?php echo absint($s360_shortcode_marker_index); ?> = new google.maps.InfoWindow({
                    content: '<?php echo trim($content); ?>'
                });

                marker_<?php echo absint($s360_shortcode_marker_index); ?>.addListener( 'click', function(){
                    infowindow_<?php echo absint($s360_shortcode_marker_index); ?>.open( map, marker_<?php echo absint($s360_shortcode_marker_index); ?> );
                });

            <?php endif; ?>
        <?php
        return ob_get_clean();
    });
?>
