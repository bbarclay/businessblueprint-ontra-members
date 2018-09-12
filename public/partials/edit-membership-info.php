<div class="mbb-form">
      
      <div class="spin-loader">
     	 <span class="fa fa-spinner fa-spin spin-normal"></span>
      </div>
      <?php $is_silver =  do_shortcode('[mbb_silver_membership]'); ?>
	  <form action="<?php echo esc_url( admin_url('admin-ajax.php') ) ?>" method="POST"  enctype="multipart/form-data" autocomplete="off">
	   		<input type="hidden" name="action" value="ontra_update_contact" />
	   		<?php wp_nonce_field( 'update_ontra_action', 'update_ontra_field' ); ?>
			<?php $user_id = $this->get_ontraport_id(); ?>
			<h3 class="title">Personal info</h3>
			<div class="row">
			   <div class="col-sm-6">
			   	  <label>First Name</label> 
			   	  <span class="privacy-status <?php echo ( $is_silver ) ? 'hide': ''; ?>"><input type="checkbox" name="hide_firstname" <?php echo ( get_user_meta(  $user_id , 'hide_firstname', true ) == 1 ) ? "checked='checked'": ""; ?> /> Hide</span><br>
			   	  <input type="text" name="firstname" value="<?php echo $this->firstname; ?>" style="color: #bfbcbc;" readonly="readonly"   class="form-control required-field"  required/>
			   </div>
			   <div class="col-sm-6">
			      <label>Last Name</label> <span class="privacy-status <?php echo ( $is_silver ) ? 'hide': ''; ?>""><input type="checkbox" name="hide_lastname" <?php echo ( get_user_meta(  $user_id , 'hide_lastname', true ) == 1 ) ? "checked='checked'": ""; ?> /> Hide</span><br>
			   	  <input type="text" name="lastname" value="<?php echo $this->lastname; ?>" style="color: #bfbcbc";  class="form-control  required-field" readonly="readonly" required/>
			   </div>
			   <div class="col-sm-6">
			      <label>Address</label> <span class="privacy-status <?php echo ( $is_silver ) ? 'hide': ''; ?>""><input type="checkbox" name="show_address" <?php echo ( !get_user_meta(  $user_id , 'show_address', true ) == 1 ) ? "checked='checked'": ""; ?>> Hide Complete Address</span><br>
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
			      <?php echo $this->getOptions( $this->state_edit, 'form-control  required-field', 'state', 'states' ); ?> 
			   </div>
				<div class="col-sm-6">
			      <label>Zipcode</label><br>
			   	  <input type="text" name="zip" value="<?php echo $this->zipcode; ?>" class="form-control  required-field" required/>
			   </div>
			   <div class="col-sm-6">
			      <label>Mobile No</label> <span class="privacy-status <?php echo ( $is_silver ) ? 'hide': ''; ?>""><input type="checkbox" name="show_mobile" <?php echo ( !get_user_meta(  $user_id , 'show_mobile', true ) == 1 ) ? "checked='checked'": ""; ?> /> Hide</span><br>
			   	  <input type="text" name="mobile_no" value="<?php echo $this->mobile_no; ?>" class="form-control  required-field" required/>
			   </div>
			   <div class="col-sm-6">
			      <label>Email</label> <span class="privacy-status <?php echo ( $is_silver ) ? 'hide': ''; ?>""><input type="checkbox" name="show_email" <?php echo ( !get_user_meta(  $user_id , 'show_email', true ) == 1 ) ? "checked='checked'": ""; ?> /> Hide</span><br>
			   	  <input type="email" name="email" value="<?php echo $this->email; ?>" class="form-control  required-field" disabled/>
			   </div>
		    </div>

		    <h3 class="title">Company Information</h3>
		    <div class="row">
			   <div class="col-sm-6">
			      <label>Company</label> 
			      <span class="privacy-status <?php echo ( $is_silver ) ? 'hide': ''; ?>""><input type="checkbox" name="show_company" <?php echo ( !get_user_meta(  $user_id , 'show_company', true ) == 1 ) ? "checked='checked'": ""; ?>  /> Hide</span><br>
			   	  <input type="text" name="company" value="<?php echo $this->company; ?>" class="form-control" />
			   </div>
			   <div class="col-sm-6">
			      <label>Website</label> <span class="privacy-status"><input type="checkbox" name="show_website" <?php echo ( !get_user_meta(  $user_id , 'show_website', true ) == 1 ) ? "checked='checked'": ""; ?>  /> Hide</span><br>
			   	  <input type="text" name="website" value="<?php echo $this->website; ?>" class="form-control" />
			   </div>
			   <div class="col-sm-6">
			      <label>Office No.</label> <span class="privacy-status"><input type="checkbox" name="show_office_no" <?php echo ( !get_user_meta(  $user_id , 'show_office_no', true ) == 1 ) ? "checked='checked'": ""; ?>  /> Hide</span><br>
			   	  <input type="text" name="office_no" value="<?php echo $this->office_no; ?>" class="form-control" />
			   </div>
			   		   <div class="col-sm-6" id="businessType">
			      <label>Business Type</label> <span class="privacy-status"><input type="checkbox" name="show_business_type" <?php echo ( !get_user_meta(  $user_id , 'show_business_type', true ) == 1 ) ? "checked='checked'": ""; ?>  /> Hide</span><br>
			      <input type="hidden" name="business_category" id="businessTypeCategory" value="<?php echo ( get_user_meta(  $user_id , 'business_category', true ) ) ? get_user_meta(  $user_id , 'business_category', true ) : '' ?>"  required/>
			      <?php 

			      	$types = array(
			      		"Accounting",
			      		"Administration & Office Support",
			      		"Advertising, Arts & Media",
			      		"Banking & Financial Services",
			      		"Call Centre & Customer Service",
			      		"CEO & General Management",
			      		"Community Services & Development",
			      		"Construction",
						"Consulting & Strategy",
			      		"Design & Architecture",
			      		"Education & Training",
			      		"Engineering",
			      		"Government & Defence",
			      		"Farming, Animals & Conservation",
			      		"Healthcare & Medical",
			      		"Hospitality & Tourism",
			      		"Human Resources & Recruitment",
			      		"Information & Communication Technology",
			      		"Insurance & Superannuation",
			      		"Marketing & Communications",
			      		"Mining, Resources & Energy",
			      		"Real Estate & Property",
			      		"Retail & Consumer Products",
			      		"Sales",
			      		"Science & Technology",
			      		"Self Employment",
			      		"Sport & Recreation",
			      		"Trades & Services" );

			        ?>
			        <select name="business_category" id="businessTypeCategory" class="required-field" required>
			        	<option value="">Select</option>
			        <?php foreach( $types as $type )  {?>
			        
			        	<option value="<?php echo $type; ?>" <?php echo ( get_user_meta(  $user_id , 'business_category', true ) ) ? 'selected' : ''; ?>><?php echo $type; ?></option>
			    		<?php } ?>
			    	</select>	
			          <!-- <div class="classificationWrapper"> 
				          <div class="classficationDropDownList">
				          	<span class="type"><?php //echo ( get_user_meta(  $user_id , 'business_category', true ) ) ? get_user_meta(  $user_id , 'business_category', true ) : 'Select classification' ?></span><i class="fa fa-chevron-down"></i>
				          </div>		
				          <button id="classificationClose"><span class="fa fa-close"></span></button>
					  </div> 	
					  <div id="classificationPanel">
					  	<nav role="navigation">

					  		<ul class="classificationMain">
					  			<?php 
					  			//foreach($types as $value ) : ?>
						  			<li class="parent-item">
						  				<a href="" role="checkbox" aria-checked="false" target="_self" <?php //echo ( get_user_meta(  $user_id , '//business_category', true ) == $value ) ? "class='is-checked is-active'": ""; ?>>
						  					<span class="item-text">
						  						<span><?php //echo $value ?></span>
						  					</span>
						  				</a>

						  			</li>
								<?php 
								//endforeach ?>	
					  		</ul>
					  	</nav>
					  </div> -->	
			   </div>
			</div>

			<h3 class="title">About Me</h3> 
			<div>
			  <textarea name="about_me" class="form-control" rows="10"><?php echo esc_attr( get_user_meta( $user_id, 'about_me', true ) ) ?></textarea>
			</div> 
			
			  <input type="submit" value="Submit" />
		</div>  

      </form>
	</div>
