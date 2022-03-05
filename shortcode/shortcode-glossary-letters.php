<?php

add_shortcode( 'glossary_letters', 'elodin_output_glossary_letters' );
function elodin_output_glossary_letters( $atts ) {
    ob_start();
    
    $letters = range( 'a', 'z');
    
    echo '<ul class="letters-list">';
    
        foreach( $letters as $letter ) {
            printf( '<li><a class="letter" href="#" data-letter="%s">%s</a></li>', $letter, $letter );
        }
        
    echo '</ul>';
    
    ?>
    
    <script type="text/javascript">
        
        jQuery(document).ready(function( $ ) {
            
            $( '#search-words' ).submit( function(e) {
                $( '.letter' ).removeClass( 'active' );
            });
	
            $( '.letter' ).click( function(e) {
                e.preventDefault();
                
                $( '#keyword' ).val( '' );
                
                var letter = $( this ).data( 'letter' );
                                
                $( '.letter' ).removeClass( 'active' );
                $( this ).addClass( 'active' );
                
                letterfetch( letter );
            });
            
        });        
                
        function letterfetch( letter ) {
                                    
            jQuery(document).ready(function( $ ) {
                                                    
                var ajaxscript = { ajax_url : '/wp-admin/admin-ajax.php' }
                
                $.ajax({
                    url: ajaxscript.ajax_url,
                    type: 'post',
                    data: { 
                        action: 'word_letter_search', 
                        letter: letter
                    },
                    success: function(data) {
                        $('#wordsearchresults').html( data );
                    }
                });
            });            

        }
    </script>
    
    <?php
    
    return ob_get_clean();
}

add_filter( 'posts_where', 'elodin_glossary_filter_first_letter', 10, 2 );
function elodin_glossary_filter_first_letter( $where, $query ) {
    global $wpdb;

    $starts_with = esc_sql( $query->get( 'starts_with' ) );

    if ( $starts_with ) {
        $where .= " AND $wpdb->posts.post_title LIKE '$starts_with%'";
    }

    return $where;
}


add_action('wp_ajax_word_letter_search' , 'word_letter_search');
add_action('wp_ajax_nopriv_word_letter_search','word_letter_search');
function word_letter_search(){
    
    $args =  array( 
        'posts_per_page'    => -1,
        'starts_with'       => esc_attr( $_POST['letter'] ),
        'post_type'         => array('words' ),
        'fields'            => 'ids',
        'orderby'           => 'title',
        'order'             => 'ASC',
        'update_post_meta_cache' => false, 
        'update_post_term_cache' => false,
        'no_found_rows' => true, 
    );
        
    $the_query = new WP_Query( $args );
    
    if( $the_query->have_posts() ) {
        
        while( $the_query->have_posts() ): $the_query->the_post(); 

            do_action( 'glossary_do_word_in_archive' );

        endwhile;
        
        wp_reset_postdata();
        
    } else {
        printf( 'Whoops! Nothing found starting with the letter <strong>%s</strong>.', esc_attr( $_POST['letter'] ) );
    }

    die();
}
