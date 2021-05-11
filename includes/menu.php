<?php

    add_action( 'wp_nav_menu_item_custom_fields', function( $item_id, $item ){

        wp_nonce_field( 's360-menu-nonce', 's360-menu-nonce' );

        $desc = sanitize_text_field(get_post_meta( $item_id, '_s360_desc', true ));
	    $rank = absint(get_post_meta( $item_id, '_s360_rank', true ));
	    $url = esc_url(get_post_meta( $item_id, '_s360_url', true ));
	?>
	    <input type="hidden" class="nav-menu-id" value="<?php echo $item_id ;?>" />


	    <div class="s360-field">
	        <p>
    	        <label for="s360_desc-<?php echo $item_id ;?>" class="w-normal"><?php esc_html_e( "Small description", 'drophouse' ); ?></label>
    	        <input type="text" name="s360_desc[<?php echo $item_id ;?>]" id="s360_desc-<?php echo $item_id ;?>" value="<?php echo esc_attr( $desc ); ?>">
	        </p>
	    </div>

	    <div class="s360-field">
	        <p>
    	        <label for="s360_rank-<?php echo $item_id ;?>" class="w-normal"><?php esc_html_e( "Rank", 'drophouse' ); ?></label>

    	        <select name="s360_rank[<?php echo $item_id ;?>]" id="s360_rank-<?php echo $item_id ;?>">
    	            <option><?php esc_html_e( '-- choose option --', 'drophouse' ); ?></option>
    	            <option value="1" <?php selected( 1, $rank ); ?>><?php esc_html_e( '1 Star', 'drophouse' ); ?></option>
    	            <option value="2" <?php selected( 2, $rank ); ?>><?php esc_html_e( '2 Stars', 'drophouse' ); ?></option>
    	            <option value="3" <?php selected( 3, $rank ); ?>><?php esc_html_e( '3 Stars', 'drophouse' ); ?></option>
    	            <option value="4" <?php selected( 4, $rank ); ?>><?php esc_html_e( '4 Stars', 'drophouse' ); ?></option>
    	            <option value="5" <?php selected( 5, $rank ); ?>><?php esc_html_e( '5 Stars', 'drophouse' ); ?></option>
    	        </select>
	        </p>
	    </div>

	    <div class="s360-field">
	        <p>
    	        <label for="s360_url-<?php echo $item_id ;?>" class="w-normal"><?php esc_html_e( "Image URL", 'drophouse' ); ?></label>
    	        <input type="url" name="s360_url[<?php echo $item_id ;?>]" id="s360_url-<?php echo $item_id ;?>" value="<?php echo esc_url( $url ); ?>">
	        </p>
	    </div>

	<?php
    }, 10, 2 );

    add_action( 'wp_update_nav_menu_item', function( $menu_id, $menu_item_db_id ) {

    	// Verify this came from our screen and with proper authorization.
    	if( !isset( $_POST['s360-menu-nonce'] ) || ! wp_verify_nonce( $_POST['s360-menu-nonce'], 's360-menu-nonce' ) ) {
    		return $menu_id;
    	}

        if( isset( $_POST['s360_desc'][$menu_item_db_id]  ) ){
    		$desc = sanitize_text_field( $_POST['s360_desc'][$menu_item_db_id] );
    		update_post_meta( $menu_item_db_id, '_s360_desc', $desc );
    	} else {
    		delete_post_meta( $menu_item_db_id, '_s360_desc' );
    	}

    	if( isset( $_POST['s360_rank'][$menu_item_db_id]  ) ){
    		$rank = absint( $_POST['s360_rank'][$menu_item_db_id] );
    		update_post_meta( $menu_item_db_id, '_s360_rank', $rank );
    	} else {
    		delete_post_meta( $menu_item_db_id, '_s360_rank' );
    	}

    	if( isset( $_POST['s360_url'][$menu_item_db_id]  ) ){
    		$url = esc_url( $_POST['s360_url'][$menu_item_db_id] );
    		update_post_meta( $menu_item_db_id, '_s360_url', $url );
    	} else {
    		delete_post_meta( $menu_item_db_id, '_s360_url' );
    	}

    }, 10, 2 );

    function s360_rank( $rank ){
        $ret = '';

        for( $i = 1; $i < 6; $i++ ){
            if( $i <= $rank ){
                $ret .= '<i class="fa fa-star with-color"></i>';
            }
            else{
                $ret .= '<i class="fa fa-star"></i>';
            }
        }

        return $ret;
    }

    add_filter( 'nav_menu_item_title', function( $title, $item ) {

        $cnt = null;

    	if( is_object( $item ) && isset( $item -> ID ) ) {

            $desc = sanitize_text_field(get_post_meta( $item->ID, '_s360_desc', true ));

    		if ( !empty($desc) ){
    			$cnt .= '<span class="s360-desc">' . esc_html( $desc )  . '</span>';
    		}

    		$rank = absint(get_post_meta( $item->ID, '_s360_rank', true ));

    		if ( 0 < $rank && $rank < 6 ){
    			$cnt .= '<span class="s360-rank">' . s360_rank( $rank )  . '</span>';
    		}

    		$url = esc_url(get_post_meta( $item->ID, '_s360_url', true ));

    		if ( !empty( $url ) ) {
    			$cnt .= '<span class="s360-image"><img src="' . esc_url($url) . '"/></span>';
    		}
    	}

    	$ret = $title;

    	if( !empty($cnt) )
    	    $ret = '<span class="s360-menu-wrap"><span class="s360-item">' . $title . '</span>' . $cnt . '</span>';

    	return  $ret;

    }, 10, 2 );
?>
