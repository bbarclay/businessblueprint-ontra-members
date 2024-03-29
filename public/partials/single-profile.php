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
	  $show_business  = get_user_meta( $id, 'show_business_type', true);



	if( $id && $active_member != 'N/A') : ?>

		<!-- <button  id="backButton" class="button  button--alt  button--login button__login  button--wide" onclick="goBack()">Back </button> -->
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
				   	<div class="inner-info">
				   			<?php if( $this->company && $show_company ) : ?>
				    			<span class="label">Company <span class="text"><?php echo ( $this->company ) ? $this->company: 'N/A';  ?></span></span>
				    		<?php else: ?>
				    			<span class="label">Company <span class="text">Private</span></span>
				    		<?php endif; ?>	
				    </div>
			   		<div class="inner-info">	
						<span class="label">Business Type <span class="text">
						<?php echo ( $show_business && get_user_meta( $id, 'business_category', true) ) ? get_user_meta( $id, 'business_category', true): 'Private'; ?></span></span>
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
				    	
				    		<div class="email"><span class="label">Email </span><span class="text"><?php echo ( $this->email &&  $show_email ) ? $this->email: 'Private'; ?></span></div>
				    
				    	<?php if( $show_address ) : ?>
				    			<div class="location">
				    				<span class="label">Address </span>
				    				<span class="text"><?php echo $this->address; ?><?php echo ( $this->address2 ) ? ', ' . $this->address2: ''; ?><?php echo $this->city; ?><?php echo ( $this->state ) ? ', ' . $this->state: ''; ?> <?php echo $this->get_country( $this->country ); ?>  <?php echo $this->zipcode; ?> </span>
				    			</div>
				    	<?php endif; ?>
				</div>
	            <?php if( $show_website ) : ?>
				<button class="accordion"><span><img src="<?php echo esc_url( plugins_url('businessblueprint-ontra-members/public/image/other-info.svg') ) ?>" width="24" /> Website Link</span>  <span class="fa fa-plus"></span></button>
				<div class="panel">
				    <div class="website"><span class="label">Website </span><span class="text"><?php echo (  $this->website  ) ?  esc_html( $this->website ) : 'N/A'; ?></span></div>
				</div>
				<?php endif ?>

			</div>	
		</section>
		<?php if( $this->about_me ) : ?>
			<h3>About Me</h3>
			<div class="about-me-section">
			   <?php 
			   echo wpautop( esc_attr( $this->about_me ) ); ?>
			</div>
		<?php endif; ?>

<?php 

else:
   echo  'Please check directory page';

endif;