/** init main window **/
cf.management_field = function(){return {
	
	isInitialized 	                 : false,
	theFieldPanel             		 : false,
	
	
	/** init grid and window **/
	init: function () {
		if (this.isInitialized == false) {
			this.isInitialized = true;
			cf.fieldPanelGrid.init();
			this.initPanel();
			this.theFieldPanel.add(cf.fieldPanelGrid.theFieldGrid);
		}
	},
	
	/** inits the panel for grid **/
	initPanel: function () {
		this.theFieldPanel = new Ext.Panel({
			title: '<?php echo __('Field Management',null,'field'); ?>',
			closable: true,
			plain: true,
			frame: false,
			layout: 'fit',
			height: 'auto',
			width: 'auto',
			autoScroll:false,
			bodyStyle:'margin-top:1px'
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
		return this.theFieldPanel;
	}
	
};}();