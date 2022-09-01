<?php

define('VERSION', '1.1.01a');

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [], VERSION );
    if(is_page_template( 'events.php' )){
      wp_enqueue_style( 'event-style', get_stylesheet_directory_uri() . '/events.css', [], VERSION, 'all');
    }
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 20 );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

function flush_rewrites($post_ID, $post, $update){
  flush_rewrite_rules();
}
add_action('save_post', 'flush_rewrites', 999, 3);

/* ADDITIONAL COMPONENTS */
include_once('includes/components/parksite.php');
include_once('includes/components/options-content.php');

function register_shortcodes(){
  add_shortcode('show-notices', 'get_notices');
  add_shortcode('show-boilerplate', 'pull_boilerplate');
}

add_action( 'init', 'register_shortcodes');

/* ACF OPTIONS PAGE */
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page();
}