/** init main window **/
cf.workflow_todo = function(){return {
	
	isInitialized 	                 : false,
	theTodoPanel       				 : false,
	
	
	/** init grid and window **/
	init: function () {
		if (this.isInitialized == false) {
			this.isInitialized = true;
			cf.todoPanelGrid.init();
			cf.todoFilterPanel.init();
			this.initPanel();
			this.theTodoPanel.add(cf.todoFilterPanel.theColumnPanel);
			this.theTodoPanel.add(cf.todoPanelGrid.theTodoGrid);
		}
	},
	
	/** inits the panel for grid **/
	initPanel: function () {
		this.theTodoPanel = new Ext.Panel({
			title: '<?php echo __('My Workflows',null,'workflowmanagement'); ?>',
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
		return this.theTodoPanel;
	}
	
};}();