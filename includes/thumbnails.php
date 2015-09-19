<?PHP
add_theme_support( 'post-thumbnails' );

$my_image_sizes = array(
	array( 'name'=>'custom_1', 'width'=>750, 'height'=>250, 'crop'=>true ),
);

function alx_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ){
    if ( !$crop ) return null; // let the wordpress default function handle this

    $aspect_ratio = $orig_w / $orig_h;
    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);

    $s_x = floor( ($orig_w - $crop_w) / 2 );
    $s_y = floor( ($orig_h - $crop_h) / 2 );

    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}

foreach ( $my_image_sizes as $my_image_size ){
    add_image_size( $my_image_size['name'], $my_image_size['width'], $my_image_size['height'], $my_image_size['crop'] );
    update_option( $my_image_size['name']."_size_w", $my_image_size['width'] );
    update_option( $my_image_size['name']."_size_h", $my_image_size['height'] );
    update_option( $my_image_size['name']."_crop", $my_image_size['crop'] );
}

function my_add_image_sizes( $sizes ){
    global $my_image_sizes;
    foreach ( $my_image_sizes as $my_image_size ){
            $sizes[] = $my_image_size['name'];
    }
    return $sizes;
}

add_filter( 'image_resize_dimensions', 'alx_thumbnail_upscale', 10, 6 );
add_filter( 'intermediate_image_sizes', 'my_add_image_sizes' );

?>
