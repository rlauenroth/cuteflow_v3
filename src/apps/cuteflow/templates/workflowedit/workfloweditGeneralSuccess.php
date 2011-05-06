cf.workfloweditGeneral = function(){return {
	
	theFieldset					:false,
	theMailinglistLabel			:false,
	theSenderLabel				:false,
	theNameLabel				:false,
	theContentLabel				:false,
	theLabel					:false,
	
	init:function(data,workflowtemplate_id) {
		this.initFieldset(data.workflow);
		this.initLabel(data.workflow, data.mailinglist, data.sender, data.content, data.version,workflowtemplate_id, data.created_at)
		this.theFieldset.add(this.theLabel);
	},
	
	
	initLabel: function (workflow, mailinglist, sender, content, version, workflowtemplate_id, created_at) {
		this.theLabel = new Ext.form.Label({
			html: '<table><tr height="25"><td><img src="/images/icons/user.png" /></td><td width="150"><?php echo __('Sender',null,'workflowmanagement'); ?>:</td><td>'+sender+'</td></tr><tr height="25"><td><img src="/images/icons/report.png" /></td><td width="150"><?php echo __('Worklfow name',null,'workflowmanagement'); ?>:</td><td>'+workflow+'</td></tr><tr height="25"><td><img src="/images/icons/clock.png" /></td><td width="150"><?php echo __('Created At',null,'workflowmanagement'); ?>:</td><td>'+created_at+'</td></tr><tr height="25"><td><img src="/images/icons/script.png" /></td><td width="150"><?php echo __('Description',null,'workflowmanagement'); ?>:</td><td>'+content+'</td></tr></table>',
			style: 'font-size:12px;'
		});
		
	},
	
	
	initFieldset: function (workflowname) {
		this.theFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('General informations',null,'workflowmanagement'); ?> : ' + workflowname,
			allowBlank: false,
			autoScroll: true,
			style: 'margin-top:5px;margin-left:10px;',
			width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 100,
			height: 'auto'
		});
	}
	
	
	
	
	
	
	
};}();