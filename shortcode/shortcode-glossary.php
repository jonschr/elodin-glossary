<?php

add_shortcode( 'glossary', 'elodin_output_glossary' );
function elodin_output_glossary( $atts ) {
    ob_start();
    
    echo '<div class="search_result" id="wordsearchresults">';
        
        $args = [
            'post_type'                 => 'words',
            'posts_per_page'            => '500',
            'fields'                    => 'ids',
            'orderby'                   => 'title',
            'order'                     => 'ASC',
            'update_post_meta_cache'    => false, 
            'update_post_term_cache'    => false, 
            'no_found_rows'             => true, 
        ];

        //* if there's a "letter" parameter in the URL, go ahead and use that instead, giving those permanent links
        if ( isset( $_GET["letter"] ) ) {
            $letter = htmlspecialchars($_GET["letter"] );
            $args['starts_with'] = $letter;
        }
            
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

        } else {
            echo 'Whoops! Looks like we didn\'t find anything!'; 
        }
    
    echo '</div>';
    
    return ob_get_clean();
}
