/** inits the main window for centerRegion **/
cf.administration_menuesetting = function(){return {
	
		
	themenueSettingModuleWindow			:false,
	isInitialized						:false,

	
	
	/** init function **/
	init:function () {
		if (this.isInitialized == false) {
			this.isInitialized = true;
			cf.menueSettingModuleGrid.init();			
			this.initModuleWindow();
			this.themenueSettingModuleWindow.add(cf.menueSettingModuleGrid.theModuleGrid);
		}
		
	},
	
	
	/** Panel for the tabbar **/
	initModuleWindow: function () {
		this.themenueSettingModuleWindow =  new Ext.FormPanel({
			modal: true,
			closable: true,
			modal: true,
			autoScroll: false,
			shadow: false,
			minimizable: false,
			draggable: false,
			resizable: false,
	        plain: false,
	        title: '<?php echo __('Menue Settings',null,'menuesetting'); ?>'
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
		return this.themenueSettingModuleWindow;
	}
	
};}();