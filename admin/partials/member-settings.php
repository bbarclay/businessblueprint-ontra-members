	<div class="wrap">
		<h2>Member Settings</h2>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						   <form method="post" action="options.php">
							    <?php settings_fields( 'bbmember-setting' ); ?>
							    <?php do_settings_sections( 'member_settings' ); ?>

						     <?php submit_button(); ?>
						    </form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>
