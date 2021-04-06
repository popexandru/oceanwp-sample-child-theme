<?php
    function s360_table_sizes_page_content(){

        if ( isset( $_POST['s360-table-sizes'] ) && wp_verify_nonce( $_POST['s360-table-sizes'], 's360-table-sizes' ) ){

            $table_sizes = [];

            if( isset($_POST['s360-title']) ){
                foreach( $_POST['s360-title'] as $i => $title ){
                    $table_sizes[] = [
                        'category'  => $_POST['s360-category'][$i],
                        'title'     => $title,
                        'icon'      => $_POST['s360-icon'][$i],
                        'image'     => $_POST['s360-image'][$i],
                        'content'   => $_POST['s360-content'][$i]
                    ];
                }
            }

            update_option( 's360-table-sizes-display-mode', esc_attr($_POST['s360-display-mode']) );
            update_option( 's360-table-sizes', $table_sizes );
        }

        ?>


        <div class="s360-page">
            <form method="post">

                <p class="s360-field">
                    <label for="s360-display-mode"><?php esc_html_e( 'Display mode', 'S360_THEME_SLUG' ); ?></label>
                    <select name="s360-display-mode">
                        <option value="all-table-sizes"><?php esc_attr_e( 'Display all table sizes in a tab', 'S360_THEME_SLUG' ); ?></option>
                        <option value="relative-table-size"><?php esc_attr_e( 'Display relative table size', 'S360_THEME_SLUG' )?></option>
                    </select>
                </p>

                <div class="s360-build-table-sizes-wrapper">

                    <div id="s360-build-table-sizes">
                    </div>

                    <button type="button" id="s360-add-new" class="button"><?php esc_html_e( 'Add New', 'S360_THEME_SLUG' ); ?></button>
                </div>

                <hr>

                <?php wp_nonce_field( 's360-table-sizes', 's360-table-sizes' ); ?>

                <button type="submit" class="button is-primary"><?php esc_html_e( 'Save changes', 'S360_THEME_SLUG' ); ?></button>
            </form>

            <script>
                jQuery(function(){

                    if( jQuery( '#s360-build-table-sizes' ).length ){

                        var S360TableSizes = function S360TableSizes( container ){

                            var s360_table_sizes_index = 0;

                            return {
                                Add : function( data ){

                                    var d = jQuery.extend({
                                        category    : '',
                                        title       : '',
                                        icon        : '',
                                        image       : '',
                                        content     : ''
                                    }, data );

                                    var i = s360_table_sizes_index;

                                    var self        = this;
                                    var options     = '';

                                    <?php
                                        $terms = get_terms([
                                            'taxonomy'      => 'product_cat',
                                            'orderby'       => 'id',
                                            'order'         => 'ASC',
                                            'hide_empty'    => false
                                        ]);

                                        foreach($terms as $t){
                                            $i = $t -> term_id;

                                            echo 'var selected_' . $i . ' = \'\';' . "\n";
                                            echo 'if( d.category == ' . $t -> term_id . ' ){ selected_' . $i . ' = \'selected="selected"\' }' . "\n";
                                            echo 'options += \'<option value="' . esc_attr($t -> term_id) . '" \' + selected_' . $i . ' + \'>' . esc_html($t -> name) . '</option>\';';
                                        }
                                    ?>

                                    var item = jQuery(
                                        '<div class="s360-build-table-size" id="s360-build-table-size-' + i + '">' +
                                        '<div class="s360-build-table-size-inner">' +
                                        '<a href="javascript:void(null);" class="s360-delete"><?php esc_html_e( 'Delete', 'S360_THEME_SLUG' ); ?></a>' +

                                        '<p class="s360-field">' +
                                        '<label for="s360-' + i + '-category"><?php esc_html_e( 'Category', 'S360_THEME_SLUG' ); ?></label>' +
                                        '<select name="s360-category[]" id="s360-' + i + '-category">' + options + '</select>' +
                                        '</p>' +

                                        '<p class="s360-field">' +
                                        '<label for="s360-' + i + '-title"><?php esc_html_e( 'Title', 'S360_THEME_SLUG' ); ?></label>' +
                                        '<input id="s360-' + i + '-title" name="s360-title[]" value="' + d.title + '" type="text">' +
                                        '</p>' +
                                        '<p class="s360-field s360-upload">' +
                                        '<label for="s360-' + i + '-icon"><?php esc_html_e( 'Icon', 'S360_THEME_SLUG' ); ?></label>' +
                                        '<input id="s360-' + i + '-icon" name="s360-icon[]" value="' + d.icon + '" type="url">' +
                                        '<button type="button"><i class="dashicons dashicons-admin-media"></i> <?php esc_html_e( 'Image', 'S360_THEME_SLUG' ); ?></button>' +
                                        '</p>' +
                                        '<p class="s360-field s360-upload">' +
                                        '<label for="s360-' + i + '-image"><?php esc_html_e( 'Image', 'S360_THEME_SLUG' ); ?></label>' +
                                        '<input id="s360-' + i + '-image" name="s360-image[]" value="' + d.image + '" type="url">' +
                                        '<button type="button"><i class="dashicons dashicons-admin-media"></i> <?php esc_html_e( 'Image', 'S360_THEME_SLUG' ); ?></button>' +
                                        '</p>' +
                                        '<p class="s360-field">' +
                                        '<label for="s360-' + i + '-content"><?php esc_html_e( 'Content', 'S360_THEME_SLUG' ); ?></label>' +
                                        '<textarea id="s360-' + i + '-content" name="s360-content[]" class="s360-height-360">' + d.content + '</textarea>' +
                                        '</p>' +
                                        '</div>' +
                                        '</div>'
                                    );

                                    jQuery( item ).find( 'a.s360-delete' ).on( 'click', function(){
                                        if( confirm( "<?php esc_html_e( 'Delete this table size?', 'S360_THEME_SLUG' ) ?>" ) ){
                                            jQuery( this ).parent('div.s360-build-table-size-inner').parent( 'div.s360-build-table-size').remove();
                                        }
                                    });

                                    jQuery(item).appendTo( container );

                                    new S360Uploader(function(args){
                                		if( args.hasOwnProperty( 'el' ) ){
                                			jQuery( args.el ).find( 'input[type="url"]' ).val( args.attachment.url );
                                		}
                                    });

                                    s360_table_sizes_index++;
                                }
                            }
                        }

                        var TableSizes  = new S360TableSizes( jQuery( '#s360-build-table-sizes' ) );
                        var table_sizes = <?php

                            $table_sizes = get_option( 's360-table-sizes' );

                            if( is_array($table_sizes) && !empty($table_sizes) ){
                                echo json_encode( $table_sizes );
                            }
                            else{
                                echo '{}';
                            }
                        ?>;

                        if( typeof table_sizes === "object" && table_sizes.length ){
                            for (var i in table_sizes) {
                                if( table_sizes.hasOwnProperty(i) )
                                    TableSizes.Add(table_sizes[i]);
                            }
                        }

                        jQuery( 'button#s360-add-new' ).on( 'click', function(){
                            TableSizes.Add({});
                        });
                    }
                });
            </script>
        </div>
        <?php
    }
?>
