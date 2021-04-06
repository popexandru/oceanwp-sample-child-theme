<?php
    /**
     *  BACKEND DISPLAY ENGINE DETAILS
     */

    function s360_team_member_details_save( $post_id ){

        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
     		return;

     	if( isset($_POST) && !empty($_POST) ){
    		if( isset($_POST['s360-tm-occupation']) ){
    			update_post_meta( $post_id, 's360-tm-occupation', sanitize_text_field( $_POST['s360-tm-occupation'] ) );
    		}

            if( isset($_POST['s360-tm-url']) ){
    			update_post_meta( $post_id, 's360-tm-url', esc_url( $_POST['s360-tm-url'] ) );
    		}

            if( isset($_POST['s360-tm-email']) ){
    			update_post_meta( $post_id, 's360-tm-email', is_email( $_POST['s360-tm-email'] ) );
    		}

            if( isset($_POST['s360-tm-phone']) ){
    			update_post_meta( $post_id, 's360-tm-phone', sanitize_text_field( $_POST['s360-tm-phone'] ) );
    		}

            if( isset($_POST['s360-tm-facebook']) ){
    			update_post_meta( $post_id, 's360-tm-facebook', esc_url( $_POST['s360-tm-facebook'] ) );
    		}

            if( isset($_POST['s360-tm-twitter']) ){
    			update_post_meta( $post_id, 's360-tm-twitter', esc_url( $_POST['s360-tm-twitter'] ) );
    		}

            if( isset($_POST['s360-tm-instagram']) ){
    			update_post_meta( $post_id, 's360-tm-instagram', esc_url( $_POST['s360-tm-instagram'] ) );
    		}

            // Skills multiple dynamic
     	}
    }

    /* <?php $val = $val ? $val : null; ?> */

    function s360_team_member_details_form( $post ){

        ?>
            <div class="s360-field">
	            <p>
                    <label for="s360-tm-occupation"><?php echo esc_html__( 'Occupation / Function', 'S360_THEME_SLUG' ); ?></label>

	                <?php $val = sanitize_text_field( get_post_meta( $post -> ID, 's360-tm-occupation', true ) ); ?>

	                <input type="text" name="s360-tm-occupation" id="s360-tm-occupation" value="<?php echo sanitize_text_field( $val ); ?>"/>
	            </p>
	        </div>

            <div class="s360-field">
	            <p>
                    <label for="s360-tm-url"><?php echo esc_html__( 'Url', 'S360_THEME_SLUG' ); ?></label>

	                <?php $val = esc_url( get_post_meta( $post -> ID, 's360-tm-url', true ) ); ?>

	                <input type="url" name="s360-tm-url" id="s360-tm-url" value="<?php echo esc_url( $val ); ?>"/>
	            </p>
	        </div>

            <div class="s360-field">
	            <p>
                    <label for="s360-tm-email"><?php echo esc_html__( 'Email', 'S360_THEME_SLUG' ); ?></label>

	                <?php $val = is_email( get_post_meta( $post -> ID, 's360-tm-email', true ) ); ?>

	                <input type="email" name="s360-tm-email" id="s360-tm-email" value="<?php echo is_email( $val ); ?>"/>
	            </p>
	        </div>

            <div class="s360-field">
	            <p>
                    <label for="s360-tm-phone"><?php echo esc_html__( 'Phone', 'S360_THEME_SLUG' ); ?></label>

	                <?php $val = sanitize_text_field( get_post_meta( $post -> ID, 's360-tm-phone', true ) ); ?>

	                <input type="text" name="s360-tm-phone" id="s360-tm-phone" value="<?php echo sanitize_text_field( $val ); ?>"/>
	            </p>
	        </div>

            <div class="s360-field">
	            <p>
                    <label for="s360-tm-facebook"><?php echo esc_html__( 'Facebook', 'S360_THEME_SLUG' ); ?></label>

	                <?php $val = esc_url( get_post_meta( $post -> ID, 's360-tm-facebook', true ) ); ?>

	                <input type="url" name="s360-tm-facebook" id="s360-tm-facebook" value="<?php echo esc_url( $val ); ?>"/>
	            </p>
	        </div>

            <div class="s360-field">
	            <p>
                    <label for="s360-tm-twitter"><?php echo esc_html__( 'Twitter', 'S360_THEME_SLUG' ); ?></label>

	                <?php $val = esc_url( get_post_meta( $post -> ID, 's360-tm-twitter', true ) ); ?>

	                <input type="url" name="s360-tm-twitter" id="s360-tm-twitter" value="<?php echo esc_url( $val ); ?>"/>
	            </p>
	        </div>

            <div class="s360-field">
	            <p>
                    <label for="s360-tm-instagram"><?php echo esc_html__( 'Instagram', 'S360_THEME_SLUG' ); ?></label>

	                <?php $val = esc_url( get_post_meta( $post -> ID, 's360-tm-instagram', true ) ); ?>

	                <input type="url" name="s360-tm-instagram" id="s360-tm-instagram" value="<?php echo esc_url( $val ); ?>"/>
	            </p>
	        </div>
        <?php
    }
?>
