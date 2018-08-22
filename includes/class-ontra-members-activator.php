<?php

/**
 * Fired during plugin activation
 *
 * @since      1.0.0
 *
 * @package    Business Blueprint Ontra Members
 * @subpackage businessblueprint-ontra-members/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Business Blueprint Ontra Members
 * @subpackage businessblueprint-ontra-members/includes
 * @author     Business Blueprint 
 */
class Ontra_Members_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		flush_rewrite_rules();
	}

}
