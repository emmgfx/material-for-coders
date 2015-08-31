<?php get_header(); ?>

<div class="big-title">
	<div class="container">
		<h2><?PHP single_cat_title(); ?> <small>(<?PHP echo $wp_query->found_posts?> articulos)</small></h2>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">

			<?php if(have_posts()): while(have_posts()): the_post(); ?>

			<div class="article-wrapper">
				<br />
				<h2><a href="<?PHP the_permalink(); ?>"><?PHP the_title(); ?></a></h2>

				<?PHP get_template_part( 'context' ); ?>

				<div class="article">
					<?PHP the_content(); ?>
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

		<!-- <div class="col-md-3 col-md-offset-1">
			<p>You can use this space to create a sidebar</p>
		</div> -->

	</div>
</div>


<?php get_footer(); ?>
