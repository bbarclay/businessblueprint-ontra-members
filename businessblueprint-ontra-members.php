<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Business Blueprint Ontraport Members
 *
 * @wordpress-plugin
 * Plugin Name:       Business Blueprint Ontraport Members
 * Plugin URI:        http://businessblueprint.com
 * Description:       Custom plugin to retreive all Ontraport contacts.
 * Version:           1.0.0
 * Author:            July Cabigas
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ontra_members
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_ontra_members() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ontra-members-activator.php';
	Ontra_Members_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_ontra_members() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ontra-members-deactivator.php';
	Ontra_Members_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ontra_members' );
register_deactivation_hook( __FILE__, 'deactivate_ontra_members' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ontra-members.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ontra_members() {

	$plugin = new Ontra_Members();
	$plugin->run();

}
run_ontra_members();


