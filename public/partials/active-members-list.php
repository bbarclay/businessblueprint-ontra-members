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


	 	  $url = site_url() . '/profile/?ontraport_id=' . $id . '';
	 	 if( ! $show_firstname || ! $show_lastname ) :
	 	?>
	 		<div class="contact-item">
	 			<a href="<?php echo esc_url( $url); ?>" target="_blank">
		   	   
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
						    
						    <?php   if( ! $show_state ) : 

						   			  echo 	'<span class="state"><span class="fa fa-map-marker"></span> ' . $this->get_state( $state ) . '</span>';

						    	 	endif; ?>
						</div>
					</div>
				
				</a>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
				
</div>
<?php echo  $this->display_pagination(); ?>	

