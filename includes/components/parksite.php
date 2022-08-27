<?php 

function get_notices() {

  global $post;

  $table_html = '<table class="notice_table"><thead><tr><td><p>Notice Date</p></td><td><p>View/Download Notice</p></td></tr></thead><tbody>';
  $notice_count = 0;
  
  if ( have_rows( 'smm_maintenance_notices' ) ) :

    $date_order = array();
    $repeater = get_field('smm_maintenance_notices');
    foreach( $repeater as $i => $row ) {
      $date_order[ $i ] = $row['smm_notice_date'];
    }
    array_multisort( $date_order, SORT_DESC, $repeater);

    foreach( $repeater as $i => $row ):

      $latest_txt = ($notice_count == 0) ? '(Latest)' : '';
      $latest_class = ($notice_count == 0) ? 'class="latest_notice"' : '';

      $notice_date = $row['smm_notice_date'];
      $notice_file = $row['smm_upload_notice'];

      $table_html .= '<tr '.$latest_class.'><td><p>'.$notice_date.'</p></td>';
      $table_html .= '<td><p><a href="'.$notice_file.'">"'.get_the_title().'" Maintenance Notice '.$latest_txt;
      $table_html .= '</a></p></td></tr>';
      
      $notice_count++;

    //endwhile;
    endforeach;

  else :

	  $table_html .= '<tr><td colspan="2" class="no_notices"><p>There are no notices posted for this site.</p></td></tr>';

  endif;
  $table_html .= '</tbody></table>';

  return $table_html;

}

function register_shortcodes(){
  add_shortcode('show-notices', 'get_notices');
}

?>