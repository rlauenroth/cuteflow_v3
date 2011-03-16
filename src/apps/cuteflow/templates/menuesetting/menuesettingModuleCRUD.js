/** save function for Modules **/
cf.menueSettingModuleCRUD = function(){return {
	thePanel 				:false,
	
	/** main save function **/
	saveModuleOrder: function () {
		this.buildModuleFields();
		this.saveModule();
	},
	
	
	/** buildPabnel, where all hiddenfields will be added **/
	buildModuleFields: function() {
		this.thePanel = new Ext.Panel ({
			width:5,
			height: 5,
			autoScroll: false
		});
		
		// add hiddenfields
		for(var a=0;a<cf.menueSettingModuleGrid.theModuleGrid.store.getCount();a++) {
		
			var row = cf.menueSettingModuleGrid.theModuleGrid.getStore().getAt(a);
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'grid[]', value:row.data.id, width: 0,heigth:0 }			
			});
			
			this.thePanel.add(hiddenfield);
			
		}
		// add Panel to formpanel
		cf.administration_menuesetting.themenueSettingModuleWindow.add(this.thePanel);
		cf.administration_menuesetting.themenueSettingModuleWindow.doLayout();
	},
	
	/** save function of the hiddenfields **/
	saveModule: function () {
		
		cf.administration_menuesetting.themenueSettingModuleWindow.getForm().submit({
			url: '<?php echo build_dynamic_javascript_url('menuesetting/SaveModule')?>',
			method: 'POST',
			waitMsg: '<?php echo __('Saving Data',null,'menuesetting'); ?>',
			success: function() {
				try { // check if an accordion item is active
					var ac_item_id = cf.Navigation.theAccordion.layout.activeItem.id;
				}
				catch(e) {
				}
				
				Ext.destroy.apply(Ext, cf.menueSettingModuleCRUD.thePanel.items.items);
				cf.menueSettingModuleCRUD.thePanel.items.clear();
				cf.menueSettingModuleCRUD.thePanel.body.update('');
				
				
				cf.administration_menuesetting.themenueSettingModuleWindow.doLayout();
				cf.menueSettingModuleGrid.theModuleStore.reload();
				
				
				
				cf.Navigation.isInitialized = false;
				cf.Layout.theRegionWest.remove(cf.Navigation.theAccordion);
				cf.Navigation.theAccordion.destroy();
				cf.Navigation.reloadNavigation();
				
				cf.Layout.theRegionWest.add(cf.Navigation.theAccordion);
				cf.Layout.theRegionWest.doLayout();	
				cf.menueSettingModuleCRUD.expandNavigation.defer(1000,this,[ac_item_id]);
				
				
				cf.administration_menuesetting.themenueSettingModuleWindow.setSize();
				cf.administration_menuesetting.themenueSettingModuleWindow.doLayout();
		
			}
		});
	},
	
	/** expand west navigation **/
	expandNavigation: function (id) {
		try {
			Ext.getCmp(id).expand();
		}
		catch(e) {
		}
	}


	
	
};}();