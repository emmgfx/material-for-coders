<?php get_header(); ?>

<div class="big-title">
	<div class="container">
		<h2><? single_cat_title(); ?> <small>(<?=$wp_query->found_posts?> articulos)</small></h2>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">

			<?php if(have_posts()): while(have_posts()): the_post(); ?>

			<div class="article-wrapper">
				<br />
				<h2><a href="<? the_permalink(); ?>"><? the_title(); ?></a></h2>

				<? include 'context.php'; ?>

				<div class="article">
					<? the_content(); ?>
				</div>
				<div align="right">
					<a href="<? the_permalink(); ?>" class="btn btn-primary">Continuar leyendo &rarr;</a>
				</div>
			</div>
			<br />
			<hr />
			<?PHP endwhile; endif; ?>

		</div>

		<!-- <div class="col-md-3 col-md-offset-1">
			<p>You can use this space to create a sidebar</p>
		</div> -->

	</div>
</div>


<?php get_footer(); ?>
