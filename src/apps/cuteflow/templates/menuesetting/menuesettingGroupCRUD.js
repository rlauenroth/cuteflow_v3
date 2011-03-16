/** save functionality for menuitems **/
cf.menueSettingGroupCRUD = function(){return {
	
	/**
	*
	* init function to save 
	*
	* @param int id, id of the loaded Group
	*/
	saveGroupOrder: function (id) {
		this.buildGroupFields(id);
		this.saveGroup();
	},
	
	
	/**
	*
	* function to build all hiddenfields to store
	*
	* @param int id, id of the loaded Group
	*/	
	buildGroupFields: function(id) {
		var myPanel = new Ext.Panel ({
			id: 'menueSettingGroupCRUDSavePanel',
			width:'5',
			height: '5',
			autoScroll: false
		});
		
		// hiddenfield with id of Parent Menue Item
		var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'module', value:id, width: 0}			
		});
		
		myPanel.add(hiddenfield);
		
		for(var a=0;a<cf.menueSettingGroupGrid.theGroupGrid.store.getCount();a++) {
		
			var row = cf.menueSettingGroupGrid.theGroupGrid.getStore().getAt(a);
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'grid[]', value:row.data.group_id, width: 0}			
			});
			
			myPanel.add(hiddenfield);
			
		}
		// add items to formpanel
		cf.menueSettingGroupWindow.theFormPanel.setVisible(true);
		cf.menueSettingGroupWindow.theFormPanel.add(myPanel);
		cf.menueSettingGroupWindow.theFormPanel.doLayout();
	},
	
	/** save items **/
	saveGroup: function () {		
		cf.menueSettingGroupWindow.theFormPanel.getForm().submit({
			url: '<?php echo build_dynamic_javascript_url('menuesetting/SaveGroup')?>',
			method: 'POST',
			waitMsg: '<?php echo __('Saving Data',null,'menuesetting'); ?>',
			success: function() {
				try { // check if accordion has active item
					var ac_item_id = cf.Navigation.theAccordion.layout.activeItem.id;
				}
				catch(e) {
				}
				cf.menueSettingGroupWindow.theMenueSettingGroupWindow.hide();
				cf.menueSettingGroupWindow.theMenueSettingGroupWindow.destroy();
				
				cf.Navigation.isInitialized = false;
				cf.Layout.theRegionWest.remove(cf.Navigation.theAccordion);
				cf.Navigation.theAccordion.destroy();
				cf.Navigation.reloadNavigation();
				cf.Layout.theRegionWest.add(cf.Navigation.theAccordion);
				cf.Layout.theRegionWest.doLayout();
				
				cf.menueSettingGroupWindow.theMenueSettingGroupWindow.hide();
				cf.menueSettingGroupWindow.theMenueSettingGroupWindow.destroy();
				cf.menueSettingModuleCRUD.expandNavigation.defer(1000,this,[ac_item_id]);

			}
		});
	}
	
	
	
	
};}();