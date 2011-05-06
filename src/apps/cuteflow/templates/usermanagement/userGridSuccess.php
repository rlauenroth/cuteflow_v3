/**
* Class inits the usergrid with all necessary components:
*	- toolbar
* 	- paging
*	- renderer of the button for the grid
*
*/

cf.UserGrid = function(){return {
	isInitialized				: false,
	theUserGrid					: false,
	theUserStore				: false,
	theUserStoreIsInitialized	: false,
	theGridCM					: false,
	theGridTopToolbar			: false,
	theGridPanel				: false,
	theGridBottomToolbar		: false,

	/** main init function **/
	init:function() {	
		this.initGridStore();
		this.initBottomToolBar();
		this.initColumnModel();
		this.initTopToolBar();
		this.initUserGrid();
		this.initGridbarPanel();
		this.theGridPanel.add(this.theUserGrid);
	},
	
	
	
	/** function initializes the usergrid and sets columnmodel, store and toolbars **/
	initUserGrid: function () {
		this.isInitialized  = true;
		this.theUserGrid = new Ext.grid.GridPanel({
			frame:false,
			autoScroll: true,
			collapsible:false,
			loadMask: true,
			height: cf.Layout.theRegionWest.getHeight() - 90,
			closable: false,
			title: '<?php echo __('User overview',null,'usermanagement'); ?>',
			border: true,
			store: this.theUserStore,
			cm: this.theGridCm,
			tbar: this.theGridTopToolbar,
			bbar: this.theGridBottomToolbar
		});
		this.theUserGrid.on('afterrender', function(grid) {
			cf.UserGrid.theUserStore.load();
		});
		
	},
	
	/** Function inits top Toolbar, with Add, Delete User and number of pages displayed **/
	initTopToolBar: function () {
		this.theGridTopToolbar = new Ext.Toolbar({
			items: [{
                icon: '/images/icons/user_add.png',
                tooltip:'<?php echo __('Add new user',null,'usermanagement'); ?>',
                disabled: <?php $arr = $sf_user->getAttribute('credential');echo $arr['administration_usermanagement_addUser'];?>,
                handler: function () {
					if(cf.administration_myprofile.isInitialized == false) {
						cf.createUserWindow.init();
					}
					else {
					Ext.Msg.minWidth = 450;
					Ext.MessageBox.alert('<?php echo __('Error',null,'usermanagement'); ?>', '<?php echo __('Profile changes and editing/creating user at same time is not supported',null,'usermanagement'); ?>');
					}
                }
		    },'-',{
				icon: '/images/icons/user_red.png',
				tooltip:'<?php echo __('Show deleted User',null,'usermanagement'); ?>',
				disabled: <?php $arr = $sf_user->getAttribute('credential');echo $arr['administration_usermanagement_showDeleted'];?>,
				handler: function () {
					cf.showDeletedUserPopUpWindow.init();
                }
			},'-',{
				icon: '/images/icons/group_key.png',
                tooltip:'<?php echo __('Add LDAP User',null,'usermanagement'); ?>',
                disabled: <?php $arr = $sf_user->getAttribute('credential');echo $arr['administration_usermanagement_addLdap'];?>,
                disabled: <?php echo Usermanagement::checkLDAP(); ?>,
                handler: function () {
					alert('add LDAP user');
                }
            },'->',
            {
            	xtype: 'label',
            	html: '<?php echo __('Items per Page',null,'usermanagement'); ?>: '
            },{
				xtype: 'combo', // number of records to display in grid
				mode: 'local',
				value: '<?php $arr = $sf_user->getAttribute('userSettings'); echo $arr['displayeditem'];?>',
				editable:false,
				triggerAction: 'all',
				foreSelection: true,
				fieldLabel: '',
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[[25, '25'],[50, '50'],[75, '75'],[100, '100']]
   				}),
 				valueField:'id',
				displayField:'text',
				width:50,
				listeners: {
		    		select: {
		    			fn:function(combo, value) {
		    				cf.UserGrid.theGridBottomToolbar.pageSize = combo.getValue();
		    				cf.UserGrid.theUserStore.load({params:{start: 0, limit: combo.getValue()}});
		    			}
		    		}
		    	}
		   }]
		});	
	},
	
	/** Paging toolbar **/
	initBottomToolBar: function () {
		this.theGridBottomToolbar =  new Ext.PagingToolbar({
			pageSize: <?php $arr = $sf_user->getAttribute('userSettings'); echo $arr['displayeditem'];?>,
			store: this.theUserStore,
			displayInfo: true,
			displayMsg: '<?php echo __('Displaying topics',null,'usermanagement'); ?> {0} - {1} <?php echo __('of',null,'usermanagement'); ?> {2}',
			emptyMsg: '<?php echo __('No records found',null,'usermanagement'); ?>'
		});
	},
	
	/** Panel where grid is rendered in **/
	initGridbarPanel: function () {
		this.theGridPanel = new Ext.Panel({
			closable: false,
			plain: true,
			frame: false,
			height: cf.Layout.theRegionWest.getHeight() - 70,
			border: false,
			layout: 'fit',
			style:'margin-top:5px;margin-left:5px;'
		});
	},
	
	/** Columnmodel for grid **/
	initColumnModel: function () {
		this.theGridCm  =  new Ext.grid.ColumnModel([
			{header: "#", width: 50, sortable: true, dataIndex: '#', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Firstname',null,'usermanagement'); ?>", width: 150, sortable: false, dataIndex: 'firstname', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Lastname',null,'usermanagement'); ?>", width: 150, sortable: false, dataIndex: 'lastname', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Email',null,'usermanagement'); ?>", width: 150, sortable: false, dataIndex: 'email', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Username',null,'usermanagement'); ?>", width: 150, sortable: false, dataIndex: 'username', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Userrole',null,'usermanagement'); ?>", width: 150, sortable: false, dataIndex: 'role_description', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/user_edit.png' />&nbsp;&nbsp;</td><td><?php echo __('Edit user',null,'usermanagement'); ?></td></tr><tr><td><img src='/images/icons/user_delete.png' />&nbsp;&nbsp;</td><td><?php echo __('Delete user',null,'usermanagement'); ?></td></tr></table>\" ext:qwidth=\"200\"><?php echo __('Action',null,'usermanagement'); ?></div>",  width: 80, sortable: false, dataIndex: 'action', css : "text-align :center; font-size:12px;", renderer: cf.UserGrid.renderAction}
		]);
		
     },
	
     /** Store for grid **/
	initGridStore: function () {
		this.theUserStoreIsInitialized = true;
		this.theUserStore = new Ext.data.JsonStore({
				totalProperty: 'total',
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('usermanagement/LoadAllUser')?>',
				fields: [
					{name: '#'},
					{name: 'id'},
					{name: 'firstname'},
					{name: 'lastname'},
					{name: 'email'},
					{name: 'username'},
					{name: 'role_description'},
					{name: 'role_id'},
					{name: 'action'}
				]
		});	
	},
	
	/** Function to render "Edit Button" into datagrid **/
	renderAction: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var action = record.data['action'];
		cf.UserGrid.createAddButton.defer(500,this, [record.data['action']]);
		cf.UserGrid.createDeleteButton.defer(500,this, [record.data['action']]);
		return '<center><table><tr><td width="16"><div id="user_edit'+ record.data['id'] +'"></div></td><td width="16"><div id="user_delete'+ record.data['id'] +'"></div></td></tr></table></center>';
	},
	
	
	/**
	* Function loads a label that includes an image into grid. Builds edit button
	* @param int id, ID of the current record
	*/
	createAddButton:function (user_editid) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'user_edit' + user_editid,
			disabled: <?php $arr = $sf_user->getAttribute('credential');echo $arr['administration_usermanagement_editUser'];?>,
			html: '<span style="cursor:pointer;"><img src="/images/icons/user_edit.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							if (c.disabled == false) {
								cf.editUserWindow.init(user_editid);
							}
						},
					scope: c
				});
				}
			}
		});
		
	},
		/**
	* Function loads a label that includes an image into grid. Builds delete button
	* @param int id, ID of the current record
	*/
	createDeleteButton:function (user_id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'user_delete' + user_id,
			disabled: <?php $arr = $sf_user->getAttribute('credential');echo $arr['administration_usermanagement_removeUser'];?>,
			html: '<span style="cursor:pointer;"><img src="/images/icons/user_delete.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							if (c.disabled == false) {
								Ext.Msg.show({
								   title:'<?php echo __('Delete user?',null,'usermanagement'); ?>',
								   msg: '<?php echo __('Delete user?',null,'usermanagement'); ?>',
								   buttons: Ext.Msg.YESNO,
								   fn: function(btn, text) {
										if(btn == 'yes') {
											cf.UserGrid.deleteUser(user_id);
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
		
	},
	/**
	* Function deletes User
	*
	*@param int user_id, user to delete
	*/
	
	deleteUser: function (user_id) {
		if (user_id != <?php echo $sf_user->getAttribute('id'); ?>) {
			Ext.Ajax.request({  
				url : '<?php echo build_dynamic_javascript_url('usermanagement/DeleteUser')?>/id/' + user_id,
				success: function(objServerResponse){ 
					cf.UserGrid.theUserStore.reload();
					Ext.Msg.minWidth = 200;
					Ext.MessageBox.alert('<?php echo __('OK',null,'usermanagement'); ?>', '<?php echo __('User deleted',null,'usermanagement'); ?>');
				}
			});
		}
		else {
			Ext.Msg.minWidth = 200;
			Ext.MessageBox.alert('<?php echo __('Error',null,'usermanagement'); ?>', '<?php echo __('Own profile cannot be deleted',null,'usermanagement'); ?>');
		}
		
		
	}

	
	
	
	
	
};}();