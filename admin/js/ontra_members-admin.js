(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


	 jQuery(document).ready(function(){

	 	var mediaUploader;
		var id;
		var profile;

		 $('.upload-image-button').on('click', function(e){
		 		e.preventDefault();

		 		
		 		id = $(this).closest('tr').attr('id');
		 		profile = $('#' + id);


		 		if( $('#' + id).find('.submit-img').hasClass('submitted') ) {

		 			$('#' + id).find('.submit-img').removeClass('submitted').addClass('button-primary');
		 			$('#' + id).find('.submit-img').val('Go');
		 		
		 		}


		 		console.log(id);

		 		if( mediaUploader ) {
		 			mediaUploader.open();
		 			return;
		 		}


		 		mediaUploader = wp.media.frames.file_frame = wp.media({
		 				title: 'Choose a Profile Picture',
		 				button: {
		 					text: 'Choose Picture'
		 				},
		 				multiple: false
		 		});


		 		mediaUploader.on('select', function(e){


		 			var attachment;
	

		 			attachment = mediaUploader.state().get('selection').first().toJSON();

		 			$('#' + id).find('.profile-picture').val(attachment.url);

		 			profile.find('.image-preview-wrapper img').attr('src', attachment.url);

		 			
		 		});	

				id = $(this).closest('tr').attr('id');
		 		mediaUploader.open();


		 		

		 });



		 $('#bb_table').on('click', '.submit-img', function(){

		 	  var id = $(this).closest('tr').attr('id'),
		 	  	  url = $(this).closest('tr').find('.profile-picture').val();

		 	  	  console.log(ontramember.security);
              
			$.ajax({
			 		url: ontramember.ajaxurl,
			        type: 'post',
			        dataType: 'json',
			        data: {
			            action: 'ontramembers_listing',
			            id: id,
			            url : url,
			            security: ontramember.security
			        },
	 
			        success: function(data, textStatus, XMLHttpRequest) {
	
						var is_success = data;

						console.log(data);
				
				         if( is_success ) {
                               
                              $('#' + id).find('.submit-img').removeClass('button-primary').addClass('submitted'); 
                              $('#' + id).find('.submit-img').val('Ok');
				         }

			          
			        },
			 
			        error: function(MLHttpRequest, textStatus, errorThrown) {
			            alert(errorThrown);
			        }
			 
			});

		 });

	 });

})( jQuery );
