/** init main window **/
cf.management_mailinglist = function(){return {
	
	isInitialized 	                 : false,
	theFormPanel             	 : false,
	
	
	/** init grid and window **/
	init: function () {
		if (this.isInitialized == false) {
			this.isInitialized = true;
			cf.mailinglistPanelGrid.init();
			this.initPanel();
			this.theFormPanel.add(cf.mailinglistPanelGrid.theMailinglistGrid);
		}
	},
	
	/** inits the panel for grid **/
	initPanel: function () {
		this.theFormPanel = new Ext.Panel({
			title: '<?php echo __('Mailing list Management',null,'mailinglist'); ?>',
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
		return this.theFormPanel;
	}
	
};}();