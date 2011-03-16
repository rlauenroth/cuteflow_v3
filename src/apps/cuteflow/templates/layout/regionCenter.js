/** init tabpanel for region center **/
cf.TabPanel = function(){return {
	
	theTabPanel 		:false,
	isInitialized		:false,
	
	/** init function **/
	init: function () {
		if(this.isInitialized == false) {
			this.isInitialized = true;
			this.theTabPanel = new Ext.TabPanel({
				activeTab: 0,
				enableTabScroll:true,
				deferredRender:false,
				frame: true,
				plain: false,
				closable:false,
				layoutOnTabChange:true
			});
		}
	},
	
	
	
	setInitialized: function (value) {
		this.isInitialized = value;
	},
	
	getInstance: function() {
		return this.theTabPanel;
	}
};}();