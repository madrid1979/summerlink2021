<?php
/**
 * Template Name: Events Listing
 * Events Listing Page Template.
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

<section id="content" class="full-width">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php echo fusion_render_rich_snippets_for_pages(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php avada_singular_featured_image(); ?>
			<div class="post-content">
				<?php the_content(); ?>
				<?php fusion_link_pages(); ?>
			</div>
			<?php if ( ! post_password_required( $post->ID ) ) : ?>
				<?php if ( Avada()->settings->get( 'comments_pages' ) ) : ?>
					<?php comments_template(); ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	<?php endwhile; wp_reset_postdata(); ?>

  <div class="event_listings">
  <?php 
    ### START EVENT BLOCKS ###
    $eventsArgs = array('post_type' => 'event');
    $eventsQuery = new WP_Query($eventsArgs);
    
    while ($eventsQuery->have_posts()) : 
      $eventsQuery->the_post(); ?>
    <div class="eventblock">
      <a class="eventlink" href="<?php echo get_the_permalink(); ?>"></a>
      <div class="eventImg">
        <?php 
          $event_image_id = get_post_thumbnail_id();
          if ($event_image_id) {
        ?>
          <img src="<?php echo wp_get_attachment_image_url($event_image_id, 'large' ); ?>" alt="<?php echo get_the_title(); ?>">
        <?php } else { ?>
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/event_placeholder.jpg" alt="New Event">
        <?php } ?>
      </div>
      <div class="eventInfo">
        <h3><?php the_title(); ?></h3>
        <h5><?php echo get_field('event_date');?></h5>
        <?php 
          if( empty( get_the_excerpt() ) ){
            $raw_content = wp_strip_all_tags(get_the_content());
            $pattern = get_shortcode_regex();
            $clean_content = preg_replace_callback( "/$pattern/s", 'fusion_extract_shortcode_contents', $raw_content);
            $clean_content = wp_trim_excerpt($clean_content);

            $excerpt_length = (int) _x( '55', 'excerpt_length' );
            $excerpt_length = (int) apply_filters( 'excerpt_length', $excerpt_length );

            $excerpt_more = apply_filters( 'excerpt_more', '&hellip; ' . '<p><strong>[CLICK FOR DETAILS]</strong></p>' );
            
            $clean_content = wp_trim_words($clean_content, $excerpt_length, $excerpt_more);
            echo apply_filters('the_content', $clean_content);
          } else {
            the_excerpt();
            echo "<p><strong>[CLICK FOR DETAILS]</strong></p>";
          }
        ?>
      </div>
    </div>

  <?php endwhile; ?>
  </div>

</section>
<?php get_footer(); ?>
