<?php

//Use Ontraport 
use Ontraport_API\Ontraport;


class Ontraport_API {

 	public $client;
 	protected $api_id;
 	protected $api_key;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() 
	{
 
        $this->api_id = get_option( 'ontrabb_appid' );
        $this->api_key = get_option( 'ontrabb_appkey' );


	}  


	/**
	 * [connect description]
	 * @return [type] [description]
	 */
    public function connect() 
    {
         
        $this->client = new Ontraport(  $this->api_id, $this->api_key );
        
        return $this->client;
         
    }




}