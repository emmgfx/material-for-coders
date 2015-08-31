<?php

require_once 'thumbnails.php';

if ( ! isset( $content_width ) ) {
	$content_width = 600;
}

function enqueue_comment_reply() {
    if ( get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'comment_form_before', 'enqueue_comment_reply' );


function baw_hack_wp_title_for_home( $title ){
	if( empty( $title ) && ( is_home() || is_front_page() ) ):
		return get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
	else:
		return get_bloginfo( 'name' ) . ' | ' . $title;
	endif;
	return $title;
}
add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );

function m4c_menus() {
    register_nav_menus(
        array(
            'header' => 'Header Menu',
            'blog' => 'Blog Menu',
        )
    );
}

function m4c_widgets() {

	register_sidebar( array(
		'name'          => 'Footer widget zone',
		'id'            => 'footer',
		'before_widget' => '<div class="col-md-4 col-sm-4 col-xs-12"><div class="widget">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

}


function m4c_settings() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}
    ?>
	<div class="wrap">
        <h2>Material 4 Coders Settings</h2>
        <br />

        <form method="post" action="options.php">

            <?PHP settings_fields( 'm4c-settings' ); ?>
            <?PHP do_settings_sections( 'm4c-settings' ); ?>
            <hr />
            <h3><span class="dashicons dashicons-admin-customizer"></span> Color scheme:</h3>
            <?PHP
            $schemes = array(
                array('Pink', '#E2105D', '#b20d49', '#fbc3d8'),
                array('Turquoise', '#33b9d3', '#2597ae', '#dbf3f7'),
                array('Green', '#18B576', '#128859', '#a6f3d4'),
            );
            $default = $schemes[0][0];
            $selected = get_option('color-scheme');
            $selected_valid = false;
            foreach( $schemes as $scheme ):
                if($scheme[0] === $selected):
                    $selected_valid = true;
                endif;
            endforeach;
            $selected = ($selected_valid ? $selected : $default);
            ?>
            <style>
            label.scheme-label{
                display: inline-block;
                padding: 5px;
                background: #FFF;
                border: 2px solid transparent;
            }
            input[type="radio"][name="color-scheme"]{
                display: none;
            }
            input[type="radio"][name="color-scheme"]:checked + label {
                border: 2px solid #2ED8A7;
            }
            </style>
            <?PHP foreach( $schemes as $scheme ): ?>
                <input type="radio" id="scheme-<?PHP echo $scheme[0]?>" name="color-scheme" value="<?PHP echo $scheme[0]?>" <?PHP if($selected == $scheme[0]): ?>checked<?PHP endif; ?>>
                <label class="scheme-label" for="scheme-<?PHP echo $scheme[0]?>">
                    <div style="display: inline-block; width: 100px; height: 50px; background-color: <?PHP echo $scheme[1]?>;"></div><!--
                    --><div style="display: inline-block; width: 50px; height: 50px; background-color: <?PHP echo $scheme[2]?>;"></div><!--
                    --><div style="display: inline-block; width: 50px; height: 50px; background-color: <?PHP echo $scheme[3]?>;"></div>
                    <div>
                    <?PHP echo $scheme[0]?>
                    </div>
                </label>
            <?PHP endforeach; ?>

            <hr >

            <h3><span class="dashicons dashicons-star-filled"></span> Logo:</h3>
            <p>Should be 170px width approx. and 30px height.</p>
            <p>Coming soon.</p>

            <hr >

            <h3><span class="dashicons dashicons-format-quote"></span> Footer phrase (usually the license):</h3>
            <input style="width: 80%;" type="text" name="footer-phrase" value="<?php echo esc_attr( get_option('footer-phrase') ); ?>" />

            <?php submit_button(); ?>

        </form>
	</div>
    <?PHP
}

function register_m4c_settings() {
    register_setting( 'm4c-settings', 'footer-phrase' );
    register_setting( 'm4c-settings', 'color-scheme' );
}


function m4c_admin_menu() {
	add_theme_page( 'Material 4 Coders', 'Material 4 Coders', 'manage_options', 'm4c-settings', 'm4c_settings' );
}

if ( is_admin() ){
    add_action( 'admin_menu', 'm4c_admin_menu' );
    add_action( 'admin_init', 'register_m4c_settings' );
} else {
    add_action( 'init', 'm4c_menus' );
}

add_action( 'widgets_init', 'm4c_widgets' );

add_theme_support( 'automatic-feed-links' );
?>
