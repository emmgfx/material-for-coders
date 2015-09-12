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

	// Auto update things:

	if(function_exists('wp_get_theme')){
	    $theme_data = wp_get_theme(get_option('template'));
	    $theme_version = $theme_data->Version;
	} else {
	    $theme_data = get_theme_data( TEMPLATEPATH . '/style.css');
	    $theme_version = $theme_data['Version'];
	}
	$theme_base = get_option('template');

    ?>
	<div class="wrap">
        <h2>Material for coders settings</h2>
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

            <h3><span class="dashicons dashicons-format-quote"></span> Footer phrase (usually the license):</h3>
            <input style="width: 80%;" type="text" name="footer-phrase" value="<?php echo esc_attr( get_option('footer-phrase') ); ?>" />

			<hr >

            <h3><span class="dashicons dashicons-format-quote"></span> Theme updates</h3>
            <ul>
				<li>
					Current version: <?php echo $theme_version; ?>
				</li>
				<li>
					<?php $last_version = get_last_commit_theme_version(); ?>
					Last version: <?php echo $last_version; ?>
				</li>
				<li>
					<?PHP
					switch(version_compare($theme_version, $last_version)){
						case -1:
							echo 'Update available. <a href="update">Update &rarr;</a>';
						break;
						case 0:
							echo 'Update not available';
						break;
						case 1:
							echo 'What?';
						break;
					}
					?>
				</li>
			</ul>

            <?php submit_button(); ?>

        </form>
	</div>
    <?PHP
}

function get_last_commit_theme_version(){

	// $branches = get_content_from_github('https://api.github.com/repos/emmgfx/material-for-coders/branches');
	//
	// var_dump($branches);
	//
	// foreach($branches as $branch){
	// 	if($branch['name'] == 'master'){
	// 		$master = $branch;
	// 	}
	// }

	// echo '<pre>';
	// print_r($branch);
	// echo '</pre>';

	// echo 'https://api.github.com/repos/emmgfx/material-for-coders/commits/' . $master['commit']['sha'];

	// $commit = get_content_from_github('https://api.github.com/repos/emmgfx/material-for-coders/commits/' . $master['commit']['sha']);

	// echo '<pre>';
	// print_r($commit);
	// echo '</pre>';

	// GET /repos/:owner/:repo/contents/:path
	// $style_file = get_content_from_github('https://api.github.com/repos/emmgfx/material-for-coders/contents/style.css');

	$style_file = file_get_contents('https://raw.githubusercontent.com/emmgfx/material-for-coders/master/style.css?rand='.rand(0,999));

	foreach(preg_split("/((\r?\n)|(\r\n?))/", $style_file) as $line){
	    if(strpos($line, 'Version') === false){
		}else{
			$remote_version = str_replace("Version: ", "", $line);
			return trim($remote_version);
			exit;
		}
	}
}

function get_content_from_github($url) {
	try {
	    $ch = curl_init();

	    if (FALSE === $ch)
	        throw new Exception('failed to initialize');

	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "https://github.com/emmgfx/");

	    $content = json_decode(curl_exec($ch), true);

		return $content;

	    if (FALSE === $content)
	        throw new Exception(curl_error($ch), curl_errno($ch));

	} catch(Exception $e) {
	    trigger_error(sprintf('Curl failed with error #%d: %s', $e->getCode(), $e->getMessage()), E_USER_ERROR);
	}
}

function register_m4c_settings() {
    register_setting( 'm4c-settings', 'footer-phrase' );
    register_setting( 'm4c-settings', 'color-scheme' );
}


function m4c_admin_menu() {
	add_theme_page( 'Material for coders', 'Material for coders', 'manage_options', 'm4c-settings', 'm4c_settings' );
}

if ( is_admin() ){
    add_action( 'admin_menu', 'm4c_admin_menu' );
    add_action( 'admin_init', 'register_m4c_settings' );
}

add_action( 'init', 'm4c_menus' );
add_action( 'widgets_init', 'm4c_widgets' );

add_theme_support( 'automatic-feed-links' );








function mm_update_theme($themes)
{
    $args = array(
            'path' => ABSPATH.'wp-content/themes/',
            'preserve_zip' => false
    );

    foreach($themes as $theme)
    {
            mm_theme_download($theme['path'], $args['path'].$theme['name'].'.zip');
            mm_theme_unpack($args, $args['path'].$theme['name'].'.zip');
            // mm_theme_activate($theme['install']);
    }
}
function mm_theme_download($url, $path)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    if(file_put_contents($path, $data))
            return true;
    else
            return false;
}
function mm_theme_unpack($args, $target)
{
    if($zip = zip_open($target))
    {
            while($entry = zip_read($zip))
            {
                    $is_file = substr(zip_entry_name($entry), -1) == '/' ? false : true;
                    $file_path = $args['path'].zip_entry_name($entry);
                    if($is_file)
                    {
                            if(zip_entry_open($zip,$entry,"r"))
                            {
                                    $fstream = zip_entry_read($entry, zip_entry_filesize($entry));
                                    file_put_contents($file_path, $fstream );
                                    chmod($file_path, 0777);
                                    //echo "save: ".$file_path."<br />";
                            }
                            zip_entry_close($entry);
                    }
                    else
                    {
                            if(zip_entry_name($entry))
                            {
                                    mkdir($file_path);
                                    chmod($file_path, 0777);
                                    //echo "create: ".$file_path."<br />";
                            }
                    }
            }
            zip_close($zip);
    }
    if($args['preserve_zip'] === false)
    {
            unlink($target);
    }
}

$themes = array(
    array('name' => 'jetpack', 'path' => 'https://github.com/emmgfx/material-for-coders/archive/master.zip'),
);
mm_update_theme($themes);


?>
