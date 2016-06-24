<?php
$option = array(
	'show_featured_index' => intval(get_option('show-featured-index')) == 1,
	'show_excerpt_in_lists' => intval(get_option('show-excerpt-in-lists')) == 1,
);
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(array('article-wrapper')); ?>>
		<?PHP
		if(has_post_thumbnail() && $option['show_featured_index']):
			echo '<a href="'.get_the_permalink().'">';
			the_post_thumbnail('custom_1', array( 'class'	=> "img-rounded img-responsive center-block featured"));
			echo '</a>';
		else:
			echo '<br />';
		endif;
		?>
		<h2><a href="<?PHP the_permalink(); ?>"><?PHP the_title(); ?></a></h2>

		<?PHP get_template_part( 'context' ); ?>

		<div class="article clearfix">
			<?PHP ($option['show_excerpt_in_lists'] ? the_excerpt() : the_content(false)); ?>
		</div>
		<div align="right">
			<a href="<?PHP the_permalink(); ?>" class="btn btn-primary"><?php echo __('Read more...', 'material-for-coders'); ?></a>
		</div>
	</div>
	<br />
	<hr />

<?PHP endwhile; endif; ?>
