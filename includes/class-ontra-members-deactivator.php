<?php

/**
 * Fired during plugin deactivation
 *
 * @since      1.0.0
 *
 * @package    Business Blueprint Ontra Members
 * @subpackage businessblueprint-ontra-members/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Business Blueprint Ontra Members
 * @subpackage businessblueprint-ontra-members/includes
 * @author     Business Blueprint 
 */
class Ontra_Members_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		flush_rewrite_rules();

	}

}
