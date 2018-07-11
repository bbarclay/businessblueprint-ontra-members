<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Ontra_Members_Admin {


	private $plugin_name;
	private $version;
	private $ontraport;


	public function __construct( $plugin_name, $version, $ontraport ) {

		$this->plugin_name 	= $plugin_name;
		$this->version 		= $version;
		$this->ontraport 	= $ontraport;


		if ( is_admin() ) {
	    	add_action("wp_ajax_ontramembers_listing", array( $this, 'ontramembers_listing' ));
	    }

	}


	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ontra_members-admin.css', array(), $this->version, 'all' );
	}


	public function enqueue_scripts() {

		wp_enqueue_media();

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ontra_members-admin.js', array( 'jquery' ), $this->version, true );

		 wp_localize_script( $this->plugin_name, 'ontramember', array( 
        	'ajaxurl' => admin_url( 'admin-ajax.php' ), 
        	'security' => wp_create_nonce('ontramember_listing')
        ) );

	}


	function get_members() 
	{

	   $client = $this->ontraport;

	   $paged = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;


   	   if($paged) {

   	   	   $x = $paged - 1;
		   $start = (50 * $x);
	       $range = ($start + 50) ;
   	   }
   	   else {

	  	   $start = 0;
	       $range = 50;
   		}

	    $queryParams = array(
	          "condition"     => 
	                             '[

	                             {
	                              "field":{"field":"BBCustomer_165"},
	                              "op":"IN",
								  "value":{"list":[{"value":802},{"value":800},{"value":1652},{"value":1220},{"value":1759}]}
	                             }
	                             

	                            ]',

	         "listFields" => "id, firstname, lastname, email, BBCustomer_165, JoinedBlue_174, title, country, sms_number,BBYearLeve_258",
	         "start" => $start,
        	 "range" => $range,
        	 'sort' => 'firstname',
        	 'sortDir' => 'asc'                  
	    );


	  $response = $client->contact()->retrieveMultiple($queryParams);
	  $response = json_decode($response, true);
	  $response = $response['data'];
	  

	   return $response;

	}




	public function get_totalItems() {

		
		$client = $this->ontraport;
	    $queryParams = array(
	          "condition"     => 
	                             '[

	                             {
	                              "field":{"field":"BBCustomer_165"},
	                              "op":"IN",
								  "value":{"list":[{"value":802},{"value":800},{"value":1652},{"value":1220},{"value":1759}]}
	                             }
	                             

	                            ]'                
	    );

	    $response = $client->contact()->retrieveCollectionInfo($queryParams);
	    $response = json_decode($response, true);
	    $count = $response["data"]["count"];



		return $count;

	}

	public function display_pagination( $max = 50) 
	{
		$output = '';

		$total = $this->get_totalItems();

		if( $total % $max ) {
	        $lists =  ( $total / $max ) + 1;
	    }
	    else {
	        $lists =  ( $total / $max );
	    }


	    if ($lists > 1){
	        $current_page = ( isset( $_GET['paged'] ) ) ? max(1, $_GET['paged']) : 1;
	 
	        $output .= paginate_links(array(
	            'base' => get_pagenum_link(1) . '%_%',
	            'format' => '&paged=%#%',
	            'current' => $current_page,
	            'total' => $lists,
	            'before_page_number' => '',
			    'after_page_number'  => '',
			    'type'               => 'list',
	        ));

	    }
   	
	    return $output;      

	}

	public function add_subpage() {

			add_menu_page('BB Members', 'MBB Members', 'manage_options', 'ontra_members', array($this,'ontra_members_page'), '', 26 );

    		add_submenu_page(
    			  'ontra_members',
    			  'General Settings',
    			  'General Settings',
    			  'manage_options',
    			  'member_settings',
    			  array($this, 'member_settings')
    		);
    }

    public function member_settings() {
		require_once( plugin_dir_path(__FILE__)) . 'partials/member-settings.php';
    }

    public function settings_init(){

    	register_setting( 'bbmember-setting', 'ontra_member_bb_appid', array($this, 'sanitize_input_field') );
		register_setting( 'bbmember-setting', 'ontra_member_bb_appkey', array($this, 'sanitize_input_field') );

		add_settings_section(
		    'ontramember-section',                   		
		    '',  						 
		    array( $this, 'ontramember_description'), 			 
		    'member_settings'                          
		);

		add_settings_field(
		    'ontramember-id',     
		    'Ontraport APP ID',      
		    array($this, 'settings_appID'), 
		    'member_settings',                    
		    'ontramember-section'               
		);

		add_settings_field(
		    'ontramember-key',     
		    'Ontraport APP KEY',      
		    array($this, 'settings_appKEY'), 
		    'member_settings',                    
		    'ontramember-section'               
		);

    }

   
    public function get_defaultThumbnail($name = '') { 

    	return plugin_dir_url( __FILE__ ) . 'image/user-icon.png';

    }


    public function ontra_members_page() {

    	wp_enqueue_media();
    	$client = $this->get_members();

    	require_once( plugin_dir_path(__FILE__) ) . 'partials/main-page-display.php';  

    }


    public function get_customerType($id) {

    	  if($id == '802') {

    	  	 $output = 'Platinum';

    	  }

    	  else if ( $id == '800') {

    	  	 $output = 'Gold';

    	  }
    	  else if ( $id == '1220') {

    	  	 $output = 'Free Customer';

    	  }
    	  else if ( $id == '1652') {

    	  	 $output = 'BB Scholar';

    	  }
    	  else if ( $id == '1759') {

    	  	 $output = 'BB Platinum - Ruby Pass';

    	  }

    	  return $output;

    }


    public function get_yearLevel($year_level) {

		switch($year_level) {
			case '1204':
			   $bb_level = "Fast-Trask";
			   break;

			case '1205':
				$bb_level = "Elite - VIP";
			   break;   

			case '1206':
				$bb_level = "Elite - All Stars";
			   break; 
			   
			case '1207':
				$bb_level = "Elite - Masters";
			   break;

			default:
				$bb_level = '';
				break;          
		}

		return $bb_level;

    }

    public function get_image($id = '') {

    	if($id) {
    		$url = get_post_meta( $id, '_ontramembers_img' , true);
    	}

    	if($url) {
    		return $url;
    	}
    	else {
    		return $this->get_defaultThumbnail();
    	}
    }


    public function ontramember_description(){
	    echo wpautop( "Add your Ontraport API Key and ID" );
	}


    public function settings_appID() {
    	$task = sanitize_text_field(get_option('ontra_member_bb_appid'));

		echo '<label for="ontra_member_bb_appid">' .
		       '<input id="ontra_member_bb_appid" name="ontra_member_bb_appid" class="regular-text" type="input" value="'. ( !empty($task) ? $task : '' )  .'" />' .
		      '</label> ';
    }

    public function settings_appKEY() {
    	$task = sanitize_text_field(get_option('ontra_member_bb_appkey'));

		echo '<label for="ontra_member_bb_appkey">' .
		       '<input id="ontra_member_bb_appkey" name="ontra_member_bb_appkey" class="regular-text" type="input" value="'. ( !empty($task) ? $task : '' )  .'" />' .
		      '</label>';
    }


    /**
	*  Sanitize Input Field
	*
	*  @param input from the form
    */
    public function sanitize_input_field( $input ) {

    	if( isset( $input ) ) {
    		$clean = sanitize_text_field( $input );

    		return $clean;
    	}
    	else {
    		return false;
    	}
    }


    function ontramembers_listing() {

		if ( !is_user_logged_in() ){
				wp_send_json_error('you are not allowed');
		}

		$success_security = check_ajax_referer( 'ontramember_listing', 'security' );
	
        $id  	 = (int)$_POST['id'];
        $url 	 =  sanitize_text_field( $_POST['url'] );
		$post_id = update_post_meta( $id, '_ontramembers_img' , $url);


		if(!$post_id) {
			wp_send_json_error(array(
      			'message' => 'Error submitting post'
    		));
		}
		else {
			wp_send_json_success(array(
      			'message' => 'Added Meta Successfully',
      			'completed' => true
    		));
		}

		wp_die();
    }


}
