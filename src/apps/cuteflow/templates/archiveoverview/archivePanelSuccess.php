/** init main window **/
cf.workflow_archive = function(){return {
	
	isInitialized 	                 : false,
	theArchivePanel     			 : false,
	
	
	/** init grid and window **/
	init: function () {
		if (this.isInitialized == false) {
			this.isInitialized = true;
			cf.archiveWorkflow.init();
			cf.archiveFilterPanel.init();
			this.initPanel();
			this.theArchivePanel.add(cf.archiveFilterPanel.theColumnPanel);
			this.theArchivePanel.add(cf.archiveWorkflow.theArchiveGrid);
			
		}
	},
	
	/** inits the panel for grid **/
	initPanel: function () {
		this.theArchivePanel = new Ext.Panel({
			title: '<?php echo __('Archived workflows',null,'workflowmanagement'); ?>',
			closable: true,
			plain: true,
			frame: false,
			layout: 'fit',
			autoScroll:false,
			bodyStyle:'margin-top:1px;'
		});
	},
	
	
	
	/** 
	 * Part of the API
	 * set value if class is already initialized. 
	 * @param boolean value
	 *
	 **/
	setInitialized: function (value) {
		this.isInitialized = value;
	},
	
	/**
	* Part of the API
	* This function returns the window, to add it into tabpanel
	*
	*/
	getInstance: function() {
		return this.theArchivePanel;
	}
	
};}();