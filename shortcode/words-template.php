<?php

add_action( 'glossary_do_word_in_archive', 'glossary_word_in_archive' );
function glossary_word_in_archive() {
    
    global $post;
    
    $title = get_the_title();
    $content = apply_filters( 'the_content', get_the_content() );
    $part_of_speech = get_post_meta( get_the_ID(), 'part_of_speech', true );
    
    echo '<details class="entry">';
		
        if ( $title ) {
            echo '<summary>';
                echo $title;
                
                if ( $part_of_speech )
                    printf( ' <span class="part-of-speech">%s</span>', $part_of_speech );
                    
            echo '</summary>';
        }
            
        echo '<div class="the-content">';
        
            echo $content;
        
            edit_post_link();
        
        echo '</div>';
        

    echo '</details>';
    
}