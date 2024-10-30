<?php
/**
 * Plugin Name: Color_Changer
 * Plugin URI: ""
 * Version: 1.5
 * Author: Rahul Chavan
 * Description: Color Changer is there to help you out when you get bored of seeing the black & white colors of the editor. Click in the Color Changer Button and you will be in the beautiful colorful world. Don't forget to submit your review for our betterment.
 * License: GPL2
 */
class TinyMCE_Color_Changer {
     
    /**
    * Constructor. Called when the plugin is initialised.
    */
    function __construct() {
        if ( is_admin() ) {
			add_action( 'init', array(  $this, 'setup_tinymce_color_changer' ) );
		}
	}
 
	/**
	* Check if the current user can edit Posts or Pages, and is using the Visual Editor
	* If so, add some filters so we can register our plugin
	*/
	function setup_tinymce_color_changer() {
		// Check if the logged in WordPress User can edit Posts or Pages
		// If not, don't register our TinyMCE plugin
			 
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}
		 
		// Check if the logged in WordPress User has the Visual Editor enabled
		// If not, don't register our TinyMCE plugin
		if ( get_user_option( 'rich_editing' ) !== 'true' ) {
			return;
		}
		 
		// Setup some filters
		add_filter( 'mce_external_plugins', array( &$this, 'add_color_changer_plugin' ) );
		add_filter( 'mce_buttons', array( &$this, 'add_color_changer_button' ) );
	}
	
	/**
	* Adds a TinyMCE plugin compatible JS file to the TinyMCE / Visual Editor instance
	*
	* @param array $plugin_array Array of registered TinyMCE Plugins
	* @return array Modified array of registered TinyMCE Plugins
	*/
	function add_color_changer_plugin( $plugin_array ) {
		$plugin_array['colorChanger'] = plugin_dir_url( __FILE__ ) . 'plugin/plugin.min.js';
		return $plugin_array;
	}
	
	/**
	* Adds a button to the TinyMCE / Visual Editor which the user can click
	* to insert a link with a custom CSS class.
	*
	* @param array $buttons Array of registered TinyMCE Buttons
	* @return array Modified array of registered TinyMCE Buttons
	*/
	function add_color_changer_button( $buttons ) {
		array_push( $buttons, 'colorChangerButton' );
		return $buttons;
	}
	

}
 
$tinyMCE_color_changer = new TinyMCE_Color_Changer;

?>