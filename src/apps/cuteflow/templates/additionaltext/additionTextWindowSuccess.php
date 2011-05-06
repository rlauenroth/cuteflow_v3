/** init the main window where grid is added **/
cf.management_additionaltext = function(){return {

	theMainPanel						:false,
	isInitialized						:false,



	/** load all necessarry functions **/
	init:function () {
		cf.additionalTextGrid.init();
		this.initMainPanel();
		this.theMainPanel.add(cf.additionalTextGrid.theTextGrid);
	},
	
	
	/** main panel, where theAdditionTextPanel is binded to **/
	initMainPanel: function() {
		if (this.isInitialized == false) {
			this.isInitialized = true;
			this.theMainPanel = new Ext.Panel({
				modal: true,
				closable: true,
				modal: true,
				style:'margin-top:5px;margin-left:5px;',
				layout: 'fit',
				autoScroll: true,
				title: '<?php echo __('Additional Text',null,'additionaltext'); ?>',
				shadow: false,
				minimizable: false,
				autoScroll: false,
				draggable: false,
				resizable: false,
				plain: false
			});
		}
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
		return this.theMainPanel;
	}
	
	
	
};}();