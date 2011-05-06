/** pop up for version **/
cf.documenttemplateVersionPopUp = function(){return {
	
	theVersionWindow				:false,
	theTabPanel						:false,
	
	
	/**
	* init popup
	*
	*@param int parent_id, id of the template
	*@param int child_id, id of the version which is active
	*
	*/
	init: function (parent_id, child_id) {
		this.initWindow();	
		cf.documenttemplateVersionFirstTab.init(parent_id);
		this.initTabPanel();
		this.theTabPanel.add(cf.documenttemplateVersionFirstTab.thePanel);
		this.theVersionWindow.add(this.theTabPanel);
		this.theVersionWindow.show();		
	},
	
	
	/** init popup window **/
	initWindow: function () {
		this.theVersionWindow = new Ext.Window({
			modal: true,
			closable: true,
			modal: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 40,
			width: 820,
			autoScroll: true,
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: true,
			title: '<?php echo __('Set Documenttemplate to previous version',null,'documenttemplate'); ?>'
		});
		this.theVersionWindow.on('close', function() {
			cf.documenttemplateVersionPopUp.theVersionWindow.hide();
			cf.documenttemplateVersionPopUp.theVersionWindow.destroy();
		});
		
	},
	
	/** init tabpanel **/
	initTabPanel: function () {
		this.theTabPanel = new Ext.TabPanel({
			activeTab: 0,
			enableTabScroll:true,
			border: false,
			deferredRender:true,
			frame: true,
			layoutOnTabChange: true,
			style: 'margin-top:5px;',
			plain: false,
			closable:false
		});	
	}
	
	
		
};}();