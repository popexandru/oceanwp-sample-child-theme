<?php

    /**
     *  Latest Articles ( with thumbnail )
     */

    if( !class_exists( 'S360_Widget_Banner' ) ){

        class S360_Widget_Banner extends WP_Widget{

            /**
             *  Widget Constructor
             */
            function __construct(){
                parent::__construct( 'S360_Widget_Banner', esc_html__( 'S360 Banner', 'home-food' ), [
                    'classname'     => 's360-widget-banner',
                    'description'   => esc_html__( 'Banner ...', 'home-food' )
                ]);
            }

            /**
             *  Widget Preview
             */

            function widget( $args, $instance ){

                // extract args
                extract( $args , EXTR_SKIP );

                $instance = wp_parse_args( (array) $instance, [
                    'title'         => null,
                    'description'   => null,
                    'img'           => null
                ]);

                $title          = sanitize_text_field( $instance[ 'title' ] );
                $description    = sanitize_textarea_field( $instance[ 'description' ] );
                $img            = esc_url( $instance[ 'img' ] );

                $style          = 'background-image: url(' . $img . ');';

                echo $before_widget;
                echo '<div class="s360-bkg-panel" style="' . esc_attr($style) . '">';

                if( !empty( $title ) ){
                    echo $before_title;
                    echo apply_filters( 'widget_title', sanitize_text_field( $title ), $instance, $this -> id_base );
                    echo $after_title;
                }

                if( !empty($description) )
                    echo '<p>' . sanitize_textarea_field( $description ) . '</p>';

                echo '</div>';
                echo $after_widget;
            }

            /**
             *  Widget Update
             */

            function update( $new_instance, $old_instance )
            {
                $new_instance = wp_parse_args( (array) $new_instance, [
                    'title'         => null,
                    'description'   => null,
                    'img'           => null
                ]);

                $instance                       = $old_instance;

                $instance[ 'title' ]            = sanitize_text_field( $new_instance[ 'title' ] );
                $instance[ 'description' ]      = sanitize_textarea_field( $new_instance[ 'description' ] );
                $instance[ 'img' ]              = esc_url( $new_instance[ 'img' ] );

                return $instance;
            }

            /**
             *  Widget Form ( admin side )
             */

            function form( $instance )
            {
                $instance = wp_parse_args( (array) $instance, [
                    'title'         => null,
                    'description'   => null,
                    'img'           => null
                ]);

                echo '<p>';
                echo '<label for="' . $this -> get_field_id( 'title' ) . '">' . esc_html__( 'Title', 'home-made' );
                echo '<input type="text" class="widefat" id="' . $this -> get_field_id( 'title' ) . '" name="' . $this -> get_field_name( 'title' ) . '" value="' . sanitize_text_field( $instance['title'] ) . '" />';
                echo '</label>';
                echo '</p>';

                echo '<p>';
                echo '<label for="' . $this -> get_field_id( 'description' ) . '">' . esc_html__( 'Description', 'home-made' );
                echo '<textarea class="widefat" id="' . $this -> get_field_id( 'description' ) . '" name="' . $this -> get_field_name( 'description' ) . '">' . sanitize_textarea_field( $instance['description'] ) . '</textarea>';
                echo '</label>';
                echo '</p>';

                echo '<p>';
                echo '<label for="' . $this -> get_field_id( 'img' ) . '">' . esc_html__( 'Image', 'home-made' );
                echo '<input type="url" class="widefat" id="' . $this -> get_field_id( 'img' ) . '" name="' . $this -> get_field_name( 'img' ) . '" value="' . esc_url( $instance['img'] ) . '" />';
                echo '</label>';
                echo '</p>';
            }
        }
    }
