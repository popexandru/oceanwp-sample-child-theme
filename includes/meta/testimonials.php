<?php

    function s360_testimonials_shortcode_form( $post ){
        ?>
            <div class="s360-field">
                <code style="margin: 3px;display: inline-block;">[s360_testimonials/]</code><br>
                <code style="margin: 3px;display: inline-block;">[s360_testimonials id="<?php echo absint( $post -> ID ) ?>"/]</code>
            </div>
        <?php
    }

    /**
     *  BACKEND DISPLAY ENGINE DETAILS
     */

    function s360_testimonials_save( $post_id ){

        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
     		return;

     	if( isset($_POST) && !empty($_POST) ){
    		if( isset($_POST['s360-ts-occupation']) ){
    			update_post_meta( $post_id, 's360-ts-occupation', sanitize_text_field( $_POST['s360-ts-occupation'] ) );
    		}

            if( isset($_POST['s360-ts-url']) ){
    			update_post_meta( $post_id, 's360-ts-url', esc_url( $_POST['s360-ts-url'] ) );
    		}

            if( isset($_POST['s360-ts-email']) ){
    			update_post_meta( $post_id, 's360-ts-email', is_email( $_POST['s360-ts-email'] ) );
    		}
     	}
    }

    /* <?php $val = $val ? $val : null; ?> */

    function s360_testimonials_form( $post ){

        ?>
            <div class="s360-field">
	            <p>
                    <label for="s360-ts-occupation"><?php echo esc_html__( 'Occupation / Function', 'S360_THEME_SLUG' ); ?></label>

	                <?php $val = sanitize_text_field( get_post_meta( $post -> ID, 's360-ts-occupation', true ) ); ?>

	                <input type="text" name="s360-ts-occupation" id="s360-ts-occupation" value="<?php echo sanitize_text_field( $val ); ?>"/>
	            </p>
	        </div>

            <div class="s360-field">
	            <p>
                    <label for="s360-ts-url"><?php echo esc_html__( 'Url', 'S360_THEME_SLUG' ); ?></label>

	                <?php $val = esc_url( get_post_meta( $post -> ID, 's360-ts-url', true ) ); ?>

	                <input type="url" name="s360-ts-url" id="s360-ts-url" value="<?php echo esc_url( $val ); ?>"/>
	            </p>
	        </div>

            <div class="s360-field">
	            <p>
                    <label for="s360-ts-email"><?php echo esc_html__( 'Email', 'S360_THEME_SLUG' ); ?></label>

	                <?php $val = is_email( get_post_meta( $post -> ID, 's360-ts-email', true ) ); ?>

	                <input type="email" name="s360-ts-email" id="s360-ts-email" value="<?php echo is_email( $val ); ?>"/>
	            </p>
	        </div>
        <?php
    }
?>
