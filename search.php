<?php get_header(); ?>

<?php
$option = array(
		'sidebar_active' 		=> intval(get_option('sidebar-active')) 		== 1,
		'show_featured_index' 	=> intval(get_option('show-featured-index')) 	== 1,
		'show_featured_single' 	=> intval(get_option('show-featured-single')) 	== 1,
		'show_excerpt_in_lists'	=> intval(get_option('show-excerpt-in-lists'))	== 1,
	);
?>

<div class="big-title">
	<div class="container">
		<h2><?php echo sprintf( '%s '.__('results for', 'material-for-coders'), $wp_query->found_posts ); echo '"'.get_search_query().'"'; ?></h2>
	</div>
</div>

<div class="container">
	<?php
	if(have_posts()):
	?>
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
	<?php else: ?>
		<br />
		<div align="center">
			<i class="material-icons icon-empty-results">error_outline</i>
		</div>
		<br />
		<div align="center">
			<a href="<?php echo home_url(); ?>" class="btn btn-lg btn-primary">&larr; <?php echo __('Return home', 'material-for-coders'); ?></a>
		</div>
	<?php endif; ?>
</div>


<?php get_footer(); ?>
