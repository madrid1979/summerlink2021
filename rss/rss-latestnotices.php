<?php 
/**
 * Template Name: Custom RSS Template - Latest Notices
 *
 * @package Avada
 * @subpackage Templates
 */

header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>

<rss version="2.0"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:wfw="http://wellformedweb.org/CommentAPI/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:atom="http://www.w3.org/2005/Atom"
  xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
  xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
  <?php do_action('rss2_ns'); ?>>

  <channel>
    <title><?php bloginfo_rss('name'); ?> - Feed</title>
    <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
    <link><?php bloginfo_rss('url') ?></link>
  
    <description><?php bloginfo_rss('description') ?></description>
    
    <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
    <language>en-us</language>
  
    <sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
    <sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
    
    <?php do_action('rss2_head'); ?>


    <?php
      $alerts_args = array('post_type' => 'site', 'post_status' => 'publish', 'orderby' => 'modified', 'order' => 'DESC');
      $alerts_all = new WP_Query( $alerts_args );

      while ($alerts_all->have_posts()) : $alerts_all->the_post(); 
        $sitename = get_the_title();
        $sitelink = get_the_permalink();
        $siteupdated_date = get_the_modified_time( 'F jS, Y' );
        $siteupdated_time = get_the_modified_time( 'h:i a' );
        $postID = get_the_ID();
    ?>
      <item>
        <title><?php the_title_rss(); ?></title>
        <link><?php the_permalink_rss(); ?></link>
        <pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
        <dc:creator>The Summerlin Council</dc:creator>
        <guid isPermaLink="false"><?php the_guid(); ?></guid>
        <description>New maintenance notice posted - </description>
        <content:encoded><![CDATA[<?php echo '<a href="'.$sitelink.'">'.$sitename.'</a> - Updated: '.$siteupdated_date.' at '.$siteupdated_time; ?>]]></content:encoded>
        <?php rss_enclosure(); ?>
        <?php do_action('rss2_item'); ?>
      </item>
  <?php endwhile; ?>

</channel>
</rss>
