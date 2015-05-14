<?php
/*
Plugin Name: Findery Notes
Plugin URI: https://findery.com/sharing
Description: Findery Notes displays your Findery notes in a widget as a list or photo grid.
Version: 1.0
Min WP Version: 3.0
Author: Findery
Author URI: https://findery.com
*/
?>
<?php
add_action('widgets_init', create_function('', 'return register_widget("Findery_Notes");'));
add_filter('the_content', 'findery_notes_on_page', 10, 1);

class Findery_Notes extends WP_Widget {

  function __construct() {
    $widget_ops = array('classname' => 'Findery_Notes', 'description' => "Findery Notes displays your Findery notes in a widget as a list of photo grid." );
    $control_ops = array('width' => 200, 'height' => 300);
    parent::__construct('finderynotes', __('Findery Notes'), $widget_ops, $control_ops);
  }

  function form($instance) {
    $instance = wp_parse_args(
      (array) $instance,
      array( 'title' => 'Follow me on Findery', 'width' => 500, 'height' => 500, 'url' => 'caterina', 'border' => 0, 'scrolling' => 'auto', 'display' => '')
    );
    $title = strip_tags($instance['title']);
    $width = strip_tags($instance['width']);
    $height = strip_tags($instance['height']);
    $url = strip_tags($instance['url']);
    $style = strip_tags($instance['style']);
    $border = strip_tags($instance['border']);
    $scrolling = strip_tags($instance['scrolling']);
    $display = strip_tags($instance['display']);
    ?>
    <p><small>Display your latest Findery posts as a widget. <a href="https://findery.com" target="_blank">Click here to sign up for Findery</a>.</small></p>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input size="40" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Findery Username:' ); ?></label>
      <input size="40" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width*:' ); ?></label>
      <input size="4" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>" />
          &nbsp;&nbsp;&nbsp;
      <label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height*:' ); ?></label>
      <input size="4" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" />
    </p>
    <p><small>* The Width and Height attributes can be specified either in pixels (example: 50px or simply 50) or as a percentage of the available space (example: 50%).</small></p>
    <p>
      <label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e( 'Display as List or Photo Grid:' ); ?></label>
      <select id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>">
          <option style="padding-right:10px;" value="" <?php selected('', esc_attr($display)); ?>>List</option>
          <option style="padding-right:10px;" value="/grid" <?php selected('/grid', esc_attr($display)); ?>>Grid</option>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'CSS Style:' ); ?></label>
      <input size="40" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="text" value="<?php echo esc_attr($style); ?>" />
      <br><small>(example:<i>border:1px solid black;align:left;</i>)</small>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'border' ); ?>"><?php _e( 'Display Frame border? :' ); ?></label>
      <select id="<?php echo $this->get_field_id('border'); ?>" name="<?php echo $this->get_field_name('border'); ?>">
          <option style="padding-right:10px;" value="1" <?php selected('1', esc_attr($border)); ?>>Yes</option>
          <option style="padding-right:10px;" value="0" <?php selected('0', esc_attr($border)); ?>>No</option>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'scrolling' ); ?>"><?php _e( 'Display Scroll bars? :' ); ?></label>
      <select id="<?php echo $this->get_field_id('scrolling'); ?>" name="<?php echo $this->get_field_name('scrolling'); ?>">
          <option style="padding-right:10px;" value="yes" <?php selected('yes', esc_attr($scrolling)); ?>>Yes</option>
          <option style="padding-right:10px;" value="no" <?php selected('no', esc_attr($scrolling)); ?>>No</option>
          <option style="padding-right:10px;" value="auto" <?php selected('auto', esc_attr($scrolling)); ?>>Auto</option>
      </select>
    </p>
    <?php
  }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['width'] = strip_tags($new_instance['width']);
    $instance['height'] = strip_tags($new_instance['height']);
    $instance['url'] = strip_tags($new_instance['url']);
    $instance['border'] = strip_tags($new_instance['border']);
    $instance['scrolling'] = strip_tags($new_instance['scrolling']);
    $instance['style'] = strip_tags($new_instance['style']);
    $instance['display'] = strip_tags($new_instance['display']);
    return $instance;
  }

  // This prints the widget
  function widget( $args, $instance ) {
    extract($args);
    echo $before_widget . $before_title . $instance['title']  . $after_title;
    ?>
    <IFRAME STYLE="<?php echo $instance['style'] ; ?>" SCROLLING="<?php echo $instance['scrolling'] ; ?>" FRAMEBORDER="<?php echo $instance['border'] ; ?>" SRC="https://findery.com/embed/<?php echo $instance['url'] ; ?><?php echo $instance['display'] ; ?>" WIDTH="<?php echo $instance['width'] ; ?>" HEIGHT="<?php echo $instance['height'] ; ?>">
      [Your user agent does not support frames or is currently configured not to display frames. However, you may visit <A href="<?php echo $instance['url'] ; ?>">the related document.</A>]
    </IFRAME>
    <?php
    echo $after_widget;
  }
}

//Converts all the occurances of [dciframe][/dciframe] to IFRAME HTML tags
function findery_notes_on_page($text){
  $regex = '#\[dciframe]((?:[^\[]|\[(?!/?dciframe])|(?R))+)\[/dciframe]#';
  if (is_array($text)) {
    //Read the Width/Height Parameters, if given
    $param = explode(",", $text[1]);
    $others = "";
    if(isset($param[1])){
      $others = ' width="' .$param[1] . '"';
    }
    if(isset($param[2])){
      $others .= ' height="' .$param[2] . '"';
    }
    if(isset($param[3]) && is_numeric($param[3])){
      $others .= ' frameborder="' .$param[3] . '"';
    }
    if(isset($param[4])){
      $others .= ' scrolling="' .$param[4] . '"';
    }
    if(isset($param[5])){
      $others .= ' style="' .$param[5] . '"';
    }

    //generate the IFRAME tag
    $text = '<iFrame src="'.$param[0].'"'.$others.'></iFrame>';
  }
  return preg_replace_callback($regex, 'findery_notes_on_page', $text);
}

?>
