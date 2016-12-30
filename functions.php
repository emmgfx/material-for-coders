<?php

require_once 'includes/thumbnails.php';
require_once 'includes/settings-page.php';
require_once 'includes/widgets-and-menus.php';
require_once 'includes/no-theme-settings.php';

// Código para mostrar el extracto en vez de todo el post en página de inicio, categoría, etiquetas
function mis_extractos($content = false) {
    // Si es portada, archivo o resultados de búsqueda
	if(is_front_page() || is_archive() || is_search()) :
		global $post;
		$content = $post->post_excerpt;
	// Si se especifica un extracto en el widget del editor
		if($content) :
			$content = apply_filters('the_excerpt', $content);
	// Si no especificas un extracto
		else :
			$content = $post->post_content;
			$excerpt_length = 55;
			$words = explode(' ', $content, $excerpt_length + 1);
			if(count($words) > $excerpt_length) :
				array_pop($words);
				array_push($words, '...');
				$content = implode(' ', $words);
			endif;
			$content = '<p>' . $content . '</p>';
		endif;
	endif;
	// Y nos aseguramos de volver al contenido
	return $content;
}
add_filter('the_content', 'mis_extractos');
?>
