<?php
/**
 * Template Name: Portfolio Index
 */
?>

<?php get_header(); ?>

<div class="big-title">
	<div class="container">
		<h2><?php the_title(); ?></h2>
	</div>
</div>

<div class="container">
	<div class="row">

		<?php
		global $post; // required
		$args = array('post_type' => 'm4c_portfolio');
		$custom_posts = get_posts($args);
		foreach($custom_posts as $post) : setup_postdata($post);
			include(locate_template('portfolio_list_item.php'));
		endforeach;
		?>
	</div>
</div>

<?php get_footer(); ?>
