<?php

// add_action( 'init', 'create_post_type' );

function create_post_type() {
	register_post_type( 'm4c_portfolio',
		array(
			'labels' => array(
				'name' => __( 'Projects' ),
				'singular_name' => __( 'Project' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'project'),
			// 'supports' => array( 'title', 'editor', 'thumbnail' ),
			'supports' => array( 'title', 'editor' ),
		)
	);

	register_taxonomy( 'technology', 'm4c_portfolio', array(
		'label' => __( 'Technologies' ),
		'rewrite' => array( 'slug' => 'projects/technology' ),
	));

	register_taxonomy( 'tools', 'm4c_portfolio', array(
		'label' => __( 'Tools' ),
		'rewrite' => array( 'slug' => 'projects/tool' ),
	));

}

?>
