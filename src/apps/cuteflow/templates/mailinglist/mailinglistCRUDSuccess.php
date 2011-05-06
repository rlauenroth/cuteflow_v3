/** save function **/
cf.mailinglistCRUD = function(){return {
	
	theLoadingMask			:false,
	/**
	* Delete record
	*
	*@param int id, id of the template to update
	*
	*/
	initAdapt: function (id) {
		cf.mailinglistCRUD.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Updating Data...',null,'mailinglist'); ?>'});					
		cf.mailinglistCRUD.theLoadingMask.show();
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('mailinglist/AdaptMailinglist')?>/id/' + id, 
			success: function(objServerResponse){
				cf.mailinglistCRUD.theLoadingMask.hide();
				cf.mailinglistPanelGrid.theMailinglistStore.reload();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'mailinglist'); ?>', '<?php echo __('Update successful',null,'mailinglist'); ?>');
			}
		});
		
	},
	
	
	/**
	* Delete record
	*
	*@param int id, id of the record to delete
	*
	*/
	initDelete: function (id) {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('mailinglist/DeleteMailinglist')?>/id/' + id, 
			success: function(objServerResponse){
				cf.mailinglistPanelGrid.theMailinglistStore.reload();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'mailinglist'); ?>', '<?php echo __('Delete successful',null,'mailinglist'); ?>');
			}
		});
	},
	
	/**
	*
	* Save record
	*
	*@param int id, id of the record, can be empty if in new mode
	*
	*/
	initSave: function (id) {
		if (id != '') {
			var url = '<?php echo build_dynamic_javascript_url('mailinglist/UpdateMailinglist')?>/id/' + id;
			var title = '<?php echo __('Data updated',null,'mailinglist'); ?>';
		}
		else {
			var url = '<?php echo build_dynamic_javascript_url('mailinglist/SaveMailinglist')?>';
			var title = '<?php echo __('Data saved',null,'mailinglist'); ?>';
		}
		var readyToSend = cf.mailinglistCRUD.buildPanel(); // build panel to save
		if(readyToSend == true)	{
			Ext.getCmp('mailinglistFirstTab_nametextfield').setDisabled(false);
			Ext.getCmp('mailinglistFirstTab_documenttemplate_id').setDisabled(false);
			cf.mailinglistPopUpWindow.theTabPanel.setActiveTab(0);
			cf.mailinglistCRUD.doSubmit(url, title);	
		}
		
	},
	
	
	/** build panel to save **/
	buildPanel:function () {
		if(Ext.getCmp('mailinglistFirstTab_nametextfield').getValue() == '' || Ext.getCmp('mailinglistFirstTab_documenttemplate_id').getValue() == '' ) {
			cf.mailinglistPopUpWindow.theTabPanel.setActiveTab(0);
			Ext.Msg.minWidth = 300;
			Ext.MessageBox.alert('<?php echo __('Error',null,'mailinglist'); ?>','<?php echo __('Set Name and select a Template',null,'mailinglist'); ?>');
			return false;
		}
		var grid = cf.mailinglistFirstTab.theAllowedSenderGrid;		
		if(grid.store.getCount() > 0) {
			var counter = 0;
			for(var c=0;c<grid.store.getCount();c++) {
				var row = grid.getStore().getAt(c);
				var hiddenfield = new Ext.form.Field({
					autoCreate : {tag:'input', type: 'hidden', name: 'user['+counter+'][id]', value:row.data.user_id, width: 0}			
				});
				cf.mailinglistFirstTab.theFormPanel.add(hiddenfield);
				cf.mailinglistFirstTab.theFormPanel.doLayout();
				counter++;
			}
		}
		
		var panel = cf.mailinglistSecondTab.theLeftPanel;
		var counter = 0;
		for(var a=0;a<panel.items.length;a++) {
			var fieldset  = panel.getComponent(a);
			var grid = fieldset.getComponent(0);
			var slot_id = fieldset.getId();
			slot_id = slot_id.replace('secondtabfieldsetid_','');
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'slot['+counter+'][slot_id]', value:slot_id, width: 0}			
			});
			cf.mailinglistFirstTab.theFormPanel.add(hiddenfield);
			for(var c=0;c<grid.store.getCount();c++) {
				var row = grid.getStore().getAt(c);
				var hiddenfield = new Ext.form.Field({
					autoCreate : {tag:'input', type: 'hidden', name: 'slot['+counter+'][grid]['+c+'][id]', value:row.data.id, width: 0}			
				});
				cf.mailinglistFirstTab.theFormPanel.add(hiddenfield);
			}
			counter++;
		}
		
		var authCounter = 0;
		var grid = cf.mailinglistThirdTab.theAuthorizationGrid;
		for(var c=0;c<grid.store.getCount();c++) {
			var row = grid.getStore().getAt(c);
			
			
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'auth['+authCounter+'][type]', value:row.data.raw_type, width: 0}			
			});
			cf.mailinglistFirstTab.theFormPanel.add(hiddenfield);
		
			var theRealId = row.data.raw_type + '_mailinglistthirdtab_deleteworkflow';
			var theValue = Ext.getCmp(theRealId).getValue() == true ? 1 : 0;
			
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'auth['+authCounter+'][deleteworkflow]', value:theValue, width: 0}			
			});
			cf.mailinglistFirstTab.theFormPanel.add(hiddenfield);
			
			var theRealId = row.data.raw_type + '_mailinglistthirdtab_archiveworkflow';
			var theValue = Ext.getCmp(theRealId).getValue() == true ? 1 : 0;
			
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'auth['+authCounter+'][archiveworkflow]', value:theValue, width: 0}			
			});
			cf.mailinglistFirstTab.theFormPanel.add(hiddenfield);
			
			var theRealId = row.data.raw_type + '_mailinglistthirdtab_stopneworkflow';
			var theValue = Ext.getCmp(theRealId).getValue() == true ? 1 : 0;
			
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'auth['+authCounter+'][stopneworkflow]', value:theValue, width: 0}			
			});
			cf.mailinglistFirstTab.theFormPanel.add(hiddenfield);
		
			var theRealId = row.data.raw_type + '_mailinglistthirdtab_detailsworkflow';
			var theValue = Ext.getCmp(theRealId).getValue() == true ? 1 : 0;	
			
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'auth['+authCounter+'][detailsworkflow]', value:theValue, width: 0}			
			});
			cf.mailinglistFirstTab.theFormPanel.add(hiddenfield);
			authCounter++;
			
			
		}

		return true;
	},
	
	
		
	/**
	* Submit theFormPanel
	*
	*@param string url, SubmitURL, can be UpdateForm or SaveForm
	*@param string title, confirm box title
	*/
	doSubmit: function (url, title) {
		cf.mailinglistFirstTab.theFormPanel.doLayout();
		cf.mailinglistFirstTab.theFormPanel.getForm().submit({
			url: url,
			method: 'POST',
			waitMsg: '<?php echo __('Saving Data',null,'mailinglist'); ?>',
			success: function(objServerResponse){
				cf.mailinglistPanelGrid.theMailinglistStore.reload();
				cf.mailinglistPopUpWindow.theMailinglistPopUpWindow.hide();
				cf.mailinglistPopUpWindow.theMailinglistPopUpWindow.destroy();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'mailinglist'); ?>',title);
			}
		});
		
		
	}
	
	
	
	
	
	
	
};}();