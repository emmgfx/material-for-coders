<?php get_header(); ?>

<?php
$option = array(
	'sidebar_active' => intval(get_option('sidebar-active')) == 1,
);
?>

<div class="big-title">
	<div class="container">
		<h2><?PHP single_cat_title(); ?> <small>(<?PHP echo $wp_query->found_posts?> articulos)</small></h2>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="<?php echo ($option['sidebar_active'] ? 'col-md-9 col-sm-8' : 'col-md-8 col-md-offset-2'); ?>">

			<?php if(have_posts()): while(have_posts()): the_post(); ?>

			<div class="article-wrapper">
				<br />
				<h2><a href="<?PHP the_permalink(); ?>"><?PHP the_title(); ?></a></h2>

				<?PHP get_template_part( 'context' ); ?>

				<div class="article">
					<?PHP the_content(false); ?>
				</div>
				<div align="right">
					<a href="<?PHP the_permalink(); ?>" class="btn btn-primary">Continuar leyendo &rarr;</a>
				</div>
			</div>
			<br />
			<hr />
			<?PHP endwhile; endif; ?>

			<?PHP get_template_part('pagination'); ?>
		</div>

		<?php if($option['sidebar_active']): ?>
		<div class="col-md-3 col-sm-4 sidebar">
			<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
				<div class="row">
					<?php dynamic_sidebar( 'sidebar' ); ?>
				</div>
			<?php else: ?>
				<h3>Sidebar</h3>
				<p>Add widgets to your sidebar or disable it in the theme settings.</p>
			<?php endif; ?>
		</div>
		<?php endif; ?>

	</div>
</div>


<?php get_footer(); ?>
