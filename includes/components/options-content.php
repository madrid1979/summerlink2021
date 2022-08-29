<?php

function pull_boilerplate() {
  return the_field('sites_boilerplate', 'option');
}
function register_shortcodes(){
  add_shortcode('show-boilerplate', 'pull_boilerplate');
}


?>