/** save system settings **/
cf.systemSettingCRUD = function(){return {
	
	theHiddenPanel				:false,
	
	/** functions calls save provess **/
	initSave: function () {		
		this.initHiddenPanel();
		this.buildHiddenfield();
		this.doSubmit();
	},
	
	/** build hiddenfils from gui settings grid **/
	buildHiddenfield: function () {
		var grid = cf.guiTab.theGuiGrid;
		for(var a=0;a<grid.store.getCount();a++) {
			var row = grid.getStore().getAt(a);
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'worklfow['+row.data.column+']', value:row.data.isactive, width: 0}			
			});
			cf.systemSettingCRUD.theHiddenPanel.add(hiddenfield);
		}
		cf.administration_systemsetting.theFormPanel.add(cf.systemSettingCRUD.theHiddenPanel);
		cf.administration_systemsetting.theFormPanel.doLayout();	
		
	},
	
	/** set hidden panel **/
	initHiddenPanel:function () {
		this.theHiddenPanel = new Ext.Panel({
			border: false,
			width:0,
			height:0
		});
		
	},
	
	/** submit panel and form **/
	doSubmit: function () {
		cf.administration_systemsetting.theFormPanel.getForm().submit({
			url: '<?php echo build_dynamic_javascript_url('systemsetting/SaveSystem')?>',
			method: 'POST',
			waitMsg: '<?php echo __('Saving Data',null,'systemsetting'); ?>',
			success: function(objServerResponse){
				try {
					Ext.destroy.apply(Ext, cf.systemSettingCRUD.theHiddenPanel.items.items);
					cf.systemSettingCRUD.theHiddenPanel.items.clear();
					cf.systemSettingCRUD.theHiddenPanel.body.update('');
				}
				catch(e) {}
				
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'systemsetting'); ?>', '<?php echo __('Settings saved',null,'systemsetting'); ?>');
			}
		});
	}
	
};}();