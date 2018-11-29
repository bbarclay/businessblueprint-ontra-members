<ul class="latest-uploads-list">
	<?php 

		$args = array(

				  'post_type' => 'mybbp_video',
				  'post_stataus' => 'publish',
				  'posts_per_page' => 8,
				  'order' => 'DESC',
				  'orderby' => 'date'
			);

		$query = New WP_Query($args);

		if( $query->have_posts() ) {
			
			while( $query->have_posts() ) : $query->the_post(); 

				$video_link 	= get_field('video_oembed', $query->ID, false );
				$first_position = strpos( $video_link, "medias/");
		        $video_id 		= substr($video_link, ( $first_position + 7 ), 10);
			 ?>

				<li class="single-video">
				    <div class="video-thumbnail" id="<?php echo $video_id ?>">
				    	<span class="fa fa-spin fa-spinner"></span>
				    </div>
					<div class="video-details">
					  <p class="name"><a href="<?php echo get_permalink() ?>" taget="_blank"><?php echo get_the_title() ?></a></p>
					  
					  	<?php 
					  		$presenter = get_the_term_list( get_the_ID(), 'mybbp_video_presenter', '<div class="presenter">', ', ', '</div>' );

					  		if( $presenter )  {
					  			echo $presenter;
					  		} else {
					  			echo '<div class="presenter">Business Blueprint</div>';
					  		}
					   ?>

					</div>
				</li>

		<?php	
			endwhile;
		} 

		wp_reset_postdata();

	?>
</ul>
<script>
	(function($){
	

			var list = $('.latest-uploads-list').find('li');	

			for( var a = 1; a <= list.length; a++ ) {

				var id = $('.latest-uploads-list li:nth-child('+ a +') .video-thumbnail').attr('id');
			
				$.ajax({
					type: 'POST',
			 		url: search_members.ajax_url,
			 		data: {
			 			action: 'get_wistia_image',
			 			security: search_members.security,
			 			id: id,
			 		},
			 		success: function(data) {
					
			 			var img = '<img src="' + data['data']['img_link'] + '" width="100%" alt="' + data['data']['title'] +'" />';
			 		
			 			$('.latest-uploads-list').find('#' + data['data']['id']).html(img);
			 		},
			 		error: function() {

			 		}
				});

			}


	})(jQuery)
</script>