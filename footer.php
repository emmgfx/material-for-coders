<?php
$option = array(
	'procastinate_fonts' => intval(get_option('procastinate-fonts', 1)) == 1,
	'blacked_footer' => intval(get_option('blacked-footer', 0)) == 1,
);
?>

		<div class="menu-mobile-wrapper">
			<div class="menu-mobile">
				<form action="<?php echo home_url(); ?>" type="get">
					<input type="text" class="search form-control" name="s" value="<?PHP echo get_search_query();?>" placeholder="<?php echo __('Search', 'material-for-coders'); ?>...">
				</form>
				<?PHP
				wp_nav_menu(array(
					'theme_location'  => 'header',
					'menu'            => 'header',
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => 'list-unstyled',
					'menu_id'         => 'header',
					'echo'            => true,
					'fallback_cb'     => '',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'depth'           => -1,
					'walker'          => ''
				));
				?>
			</div>
		</div>

		<div class="footer-wrapper">
			<?php if ( is_active_sidebar( 'footer' ) ) : ?>
			<div class="footer <?php if($option['blacked_footer']){ echo "black"; } ?>">
				<div class="container">
					<div class="row">
						<?php dynamic_sidebar( 'footer' ); ?>
					</div>
				</div>
			</div>
			<?php else: ?>
			<br />
			<br />
			<?php endif; ?>

			<div class="license <?php if($option['blacked_footer']){ echo "black"; } ?>">
				<div class="container">
					<?PHP $footer_phrase = get_option('footer-phrase'); ?>
					<?PHP if( $footer_phrase === false || empty($footer_phrase) ): ?>
						<p><?PHP echo bloginfo('name')?>, <?PHP echo date('Y')?>. Theme <a href="https://github.com/emmgfx/material-for-coders" target="_blank">Material for Coders</a></p>
					<?PHP else: ?>
						<p><?PHP echo $footer_phrase?></p>
					<?PHP endif; ?>

				</div>
			</div>
		</div>

		<?php if($option['procastinate_fonts']): ?>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,500,700,300' rel='stylesheet' type='text/css'>
		<?php endif; ?>
		<?php wp_footer(); ?>
	</body>
</html>
