<?php

require_once('widget_home_portfolio.php');

function m4c_menus() {
    register_nav_menus(
        array(
            'header' => 'Header Menu',
            'blog' => 'Blog Menu',
        )
    );
}

function m4c_widgets() {

    register_sidebar( array(
		'name'          => 'Home widget zone',
		'id'            => 'home',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<div class="big-title"><div class="container"><h2>',
		'after_title'   => '</h2></div></div>',
	) );

    register_sidebar( array(
		'name'          => 'Footer widget zone',
		'id'            => 'footer',
		'before_widget' => '<div class="col-md-4 col-sm-4 col-xs-12"><div class="widget">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar',
		'before_widget' => '<div class="col-md-12 col-md-offset-0 col-xs-10 col-xs-offset-1"><div class="widget">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

}

function mfc_load_widgets() {
	register_widget( 'mfc_widget_portfolio' );
}

add_action( 'widgets_init', 'mfc_load_widgets' );
add_action( 'init', 'm4c_menus' );
add_action( 'widgets_init', 'm4c_widgets' );

?>
