/** CRUD functions for Field **/
cf.fieldCRUD = function(){return {
	
	
	theLoadingMask					:false,
	/**
	* function deletes a record
	*@param int id, id of record to delete
	*/
	initDelete:function (id) {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('field/DeleteField')?>/id/' + id, 
			success: function(objServerResponse){
				cf.fieldPanelGrid.theFieldStore.reload();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'field'); ?>', '<?php echo __('Delete successful',null,'field'); ?>');
			}
		});  	
	},
	
	/**
	* function inits save/update process
	*@param int id, id is set if in edit mode 
	*@param object saveObject, object to save
	*/
	initSave: function (id, saveObject) {
		var check = this.checkValues(saveObject);
		if(check == true) {
			this.doSubmit(id);
		}
	},
	
	
	/**
	* save / update record
	*
	*@param int id, id is set if in editmode
	*/
	doSubmit: function (id) {	
		if(id != '') {
			var url = '<?php echo build_dynamic_javascript_url('field/UpdateField')?>/id/' + id;
			var title = '<?php echo __('Data updated',null,'field'); ?>';
		}
		else {
			var url = '<?php echo build_dynamic_javascript_url('field/SaveField')?>';
			var title = '<?php echo __('Data saved',null,'field'); ?>';
		}
		cf.createFileWindow.theFormPanel.getForm().submit({
			url: url,
			method: 'POST',
			waitMsg: '<?php echo __('Saving Data',null,'field'); ?>',
			success: function(objServerResponse){
				cf.fieldPanelGrid.theFieldStore.reload();
				cf.createFileWindow.theFieldPopUpWindow.hide();
				cf.createFileWindow.theFieldPopUpWindow.destroy();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'field'); ?>',title);
			}
		});
	},
	
	/**
	* function checks if all data is correct filled
	*
	* @param object saveObject
	*
	*/
	checkValues: function (saveObject) {
		if(saveObject.checkBeforeSubmit() == true) {
			return true;
		}
		else {
			return false;
		}
	}


};}();