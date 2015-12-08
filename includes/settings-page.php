<?php

function register_m4c_settings() {
    register_setting( 'm4c-settings', 'footer-phrase' );
    register_setting( 'm4c-settings', 'color-scheme' );
    register_setting( 'm4c-settings', 'sidebar-active' );
    register_setting( 'm4c-settings', 'hide-sidebar-xs-window' );
    register_setting( 'm4c-settings', 'show-featured-index' );
    register_setting( 'm4c-settings', 'show-featured-single' );
    register_setting( 'm4c-settings', 'portfolio_projects_per_page' );
    register_setting( 'm4c-settings', 'show-excerpt-in-lists' );
    register_setting( 'm4c-settings', 'logo-attachment' );
}


function m4c_admin_menu() {
	add_theme_page( 'Material for coders', 'Material for coders', 'manage_options', 'm4c-settings', 'm4c_settings' );
}

function m4c_settings() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}
    wp_enqueue_media();
    ?>
	<div class="wrap">

        <h2>Material for coders settings</h2>

        <form method="post" action="options.php">

            <?PHP settings_fields( 'm4c-settings' ); ?>
            <?PHP do_settings_sections( 'm4c-settings' ); ?>

            <div class="card">
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
    					<p><span class="dashicons dashicons-warning"></span> <strong>You have an outdated version</strong>: <?php echo $version_current; ?></p>
                        <p><a href="themes.php?page=m4c-settings&updater" class="button">Update to <?php echo $version_latest; ?></a></p>

    				<?php elseif($updated == 0): ?>
    					<p><span class="dashicons dashicons-yes"></span> You have the latest version, <?php echo $version_current; ?>.</p>
                        <p><a href="themes.php?page=m4c-settings&updater" class="button">Force update anyway</a></p>

    				<?php elseif($updated == 1): ?>
    					<p>Mmm... something weird has happened... do you have a more recent version than the latest?</p>
                        <p><a href="themes.php?page=m4c-settings&updater" class="button">Force update to <?php echo $version_latest; ?></a></p>

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
                                    <?php if($unpacked): ?>
                                        Install complete.<p><a href="themes.php?page=m4c-settings" class="button">Continue</a></p>
                                    <?php else: ?>
                                        Error installing
                                    <?php endif; ?>
    							</li>
    						<?php endif; ?>
    					<?php endif; ?>
    				</ul>


    			<?php else: ?>
    				<p>I don't like the Wordpress update system, so I prepared an
    					auto update against the GitHub repository.</p>
                    <p>You don't have
    					to download and override the theme files, only click on
    					the link down here to check for updates.</p>
    				<p><a href="themes.php?page=m4c-settings&update_check" class="button">Check for update</a></p>
    			<?php endif; ?>
            </div>

            <div class="card">
                <h3><span class="dashicons dashicons-admin-appearance"></span> Color scheme:</h3>
                <?PHP
                $schemes = array(
                    array('Pink', '#E2105D', '#b20d49', '#fbc3d8'),
                    array('Blue-Grey', '#607d8b', '#2597ae', '#dbf3f7'),
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
                $selected_scheme = strtolower($selected);
                ?>
                <style>
                label.scheme-label{
                    display: inline-block;
                    padding: 3px;
                    background: #FFF;
                    border: 2px solid transparent;
                    width: 30%;
                    border-radius: 5px;
                    transition: all .2s;
                }
                    label.scheme-label div{
                        border-radius: 3px;
                        display: inline-block;
                        width: 100%;
                        color: #FFF;
                        text-align: center;
                        font-weight: bolder;
                        font-size: 16px;
                        padding: 20px 0;
                    }
                input[type="radio"][name="color-scheme"]{
                    display: none;
                }
                input[type="radio"][name="color-scheme"]:checked + label {
                    border: 2px solid #2ED8A7;
                }
                </style>
                <script>
                jQuery(function(){
                    var $ = jQuery;

                    $('input[type="radio"][name="color-scheme"]').change(function(){
                        $('.logo-wrapper').removeClass('pink blue-grey green').addClass($(this).val().toLowerCase());
                    });

                });
                </script>
                <?PHP foreach( $schemes as $scheme ): ?>
                    <input type="radio" id="scheme-<?PHP echo $scheme[0]?>" name="color-scheme" value="<?PHP echo $scheme[0]?>" <?PHP if($selected == $scheme[0]): ?>checked<?PHP endif; ?>>
                    <label class="scheme-label" for="scheme-<?PHP echo $scheme[0]?>">
                        <div style="background-color: <?PHP echo $scheme[1]?>;">
                            <?PHP echo $scheme[0]?>
                        </div>
                    </label>
                <?PHP endforeach; ?>
            </div>

            <div class="card">
                <h3><span class="dashicons dashicons-admin-appearance"></span> Logo:</h3>

                <?php $logo_attachment = get_option('logo-attachment'); ?>

                <style>
                .logo-wrapper img{
                    background: #E6E6E6;
                    padding: 10px;
                    border-radius: 3px;
                    transition: all .2s;
                }
                .logo-wrapper.pink img{
                    background: #E2105D;
                }
                .logo-wrapper.blue-grey img{
                    background: #607d8b;
                }
                .logo-wrapper.green img{
                    background: #18B576;
                }
                </style>

                <?php if(empty($logo_attachment)): ?>
                    <div class="logo-wrapper <?php echo $selected_scheme; ?>"><p>No logo selected.</p></div>
                    <input type="hidden" name="logo-attachment" value="" />
                    <a href="#" class="button logo-change">Change logo</a>
                    <a href="#" class="button logo-remove disabled">Remove logo</a>
                <?php else: ?>
                    <div class="logo-wrapper <?php echo $selected_scheme; ?>">
                        <?php echo wp_get_attachment_image( $logo_attachment, 'logo_1'); ?>
                    </div>
                    <input type="hidden" name="logo-attachment" value="<?php echo intval($logo_attachment); ?>" />
                    <a href="#" class="button logo-change">Change logo</a>
                    <a href="#" class="button logo-remove">Remove logo</a>
                <?php endif; ?>

                    <ul>
                        <li>Should be 350 x 32px max.</li>
                        <li>Remember to save the changes on end.</li>
                    </ul>

                <script>
            	jQuery(document).ready(function() {

            		var $ = jQuery;

            		var file_frame;

            		$(document).on('click', '.logo-change', function( event ){

                        event.preventDefault();

                        if ( file_frame ) {
                            file_frame.open();
                            return;
                        }

                        file_frame = wp.media.frames.file_frame = wp.media({
                            title: jQuery( this ).data( 'uploader_title' ),
                            button: {
                                text: jQuery( this ).data( 'uploader_button_text' ),
                            },
                            multiple: false
                        });

                        file_frame.on( 'select', function() {

                            attachment = file_frame.state().get('selection').first().toJSON();

                            console.log(attachment);

                            if(attachment.width > 350 || attachment.height > 32)
                                alert("The selected image it\'s bigger than 350 x 32px.\n\nCheck it twice before definitely leave it.");

                            $('.logo-wrapper').html('<img src="' + attachment.sizes.full.url + '" style="max-width: 350px; max-height: 39px;" />');
                            $('.logo-remove').removeClass('disabled');
                            $('input[name="logo-attachment"]').val(attachment.id);

                        });

                        file_frame.open();

            		});

            		$(document).on('click', '.logo-remove', function(){
                        $('input[name="logo-attachment"]').val("");
                        $(".logo-wrapper").html('<p>No logo selected.</p>');
                        $('.logo-remove').addClass('disabled');
            			return false;
            		});

            	});
            	</script>
            </div>

            <div class="card">
                <h3><span class="dashicons dashicons-format-quote"></span> Footer phrase:</h3>
                <p>Usually the license</p>
                <p><input style="width: 100%;" type="text" name="footer-phrase" value="<?php echo esc_attr( get_option('footer-phrase') ); ?>" /></p>
            </div>

			<?php
			# Get the options
            $option = array(
            	'sidebar_active' => intval(get_option('sidebar-active')) == 1,
                'show_featured_index' => intval(get_option('show-featured-index')) == 1,
                'show_featured_single' => intval(get_option('show-featured-single')) == 1,
                'hide_sidebar_xs_window' => intval(get_option('hide-sidebar-xs-window')) == 1,
                'show_excerpt_in_lists' => intval(get_option('show-excerpt-in-lists')) == 1
            );
            ?>

            <div class="card">
                <h3><span class="dashicons dashicons-admin-appearance"></span> Structure and element options</h3>
    			<ul>
    				<li><label><input type="checkbox" name="sidebar-active" value="1" <?php echo ($option['sidebar_active'] ? 'checked' : '');?> /> Show sidebar</label></li>
                    <li><label><input type="checkbox" name="hide-sidebar-xs-window" value="1" <?php echo ($option['hide_sidebar_xs_window'] ? 'checked' : '');?> /> Hide sidebar on small windows (phones).</label></li>
                    <li><label><input type="checkbox" name="show-featured-index" value="1" <?php echo ($option['show_featured_index'] ? 'checked' : '');?> /> Show featured image in index and other posts list</label></li>
                    <li><label><input type="checkbox" name="show-featured-single" value="1" <?php echo ($option['show_featured_single'] ? 'checked' : '');?> /> Show featured image in post</label></li>
                    <li><label><input type="checkbox" name="show-excerpt-in-lists" value="1" <?php echo ($option['show_excerpt_in_lists'] ? 'checked' : '');?> /> Show excerpt instead of full (or manually clipped) article in lists.</label></li>
    			</ul>
            </div>

            <div class="card">
                <h3><span class="dashicons dashicons-admin-appearance"></span> Portfolio:</h3>
                <?php
                $projects_per_page = intval(get_option('portfolio_projects_per_page'));
                if($projects_per_page == false || $projects_per_page == 0)
                    $projects_per_page = get_option('posts_per_page');
                ?>
    			<p><label>Projects per page:</label></p>
                <p><input type="text" name="portfolio_projects_per_page" value="<?php echo $projects_per_page; ?>" /></p>
            </div>

            <?php submit_button(); ?>

        </form>
	</div>
    <?PHP
}

if ( is_admin() ){
    add_action( 'admin_menu', 'm4c_admin_menu' );
    add_action( 'admin_init', 'register_m4c_settings' );
}

?>
