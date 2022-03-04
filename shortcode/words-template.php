<?php

add_action( 'glossary_do_word_in_archive', 'glossary_word_in_archive' );
function glossary_word_in_archive() {
    
    global $post;
    
    $title = get_the_title();
    $content = apply_filters( 'the_content', get_the_content() );
    
    echo '<details class="entry">';
		
        if ( $title )
            printf( '<summary>%s</summary>', $title );
            
        echo '<div class="the-content">';
        
            echo $content;
        
            edit_post_link();
        
        echo '</div>';
        

    echo '</details>';
    
}