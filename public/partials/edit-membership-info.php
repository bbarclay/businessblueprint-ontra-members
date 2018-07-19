<div class="mbb-form">
      
      <div class="spin-loader">
     	 <span class="fa fa-spinner fa-spin spin-normal"></span>
      </div>
	  <form action="<?php echo esc_url( admin_url('admin-ajax.php') ) ?>" method="POST"  enctype="multipart/form-data">
	   		<input type="hidden" name="action" value="ontra_update_contact" />
	   		<?php wp_nonce_field( 'update_ontra_action', 'update_ontra_field' ); ?>
			<h3 class="title">Profile Picture</h3>   
			<div class='image-preview-wrapper'>
			    <label>Accepted file formats: <small>jpg, jpeg and png</small></label><br>
		  		<input type="file" name="file" />
			</div>
			<?php $user_id = $this->get_ontraport_id(); ?>
			<h3 class="title">Personal info</h3>
			<div class="row">

			   <div class="col-sm-6">
			   	  <label>First Name</label> 
			   	  <span class="privacy-status"><input type="checkbox" name="hide_firstname" <?php echo ( get_user_meta(  $user_id , 'hide_firstname', true ) == 1 ) ? "checked='checked'": ""; ?> /> Hide</span><br>
			   	  <input type="text" name="firstname" value="<?php echo $this->firstname; ?>" style="color: #bfbcbc;" readonly="readonly"   class="form-control required-field"  required/>
			   </div>

			   <div class="col-sm-6">
			      <label>Last Name</label> <span class="privacy-status"><input type="checkbox" name="hide_lastname" <?php echo ( get_user_meta(  $user_id , 'hide_lastname', true ) == 1 ) ? "checked='checked'": ""; ?> /> Hide</span><br>
			   	  <input type="text" name="lastname" value="<?php echo $this->lastname; ?>" style="color: #bfbcbc";  class="form-control  required-field" readonly="readonly" required/>
			   </div>

			   <div class="col-sm-6">
			      <label>Address</label> <span class="privacy-status"><input type="checkbox" name="show_address" <?php echo ( !get_user_meta(  $user_id , 'show_address', true ) == 1 ) ? "checked='checked'": ""; ?>> Hide Complete Address</span><br>
			   	  <input type="text" name="address" value="<?php echo $this->address; ?>"  class="form-control  required-field" required/>
			   </div>

			   <div class="col-sm-6">
			      <label>Address 2</label><br>
			   	  <input type="text" name="address2" value="<?php echo $this->address2; ?>" class="form-control" />
			   </div>

			   <div class="col-sm-6">
			      <label>City</label><br>
			   	  <input type="text" name="city" value="<?php echo $this->city; ?>" class="form-control  required-field" required/>
			   </div>

			   <div class="col-sm-6">
			      <label>State</label><span class="privacy-status"><input type="checkbox" name="hide_state" <?php echo ( get_user_meta(  $user_id , 'hide_state', true ) == 1 ) ? "checked='checked'": ""; ?> /> Hide</span><br>
			      <?php echo $this->getOptions($this->state, 'form-control  required-field','state','states'); ?> 
			   </div>

				<div class="col-sm-6">
			      <label>Zipcode</label><br>
			   	  <input type="text" name="zip" value="<?php echo $this->zipcode; ?>" class="form-control  required-field" required/>
			   </div>

			   <div class="col-sm-6">
			      <label>Mobile No</label> <span class="privacy-status"><input type="checkbox" name="show_mobile" <?php echo ( !get_user_meta(  $user_id , 'show_mobile', true ) == 1 ) ? "checked='checked'": ""; ?> /> Hide</span><br>
			   	  <input type="text" name="mobile_no" value="<?php echo $this->mobile_no; ?>" class="form-control  required-field" required/>
			   </div>

			   <div class="col-sm-6">
			      <label>Email</label> <span class="privacy-status"><input type="checkbox" name="show_email" <?php echo ( !get_user_meta(  $user_id , 'show_email', true ) == 1 ) ? "checked='checked'": ""; ?> /> Hide</span><br>
			   	  <input type="email" name="email" value="<?php echo $this->email; ?>" class="form-control  required-field" disabled/>
			   </div>

		    </div>

		    <h3 class="title">Company Information</h3>
		    <div class="row">

			   <div class="col-sm-6">
			      <label>Company</label> 
			      <span class="privacy-status"><input type="checkbox" name="show_company" <?php echo ( !get_user_meta(  $user_id , 'show_company', true ) == 1 ) ? "checked='checked'": ""; ?>  /> Hide</span><br>
			   	  <input type="text" name="company" value="<?php echo $this->company; ?>" class="form-control" />
			   </div>

			   <div class="col-sm-6" id="businessType">
			      <label>Business Type</label> <span class="privacy-status"><input type="checkbox" name="show_business_type" <?php echo ( !get_user_meta(  $user_id , 'show_business_type', true ) == 1 ) ? "checked='checked'": ""; ?>  /> Hide</span><br>
			      <?php echo $this->getOptions($this->business_type, 'form-control  required-field','business_type','business_type'); ?>  
			   </div>

			   <div class="col-sm-6">
			      <label>Website</label> <span class="privacy-status"><input type="checkbox" name="show_website" <?php echo ( !get_user_meta(  $user_id , 'show_website', true ) == 1 ) ? "checked='checked'": ""; ?>  /> Hide</span><br>
			   	  <input type="text" name="website" value="<?php echo $this->website; ?>" class="form-control" />
			   </div>

			   <div class="col-sm-6">
			      <label>Office No.</label> <span class="privacy-status"><input type="checkbox" name="show_office_no" <?php echo ( !get_user_meta(  $user_id , 'show_office_no', true ) == 1 ) ? "checked='checked'": ""; ?>  /> Hide</span><br>
			   	  <input type="text" name="office_no" value="<?php echo $this->office_no; ?>" class="form-control" />
			   </div>

			   <div class="col-sm-12">
			   	  <input type="submit" value="Submit" />
			   </div>

			</div>   

        </form>
	</div>
</div>
<style>
	.privacy-status {
	    float: right;
	    margin-top: 15px;
	    font-size: 15px;
	    color: #9c9b9b;
	}
</style>
