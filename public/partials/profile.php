	
	<div class="option-to-edit">
	    <a href="<?php echo site_url() ?>/reset-password" class="button button--small button__danger">Reset Password</a>
	    <a href="<?php echo site_url() ?>/upload-photo" class="button button--small">Change Photo</a>
		<a href="<?php echo site_url() ?>/edit-membership-info"  class="button button--small button__success"><span class="fa fa-edit"></span> Edit</a>
	</div>
	<!-- end of option -->

	<!-- start of profile -->
	<div class="profile">	
		<div class="profile__thumbnail">
			<div class="profile__thumbnail--image" style="background-image: url(<?php echo $this->thumbnail; ?>)"></div>
		</div>
		<div class="profile__info">  

	        <div class="inner-info">
	   			<span class="label">Name <span class="text"><?php echo $this->firstname; ?> <?php echo $this->lastname; ?></span></span>
	   		</div>
	   		<?php if( $this->company ) :?>
	   		<div class="inner-info">
	    		<span class="label">Company <span class="text"><?php echo ( $this->company ) ? $this->company : ''; ?></span></span>
	    	</div>
	    	<?php endif; ?>
	   		<div class="inner-info">	
				<span class="label">Business Type <span class="text">
					<?php echo ( $this->business_category ) ? $this->business_category: 'N/A'; ?></span></span>
			</div>
	   		<div class="inner-info">	
				<span class="label">Consultant <span class="text"><?php echo $this->owner ?></span></span>
			</div>	
		</div>   
	</div>	 
	<!-- end of profile -->

	<!-- start of  extra info -->
	<div class="extra-info">

		<button class="accordion">
			<span> 
			<img src="<?php echo esc_url( plugins_url('businessblueprint-ontra-members/public/image/contact-info.svg') ) ?>" width="24" /> Contact info</span> <span class="fa fa-plus"></span>
		</button>
		<div class="panel">
				<?php if( $this->mobile_no ) : ?>
		    		<div class="contact"><span class="label">Mobile No </span><span class="text"><?php echo $this->mobile_no; ?></span></div>
		    	<?php endif; ?>
		    	<?php if( $this->office_no ) : ?>
		    		<div class="contact"><span class="label">Office No </span><span class="text"><?php echo $this->office_no; ?></span></div>
		    	<?php endif; ?>
		    	<div class="email"><span class="label">Email </span><span class="text"><?php echo $this->email; ?></span></div>
		    	<div class="location"><span class="label">Address </span><span class="text"><?php echo $this->address . ', '; ?><?php echo ( $this->address2 ) ? $this->address2 . ', ': ''; ?><?php echo $this->city; ?><?php echo ( $this->state ) ? ', ' . $this->state: ''; ?> <?php echo ( $this->state !== 'Outside Australia') ? ', ' . $this->get_country( $this->country) : ''; ?>  <?php echo $this->zipcode; ?> </span></div>
		</div>
		<!-- end of accordion -->

		<button class="accordion"><span><img src="<?php echo esc_url( plugins_url('businessblueprint-ontra-members/public/image/customer-info.svg') ) ?>" width="24" /> Membership Info</span>  <span class="fa fa-plus"></span></button>
		<div class="panel">
				<div class="label"><span>Customer Type</span><span class="text"><?php echo ( $this->customer_type ) ? $this->customer_type: 'N/A'; ?></span></div>
				<div class="label"><span>Year Level</span><span class="text"><?php echo ( $this->yearlevel ) ? $this->yearlevel : 'N/A';?></span></div>
				<div class="label"><span>Joined Date</span><span class="text"><?php echo ( $this->joined_date ) ? date('j F Y',strtotime( $this->joined_date)) : 'N/A';  ?></span></div>
				<div class="label"><span>Renewal Date</span><span class="text"><?php echo (  $this->renew_date ) ? date('j F Y',strtotime(  $this->renew_date)) : 'N/A'; ?></span></div>
		</div>
		<!-- end of accordion -->

		<button class="accordion">
			<span><img src="<?php echo esc_url( plugins_url('businessblueprint-ontra-members/public/image/affiliate-link.svg') ) ?>" width="24" /> Affiliate Link</span>  <span class="fa fa-plus"></span>
		</button>
		<div class="panel">
	    	<span class="aff__link">
	    		<?php 
	    			$share_link = $this->affiliate_link; 

	    			if( $share_link ) {
	    				echo '<a href="'. $share_link .'" target="_blank">' . $share_link . '</a>';
	    			} else {
	    				echo "<div class='text'>You don't have an affiliate link. Please contact support</div>";
	    			}   ?>
	    	</span>
		</div>
		<!-- end of accordion -->

		<button class="accordion">
			<span><img src="<?php echo esc_url( plugins_url('businessblueprint-ontra-members/public/image/other-info.svg') ) ?>" width="24" /> Website Link</span>  <span class="fa fa-plus"></span>
		</button>
		<div class="panel">
		    <div class="website">
		    	<span class="label">Website </span><span class="text"><?php echo (  $this->website  ) ?  $this->website : 'N/A'; ?></span>
		    </div>
		</div>
		<!-- end of accordion -->


	</div>	
	<!-- end of extra info -->


	<?php if( $this->about_me ) : ?>
		<h3>About Me</h3>
		<div class="about-me-section">
		   <?php 
		   echo wpautop( esc_attr( $this->about_me ) ); ?>
		</div>
	<?php endif; ?>

