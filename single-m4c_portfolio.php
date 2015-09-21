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
				<?PHP
				if(has_post_thumbnail())
					the_post_thumbnail('custom_1', array( 'class'	=> "img-rounded img-responsive center-block featured"));
				?>
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
			<?php foreach(get_attached_media( 'image' ) as $image): ?>
				<?php $image_data =  wp_get_attachment_image_src($image->ID, 'portfolio_1'); ?>
				<p><img src="<?php echo $image_data[0]; ?>" class="img-responsive" /></p>
			<?php endforeach; ?>
		</div>

	</div>
</div>
<?php endwhile; endif; ?>


<?php get_footer(); ?>
