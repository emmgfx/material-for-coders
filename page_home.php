<?php
/**
 * Template Name: Home
 */
?>

<?php get_header(); ?>

<!-- <?php the_title(); ?></h2>
	</div>
</div> -->

	<?php if ( is_active_sidebar( 'home' ) ) : ?>
		<?php dynamic_sidebar( 'home' ); ?>
	<?php endif ?>

<?php get_footer(); ?>
