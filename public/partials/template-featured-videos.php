<?php 
 	global $post;

	if( have_rows('featured_videos') ) { ?>

		<div class="grid" id="featured-videos">
                	
			<?php 				
				while( have_rows('featured_videos') ) : the_row(); 

				$post_object = get_sub_field('video');

				if( $post_object ) :

					// override $post
					$post = $post_object;
					setup_postdata( $post );

						$video_link 	= get_field('video_oembed', GET_THE_ID(), false );
						$f_position 	= strpos( $video_link, "medias/");
			            $video_id 		= substr($video_link, ( $f_position + 7 ), 10);

  
		                $total_plays = ""; ?>

						<div class="column">
							<div class="single-post">								
							    <div class="video-thumbnail" id="<?php echo $video_id ?>">
									<span class="fa fa-spin fa-spinner"></span>
							    </div>
								<div class="video-details detail-<?php echo $video_id ?>">
								  <p class="name"><a href="<?php echo get_permalink() ?>"><?php echo get_the_title() ?></a></p>
									  	<?php $presenter = get_the_term_list( get_the_ID(), 'mybbp_video_presenter', '<div class="presenter">', ', ', '</div>' );

									  		if( $presenter )  {
									  			echo '<div class="content-footer">';
									  			echo $presenter;
									  			echo '<span class="total-views"></span>';
									  			echo '</div>';
									  		} else {
									  			echo '<div class="content-footer">';
									  			echo '<div class="presenter">Business Blueprint</div>';
									  			echo '<span class="total-views"></span>';
									  			echo '</div>';
									  		}  ?>
								</div>
							</div>
						</div>


	                <?php

					wp_reset_postdata();
				endif;	?>

					

			<?php	endwhile; ?>
		</div>	
<?php } 

wp_reset_postdata();

?>
<script>
	(function($){
	

			var list = $('#featured-videos').find('.column');	

			for( var a = 1; a <= list.length; a++ ) {

				var id = $('#featured-videos .column:nth-child('+ a +') .video-thumbnail').attr('id');

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
			 		
			 			$('#featured-videos').find('#' + data['data']['id']).html(img);
			 			$('#featured-videos').find('.detail-' + data['data']['id'] + ' .total-views').html(data['data']['total_plays'] + ' views');
			 		},
			 		error: function() {

			 		}
				});

			}


	})(jQuery)
</script>