<?php 
/**
 * Template Name: Latest Notices
 * Show latest notices posted to sites/parks.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>

<ul>
<?php 
  ### ALL ALERTS ###

  $alerts_args = array('post_type' => 'site', 'post_status' => 'publish', 'orderby' => 'modified', 'order' => 'DESC');
  $alerts_all = new WP_Query( $alerts_args );

  while ($alerts_all->have_posts()) : 
    $alerts_all->the_post();

    $sitename = get_the_title();
    $sitelink = get_the_permalink();
    $siteupdated_date = get_the_modified_time( 'F jS, Y' );
    $siteupdated_time = get_the_modified_time( 'h:i a' );

    echo '<li><a href="'.$sitelink.'">'.$sitename.'</a> - Updated: '.$siteupdated_date.' at '.$siteupdated_time.'</li>';

  endwhile;

?>
</ul>
  
<?php get_footer(); ?>