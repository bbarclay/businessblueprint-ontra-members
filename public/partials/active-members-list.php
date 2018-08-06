<?php 
 	$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$lists = $this->get_active_members($page); 
?>
<form action="<?php echo esc_url( admin_url('admin-ajax') )  ?>" class="mbb-form inline-group" autocomplete="off">
    <input type="hidden" value="search_ontra" name="action" />
    <?php wp_nonce_field( 'search_members_action', 'search_members_field' ); ?>
	<input type="text" name="search" id="searchMembers" placeholder="Search by name" />
	<?php 
		$states = [
			'747' => 'New South Wales', 
			'748' => 'Victoria',
			'749' => 'Queensland',
			'750' => 'Western Australia',
			'751' => 'South Australia',
			'752' => 'Tasmania',
			'753' => 'Australian Capital Territory',
			'754' => 'Northern Territory',
			'763' => 'Outside Australia'
		] 

	?>
	<select name="state" id="searchByState">
			<option value="">Select State</option>
		<?php foreach($states as $key => $value) : ?>
			<option value="<?php echo $key ?>"><?php  echo $value; ?></option>
		<?php endforeach ?>
	</select>
	<div class="spin-loader">
	    <span class="fa fa-spinner fa-spin spin-normal"></span>
	</div>
	<submit type="submit" class="button" id="searchDirectory">Search</submit>
	<span id="clearSearch" class="button">Clear</span>
</form>

<div class="member-contact-listing">
								
	 <?php foreach( $lists as $list ) : 

	 	  $id  = $list['id'];

	 	  $show_firstname = get_user_meta( $id, 'hide_firstname', true); 
	 	  $show_lastname  = get_user_meta( $id, 'hide_lastname', true);
	 	  $show_state 	  = get_user_meta( $id, 'show_state', true);


	 	  $firstname 	= $list['firstname'];
	 	  $lastname  	= $list['lastname'];
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
						<div class="image" style="background: url(<?php echo $img_bg ?>) center center / cover no-repeat;">
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
<div class="contact-pagination">
<?php echo  $this->display_pagination(); ?>	
</div>

