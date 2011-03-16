cf.showDeletedUserPopUpWindow = function(){return {

	thePopUpWindow				:false,
	
	
	init: function () {
		cf.showDeletedUserGrid.init();
		this.initWindow();
		this.thePopUpWindow.add(cf.showDeletedUserGrid.theDeletedUserGrid);
		this.thePopUpWindow.show();
	},
	
	
	
	initWindow: function() {
		this.thePopUpWindow = new Ext.Window({
			modal: true,
			closable: true,
			modal: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 120,
			width: 800,
			autoScroll: false,
			title: '<?php echo __('Deleted user',null,'usermanagement'); ?>',
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: false,
	        buttonAlign: 'center',
			close : function(){
				cf.showDeletedUserPopUpWindow.thePopUpWindow.hide();
				cf.showDeletedUserPopUpWindow.thePopUpWindow.destroy();
			}		
		})
	}


};}();