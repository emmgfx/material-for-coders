<?php get_header(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/simple-lightbox.min.js"></script>
<script>
jQuery(function($) {
	var gallery = $('a.gallery').simpleLightbox();
});
</script>

<div class="big-title">
	<div class="container">
		<h2><?PHP the_title(); ?></h2>
	</div>
</div>

<br />
<br />

<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 col-md-4 col-md-offset-0">
			<?php
			$post_classes = array('article-wrapper');
			if($option['sidebar_active'])
				$post_classes[] = 'sidebar-active';
			?>

			<div id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>

				<div class="article clearfix">
					<?PHP the_content(); ?>
				</div>

				<?php
				$technologies	= get_the_terms($post->ID, 'project_technologies');
				$tools			= get_the_terms($post->ID, 'project_tools');
				?>

				<div class="project-meta">
					<?php if($technologies != false): ?>
					<h4>Technologies</h4>
					<ul class="list-unstyled list-inline">
						<?php foreach ($technologies as $taxonomy ): ?>
							<li><a href="<?php echo get_term_link($taxonomy); ?>"><?php echo $taxonomy->name; ?></a></li>
						<?php endforeach;?>
					</ul>
					<?php endif; ?>

					<?php if($tools != false): ?>
					<h4>Tools</h4>
					<ul class="list-unstyled list-inline">
						<?php foreach ($tools as $taxonomy ): ?>
							<li><a href="<?php echo get_term_link($taxonomy); ?>"><?php echo $taxonomy->name; ?></a></li>
						<?php endforeach;?>
					</ul>
					<?php endif; ?>

				</div>

				<br class="visible-xs visible-sm" />
			</div>

		</div>
		<div class="col-md-7 col-md-offset-1 col-sm-10 col-sm-offset-1">
			<?php
			$images_json = get_post_meta( $post->ID, 'emm_portfolio_images_order', true );
			if(!is_array(@json_decode($images_json, true)))
				$images_json = json_encode(array());

			foreach(json_decode($images_json) as $attachment_id):

				$attachment_meta = wp_get_attachment_metadata($attachment_id);
				if($attachment_meta == false)
					continue;

				$image_m_data = wp_get_attachment_image_src( $attachment_id, 'portfolio_2', '', array(
					'class' => 'img-responsive'
				));

				$image_f_data = wp_get_attachment_image_src( $attachment_id, 'full', '', array(
					'class' => 'img-responsive'
				));

				echo '<p>';
				echo '<a href="'.$image_f_data[0].'" class="gallery" title="'.get_the_title().'">';
				echo '<img src="'.$image_m_data[0].'" width="'.$image_m_data[1].'" height="'.$image_m_data[2].'" alt="'.get_the_title().'" class="img-responsive" />';
				echo '</a>';
				echo '</p>';
				?>
			<?php endforeach; ?>

		</div>

	</div>
</div>
<?php endwhile; endif; ?>


<?php get_footer(); ?>
