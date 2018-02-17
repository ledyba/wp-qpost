<?php
/*
Plugin Name: Quick Post Plugin
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: You can post a new post from this widget.
Version: 1.0
Author: PSI
Author URI: http://ledyba.org/
License: GPL3
*/

class wp_qpost_plugin extends WP_Widget {

  // constructor
  function __construct() {
    parent::__construct(false, $name = __('Quick Post Widget', 'wp_widget_plugin') );
    add_action('wp_enqueue_scripts', array(__CLASS__, 'wp_enqueue_scripts'));
  }

  public static function wp_enqueue_scripts() {
    wp_register_script('qpost', plugin_dir_url( __FILE__ ).'app.js', array('wp-api'), null, false);
    wp_register_style('qpost-css', plugin_dir_url( __FILE__ ).'style.css' );
    //wp_localize_script('qpost', 'wpQpostId', "qpost-".wp_qpost_plugin::makeRandStr(10));
    wp_enqueue_script('qpost');
    wp_enqueue_style('qpost-css');
  }

  public static function makeRandStr($length) {
    $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
    $r_str = null;
    for ($i = 0; $i < $length; $i++) {
        $r_str .= $str[rand(0, count($str) - 1)];
    }
    return $r_str;
  }

  // widget form creation
  function form($instance) {
  }

  // widget update
  function update($new_instance, $old_instance) {
    return $instance;
  }

  // display widget
  function widget($args, $instance) {
    if ( !is_user_logged_in() ) {
      return;
    }
    extract( $args );
    // these are the widget options
    $title = apply_filters('widget_title', $instance['title']);
    echo $before_widget;

    //echo $before_title . "Post Now" . $after_title;
    $id = wp_qpost_plugin::makeRandStr(10);
?>
<div>
  <div>
    <textarea class="qpost-textarea" id="qpost-form-<?php echo $id; ?>" autofocus="autofocus"></textarea>
  </div>
  <div class="qpost-button-box">
    <input class="qpost-button" id="qpost-button-<?php echo $id; ?>" type="button" value="post">
  </div>
</div>
<script>
(function(){
  function main() {
    var btn = document.getElementById('qpost-button-<?php echo $id; ?>');
    var form = document.getElementById('qpost-form-<?php echo $id; ?>');
    btn.addEventListener('click', function(event) {
      return wp_qpost(btn,form,true,event);
    });
    form.addEventListener('keydown', function(event) {
      return wp_qpost(btn, form, false, event);
    });
  }
  document.addEventListener('DOMContentLoaded', main);
})();
</script>
<?php
     echo $after_widget;
  }
}

add_action('widgets_init', create_function('', 'return register_widget("wp_qpost_plugin");'));
?>
