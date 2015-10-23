<?php

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

add_action( 'init', 'm4c_menus' );
add_action( 'widgets_init', 'm4c_widgets' );

?>
