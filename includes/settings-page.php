<?php

function register_m4c_settings() {
    register_setting( 'm4c-settings', 'footer-phrase' );
    register_setting( 'm4c-settings', 'color-scheme' );
    register_setting( 'm4c-settings', 'sidebar-active' );
    register_setting( 'm4c-settings', 'procastinate-fonts' );
    register_setting( 'm4c-settings', 'hide-sidebar-xs-window' );
    register_setting( 'm4c-settings', 'show-featured-index' );
    register_setting( 'm4c-settings', 'show-featured-single' );
    register_setting( 'm4c-settings', 'show-featured-single' );
    register_setting( 'm4c-settings', 'show-author-box' );
    register_setting( 'm4c-settings', 'show-excerpt-in-lists' );
    register_setting( 'm4c-settings', 'logo-attachment' );
    register_setting( 'm4c-settings', 'blacked-footer' );
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
                <h3><span class="dashicons dashicons-admin-appearance"></span> Color scheme:</h3>
                <?PHP
                $schemes = array(
                    array('Pink', '#E2105D', '#b20d49', '#fbc3d8'),
                    array('Blue-Grey', '#607d8b', '#2597ae', '#dbf3f7'),
                    array('Green', '#18B576', '#128859', '#a6f3d4'),
                    array('Yellow', '#f3c43c', '#f3c43c', '#f3c43c')
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
                    width: 47%;
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
                        $('.logo-wrapper').removeClass('pink blue-grey green yellow').addClass($(this).val().toLowerCase());
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
                .logo-wrapper.yellow img{
                    background: #f3c43c;
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
                'show_author_box' => intval(get_option('show-author-box'), 0) == 1,
                'hide_sidebar_xs_window' => intval(get_option('hide-sidebar-xs-window')) == 1,
                'show_excerpt_in_lists' => intval(get_option('show-excerpt-in-lists')) == 1,
                'procastinate_fonts' => intval(get_option('procastinate-fonts', 1)) == 1,
                'blacked_footer' => intval(get_option('blacked-footer', 0)) == 1,
            );
            ?>

            <div class="card">
                <h3><span class="dashicons dashicons-admin-appearance"></span> Structure and element options</h3>
    			<ul>
    				<li><label><input type="checkbox" name="sidebar-active" value="1" <?php echo ($option['sidebar_active'] ? 'checked' : '');?> /> Show sidebar</label></li>
                    <li><label><input type="checkbox" name="hide-sidebar-xs-window" value="1" <?php echo ($option['hide_sidebar_xs_window'] ? 'checked' : '');?> /> Hide sidebar on small windows (phones).</label></li>
                    <li><label><input type="checkbox" name="show-featured-index" value="1" <?php echo ($option['show_featured_index'] ? 'checked' : '');?> /> Show featured image in index and other posts list</label></li>
                    <li><label><input type="checkbox" name="show-featured-single" value="1" <?php echo ($option['show_featured_single'] ? 'checked' : '');?> /> Show featured image in post</label></li>
                    <li><label><input type="checkbox" name="show-author-box" value="1" <?php echo ($option['show_author_box'] ? 'checked' : '');?> /> Show author box after the article single.</li>
                    <li><label><input type="checkbox" name="show-excerpt-in-lists" value="1" <?php echo ($option['show_excerpt_in_lists'] ? 'checked' : '');?> /> Show excerpt instead of full (or manually clipped) article in lists.</label></li>
                    <li><label><input type="checkbox" name="procastinate-fonts" value="1" <?php echo ($option['procastinate_fonts'] ? 'checked' : '');?> /> Procastinate non-system fonts loading (great for SEO).</label></li>
                    <li><label><input type="checkbox" name="blacked-footer" value="1" <?php echo ($option['blacked_footer'] ? 'checked' : '');?> /> Blacked footer (on any color scheme)</label></li>
    			</ul>
            </div>

            <div class="card">
                <h3><span class="dashicons dashicons-admin-appearance"></span> Portfolio:</h3>
                <?php if(!is_plugin_active('emm-portfolio/emm-portfolio.php')): ?>
                    <p>You don't have the portfolio plugin installed.</p>
                    <p><a target="_blank" class="button" href="https://github.com/emmgfx/emm-portfolio">Download</a></p>
                    <p>If you have old projects, the plugin can import them and you never lose anything.</p>
                <?php else: ?>
                    <?php
                    $projects_per_page = intval(get_option('portfolio_projects_per_page'));
                    if($projects_per_page == false || $projects_per_page == 0)
                        $projects_per_page = get_option('posts_per_page');
                    ?>
        			<p><label>Projects per page:</label></p>
                    <p><input type="text" name="portfolio_projects_per_page" value="<?php echo $projects_per_page; ?>" /></p>
                <?php endif; ?>
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
