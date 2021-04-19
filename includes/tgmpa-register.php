<?php
    /**
     *  TGM SETUP
     */

    add_action( 'tgmpa_register', function(){
        $plugins = [
            [
                'name'      => 'Contact Form 7',
                'slug'      => 'contact-form-7',
                'required'  => false,
            ],
            [
                'name'      => 'Loco Translate',
                'slug'      => 'loco-translate',
                'required'  => false
            ],
            // lightSpeed
            [
                'name'      => 'Duplicate Post',
                'slug'      => 'duplicate-post',
                'required'  => false
            ],
            [
                'name'      => 'Ocean Hooks',
                'slug'      => 'ocean-hooks',
                'source'    => get_stylesheet_directory() . '/includes/plugins/ocean-hooks.zip',
                'required'  => false
            ],
            [
                'name'      => 'Ocean Sticky Header',
                'slug'      => 'ocean-sticky-header',
                'source'    => get_stylesheet_directory() . '/includes/plugins/ocean-sticky-header.zip',
                'required'  => false
            ],
            [
                'name'      => 'Ocean Cookie Notice',
                'slug'      => 'ocean-cookie-notice',
                'source'    => get_stylesheet_directory() . '/includes/plugins/ocean-cookie-notice.zip',
                'required'  => false
            ],
            [
                'name'      => 'TI WooCommerce Wishlist',
                'slug'      => 'ti-woocommerce-wishlist',
                'require'   => false
            ],
            [
                'name'      => 'Variation Swatches for WooCommerce',
                'slug'      => 'woo-variation-swatches',
                'require'   => false
            ],
            [
                'name'      => 'S360 LESS',
                'slug'      => 's360-less',
                'source'    => get_stylesheet_directory() . '/includes/plugins/s360-less.zip',
                'required'  => false
            ]
        ];

        $config = [
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
        ];

        tgmpa( $plugins, $config );
    });
?>
