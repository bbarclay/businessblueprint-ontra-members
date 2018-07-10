
	<div class="grid  grid--boxes profiling ontramember-list">
									
		
		   <?php $lists = $this->get_fasttrack();

		    ?>

		   <?php foreach( $lists as $list ) : ?>
		   	   <div class="grid__column">
					<div class="member">
						<div class="image <?php echo $this->get_color($list['owner']) ?>">
							
								  <img src="<?php echo $this->get_thumbnail( $list["id"] ); ?>" />
								<div>
									<span><?php ?></span>
								</div>
							
						</div>	
							<div class="information">
							    <span class="name"><?php echo $list['firstname'] . ' ' . $list['lastname'] ?></span>	
							</div>
					</div>
				</div>
		<?php endforeach; ?>

		
								
		
	</div>
	<div class="printable-style">
		<a href="javascript:window.print()">Download PDF</a>
	</div>
