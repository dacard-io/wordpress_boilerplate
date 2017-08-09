<?php
/**
 * Theme Functions
 * 
 * This file contains functions that set up the theme and add any extra
 * or custom functionality.
 * 
 * @package WordPress
 * @version 1.0
 */



/**
 * Maximum width allowed for any content
 * 
 * @since 1.0
 */
if ( ! isset( $content_width ) ) {
    $content_width = 660;
}
// bp namespace is for "boilerplate". Change for whatever theme you create
if ( ! function_exists( 'bp_setup' ) ):
/**
 * bp Theme Setup
 * 
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 * 
 * @since 1.0
 */
function bp_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on twentyfifteen, use a find and replace
     * to change 'twentyfifteen' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'bp', get_template_directory() . '/languages' );

    // Add RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    /*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
    add_theme_support( 'title-tag' );

    /*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 825, 510, true );

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus( array(
        'primary-nav' => __( 'Primary Navigation', 'bp' ),
        'top-links'  => __( 'Top Bar Links', 'bp' ),
        'footer-links' => __( 'Footer Links', 'bp'),
    ) );

    /*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
    ) );

}
endif; // bp_setup
add_action( 'after_setup_theme', 'bp_setup' );


/**
 * Load required stylesheets & scripts
 * @since 1.0
 */
function bp_enqueue_style() {
    wp_enqueue_style('main-css', get_template_directory_uri() . '/assets/css/theme.css');
    wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css');
}

function bp_enqueue_script() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/theme.js', array(), '1', true);
}

add_action( 'wp_enqueue_scripts', 'bp_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'bp_enqueue_script' );


/*
 * Registers widget areas
 *
 * @since 1.0
 *
 * @return void
 */
function bp_widgets_init() {
     // register_sidebar( array(
     //     'name'          => __( 'Footer Widget Area', 'holstein' ),
     //     'id'            => 'footer-widget',
     //     'description'   => __( 'Appears on the bottom of every page.', 'holstein' ),
     //     'before_widget' => '<div class="col">',
     //     'after_widget'  => '</div>',
     //     'before_title'  => '<h2>',
     //     'after_title'   => '</h2>'
     // ) );

     register_sidebar( array(
         'name'          => __( 'Right Sidebar Widget Area', 'bp' ),
         'id'            => 'right-sidebar',
         'description'   => __( 'Appears on the right side of the blog index.', 'bp' ),
         'before_widget' => '<div id="%1$s" class="widget %2$s">',
         'after_widget'  => '</div>',
         'before_title'  => '<h4 class="widget-title">',
         'after_title'   => '</h4>'
     ) );

     // register_sidebar( array(
     //     'name'          => __( 'Left Sidebar Widget Area', 'holstein' ),
     //     'id'            => 'left-sidebar',
     //     'description'   => __( 'Appears on the left side of pages', 'holstein' ),
     //     'before_widget' => '<div id="%1$s" class="area %2$s">',
     //     'after_widget'  => '</div>',
     //     'before_title'  => '<h3>',
     //     'after_title'   => '</h3>'
     // ) );     
}

add_action( 'widgets_init', 'bp_widgets_init' );


/*
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 */

if ( !function_exists( 'of_get_option' ) ) {
    function of_get_option($name, $default = false) {

        $optionsframework_settings = get_option('optionsframework');

        // Gets the unique option id
        $option_name = $optionsframework_settings['id'];

        if ( get_option($option_name) ) {
            $options = get_option($option_name);
        }

        if ( isset($options[$name]) ) {
            return $options[$name];
        } else {
            return $default;
        }
    }
}