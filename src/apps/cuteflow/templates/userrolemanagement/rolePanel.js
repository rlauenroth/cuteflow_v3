/**
* Main class for Rolemanegement, which loads the grid into an panel
*
*/

cf.administration_userrolemanagement = function(){return {
	
	isInitialized 	                 : false,
	theManagementWindow              : false,
	
	
	/** init grid and window **/
	init: function () {
		if (this.isInitialized == false) {
			this.isInitialized = true;
			this.initWindow();
			cf.UserRoleGrid.init();
			this.theManagementWindow.add(cf.UserRoleGrid.theUserRoleGrid);
		}
	},
	
	/** inits the panel for grid **/
	initWindow: function () {
		this.theManagementWindow = new Ext.Panel({
			title: '<?php echo __('Role management',null,'userrolemanagement'); ?>',
			closable: true,
			plain: true,
			frame: false,
			layout: 'fit',
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
		return this.theManagementWindow;
	}
	
};}();