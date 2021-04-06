<?php
    /**
     *  TGM SETUP
     */

    add_action( 'tgmpa_register', function(){
        $plugins = array(
            array(
                'name'      => 'Contact Form 7',
                'slug'      => 'contact-form-7',
                'required'  => false,
            ),
            array(
                'name'      => 'Loco Translate',
                'slug'      => 'loco-translate',
                'required'  => false
            ),
            // lightSpeed
            array(
                'name'      => 'Duplicate Post',
                'slug'      => 'duplicate-post',
                'required'  => false
            ),
            array(
                'name'      => 'Ocean Hooks',
                'slug'      => 'ocean-hooks',
                'source'    => get_stylesheet_directory() . '/includes/plugins/ocean-hooks.zip',
                'required'  => false
            ),
            array(
                'name'      => 'Ocean Sticky Header',
                'slug'      => 'ocean-sticky-header',
                'source'    => get_stylesheet_directory() . '/includes/plugins/ocean-sticky-header.zip',
                'required'  => false
            ),
            array(
                'name'      => 'Ocean Cookie Notice',
                'slug'      => 'ocean-cookie-notice',
                'source'    => get_stylesheet_directory() . '/includes/plugins/ocean-cookie-notice.zip',
                'required'  => false
            ),
            array(
                'name'      => 'TI WooCommerce Wishlist',
                'slug'      => 'ti-woocommerce-wishlist',
                'require'   => false
            ),
            array(
                'name'      => 'Variation Swatches for WooCommerce',
                'slug'      => 'woo-variation-swatches',
                'require'   => false
            ),
            array(
                'name'      => 'WP Less',
                'slug'      => 'wp-less',
                'required'  => false
            )
        );

        $config = array(
            'id'           => 'oceanwp_theme',
            'domain'       => 'oceanwp',
            'menu'         => 'install-required-plugins',
            'parent_slug'  => 'themes.php',
            'capability'   => 'edit_theme_options',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => false,
            'message'      => ''
        );

        tgmpa( $plugins, $config );
    });
?>
