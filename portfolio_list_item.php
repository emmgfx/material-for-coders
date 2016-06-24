<?php
if(has_post_thumbnail()):

	the_post_thumbnail('custom_1', array( 'class'	=> "img-rounded img-responsive center-block featured"));

else:

	$images_json = get_post_meta( get_the_ID(), 'emm_portfolio_images_order', true );

	if(!is_array(@json_decode($images_json, true)))
		$images_json = json_encode(array());

	$images_array = json_decode($images_json);


	if(isset($images_array[0])):
		$poster_meta = wp_get_attachment_metadata($images_array[0]);
		if($poster_meta != false):
			$project_poster = wp_get_attachment_image_src( $images_array[0], 'portfolio_1' );
		endif;
	endif;

endif;

$project_categories = wp_get_post_terms( $post->ID, 'project_categories' );

?>

<div class="col-md-4 col-sm-6 col-xs-10 col-xs-offset-1 col-sm-offset-0">
	<div class="project">
		<a href="<?php the_permalink(); ?>"><img src="<?php echo $project_poster[0]; ?>" width="<?php echo $project_poster[1]; ?>" height="<?php echo $project_poster[2]; ?>" class="img-responsive" /></a>
		<div class="project-date pull-right"><?php echo date('Y', get_post_time()); ?></div>
		<h3 class="project-title"><?php the_title(); ?></h3>
		<ul class="project-categories list-unstyled list-inline">
			<?php foreach($project_categories as $category): ?>
				<li><a href="<?php echo get_site_url(); ?>/projects/category/<?php echo $category->slug; ?>">#<?php echo $category->name; ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
