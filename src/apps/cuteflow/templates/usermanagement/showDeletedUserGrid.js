cf.showDeletedUserGrid = function(){return {

	theDeletedUserGrid					: false,
	theDeletedUserStore					: false,
	theDeletedGridCM					: false,

	
	init: function () {
		this.initCM();
		this.initStore();
		this.initGrid();
	},
	
	
	initCM: function () {
		this.theDeletedGridCM  =  new Ext.grid.ColumnModel([
			{header: "#", width: 50, sortable: true, dataIndex: '#', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Firstname',null,'usermanagement'); ?>", width: 150, sortable: false, dataIndex: 'firstname', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Lastname',null,'usermanagement'); ?>", width: 150, sortable: false, dataIndex: 'lastname', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Email',null,'usermanagement'); ?>", width: 150, sortable: false, dataIndex: 'email', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Username',null,'usermanagement'); ?>", width: 150, sortable: false, dataIndex: 'username', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/user_go.png' />&nbsp;&nbsp;</td><td><?php echo __('Activate user',null,'usermanagement'); ?></td></tr></table>\" ext:qwidth=\"200\"><?php echo __('Action',null,'usermanagement'); ?></div>",  width: 80, sortable: false, dataIndex: 'action', css : "text-align :center; font-size:12px;", renderer: this.renderAction}
		]);
	
	},
	
	
	initStore: function () {
		this.theDeletedUserStore = new Ext.data.JsonStore({
			totalProperty: 'total',
			root: 'result',
			url: '<?php echo build_dynamic_javascript_url('usermanagement/LoadDeletedUser')?>',
			fields: [
				{name: '#'},
				{name: 'id'},
				{name: 'firstname'},
				{name: 'lastname'},
				{name: 'email'},
				{name: 'username'},
				{name: 'action'}
			]
		});	
	
	},
	
	initGrid: function () {
		this.theDeletedUserGrid = new Ext.grid.GridPanel({
			frame:false,
			autoScroll: true,
			collapsible:false,
			closable: false,
			title: '<?php echo __('User overview',null,'usermanagement'); ?>',
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 80,
			border: true,
			store: this.theDeletedUserStore,
			cm: this.theDeletedGridCM
		});
		this.theDeletedUserGrid.on('afterrender', function(grid) {
			cf.showDeletedUserGrid.theDeletedUserStore.load();
		});
	
	},
	
	
	
	/** Function to render "Edit Button" into datagrid **/
	renderAction: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var action = record.data['action'];
		cf.showDeletedUserGrid.createActivateButton.defer(500,this, [record.data['action']]);
		return '<center><table><tr><td width="16"><div id="user_activate'+ record.data['id'] +'"></div></td></tr></table></center>';
	},
	
	
	/**
	* Function loads a label that includes an image into grid. Builds edit button
	* @param int id, ID of the current record
	*/
	createActivateButton:function (user_activateid) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'user_activate' + user_activateid,
			html: '<span style="cursor:pointer;"><img src="/images/icons/user_go.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							cf.showDeletedUserGrid.activateUser(user_activateid);
						},
					scope: c
				});
				}
			}
		});
		
	},
	
	activateUser: function (user_id) {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('usermanagement/ActivateUser')?>/id/' + user_id,
			success: function(objServerResponse){ 
				cf.showDeletedUserGrid.theDeletedUserStore.reload();
				cf.UserGrid.theUserStore.reload();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'usermanagement'); ?>', '<?php echo __('User activated',null,'usermanagement'); ?>');
			}
		});
		
	
	}
	
	
	
	
	
	
};}();