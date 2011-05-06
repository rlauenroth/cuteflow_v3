/**
* Function creates the popup, to apply the users of an deleted role into another role.
*
*
*/
cf.DeleteRoleWindow = function(){return {

	theRoleDeleteWindow			:false,
	theCombobox					:false,
	theComboStore				:false,
	thePanel					:false,
	
	
	/**
	* Function calls all necessary functions to display the popup
	*
	* @param int id, id of the role, which will be deleted
	*
	*/
	init:function (id) {
		this.initComboStore(id);
		this.theComboStore.load();
		this.initPanel();
		this.initWindow(id);
		this.theRoleDeleteWindow.add(this.thePanel);
		this.theRoleDeleteWindow.show();
	
	},
	
	/** store for the combobox **/
	initComboStore: function (id) {
		this.theComboStore = new Ext.data.JsonStore({
			mode: 'local',
			autoload: true,
			url: '<?php echo build_dynamic_javascript_url('userrolemanagement/LoadDeletableRoles')?>/id/' + id,
			root: 'result',
			fields: [
				{name: 'value'},
				{name: 'text'}
			]
		});
	},
	
	/** Panel, where combo is binded **/
	initPanel: function () {
		this.thePanel = new Ext.Panel({
			plain: false,
			frame: true,
			buttonAlign: 'center',
			layout: 'form',
			height: 110,
			autoScroll: false,
			items: [{
				xtype: 'combo',
				fieldLabel: '<?php echo __('Move all users to',null,'userrolemanagement'); ?>',
				valueField: 'value',
				displayField: 'text',
				editable: false,
				mode: 'local',
				id: 'deleteUserRightCombo',
				triggerAction: 'all',
				selectOnFocus:true,
				allowBlank: false,
				forceSelection:true,
				store: cf.DeleteRoleWindow.theComboStore
				
			}]
		});
	},
	
	/** 
	* popupwindow, where panel is added
    *	
    * @param deleteid, id of the entry which is to delete
    */
	initWindow: function (deleteid) {
		this.theRoleDeleteWindow = new Ext.Window({
			modal: true,
			closable: true,
			modal: true,
			height: 130,
			width: 400,
			autoScroll: false,
			title: '<?php echo __('Delete Role',null,'userrolemanagement'); ?>',
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: false,
			close : function(){
				cf.DeleteRoleWindow.theRoleDeleteWindow.hide();
				cf.DeleteRoleWindow.theRoleDeleteWindow.destroy();
			},
	        buttonAlign: 'center',
			buttons:[{
				id: 'removeButton',
				text:'<?php echo __('Delete',null,'userrolemanagement'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () { // delete role
					if(Ext.getCmp('deleteUserRightCombo').getValue() != '') {
						var updateid = (Ext.getCmp('deleteUserRightCombo').getValue());
						Ext.Ajax.request({ 
							url : '<?php echo build_dynamic_javascript_url('userrolemanagement/DeleteRole')?>/deleteid/' + deleteid + '/updateid/' + updateid, 
							success: function(objServerResponse){
								cf.UserRoleGrid.theUserRoleStore.reload();
								if(cf.UserGrid.theUserStoreIsInitialized == true) {
									cf.UserGrid.theUserStore.reload();
								}
								Ext.Msg.minWidth = 200;
								Ext.MessageBox.alert('<?php echo __('OK',null,'userrolemanagement'); ?>', objServerResponse.responseText + ' <?php echo __('profiles changed',null,'userrolemanagement'); ?>');
							}
						});
						cf.DeleteRoleWindow.theRoleDeleteWindow.hide();
						cf.DeleteRoleWindow.theRoleDeleteWindow.destroy();
					}
				}
			},
			{ // do nothing
				id: 'cancelButton',
				text:'<?php echo __('close',null,'userrolemanagement'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {
					cf.DeleteRoleWindow.theRoleDeleteWindow.hide();
					cf.DeleteRoleWindow.theRoleDeleteWindow.destroy();
			}
			}]
		});
	}
};}();