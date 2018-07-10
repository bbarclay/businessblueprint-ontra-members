<?php

/**
 *  Use to Build url with email parameter for
 *  Business Blueprint au.
 */

	
class LinkBuilder 
{

	public function __construct()
	{
		add_shortcode( 'url_builder', array( $this,'link_builder_shortcode') );
	}

	/**
	 * @return [email]
	 */
	function get_email() {

	  $current_user = wp_get_current_user();

	  $email = $current_user->user_email;

	  return $email;
	}


	/**
	 * @param  [array] attribute
	 * @return [string] url with email parameter
	 */
	function link_builder_shortcode( $atts) {

		$atts = shortcode_atts( array(
				'url' => 'https://businessblueprint.com.au/',
				'slug'    => ''

			), $atts, 'url_builder' );

		$email = $this->get_email(); 

		$output = $atts['url'] . '/' . $atts['slug'] . '?email=' . $email;

		return $output;

	}

	
}