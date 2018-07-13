<?php 

 	 $page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

	$lists = $this->get_active_members($page); 

?>
<div class="member-contact-listing">
								
	 <?php foreach( $lists as $list ) : 

	 	  $id  = $list['id'];

	 	  $show_firstname = get_user_meta( $id, 'hide_firstname', true); 
	 	  $show_lastname  = get_user_meta( $id, 'hide_lastname', true);
	 	  $show_website   = get_user_meta( $id, 'show_website', true);
	 	  $show_email     = get_user_meta( $id, 'show_email', true);
	 	  $show_mobile    = get_user_meta( $id, 'show_mobile', true);
	 	  $show_address   = get_user_meta( $id, 'show_address', true);
	 	  $show_company   = get_user_meta( $id, 'show_company', true);
	 	  $show_office_no = get_user_meta( $id, 'show_office_no', true);
	 	  $show_state 	  = get_user_meta( $id, 'show_state', true);


	 	  $firstname 	= $list['firstname'];
	 	  $lastname  	= $list['lastname'];
	 	  $website   	= $list['website'];
	 	  $email     	= $list['email'];
	 	  $cellphone 	= $list['cell_phone'];
	 	  $address   	= $list['address'];
	 	  $address2  	= $list['address2'];
	 	  $city      	= $list['city'];
	 	  $zip       	= $list['zip'];
	 	  $company     	= $list['company'];
	 	  $office_phone = $list['office_phone'];
	 	  $state     	= $list['StateAUS_131'];



	 	 if( ! $show_firstname || ! $show_lastname ) :
	 	?>
		   	   <div class="contact-item">
					<div class="inner">
						<?php 
							$img_url = wp_get_attachment_url( $id );
							if($img_url) {
								$img_bg = $img_url;
							} else {
								$img_bg = $this->get_thumbnail( $id );
							}	

						?>
						<div class="image <?php echo $this->get_color($list['owner']) ?>" style="background: url(<?php echo $img_bg ?>) center center / cover no-repeat;">
						</div>	
						<div class="detail">
							
						    <h4 class="name"><?php echo $firstname . ' ' . $lastname ?></h4>
  							<?php if( $website  && $show_website  || $email && $show_email || !empty( $mobile ) && $show_mobile  ) : ?>	
								    <ul class="contact">
								    	<?php 
								    		if( $website  && $show_website ) :
								    	?>
								    			<li><a href="<?php echo $website; ?>" target="_blank"><span class="fa fa-globe"></span>Website</a></li>
								    	<?php 
								    		endif;
								    		if( $email  && $show_email ) :
								    	?>
								    			<li><a href="<?php echo $email; ?>" target="_blank"><span class="fa fa-envelope"></span>Email</a></li>
								    	<?php 
								    		endif;
								    		if( $cellphone && $show_mobile ) :
								    	?>
								    			<li><a href="<?php echo $cellphone; ?>"><span class="fa fa-phone"></span>Phone</a></li>
								    	<?php
								    		endif;
								    	?>
								    </ul>
								<?php endif; ?> 
						    
						    <?php   if( ! $show_state ) : 

						   			  echo 	'<span class="state"><span class="fa fa-map-marker"></span> ' . $this->get_state( $state ) . '</span>';

						    	 	endif; ?>
						    <?php   if( $show_address ) : ?>
						   				 <p><?php echo $address . ','; ?> <?php echo ( $address2 ) ?  $address2 . ',': '' ; ?> <?php echo $city; ?> <?php echo $zip; ?></p>
						   	<?php   endif; ?>	
						   	

						   	<?php if( $company ||  $office_phone ) : ?>
								    <ul class="company-detail">
								    	<?php if( $company && $show_company ) : ?>
								    		<li><span>Company : </span><span><?php echo $company; ?></span></li>
								    	<?php 
								    		endif;
								    		if( $office_phone && $show_office_no ) :
								    	?>	
								    		<li><span>Office No : </span><span><?php echo $office_phone; ?></span></li>
								    	<?php endif; ?>	
								    </ul>
							<?php endif; ?>
							
						</div>
					</div>
				</div>
		<?php endif; ?>
	<?php endforeach; ?>
				
</div>
<?php echo  $this->display_pagination(); ?>	

