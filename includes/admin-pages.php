<?php

	/**
	 *  REGISTER ADMIN PAGES AND SUBPAGES
	 **/

    add_action('admin_menu', function(){


    	//create new top-level menu
    	// add_menu_page(
    	//     'S360_THEME_SLUG',
    	//     'S360_THEME_NAME',
    	//     'administrator',
    	//     'S360_THEME_SLUG'
        // );
        // 
    	// add_submenu_page(
    	//     'S360_THEME_SLUG',
    	//     esc_html__( 'Table Sizes', 'S360_THEME_SLUG' ),
    	//     esc_html__( 'Table Sizes', 'S360_THEME_SLUG' ),
    	//     'administrator',
    	//     'S360_THEME_SLUG',
    	//     's360_table_sizes_page_content'
        // );

    	// TABLE SIZES
    	//include get_stylesheet_directory() . '/includes/admin-pages/table-sizes.php';
    });
?>
