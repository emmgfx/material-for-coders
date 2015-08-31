<div id="comments">
	<h2><?php comments_number(); ?></h2>
	<?php if($comments) : ?>
		<div class="comments">
	        <?php
			wp_list_comments(array(
				'style'             => 'div',
				'type'              => 'all',
				'reply_text'        => 'Responder',
				'avatar_size'       => 60,
				'format'            => 'html5',
			));
			?>
			<div class="navigation">
				<?php
				paginate_comments_links( array( 'type' => 'list' ) );
				?>
		    </div>
	    </div>
	<?php else : ?>
		<br />
	    <p>Puedes dejar el primero :&nbsp;)</p>
		<br />
		<hr />
	<?php endif; ?>
</div>

<?php comment_form(array(
	'class_submit' => 'btn btn-primary'
)); ?>
