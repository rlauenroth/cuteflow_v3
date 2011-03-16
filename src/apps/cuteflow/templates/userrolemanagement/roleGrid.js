/**
* Class initialzies the Grid to display all roles stored in DB.
* Paging and Searchbar is not needed here
* 
*/
cf.UserRoleGrid = function(){return {
	theUserRoleGrid					:false,
	isInitialized					:false,
	theUserRoleStore				:false,
	theUserRoleStoreIsInitialized	:false,
	theUserRoleCM					:false,
	theTopToolBar					:false,
	
	/** inits all necessary functions to build the grid and its toolbars **/
	init: function () {
			this.isInitialized = true;
			this.initUserRoleCM();
			this.initUserRoleStore();
			this.initTopToolBar();
			this.initUserRoleGrid();
	},


	
	/** Grid and store, toolbar and cm are binded **/
	initUserRoleGrid: function () {
		this.theUserRoleGrid = new Ext.grid.GridPanel({
			title: '<?php echo __('Role management',null,'userrolemanagement'); ?>',
			stripeRows: true,
			loadMask: true,
			border: true,
			collapsible: false,
			style:'margin-top:5px;margin-left:5px;margin-right:5px;',
			store: this.theUserRoleStore,
			tbar: this.theTopToolBar,
			cm: this.theUserRoleCM
		});	
		
		this.theUserRoleGrid.on('afterrender', function(grid) {
			cf.UserRoleGrid.theUserRoleStore.load();
		});
		
	},
	


	/** columnModel **/
	initUserRoleCM: function() {

		this.theUserRoleCM  =  new Ext.grid.ColumnModel([
			{header: "#", width: 50, sortable: true, dataIndex: '#', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Role description',null,'userrolemanagement'); ?>", width: 220, sortable: false, dataIndex: 'description', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('currently used by',null,'userrolemanagement'); ?>", width: 150, sortable: false, dataIndex: 'users', css : "text-align:center;font-size:12px;align:center;"},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/cog_edit.png' />&nbsp;&nbsp;</td><td><?php echo __('Edit role',null,'userrolemanagement'); ?></td></tr><tr><td><img src='/images/icons/cog_delete.png' />&nbsp;&nbsp;</td><td><?php echo __('Remove role',null,'userrolemanagement'); ?></td></tr></table>\" ext:qwidth=\"200\"><?php echo __('Action',null,'userrolemanagement'); ?></div>", width: 80, sortable: false, dataIndex: 'action', css : "text-align : left;font-size:12px;align:center;" ,renderer: this.renderAction }
		]);

		
		
	},
	
	
	/** Toolbar, to add new role **/
	initTopToolBar: function () {
		this.theTopToolBar = new Ext.Toolbar({
			items: [{
                icon: '/images/icons/cog_add.png',
                tooltip:'<?php echo __('Add new Userrole',null,'userrolemanagement'); ?>',
                disabled: false,
                handler: function () {
                	cf.rolePopUpWindow.initNewRole(''); // new popup is opened, 1 = new record
                }
			}]
		});	
	},
	
	
	/** the store for grid **/
	initUserRoleStore: function () {
		this.theUserRoleStoreIsInitialized = true;
		this.theUserRoleStore = new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('userrolemanagement/LoadAllRoles')?>',
				autoload: false,
				fields: [
					{name: '#'},
					{name: 'id'},
					{name: 'description'},
					{name: 'users'}
				]
		});
	},
	
	/** 
	* function created edit and delete button for the grid. button is displayed as label 
	*
	* @param int id, id of the record
	**/
	createButtons: function (id, label) {
		var disabled = false;
		if (label == 'admin' || label == 'sender' || label == 'receiver') {
			disabled = true;
		}
		var btn_delete = new Ext.form.Label(  {
			renderTo: 'role_del_' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/cog_delete.png" /></span>',
			disabled: disabled,
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							if(c.disabled == false) {
								Ext.Msg.show({
								   title:'<?php echo __('Delete role?',null,'userrolemanagement'); ?>',
								   msg: '<?php echo __('Delete role?',null,'userrolemanagement'); ?>',
								   buttons: Ext.Msg.YESNO,
								   fn: function(btn, text) {
										if(btn == 'yes') {
											cf.RoleCRUD.deleteRole(id);
										}
								   }
								});
							}
						},
					scope: c
					});
				}
			}
		});
		
		var btn_edit = new Ext.form.Label(  {
			renderTo: 'role_edit_' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/cog_edit.png" /></span>',
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							cf.rolePopUpWindow.initEditRole(id);
						},
					scope: c
					});
				}
			}
		});
		
	
	},
	
	/** render both buttons to grid **/
	renderAction: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		cf.UserRoleGrid.createButtons.defer(500, this, [record.data['id'], record.data['description'],]);
		return '<center><table><tr><td width="16"><div id="role_edit_'+ record.data['id'] +'"></div></td><td><div style="float:left;" id="role_del_'+ record.data['id'] +'"></div></td></tr></table></center>'
	}

};}();







