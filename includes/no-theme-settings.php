<?php

add_action( 'comment_form_before', 'enqueue_comment_reply' );
add_action( 'after_setup_theme', 'language_setup');
add_action( 'after_setup_theme', 'init_infinite_scroll' );
add_action( 'after_setup_theme', 'theme_slug_setup' );

if ( ! isset( $content_width ) ) {
	$content_width = 600;
}

function enqueue_comment_reply() {
    if ( get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

add_theme_support( 'automatic-feed-links' );

function theme_slug_setup() {
   add_theme_support( 'title-tag' );
}

function language_setup(){
    load_theme_textdomain('material-for-coders', get_template_directory() . '/languages');
}

function init_infinite_scroll() {
    add_theme_support( 'infinite-scroll', array(
        'container' 	=> 'articles',
        'render'    	=> 'infinite_scroll_render',
        'footer'    	=> false,
		'posts_per_page'=> 1,
    ) );
}

function infinite_scroll_render() {
    get_template_part( 'post-loop' );
}

add_action( 'wp_enqueue_scripts', 'loadMfcJs' );
function loadMfcJs() {
	wp_enqueue_script( 'headroom.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/headroom/0.9.3/headroom.min.js');
	wp_enqueue_script( 'jQuery.headroom.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/headroom/0.9.3/jQuery.headroom.min.js', array('jquery') );
	wp_enqueue_script( 'js.js', get_template_directory_uri().'/assets/js/js.js', array('jquery') );
}
?>
