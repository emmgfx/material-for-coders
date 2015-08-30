<?php if ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<h2>Comentarios</h2>
		<p><?php _e( 'Comments are closed here'); ?></p>
	</div>
<?php endif; ?>

<?php if (post_password_required()) : ?>
	<div class="comments">
		<h2>Comentarios</h2>
		<p><?php _e( 'Post is password protected. Enter the password to view any comments.'); ?></p>
	</div>
<?php else: ?>

	<?php if (have_comments()) : ?>
		<div class="comments">
			<h2><?php comments_number(); ?></h2>

			<?php foreach(get_comments(array('post_id' => get_the_ID())) as $comment) : ?>
			<div class="comment clearfix">
				<div class="avatar"><img src="http://0.gravatar.com/avatar/<?=md5($comment->comment_author_email)?>?s=60&r=g&d=mm" class="img-responsive img-circle" /></div>
				<h4 class="name"><a href="<?=$comment->comment_author_url?>"><?=$comment->comment_author?></a></h4>
				<div class="date">Hace <?=human_time_diff( get_the_time('U'), current_time('timestamp') )?></div>
				<div class="content">
					<p><?=nl2br($comment->comment_content)?></p>
				</div>
			</div>
			<? endforeach; ?>

		</div>
	<?php endif; ?>

	<?php comment_form(array(
		'class_submit' => 'btn btn-primary'
	)); ?>

<?php endif; ?>
