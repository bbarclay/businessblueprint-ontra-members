<?php

		$output = '';
		$data   = '';
		$data2  = '';

       $paged = (int)get_query_var( 'paged', 1 );

       if($paged) {

           $x = $paged - 1;
         $start = (50 * $x) + 1;
       }
       else {

         $start = 0 + 1;
       }

$output .= '<h2>People registered on your link</h2>';

if($referrals != false) {
    $data .= '<div class="table-responsive">';
	$data .= '<table class="table table-default-brand" cellpadding="0">';
	$data .= '<thead><tr><th>#</th><th>Name</th><th>Email</th><th>City</th><th>Date</th><th>Attended</th></tr></thead><tbody>';

	$count = $start;
	foreach( $referrals as $row) {


	    $data .= '<tr>';
	      $data .= '<td>' . $count . '</td><td>'. $row['firstname'] . ' ' .  $row['lastname'] . '</td><td>'. $row['email'] . '</td><td>'. $row['city']  . '</td><td>'. $row['event_date'] . '</td><td>' . $row['attended'] . '</td>';
	    $data .= '</tr>';


	    $count++;
	}


	$data .= '</tbody></table>';
	$data .= '</div>';
}
else {
  $data .= "No record found";
}

if($members) {

    $data2 .= '<div class="table-responsive">';
	$data2 .= '<table class="table table-default-brand" cellpadding="0">';
	$data2 .= '<thead><tr><th>#</th><th>First Name</th><th>Last Name</th><th>Membership Level</th><th>Referral Fee</th><th>Start Date</th><th>Payment Due</th><th>Paid</th></tr><thead><tbody>';

	$count = 1;
	foreach( $members as $row) {

	    $data2 .= '<tr>';
	      $data2 .= '<td>' . $count . '</td><td>'. $row['firstname'] . '</td><td>'. $row['lastname'] . '</td><td>'.  $row['member_type']  . '</td><td>'.  $row['referral_fee'] . '</td><td>' .  $row['joined_date'] . '</td><td>'.   $row['payment_date'] .'</td><td>'.   $this->is_paid( $row['is_paid'] ) .'</td>';
	    $data2 .= '</tr>';


	    $count++;
	}


	$data2 .= '</tbody></table>';
	$data2 .= '</div>';
}
else {
  $data2 .= "No record found";
}

$output .= $data;
$output .=  '<div class="pagination-wrap">' . $pagination . '</div>';
$output .= '<h2>People you referred who joined the program</h2>';
$output .= $data2;

