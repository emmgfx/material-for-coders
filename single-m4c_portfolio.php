<?php get_header(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

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
			<div class="article-wrapper">

				<div class="article">
					<?PHP the_content(); ?>
				</div>

				<div class="project-meta">
					<h4>Technologies</h4>
					<ul class="list-unstyled list-inline">
						<? foreach (get_terms(array('technology'))  as $taxonomy ): ?>
							<li><a href="<?php echo get_term_link($taxonomy); ?>"><?php echo $taxonomy->name; ?></a></li>
						<? endforeach;?>
					</ul>

					<h4>Tools</h4>
					<ul class="list-unstyled list-inline">
						<? foreach (get_terms(array('tools'))  as $taxonomy ): ?>
							<li><a href="<?php echo get_term_link($taxonomy); ?>"><?php echo $taxonomy->name; ?></a></li>
						<? endforeach;?>
					</ul>
				</div>
			</div>

		</div>
		<div class="col-md-7 col-md-offset-1 col-sm-10 col-sm-offset-1">
			<?php
			$images_json = get_post_meta( $post->ID, '_m4c_portfolio_images_order', true );
			if(!is_array(@json_decode($images_json, true)))
				$images_json = json_encode(array());

			foreach(json_decode($images_json) as $attachment_id):

				$attachment_meta = wp_get_attachment_metadata($attachment_id);
				if($attachment_meta == false)
					continue;

				echo '<p>'.wp_get_attachment_image( $attachment_id, 'portfolio_1', $icon, 'img-responsive' ).'</p>';
				?>
			<?php endforeach; ?>

		</div>

	</div>
</div>
<?php endwhile; endif; ?>


<?php get_footer(); ?>
