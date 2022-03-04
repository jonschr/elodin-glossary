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
    
    return ob_get_clean();
}
