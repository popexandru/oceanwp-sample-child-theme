<?php
    /**
     *  Template Name: Team
     */

get_header(); ?>

	<?php do_action( 'ocean_before_content_wrap' ); ?>

	<div id="content-wrap" class="container clr">

		<?php do_action( 'ocean_before_primary' ); ?>

		<div id="primary" class="content-area clr">

			<?php do_action( 'ocean_before_content' ); ?>

			<div id="content" class="site-content clr">

				<?php do_action( 'ocean_before_content_inner' ); ?>

				<?php
                    $col    = 3;   // 2, 3, 4, 5
                    $ln     = 130;

                    $wp_query = new WP_Query([
                        'post_type'         => 'team-member',
                        'posts_per_page'    => intval(get_option('posts_per_page')),
                        'paged'             => max( 1, get_query_var( '_page' ) )
                    ]);

                    if ( $wp_query -> have_posts() ){

                        echo '<div id="' . esc_attr($id) . '" class="s360-tm-wrapper">';
                        echo '<div class="s360-tm cols-' . absint($col) . '">';

                        foreach( $wp_query -> posts as $p ) {
                            echo '<div class="s360-tm-member-wrapper col">';
                            echo '<div class="s360-tm-member">';

                            $excerpt = trim(strip_tags($p -> post_excerpt));

                            if( $ln < strlen($excerpt) )
                                echo '<a href="javascript:void(null);" class="s360-tm-close">&times;</a>';

                            $url = esc_url(get_post_meta( $p -> ID, 's360-tm-url', true ));

                            $thumbnail          = get_post( get_post_thumbnail_id( $p ) );
                            $has_post_thumbnail = has_post_thumbnail( $p ) && isset( $thumbnail -> ID ) && wp_attachment_is( 'image', $thumbnail );

                            if( $has_post_thumbnail ){
                                if( !empty($url) ){
                                    echo '<div class="s360-tm-avatar">';
                                    echo '<a href="' . esc_url($url) . '" title="' . esc_attr( get_the_title( $p ) ) . '">';
                                    echo get_the_post_thumbnail( $p, [100, 100] );
                                    echo '</a>';
                                    echo '</div>';
                                }
                                else{
                                    echo '<div class="s360-tm-avatar">';
                                    echo get_the_post_thumbnail( $p, [100, 100] );
                                    echo '</div>';
                                }
                            }

                            echo '<div class="s360-tm-head">';

                            if( !empty($url) ){
                                echo '<h3 class="s360-tm-title">';
                                echo '<a href="' . esc_url($url) . '" title="' . esc_attr( get_the_title( $p ) ) . '">' . get_the_title( $p ) . '</a>';
                                echo '</h3>';
                            }

                            else{
                                echo '<h3 class="s360-tm-title">' . get_the_title( $p ) . '</h3>';
                            }

                            $occupation = esc_html(trim(get_post_meta( $p -> ID, 's360-tm-occupation', true )));

                            if( !empty($occupation) )
                                echo '<div class="s360-tm-ocupation">' . esc_html($occupation) . '</div>';

                            $phone = esc_html(get_post_meta( $p -> ID, 's360-tm-phone', true ));

                            if( !empty($phone) )
                                echo '<div class="s360-tm-phone"><i class="fa fa-mobile-alt"></i>' . esc_html($phone) . '</div>';

                            $email = is_email(get_post_meta( $p -> ID, 's360-tm-email', true ));

                            if( !empty($email) ){
                                echo '<div class="s360-tm-email">';
                                echo '<a href="mailto:' . is_email($email) . '"><i class="fa fa-at"></i>' . is_email($email) . '</a>';
                                echo '</div>';
                            }

                            echo '</div>';

                            echo '<div class="s360-tm-body">';
                            echo '<p>';

                            if( $ln < strlen($excerpt) ){
                                echo mb_substr($excerpt, 0, $ln);
                                echo '<span class="s360-tm-excerpt-wrapper">';
                                echo '<span class="s360-tm-excerpt">';
                                echo mb_substr($excerpt, $ln, -1);
                                echo '</span>';
                                echo '<span class="s360-tm-readmore"><a href="javascript:void(null);">' . esc_html__( 'See more →', 'S360_THEME_SLUG' ) . '</a></span>';
                                echo '</span>';
                            }

                            else{
                                echo $excerpt;
                            }

                            echo '</p>';
                            echo '</div>';

                            $facebook   = esc_url(get_post_meta( $p -> ID, 's360-tm-facebook', true ));
                            $twitter    = esc_url(get_post_meta( $p -> ID, 's360-tm-twitter', true ));
                            $instagram  = esc_url(get_post_meta( $p -> ID, 's360-tm-instagram', true ));

                            if( !(empty($facebook) && empty($twitter) && empty($instagram)) ){
                                echo '<div class="s360-tm-socials">';

                                if( !empty($facebook) )
                                    echo '<a href="' . esc_url($facebook) . '" class="facebook"><i class="fab fa-facebook-f"></i></a>';

                                if( !empty($twitter) )
                                    echo '<a href="' . esc_url($twitter) . '" class="twitter"><i class="fab fa-twitter"></i></a>';

                                if( !empty($instagram) )
                                    echo '<a href="' . esc_url($instagram) . '" class="instagram"><i class="fab fa-instagram"></i></a>';

                                echo '</div>';
                            }

                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</div>';
                        echo '</div>';

                        $args = [
                            'mid_size'              => 2,
                            'prev_text'             => '&larr;',
                            'next_text'             => '&rarr;',
                            'screen_reader_text'    => ''
                        ];

                        $pagination = get_the_posts_pagination( $args );

                        if( !empty( $pagination ) ){
                            echo '<div class="s360-list-pagination">';
                            echo $pagination;
                            echo '</div>';
                        }
                    }

                    wp_reset_query();
				?>

				<?php do_action( 'ocean_after_content_inner' ); ?>

			</div><!-- #content -->

			<?php do_action( 'ocean_after_content' ); ?>

		</div><!-- #primary -->

		<?php do_action( 'ocean_after_primary' ); ?>

	</div><!-- #content-wrap -->

	<?php do_action( 'ocean_after_content_wrap' ); ?>

<?php get_footer(); ?>
