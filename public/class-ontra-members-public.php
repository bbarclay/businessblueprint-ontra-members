<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */


class Ontra_Members_Public {


	public $email;
	public $firstname;
	public $lasttname;
	public $website;
	public $address;
	public $city;
	public $state;
	public $zipcode;
	public $country;
	public $mobile_no;
	public $office_no;
	public $company;
	public $year_level;
	public $customer_type;
	public $joined_date;
	public $owner;
	public $business_type;
	public $thumbnail;
	public $yearlevel; 
	public $active_members;
	public $affiliate_link;
	public $about_me;
	public $wistia;
	protected $ontraport;
	private $plugin_name;
	private $version;
	
	public function __construct( $plugin_name, $version, $ontraport, $wistia ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->ontraport = $ontraport;
		$this->wistia = $wistia;

	}


	/**
	* Register the stylesheets for the public-facing side of the site.
	*
	* @since    1.0.0
	*/
	public function enqueue_styles() {


		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ontra-members-public.css', array(), $this->version, 'all' );

	}

	/**
	* Register the JavaScript for the public-facing side of the site.
	*
	* @since    1.0.0
	*/
	public function enqueue_scripts() {

		wp_enqueue_script( 'jcrop');

		wp_enqueue_script( 'ontra-members', plugin_dir_url( __FILE__ ) . 'js/ontra-members-public.js', array( 'jquery' ), $this->version, false );

        wp_localize_script( 
           'ontra-members', 
           'search_members', 
           array( 
              'ajax_url' => admin_url('admin-ajax.php'),
              'security' => wp_create_nonce('ontra_security_action', 'ontra_security_field')

        ) );

        wp_localize_script( 
           'ontra-members', 
           'upload_photo', 
           array( 
              'ajax_url' => admin_url('admin-ajax.php'),
              'security' => wp_create_nonce('ontra_security_action', 'ontra_security_field')

        ) );

	}

	public function get_fasttrack() 
	{

	   $client = $this->ontraport;

	   	$max = 50;
	    $total = $this->get_total_FT();


		if( $total % $max ) {
	        $lists =  ( $total / $max ) + 1;
	    }
	    else {
	        $lists =  ( $total / $max );
	    }

	     $start = 0;
	     $range = 50;

	     $contact = [];
            
	     for($x = 1; $x <= $lists; $x++) {


	    	  $queryParams = array(
			          "condition"     => 
			                             '[
	                             {
			                              "field":{"field":"BBCustomer_165"},
			                              "op":"IN",
										   "value":{"list":[{"value":802},{"value":800},{"value":1652},{"value":1220},{"value":1759}]}
			                     },
								"AND",
	                             {
			                              "field":{"field":"BBYearLeve_258"},
			                              "op":"=",
										  "value":{"value":"1204"}
	                             	}

			                            ]',

			         "listFields" => "id, firstname, lastname, BBCustomer_165, JoinedBlue_174, country, BBYearLeve_258",
			         "start" => $start,
		        	 "range" => $range,
		        	 'sort' => 'firstname',
		        	 'sortDir' => 'asc'                  
			    );


			  $response = $client->contact()->retrieveMultiple($queryParams);
			  $response = json_decode($response, true);
			  $response = $response['data'];


			  if ($x == 1) {	

			  	 $contact = $response;

			  }
			  else {
			  	$contact = array_merge($contact, $response);
			  }


			  $start = ( 50 * $x ) + 1;
			  $range = $range + 50;


	  
		}	  



