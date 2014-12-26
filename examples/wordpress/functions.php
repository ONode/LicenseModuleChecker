<?php
/* 	SunRain Theme's Functions
	Copyright: 2014, D5 Creation, www.d5creation.com
	Based on the Simplest D5 Framework for WordPress
	Since SunRain 1.0
*/

//	Set the content width based on the theme's design and stylesheet.
if (!isset($content_width)) $content_width = 584;

// 	Load the D5 Framework Optios Page
define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/');
require_once dirname(__FILE__) . '/inc/options-framework.php';
require dirname(__FILE__) . '/hkmcheck/wp_check_lock.php';

// 	Tell WordPress for wp_title in order to modify document title content
function sunrain_filter_wp_title($title)
{
    $site_name = get_bloginfo('name');
    $filtered_title = $site_name . $title;
    return $filtered_title;
}

add_filter('wp_title', 'sunrain_filter_wp_title');

function sunrain_setup()
{
    register_nav_menus(array('main-menu' => "Main Menu", 'top-menu' => "Top Menu"));

// 	Tell WordPress for the Feed Link
    add_editor_style();
    add_theme_support('automatic-feed-links');

// 	This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images

    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(150, 150, true); // default Post Thumbnail dimensions (cropped)
    // additional image sizes
    // delete the next line if you do not need additional image sizes
    add_image_size('category-thumb', 300, 9999); //300 pixels wide (and unlimited height)


// 	WordPress 3.4 Custom Background Support	
    $sunrain_custom_background = array('default-color' => 'ffffff', 'default-image' => get_template_directory_uri() . '/images/back1.png',);
    add_theme_support('custom-background', $sunrain_custom_background);

// 	WordPress 3.4 Custom Header Support				
    $sunrain_custom_header = array(
        'default-image' => get_template_directory_uri() . '/images/logo.png',
        'random-default' => false,
        'width' => 300,
        'height' => 90,
        'flex-height' => false,
        'flex-width' => false,
        'default-text-color' => '000000',
        'header-text' => false,
        'uploads' => true,
        'wp-head-callback' => '',
        'admin-head-callback' => '',
        'admin-preview-callback' => '',
    );
    add_theme_support('custom-header', $sunrain_custom_header);
}

add_action('after_setup_theme', 'sunrain_setup');

// 	Functions for adding script
function sunrain_enqueue_scripts()
{
    wp_enqueue_style('sunrain-style', get_stylesheet_uri(), false);
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('jquery');
    wp_enqueue_script('sunrain-menu-style', get_template_directory_uri() . '/js/menu.js');

    wp_register_style('sunrain-gfonts1', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800', false);
    wp_enqueue_style('sunrain-gfonts1');
    if (is_front_page()):
        wp_enqueue_script('sunrain-main-slider', get_template_directory_uri() . '/js/jquery.fractionslider.min.js');
        wp_enqueue_style('sunrain-main-slider-css', get_template_directory_uri() . '/css/fractionslider.css');
    endif;
    if (of_get_option('responsive', '0') == '1') : wp_enqueue_style('sunrain-responsive', get_template_directory_uri() . '/style-responsive.css'); endif;
}

add_action('wp_enqueue_scripts', 'sunrain_enqueue_scripts');

// 	Functions for adding some custom code within the head tag of site
function sunrain_custom_code()
{
    ?>
	
	<style type="text/css">
	.site-title a, 
	.site-title a:active, 
	.site-title a:hover {
	
	color: #<?php echo get_header_textcolor(); ?>;
	}
			
<?php

}


function sunrain_post_meta()
{ ?>
	<div class="post-meta"> <span class="post-edit"> <?php edit_post_link('Edit'); ?></span> <span class="post-author"> <?php the_author_posts_link(); ?> </span>
	<span class="post-tag"> <?php the_tags('<span class="post-tag-icon"></span>', ', '); ?> </span> <span class="post-category"> <?php the_category(', '); ?> </span> <span class="post-comments"> <?php comments_popup_link('No Comments &#187;', 'One Comment &#187;', '% Comments &#187;'); ?> </span>
	</div> 
	
	<?php
}

//	Registers the Widgets and Sidebars for the site
function sunrain_widgets_init()
{

    register_sidebar(array(
        'name' => 'Primary Sidebar',
        'id' => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Secondary Sidebar',
        'id' => 'sidebar-2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Footer Area One',
        'id' => 'sidebar-3',
        'description' => 'An optional widget area for your site footer',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Footer Area Two',
        'id' => 'sidebar-4',
        'description' => 'An optional widget area for your site footer',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Footer Area Three',
        'id' => 'sidebar-5',
        'description' => 'An optional widget area for your site footer',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => 'Footer Area Four',
        'id' => 'sidebar-6',
        'description' => 'An optional widget area for your site footer',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

}

add_action('widgets_init', 'sunrain_widgets_init');

add_filter('the_title', 'sunrain_title');
function sunrain_title($title)
{
    if ('' == $title) {
        return '(Untitled)';
    } else {
        return $title;
    }
}

