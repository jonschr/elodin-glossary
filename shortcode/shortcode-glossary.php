<?php

add_shortcode( 'glossary', 'elodin_output_glossary' );
function elodin_output_glossary( $atts ) {
    ob_start();
    
    echo '<div class="search_result" id="wordsearchresults">';
        
    $args = array(
        'post_type'                 => 'words',
        'posts_per_page'            => '-1',
        'fields'                    => 'ids',
        'orderby'                   => 'title',
        'order'                     => 'ASC',
        'update_post_meta_cache'    => false, 
        'update_post_term_cache'    => false, 
        'no_found_rows'             => true, 
    );

    // The Query
    $custom_query = new WP_Query( $args );

    // The Loop
    if ( $custom_query->have_posts() ) {

        while ( $custom_query->have_posts() ) {
            
            $custom_query->the_post();
            
            do_action( 'glossary_do_word_in_archive' );

        }
        
        // Restore postdata
        wp_reset_postdata();

    }
    
    echo '</div>';
    
    return ob_get_clean();
}