	   return $contact;

	}

	private function defaultPagination( $max = 50, $total = '')
	{
		if( empty($total) )
		{
			return false;
		}

		if( $total % $max ) {
	        $lists =  ( $total / $max ) + 1;
	    }
	    else {
	        $lists =  ( $total / $max );
	    }
	}

	public function get_active_members($page_number = '')
	{
		$client = $this->ontraport;

	   	$max = 50;
	    $total = $this->get_total_active_members($client);


		if( $total % $max ) {
	        $lists =  ( $total / $max ) + 1;
	    }
	    else {
	        $lists =  ( $total / $max );
	    }


	    $start = ($page_number > 1) ? $page_number * $max : 0;
	    $range = 50;

	    $contact = [];
         

    	$queryParams = array(
		          "condition"     => 
		                      '[{
	                              "field":{"field":"BBCustomer_165"},
	                              "op":"IN",
								   "value":{"list":[{"value":802},{"value":800}]}
		                       }]',

		         "listFields" => "id, firstname, lastname,StateAUS_131",
		         "start" => $start,
	        	 "range" => $range,
	        	 'sort' => 'firstname',
	        	 'sortDir' => 'asc'                  
		);

		$response = $this->ontraport->contact()->retrieveMultiple($queryParams);
		$response = json_decode($response, true);	
		$response = $response['data'];

		$contact  = array_merge($contact, $response);
			  
	   return $contact;
	}

    public function get_total_active_members() {
      
    
          global $client;
          $query = array(
             "condition"  => '[{
	                              "field":{"field":"BBCustomer_165"},
	                              "op":"IN",
								   "value":{"list":[{"value":802},{"value":800}]}
		                      }]',

          );

          $response = $this->ontraport->contact()->retrieveCollectionInfo($query);
          $response = json_decode($response, true);
          $count = $response["data"]["count"];

          return $count;
    }

	public function searchMembers()
	{
		$start   = (int)$_POST['start'];
		$range   = (int)$_POST['end'];
		$name    = $_POST['name'];
		$state   = intval( $_POST['stateId'] );

		if( ! isset( $_POST['security'] ) || ! check_ajax_referer( 'ontra_security_action', 'security') ) {
			return wp_send_json_error();
		}

		if( current_user_can('subscriber') &&  current_user_can('administrator') ) {
			return wp_send_json_error();
		}

    	
    	$contact = [];
 

    	if( $name && empty( $state ) ) {

    		// Count total entries
			$query = array(
				
				"search"	 => jo,
			    "condition"  => 
                  '[{
                      "field":{"field":"BBCustomer_165"},
                      "op":"IN",
					   "value":{"list":[{"value":802},{"value":800}]}
                   }]',
                   
	        );

	    	// Query the name only
	    	$queryParams = array(
	    			  
			         "condition"  => 
	                      '[{
                              "field":{"field":"BBCustomer_165"},
                              "op":"IN",
							   "value":{"list":[{"value":802},{"value":800}]}
	                       }]',    
	                 "search"	 => "jo",       
			         "listFields" => "id, firstname, lastname,StateAUS_131",
		        	 'sort' => 'firstname',
		        	 "start" => $start,
		  			 "range" => $range,
		        	 'sortDir' => 'asc',
			);

	    } 


	    if( $state && empty( $name ) ) {

	    	// Count total entries
			$query = array(
			          "condition"     => 
	                      '[{
                              "field":{"field":"BBCustomer_165"},
                              "op":"IN",
							   "value":{"list":[{"value":802},{"value":800}]}
	                       },
	                       "AND",
	                       {
	                       	  "field":{"field":"StateAUS_131"},
	                       	  "op":"=",
	                       	  "value": {"value": "'. $state .'"}
	                       }]',
	         );


	    	// Query the state only
	    	$queryParams = array(
			          "condition" => 
		                      '[{
	                              "field":{"field":"BBCustomer_165"},
	                              "op":"IN",
								   "value":{"list":[{"value":802},{"value":800}]}
		                       },
		                       "AND",
		                       {
		                       	  "field":{"field":"StateAUS_131"},
		                       	  "op":"=",
		                       	  "value": {"value": "'. $state .'"}
		                       }]',
			         "listFields" => "id, firstname, lastname,StateAUS_131",
		        	 'sort' => 'firstname',
		        	 "start" => $start,
		  			 "range" => $range,
		        	 'sortDir' => 'asc',
			);

	    } 


		// Query if name and state is filled up
    	if( $name && $state )  {


    		// Count total entries
			$query = array(
				"search"	 => $name,
			    "condition"  => 
	                      '[{
                              "field":{"field":"BBCustomer_165"},
                              "op":"IN",
							   "value":{"list":[{"value":802},{"value":800}]}
	                       },
	                       "AND",
			                {
	                       	  "field":{"field":"StateAUS_131"},
	                       	  "op":"=",
	                       	  "value": {"value": "'. $state .'"}
			                }]',
	        );


	    	// Query the name only
	    	$queryParams = array(
	    			  "search"	 => $name,
			          "condition"     => 
			                      '[{
		                              "field":{"field":"BBCustomer_165"},
		                              "op":"IN",
									   "value":{"list":[{"value":802},{"value":800}]}
			                       },
			                       "AND",
			                       {
			                       	  "field":{"field":"StateAUS_131"},
			                       	  "op":"=",
			                       	  "value": {"value": "'. $state .'"}
			                       }]',
			         "listFields" => "id, firstname, lastname,StateAUS_131",
		        	 'sort' => 'firstname',
		        	 "start" => $start,
		  			 "range" => $range,
		        	 'sortDir' => 'asc',
			);

    	} 

    	if( empty( $name ) && empty( $state ) ) {

	    	// Count total entries
			$query = array(
			          "condition"     => 
	                      '[{
                              "field":{"field":"BBCustomer_165"},
                              "op":"IN",
							   "value":{"list":[{"value":802},{"value":800}]}
	                       }]',
	        );

	    	/// Query all members
	    	$queryParams = array(
			          "condition"     => 
			                      '[{
		                              "field":{"field":"BBCustomer_165"},
		                              "op":"IN",
									   "value":{"list":[{"value":802},{"value":800}]}
			                       }]',
			         "listFields" => "id, firstname, lastname,StateAUS_131",
		        	 'sort' => 'firstname',
		        	 "start" => $start,
		  			 "range" => $range,
		        	 'sortDir' => 'asc',
		        	 );
	    }

	    //Count All entries
	    $response = $this->ontraport->contact()->retrieveCollectionInfo($query);
        $response = json_decode($response, true);
        $count 	  = $response["data"]["count"];


        // Contat List
		$response = $this->ontraport->contact()->retrieveMultiple($queryParams);
		$response = json_decode($response, true);
		$total_contact = count( $response['data'] );

	
		for( $x = 0; $x < $total_contact;  $x++ )
		{

			$contact[$x]['id'] 			 = $response['data'][$x]['id'];  
			$contact[$x]['firstname'] 	 = $response['data'][$x]['firstname']; 
			$contact[$x]['lastname'] 	 = $response['data'][$x]['lastname']; 
			$contact[$x]['StateAUS_131'] = $response['data'][$x]['StateAUS_131']; 
			$contact[$x]['owner'] 		 = $response['data'][$x]['owner'];  
			$contact[$x]['link'] 		 = site_url() . '/profile?ontraport_id=' . $response['data'][$x]['id'];
			$contact[$x]['photo'] 		 = $this->get_profile_photo($response['data'][$x]['id']);

		}

		//$contact  = array_merge($contact, $response);

		$pages 	  = ceil( $count  / 50 );

		$response = array('success' => true, 'data' => $contact, 'total' => $count, 'pages' => $pages, 'name' => $name, 'state' => $state );

		return wp_send_json_success($response);


	}


	public function get_elite() 
	{

	   $client = $this->ontraport;

	   	$max = 50;
	    $total = $this->get_total_Elite();


		if( $total % $max ) {
	        $lists =  ( $total / $max ) + 1;
	    }
	    else {
	        $lists =  ( $total / $max );
	    }

	     $start = 0;
	     $range = 50;

	     $contact = [];
            
	     for($x = 1; $x <= $lists; $x++) {


	    	  $queryParams = array(
			          "condition"     => 
			                             '[
	                             {
			                              "field":{"field":"BBCustomer_165"},
			                              "op":"IN",
										   "value":{"list":[{"value":802},{"value":800},{"value":1652},{"value":1220},{"value":1759}]}
			                     },
								"AND",
	                             {
			                              "field":{"field":"BBYearLeve_258"},
			                              "op":"IN",
										  "value":{"list":[{"value":1205},{"value":1206},{"value":1207}]}
	                             }

			                            ]',

			         "listFields" => "id, firstname, lastname, BBCustomer_165, JoinedBlue_174, country, BBYearLeve_258",
			         "start" => $start,
		        	 "range" => $range,
		        	 'sort' => 'firstname',
		        	 'sortDir' => 'asc'                  
			    );


			  $response = $client->contact()->retrieveMultiple($queryParams);
			  $response = json_decode($response, true);
			  $response = $response['data'];


			  if ($x == 1) {	

			  	 $contact = $response;

			  }
			  else {
			  	$contact = array_merge($contact, $response);
			  }


			  $start = ( 50 * $x ) + 1;
			  $range = $range + 50;

		}	  



	   return $contact;

	}

	public function get_pastmembers() 
	{

	   $client = $this->ontraport;

	   	$max = 50;
	    $total = $this->get_total_Past();


		if( $total % $max ) {
	        $lists =  ( $total / $max ) + 1;
	    }
	    else {
	        $lists =  ( $total / $max );
	    }

	     $start = 0;
	     $range = 50;

	     $contact = [];
            
	     for($x = 1; $x <= $lists; $x++) {


	    	  $queryParams = array(
			          "condition"     => 
			                             '[{
	                             			
			                              		"field":{"field":"BBCustomer_165"},
			                              		"op":"=",
										   		"value":{"value":916}
			                     		

			                            }]',

			         "listFields" => "id, firstname, lastname, BBCustomer_165, JoinedBlue_174, country, BBYearLeve_258",
			         "start" => $start,
		        	 "range" => $range,
		        	 'sort' => 'firstname',
		        	 'sortDir' => 'asc'                  
			    );


			  $response = $client->contact()->retrieveMultiple($queryParams);
			  $response = json_decode($response, true);
			  $response = $response['data'];


			  if ($x == 1) {	

			  	 $contact = $response;

			  }
			  else {
			  	$contact = array_merge($contact, $response);
			  }


			  $start = ( 50 * $x ) + 1;
			  $range = $range + 50;


	  
		}	  

	   return $contact;

	}

	/** 
	*   Display FastTrack
	*/
	public function display_active_members($atts = '') {
       
       	$this->atts = $atts;

			$atts = shortcode_atts( array(

				'title' => 'BusinessBlueprint Active Members'

			), $this->atts, 'bb_active_members' );

	    ob_start();		
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/active-members-list.php';
	    $output_string = ob_get_contents();
	    if (ob_get_contents()) ob_end_clean();
	    return $output_string;
    }

    public function display_silver($atts) {


       	$this->atts = $atts;

		$atts = shortcode_atts( array(
			'title' => 'BusinessBlueprint Fasttrack Member'
		), $this->atts, 'mbb_silver_membership' );

		
    	$output = $this->isSilverMembership();

    	return $output;

    }



	/** 
	*   Display FastTrack
	*/
	public function display_fasttrackmembers($atts) {
       
       	$this->atts = $atts;

			$atts = shortcode_atts( array(

				'title' => 'BusinessBlueprint Fasttrack Member'

			), $this->atts, 'BB_fastrackMember' );


		ob_start();	
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/fasttrack-members-list.php'; 

		$output_string = ob_get_contents();
		if (ob_get_contents()) ob_end_clean();
		return $output_string;
    }

	/** 
	*   Display Elite
	*/
	public function display_elitemembers($atts) {
       
       	$this->atts = $atts;

			$atts = shortcode_atts( array(

				'title' => 'BusinessBlueprint Elite Member'

			), $this->atts, 'BB_EliteMember' );


		ob_start();	
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/elite-members-list.php'; 
        
		$output_string = ob_get_contents();
		if (ob_get_contents()) ob_end_clean();
		return $output_string;
    }

	/** 
	*   Display Past 
	*/
    public function display_pastmembers($atts) {
       
       	$this->atts = $atts;

			$atts = shortcode_atts( array(

				'title' => 'BusinessBlueprint Past Member'

			), $this->atts, 'BB_PastMember' );

		ob_start();	
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/past-members-list.php'; 

		$output_string = ob_get_contents();
		if (ob_get_contents()) ob_end_clean();
		return $output_string;
    }


    public function generate_membership_form($atts) {
      
       	$this->atts = $atts;

			$atts = shortcode_atts( array(

				'title' => 'BusinessBlueprint Past Member'

			), $this->atts, 'MBB_update_info' );

		$this->getContactMeta();

		ob_start();
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/edit-membership-info.php'; 
		$output_string = ob_get_contents();
		if (ob_get_contents()) ob_end_clean();
		return $output_string;
    }


    public function your_consultant() {
      
		//Get Email
		$user =  wp_get_current_user();

		$email = $user->user_email;


		//connect ontraport
		$client = $this->ontraport;

		//query ontraport database
	    $queryParams = array(

	          "condition"     => 
	                             '[{
				"field":{"field":"email"},
				"op":"=",
				"value":{"value":"'. $email .'"}

				}]',
				"listFields" => "owner",
		);

		$response 				= $client->contact()->retrieveMultiple($queryParams);
		$response 				= json_decode($response, true);
		$response 				= $response['data'];

		$this->owner 			= $this->getConsultant($response[0]['owner']);
    	return $this->owner;
    }


	/** 
	*   Update Contact Page
	*/
    public function update_contact() {
  	

    	if( ! isset( $_POST['update_ontra_field'] ) || ! wp_verify_nonce( $_REQUEST['update_ontra_field'], 'update_ontra_action') ) {

    		die('Sorry unable to verify nonce');

    	}
    	if( !current_user_can('subscriber') && !current_user_can('editor') && !current_user_can('administrator')   )
		{
			wp_send_json_error('You are not an authorized user!');
    	}

    			$about 				= wp_strip_all_tags( $_POST['about_me']);
		     	$firstname 			= sanitize_text_field( $_POST['firstname'] );
		     	$lastname 			= sanitize_text_field( $_POST['lastname'] );
				$address 			= sanitize_text_field( $_POST['address'] );
				$address2 			= sanitize_text_field( $_POST['address2'] );
				$city 				= sanitize_text_field( $_POST['city'] );
				$state 				= sanitize_text_field( $_POST['state'] );
				$zip				= sanitize_text_field( $_POST['zip'] );
		     	$mobile_no 			= sanitize_text_field( $_POST['mobile_no'] );
		     	$company 			= sanitize_text_field( $_POST['company'] );
		     	$business_type 		= sanitize_text_field( $_POST['business_type'] );
		     	$website 			= sanitize_text_field( $_POST['website'] );
		     	$office_phone 		= sanitize_text_field( $_POST['office_no'] );
		     	$category   		= wp_strip_all_tags(sanitize_text_field( $_POST['business_category'] ) );

		     	$hide_firstname 	= sanitize_text_field( $_POST['hide_firstname'] );
		     	$hide_lastname 		= sanitize_text_field( $_POST['hide_lastname'] );
				$show_address 		= sanitize_text_field( $_POST['show_address'] );
				$show_mobile_no	 	= sanitize_text_field( $_POST['show_mobile'] );
				$hide_state	 		= sanitize_text_field( $_POST['hide_state'] );
				$show_company 		= sanitize_text_field( $_POST['show_company'] );
		     	$show_business_type = sanitize_text_field( $_POST['show_business_type'] );
		     	$show_website 		= sanitize_text_field( $_POST['show_website'] );
		     	$show_office_phone 	= sanitize_text_field( $_POST['show_office_no'] );
		     	$show_email	 		= sanitize_text_field( $_POST['show_email'] );


		     	$user_id = $this->get_ontraport_id();

		     	$meta_value = array(
		     			'hide_firstname' => 1,
		     			'hide_lastname' => 1,
		     			'hide_state' => 1,
		     			'show_address' => 1,
		     			'show_mobile' => 1,
		     			'show_email' => 1,
		     			'show_company' => 1,
		     			'show_business_type' => 1,
		     			'show_website' => 1,
		     			'show_office_no' => 1,

		     		);

		     	update_user_meta( $user_id, 'ontra_member_fields', $meta_value );

		     	if( !empty($about) ) {
					update_user_meta( $user_id, 'about_me', $about);
				} else {
					delete_user_meta( $user_id, 'about_me');
				}

				if( !empty($hide_firstname) ) {
					update_user_meta( $user_id, 'hide_firstname', 1);
				} else {
					delete_user_meta( $user_id, 'hide_firstname', 1);
				}

				if( !empty($hide_lastname) ) {
					update_user_meta( $user_id, 'hide_lastname', 1);
				} else {
					delete_user_meta( $user_id, 'hide_lastname', 1);
				}

				if( !empty( $hide_state ) ) {
					update_user_meta( $user_id, 'hide_state', 1);
				} else {
					delete_user_meta( $user_id, 'hide_state', 1);
				}

				if( empty($show_address) ) {
					update_user_meta( $user_id, 'show_address', 1);
				} else {
					delete_user_meta( $user_id, 'show_address', 1);
				}
		     	
		     	if( empty($show_mobile_no) ) {
					update_user_meta( $user_id, 'show_mobile', 1);
				} else {
					delete_user_meta( $user_id, 'show_mobile', 1);
				}

				if( empty($show_email) ) {
					update_user_meta( $user_id, 'show_email', 1);
				} else {
					delete_user_meta( $user_id, 'show_email', 1);
				}

				if( empty($show_company) ) {
					update_user_meta( $user_id, 'show_company', 1);
				} else {
					delete_user_meta( $user_id, 'show_company', 1);
				}

				if( empty($show_business_type) ) {
					update_user_meta( $user_id, 'show_business_type', 1);
				} else {
					delete_user_meta( $user_id, 'show_business_type', 1);
				}

				if( empty($show_website) ) {
					update_user_meta( $user_id, 'show_website', 1);
				} else {
					delete_user_meta( $user_id, 'show_website', 1);
				}

				if( empty($show_office_phone) ) {
					add_user_meta( $user_id, 'show_office_no', 1);
				} else {
					delete_user_meta( $user_id, 'show_office_no', 1);
				}


				if( !empty($category) ) {
					update_user_meta( $user_id, 'business_category', $category);
				} else {
					delete_user_meta( $user_id, 'business_category');
				}



				$client 		= $this->ontraport;

			    $queryParams = array(
						"id"          	 => $this->get_ontraport_id(),
				        "firstname"   	 => $firstname,
				        "lastname"    	 => $lastname,
				        "cell_phone"  	 => $mobile_no,
				        "address"     	 => $address,
				        "address2"    	 => $address2,
				        "city"        	 => $city,
				        "StateAUS_131"   => $state,
				        "zip"         	 => $zip,
				        "company"        => $company,
				        "website"        => $website,
				        "office_phone"   => $office_phone,  
				);


				$response = $client->contact()->update($queryParams);
				$response = json_decode($response, true);
				$response = $response['data'];


			

				$url = site_url() . '/your-profile';

				wp_redirect( $url );

				die();
				

    }

	public function getContactMeta() {

		//Get Email
		$email = $this->getEmail();

		//connect ontraport
		$client = $this->ontraport;

		//query ontraport database
	    $queryParams = array(

	          "condition"     => 
	                             '[{
				"field":{"field":"email"},
				"op":"=",
				"value":{"value":"'. $email .'"}
				}]'
		);

	    //response from ontraport server
		$response 				= $client->contact()->retrieveMultiple($queryParams);
		$response 				= json_decode($response, true);
		$response 				= $response['data'];
		$this->email 			= $email;
		$this->id 				= $response[0]['id'];
		$userID 				= get_current_user_id();

		if( ! $this->get_ontraport_id() ) {
			$this->set_ontraport_id( $this->id );
		}

		$this->firstname 		= $response[0]['firstname'];
		$this->lastname 		= $response[0]['lastname'];
		$this->website   		= $response[0]['website'];
		$this->address 			= $response[0]['address'];
		$this->address2 		= $response[0]['address2'];
		$this->city 			= $response[0]['city'];
		$this->state_edit       = $response[0]['StateAUS_131']; 
		//$this->state 			= $this->get_state( $response[0]['StateAUS_131'] );
		$this->zipcode 			= $response[0]['zip'];
		$this->country 			= $response[0]['country'];
		$this->mobile_no 		= $response[0]['cell_phone'];
		$this->office_no 		= $response[0]['office_phone'];
		$this->company 			= $response[0]['company'];
		$this->year_level 		= $this->getYearLevel($response[0]['BBYearLeve_258']);
	    $aff_link               = $response[0]['f1608'];

	    $this->affiliate_link  = str_replace('*****', $this->id, $aff_link );

		if( !empty( $response[0]['BBCustomer_165'] ) ) {
			$this->customer_type 	= $this->getCustomerType($response[0]['BBCustomer_165']);
		}
		else {
			$this->customer_type 	= "N/A";
		}

		if( !empty( $response[0]['JoinedBlue_174'] ) ) {
			$this->joined_date		= date('m-d-Y', $response[0]['JoinedBlue_174']);
		}
		else {
			$this->joined_date 		= "N/A";
		}

		if( !empty( $response[0]['RenewalDat_214'] ) ) {
			$this->renew_date		= date('m-d-Y',$response[0]['RenewalDat_214']);
		}
		else {
			$this->renew_date 		= "N/A";
		}
	
		$this->business_type 		= $response[0]['TestDropBo_234'];
		$this->owner 				= $this->getConsultant($response[0]['owner']);
		$this->thumbnail		    = $this->get_profile_photo($response[0]['id']);
		$this->yearlevel 		    = $this->getYearLevel($response[0]['BBYearLeve_258']);
		$this->about_me             = get_user_meta( $this->id, 'about_me', true );
		$this->business_category    = get_user_meta( $this->id, 'business_category', true );
	}


	/**
	 * Get user's ontraport information
	 * @param  int   $id  Ontraport Id
	 * @return strings          
	 */
	public function get_single_user($id) {

		$id = esc_attr($id);

		//connect ontraport
		$client = $this->ontraport;

		//query ontraport database
	    $queryParams = array(

	          "id" => $id
		);

	    //response from ontraport server
		$response 				= $client->contact()->retrieveSingle($queryParams);
		$response 				= json_decode($response, true);
		$response 				= $response['data'];
		$this->id 				= $id;

		$this->firstname 		= $response['firstname'];
		$this->lastname 		= $response['lastname'];
		$this->website   		= $response['website'];
		$this->address 			= $response['address'];
		$this->address2 		= $response['address2'];
		$this->city 			= $response['city'];
		$this->state 			= $response['state'];
		$this->zipcode 			= $response['zip'];
		$this->country 			= $response['country'];
		$this->mobile_no 		= $response['cell_phone'];
		$this->office_no 		= $response['office_phone'];
		$this->company 			= $response['company'];
		$this->email 			= $response['email'];
		$this->year_level 		= $this->getYearLevel($response['BBYearLeve_258']);
	    $aff_link               = $response['f1608'];

	    $this->affiliate_link  = str_replace('*****', $this->id, $aff_link );

		if( !empty( $response['BBCustomer_165'] ) ) {
			$this->customer_type 	= $this->getCustomerType($response['BBCustomer_165']);
		}
		else {
			$this->customer_type 	= "N/A";
		}

		if( !empty( $response['JoinedBlue_174'] ) ) {
			$this->joined_date		= date('m-d-Y', $response['JoinedBlue_174']);
		}
		else {
			$this->joined_date 		= "N/A";
		}

		if( !empty( $response['RenewalDat_214'] ) ) {
			$this->renew_date		= date('m-d-Y',$response['RenewalDat_214']);
		}
		else {
			$this->renew_date 		= "N/A";
		}
	
		$this->business_type 		= $response['TestDropBo_234'];
		$this->owner 				= $this->getConsultant($response['owner']);
		$this->thumbnail		    = $this->get_profile_photo($response['id']);
		$this->yearlevel 		    = $this->getYearLevel($response['BBYearLeve_258']);
		$this->about_me 			= get_user_meta( $this->id, 'about_me', true );
	}


    /**
    * Helpers
    *
    */
	public function get_contactInfo() {
	
		ob_start();
		$this->getContactMeta();
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/profile.php';
	    $output_string = ob_get_contents();
	    if (ob_get_contents()) ob_end_clean();
	    return $output_string;

	}

	/**
	 *  Display user profile
	 * @return [type] [description]
	 */
	public function user_profile()
	{	

		ob_start();
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/single-profile.php';
	    $output_string = ob_get_contents();
	    if (ob_get_contents()) ob_end_clean();
	    return $output_string;

	}

	public function getMeta( $type ) {

		$client = $this->ontraport;

		$response 				=  $client->contact()->retrieveMeta();
		$response 				=  json_decode($response, true);
		$response				=  $response['data'][0];

		if( $type == 'business_type' ) {

			$response = $response['fields']['TestDropBo_234']['options'];

		} elseif( $type == 'states' ) {

			$response = $response['fields']['StateAUS_131']['options'];

		} 

		return $response;
	}


	/**
	* Generate html select options
	*
	* @param value, html class, input field name, meta from ontraport
	*/
	public function getOptions( $curValue = '', $class = '', $name = '', $meta = 'business_type' ) {

		$response = $this->getMeta($meta);

		$output = '<select name="'. $name .'" class="'. $class .'">';

			foreach($response as $key => $value) :
				$selected = ($curValue == $key ) ? "selected" : "";

				if( $meta == 'states' ) {

					switch( $value ) {

						case 'NSW':
							$value = 'New South Wales';
							break;
						case 'VIC':
							$value = 'Victoria';
							break;
						case 'QLD':
							$value = 'Queensland';
							break;
						case 'WA':
							$value = 'Western Australia';
							break;
						case 'SA':
							$value = 'South Australia';
							break;	
						case 'TAS':
							$value = 'Tasmania';
							break;	
						case 'ACT':
							$value = 'Australian Capital Territory';
							break;		
						case 'NT':
							$value = 'Northern Territory';
							break;						
						default:
							break;	

					}

				}

				$output .= '<option value="'. $key .'" '. $selected .'>' . $value. '</option>';
			endforeach;

		$output .= '</select>';

		return $output;
	}


	/**
	* Generate Customer State
	*
	* @param string
	* @return string
	*/
	public function get_state( $state_id = '' ) {

			if( $state_id === '' )
					return false;
	
			switch( $state_id ) {

				case '747':
					$value = 'New South Wales';
					break;
				case '748':
					$value = 'Victoria';
					break;
				case '749':
					$value = 'Queensland';
					break;
				case '750':
					$value = 'Western Australia';
					break;
				case '751':
					$value = 'South Australia';
					break;	
				case '752':
					$value = 'Tasmania';
					break;	
				case '753':
					$value = 'Australian Capital Territory';
					break;		
				case '754':
					$value = 'Northern Territory';
					break;	
				case '763':
					$value = 'Outside Australia';
					break;						
				default:
					break;	

			}

		return $value;
	}


	public function getOntraportValue( $curValue = '', $meta = '') {


		if( !$meta && !$curValue ) {
			return;
		}
		
		$response = $this->getMeta($meta);

			if($response) {
				foreach($response as $key => $value) :

					if ($curValue == $key ) {
						return $value;
					} 

				endforeach;
			}

		return $output = "N/A";

	}


    public function upload_user_photo( $file = array(), $id  = '') {

    	if( empty($id) )
    			return false;	

    	//include admin for upload 
	    require_once( ABSPATH . 'wp-admin/includes/image.php' );
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	    require_once( ABSPATH . 'wp-admin/includes/media.php' );

	    $file_return = wp_handle_upload( $file, array('test_form' => false ) );

        if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {

          return false;

        } else {

	          $filename = $file_return['file'];

	          $attachment = array(
	              'post_mime_type' => $file_return['type'],
	              'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
	              'post_content' => '',
	              'post_status' => 'inherit',
	              'guid' => $file_return['url']
	          );

	          $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );

	          //update or add user meta name: user_photo
	          update_user_meta( $id, 'user_photo', $attachment_id  );

	          $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );

	          wp_update_attachment_metadata( $attachment_id, $attachment_data );

	          if( 0 < intval( $attachment_id ) ) {
	          	return $attachment_id;
	          }
	      }
	      return false;

	      exit();

	}


    public function uploadNewPhoto( $file = array(), $id  = '') {

    	if( ! isset( $_POST['ontra_security_field'] ) || ! wp_verify_nonce( $_REQUEST['ontra_security_field'], 'ontra_security_action') ) {

    		die('Sorry unable to verify nonce');

    	}

    	if( !current_user_can('subscriber') && !current_user_can('editor') && !current_user_can('administrator')   )
		{
			wp_send_json_error('You are not an authorized user!');

    	} else {


    	$user_id   = $this->get_ontraport_id();

    	//include admin for upload 
	    require_once( ABSPATH . 'wp-admin/includes/image.php' );
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	    require_once( ABSPATH . 'wp-admin/includes/media.php' );

		//
		$file             = $_FILES['file'];
		$upload_overrides = array('action' => 'upload_new_photo');

		$movefile = wp_handle_upload( $file, $upload_overrides );
	
		//if ( is_wp_error( $attachment_id ) ) {
		if( !$movefile && !isset( $movefile['error'] ) ) {

			wp_send_json_error('Can\'t save the image!');
   
		} else {

			$img_url        = $movefile['url'];
			$update_photo   = update_user_meta( $user_id, 'new_uploaded_photo', $img_url  );
			$generate_image = '<img src="'. $img_url .'" id="cropbox" />';

			$data = array(
					'photo_link' => $generate_image
			);

	        wp_send_json_success( $data );
		}	


	  }

	  die();

	}

    public function update_profile_photo() {

  		$nonce = $_POST['update_photo_field'];


    	if( ! isset( $_POST['update_photo_field'] ) || ! wp_verify_nonce( $_REQUEST['update_photo_field'], 'update_photo_action') ) {

    		die('Sorry unable to verify nonce');

    	}

    	if( !current_user_can('subscriber') && !current_user_can('editor') && !current_user_can('administrator')   )
		{
			wp_send_json_error('You are not an authorized user!');
    	}

    	// Add file if function exists
    	if ( ! function_exists( 'wp_handle_upload' ) ) {
		    require_once( ABSPATH . 'wp-admin/includes/image.php' );
		    require_once( ABSPATH . 'wp-admin/includes/file.php' );
		    require_once( ABSPATH . 'wp-admin/includes/media.php' );
		}

		$user 			= wp_get_current_user();
    	$id   			= $this->get_ontraport_id();
	    $image_url      = get_user_meta( $id, 'new_uploaded_photo', true  );

		$targ_w = $targ_h = 240;
		$jpeg_quality = 90;
		$src          = $image_url;

		if ( preg_match('/(\.jpg|\.JPG|\.JPEG|\.jpeg)$/i', $src) ) {
			$img_r = imagecreatefromjpeg($src);
		} elseif( preg_match('/(\.png|\.PNG)$/i', $src)  ) {
			$img_r = imagecreatefrompng($src);
		}
        
			

		//Create a new true color image
		$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

		//Copy and resize part of the image
		imagecopyresampled( $dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h'] );

		$upload_dir   = wp_upload_dir();
		

		if ( preg_match('/(\.jpg|\.JPG|\.JPEG|\.jpeg)$/i', $src) ) {
			$filename     = 'profile-picture-'. $id . '-' . time() . '.jpg';
		} elseif( preg_match('/(\.png|\.PNG)$/i', $src)  ) {
			$filename     = 'profile-picture-'. $id . '-' . time() . '.png';
		}

		
		if( isset( $user->user_login ) && ! empty( $upload_dir['basedir'] ) ) {
			$profile_folder = $upload_dir['basedir'] . '/profile';

			if( !file_exists( $profile_folder))
			 	  wp_mkdir_p($profile_folder);

		 	if( $dst_r && $profile_folder ) {
		 		$distfile = $profile_folder . '/'. $filename;
				$is_image_uploaded = imagejpeg($dst_r, $distfile, 90);
		 	}
		}
		

		if( $is_image_uploaded) {
			$id = $this->get_ontraport_id();
			$photo_link = $upload_dir['baseurl'] .'/profile/'. $filename;
			$update_photo = update_user_meta( $id, 'user_photo', $photo_link );

			$url = site_url() . '/your-profile';
	        wp_redirect( $url );
	        die();
	        
		} else {
			$url = get_permalink();
	        wp_redirect($url);
			die();
		}

	

	    $file_return = wp_handle_upload( $link, array('test_form' => false ) );

	    if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {

	          return false;

	    } else {

	          $filename = $file_return['file'];

	          $attachment = array(
	              'post_mime_type' => $file_return['type'],
	              'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
	              'post_content' => '',
	              'post_status' => 'inherit',
	              'guid' => $file_return['url']
	          );

	          $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );

	          //update or add user meta name: user_photo
	          update_user_meta( $id, 'user_photo', $attachment_id  );

	          $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );

	          wp_update_attachment_metadata( $attachment_id, $attachment_data );

	          if( 0 < intval( $attachment_id ) ) {
	          	return $attachment_id;
	          }
	    }

	    $url = site_url() . '/your-profile';
	    wp_redirect($url);
	    die();

	}

	public function getLatestUploads() {
		$videoInfo = $this->wistia;

 		ob_start();		
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/template-latest-uploads.php';
	    $output_string = ob_get_contents();
	    if (ob_get_contents()) ob_end_clean();
	    return $output_string;
	}

	/**
	 * Retreive the thumbnail of the Wistia Video
	 * @param   
	 * @return string 
	 */
	public function getPostImage() {
		                
		if( ! isset( $_POST['security'] ) || ! check_ajax_referer( 'ontra_security_action', 'security') ) {
			return wp_send_json_error();
		}

		if( current_user_can('subscriber') &&  current_user_can('administrator') ) {
			return wp_send_json_error();
		}

		$id = $_POST['id'];

		$videoInfo = $this->wistia;

		$video 			= $videoInfo->mediaShow( $id );
        $img_url 		= $video->thumbnail->url;
        $img_title 		= $video->name;
		$video_stats 	= $videoInfo->mediaShowStats($id);
		$total_plays	= $video_stats->stats->plays;
        $data = array(
        	'img_link' => $img_url,
        	'id' => $id,
        	'title' => $img_title,
        	'total_plays' => $total_plays 
        );


	    return wp_send_json_success($data);
	}

	public function getFeaturedVideos() {
		$videoInfo = $this->wistia;


 		ob_start();		
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/template-featured-videos.php';
	    $output_string = ob_get_contents();
	    if (ob_get_contents()) ob_end_clean();
	    return $output_string;
	}


	public function getSuccessStories() {
		$videoInfo = $this->wistia;

 		ob_start();		
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/template-success-stories.php';
	    $output_string = ob_get_contents();
	    if (ob_get_contents()) ob_end_clean();
	    return $output_string;
	}


	public function getBusinessType($id) {

		switch($id) {
			case '1076':
				return 'Accountants & Finance';
				break;
			case '1077':
				 return 'Property & Investing';
				 break;
			case '1078':
				 return 'Health & Wellness';
				 break;
			case '1079':
				 return 'Coaching & Speaking';
				 break;	 
			case '1108':
				 return 'Professional Services';
				 break;	
			case '1109':
				 return 'Trade Based Business';
				 break;	
			case '1110':
				 return 'Retail & Online Sales';
				 break;	
			case '1110':
				 return 'Lifestyle & Leisure';
				 break;	
			case '1112':
				 return 'International Business';
				 break;		 	 	 	 	 	 
			default:
				return 'N/A';
				break;	 
		}	
	}

	public function getYearLevel($id) {

		switch($id) {

			case '1204': 
				  return 'Fast-Track';
				  break;
			case '1205': 
				  return 'Elite - VIP';
				  break;
			case '1206': 
				  return 'Elite - All Stars';
				  break;
			case '1207': 
				  return 'Elite - Masters';
				  break;
			default:
				  return 'N/A';
				  break;	  

		}
	}

    
	public function display_pagination( $max = 50) 
	{
	    $output = '';

	    $total = $this->get_total_active_members();


	    if( $total % $max ) {
	        $lists =  ( $total / $max ) + 1;
	    }
	    else {
	        $lists =  ( $total / $max );
	    }


	          $current_page = max(1, get_query_var('paged'));
	   

	          $output .= paginate_links(array(
	              'base' => get_pagenum_link() . '%_%',
	              'format' => 'page/%#%',
	              'current' => $current_page,
	              'total' => $lists,
	              'before_page_number' => '',
	              'after_page_number'  => '',
	              'type'               => 'list',
	          ));

	  
	    
	      return $output;
	        
	  }


	public function getConsultant($id) {


		switch($id) {
			case '13':
				return 'Beau Chase';
				break;
			case '22':
				 return 'Luke Ahearn';
				 break;
			default:
				return 'Support';
				break;	 
		}	
	}


	public function getCustomerType($id) {

		switch($id) {
			case '800':
				return 'Gold';
				break;
			case '802':
				 return 'Platinum';
				 break;
			case '917':
				 return 'BB Team';
				 break;
			case '982':
				 return 'BB Mentor';
				 break;
			case '1652':
				 return 'BB Scholar';
				 break;
			case '1759':
				 return 'BB Platinum - Ruby Pass';
				 break;	 
			default:
				return '';
				break;	 
		}	
	}


	public function get_country($code) {

		switch($code) {
			case 'AU':
				return 'Australia';
				break;
			case 'NZ':
				 return 'New Zealand';
				 break;	 
			default:
				return '';
				break;	 
		}	

	}


	/** 
	*   Get Email from Wordpress
	*   @return email
	*/
	private function getEmail() {

		// Get User in WP
		$user =  wp_get_current_user();

		// Get user email
		$email = $user->user_email;	

		return $email;	
	}


    /**
    * Get member type on Ontraport
    *	 
    * @return member type
    */
	public function get_member_type() {

		$client = $this->ontraport;
		$user   =  wp_get_current_user();
		$email 	= $user->user_email;

			
	    $queryParams = array(
			          "condition"     => 
			                             '[{
						"field":{"field":"email"},
						"op":"=",
						"value":{"value":"'. $email .'"}
						}]',

			         "listFields" => "id, firstname, lastname, BBCustomer_165, JoinedBlue_174, country, BBYearLeve_258",
		);


		$response = $client->contact()->retrieveMultiple($queryParams);
		$response = json_decode($response, true);
		$response = $response['data'];

		 
		if($response[0]['BBCustomer_165'] === '800' && $response[0]['BBYearLeve_258'] === '1204' ) {
			// Fasttrack Gold
			$member_type = 'Fasttrack Gold';
		}
		else if($response[0]['BBCustomer_165'] === '802' && $response[0]['BBYearLeve_258'] === '1204' ) {
			// Fasttrack Platinum
			$member_type = 'Fasttrack Platinum';
		}
		else if( $response[0]['BBCustomer_165'] === '800' && $response[0]['BBYearLeve_258'] !== '1204') {
			$member_type = 'Elite Gold';
		}
		else if( $response[0]['BBCustomer_165'] === '802' && $response[0]['BBYearLeve_258'] !== '1204') {
			$member_type = 'Elite Platinum';
		}
		else if( $response[0]['BBCustomer_165'] === '917' || $response[0]['BBCustomer_165'] === '1652' || $response[0]['BBCustomer_165'] === '1220' || $response[0]['BBCustomer_165'] === '1759' || $response[0]['BBCustomer_165'] === '982' && $response[0]['BBYearLeve_258'] !== '1204') {
			$member_type = 'Elite Platinum';
		}
		else {
			$member_type = 'N/A';
		}
		
		return  $member_type;
	}




	public function isSilverMembership() {

		$client = $this->ontraport;

		$user =  wp_get_current_user();

		$email = $user->user_email;

			
	    $queryParams = array(

			          "condition"     => 
			                             '[{
						"field":{"field":"email"},
						"op":"=",
						"value":{"value":"'. $email .'"}
						}]',

			         "listFields" => "id, firstname, lastname, BBCustomer_165",
		);


		$response = $client->contact()->retrieveMultiple($queryParams);
		$response = json_decode($response, true);
		$response = $response['data'];

		// Fasttrack and Gold Member
		if($response[0]['BBCustomer_165'] === '1831' ) {
			return true;
		}
		else {
			return false;
		}
			

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

	/** 
	*   Thumbnail for user profile
	*
	*  @param int Ontraport ID
	*  @return url of the image
	*/
    public function get_profile_photo( $id ) {

	     // Check if user has user photo in the meta table
        $image = get_user_meta( $id, 'user_photo', true );  

        if( $image ) {
        	if( ! wp_get_attachment_url( $image ) ) {
        		$image_link = $image;
        	} else {
                $image_link =  wp_get_attachment_url( $image );
        	}
        } else {
        	$image_link = $this->get_defaultThumbnail();
        }

        return $image_link;

    }

    /** 
	*   Thumbnail for user profile
	*
	*  @param int Ontraport ID
	*  @return url of the image
	*/
    public function get_photo_ajax( $id ) {

    	// Check if user has user photo in the meta table
        $image = get_user_meta( $id, 'user_photo', true );  

        if( $image ) {
        	return wp_get_attachment_url($image);
        }

    	return $this->get_defaultThumbnail();
    	
    }



	/** 
	*   Thumbnail for user profile
	*
	*  @param int Ontraport ID
	*  @param bool 
	*/
    public function get_thumbnail( $id ) {

    	// Check if user has user photo in the meta table
        $image = get_user_meta( $id, 'user_photo', true );  

        if( $image ) {
        	return wp_get_attachment_url($image);
        }

    	return $this->get_defaultThumbnail();
    }

    /** 
	*   get Thumbnail Url
	*/
    public function get_defaultThumbnail($name = '') { 

    	return plugin_dir_url( __FILE__ ) . 'image/user-icon.png';

    }

    public function get_color( $owner ) {

    	if($owner == '22') {
    		$output = 'bg-Blue';
    	}
    	else if($owner == '13') {
			$output = 'bg-Orange';
    	}
    	else {
    		$output = '';
    	}
    	return $output;
    }

    public function get_total_FT() {


		$client = $this->ontraport;
	    $queryParams = array(
	          "condition"     => 
	                             '[
	                             {
			                              "field":{"field":"BBCustomer_165"},
			                              "op":"IN",
										  "value":{"list":[{"value":802},{"value":800},{"value":1652},{"value":1220},{"value":1759}]}
			                     },
								"AND",
	                             {
			                              "field":{"field":"BBYearLeve_258"},
			                              "op":"=",
										  "value":{"value":"1204"}
	                             }
	                             
			                                                         

	                            ]');

	    $response = $client->contact()->retrieveCollectionInfo($queryParams);
	    $response = json_decode($response, true);
	    $count = $response["data"]["count"];

		return $count;

	}

	public function get_total_Elite() {


		$client = $this->ontraport;
	    $queryParams = array(
	          "condition"     => 
	                             '[
	                             {
			                              "field":{"field":"BBCustomer_165"},
			                              "op":"IN",
										  "value":{"list":[{"value":802},{"value":800},{"value":1652},{"value":1220},{"value":1759}]}
			                     },
								"AND",
	                             {
			                              "field":{"field":"BBYearLeve_258"},
			                              "op":"IN",
										  "value":{"list":[{"value":1205},{"value":1206},{"value":1207}]}
	                             }
	                             
			                             
	                             

	                            ]'                
	    );

	    $response = $client->contact()->retrieveCollectionInfo($queryParams);
	    $response = json_decode($response, true);
	    $count = $response["data"]["count"];



		return $count;
	
	}

	public function get_total_Past() {


		$client = $this->ontraport;
	    $queryParams = array(
	          "condition"     => 
	                             '[{
	                             
			                              "field":{"field":"BBCustomer_165"},
			                              "op":"=",
										  "value":{"value":916}
			                    


	                            }]'                
	    );

	    $response = $client->contact()->retrieveCollectionInfo($queryParams);
	    $response = json_decode($response, true);
	    $count = $response["data"]["count"];

		return $count;
	
	}
	public function get_wp_id() {

		return get_current_user_id();

	}
	private function get_ontraport_id() {

		return get_post_meta( get_current_user_id(), 'ontraport_id', true );

	}
	private function set_ontraport_id($id) {

		update_post_meta( get_current_user_id(), 'ontraport_id', $id  );

	}
	
}
