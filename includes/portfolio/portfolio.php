<?php

add_action( 'init', 'create_post_type' );

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

add_action( 'add_meta_boxes', 'page_meta_boxes' );
function page_meta_boxes()
{

    global $_wp_post_type_features;

    add_meta_box(
        $id     =   'page_heading_meta_box',
        $title  =   __('Images'),
        $callback   = 'render_m4c_portfolio_images_metabox',
        $post_type  =   'm4c_portfolio',
        $context    =   'normal',
        $priority   =   'core'
    );
}

function render_m4c_portfolio_images_metabox(){
?>
<div class="uploader">
	<a href="#" class="upload_image_button">Add images to project</a>
	<div class="images-list">

	</div>
</div>
<script>

var file_frame;

jQuery('.upload_image_button').live('click', function( event ){

	event.preventDefault();

	if ( file_frame ) {
		file_frame.open();
		return;
	}

	file_frame = wp.media.frames.file_frame = wp.media({
		title: jQuery( this ).data( 'uploader_title' ),
		button: {
			text: jQuery( this ).data( 'uploader_button_text' ),
		},
		multiple: true
	});

	file_frame.on( 'select', function() {
		attachments = file_frame.state().get('selection').toJSON();

		console.log(attachments[0]);

		for(i = 0; i < attachments.length; i++){
			jQuery(".uploader .images-list").append('<img src="' + attachments[i].sizes.thumbnail.url+ '" />');
		}

	});

	file_frame.open();
});
</script>
<?
}
?>
