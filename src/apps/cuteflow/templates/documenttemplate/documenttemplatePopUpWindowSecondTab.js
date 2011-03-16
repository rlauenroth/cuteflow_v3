/** init second tab of popup **/
cf.documenttemplatePopUpSecondTab = function(){return {

	theColumnPanel				:false,
	theRightColumnPanel			:false,
	theLeftColumnPanel			:false,

	
	/** init second tab of popup **/	
	init: function () {
		cf.documenttemplatePopUpSecondTabRightColumn.init();
		cf.documenttemplatePopUpSecondTabLeftColumn.init();
		this.initLeftColumnPanel();
		this.initRightColumnPanel();
		this.initColumnPanel();
		this.theRightColumnPanel.add(cf.documenttemplatePopUpSecondTabRightColumn.theFieldGrid);
		this.theLeftColumnPanel.add(cf.documenttemplatePopUpSecondTabLeftColumn.theTopToolBar);
		this.theColumnPanel.add(this.theLeftColumnPanel);
		this.theColumnPanel.add(this.theRightColumnPanel);
	},
	
	/** init column panel **/
	initColumnPanel: function () {
		this.theColumnPanel = new Ext.Panel({
			layout: 'column',
			frame:true,
			title: '<?php echo __('Set Fields to Template',null,'documenttemplate'); ?>',
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 148,
			border: false,
			style: 'border:none;',
			autoScroll: false,
			layoutConfig: {
				columns: 2
			}
		});
	},
	
	
	/** on the left Panel, new Fieldsets were added **/
	initLeftColumnPanel: function () {
		this.theLeftColumnPanel = new Ext.Panel ({
			frame:true,
			border: false,
			autoScroll: true,
			columnWidth: .5,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 177,
			width: 370
		});
	},
	
	/** right panel contains the Grid with the Fields **/
	initRightColumnPanel: function () {
		this.theRightColumnPanel = new Ext.Panel ({
			frame:true,
			border: false,
			columnWidth: .5,
			autoScroll: false,
			width: 370
		});
	}














};}();