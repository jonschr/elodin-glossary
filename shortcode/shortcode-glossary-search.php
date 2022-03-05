<?php

add_shortcode( 'glossary_search', 'elodin_output_glossary_search' );
function elodin_output_glossary_search( $atts ) {
    ob_start();
    
    //* The search form
    echo '<div class="word-search-wrap">';
        echo '<form id="search-words" action="/" method="post" autocomplete="off">';
            echo '<input type="text" name="s" placeholder="Search the glossary..." id="keyword" class="input_search">';
            echo '<button id="glossary-search">Search</button>';
        echo '</form>';
    echo '</div>';
    
    ?>
    
    <script type="text/javascript">
        
        jQuery(document).ready(function( $ ) {
            
            function throttle(func, interval) {
                var lastCall = 0;
                return function() {
                    var now = Date.now();
                    if (lastCall + interval < now) {
                        lastCall = now;
                        return func.apply(this, arguments);
                    }
                };
            }
                        
            $("#keyword").on("keypress", throttle(function(event) {
                resetURL();
                fetch();
            }, 100));
	
            $( '#search-words' ).submit( function(e) {            
                e.preventDefault();                
            });
                        
        });
        
        function resetURL() {
            //* reset the URL
            var currURL = window.location.href;
            var beforeQueryString = currURL.split("?")[0];  
            console.log( beforeQueryString );
            history.replaceState( null, null, beforeQueryString );
        }
                
        function fetch() {
                        
            jQuery(document).ready(function( $ ) {
                                
               
                
                //* do our query
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
                        
                        $( '.letter' ).removeClass( 'active' );
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
        'post_type'         => array('words' ),
        'fields'            => 'ids',
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
        printf( 'Whoops! Nothing found with <strong>%s</strong> in our words or definitions.', $_POST['keyword'] );
    }

    die();
}
