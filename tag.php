<?php get_header(); ?>

<?php
$option = array(
	'sidebar_active' => intval(get_option('sidebar-active')) == 1,
	'show_featured_index' => intval(get_option('show-featured-index')) == 1,
	'show_featured_single' => intval(get_option('show-featured-single')) == 1,
	'show_excerpt_in_lists' => intval(get_option('show-excerpt-in-lists')) == 1,
);
?>

<div class="big-title">
	<div class="container">
		<h2><?PHP single_cat_title(); ?> (<?PHP echo $wp_query->found_posts?>)</h2>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="<?php echo ($option['sidebar_active'] ? 'col-md-8 col-sm-8' : 'col-md-8 col-md-offset-2'); ?>">

			<div id="articles">
				<?PHP get_template_part('post-loop'); ?>
			</div>

			<?php
			$show_pagination = true;

			if(class_exists('Jetpack'))
				if(Jetpack::is_module_active('infinite-scroll'))
					$show_pagination = false;

			if($show_pagination)
				get_template_part('pagination');

			?>
		</div>

		<?php
		if($option['sidebar_active']):
			get_sidebar();
		endif;
		?>

	</div>
</div>


<?php get_footer(); ?>
