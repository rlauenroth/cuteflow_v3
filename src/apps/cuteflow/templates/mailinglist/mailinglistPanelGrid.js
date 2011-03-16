/** class loads the overview grid **/
cf.mailinglistPanelGrid = function(){return {
	
	theMailinglistGrid				:false,
	isInitialized					:false,
	theMailinglistStore				:false,
	theMailinglistCM				:false,
	theTopToolBar					:false,
	theBottomToolBar				:false,
	theLoadingMask					:false,

	
	/** inits all necessary functions to build the grid and its toolbars **/
	init: function () {
		this.initStore();
		this.initBottomToolbar();
		this.initCM();
		this.initTopToolBar();
		this.initGrid();
	},
	
	doSearch: function () {
		var textfield = Ext.getCmp('mailinglistPanelGrid_searchtextfield').getValue();
		if(textfield != '') {
			var url = encodeURI('<?php echo build_dynamic_javascript_url('mailinglist/LoadAllMailinglistsByFilter')?>/name/' + textfield);
			cf.mailinglistPanelGrid.theMailinglistStore.proxy.setApi(Ext.data.Api.actions.read,url);
			cf.mailinglistPanelGrid.theMailinglistStore.reload();	
		}
	},
	
	
	/** init CM for the grid **/
	initCM: function () {
		this.theMailinglistCM  =  new Ext.grid.ColumnModel([
			{header: "#", width: 50, sortable: true, dataIndex: '#', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Name',null,'mailinglist'); ?>", width: 280, sortable: false, dataIndex: 'name', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Document Template',null,'mailinglist'); ?>", width: 280, sortable: false, dataIndex: 'formtemplate_name', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('is default',null,'mailinglist'); ?>", width: 150, sortable: false, dataIndex: 'isdefault', css : "text-align:center;font-size:12px;align:center;", renderer: this.renderRadiobox},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/group_edit.png' />&nbsp;&nbsp;</td><td><?php echo __('Edit Mailing list template',null,'mailinglist'); ?></td></tr><tr><td><img src='/images/icons/clock.png' />&nbsp;&nbsp;</td><td><?php echo __('Show Mailinglist template versions',null,'mailinglist'); ?></td></tr><tr><td><img src='/images/icons/group_delete.png' />&nbsp;&nbsp;</td><td><?php echo __('Delete Mailing List template',null,'mailinglist'); ?></td></tr><tr><td><img src='/images/icons/table_lightning.png' />&nbsp;&nbsp;</td><td><?php echo __('Adapt Mailinglist to current Document Template',null,'mailinglist'); ?></td></tr></table>\" ext:qwidth=\"300\"><?php echo __('Action',null,'mailinglist'); ?></div>", width: 100, sortable: false, dataIndex: 'action', css : "text-align : left;font-size:12px;align:center;" ,renderer: this.renderAction}
		]);
	},
	
	/** init store for the grid **/
	initStore: function () {
		this.theMailinglistStore = new Ext.data.JsonStore({
				root: 'result',
				totalProperty: 'total',
				url: '<?php echo build_dynamic_javascript_url('mailinglist/LoadAllMailinglists')?>',
				autoload: false,
				fields: [
					{name: '#'},
					{name: 'id'},
					{name: 'name'},
					{name: 'formtemplate_id'},
					{name: 'activeversion'},
					{name: 'formtemplate_name'},
					{name: 'isactive'}
				]
		});
	},
	/** init toolbar for grid, contains ajax search **/
	initTopToolBar: function () {
		this.theTopToolBar = new Ext.Toolbar({
			items: [{
				xtype: 'textfield',
				id: 'mailinglistPanelGrid_searchtextfield',
				emptyText:'<?php echo __('Search for name',null,'mailinglist'); ?>',
				width:180
			},{
				xtype: 'button',
				text: '<?php echo __('Search',null,'mailinglist'); ?>',
				icon: '/images/icons/group_go.png',
				handler: function (){
					cf.mailinglistPanelGrid.doSearch();
				}
			},'-',{
				xtype: 'button',
				tooltip: '<?php echo __('Clear field',null,'mailinglist'); ?>',
				icon: '/images/icons/delete.png',
				handler: function () {
					var textfield = Ext.getCmp('mailinglistPanelGrid_searchtextfield').setValue();
					var url = '<?php echo build_dynamic_javascript_url('mailinglist/LoadAllMailinglists')?>';
					cf.mailinglistPanelGrid.theMailinglistStore.proxy.setApi(Ext.data.Api.actions.read,url);
					cf.mailinglistPanelGrid.theMailinglistStore.reload();	
				}
			},'-',{	
				icon: '/images/icons/group_add.png',
	            tooltip:'<?php echo __('Add new Mailing List',null,'mailinglist'); ?>',
				disabled: <?php $arr = $sf_user->getAttribute('credential');echo $arr['management_mailinglist_addMailinglist'];?>,
				style: 'margin-left:20px;',
	            handler: function () {
					cf.mailinglistPopUpWindow.initNewMailinglist('');
	            }
				
			},'->',{
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
		    				cf.mailinglistPanelGrid.theBottomToolBar.pageSize = combo.getValue();
		    				cf.mailinglistPanelGrid.theMailinglistStore.load({params:{start: 0, limit: combo.getValue()}});
		    			}
		    		}
		    	}
			}]
		});
		
	},
	
	/** init paging toolbar **/
	initBottomToolbar: function () {
		this.theBottomToolBar =  new Ext.PagingToolbar({
			pageSize: <?php $arr = $sf_user->getAttribute('userSettings'); echo $arr['displayeditem'];?>,
			store: this.theMailinglistStore,
			displayInfo: true,
			style: 'margin-bottom:10px;',
			displayMsg: '<?php echo __('Displaying topics',null,'mailinglist'); ?> {0} - {1} <?php echo __('of',null,'mailinglist'); ?> {2}',
			emptyMsg: '<?php echo __('No records found',null,'mailinglist'); ?>'
		});
	},
	
	/** init grid **/
	initGrid: function () {
		this.theMailinglistGrid = new Ext.grid.GridPanel({
			title: '<?php echo __('Mailinglist templates',null,'mailinglist'); ?>',
			stripeRows: true,
			border: true,
			width: 'auto',
			height: cf.Layout.theRegionWest.getHeight() - 100,
			loadMask: true,
			collapsible: false,
			style:'margin-top:5px;margin-left:5px;margin-right:5px;',
			store: this.theMailinglistStore,
			tbar: this.theTopToolBar,
			bbar: this.theBottomToolBar,
			cm: this.theMailinglistCM
		});
		this.theMailinglistGrid.on('afterrender', function(grid) {
			cf.mailinglistPanelGrid.theMailinglistStore.load();
		});	
		
	}, 
	
	/** button renderer for edit and delete **/
	renderAction: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		cf.mailinglistPanelGrid.createEditButton.defer(500,this, [record.data['id'], record.data['activeversion']]);
		cf.mailinglistPanelGrid.createDeleteButton.defer(500,this, [record.data['id']]);
		cf.mailinglistPanelGrid.createVersionButton.defer(500,this, [record.data['id']]);
		cf.mailinglistPanelGrid.createAdaptButton.defer(500,this, [record.data['id']]);
		return '<center><table><tr><td width="16"><div id="mailinglist_edit'+ record.data['id'] +'"></div></td><td width="16"><div id="mailinglist_version'+ record.data['id'] +'"></div></td><td width="16"><div id="mailinglist_delete'+ record.data['id'] +'"></div></td><td width="16"><div id="mailinglist_adapt'+ record.data['id'] +'"></div></td></tr></table></center>';
	},
	
	/** add adapt button **/
	createAdaptButton: function (id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'mailinglist_adapt' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/table_lightning.png" /></span>',
			disabled: <?php $arr = $sf_user->getAttribute('credential');echo $arr['management_mailinglist_deleteMailinglist'];?>,
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							if (c.disabled == false) {
								Ext.Msg.minWidth = 320;
								Ext.Msg.show({
								   title:'<?php echo __('Adapt mailinglist',null,'mailinglist'); ?>?',
								   msg: '<?php echo __('Adapt mailinglist to current Document Template',null,'mailinglist'); ?>?',
								   buttons: Ext.Msg.YESNO,
								   fn: function(btn, text) {
										if(btn == 'yes') {
											cf.mailinglistCRUD.initAdapt(id);
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
	
	/** create version button with id of version **/
	createVersionButton: function (id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'mailinglist_version' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/clock.png" /></span>',
			disabled: <?php $arr = $sf_user->getAttribute('credential');echo $arr['management_documenttemplate_editVersion'];?>,
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							if (c.disabled == false) {
								cf.mailinglistVersionPopUp.init(id);
							}
						},
					scope: c
				});
				}
			}
		});
	},
	
	/**
	* edit button
	*
	*@param int id, id of the record
	*/
	createEditButton: function (id, activeversion_id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'mailinglist_edit' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/group_edit.png" /></span>',
			disabled: <?php $arr = $sf_user->getAttribute('credential');echo $arr['management_mailinglist_editMailinglist'];?>,
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							if (c.disabled == false) {
								cf.mailinglistPopUpWindow.initEdit(id, activeversion_id);
							}
						},
					scope: c
				});
				}
			}
		});
	},
	/**
	* create delete button
	*
	*@param int id, id of record
	*
	*/
	createDeleteButton: function (id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'mailinglist_delete' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/group_delete.png" /></span>',
			disabled: <?php $arr = $sf_user->getAttribute('credential');echo $arr['management_mailinglist_deleteMailinglist'];?>,
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							if (c.disabled == false) {
								Ext.Msg.show({
								   title:'<?php echo __('Delete mailinglist',null,'mailinglist'); ?>?',
								   msg: '<?php echo __('Delete mailinglist',null,'mailinglist'); ?>?',
								   buttons: Ext.Msg.YESNO,
								   fn: function(btn, text) {
										if(btn == 'yes') {
											cf.mailinglistCRUD.initDelete(id);
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
	
	/** button renderer for edit and delete **/
	renderRadiobox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		cf.mailinglistPanelGrid.createRadiobox.defer(500,this, [record.data['id'], record.data['isactive']]);
		return '<center><table><tr><td width="16"><div id="mailinglist_radiobox'+ record.data['id'] +'"></div></td></tr></table></center>';
	},
	
	/**
	* create radiobox to activate item
	*
	*@param int id, id of the record
	*@param boolean isactive
	*/
	createRadiobox: function (id, isactive) {
		var check = isactive == 1 ? true : false;
		var radio = new Ext.form.Radio({
			renderTo: 'mailinglist_radiobox' + id,
			name: 'mailinglist_radioboxGrid_radioStandard',
			checked: check,
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							Ext.Ajax.request({  
								url : '<?php echo build_dynamic_javascript_url('mailinglist/SetStandard')?>/id/' + id, 
								success: function(objServerResponse){  
								}
							});
						},
						scope: c
					});
				}
			}
		});
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
};}();