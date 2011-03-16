/** second tab for versionpopup **/
cf.mailinglistVersionSecondTab = function(){return {
	
	theGridCM					:false,
	theFirstPanel				:false,
	theSecondPanel				:false,
	theTabPanel					:false,
	theAuthorizationFieldset	:false,
	theSenderFieldset			:false,
	theAuthorizationCM			:false,
	theSendToAllReceiver		:false,
	
	/**
	* create a new tab with data in the tabpanel
	*
	*@param int id, id of the version
	*@param string data, json data
	*@param string created_at, creation date
	*@param int grid_id, # id of the grid
	*@param int mailinglisttemplateid, id of the template
	*
	*/
	init: function (id, data, created_at, grid_id, mailinglisttemplateid) {
		var toolbar1 = this.initToolbar(id,mailinglisttemplateid);
		var toolbar2 = this.initToolbar(id,mailinglisttemplateid);
		this.initSendToAllReceiver(data.sendtoallslotsatonce);
		this.initAuthorizationCM();
		var authGrid = this.initAuthorizationGrid(id);
		this.initAllowedSenderCM();
		var theAllowedSenderGrid = this.initAllowedSenderGrid(id);
		this.initAuthorizationFieldset();
		this.theAuthorizationFieldset.add(authGrid);
		this.initSenderFieldset();
		this.theSenderFieldset.add(theAllowedSenderGrid);
		this.initFirstTab();
		this.initSecondTab();
		this.initTabPanel();
		this.theFirstPanel.add(toolbar1);
		this.theSecondPanel.add(toolbar2);
		this.theFirstPanel.add(this.theSendToAllReceiver);
		this.theFirstPanel.add(this.theSenderFieldset);
		this.theFirstPanel.add(this.theAuthorizationFieldset);
		this.theTabPanel.add(this.theFirstPanel);
		this.theTabPanel.add(this.theSecondPanel);
		this.initGridCM();

		var panel = this.initTab(id, created_at, grid_id);
		
		
		panel.add(this.theTabPanel);
		for(var a=0;a<data.slots.length;a++) {
			var fieldset = this.initFieldset(data.slots[a].name);
			var grid = this.initGrid();
			fieldset.add(grid);
			this.theSecondPanel.add(fieldset);
			for(var b=0;b<data.slots[a].users.length;b++) {
				var item = data.slots[a].users[b];
				var Rec = Ext.data.Record.create({name: 'name'});
				grid.store.add(new Rec({ title: item.name}));
			}
		}
		cf.mailinglistVersionPopUp.theTabPanel.add(panel);
		cf.mailinglistVersionPopUp.theTabPanel.setActiveTab(panel);
		cf.mailinglistVersionFirstTab.theLoadingMask.hide();
	},
	
	
	initSendToAllReceiver: function (checked) {
		checked = checked == 1 ? true : false,
		
		this.theSendToAllReceiver = new Ext.form.FieldSet({
			title: '<?php echo __('Send to all slots at once',null,'mailinglist'); ?>',
			width: 700,
			height: 80,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 180,
			items:[{
				xtype: 'checkbox',
				fieldLabel: '<?php echo __('Send to all slots at once',null,'mailinglist'); ?>?',
				inputValue: '1',
				style: 'margin-top:3px;',
				checked: checked,
				id: 'mailinglistFirstTab_sendtoallslots'	
			}]
		});
	},
	
	/** CM for auth **/
	initAuthorizationCM: function () {
		this.theAuthorizationCM  =  new Ext.grid.ColumnModel([
			{header: "<?php echo __('Action',null,'mailinglist'); ?>",  width: 200, sortable: false, dataIndex: 'type', css : "text-align :left; font-size:12px;"},
			{header: "<?php echo __('delete workflow',null,'mailinglist'); ?>",  width: 100, sortable: false, dataIndex: 'deleteworkflow', css : "text-align :left; font-size:12px;", renderer: cf.mailinglistVersionSecondTab.renderDeleteCheckbox},
			{header: "<?php echo __('archive workflow',null,'mailinglist'); ?>",  width: 120, sortable: false, dataIndex: 'archiveworkflow', css : "text-align :left; font-size:12px;", renderer: cf.mailinglistVersionSecondTab.renderArchiveCheckbox},
			{header: "<?php echo __('stop/new workflow',null,'mailinglist'); ?>",  width: 120, sortable: false, dataIndex: 'stopneworkflow', css : "text-align :left; font-size:12px;", renderer: cf.mailinglistVersionSecondTab.renderStopNewCheckbox},
			{header: "<?php echo __('show workflow details',null,'mailinglist'); ?>",  width: 130, sortable: false, dataIndex: 'detailsworkflow', css : "text-align :left; font-size:12px;", renderer: cf.mailinglistVersionSecondTab.renderShowCheckbox}
		]);	
	
	},
	
	/** grid and store for auth **/
	initAuthorizationGrid: function (id) {
		var theAuthorizationStore = new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('mailinglist/LoadAuthorization')?>/id/' + id,
				fields: [
					{name: 'type'},
					{name: 'id'},
					{name: 'raw_type'},
					{name: 'deleteworkflow'},
					{name: 'archiveworkflow'},
					{name: 'stopneworkflow'},
					{name: 'detailsworkflow'}
				]
		});
		var theAuthorizationGrid = new Ext.grid.GridPanel({
			frame:false,
			autoScroll: true,
			collapsible:false,
			closable: false,
			height: 250,
			width: 'auto',
			border: true,
			store: theAuthorizationStore,
			cm: this.theAuthorizationCM
		});
		theAuthorizationGrid.on('render', function(grid) {
			theAuthorizationGrid.store.load();
		});
		return theAuthorizationGrid;
	},
	
	
	/** init allowed sender cm **/
	initAllowedSenderCM: function () {
		this.theAllowedSenderCM = new Ext.grid.ColumnModel([
				{header: "<?php echo __('User',null,'mailinglist'); ?>", width: 260, sortable: false, dataIndex: 'name', css : "text-align : left;font-size:12px;align:center;"}
		]);
	},
	
	/**
	* init allowed sender grid
	*
	*@param int id, id of the version to load
	*
	*/
	initAllowedSenderGrid: function (id) {
		var theStore = new Ext.data.JsonStore({
			root: 'result',
			url: '<?php echo build_dynamic_javascript_url('mailinglist/LoadAllAllowedSender')?>/id/' + id,
			autoload: true,
			fields: [
				{name: 'name'}
			]
		});
		
		var allowedsendergrid = new Ext.grid.GridPanel({
			stripeRows: true,
			border: false,
			width: 290,
			height:200,
			enableDragDrop:false,
			collapsible: false,
			autoScroll: true,
			style:'margin-top:5px;margin-left:5px;margin-right:5px;',
			store: theStore,
			cm: this.theAllowedSenderCM
		});
		allowedsendergrid.on('render', function(grid) {
			allowedsendergrid.store.load();
		});
		
		return allowedsendergrid;
	
	},
	
	/** inti auth fieldset **/
	initAuthorizationFieldset: function () {
		this.theAuthorizationFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Authorization',null,'mailinglist'); ?>',
			width: 700,
			height: 300,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 120
		});
	
	},
	
	
	/** init sender fieldset **/
	initSenderFieldset: function () {
		this.theSenderFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Allowed Sender',null,'mailinglist'); ?>',
			width: 700,
			height: 225,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 120
		});
	},
	
	
	/** init first tab **/
	initFirstTab: function () {
		this.theFirstPanel = new Ext.Panel({
			title: '<?php echo __('General Settings',null,'mailinglist'); ?>',
			frame:true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 144
		});
	},
	
	/** init second tab **/
	initSecondTab: function () {
		this.theSecondPanel = new Ext.Panel({
			title: '<?php echo __('Slot settings',null,'mailinglist'); ?>',
			frame:true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 144
		});
	
	},
	/** init tabpanel **/
	initTabPanel:  function () {
		this.theTabPanel = new Ext.TabPanel({
			activeTab: 0,
			enableTabScroll:true,
			border: false,
			deferredRender:true,
			frame: true,
			layoutOnTabChange: true,
			style: 'margin-top:5px;',
			plain: false,
			closable:false
		});	
	
	},
	
	
	/**
	* init toolbar to activate mailinglist
	*
	*@param int id, id of the record to activate
	*@param int mailinglisttemplateid, id of template to active
	*
	*/
	initToolbar: function (id, mailinglisttemplateid) {
		var toolbar = new Ext.Toolbar({
			width: 'auto',
			items: [{
				xtype: 'button',
				text: '<?php echo __('Activate Mailinglist template',null,'mailinglist'); ?>',
				icon: '/images/icons/clock_go.png',
	            tooltip:'<?php echo __('Set Template to active',null,'mailinglist'); ?>',
				style: 'margin-botton:10px;',
	            handler: function () {
					Ext.Msg.show({
					   title:'<?php echo __('Activate Template',null,'mailinglist'); ?>?',
					   msg: '<?php echo __('Activate Template',null,'mailinglist'); ?>?',
					   buttons: Ext.Msg.YESNO,
					   fn: function(btn, text) {
							if(btn == 'yes') {
								cf.mailinglistCRUD.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Updating Data...',null,'mailinglist'); ?>'});					
								cf.mailinglistCRUD.theLoadingMask.show();
								Ext.Ajax.request({  
									url : '<?php echo build_dynamic_javascript_url('mailinglist/ActivateMailinglist')?>/id/' + id + '/mailinglistid/' + mailinglisttemplateid, 
									success: function(objServerResponse){
										cf.mailinglistVersionPopUp.theVersionWindow.hide();
										cf.mailinglistVersionPopUp.theVersionWindow.destroy();
										cf.mailinglistPanelGrid.theMailinglistStore.reload();
										cf.mailinglistCRUD.theLoadingMask.show();
										Ext.Msg.minWidth = 200;
										Ext.MessageBox.alert('<?php echo __('OK',null,'mailinglist'); ?>','<?php echo __('Template activated',null,'mailinglist'); ?>');
										cf.mailinglistCRUD.theLoadingMask.hide();
									}
								});
							}
					   }
					});
	            }
			}]
		});	
		return toolbar;	
	},
	
	
	/** CM for all grids in fieldset **/
	initGridCM: function () {
		this.theGridCM = new Ext.grid.ColumnModel([
			{header: "<?php echo __('Field',null,'mailinglist'); ?>", width: 230, sortable: false, dataIndex: 'title', css : "text-align : left;font-size:12px;align:left;"}
			
		]);
	},
	
	/** init grid **/
	initGrid: function () {
		var grid = new Ext.grid.GridPanel({
			stripeRows: true,
			border: true,
			enableDragDrop: false,
			autoScroll: true,
			allowContainerDrop : false,
			width: 280,
			height: 170,
			collapsible: false,
			style:'margin-top:5px;',
			store: new Ext.data.SimpleStore({
				fields: [{name: 'title'}]
			}),
			cm: this.theGridCM
		});
		return grid;
	},
	
	
	/**
	* Set fieldset
	*
	*@param string title, title of the slot and fieldset
	*
	*/
	initFieldset: function (title) {
		var fieldset = new Ext.form.FieldSet({
			title: 'Slot: ' + title,
			width: 'auto',
			height: 235,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 170
		});
		return fieldset;
		
	},
	
	/**
	* add tab to tabpanel
	*
	*@param int id, id of the record
	*@param string created_at, creation time of record
	*@param int grid_id, id of grid #
	*
	*/
	initTab: function (id, created_at, grid_id) {
		var panel = new Ext.Panel({
			id: 'panel_' + id,
			title: grid_id + ': ' + created_at,
			closable: true,
			frame: true,
			height: 'auto'
		});
		return panel;
	},
	
	/** render checkbox to grid **/
	renderDeleteCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['raw_type'];
		var databaseId = record.data['id'];
		cf.mailinglistThirdTab.createCheckbox.defer(500,this, [id, 'databaseid_'+databaseId+'mailinglistFirstTabCheckboxDelete_'+ id, 'deleteworkflow', record.data['deleteworkflow'],databaseId]);
		return '<center><table><tr><td><div id="databaseid_'+databaseId+'mailinglistFirstTabCheckboxDelete_'+ id +'"></div></td></tr></table></center>';
	},
	renderArchiveCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['raw_type'];
		var databaseId = record.data['id'];
		cf.mailinglistThirdTab.createCheckbox.defer(500,this, [id, 'databaseid_'+databaseId+'mailinglistFirstTabCheckboxArchive_'+ id, 'archiveworkflow', record.data['archiveworkflow'],databaseId]);
		return '<center><table><tr><td><div id="databaseid_'+databaseId+'mailinglistFirstTabCheckboxArchive_'+ id +'"></div></td></tr></table></center>';
	},
	renderStopNewCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['raw_type'];
		var databaseId = record.data['id'];
		cf.mailinglistThirdTab.createCheckbox.defer(500,this, [id, 'databaseid_'+databaseId+'mailinglistFirstTabCheckboxStopNew_'+ id, 'stopneworkflow', record.data['stopneworkflow'],databaseId]);
		return '<center><table><tr><td><div id="databaseid_'+databaseId+'mailinglistFirstTabCheckboxStopNew_'+ id +'"></div></td></tr></table></center>';
	},
	renderShowCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['raw_type'];
		var databaseId = record.data['id'];
		cf.mailinglistThirdTab.createCheckbox.defer(500,this, [id, 'databaseid_'+databaseId+'mailinglistFirstTabCheckboxShow_'+ id, 'detailsworkflow', record.data['detailsworkflow'],databaseId]);
		return '<center><table><tr><td><div id="databaseid_'+databaseId+'mailinglistFirstTabCheckboxShow_'+ id +'"></div></td></tr></table></center>';
	}
	
	
	
	
	
	
	
	
};}();