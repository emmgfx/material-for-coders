<?php

if ( ! isset( $content_width ) ) {
	$content_width = 600;
}

function enqueue_comment_reply() {
    if ( get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'comment_form_before', 'enqueue_comment_reply' );


function baw_hack_wp_title_for_home( $title ){
	if( empty( $title ) && ( is_home() || is_front_page() ) ):
		return get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
	else:
		return get_bloginfo( 'name' ) . ' | ' . $title;
	endif;
	return $title;
}
add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );

add_theme_support( 'automatic-feed-links' );

?>
