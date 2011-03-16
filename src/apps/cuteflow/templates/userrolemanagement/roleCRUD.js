/**
* CRUD Functionality for Rolemangement
*
*/
cf.RoleCRUD = function(){return {


	/** delete role from database **/
	deleteRole: function (id) {
		cf.DeleteRoleWindow.init(id);
	},



	
	/**
	* save or update an exisiting role
	*
	* @param boolean new_flag, if 1 then a new record will be created, if 0 then a exisitng record is edited
	* @param int id, is only set, if a record is edited
	*
	*/
	saveRole: function (id) {
		var rolename = this.checkRolename();
		if(rolename == true) {
			if(id == '') {
				this.saveNewRole();
			}
			else {
				this.updateExistingRole();
			}
		}
	},
	
	/** check if rolename is set or not **/
	checkRolename: function () {
		if(Ext.getCmp('userrole_title_id').getValue() == '') { // no role name is set
			cf.PopUpRoleTabpanel.theTabpanel.setActiveTab(0);
			Ext.getCmp('userrole_title_id').focus();
			return false;
		}
		else {
			return true;
		}
	},
	
	/** update an role **/
	updateExistingRole: function() {
		cf.PopUpRoleTabpanel.theFormPanel.getForm().submit({
			url: '<?php echo build_dynamic_javascript_url('userrolemanagement/EditRole')?>',
			method: 'POST',
			waitMsg: '<?php echo __('Saving Data',null,'userrolemanagement'); ?>',
			success: function() {
				cf.rolePopUpWindow.theRoleWindow.hide();
				cf.rolePopUpWindow.theRoleWindow.destroy();
			}
		});
	},
	
	/** add new role **/
	saveNewRole: function () {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('userrolemanagement/CheckForExistingRole')?>/description/' + Ext.getCmp('userrole_title_id').getValue(),
			success: function(objServerResponse){
				if(objServerResponse.responseText == 1) { // save Role
					cf.PopUpRoleTabpanel.theFormPanel.getForm().submit({
						url: '<?php echo build_dynamic_javascript_url('userrolemanagement/AddRole')?>',
						method: 'POST',
						waitMsg: '<?php echo __('Saving Data',null,'userrolemanagement'); ?>',
						success: function() {
							cf.UserRoleGrid.theUserRoleStore.reload();
							cf.rolePopUpWindow.theRoleWindow.hide();
							cf.rolePopUpWindow.theRoleWindow.destroy();
						}
					});
				}
				else {
					Ext.MessageBox.alert('<?php echo __('Error',null,'userrolemanagement'); ?>', '<?php echo __('Role is already existing',null,'userrolemanagement'); ?>');
					cf.PopUpRoleTabpanel.theTabpanel.setActiveTab(0);
					Ext.getCmp('userrole_title_id').focus();
					Ext.getCmp('userrole_title_id').setValue();
				}
			}
		});
	}




};}();