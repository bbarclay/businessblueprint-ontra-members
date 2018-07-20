<?php


if( !class_exists('MyBB_Affiliate_Centre') ) :

   class MyBB_Affiliate_Centre {

   		public $email;
   		private $ontraport;


		/**
   		*
   		*  Default Values 
   		*
   		*
   		**/
   		public function __construct(Ontraport_API $ontraport ) {
			$this->ontraport = $ontraport;
   			add_shortcode('mbb_affiliate_centre', array( $this, 'affiliate_centre' ) );

   		}	

   		/**
   		*
   		*  Display affiliate Centre
   		*
   		*
   		**/
		public function affiliate_centre( $atts ) 
		{

		    $queryParams = array(
		          "condition"     => 
		                             '[{
		                              "field":{"field":"email"},
		                              "op":"=",
		                              "value":{"value":"'. $this->user_email() .'"}
		                            }]',

		          "listFields" => "id"                   
		    );
		 


		   $response = $this->ontraport->connect()->contact()->retrieveMultiple($queryParams);
		   $response = json_decode($response, true);
		   $id 		 = (int)$response['data'][0]['id'];

		   $referrals   = $this->get_referrals($id); 
		   $pagination  = $this->display_pagination($id);
		   $members 	= $this->get_blueprint_referrals($id);
		 
		  ob_start();	
		  require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/affiliate_page.php';
		  $output_string = ob_get_contents();
	      if (ob_get_contents()) ob_end_clean();
	      return $output_string;

		}

		/**
   		*
   		*  Get referrals from Ontraport
   		*
   		*
   		**/
		public function get_referrals($contact_id = '') {

	        $paged = (int)get_query_var( 'paged', 1 );
 
	       if($paged) {
				$x 		= $paged - 1;
				$start  = ( 50 * $x ) + 1;
				$range  = ( $start + 50 ) - 1;
	        }
	        else {
			        $start = 0;
			        $range = 50;
		     }

		      $queryParams = array(
		          "condition"     => '[{
		                              "field":{"field":"freferrer"},
		                              "op":"=",
		                              "value":{"value":"'. $contact_id .'"}
		                            }]',
		          "sort"       => "timestamp",
		          "sortDir"    => "desc",
		          "listFields" => "id,firstname,lastname,email,id,contact_cat,Date_232,JoinedBlue_174,f1634,f1770,BBCustomer_165,f1723,f1559,f1813,f1814",
		          "start" => $start,
		          "range" => $range                     
		    );
		 

		    $response = $this->ontraport->connect()->contact()->retrieveMultiple($queryParams);
		    $res = json_decode($response, true);


		    $count = 0;
		    $output = array();

		    if(!empty($res['data'])) {
		        for($x = 0; $x < count($res["data"]); $x++ ) {

		          $output[$x]['firstname']  = $res["data"][$x]['firstname'];
		          $output[$x]['lastname']   = $res["data"][$x]['lastname'];
		          $output[$x]['email']      = $res["data"][$x]['email'];
		          $output[$x]['city']       = $this->get_city( $res["data"][$x]['f1813'], $res["data"][$x]['f1723']); 

		          $output[$x]['event_date'] = $this->get_date($res["data"][$x]['f1814'],$res["data"][$x]['Date_232'] );
		          $output[$x]['attended']   = $this->has_attended( $res["data"][$x]['contact_cat'], $res["data"][$x]['Date_232']);
		    
		        }

		    } else {
		       $output = false;
		    }    
		    
		  return $output;

		}

		public function get_blueprint_referrals( $contact_id = '') {

	
		      $queryParams = array(
		          "condition"     => '[{
		                                "field":{"field":"freferrer"},
		                                "op":"=",
		                                "value":{"value":"'. $contact_id .'"}
		                               },
		                               "AND",
		                               {
		                                "field":{"field":"BBCustomer_165"},
		                                "op":"=",
		                                "value":{"value":"802"}
		                               },
		                               "OR",
		                               {
		                                "field":{"field":"freferrer"},
		                                "op":"=",
		                                "value":{"value":"'. $contact_id .'"}
		                               },
		                               "AND",
		                               {
		                                "field":{"field":"BBCustomer_165"},
		                                "op":"=",
		                                "value":{"value":"800"}
		                               }]',
		          "sort"       => "timestamp",
		          "sortDir"    => "desc",
		          "listFields" => "id,firstname,lastname,f1770,BBCustomer_165,f1634,JoinedBlue_174,f1820"
		                   
		    );
		 


		  $response = $this->ontraport->connect()->contact()->retrieveMultiple($queryParams);
		  $resx = json_decode($response, true);

		  //return $resx;
		  $count = 0;
		  $output = array();

		    if(!empty($resx['data'])) {
		    
		  
		        for($x = 0; $x < count($resx["data"]); $x++ ) {


	                  $output[$x]['is_paid']    = $resx["data"][$x]['f1770'];
	                  $output[$x]['firstname']  = $resx["data"][$x]['firstname'];
	                  $output[$x]['lastname']   = $resx["data"][$x]['lastname'];

	          
	                        if ($resx['data'][$x]['BBCustomer_165'] == '802' ) {
	                           $output[$x]['member_type'] = 'Platinum Member';


	                             if( $resx['data'][$x]['f1820']) {

	                                $output[$x]['referral_fee'] = '$400';

	                             }
	                             else {

	                               $output[$x]['referral_fee'] = '$800';

	                             }

	                        }
	                        else if ( $resx['data'][$x]['BBCustomer_165'] == '800' ) {
	                            $output[$x]['member_type'] = 'Gold Member';


	                             if( $resx['data'][$x]['f1820']) { 

	                                $output[$x]['referral_fee'] = '$250';

	                             }
	                             else {

	                                $output[$x]['referral_fee'] = '$500';

	                             }

	                        }

	                        if( $resx["data"][$x]['JoinedBlue_174'] ) {

	                          $output[$x]['joined_date'] = date('d-m-Y', $resx["data"][$x]['JoinedBlue_174']);

	                        } else {

	                          $output[$x]['joined_date'] = 'N/A';

	                        }


	                        if( $resx["data"][$x]['f1634'] ) {

	                          $output[$x]['payment_date'] = date('d-m-Y', $resx["data"][$x]['f1634']);

	                        } else {

	                          $output[$x]['payment_date'] = false;

	                        }

		        }
		        return $output;

		    } else {
		       
		       return $output = false;
		    }    
		    


		  }

		 public function is_paid( $value = '') {

		   if($value == true) {
		      $output = 'YES';
		   }
		   else {
		      $output = ' ';
		   }
		   return $output;
		 }

		public function user_email() {
		  $current_user = wp_get_current_user();
		  $user_email   = $current_user->user_email;

		  return  $user_email;
		}
		/**
   		*
   		*  Display pagination links
   		*
   		*
   		**/
		public function display_pagination( $id, $max = 50) 
		{
		    $output = '';

		    $total = $this->get_total_items($id);


		    if( $total % $max ) {
		        $lists =  ( $total / $max ) + 1;
		    }
		    else {
		        $lists =  ( $total / $max );
		    }

		      if ($lists > 1){

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

		      }
		    
		      return $output;
		        
		}



		/**
   		*
   		*  Get Total Items for pagination
   		*
   		*
   		**/
	    public function get_total_items($id) {


	          $query = array(
	              "condition"     => '[{
	                                  "field":{"field":"freferrer"},
	                                  "op":"=",
	                                  "value":{"value":"' . $id .'"}
	                                }]',

	          );

	          $response = $this->ontraport->connect()->contact()->retrieveCollectionInfo($query);
	          $response = json_decode($response, true);
	          $count = $response["data"]["count"];

	          return $count;

	    }



		/**
   		*
   		*  Get Date attended
   		*
   		*
   		**/
		public function get_date($attended_date, $new_date) {
		     

		    if( !empty($attended_date) ) {
		         $date =  date('d-m-Y', $attended_date);
		    }
		    else if(!empty($new_date)) {
		         $date =  date('d-m-Y', $new_date);
		    }
		    else {
		         $date =  '';
		    }
		    return $date;
		}
	  

		/**
   		*
   		*  Get Cities of registed referrals
   		*
   		*
   		**/
		public function get_city( $id = '', $nearest_city) {

		    switch ($id) {
		      case '1789':
		        $output = 'Sydney';
		        break;
		      case '1790':
		        $output = 'Perth';
		        break;
		      case '1791':
		        $output = 'Parramatta';
		        break;
		      case '1792':
		        $output = 'Melbourne';
		        break;
		      case '1793':
		        $output = 'Gold Coast';
		        break;
		      case '1794':
		        $output = 'Brisbane';
		        break;
		      case '1795':
		        $output = 'Auckland';
		        break;
		      case '1796':
		        $output = 'Adelaide';
		        break;
		      case '1797':
		        $output = 'Newcastle';
		        break;
		      default:
		         $output = 'No Show';
		        break;
		    }
		     
		    if( $output == 'No Show' ) {

               switch ($nearest_city) {
                  case '1672':
                    $output = 'Sydney';
                    break;
                  case '1673':
                    $output = 'Perth';
                    break;
                  case '1674':
                    $output = 'Parramatta';
                    break;
                  case '1676':
                    $output = 'Melbourne';
                    break;
                  case '1692':
                    $output = 'Brisbane';
                    break;
                  case '1677':
                    $output = 'Auckland';
                    break;
                  case '1678':
                    $output = 'Adelaide';
                    break;
                  case '1675':
                    $output = 'Newcastle';
                    break;
                  default:
                     $output = '';
                    break;
                }
		    } 

		    return $output;
		}



		/**
   		*
   		*  Check is use has attended
   		*
   		*
   		**/
		public function has_attended( $id = '', $event_date) {

		  $tags = explode("*/*", $id );


		   foreach($tags as $key => $tag) {

		     
		            if( $tag == '1593' )
		            {
		   
		              $is_tag = true;

		            } else {
		              $is_tag = false;
		            }

		    }

		      if($is_tag) {
		        $output = 'Yes';
		      }
		      else {
		  
		        if( !empty($event_date) && $event_date < strtotime('now') ) {
		           $output = 'No';
		        }
		        else {
		          $output = 'N/A';
		        }
		      }

		      return $output;
		}


		/**
   		*
   		*  Check if user has paid
   		*
   		*
   		**/
		function has_paid( $value = '') {

		   if($value == true) {
		      $output = 'YES';
		   }
		   else {
		      $output = ' ';
		   }
		   return $output;
		}



   }

endif;