<?php
/*
    Plugin Name: Sortable Lite
    Plugin URI: http://wpicode.com/sortable-lite
    Description: Sortable is a plugin that sorts your posts by different parameters like social status, alphabetically, comments and others.
    Version: 2.1
    Author: Wpicode
    Author URI: http://wpicode.com
	Tags: sort by, order by, sorting posts, ordering posts, sort by date, older, newer, order by comments count, order by comments, order alphabetically, alphabetically

*/

include_once('inc/classes.php');
include_once('inc/functions.php');
include_once('inc/loop.php');
include_once('inc/admin/view.php');
	global 	$sortableNetworks;
 	$sortableNetworks = array();
	global $sortableNetworksPostId;

function sortable_short_func( $atts, $content ) {
	$atts = extract(shortcode_atts( array(
		'social_status'=>true,
		'include_social_media'=>'facebook,twitter,stumbleupon,googleplus,linkedin,pinterest',
		'sort_social_media'=>'facebook,twitter,stumbleupon,googleplus,linkedin,pinterest',
		'alphabetically'=>true,
		'comments'=>true,
		'post_type' => 'post',
		'per_page'=>'12',
		'show_stats'=>false,
		'default_view'=>'list',
		'color'=>'#777777',
		'custom'=>false
	), $atts ));

	$sortable = sortable_init_object();
	$sortable->init($post_type);
	return $sortable->get_html($social_status,$include_social_media,$sort_social_media,$alphabetically,$comments,$post_type,$per_page,$show_stats,$default_view,$color,$custom);
}
add_shortcode( 'sortable', 'sortable_short_func' );

function sort_scripts_method() {
    wp_enqueue_script( 'jquery' );
	   // wp_register_script( 'bootstrap', plugins_url('js/bootstrap.min.js', __FILE__));
      //  wp_enqueue_script( 'bootstrap' );
	   // wp_register_style( 'bootstrap', plugins_url('css/bootstrap.min.css', __FILE__));
       // wp_enqueue_style( 'bootstrap' );
		wp_register_style( 'sortable', plugins_url('css/sortable.css', __FILE__));
        wp_enqueue_style( 'sortable' );
	   // wp_register_style( 'bootstrap-theme', plugins_url('css/bootstrap-theme.min.css', __FILE__));
       // wp_enqueue_style( 'bootstrap-theme' );
	   $disable_font_awesome = get_option('disable_font_awesome');
	   if($disable_font_awesome!='yes'){
	    wp_register_style( 'font-awesome', plugins_url('css/font-awesome.min.css', __FILE__));
        wp_enqueue_style( 'font-awesome' );
		}
	   wp_register_script( 'sortable', plugins_url('js/sortable.js', __FILE__));
        wp_enqueue_script( 'sortable' );
	wp_localize_script( 'sortable', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
}
function sort_scripts_admin() {
    wp_enqueue_script( 'jquery' );
	   wp_register_script( 'sortable', plugins_url('js/sortable.js', __FILE__));
        wp_enqueue_script( 'sortable' );
	   wp_register_script( 'sortable-admin', plugins_url('js/sortable-admin.js', __FILE__));
        wp_enqueue_script( 'sortable-admin' );
	   $disable_font_awesome = get_option('disable_font_awesome');
	   if($disable_font_awesome!='yes'){
	    wp_register_style( 'font-awesome', plugins_url('css/font-awesome.min.css', __FILE__));
        wp_enqueue_style( 'font-awesome' );
		}
		wp_register_style( 'sortable-admin-css', plugins_url('css/sortable-admin.css', __FILE__));
        wp_enqueue_style( 'sortable-admin-css' );
	wp_localize_script( 'sortable', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );

}
add_action('admin_enqueue_scripts', 'sort_scripts_admin');
add_action('wp_enqueue_scripts', 'sort_scripts_method');


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'sortable_action_links' );

function sortable_action_links( $links ) {
   $links[] = '<a href="admin.php?page=sortable_admin_view">Settings</a>';
   $links[] = '<a href="http://codecanyon.net/user/wpicode/portfolio" target="_blank">More plugins by Wpicode</a>';
   return $links;
}
add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page() {

	add_menu_page( 'Sortable', 'Sortable', 'manage_options', 'sortable_admin_view', 'sortable_admin_view', plugins_url( 'sortable/img/icon.png' ) );

}

function sortable_activate() {

		if ( get_option( 'disable_font_awesome' ) !== false ) {
		update_option( 'disable_font_awesome', 'no' );
		} else {
		 add_option( 'disable_font_awesome', 'no' );
		}

		if ( get_option( 'sortable_cache' ) !== false ) {
		update_option( 'sortable_cache', '700' );
		} else {
		 add_option( 'sortable_cache', '700' );
		}


		if ( get_option( 'sortable_custom_meta' ) !== false ) {
		update_option( 'sortable_custom_meta', 'pricing' );
		} else {
		 add_option( 'sortable_custom_meta', 'pricing' );
		}


		if ( get_option( 'sortable_custom_order' ) !== false ) {
		update_option( 'sortable_custom_order', 'ASC' );
		} else {
		 add_option( 'sortable_custom_order', 'ASC' );
		}

		if ( get_option( 'sortable_custom_text' ) !== false ) {
		update_option( 'sortable_custom_text', 'Pricing' );
		} else {
		 add_option( 'sortable_custom_text', 'Pricing' );
		}

		$sortable_premetatext = '$';
		if ( get_option( 'sortable_premetatext' ) !== false ) {
		update_option( 'sortable_premetatext', $sortable_premetatext );
		} else {
		 add_option( 'sortable_premetatext', $sortable_premetatext );
		}

		if ( get_option( 'sortable_translate' ) !== false ) {
		update_option( 'sortable_translate', 'Sort by:|Social Status|Facebook Shares|Twitter Shares|Google Plus Shares|StumbleUpon Shares|LinkedIn Shares|Pinterest Shares|A-Z Alphabetically|Z-A Alphabetically|Newest|Oldest|Most Commented|Read More|Posted by|on' );
		} else {
		 add_option( 'sortable_translate', 'Sort by:|Social Status|Facebook Shares|Twitter Shares|Google Plus Shares|StumbleUpon Shares|LinkedIn Shares|Pinterest Shares|A-Z Alphabetically|Z-A Alphabetically|Newest|Oldest|Most Commented|Read More|Posted by|on' );
		}
}
register_activation_hook( __FILE__, 'sortable_activate' );

?>
