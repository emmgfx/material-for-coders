<?php

require_once 'thumbnails.php';

define('THEMES_DIR',	ABSPATH.'wp-content/themes/');
define('THEME_DIR',		THEMES_DIR.'material-for-coders');
define('THEME_DIR_TMP', THEMES_DIR.'material-for-coders-master');
define('THEME_ZIP',		THEMES_DIR.'material-for-coders-master.zip');
define('THEME_ZIP_URL',	'https://github.com/emmgfx/material-for-coders/archive/master.zip');

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

			<br />
			<hr />
			<br />


			<?PHP
			# Get the current version:
			{
				$theme = wp_get_theme();
				$version_current = $theme->Version;
			}

			# Get latest version:
			{

				if(isset($_GET['update_check'])):
					$latest_style_url = 'https://raw.githubusercontent.com/emmgfx/material-for-coders/master/style.css';
					$latest_style_content = file_get_contents($latest_style_url);

					foreach(preg_split("/((\r?\n)|(\r\n?))/", $latest_style_content) as $line){
						if (strpos($line, 'Version') === false) {
							# Version is not in this line.
						} else {
							$version_latest = trim(str_replace('Version:', '', $line));
							break;
						}
					}
				endif;
			}
			?>


			<h3><span class="dashicons dashicons-update"></span> Updater</h3>

			<?php if(isset($_GET['update_check'])): ?>
				<?php $updated = version_compare($version_current, $version_latest); ?>
				<?php if($updated == -1): ?>
					<p><span class="dashicons dashicons-warning"></span> <strong>You have an outdated version</strong> (<?php echo $version_current; ?>). <a href="themes.php?page=m4c-settings&updater">Update to <?php echo $version_latest; ?></a>.</p>

				<?php elseif($updated == 0): ?>
					<p><span class="dashicons dashicons-yes"></span> You have the latest version, <?php echo $version_current; ?>.</p>

				<?php elseif($updated == 1): ?>
					<p>Mmm... something weird has happened... do you have a more recent version than the latest?</p>

				<?php endif; ?>
			<?php elseif(isset($_GET['updater'])): ?>

				<ul>
					<li>
						Downloading...
						<?php $downloaded = download_latest();?>
					</li>
					<li>
						<?php echo ($downloaded ? 'Download complete' : 'Error downloading'); ?>
					</li>
					<?php if($downloaded): ?>
						<li>
							Unpacking...
							<?php $unpacked = unpack_downloaded(); ?>
						</li>
						<li>
							<?php echo ($unpacked ? 'Unpacked' : 'Error unpacking'); ?>
						</li>
						<?php if($unpacked): ?>
							<li>
								Installing...
								<?php $installed = install_unpacked(); ?>
							</li>
							<li>
								<?php echo ($unpacked ? 'Install complete.' : 'Error installing'); ?>
							</li>
						<?php endif; ?>
					<?php endif; ?>
				</ul>


			<?php else: ?>
				<p>I don't like the Wordpress update system, so I prepared an
					auto update against the GitHub repository. You don't have
					to download and override the theme files, only click on
					the link down here to check for updates.</p>
				<p><a href="themes.php?page=m4c-settings&update_check">Check for update</a></p>
			<?php endif; ?>

			<br />
			<hr />
			<br />

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
	add_theme_page( 'Material for coders', 'Material for coders', 'manage_options', 'm4c-settings', 'm4c_settings' );
}

if ( is_admin() ){
    add_action( 'admin_menu', 'm4c_admin_menu' );
    add_action( 'admin_init', 'register_m4c_settings' );
}

add_action( 'init', 'm4c_menus' );
add_action( 'widgets_init', 'm4c_widgets' );

add_theme_support( 'automatic-feed-links' );



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

function download_latest(){

	$rh = fopen(THEME_ZIP_URL, 'rb');
    $wh = fopen(THEME_ZIP, 'w+b');
    if (!$rh || !$wh) {
        return false;
    }

    while (!feof($rh)) {
        if (fwrite($wh, fread($rh, 4096)) === FALSE) {
            return false;
        }
        echo ' ';
        flush();
    }

    fclose($rh);
    fclose($wh);

    return true;

}

function unpack_downloaded(){

	$zip = new ZipArchive;
	$res = $zip->open(THEME_ZIP);
	if ($res === TRUE) {
	  $zip->extractTo(THEMES_DIR);
	  $zip->close();
	  return true;
	} else {
	  return false;
	}
}

function install_unpacked(){
	deltree(THEME_DIR);
	return rename(THEME_DIR_TMP, THEME_DIR);
}

function delTree($dir) {
	$files = array_diff(scandir($dir), array('.','..'));
	foreach ($files as $file) {
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
	}
	return rmdir($dir);
}

?>
