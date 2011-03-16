/** init tabpanel for region center **/
cf.cuteFlowLogo = function(){return {
	
	thePanel	 		:false,
	isInitialized		:false,
	
	/** init function **/
	init: function () {
		if(this.isInitialized == false) {
			this.isInitialized = true;
			this.thePanel = new Ext.Panel({
				frame:true,
				border: false,
				autoScroll: true,
				bodyStyle: 'background-color:<?php echo Login::getBackgroundColor();?>;',
				width: 'auto',
				html:'<div><img src="/images/logo/logo.png" /></div>',
			    height: 'auto'
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