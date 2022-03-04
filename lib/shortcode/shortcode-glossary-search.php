<?php

add_shortcode( 'glossary_search', 'elodin_output_glossary_search' );
function elodin_output_glossary_search( $atts ) {
    ob_start();
    
    //* The search form
    echo '<div class="word-search-wrap">';
        echo '<form id="search-words" action="/" method="post" autocomplete="off">';
            echo '<input type="text" name="s" placeholder="Search the glossary..." id="keyword" class="input_search" onkeyup="fetch()">';
            echo '<button id="glossary-search">Search</button>';
        echo '</form>';
    echo '</div>';
    
    ?>
    
    <script type="text/javascript">
        
        jQuery(document).ready(function( $ ) {
	
            $( '#search-words' ).submit( function(e) {
                e.preventDefault();
            });
            
        });        
                
        function fetch() {
                        
            jQuery(document).ready(function( $ ) {
                    
                var ajaxscript = { ajax_url : '/wp-admin/admin-ajax.php' }
                
                $.ajax({
                    url: ajaxscript.ajax_url,
                    type: 'post',
                    data: { 
                        action: 'word_search_fetch', 
                        keyword: $('#keyword').val() 
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

add_action('wp_ajax_word_search_fetch' , 'word_search_fetch');
add_action('wp_ajax_nopriv_word_search_fetch','word_search_fetch');
function word_search_fetch(){
    
    $args =  array( 
        'posts_per_page'    => -1,
        's'                 => esc_attr( $_POST['keyword'] ),
        'post_type'         => array('words' )
    );

    $the_query = new WP_Query( $args );
    
    if( $the_query->have_posts() ) :
        
        while( $the_query->have_posts() ): $the_query->the_post(); 

            do_action( 'glossary_do_word_in_archive' );

        endwhile;
        
        wp_reset_postdata();  
    endif;

    die();
}
