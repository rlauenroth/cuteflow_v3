cf.mailinglistThirdTab = function(){return {
	
	
	
	
	thePanel 					:false,
	theAuthorizationFieldset	:false,
	theAuthorizationStore		:false,
	theAuthorizationCM			:false,
	theAuthorizationGrid		:false,
	
	
	init:function (storeurl,id) {
		this.initPanel();
		this.initAuthCM();
		this.initAuthStore(storeurl);
		this.initAuthGrid();
		this.initAuthorizationFieldset();
		
		this.theAuthorizationFieldset.add(this.theAuthorizationGrid);
		this.thePanel.add(this.theAuthorizationFieldset);
		
	},
	
	
	/** init first tab formpanel **/
	initPanel: function () {
		this.thePanel = new Ext.FormPanel({
			title: '<?php echo __('Authorization settings',null,'mailinglist'); ?>',
			frame:true,
			autoScroll: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 148
		});
	},
	
		/** init auth fieldset **/
	initAuthorizationFieldset: function () {
		this.theAuthorizationFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Authorization',null,'mailinglist'); ?>',
			width: 700,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 120
		});
	
	},
	
	
	
	/**
	* init auth store, url is different in edit and new mode
	*
	*@param string url, url to load
	*/
	initAuthStore: function (url) {
		this.theAuthorizationStore = new Ext.data.JsonStore({
				root: 'result',
				url: url,
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
		
	},
	
	
		/** init cm for auth grid **/
	initAuthCM: function () {
		this.theAuthorizationCM  =  new Ext.grid.ColumnModel([
			{header: "<?php echo __('Action',null,'mailinglist'); ?>",  width: 200, sortable: false, dataIndex: 'type', css : "text-align :left; font-size:12px;"},
			{header: "<?php echo __('delete workflow',null,'mailinglist'); ?>",  width: 100, sortable: false, dataIndex: 'deleteworkflow', css : "text-align :left; font-size:12px;", renderer: cf.mailinglistThirdTab.renderDeleteCheckbox},
			{header: "<?php echo __('archive workflow',null,'mailinglist'); ?>",  width: 120, sortable: false, dataIndex: 'archiveworkflow', css : "text-align :left; font-size:12px;", renderer: cf.mailinglistThirdTab.renderArchiveCheckbox},
			{header: "<?php echo __('stop/new workflow',null,'mailinglist'); ?>",  width: 120, sortable: false, dataIndex: 'stopneworkflow', css : "text-align :left; font-size:12px;", renderer: cf.mailinglistThirdTab.renderStopNewCheckbox},
			{header: "<?php echo __('show workflow details',null,'mailinglist'); ?>",  width: 130, sortable: false, dataIndex: 'detailsworkflow', css : "text-align :left; font-size:12px;", renderer: cf.mailinglistThirdTab.renderShowCheckbox}
		]);	
	},
	
		
	/** init auth grid **/
	initAuthGrid: function () {
		this.theAuthorizationGrid = new Ext.grid.GridPanel({
			frame:false,
			autoScroll: true,
			collapsible:false,
			closable: false,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 230,
			width: 'auto',
			border: true,
			store: this.theAuthorizationStore,
			cm: this.theAuthorizationCM
		});
		this.theAuthorizationGrid.on('afterrender', function(grid) {
			cf.mailinglistThirdTab.theAuthorizationStore.load();
		});
	
	},
	
	
		
	/** render checkbox to grid **/
	renderDeleteCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['raw_type'];
		cf.mailinglistThirdTab.createCheckbox.defer(1500,this, [id, 'mailinglistFirstTabCheckboxDelete_'+ id, 'deleteworkflow', record.data['deleteworkflow']]);
		return '<center><table><tr><td><div id="mailinglistFirstTabCheckboxDelete_'+ id +'"></div></td></tr></table></center>';
	},
	renderArchiveCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['raw_type'];
		cf.mailinglistThirdTab.createCheckbox.defer(1500,this, [id, 'mailinglistFirstTabCheckboxArchive_'+ id, 'archiveworkflow', record.data['archiveworkflow']]);
		return '<center><table><tr><td><div id="mailinglistFirstTabCheckboxArchive_'+ id +'"></div></td></tr></table></center>';
	},
	renderStopNewCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['raw_type'];
		cf.mailinglistThirdTab.createCheckbox.defer(1500,this, [id, 'mailinglistFirstTabCheckboxStopNew_'+ id, 'stopneworkflow', record.data['stopneworkflow']]);
		return '<center><table><tr><td><div id="mailinglistFirstTabCheckboxStopNew_'+ id +'"></div></td></tr></table></center>';
	},
	renderShowCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['raw_type'];
		cf.mailinglistThirdTab.createCheckbox.defer(1500,this, [id, 'mailinglistFirstTabCheckboxShow_'+ id, 'detailsworkflow', record.data['detailsworkflow']]);
		return '<center><table><tr><td><div id="mailinglistFirstTabCheckboxShow_'+ id +'"></div></td></tr></table></center>';
	},
	
	/** create checkbox, toactivate a item **/
	createCheckbox: function (id, div, table, value) {
		value = value == 0 ? false : true;
		var name = id + '__' + table;
		var check = new Ext.form.Checkbox({
			renderTo: div,
			id: id + '_mailinglistthirdtab_' + table,
			name: 'mailinglistFirstTab[' + name + ']',
			inputValue: "1",
			checked: value
		});
	}
	
	
};}();