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


		$('#searchDirectory').on( 'click', function(e){

			e.preventDefault();

		 	var name  = $('#searchMembers').val();
		 	var state = $('#searchByState option:selected').val();
		 	var start = 0;
		 	var end	  = 50;

		 	//console.log(name);
		 	//console.log(state);

		 	$('.mbb-form .spin-loader').addClass('show');

		 	contactAjax(name, state, start, end, true );

		});

		$('#searchMembers').on('keypress', function(event){

			//event.preventDefault();

			if( event.keyCode === 13 ) {


			 	var name  = $('#searchMembers').val();
			 	var state = $('#searchByState option:selected').val();
			 	var start = 0;
			 	var end	  = 50;

			 	//console.log(name);
			 	//console.log(state);

			 	$('.mbb-form .spin-loader').addClass('show');

			 	contactAjax(name, state, start, end, true );

			 	event.preventDefault();
			}


		});


		$('#clearSearch').on( 'click', function(e){


			e.preventDefault();

			$('#searchMembers').val('');
			$('#searchByState option:selected').attr('selected', false);
			$('#searchByState option:first-child').attr('selected', true);

			var name  = '';
		 	var state = '';
		 	var start = 0;
		 	var end	  = 50;

		 	$('.mbb-form .spin-loader').addClass('show');

		 	contactAjax(name, state, start, end, true );

		});


		$('.contact-pagination').on('click', '.button-next', function(e){

			e.preventDefault();

			var id 		  = $(this).attr('id');
			var name  	  = $('#searchMembers').val();
		 	var state 	  = $('#searchByState option:selected').val();
		 	var start 	  = ( id * 50 ) - 50;
		 	var end	  	  = ( id * 50 ) - 1;
		 	var next_page = parseInt(id) + 1;


		 	$('.mbb-form .spin-loader').addClass('show');

		 	contactAjax(name, state, start, end, false, next_page );
	
		 	$('.button-next').attr('id', id);


		});



		function contactAjax( name = '', stateID = '', start = 0, end = 50, clean_listing = false, next_page = 2 )
		{
		
			//console.log(start + ' ' + end );
			$.ajax({
		 		type: 'POST',
		 		url: search_members.ajax_url,
		 		data: {
		 			action: 'search_ontra',
		 			security: search_members.security,
		 			name: name,
		 			stateId: stateID,
		 			start: start,
		 			end: end
		 		},
		 		success: function(data) {

		 			//console.log(data);
		 			var total = data['data']['data'].length;
		 			var template = [];
		 			var contacts = data['data']['data'];
		 			var total_pages = data['data']['pages'];

		 			if( total > 0 && clean_listing == true ) {
		 				$('.member-contact-listing').html(''); 
		 				clean_listing = false;
		 			}

		 			if( total == 0 ) {
		 				$('.member-contact-listing').html('<p>No record found!</p>');
		 				$('.contact-pagination').html('');
		 				$('.mbb-form .spin-loader').removeClass('show');
		 			}

		 			//console.log(clean_listing);
	 				for(var a = 0; a < data['data']['data'].length; a++ ) {
	 				
	 					var fullname = data['data']['data'][a]['firstname'] + ' ' + data['data']['data'][a]['lastname'];
	 					var state = getState( parseInt( contacts[a]['StateAUS_131'] ) );
	 					var id = parseInt( data['data']['data'][a]['id'] );
	 					var link = data['data']['data'][a]['link'];
	 					var photo = data['data']['data'][a]['photo'];

	 					template = singleContact( fullname, state, id, photo, link );
	 					
	 					$('.member-contact-listing').append(template);

	 				}

	 				if( total_pages > 0 ) {

	 					$('.page-numbers').remove();

	 					var next_button = '<button class="button text-center button-next" id="' + next_page +'">Load More</button>';

	 					$('.contact-pagination').html(next_button);	
	 					$('.mbb-form .spin-loader').removeClass('show');
	 				}

	 				if( total_pages < next_page ) 
	 				{
	 					$('.contact-pagination').html('');		
	 				}

	
		 		},
		 		error: function(error) {
		 			console.log(error);
		 		}
		 	});
		}

	 	function singleContact(name = '', state = '', id = '', photo = '', link = '', output = []) 
	 	{
	 		
	 		output += '<div class="contact-item">';
	 			output += '<a href="'+ link +'" target="_blank">';
	 				output += '<div class="inner">';
                      output += '<div class="image" style="background: url('+ photo +') center center / cover no-repeat;">';
	 				  output += '</div>';
	 				  output += '<div class="detail">';
	 				     output += '<h4 class="name">'+ name +'</h4><span class="state"><span class="fa fa-map-marker"></span>'+ state +'</span>';
	 				  output += '</div>';	
	 				output += '</div>';
	 			output += '</a>';
	 		output += '</div>';

	 		return output;
	 	}

		function getState( stateID )
		{
			var value = '';
			switch( stateID ) {

				case 747:
					value = "New South Wales";
					break;
				case 748:
					value = "Victoria";
					break;
				case 749:
					value = "Queensland";
					break;
				case 750:
					value = "Western Australia";
					break;
				case 751:
					value = "South Australia";
					break;	
				case 752:
					value = "Tasmania";
					break;	
				case 753:
					value = "Australian Capital Territory";
					break;		
				case 754:
					value = "Northern Territory";
					break;	
				case 763:
					value = "Outside Australia";
					break;						
				default:
					value = "N/A";

			}

			return value;
		}

		 

	});

})(jQuery);	 
