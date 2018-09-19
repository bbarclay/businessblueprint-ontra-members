<?php 

		$args = array(

				  'post_type' => 'mybbp_video',
				  'post_stataus' => 'publish',
				  'posts_per_page' => 4,
				  's' => 'Success Stories',
				  'order' => 'DESC',
				  'orderby' => 'date'
			);

		$query = New WP_Query($args); 

		if( $query->have_posts() ) :

		?>

		<div class="grid" id="success-stories">
                	
			<?php 				
				while( $query->have_posts() ) : $query->the_post(); 


					$video_link 	= get_field('video_oembed', $query->ID, false );

					
					$last_position 	= strpos( $video_link, '?');
					$f_position 	= strpos( $video_link, "medias/");
			        $video_id 		= substr($video_link, ( $f_position + 7 ), 10);
	         
	                ?>

						<div class="column">
							<div class="single-post">								
							    <div class="video-thumbnail" id="<?php echo $video_id ?>">
									<span class="fa fa-spin fa-spinner"></span>
							    </div>
								<div class="video-details">
								  <p class="name"><a href="<?php echo get_permalink() ?>"><?php echo get_the_title() ?></a></p>
								  <span class="date"><?php echo get_the_date() ?></span>
								</div>
							</div>
						</div>

					
			<?php	endwhile; ?>
		</div>	
<?php endif;
wp_reset_postdata();

?>
<script>
	(function($){
	

			var list = $('#success-stories').find('.column');	

			for( var a = 1; a <= list.length; a++ ) {

				var id = $('#success-stories .column:nth-child('+ a +') .video-thumbnail').attr('id');
				console.log(id);
				$.ajax({

					type: 'POST',
			 		url: search_members.ajax_url,
			 		data: {
			 			action: 'get_wistia_image',
			 			security: search_members.security,
			 			id: id,
			 		},
			 		success: function(data) {
						console.log(data);
			 			var img = '<img src="' + data['data']['img_link'] + '" width="100%" alt="' + data['data']['title'] +'" />';
			 		
			 			$('#success-stories').find('#' + data['data']['id']).html(img);
			 		},
			 		error: function() {

			 		}
				});

			}


	})(jQuery)
</script>