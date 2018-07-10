	<div class="wrap">
		<h2>Business Blueprint Member List</h2>

		<div id="member-listing">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
					 <?php  $clients = $this->get_members();  
                            echo $this->display_pagination();   ?>
                         <table id="bb_table" cellpadding="0" cellspacing="0">
                             <tr>
                                <th>  
                                    Thumbnail
						       </th>
                             	<th>Full Name</th>
                             	<th>Customer Type</th>
                             	<th>Year Level</th>
                             	<th>Action</th>
                             </tr>
                         	<?php foreach($clients as $client) { ?>
                         		<tr id="<?php echo $client['id'] ?>">
                         		    <td>
                         		    	<div class='image-preview-wrapper'>
							          		<img id='image-preview' src='<?php echo $this->get_image( $client["id"] ); ?>' width='80' height='80' style='max-height: 80px; width: 80px;'>
						           		</div>
                         		    </td>
                         			<td><?php echo $client['firstname'] . ' ' . $client['lastname'] ?></td>
                         			<td><?php echo $this->get_customerType( $client['BBCustomer_165'] ) ?></td>
                         			<td><?php echo $this->get_yearLevel( $client['BBYearLeve_258'] ) ?></td>
                         			<td class="submit">
									    <input type='hidden' name='image_attachment_id' class='profile-picture' value=''>
                         				<input class="upload-image-button button" type="button" value="<?php _e( 'Upload image' ); ?>" />
                                        <input type="submit" class="submit-img button button-primary" value="Go" />
                         			</td>
                         		</tr>

                         	<?php } ?>	
                         </table>

						

					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>
