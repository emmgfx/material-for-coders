<?php get_header(); ?>

<?php
$option = array(
	'sidebar_active' => intval(get_option('sidebar-active')) == 1,
	'show_featured_index' => intval(get_option('show-featured-index')) == 1,
	'show_featured_single' => intval(get_option('show-featured-single')) == 1,
	'show_author_box' => intval(get_option('show-author-box', 0)) == 1
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
			<div id="post-<?php the_ID(); ?>" <?php post_class(array('article-wrapper')); ?>>
				<?PHP get_template_part( 'context' ); ?>
				<?PHP
				if(has_post_thumbnail() && $option['show_featured_single']):
					the_post_thumbnail('custom_1', array( 'class'	=> "img-rounded img-responsive center-block featured"));
				endif;
				?>
				<div class="article clearfix">
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
					'nextpagelink'     => 'P&aacute;gina siguiente',
					'previouspagelink' => 'P&aacute;gina anterior',
					'pagelink'         => '%',
				)); ?>
				<br />
				<hr />
				<?php endif; ?>

				<?php if($option['show_author_box']): ?>
					<div class="author-box">
						<div class="author-avatar-container">
							<?php echo get_avatar( get_the_author_meta('email'), 80, null, null, array("class" => "img-circle author-avatar-image")); ?>
						</div>
						<h3><?php the_author_meta('display_name'); ?></h3>
						<p><?php the_author_meta('description'); ?></p>
						<?php if(get_the_author_meta('user_url')): ?>
							<div>- <a href="<?php the_author_meta('user_url'); ?>"><?php the_author_meta('user_url'); ?></a></div>
						<?php endif; ?>
					</div>
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
