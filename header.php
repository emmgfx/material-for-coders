<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!--
    Material for Coders is a free Wordpress Theme developed by Josep Viciana (@emmgfx).
    The theme was designed by me, doing my own adaptation of the material design
    principles.

    All the code is open source and you can improve it in his repository, and I
    hope you make it, but anyway, you should respect the license terms indicated
    on the LICENSE file, placed in the root and available in the repository.

    The MIT License (MIT)

    Copyright (c) 2015 Josep Viciana

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.
    -->

    <title><?php wp_title(''); ?></title>
    <meta charset="<?php bloginfo('charset'); ?>">
	<link href="<?PHP echo get_template_directory_uri(); ?>/assets/img/icons/favicon.ico" rel="shortcut icon">
	<link href="<?PHP echo get_template_directory_uri(); ?>/assets/img/icons/touch.png" rel="apple-touch-icon-precomposed">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php bloginfo('description'); ?>">
    <meta name="expires" content="<?php echo gmdate ("D, d M Y H:i:s", time() + 60*60*24*7); ?>">
    <meta http-equiv="Cache-control" content="public">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <?PHP
    switch(get_option('color-scheme')){
        case 'Green':
            echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/style-green.css" />';
            echo '<meta name="theme-color" content="#18B576">';
            break;
        case 'Blue-Grey':
            echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/style-bluegrey.css" />';
            echo '<meta name="theme-color" content="#33b9d3">';
            break;
        default:
            echo '<link rel="stylesheet" href="'.get_stylesheet_uri().'" />';
            echo '<meta name="theme-color" content="#CC1C52">';
    }
    ?>

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

    <div class="header-placeholder"></div>
    <div class="header">

        <div class="container">
            <div class="row">

                <div class="col-md-9 col-sm-12">

                    <div class="title-wrapper">
                        <a href="#" class="mobile-menu-toggler hidden-md hidden-lg"><i class="fa fa-fw fa-navicon"></i></a>
                        <h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name');?></a></h1>
                    </div>

					<?PHP
					wp_nav_menu(array(
                    	'theme_location'  => 'header',
                    	'menu'            => 'header',
                    	'container'       => '',
                    	'container_class' => '',
                    	'container_id'    => '',
                    	'menu_class'      => 'primary-menu list-unstyled list-inline hidden-sm hidden-xs',
                    	'menu_id'         => 'header',
                    	'echo'            => true,
                    	'fallback_cb'     => '',
                    	'before'          => '',
                    	'after'           => '',
                    	'link_before'     => '',
                    	'link_after'      => '',
                    	'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    	'depth'           => -1,
                    	'walker'          => ''
                    ));
					?>
                </div>

                <div class="col-md-3 col-sm-12 hidden-sm hidden-xs" align="right">
                    <!-- Search form -->
                    <form action="<?php echo home_url(); ?>" type="get">
                        <input type="text" class="search form-control" name="s" value="<?PHP echo get_search_query();?>">
                        <i class="fa fa-search"></i>
                    </form>
                </div>


            </div>
        </div>

    </div>

    <?PHP if ( is_home() || is_category() || is_tag() ){ ?>
        <div class="menu-2">
            <a href="#" class="menu-2-toggler visible-xs"><i class="fa fa-lg fa-caret-down fa-fw"></i> Categor&iacute;as</a>
            <div class="container">
                <?PHP
                wp_nav_menu(array(
                    'theme_location'  => 'blog',
                    'menu'            => 'blog',
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'list-unstyled list-inline collapsed',
                    'menu_id'         => 'blog',
                    'echo'            => true,
                    'fallback_cb'     => '',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'           => -1,
                    'walker'          => ''
                ));
                ?>
            </div>
        </div>
    <?PHP } ?>
