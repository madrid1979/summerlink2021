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

/* Custom RSS Feeds */
add_action('init', 'customRSS');
function customRSS(){
  add_feed('latest-notices', 'customRSSFunc');
}
function customRSSFunc(){
  get_template_part('rss/rss', 'latestnotices');
}

add_filter( 'get_post_time', 'return_post_date_rss_2_feed_func', 10, 3 ); 
function return_post_date_rss_2_feed_func( $time, $d, $gmt ) {
	if( did_action( 'rss2_head' ) ) {
  	if(get_post_type() == 'site') { ?>
			<item>
        <title><?php the_title_rss(); ?></title>
        <link><?php the_permalink_rss(); ?></link>
        <pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_modified_time('Y-m-d H:i:s', true), false); ?></pubDate>
        <dc:creator>The Summerlin Council</dc:creator>
        <guid isPermaLink="false"><?php the_guid(); ?></guid>
        <description>New maintenance notice posted</description>
        <?php rss_enclosure(); ?>
        <?php do_action('rss2_item'); ?>
      </item>
		<?php 
    }
  }     
  return $time;
}
