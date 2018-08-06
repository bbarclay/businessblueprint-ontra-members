<?php

/**
 * 
 */

class FastTrack implements Members
{
	
	public function getTotal() 
	{

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

    public function getMembers( $ontraport_api ) 
    {

 	   $client = $ontraport_api;

	   	$max = 50;
	    $total = $this->getTotal();


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
}