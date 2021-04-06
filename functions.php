<?php

    require_once get_stylesheet_directory() . '/includes/tools.php';
    require_once get_stylesheet_directory() . '/includes/scripts.php';
    require_once get_stylesheet_directory() . '/includes/class-tgm-plugin-activation.php';
    require_once get_stylesheet_directory() . '/includes/tgmpa-register.php';

    //
    //require_once get_stylesheet_directory() . '/includes/admin-pages.php';
    //require_once get_stylesheet_directory() . '/includes/admin-login.php';
    //require_once get_stylesheet_directory() . '/includes/custom-posts.php';
    //require_once get_stylesheet_directory() . '/includes/meta.php';

    // EXTRA
    //require_once get_stylesheet_directory() . '/includes/extra/table-sizes.php';

    // SHORTCODES
    //require_once get_stylesheet_directory() . '/includes/shortcodes/articles.php';
    //require_once get_stylesheet_directory() . '/includes/shortcodes/products.php';
    //require_once get_stylesheet_directory() . '/includes/shortcodes/gmap.php';
    //require_once get_stylesheet_directory() . '/includes/shortcodes/team.php';
    //require_once get_stylesheet_directory() . '/includes/shortcodes/testimonials.php';

    /**
     *  INTERNATIONALIZATION
     */

    add_action( 'after_setup_theme', function(){

		set_post_thumbnail_size( 825, 620, true ); // post-thumbnail

        load_child_theme_textdomain( 'S360_THEME_SLUG', get_stylesheet_directory() . '/languages' );
    }, 1);

    /**
     *  ADDITIONAL QUERY
     */

    // add_action( 'init', function(){
    //     // add tags with `_` prefix to avoid screwing up query
    //     add_rewrite_tag( '%_page%', '([^/]+)' );
    //
    //     add_rewrite_rule( '([a-zA-Z\d\-_+]+)/page/([^/]+)/?$', 'index.php?pagename=$matches[1]&_page=$matches[2]', 'top' );
    //
    //     // required once after rules added/changed
    //     flush_rewrite_rules( true );
    // }, 0 );
    //
    // add_filter( 'query_vars', function( $vars ){
    //     $vars[] = "_page";
    //     return $vars;
    // });
?>
