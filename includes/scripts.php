<?php

    /**
     *  FRONT END
     */

    add_action( 's360_less_scripts', function( $less ){

        $less -> add( '/public/less/styles.less', '/public/css/styles.css' );
        //$less -> add( '/public/less/docs.less', '/public/css/docs.css' );

        $less -> compile();

    }, 10 );

    /**
     *  BACKEND END
     */

    add_action( 's360_less_admin_scripts', function( $less ){

        $less -> add( '/admin/less/styles.less', '/admin/css/styles.css' );
        //$less -> add( '/public/less/docs.less', '/public/css/docs.css' );

        $less -> compile();

    }, 10 );

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
