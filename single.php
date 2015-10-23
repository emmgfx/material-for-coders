<?php get_header(); ?>

<?php
$option = array(
	'sidebar_active' => intval(get_option('sidebar-active')) == 1,
	'show_featured_index' => intval(get_option('show-featured-index')) == 1,
	'show_featured_single' => intval(get_option('show-featured-single')) == 1
);
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<div class="big-title">
	<div class="container">
		<h2><?PHP the_title(); ?></h2>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="<?php echo ($option['sidebar_active'] ? 'col-md-8 col-sm-8' : 'col-md-8 col-md-offset-2'); ?>">

			<div class="article-wrapper <?php echo ($option['sidebar_active'] ? 'sidebar-active' : ''); ?>">
				<?PHP get_template_part( 'context' ); ?>
				<?PHP
				if(has_post_thumbnail() && $option['show_featured_single']):
					the_post_thumbnail('custom_1', array( 'class'	=> "img-rounded img-responsive center-block featured"));
				endif;
				?>
				<div class="article">
					<?PHP the_content(); ?>
				</div>

				<br />
				<hr />
				<br />
				<?php global $numpages; if ( is_singular() && $numpages > 1 ): ?>
				<?php wp_link_pages(array(
					'before'           => '<div align="right">Seguir leyendo: ',
					'after'            => '</div>',
					'link_before'      => '',
					'link_after'       => '',
					'next_or_number'   => 'number',
					'separator'        => ', ',
					'nextpagelink'     => 'Página siguiente',
					'previouspagelink' => 'Página anterior',
					'pagelink'         => '%',
				)); ?>
				<br />
				<hr />
				<?php endif; ?>

				<?php comments_template(); ?>

			</div>
			<?php endwhile; endif; ?>

		</div>

		<?php
		if($option['sidebar_active']):
			get_sidebar();
		endif;
		?>

	</div>
</div>


<?php get_footer(); ?>
