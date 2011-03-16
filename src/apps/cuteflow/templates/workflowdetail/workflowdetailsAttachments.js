cf.workflowdetailsAttachments = function(){return {
	
	theFieldset 					:false,
	
	
	
	init: function (attachments) {
		this.initFieldset();		
		this.addData(attachments);
	},
	
	
	initFieldset: function () {
		this.theFieldset = new Ext.form.FieldSet({
			title: '<table><tr><td><img src="/images/icons/attach.png" /></td><td><?php echo __('Attachments',null,'workflowmanagement'); ?></td></tr></table>',
			style: 'margin-top:5px;margin-left:10px;',
			autoScroll: true,
			width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 100,
			height: 'auto'
		});
	},
	
	addData: function (attachments) {
		if(attachments.length > 0) {
			for(var a=0;a<attachments.length;a++) {
				var attach = attachments[a];
				var label = new Ext.form.Label({
					html: attach.link + '<br>',
					style: 'font-size:14px;'
				});
				cf.workflowdetailsAttachments.theFieldset.add(label);
			}
		}
		else {
			cf.workflowdetailsAttachments.theFieldset.setVisible(false);
		}
		
	}
	
	
};}();