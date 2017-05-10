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
    wp_enqueue_script('', 'wp-api');
    wp_enqueue_script('qpost', plugin_dir_url( __FILE__ ).'scripts/app.js', null, null, false );
  }

  // widget form creation
  function form($instance) {

    // Check values
    if( $instance) {
         $title = esc_attr($instance['title']);
         $text = esc_attr($instance['text']);
         $textarea = esc_textarea($instance['textarea']);
    } else {
         $title = '';
         $text = '';
         $textarea = '';
    }
?>
    <p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>

    <p>
    <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'wp_widget_plugin'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
    </p>

    <p>
    <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Textarea:', 'wp_widget_plugin'); ?></label>
    <textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
    </p>
<?php
  }

  // widget update
  function update($new_instance, $old_instance) {
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['text'] = strip_tags($new_instance['text']);
        $instance['textarea'] = strip_tags($new_instance['textarea']);
       return $instance;
  }

  // display widget
  function widget($args, $instance) {
     extract( $args );
     // these are the widget options
     $title = apply_filters('widget_title', $instance['title']);
     $text = $instance['text'];
     $textarea = $instance['textarea'];
     echo $before_widget;

     // Check if title is set
     if ( $title ) {
        echo $before_title . $title . $after_title;
     }

     // Check if text is set
     if( $text ) {
        echo '<p class="wp_widget_plugin_text">'.$text.'</p>';
     }
     // Check if textarea is set
     if( $textarea ) {
       echo '<p class="wp_widget_plugin_textarea">'.$textarea.'</p>';
     }
     echo $after_widget;
  }
}

add_action('widgets_init', create_function('', 'return register_widget("wp_qpost_plugin");'));
?>
