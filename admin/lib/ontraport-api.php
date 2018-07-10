<?php

//Add Base PHP
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'lib/ontraport/Ontraport.php';

//Use Ontraport 
use Ontraport_API\Ontraport;


class Ontraport_API {

    public $client;
 	protected $api_ID;
 	protected $api_Key;
 	public static $instance = null;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
 

        $this->api_ID = get_option( 'ontrabb_appid' );
        $this->api_Key = get_option( 'ontrabb_appkey' );

	}  

    public function connect() {
         
        $this->client = new Ontraport( $this->api_ID, $this->api_Key );

        return $this->client;
         
    }




}