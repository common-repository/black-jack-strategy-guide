<?php
/*
 * Plugin Name: Black Jack Strategy Guide
 * Plugin URI: https://wordpress.org/plugins/blackjack_strategy/
 * Description: Displays the correct play in every situation in Black Jack. 
 * Version: 1.0.0
 * Author: Henrik Rasi
 * Author URI: https://profiles.wordpress.org/razzie83
 * License: GPLv2 or later
 *
*/

if ( ! defined( 'ABSPATH' ) ) exit; 
// Load Styles
function blackjack_strategy_backend_styles() {

 wp_enqueue_style( 'blackjack_strategy_backend_css', plugins_url( 'css/blackjack_strategy.css', __FILE__ ) );

}
add_action( 'admin_head', 'blackjack_strategy_backend_styles' );

// Ajax function when sending the form
function blackjack_ajax_request() {

}

add_action( 'wp_ajax_blackjack_ajax_request', 'blackjack_ajax_request' );
add_action('wp_ajax_nopriv_blackjack_ajax_request', 'blackjack_ajax_request');


function blackjack_strategy_frontend_scripts_and_styles() {

 wp_enqueue_style( 'blackjack_strategy_frontend_css', plugins_url( 'css/blackjack_strategy.css', __FILE__ ) );
 wp_enqueue_script( 'blackjack_strategy_frontend_js', plugins_url( 'js/blackjack_strategy.js', __FILE__ ), array('jquery'), '', true );
 // Localize the script with new data
$dir = basename(__DIR__) ;
$ts_js_array = array(
  'plugin_url'  => plugins_url() . '/' .  $dir,
  'site_url'    => get_site_url()
);
wp_localize_script( 'blackjack_strategy_frontend_js', 'wp_urls', $ts_js_array, admin_url( 'admin-ajax.php' ) );

}
add_action( 'wp_enqueue_scripts', 'blackjack_strategy_frontend_scripts_and_styles' );

/**
 * Adds blackjack_strategy widget.
 */
class blackjack_strategy extends WP_Widget {

 /**
  * Register widget with WordPress.
  */
 function __construct() {
  parent::__construct(
   'blackjack_strategy', // Base ID
   __( 'Black Jack Strategy', 'blackjack_strategy' ), // Name
   array( 'description' => __( 'Widget that displays Black Jack strategy guide', 'blackjack_strategy' ), ) // Args
  );
 }

 /**
  * Front End 
  *
  * @see WP_Widget::widget()
  *
  * @param array $args     Widget arguments.
  * @param array $instance Saved values from database.
  */
 public function widget( $args, $instance ) {
  echo $args['before_widget'];
  if ( ! empty( $instance['title'] ) ) {
   echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
  } ?>
  <form id="blackjack-form">
<p class="blackjack-rules">From 4 to 8 decks <br>Dealer stands on Soft 17</p>
  <select id="blackjack-dealer" class="blackjack-form">
    <option selected disabled>Dealers hand</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">A (A = Ace)</option>
  </select>
  <select id="blackjack-player" class="blackjack-form">
    <option selected disabled>Your hand</option>
    <option value="8">8 or lower</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17+</option>
    <option disabled>Softs</option>
    <option value="1113">A13</option>
    <option value="1114">A14</option>
    <option value="1115">A15</option>
    <option value="1116">A16</option>
    <option value="1117">A17</option>
    <option value="1118">A18</option>
    <option value="1119">A19+</option>
    <option disabled>Splits</option>
    <option value="22">22</option>
    <option value="33">33</option>
    <option value="44">44</option>
    <option value="66">66</option>
    <option value="77">77</option>
    <option value="88">88</option>
    <option value="99">99</option>
    <option value="1111">AA</option>
  </select>
<button id="blackjack-btn">Correct play</button>
  </form>
<div id="blackjack-response"></div>
<?php
  echo $args['after_widget'];
 }

 /**
  * Back-end widget form.
  *
  * @see WP_Widget::form()
  *
  * @param array $instance Previously saved values from database.
  */
 public function form( $instance ) {
  $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Black Jack Strategy', 'blackjack_strategy' );
 // $number = ! empty()
  ?>
  <p>
  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label> 
  <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
  </p>
  <?php 
 }

 /**
  * Sanitize widget form values as they are saved.
  *
  * @see WP_Widget::update()
  *
  * @param array $new_instance Values just sent to be saved.
  * @param array $old_instance Previously saved values from database.
  *
  * @return array Updated safe values to be saved.
  */
 public function update( $new_instance, $old_instance ) {
  $instance = array();
  $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
  
  return $instance;
 }

} // class blackjack_strategy

// register blackjack_strategy widget
function register_blackjack_strategy() {
    register_widget( 'blackjack_strategy' );
}
add_action( 'widgets_init', 'register_blackjack_strategy' );


?>