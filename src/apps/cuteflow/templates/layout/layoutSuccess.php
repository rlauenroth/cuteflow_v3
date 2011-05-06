/**
* Class creates Layout with Region West,North and Center (3 BorderLayout)
* West = Navigation
* Center = Tabpanel
* North = CuteFlow Logo
* When layout is initialized, a welcome tab is shown
*/
cf.Layout = function(){return {
	
	isInitialized              : false,
	theMainLayout              : false, // stores the main layout
	theRegionCenter			   : false, // stores the center Region
	theRegionWest		       : false, // stores the west region
	
	/*********************************/
	
	init: function(){
	if (this.isInitialized == false) {
			this.isInitialized = true;
			this.theMainLayout = new Ext.Viewport({
				layout:'border',
				border:false,
				items:[{
					region:'west',
					width:240,
					border:true,
					autoScroll:true,
					layout:'fit',
					bodyStyle:'padding:5px;font-size:11px;background-color:#f4f4f4;',
					collapsible:false,
					split:true
				},{
					region:'center',
					border:false,
					layout:'fit',							
					bodyStyle:'background-color:#f0f0f0;'
				},{
					region:'north',
					border:false,
					height: 85,
					layout:'fit',							
					bodyStyle:'background-color:#f0f0f0;'
				}]
			});
			this.theRegionWest =  this.theMainLayout.layout.west.panel;
			this.theRegionCenter = this.theMainLayout.layout.center.panel;
			this.theRegionNorth = this.theMainLayout.layout.north.panel;
			cf.Navigation.init();
			cf.TabPanel.init();
			cf.cuteFlowLogo.init();
			cf.Layout.theRegionWest.add(cf.Navigation.theAccordion);
			this.theRegionCenter.add(cf.TabPanel.theTabPanel);
			this.theRegionNorth.add(cf.cuteFlowLogo.thePanel);	
			this.theMainLayout.doLayout();
			
			cf.workflow_todo.init();
			cf.workflow_todo.setInitialized(true);
			cf.TabPanel.theTabPanel.add(cf.workflow_todo.getInstance());
			cf.TabPanel.theTabPanel.setActiveTab(cf.workflow_todo.getInstance());
			
		}
	}
};}();