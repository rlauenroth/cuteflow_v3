cf.restartWorkflowWindow = function(){return {
	
	theRestartWorkflowWindow		:false,
	theTabPanel						:false,
	theTemplateId					:false,
	theLoadingMask					:false,
	
	
	init: function(template_id) {
		this.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Preparing Data...',null,'workflowmanagement'); ?>'});					
		this.theLoadingMask.show();
		this.theTemplateId = template_id;
		this.initTabPanel();
		this.initWindow();
		cf.restartWorkflowFirstTab.init();
		this.theTabPanel.add(cf.restartWorkflowFirstTab.theFirstTabPanel);
		this.theRestartWorkflowWindow.add(this.theTabPanel);
		this.theRestartWorkflowWindow.show();
		
		cf.restartWorkflowFirstTab.theFirstTabPanel.getComponent(1).collapse(false);
		cf.restartWorkflowFirstTab.theFirstTabPanel.getComponent(2).collapse(false);
		this.theLoadingMask.hide();
	},
	
	
	
	/**
	* init the popupwindow
	*
	* @param int id, id is set if in edit mode
	* @param string title, title of window
	*/
	initWindow: function () {
		this.theRestartWorkflowWindow = new Ext.Window({
			modal: true,
			closable: true,
			modal: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 40,
			width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 40,
			autoScroll: false,
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: true,
			title:  '<?php echo __('Restart workflow',null,'workflowmanagement'); ?>',
	        buttonAlign: 'center',
			buttons:[{
				text:'<?php echo __('Store',null,'documenttemplate'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () {
					cf.restartWorkflowCRUD.doSubmit(cf.restartWorkflowWindow.theTemplateId);
				}
			},{
				text:'<?php echo __('Close',null,'documenttemplate'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {
					cf.restartWorkflowWindow.theRestartWorkflowWindow.hide();
					cf.restartWorkflowWindow.theRestartWorkflowWindow.destroy();
				}
			}]
		});
		this.theRestartWorkflowWindow.on('close', function() {
			cf.restartWorkflowWindow.theRestartWorkflowWindow.hide();
			cf.restartWorkflowWindow.theRestartWorkflowWindow.destroy();
		});
	},
	
	/** init tabpanel **/
	initTabPanel: function () {
		this.theTabPanel = new Ext.TabPanel({
			activeTab: 0,
			enableTabScroll:true,
			border: false,
			deferredRender:true,
			frame: true,
			layoutOnTabChange: true,
			style: 'margin-top:5px;',
			plain: false,
			closable:false
		});	
	}
	
	
	
	
	
	
	
	
	
	
	
};}();