</div>
<!-- <script>
  var classificationPanel = document.getElementById('classificationPanel');
  var classLink = classificationPanel.querySelectorAll('a');


  (function($){

  	$('.classificationMain > li > a').on('click', function(e){

  		e.preventDefault();

  		//$('.classificationMain > li > a').removeClass('is-checked is-active');
  		$('.classificationMain > li').find('.submenu a').removeClass('is-checked');
  		$('.classificationMain > li').find('.submenu').removeClass('show');


  		if( $(this).hasClass('is-active') ) {

  			
  			$(this).removeClass('is-checked is-active');

  			$(this).closest('li').find('.submenu a').removeClass('is-checked');
  			$(this).closest('li').find('.submenu').removeClass('show');
  		
  		} else {

  			$('.classificationMain > li > a').removeClass('is-checked is-active');
  			$(this).addClass('is-checked is-active');
  			$(this).closest('li').find('.submenu > li:first-child a').addClass('is-checked is-first');

  			$(this).closest('li').find('.submenu').addClass('show');

  		}


  		if( $('.classificationMain').find('.is-active').length > 1 ) {


  			var total = $('.classificationMain').find('.is-active').length;

  			var title = total.toString() + " Classifications";

  			$('.classficationDropDownList .type').html( title );
  			$('.classficationDropDownList').removeClass('input-error');

  		} else if( $('.classificationMain').find('.is-active').length == 1 ) {

  		  	var title = $(this).find('.item-text span').text();

  			$('.classficationDropDownList .type').html( title );
  			$('.classficationDropDownList i').addClass('type-added');
  			$('#classificationClose').addClass('active');
  			$('.classficationDropDownList').removeClass('input-error');

  		} else {

  			$('.classficationDropDownList .type').html( 'Select Classification');
  			$('.classficationDropDownList i').removeClass('type-added');
  			$('#classificationClose').removeClass('active');
  			$('#businessTypeCategory').val('');

  		}

  		//get value and store in input
  		var active  = $('.classificationMain').find('.is-active');
  		var output  = [];
  		var output2 = [];
  		var text 	= [];
  		var text2   = [];


  		$('#businessTypeCategory').val('');


  		for( var a = 1; a <= active.length; a++ ) {
      
      		text 	 = $('.classificationMain').find('.is-active:nth-child(' + a + ') .item-text span').text();	
      		text2 	 = $('.classificationMain .submenu').find('.is-first.is-checked:nth-child(' + a + ')').text();
      		output   = text;
      		output2 += text2;
  			$('#businessTypeCategory').val(output);
  		}




  	});

  
  	$('.classficationDropDownList').on('click', function(){
  		$(this).find('i').toggleClass('rotate');
  		$('#classificationPanel').toggleClass('classification-visible');

  	})

  	$('#classificationClose').on('click', function(e){

  		e.preventDefault();

		$('.classficationDropDownList .type').html( 'Select Classification');
		$('#classificationClose').removeClass('active');

		$('.classficationDropDownList').find('i').removeClass('type-added');
		$('.classificationMain  a').removeClass('is-checked is-active');
		$('.classificationMain  .submenu').removeClass('show');
		
		$('#businessTypeSubcategory').html('');
		$('#businessTypeCategory').val('');
  	})


  })(jQuery)

	
</script> -->
