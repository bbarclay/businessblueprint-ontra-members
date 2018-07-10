<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-6">

		<div><span class="label">Joined Date</span><span class="text"><?php echo $this->joined_date; ?></span></div>

		<div><span class="label">Renewal Date</span><span class="text"><?php echo $this->renew_date; ?></span></div>
	
		

	</div>
	<div class="col-md-4 col-sm-6 col-xs-6">	
		<div><span class="label">Customer Type</span><span class="text"><?php echo $this->customer_type ?></span></div>
		<div><span class="label">Year Level</span><span class="text"><?php echo $this->yearlevel ?></span></div>
		<div class="visible-sm"><span class="label">Consultant</span><span class="text"><?php echo $this->owner ?></span></div>

	</div>
	<div class="col-md-4 hidden-sm col-xs-6">	

		<div><span class="label">Consultant</span><span class="text"><?php echo $this->owner ?></span></div>
        
	
	</div>
</div>	