<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script type="text/javascript">
	var api_id      = '<?php echo get_option('ontra_member_bb_wistia_key') ?>';
	var media_id    = '<?php echo get_option('ontra_member_bb_wistia_video_id') ?>';
    var output      = [];
    var cache_users = [];

	function ValidateEmail(inputText)
	{
 		var re = /\S+@\S+\.\S+/;
    	return re.test(inputText);
	}
	$.ajax({
		url: 'https://api.wistia.com/v1/stats/events.json?media_id='+ media_id +'&per_page=150&page=1&api_password=' + api_id,
		type : 'get',
		headers: {
            'Access-Control-Allow-Headers': 'Content-Type'
		},
		success: function(data) {

			var temp_array = [];

			for( var a = 0; a < data.length; a++) {

                var viewer         = [];
                var percent_viewed = ( data[a]['percent_viewed'] * 100 ) / 1; 

                //Check if email exist in the array
                email = data[a]['email'];

                // Store Data
                ///viewer.push( data[a]['email'], percent_viewed );
                viewer['email'] = data[a]['email'];
                viewer['percent_viewed'] = percent_viewed;

               
               	// Check if new email exist in the list
				function findFirstEmail(temp_array) {
				 	return temp_array['email'] === email;
				}
                var index = temp_array.findIndex(findFirstEmail);

              
                if( index == -1) {
                      temp_array.push(viewer);

                } else {
					if(percent_viewed > temp_array[index]['percent_viewed']) {
                      	temp_array[index]['percent_viewed'] = percent_viewed;
                    }
                }


			}

			for(var a = 0; a < temp_array.length; a++) {
				var is_email = ValidateEmail(temp_array[a]['email']);
	
				if(is_email) {
					output += '<div class="item"><div class="email">'+ temp_array[a]['email'] + '</div><div class="percent"><strong id="'+temp_array[a]['percent_viewed'].toFixed(2)+'">'+  temp_array[a]['percent_viewed'].toFixed(2) + '%</strong></div><div><button class="button updateWatchedVideo">Update</button></div></div>';
				}
			}

			 //console.log('find ' + cache_users.findIndex(findFirstEmail));    
			 $('#contactListing2 .inner-list').append(output);   

		},
		error: function(err) {
			console.log(err);
		}	

	});


</script>