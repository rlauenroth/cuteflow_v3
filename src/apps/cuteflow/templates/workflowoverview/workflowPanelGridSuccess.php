cf.workflowmanagementPanelGrid = function(){return {
	
	theWorkflowGrid					:false,
	isInitialized					:false,
	theWorkflowStore				:false,
	theWorkflowCM					:false,
	theTopToolBar					:false,
	theBottomToolBar				:false,
	theLoadingMask					:false,
	
	init:function () {
		this.initStore();
		this.initBottomToolbar();
		this.initCM();
		this.initTopToolBar();
		this.initGrid();
		setTimeout('cf.workflowmanagementPanelGrid.storeReload()',<?php $arr = $sf_user->getAttribute('userSettings'); echo $arr['refresh_time']*1000;?>);
	},
	
	
	initBottomToolbar: function () {
		this.theBottomToolBar =  new Ext.PagingToolbar({
			pageSize: <?php $arr = $sf_user->getAttribute('userSettings'); echo $arr['displayed_item'];?>,
			store: this.theWorkflowStore,
			displayInfo: true,
			style: 'margin-bottom:10px;',
			displayMsg: '<?php echo __('Displaying topics',null,'workflowmanagement'); ?> {0} - {1} <?php echo __('of',null,'documenttemplate'); ?> {2}',
			emptyMsg: '<?php echo __('No records found',null,'documenttemplate'); ?>'
		});	
		
	},
	
	storeReload: function () {
		setTimeout('cf.workflowmanagementPanelGrid.storeReload()',<?php $arr = $sf_user->getAttribute('userSettings'); echo $arr['refresh_time']*1000;?>);
		try {
			cf.workflowmanagementPanelGrid.theWorkflowStore.reload();
		}
		catch(e) {
			
		}
		
	},
	
	/** init CM for the grid **/
	initCM: function () {
		<?php $arr = $sf_user->getAttribute('userWorkflowSettings'); ?>
		this.theWorkflowCM  =  new Ext.grid.ColumnModel([
			{header: "#", width: 50, sortable: true, dataIndex: '#', css : "text-align : left;font-size:12px;align:center;"},
			
			{header: "<?php echo $arr[0]['text'];?>", width: <?php echo $arr[0]['width']; ?>, sortable: true, dataIndex: '<?php echo $arr[0]['store']; ?>', css : "text-align : left;font-size:12px;align:center;", hidden: <?php echo $arr[0]['hidden']; ?>},
			{header: "<?php echo $arr[1]['text'];?>", width: <?php echo $arr[1]['width']; ?>, sortable: true, dataIndex: '<?php echo $arr[1]['store']; ?>', css : "text-align : left;font-size:12px;align:center;", hidden: <?php echo $arr[1]['hidden']; ?>},
			{header: "<?php echo $arr[2]['text'];?>", width: <?php echo $arr[2]['width']; ?>, sortable: true, dataIndex: '<?php echo $arr[2]['store']; ?>', css : "text-align : left;font-size:12px;align:center;", hidden: <?php echo $arr[2]['hidden']; ?>},
			{header: "<?php echo $arr[3]['text'];?>", width: <?php echo $arr[3]['width']; ?>, sortable: true, dataIndex: '<?php echo $arr[3]['store']; ?>', css : "text-align : left;font-size:12px;align:center;", hidden: <?php echo $arr[3]['hidden']; ?>},
			{header: "<?php echo $arr[4]['text'];?>", width: <?php echo $arr[4]['width']; ?>, sortable: true, dataIndex: '<?php echo $arr[4]['store']; ?>', css : "text-align : left;font-size:12px;align:center;", hidden: <?php echo $arr[4]['hidden']; ?>},
			{header: "<?php echo $arr[5]['text'];?>", width: <?php echo $arr[5]['width']; ?>, sortable: true, dataIndex: '<?php echo $arr[5]['store']; ?>', css : "text-align : left;font-size:12px;align:center;", hidden: <?php echo $arr[5]['hidden']; ?>},
			{header: "<?php echo $arr[6]['text'];?>", width: <?php echo $arr[6]['width']; ?>, sortable: true, dataIndex: '<?php echo $arr[6]['store']; ?>', css : "text-align : left;font-size:12px;align:center;", hidden: <?php echo $arr[6]['hidden']; ?>},
			{header: "<?php echo __('already done',null,'workflowmanagement'); ?>", width: 110, sortable: true, dataIndex: 'process', css : "text-align : left;font-size:12px;align:center;",  hidden: false},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/delete.png' />&nbsp;&nbsp;</td><td><?php echo __('Delete Workflow',null,'workflowmanagement'); ?></td></tr><tr><td><img src='/images/icons/zoom.png' />&nbsp;&nbsp;</td><td><?php echo __('Show Details',null,'workflowmanagement'); ?></td></tr><tr><td><img src='/images/icons/disk.png' />&nbsp;&nbsp;</td><td><?php echo __('Move to Archive',null,'workflowmanagement'); ?></td</tr><tr><td><img src='/images/icons/control_stop_blue.png' />&nbsp;&nbsp;</td><td><?php echo __('Stop Workflow',null,'workflowmanagement'); ?></td></tr><tr><td><img src='/images/icons/control_play.png' />&nbsp;&nbsp;</td><td><?php echo __('Start Workflow',null,'workflowmanagement'); ?></td></tr></table>\" ext:qwidth=\"230\"><?php echo __('Action',null,'documenttemplate'); ?></div>", width: 100, sortable: false, dataIndex: 'action', css : "text-align : left;font-size:12px;align:center;", renderer: this.renderButton}
		]);
	},
	
	/** init store for the grid **/
	initStore: function () {
		this.theWorkflowStore = new Ext.data.JsonStore({
				root: 'result',
				totalProperty: 'total',
				url: '<?php echo build_dynamic_javascript_url('workflowoverview/LoadAllWorkflow')?>',
				autoload: false,
				fields: [
					{name: '#'},
					{name: 'id'},
					{name: 'mailinglist_template_id'},
					{name: 'mailinglisttemplate'},
					{name: 'sender_id'},
					{name: 'sendername'},
					{name: 'currentstation'},
					{name: 'workflow_is_started'},
					{name: 'is_completed'},
					{name: 'stationrunning'},
					{name: 'isstopped'},
					{name: 'process'},
					{name: 'name'},
					{name: 'isstopped'},
					{name: 'auth'},
					{name: 'currentlyrunning'},
					{name: 'version_created_at'},
					{name: 'active_version_id'},
					{name: 'userdefined1'},
					{name: 'userdefined2'}
				]
		});
	},
	
	
	/** init toolbar for grid, contains ajax search **/
	initTopToolBar: function () {
		this.theTopToolBar = new Ext.Toolbar({
			items: [{	
				icon: '/images/icons/report_add.png',
	            tooltip:'<?php echo __('Create new Workflow',null,'workflowmanagement'); ?>',
				disabled: <?php $arr = $sf_user->getAttribute('credential');echo $arr['management_documenttemplate_addDocumenttemplate'];?>,
	            handler: function () {
					cf.createWorkflowWindow.init();
	            }
				
			},'-',{
				icon: '/images/icons/zoom_out.png',
	            tooltip:'<?php echo __('Reset Filter',null,'workflowmanagement'); ?>',
	            handler: function () {
					cf.workflowFilterPanel.theCounter = 0;
					cf.workflowFilterPanel.theSearchPanel.getForm().reset();
					cf.workflowFilterPanel.theFieldGrid.store.removeAll();
					var loadUrl = '<?php echo build_dynamic_javascript_url('workflowoverview/LoadAllWorkflow')?>';
					cf.workflowmanagementPanelGrid.theWorkflowStore.proxy.setApi(Ext.data.Api.actions.read,loadUrl);
					cf.workflowmanagementPanelGrid.theWorkflowStore.load();
				}
            },'->',{
            	xtype: 'label',
            	html: '<?php echo __('Items per Page',null,'usermanagement'); ?>: '
            },{
				xtype: 'combo', // number of records to display in grid
				mode: 'local',
				value: '<?php $arr = $sf_user->getAttribute('userSettings'); echo $arr['displayed_item'];?>',
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
		    				cf.workflowmanagementPanelGrid.theBottomToolBar.pageSize = combo.getValue();
		    				cf.workflowmanagementPanelGrid.theWorkflowStore.load({params:{start: 0, limit: combo.getValue()}});
		    			}
		    		}
		    	}
			}]
		});	
		
	},
	
	
	
	initGrid: function () {
		this.theWorkflowGrid = new Ext.grid.GridPanel({
			title: '<?php echo __('Workflow templates',null,'workflowmanagement'); ?>',
			stripeRows: true,
			border: true,
			width: 'auto',
			height: cf.Layout.theRegionWest.getHeight()-60,
			collapsible: false,
			loadMask: true,
			style:'margin-top:5px;margin-left:5px;margin-right:5px;',
			store: this.theWorkflowStore,
			tbar: this.theTopToolBar,
			bbar: this.theBottomToolBar,
			cm: this.theWorkflowCM
		});
		this.theWorkflowGrid.on('afterrender', function(grid) {
			cf.workflowmanagementPanelGrid.theWorkflowStore.load();
		});	
		
	},
	
	renderButton: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['id'];
		var active_version_id = record.data['active_version_id'];
		
		var isstopped = record.data['isstopped'];
		var is_completed = record.data['is_completed'];
		var workflow_is_started = record.data['workflow_is_started'];
		
		var rights = record.data['auth'];
		
		var btnDetails = cf.workflowmanagementPanelGrid.createDetailsButton.defer(10,this, [id, active_version_id, rights.details_workflow]);
		var btnEdit1 = cf.workflowmanagementPanelGrid.createDeleteButton.defer(10,this, [id, active_version_id, rights.delete_workflow]);
		var btnEdit2 = cf.workflowmanagementPanelGrid.createArchiveButton.defer(10,this, [id, active_version_id, rights.archive_workflow]);
		var btnEdit3 = cf.workflowmanagementPanelGrid.createStopButton.defer(10,this, [id, active_version_id, isstopped, workflow_is_started, is_completed, rights.stop_new_workflow]);
		return '<center><table><tr><td width="16"><div id="workflowoverview_delete'+ id +'"></div></td><td width="16"><div id="workflowoverview_details'+ id +'"></div></td><td width="16"><div id="workflowoverview_archive'+ id +'"></div></td><td width="16"><div id="workflowoverview_stop'+ id +'"></div></td></tr></table></center>';
	},
	
	
	createArchiveButton: function (id, version_id, right) {
		var btn_copy = new Ext.form.Label({
			html: '<span style="cursor:pointer;"><img src="/images/icons/disk.png" /></span>',
			renderTo: 'workflowoverview_archive' + id,
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							if(right == 1) {
								Ext.Msg.show({
								   title:'<?php echo __('Archive workflow',null,'workflowmanagement'); ?>?',
								   msg: '<?php echo __('Archive workflow',null,'workflowmanagement'); ?>?',
								   buttons: Ext.Msg.YESNO,
								   fn: function(btn, text) {
										if(btn == 'yes') {
											cf.workflowmanagementPanelCRUD.archiveWorkflow(id, version_id);
										}
								   }
								});
							}
							else {
								Ext.Msg.minWidth = 200;
								Ext.MessageBox.alert('<?php echo __('Error',null,'workflowmanagement'); ?>', '<?php echo __('Permission denied',null,'workflowmanagement'); ?>');
							}
						},
					scope: c
					});
				}
			}
		});
	},
	
	createStopButton: function (template_id, active_version_id, isstopped, workflow_is_started, is_completed, right) {
		var disabled = is_completed == 1 ? true : false;
		var btn_copy = new Ext.form.Label({
			html: '<span style="cursor:pointer;"><img src="/images/icons/control_stop_blue.png" /></span>',
			disabled: disabled,
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							if(is_completed != 1) {
								if(isstopped == 1) {
									if(right == 1) {
										cf.restartWorkflowWindow.init(active_version_id);
									}
									else {
										Ext.Msg.minWidth = 200;
										Ext.MessageBox.alert('<?php echo __('Error',null,'workflowmanagement'); ?>', '<?php echo __('Permission denied',null,'workflowmanagement'); ?>');
									}
								}
								else {
									if(right == 1) {
										if(workflow_is_started == 1) {
											cf.workflowmanagementPanelCRUD.stopWorkflow(template_id, active_version_id);
										}
										else {
											cf.workflowmanagementPanelCRUD.startWorkflow(template_id);
										}
									}
									else {
										Ext.Msg.minWidth = 200;
										Ext.MessageBox.alert('<?php echo __('Error',null,'workflowmanagement'); ?>', '<?php echo __('Permission denied',null,'workflowmanagement'); ?>');
									}
								}
							}
							else {
								Ext.Msg.minWidth = 300;
								Ext.MessageBox.alert('<?php echo __('Notice',null,'workflowmanagement'); ?>','<?php echo __('Workflow has already been completed',null,'workflowmanagement'); ?>!');
							}
						},
					scope: c
					});
				}
			}
		});
		
		if(isstopped == 1) {
			btn_copy.html = '<span style="cursor:pointer;"><img src="/images/icons/control_play_blue.png" /></span>';
		}
		if(workflow_is_started == 0) {
			btn_copy.html = '<span style="cursor:pointer;"><img src="/images/icons/control_play.png" /></span>';
		}
		if(is_completed == 1) {
			btn_copy.html = '<span style="cursor:pointer;"><img src="/images/icons/accept.png" /></span>';
		}
		btn_copy.render('workflowoverview_stop' + template_id);
	},
	
	
	createDetailsButton: function (template_id, active_version_id, right) {
		var btn_copy = new Ext.form.Label({
			renderTo: 'workflowoverview_details' + template_id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/zoom.png" /></span>',
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							if(right == 1) {
								cf.workflowdetails.init(template_id, active_version_id, false, true);
							}
							else {
								Ext.Msg.minWidth = 200;
								Ext.MessageBox.alert('<?php echo __('Error',null,'workflowmanagement'); ?>', '<?php echo __('Permission denied',null,'workflowmanagement'); ?>');
							}
						},
					scope: c
					});
				}
			}
		});
		
	},
	
	createDeleteButton: function (template_id, active_version_id, right) {
		var btn_copy = new Ext.form.Label({
			renderTo: 'workflowoverview_delete' + template_id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/delete.png" /></span>',
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							if(right == 1) {
								Ext.Msg.show({
								   title:'<?php echo __('Delete workflow',null,'workflowmanagement'); ?>?',
								   msg: '<?php echo __('Delete workflow',null,'workflowmanagement'); ?>?',
								   buttons: Ext.Msg.YESNO,
								   fn: function(btn, text) {
										if(btn == 'yes') {
											cf.workflowmanagementPanelCRUD.deleteWorkflow(template_id, active_version_id);
										}
								   }
								});
							}
							else {
								Ext.Msg.minWidth = 200;
								Ext.MessageBox.alert('<?php echo __('Error',null,'workflowmanagement'); ?>', '<?php echo __('Permission denied',null,'workflowmanagement'); ?>');
							}
						},
					scope: c
					});
				}
			}
		});
		
	}
	
	
	
	
	
};}();