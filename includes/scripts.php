<?php
    /**
     *  DEVELOPMENT MODE
     *  Compile file.less > file.css
     */

    if( class_exists( 'WPLessPlugin' ) ){
        $lessConfig = WPLessPlugin::getInstance()->getConfiguration();

        // compiles in the active theme, in a ‘compiled-css’ subfolder
        $lessConfig->setUploadDir(get_stylesheet_directory());
        $lessConfig->setUploadUrl(get_stylesheet_directory_uri());

        add_action( 'wp-less_init', function( $WPLess ){
            $WPLess->getCompiler()->setFormatter( 'compressed' );
        });

        add_filter( 'wp-less_stylesheet_compute_target_path', function( $path ){

            $path = str_replace( '-%s.css', '.css', str_replace( '/S360_THEME_SLUG/public/less/', '/public/css/', $path ) );
            $path = str_replace( '-%s.css', '.css', str_replace( '/S360_THEME_SLUG/admin/less/', '/admin/css/', $path ) );

            return $path;
        });

        /**
         *  LOAD LESS STYLES
         */

        add_action( 'wp_enqueue_scripts', function(){
            wp_register_style( 's360-styles', get_stylesheet_directory_uri() . '/public/less/styles.less', null, null );
            wp_enqueue_style( 's360-styles' );
        }, 100 );

        add_action( 'admin_enqueue_scripts', function(){
            wp_enqueue_style( 's360-styles', get_stylesheet_directory_uri() . '/admin/less/styles.less', false, null );
            wp_enqueue_style( 's360-styles' );
        });
    }

    else{

        /**
         *  LOAD CSS STYLES
         */

        add_action( 'wp_enqueue_scripts', function(){
            wp_register_style( 's360-styles', get_stylesheet_directory_uri() . '/public/css/styles.css', null, null );
            wp_enqueue_style( 's360-styles' );
        }, 100 );

        add_action( 'admin_enqueue_scripts', function(){
            wp_enqueue_style( 's360-styles', get_stylesheet_directory_uri() . '/admin/css/styles.css', null, null );
            wp_enqueue_style( 's360-styles' );
        });
    }

    /**
     *  LOAD JavaScripts
     */

    add_action( 'wp_enqueue_scripts', function(){
    wp_register_script( 's360-scripts', get_stylesheet_directory_uri() . '/public/js/scripts.js', [ 'jquery'/*, 'masonry'*/ ], null, true );
        wp_enqueue_script( 's360-scripts' );

        /*wp_register_script( 's360-slick', get_stylesheet_directory_uri() . '/assets/js/slick.js', [ 'jquery' ], null, true );
        wp_enqueue_script( 's360-slick' );*/

    }, 100 );

    add_action( 'admin_enqueue_scripts', function(){

        /**
         *  Admin Media Uploader
         */

        //wp_enqueue_media();

        //wp_register_script( 's360-uploader', get_stylesheet_directory_uri() . '/admin/js/uploader.js', [ 'jquery' ], null, true );
        //wp_enqueue_script( 's360-uploader' );

        wp_register_script( 's360-scripts', get_stylesheet_directory_uri() . '/admin/js/scripts.js', [ 'jquery' ], null, true );
        wp_enqueue_script( 's360-scripts' );
    });
?>
