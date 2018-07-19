(function( $ ) {
	'use strict';

	
	 $(document).ready(function(){

	     $('.mbb-form input[type="file"]').change(function(e){

	     	var file = $(this).val();
	     	var fileExtension = file.substr( file.lastIndexOf('.') + 1 );

	     	if( fileExtension != "jpg" && fileExtension != "jpeg"  && fileExtension != "png" && fileExtension != "JPG" && fileExtension != "JPEG" && fileExtension != "PNG" && file.length > 0 ) {

	     		if( $(this).hasClass('input-error') == false ) {

	     			var formSubmit= $(this).closest('form').find('input[type="submit"]');

	     			formSubmit.prop('disabled', true);
	     			formSubmit.after('<div class="text-center"><span class="error-message">Please check for errors before submittting</span></div>');
		     		$(this).addClass('input-error');
		     		$(this).after("<span class='error-message'>File format is not supported!</span>");

	     		}
	    
	     	} 
	     	else {
	   
	     		if( $(this).hasClass('input-error') ) {

	     			var form = $(this).closest('form');
	     			var btnSubmit= form.find('input[type="submit"]');

	     			btnSubmit.prop('disabled', true);
	     			form.find('.error-message').remove();

	     			$(this).closest('form').find('input[type="submit"]').prop('disabled', false);
	     			$(this).removeClass('input-error');
	     			$('.image-preview-wrapper .error-message').remove();

	     		}
	     	}

	     });

	     function accordion_in_profile() {

	     	var acc = document.getElementsByClassName("accordion");
			var i;

			for (i = 0; i < acc.length; i++) {
			    acc[i].addEventListener("click", function() {

			        /* Toggle between adding and removing the "active" class,
			        to highlight the button that controls the panel */
			        if( this.classList.contains("active") ) {
			        	this.classList.remove("active");
			        } else {
			        	this.classList.toggle("active");
			        }

			        /* Toggle between hiding and showing the active panel */
			        var panel = this.nextElementSibling;
			        var icon  = this.querySelector('.fa');

			        if ( panel.classList.contains("active") ) {

			            panel.classList.remove("active");
			            icon.classList.remove('fa-minus');
			        	icon.classList.add('fa-plus');

			        } else {

			    		panel.classList.add("active");
		        		icon.classList.remove('fa-plus');
		        		icon.classList.add('fa-minus');

			        }

			    });
			}
	     }

	     accordion_in_profile();


	     function submit_edit_profile() {

	     		$('.mbb-form input[type="submit"]').on('click', function(){
	
	     			var form 		 = $(this).closest('form'),
	     				error_counts = 0,
	     				totalInputs  = form.find('.required-field').length;


	     			for( var x = 0; x < totalInputs; x++ ) {

	     				var input    = form.find('.required-field')[x];
	     				var inputVal = input['value'];


	     				if( inputVal == "" ) {
	     					input.classList.add('input-error');
	     					error_counts++;
	     				} else {
	     					input.classList.remove('input-error');
	     				}

	     			}

	     			if( error_counts < 1 ) {

	     				$('.mbb-form .spin-loader').show();

	     			}

     			});

		}
		submit_edit_profile();

	});

})(jQuery);	 
