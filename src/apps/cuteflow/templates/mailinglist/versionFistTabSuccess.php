/** init first tab **/
cf.mailinglistVersionFirstTab = function(){return {
	
	
	thePanel				:false,
	theFieldset				:false,
	theGrid					:false,
	theGridCM				:false,
	theGridStore			:false,
	theLoadingMask			:false,
	
	/**
	*
	*init first tab
	*
	*@param int parent_id, id of the template
	*
	*/
	init:function (parent_id) {
		this.initStore(parent_id);
		this.initCM();
		this.initGrid();
		this.initPanel();
		this.initFieldset();
		this.theFieldset.add(this.theGrid);
		this.thePanel.add(this.theFieldset);
	},
	
	
	/**
	*
	* init store for grid
	*
	*@param int parent_id, id of template to laod
	*/
	initStore: function (parent_id) {
		this.theGridStore =  new Ext.data.JsonStore({
			root: 'result',
			url: '<?php echo build_dynamic_javascript_url('mailinglist/LoadAllVersion')?>/id/' + parent_id,
			autoload: false,
			fields: [
				{name: '#'},
				{name: 'id'},
				{name: 'mailinglisttemplate_id'},
				{name: 'name'},
				{name: 'activeversion'},
				{name: 'created_at'}
			]
		});	
		
	},
	
	/** init CM **/
	initCM: function () {
		this.theGridCM  =  new Ext.grid.ColumnModel([
			{header: "#", width: 50, sortable: true, dataIndex: '#', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Name',null,'mailinglist'); ?>", width: 280, sortable: false, dataIndex: 'name', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('created at',null,'mailinglist'); ?>", width: 130, sortable: false, dataIndex: 'created_at', css : "text-align:center;font-size:12px;align:center;"},
			{header: "<?php echo __('currently active',null,'mailinglist'); ?>", width: 120, sortable: false, dataIndex: 'activeversion', css : "text-align:center;font-size:12px;align:center;"},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/clock_go.png' />&nbsp;&nbsp;</td><td><?php echo __('Activate Mailinglist template',null,'mailinglist'); ?></td></tr><tr><td><img src='/images/icons/zoom.png' />&nbsp;&nbsp;</td><td><?php echo __('Show Mailinglist template version',null,'mailinglist'); ?></td></tr></table>\" ext:qwidth=\"230\"><?php echo __('Action',null,'mailinglist'); ?></div>", width: 80, sortable: false, dataIndex: 'action', css : "text-align : left;font-size:12px;align:center;" ,renderer: this.renderAction}
		]);
	},
	
	
	
	
	/** button renderer for activate and show **/
	renderAction: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		cf.mailinglistVersionFirstTab.createActivateButton.defer(500,this, [record.data['id'],record.data['mailinglisttemplate_id']]);
		cf.mailinglistVersionFirstTab.createShowButton.defer(500,this, [record.data['#'],record.data['id'],record.data['created_at'],record.data['mailinglisttemplate_id']]);
		return '<center><table><tr><td width="16"><div id="mailinglisttemplateversion_activate'+ record.data['id'] +'"></div></td><td width="16"><div id="mailinglisttemplateversion_show'+ record.data['id'] +'"></div></td></tr></table></center>';
	},
	
	/**
	* activate button
	*
	*@param int id, id of the record
	*@param int mailinglisttemplate_id, template id
	*/
	createActivateButton: function (id, mailinglisttemplate_id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'mailinglisttemplateversion_activate' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/clock_go.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							Ext.Msg.show({
							   title:'<?php echo __('Activate Template',null,'mailinglist'); ?>?',
							   msg: '<?php echo __('Activate Template',null,'mailinglist'); ?>?',
							   buttons: Ext.Msg.YESNO,
							   fn: function(btn, text) {
									if(btn == 'yes') {
										cf.mailinglistCRUD.theLoadingMask = new Ext.LoadMask(cf.mailinglistVersionPopUp.theVersionWindow.body, {msg:'<?php echo __('Updating Data...',null,'mailinglist'); ?>'});					
										cf.mailinglistCRUD.theLoadingMask.show();
										Ext.Ajax.request({  
											url : '<?php echo build_dynamic_javascript_url('mailinglist/ActivateMailinglist')?>/id/' + id + '/mailinglistid/' + mailinglisttemplate_id, 
											success: function(objServerResponse){
												cf.mailinglistVersionPopUp.theVersionWindow.hide();
												cf.mailinglistVersionPopUp.theVersionWindow.destroy();
												cf.mailinglistPanelGrid.theMailinglistStore.reload();
												cf.mailinglistCRUD.theLoadingMask.hide();
												Ext.Msg.minWidth = 200;
												Ext.MessageBox.alert('<?php echo __('OK',null,'mailinglist'); ?>','<?php echo __('Mailinglist activated',null,'mailinglist'); ?>');
											}
										});
									}
							   }
							});
						},
					scope: c
				});
				}
			}
		});
	},
	/**
	* show button
	*
	*@param int grid_id, id of the grid #
	*@param int id, id of the template
	*@param string created_at, creation time of record
	*@param int mailinglisttemplateid, id of template
	*/
	createShowButton: function (grid_id, id, created_at,mailinglisttemplateid) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'mailinglisttemplateversion_show' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/zoom.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							cf.mailinglistVersionFirstTab.theLoadingMask = new Ext.LoadMask(cf.mailinglistVersionPopUp.theVersionWindow.body, {msg:'<?php echo __('Loading Data...',null,'mailinglist'); ?>'});					
							cf.mailinglistVersionFirstTab.theLoadingMask.show();
							Ext.Ajax.request({  
								url : '<?php echo build_dynamic_javascript_url('mailinglist/LoadSingleMailinglist')?>/id/' + id, 
								success: function(objServerResponse){		
									theJsonTreeData = Ext.util.JSON.decode(objServerResponse.responseText);
									cf.mailinglistVersionSecondTab.init(id, theJsonTreeData.result, created_at, grid_id, mailinglisttemplateid);
								}
							});
						},
					scope: c
				});
				}
			}
		});
	},
	
	
	/** init grid **/
	initGrid: function () {
		this.theGrid = new Ext.grid.GridPanel({
			title: '<?php echo __('Mailinglist templates',null,'mailinglist'); ?>',
			stripeRows: true,
			border: false,
			width: 'auto',
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 210,
			collapsible: false,
			style:'margin-top:5px;margin-left:5px;margin-right:5px;',
			store: this.theGridStore,
			cm: this.theGridCM
		});
		this.theGrid.on('afterrender', function(grid) {
			cf.mailinglistVersionFirstTab.theGridStore.load();
		});	
		
	},
	/** init fieldset **/
	initFieldset:function () {
		this.theFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Select Mailinglist template',null,'mailinglist'); ?>',
			width: 'auto',
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 190,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 170
		});
		
	},
	
	/** init panel **/
	initPanel: function () {
		this.thePanel = new Ext.Panel({
			title: '<?php echo __('Select Document template',null,'mailinglist'); ?>',
			frame:true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 148
		});
		
	}
	
	
	
	
	
	
	
	
};}();