<?php get_header(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<div class="big-title">
	<div class="container">
		<h2><?PHP the_title(); ?></h2>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">


			<div class="article-wrapper">

				<?PHP # include 'context.php'; ?>

				<br />
				
				<?PHP
				if(has_post_thumbnail())
					the_post_thumbnail('custom_1', array( 'class'	=> "img-rounded img-responsive center-block featured"));
				?>

				<div class="article">
					<?PHP the_content(); ?>
				</div>
			</div>
			<br />
			<hr />
			<?php endwhile; endif; ?>

		</div>

		<!-- <div class="col-md-3 col-md-offset-1">
			<p>You can use this space to create a sidebar</p>
		</div> -->

	</div>
</div>


<?php get_footer(); ?>
