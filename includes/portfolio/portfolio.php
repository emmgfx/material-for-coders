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
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);

	register_taxonomy( 'project_categories', 'm4c_portfolio', array(
		'label' => __( 'Categories' ),
		'rewrite' => array( 'slug' => 'projects/category'),
	));

	register_taxonomy( 'project_technologies', 'm4c_portfolio', array(
		'label' => __( 'Technologies' ),
		'rewrite' => array( 'slug' => 'projects/technology' ),
	));

	register_taxonomy( 'project_tools', 'm4c_portfolio', array(
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

function render_m4c_portfolio_images_metabox($post){
?>
<div class="uploader">
	<?php
	wp_nonce_field( 'm4c_portfolio_images_metabox_data', 'm4c_portfolio_images_metabox_nonce' );
	$images_json = get_post_meta( $post->ID, '_m4c_portfolio_images_order', true );
	if(!is_array(@json_decode($images_json, true)))
		$images_json = json_encode(array());
	?>

	<p><a href="#" class="upload_image_button button button-primary">Add images to project</a></p>
	<div class="images-list">
		<?php foreach(json_decode($images_json) as $attachment_id): ?>

			<?php
			$attachment_meta = wp_get_attachment_metadata($attachment_id);
			if($attachment_meta == false)
				continue;
			?>
			<div class="image" data-id="<?php echo $attachment_id; ?>">
				<img src="<?php echo wp_get_attachment_thumb_url($attachment_id); ?>" />
				<a href="#" class="button delete">Remove</a>
			</div>
		<?php endforeach; ?>
	</div>

	<input type="hidden" id="m4c_portfolio_images_order" name="m4c_portfolio_images_order" value="<?php echo esc_attr( $images_json ); ?> " />
</div>
<style>
.images-list{
	margin-top: 20px;
	overflow: auto;
}
.images-list .image{
	margin: 0 15px 15px 0;
    padding: 5px;
    background: #FFF;
    border: 1px solid #DCDCDC;
	border-radius: 2px;
	float: left;
}
.images-list .image img{
	width: 150px;
	height: 150px;
}
.images-list a.delete{
	display: block;
	text-align: center;
}
</style>
<script>

jQuery(document).ready(function() {

	var $ = jQuery;

	var file_frame;

	$(document).on('click', '.upload_image_button', function( event ){

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

			for(i = 0; i < attachments.length; i++){

				var image = '<img src="' + attachments[i].sizes.thumbnail.url+ '" />';
				var bt_delete = '<a href="#" class="button delete">Remove</a>';
				var container = '<div class="image" data-id="' + attachments[i].id + '">' + image + bt_delete + '</div>'

				$(".uploader .images-list").append(container);
			}

			updateImagesJSONField();

		});

		file_frame.open();
	});

	$(document).on('click', '.uploader .images-list div.image a.button.delete', function(){
		$(this).closest('div.image').hide(500, function(){
			$(this).remove();
			updateImagesJSONField();
		});
		return false;
	});

	$( ".images-list" ).sortable({
		update: function( event, ui ) {
			updateImagesJSONField();
		}
	});

	function getImagesJSON(){

		var image_ids = [];

		$('.images-list div.image').each(function(index, value){
			var id = $(this).attr('data-id');
			image_ids.push(id);
		});

		return JSON.stringify(image_ids);
	}

	function updateImagesJSONField(){
		$('#m4c_portfolio_images_order').val(getImagesJSON());
	}

});

</script>
<?
}

function m4c_portfolio_save_metadata( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['m4c_portfolio_images_metabox_nonce'] ) ) {
		echo 'nonce not set';
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['m4c_portfolio_images_metabox_nonce'], 'm4c_portfolio_images_metabox_data' ) ) {
		echo 'nonce not verified';
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		echo 'doing autosave';
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			echo 'current user cant edit this page';
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			echo 'current user cant edit this post';
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if ( ! isset( $_POST['m4c_portfolio_images_order'] ) ) {
		echo 'm4c_portfolio_images_order not set';
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['m4c_portfolio_images_order'] );

	// var_dump($my_data);

	// Update the meta field in the database.
	update_post_meta( $post_id, '_m4c_portfolio_images_order', $my_data );
}
add_action( 'save_post', 'm4c_portfolio_save_metadata' );
?>
