/** init main window **/
cf.workflow_workflowmanagement = function(){return {
	
	isInitialized 	                 : false,
	theWorkflowPanel       			 : false,
	
	
	/** init grid and window **/
	init: function () {
		if (this.isInitialized == false) {
			this.isInitialized = true;
			cf.workflowmanagementPanelGrid.init();
			cf.workflowFilterPanel.init();
			this.initPanel();
			this.theWorkflowPanel.add(cf.workflowFilterPanel.theColumnPanel);
			this.theWorkflowPanel.add(cf.workflowmanagementPanelGrid.theWorkflowGrid);
		
		}
	},
	
	/** inits the panel for grid **/
	initPanel: function () {
		this.theWorkflowPanel = new Ext.Panel({
			title: '<?php echo __('Workflow Management',null,'workflowmanagement'); ?>',
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
		return this.theWorkflowPanel;
	}
	
};}();