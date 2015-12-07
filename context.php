<?PHP
$max_categories = 2;
$max_tags = 3;
?>
<ul class="context list-unstyled list-inline">

	<li class="date"><i class="material-icons">&#xE916;</i> <?PHP the_time(get_option( 'date_format' )); ?></li>

	<?PHP $categories = get_the_category(); ?>
	<?PHP if($categories){ ?>
		<li class="categories"><i class="material-icons">&#xE2C8;</i>
			<?PHP
			foreach($categories as $index => $category) {
				if($index < $max_categories){
					echo '<a href="'.get_category_link($category->cat_ID).'">'.$category->name.'</a>';
					if($index+1 < count($categories)){
						echo ', ';
					}
				}else if($index == $max_categories){
					echo '...';
				}
			}
			?>
		</li>
	<?PHP } ?>

	<?PHP $posttags = get_the_tags(); ?>
	<?PHP if($posttags){ ?>
		<li class="tags"><i class="material-icons">&#xE893;</i>
			<?PHP
			foreach($posttags as $index => $tag) {
				if($index < $max_tags){
					echo '<a href="'.get_tag_link($tag->term_id).'">#'.$tag->name.'</a>';
					if($index+1 < count($posttags)){
						echo ', ';
					}
				}else if($index == $max_tags){
					echo '...';
				}
			}
			?>
		</li>
	<?PHP } ?>

	<?PHP if(get_comments_number() > 0){ ?>
	<li><i class="material-icons">&#xE8AF;</i> <a href="<?php the_permalink() ?>/#comments"><?PHP comments_number( 'Sin comentarios', '1 comentario', '% comentarios' ) ?></a></li>
	<?PHP } ?>
</ul>
