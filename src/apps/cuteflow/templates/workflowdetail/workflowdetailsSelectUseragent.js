cf.workflowdetailsSelectUseragent = function(){return {
	
	thePopUpWindow					:false,
	theCM							:false,
	theStore						:false,
	theGrid							:false,
	theToolbar						:false,
	theWorkflowProcessUserId		:false,
	theTemplateVersionId			:false,
	
	
	init: function (workflowprocessuser_id, templateversion_id) {
		this.theWorkflowProcessUserId = workflowprocessuser_id;
		this.theTemplateVersionId = templateversion_id;
		this.initCM();
		this.initStore();
		this.initToolbar();
		this.initGrid();
		this.initWindow();
		this.thePopUpWindow.add(this.theGrid);
		this.thePopUpWindow.doLayout();
		this.thePopUpWindow.show();
		
	},
	
	
	initToolbar: function () {
		this.theToolbar = new Ext.Toolbar({
			items: [{
				xtype: 'textfield',
				id: 'workflowdetailsSelectUseragent_livesearch',
				emptyText:'<?php echo __('Search for User...',null,'workflowmanagement'); ?>',
				width: 200,
				enableKeyEvents: true,
				listeners: {
					keyup: function(el, type) {
						var grid = cf.workflowdetailsSelectUseragent.theGrid;
						grid.store.filter('text', el.getValue());
					}
				}
			},'-',{
				icon: '/images/icons/delete.png',
				tooltip: '<?php echo __('Clear field',null,'workflowmanagement'); ?>',
				handler: function () {
					Ext.getCmp('workflowdetailsSelectUseragent_livesearch').setValue();
					cf.workflowdetailsSelectUseragent.theGrid.store.filter('text', '');
                }
			}]
		});
	},
	
	
	initGrid: function () {
		this.theGrid = new Ext.grid.GridPanel({
			frame:false,
			autoScroll: true,
			collapsible:false,
			closable: false,
			title: '<table><tr><td><img src="/images/icons/user_suit.png" /></td><td><?php echo __('Available Useragents',null,'workflowmanagement'); ?></td></tr></table>',
			height: 485,
			width:'auto',
			border: true,
			plain: false,
			enableDragDrop:false,
			expand: true,
			store: this.theStore,
			tbar: this.theToolbar,
			cm: this.theCM
		});
		this.theGrid.on('render', function(grid) {
			cf.workflowdetailsSelectUseragent.theStore.load();
		});
	},
	
	initCM: function () {
		this.theCM = new Ext.grid.ColumnModel([
			{header: "<?php echo __('Name',null,'workflowmanagement'); ?>", width: 300, sortable: true, dataIndex: 'username', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/user_go.png' />&nbsp;&nbsp;</td><td><?php echo __('Set as Useragent',null,'workflowmanagement'); ?></td></tr></table>\" ext:qwidth=\"200\"><?php echo __('Action',null,'workflowmanagement'); ?></div>", width: 60, sortable: true, css : "text-align : left;font-size:12px;align:center;", renderer: this.buttonRenderer}
		]);
		
	},
	
	initStore: function () {
		this.theStore = new Ext.data.JsonStore({
			root: 'result',
			url: '<?php echo build_dynamic_javascript_url('usermanagement/LoadUserGrid')?>',
			fields: [
				{name: 'id'},
				{name: 'username'},
				{name: 'text'}
			]
		});	
	},
	
	buttonRenderer: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['id'];
		
		var btn = cf.workflowdetailsSelectUseragent.createSetButton.defer(1,this, [id, cf.workflowdetailsSelectUseragent.theWorkflowProcessUserId, cf.workflowdetailsSelectUseragent.theTemplateVersionId]);
		return '<center><table><tr><td><div id="setnewuseragent'+ id +'"></div></td></tr></table></center>';
	},
	
	
	createSetButton: function (user_id, workflowprocessuser_id, templateversion_id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'setnewuseragent' + user_id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/user_go.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							cf.workflowdetailsCRUD.setUseragent(user_id, workflowprocessuser_id, templateversion_id);
						},
					scope: c
				});
				}
			}
		});
		
	},
	
	initWindow: function () {
		this.thePopUpWindow = new Ext.Window({
			modal: true,
			closable: true,
			modal: true,
			height: 550,
			width: 500,
			autoScroll: true,
			title: '<?php echo __('Select a Useragent',null,'workflowmanagement'); ?>',
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: false,
			close : function(){
				cf.workflowdetailsSelectUseragent.thePopUpWindow.hide();
				cf.workflowdetailsSelectUseragent.thePopUpWindow.destroy();
			}
		});
		
	}
	
	
	
	












};}();