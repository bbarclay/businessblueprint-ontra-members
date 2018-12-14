<div class="affiliate-center-section">
	<?php
		$output = '';
		$data   = '';
		$data2  = '';

	    $paged = (int)get_query_var( 'paged', 1 );

	    if($paged) {
	       $x     = $paged - 1;
	       $start = (50 * $x) + 1;
	    }
	    else {
	       $start = 0 + 1;
	    }
	?>       

	<div class="row share-tab-menu">
		<div class="col-md-7">
			<?php if($member_aff_link) : ?>
				  <h3>Your Referral Link</h3>
			      <span class="referral-link"><span id="clipboard"><?php echo $member_aff_link ?></span> <button class="button button--secondary" id="copyRefLink" onclick="copyToClipboard('#clipboard')">Copy</button></span>
			       <input type="hidden" id="hide-clip" />
			<?php endif; ?>	
		</div>
		<div class="col-md-5 text-right">
			 	<h3>Sharing Options</h3>
				<!-- Tab links -->
				<div class="tab">
				  <button class="button tablinks active" onclick="openTab(event, 'itemView1')">Tracking</button>
				  <button class="button tablinks" onclick="openTab(event, 'itemView2')">Share</button>
				  <button class="button tablinks" onclick="openTab(event, 'itemView3')">Images</button>
				  <button class="button tablinks" onclick="openTab(event, 'itemView4')">Email</button>
				</div>
		</div>
		
	</div>

	<!-- Tab Content -->
	<div id="itemView1" class="tabcontent" style="display:block;">
		<div class="line-top"></div>
		<h2>People registered on your link</h2>
		<div class="table-responsive">
			<table class="table table-default-brand" cellpadding="0">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Email</th>
						<th>City</th>
						<th>Date</th>
						<th>Attended</th>
					</tr>
				</thead>
				<tbody>

				<?php if($referrals != false) { $count = $start;

						foreach( $referrals as $row) { ?>

						    <tr>
						      <td><?php echo $count ?></td>
						      <td><?php echo $row['firstname'] . ' ' .  $row['lastname'] ?></td>
						      <td><?php echo $row['email'] ?></td>
						      <td><?php echo $row['city']  ?></td>
						      <td><?php echo $row['event_date'] ?></td>
						      <td><?php echo $row['attended'] ?></td>
						    </tr>

							<?php  $count++;
								}
							 }
						 else 
						 {
						  	echo '<tr><td colspan="6">No record found</td></tr>';
						 } ?>
				</tbody>
			</table>
		</div>		
		<div class="pagination-wrap"><?php echo $pagination ?></div>

		<div class="line-top"></div>
		<h2>People you referred who joined the program</h2>

		 <div class="table-responsive">
			<table class="table table-default-brand" cellpadding="0">
				<thead>
					<tr>
						<th>#</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Membership Level</th>
						<th>Referral Fee</th>
						<th>Start Date</th>
						<th>Payment Due</th>
						<th>Paid</th>
					</tr>
				</thead>
				<tbody>
					<?php  
						if($members) { 
								$count = 1;
								foreach( $members as $row) { ?>
								    <tr>
								      <td><?php echo  $count ?></td>
								      <td><?php echo  $row['firstname'] ?></td>
								      <td><?php echo  $row['lastname'] ?></td>
								      <td><?php echo  $row['member_type']  ?></td>
								      <td><?php echo  $row['referral_fee'] ?></td>
								      <td><?php echo  $row['joined_date'] ?></td>
								      <td><?php echo  $row['payment_date'] ?></td>
								      <td><?php echo  $this->is_paid( $row['is_paid'] ) ?></td>
								    </tr>';
									<?php 	
									$count++;
								}  
						}
						else {
							echo '<tr><td colspan="8">No record found</td></tr>';

						} ?>

				</tbody>
			</table>
		</div>
	</div>
	
	<div id="itemView2" class="tabcontent">
	    <div class="line-top"></div>
		<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/affiliate/share.php'; ?>
	</div>	
	<div id="itemView3" class="tabcontent">
		<div class="line-top"></div>
		<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/affiliate/images.php'; ?>
	</div>
	<div id="itemView4" class="tabcontent">
		<div class="line-top"></div>
		<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/affiliate/email.php'; ?>
	</div>

</div>

<script>

	function openTab(evt, tabName) {
	  // Declare all variables
	  var i, tabcontent, tablinks;

	  // Get all elements with class="tabcontent" and hide them
	  tabcontent = document.getElementsByClassName("tabcontent");
	  for (i = 0; i < tabcontent.length; i++) {
	    tabcontent[i].style.display = "none";
	  }

	  // Get all elements with class="tablinks" and remove the class "active"
	  tablinks = document.getElementsByClassName("tablinks");
	  for (i = 0; i < tablinks.length; i++) {
	    tablinks[i].className = tablinks[i].className.replace(" active", "");
	  }

	  // Show the current tab, and add an "active" class to the button that opened the tab
	  document.getElementById(tabName).style.display = "block";
	  evt.currentTarget.className += " active";
	}

	//Copty to clipboard
	function copyToClipboard(element) {
	  var $temp = jQuery("<input>");
	  jQuery("body").append($temp);
	  		$temp.val(jQuery(element).text()).select();
	  		document.execCommand("copy");
	  		$temp.remove();
	}
</script>