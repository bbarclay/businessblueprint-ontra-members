<?php  

	$id = get_query_var('ontraport_id');
	$this->get_single_user($id);
	$active_member = $this->customer_type;

	  $hide_firstname = get_user_meta( $id, 'hide_firstname', true); 
	  $hide_lastname  = get_user_meta( $id, 'hide_lastname', true);
	  $show_website   = get_user_meta( $id, 'show_website', true);
	  $show_email     = get_user_meta( $id, 'show_email', true);
	  $show_mobile    = get_user_meta( $id, 'show_mobile', true);
	  $show_address   = get_user_meta( $id, 'show_address', true);
	  $show_company   = get_user_meta( $id, 'show_company', true);
	  $show_office_no = get_user_meta( $id, 'show_office_no', true);
	  $show_state 	  = get_user_meta( $id, 'show_state', true);



	if( $id && $active_member != 'N/A') : ?>

		<button  class="button  button--alt  button--login button__login  button--wide" onclick="goBack()">Back </button>
		<section class="module module__membership">		
		  <div class="profile">	

				<div class="profile__thumbnail">
					<div class="profile__thumbnail--image" style="background-image: url(<?php echo $this->thumbnail; ?>)"></div>
				</div>
				<div class="profile__info">
					<?php if( $this->firstname && !$hide_firstname || $this->lastname && !$hide_lastname ) : ?>
				        <div class="inner-info">
				   			<span class="label">Name <span class="text"><?php echo ( $this->firstname && !$hide_firstname) ? $this->firstname: ''; ?> <?php echo ( $this->lastname && !$hide_lastname) ? $this->lastname: ''; ?></span></span>
				   		</div>
			   		<?php endif; ?>
					<?php if( $this->company && $show_company ) : ?>
				   		<div class="inner-info">
				    		<span class="label">Company <span class="text"><?php echo $this->company ?></span></span>
				    	</div>
			    	<?php endif; ?>
			   		<div class="inner-info">	
						<span class="label">Business Type <span class="text">
					   <?php echo $this->getOntraportValue($this->business_type, 'business_type');  ?></span></span>
					</div>
			   		<div class="inner-info">	
							<span class="label">Consultant <span class="text"><?php echo $this->owner ?></span></span>
					</div>	

				</div>   
			</div>	 
			<div class="extra-info">
				<button class="accordion"><span> <img src="<?php echo esc_url( plugins_url('businessblueprint-ontra-members/public/image/contact-info.svg') ) ?>" width="24" /> Contact info</span> <span class="fa fa-plus"></span></button>
				<div class="panel">
						<?php if( $this->mobile_no && $show_mobile ) : ?>
				    		<div class="contact"><span class="label">Mobile No </span><span class="text"><?php echo $this->mobile_no; ?></span></div>
				    	<?php endif; ?>
				    	<?php if( $this->office_no && $show_office_no ) : ?>
				    		<div class="contact"><span class="label">Office No </span><span class="text"><?php echo $this->office_no; ?></span></div>
				    	<?php endif; ?>
				    	<?php if( $show_email ) :?>
				    			<div class="email"><span class="label">Email </span><span class="text"><?php echo $this->email; ?></span></div>
				    	<?php endif; ?>		
				    	<?php if( $show_address ) : ?>
				    			<div class="location">
				    				<span class="label">Address </span>
				    				<span class="text"><?php echo $this->address; ?> <?php echo ( $this->address2 ) ? ',' . $this->address2: ''; ?><?php echo $this->city; ?><?php echo ( $this->state ) ? ',' . $this->state: ''; ?> <?php echo $this->get_country( $this->country ); ?>  <?php echo $this->zipcode; ?> </span>
				    			</div>
				    	<?php endif; ?>
				</div>
				<button class="accordion"><span><img src="<?php echo esc_url( plugins_url('businessblueprint-ontra-members/public/image/customer-info.svg') ) ?>" width="24" /> Membership Info</span>  <span class="fa fa-plus"></span></button>
				<div class="panel">
					<div class="label">
						<span>Customer Type</span><span class="text"><?php echo ( $this->customer_type ) ? $this->customer_type: 'N/A'; ?></span>
					</div>
					<div class="label">
						<span>Year Level</span><span class="text"><?php echo ( $this->yearlevel ) ? $this->yearlevel : 'N/A';?></span>
					</div>
					<div class="label">
						<span>Joined Date</span><span class="text"><?php echo ( $this->joined_date ) ? $this->joined_date : 'N/A';  ?></span>
					</div>
					<div class="label">
						<span>Renewal Date</span><span class="text"><?php echo (  $this->renew_date ) ?  $this->renew_date : 'N/A'; ?></span>
					</div>
				</div>

				<button class="accordion"><span><img src="<?php echo esc_url( plugins_url('businessblueprint-ontra-members/public/image/other-info.svg') ) ?>" width="24" /> Website Link</span>  <span class="fa fa-plus"></span></button>
				<div class="panel">
				    <div class="website"><span class="label">Website </span><span class="text"><?php echo (  $this->website  ) ?  $this->website : 'N/A'; ?></span></div>
				</div>

			</div>	
		</section>
		<script>
		function goBack() {
		    window.history.back();
		}
		</script>
<?php 

else:
   echo  'Please check directory page';

endif;