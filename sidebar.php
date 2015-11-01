<?php
$hide_sidebar_xs_window = intval(get_option('hide-sidebar-xs-window')) == 1;
?>
<div class="col-md-3 col-sm-4 col-md-offset-1 sidebar <?php if($hide_sidebar_xs_window){ echo 'hidden-xs'; } ?>">
	<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
		<div class="row">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</div>
	<?php else: ?>
		<h3>Sidebar</h3>
		<p>Add widgets to your sidebar or disable it in the theme settings.</p>
	<?php endif; ?>
</div>
