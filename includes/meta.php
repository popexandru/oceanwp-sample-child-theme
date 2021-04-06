<?php

    /**
     *  INCLUDE META FORM AND META SAVE FUNCTIONS
     */

    // include_once get_stylesheet_directory() . '/includes/meta/team-member.php';
    // include_once get_stylesheet_directory() . '/includes/meta/testimonials.php';

    /**
     *  REGISTER CUSTOM META
     */

    add_action( 'admin_init', function(){

        $boxes = [
            // 'team-member' => [
            //     's360-details' => [
            //         'title' 	=> esc_html__( 'Other details', 'S360_THEME_SLUG' ),
            //         'context' 	=> 'normal',
            //         'priority' 	=> 'default',
            //         'callback'	=> 's360_team_member_details_form',
            //         'save'		=> 's360_team_member_details_save',
            //         'args' 		=> null,
            //     ]
            // ],
            // 'testimonials' => [
            //     's360-details' => [
            //         'title' 	=> esc_html__( 'Other details', 'S360_THEME_SLUG' ),
            //         'context' 	=> 'side',
            //         'priority' 	=> 'default',
            //         'callback'	=> 's360_testimonials_form',
            //         'save'		=> 's360_testimonials_save',
            //         'args' 		=> null,
            //     ],
            //     's360-shortcode' => [
            //         'title' 	=> esc_html__( 'Other details', 'S360_THEME_SLUG' ),
            //         'context' 	=> 'normal',
            //         'priority' 	=> 'high',
            //         'callback'	=> 's360_testimonials_shortcode_form',
            //         'save'		=> null,
            //         'args' 		=> null,
            //     ]
            // ],
        ];

        foreach( $boxes as $post_slug => & $post_boxes ) {
            foreach( $post_boxes as $box_slug => $box ) {
                add_meta_box( $box_slug
                    , $box[ 'title' ]
                    , $box[ 'callback' ]
                    , $post_slug
                    , $box[ 'context' ]
                    , $box[ 'priority' ]
                    , $box[ 'args' ]
                );

                if( isset( $box[ 'save' ] ) ) {
                    add_action( 'save_post', $box[ 'save' ], 10, 1 );
                }
            }
        }
    });
?>
