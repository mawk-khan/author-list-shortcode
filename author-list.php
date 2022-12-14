/**
 * Shortcode to render Author List.
 *
 * By: Wajid Khan
 */
function authors_list_sc( $atts = false, $content = false ) {

    // if no atts supplied make it an empty array
    if ( ! $atts ) $atts = array();
    // default values
    $defaults = array(
        'columns' => '4',
        'skip_empty' => 'yes',
        'amount' => false,
        'roles' => '',
    );
    // merge settings
    $settings = array_merge( $defaults, $atts );

    // roles
    if ( ! empty( $settings['roles'] ) ) {
        $atts['role__in'] = explode( ',', $settings['roles'] );
        unset( $atts['who'] );
        unset( $atts['capability'] );
    }
    // get authors order by post count
    $authors_ids = get_users( $atts );

    // start output buffer
    ob_start();
    $item_class = '';
    switch ( $settings['columns'] ) {
        case '4':
            $item_class .= 'authors-list-col-4';
            break;
        case '3':
            $item_class .= 'authors-list-col-3';
            break;
        case '2':
            $item_class .= 'authors-list-col-2';
            break;
    }
    $count = 0;
    ?>
    <div class="authors-list-items authors-list-clearfix authors-list-cols-<?php echo esc_attr( $settings['columns'] ); ?>"><?php
        // loop through each author
        foreach ( $authors_ids as $author_id ) : $count++;
            $posts_url = get_author_posts_url( $author_id->ID );
            ?>
            <div class="authors-list-item authors-list-item-clearfix authors-list-col <?php echo esc_attr( $item_class ); ?>">
                <div class="authors-list-item-thumbnail">
                    <a href="<?php echo esc_url( $posts_url ); ?>"><?php echo get_avatar($author_id->user_email, ''); ?></a>
                </div>

                <div class="authors-list-item-main">
                    <p class="authors-list-item-title"><a href="<?php echo esc_url( $posts_url ); ?>"><?php echo esc_html( $author_id->display_name ); ?></a></p>
                </div>
            </div>
                <?php
        endforeach; ?>
    </div><!-- authors-list-items -->
    <?php

    $output = ob_get_contents();
    ob_end_clean();

    return $output;

}
add_shortcode( 'authors_list', 'authors_list_sc' );
