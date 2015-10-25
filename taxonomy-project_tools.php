<?php get_header(); ?>

<div class="big-title">
	<div class="container">
		<h2><?php single_cat_title(); ?></h2>
	</div>
</div>

<?php get_header(); ?>

<div class="container">
	<div class="row">
		<?php
		if(have_posts()): while(have_posts()): the_post();
		include(locate_template('portfolio_list_item.php'));
		endwhile; endif;
		?>
	</div>
	<?PHP get_template_part('pagination'); ?>
</div>

<?php get_footer(); ?>
