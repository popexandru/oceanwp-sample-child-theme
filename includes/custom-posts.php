<?php
    add_action( 'init', function(){

        $posts = [
            // 'team-member' => [
            //     'menu_icon'         => 'dashicons-groups',
            //     'singular-title'    => esc_html__( 'Team Member' , 'S360_THEME_SLUG' ),
            //     'plural-title'      => esc_html__( 'Team Members' , 'S360_THEME_SLUG' ),
            //     'parent'            => '',
            //     'fields'            => [ 'title', 'excerpt', 'thumbnail' ]
            // ],
            // 'testimonials' => [
            //     'menu_icon'         => 'dashicons-groups',
            //     'singular-title'    => esc_html__( 'Testimonials' , 'S360_THEME_SLUG' ),
            //     'plural-title'      => esc_html__( 'Testimonials' , 'S360_THEME_SLUG' ),
            //     'fields'            => [ 'title', 'excerpt', 'thumbnail' ]
            // ],
            // 'rank' => [
            //     'singular-title'    => __( 'Testimonials' , 'S360_THEME_SLUG' ),
            //     'plural-title'      => __( 'Testimonials' , 'S360_THEME_SLUG' ),
            //     'parent'            => '',
            //     'fields'            => [ 'title', 'excerpt' ]
            // ],
        ];

        foreach( $posts as $slug => & $post ){
            if( isset( $post[ 'noregister' ] ) && $post[ 'noregister' ] ){
                /* IF NOT REGISTER CUSTOM POST  */
            }
            else{

                /* LABELS FOR ADMIN SIDE */
                $labels = [
                    'name'          	=> esc_html( $post[ 'plural-title' ] ),
                    'singular_name' 	=> esc_html( $post[ 'singular-title' ] ),
                    'add_new'       	=> sprintf( esc_html__( 'Add new %1$s', 'S360_THEME_SLUG' ), esc_html( $post[ 'singular-title' ] ) ),
                    'add_new_item'  	=> sprintf( esc_html__( 'Add new %1$s' , 'S360_THEME_SLUG' ), esc_html( $post[ 'singular-title' ] ) ),
                    'edit_item'     	=> sprintf( esc_html__( 'Edit %1$s', 'S360_THEME_SLUG' ), esc_html( $post[ 'singular-title' ] ) ),
                    'new_item'      	=> sprintf( esc_html__( 'New %1$s', 'S360_THEME_SLUG' ), esc_html( $post[ 'singular-title' ] ) ),
                    'view_item'     	=> sprintf( esc_html__( 'View %1$s', 'S360_THEME_SLUG' ), esc_html( $post[ 'singular-title' ] ) ),
                    'search_items'  	=>  esc_html__( 'Search', 'S360_THEME_SLUG' ),
                    'not_found'     	=>  esc_html__( 'Not found' , 'S360_THEME_SLUG' ),
                    'not_found_in_trash' => esc_html__( 'Not found in trash' , 'S360_THEME_SLUG' )
                ];


                if( isset( $post[ 'fields' ] ) && is_array( $post[ 'fields' ] ) && !empty( $post[ 'fields' ] ) ){
                    $fields = $post[ 'fields' ];
                }else{
                    /* DEAFULT LIST WITH FIELDS */
                    $fields = [ 'title' , 'editor' , 'excerpt' , 'comments' , 'thumbnail' ];
                }

                $args = [
                    'public'        => true,
                    'hierarchical'  => false,
                    'menu_position' => 5,
                    'supports'      => $fields,
                    'labels'        => $labels,
                ];

                if(isset($post['hierarchical'])){
                    $args['hierarchical'] = $post['hierarchical'];
                }

                /* REGISTER CUSTOM POST */
                register_post_type( $slug , $args );
            }
        }
    });
?>
