cf.authorizationTab = function(){return {
	
	
	theAuthorizationFieldset			:false,
	theAuthorizationTab				:false,
	theAuthorizationCM				:false,
	theAuthorizationStore				:false,
	theAuthorizationGrid				:false,
	theHiddenPanel					:false,
	
	
	init: function () {
		this.initHiddenPanel();
		this.initCM();
		this.initStore();
		this.initGrid();
		this.initAuthorizationTab();
		this.initFieldset();
		this.theAuthorizationFieldset.add(this.theAuthorizationGrid);
		this.theAuthorizationFieldset.add(this.theHiddenPanel);
		this.theAuthorizationTab.add(this.theAuthorizationFieldset);
	},
	
	initHiddenPanel: function () {
		this.theHiddenPanel = new Ext.form.Hidden({
			name: 'authorizationTab_hiddenpanel'
		});
	},
	
	initGrid: function () {
		this.theAuthorizationGrid = new Ext.grid.GridPanel({
			frame:false,
			autoScroll: true,
			collapsible:false,
			closable: false,
			height: 470,
			width: 'auto',
			border: true,
			store: this.theAuthorizationStore,
			cm: this.theAuthorizationCM
		});
	
	},
	
	initCM: function () {
		this.theAuthorizationCM  =  new Ext.grid.ColumnModel([
			{header: "<?php echo __('Action',null,'systemsetting'); ?>",  width: 200, sortable: false, dataIndex: 'type', css : "text-align :left; font-size:12px;"},
			{header: "<?php echo __('delete workflow',null,'systemsetting'); ?>",  width: 100, sortable: false, dataIndex: 'delete_workflow', css : "text-align :left; font-size:12px;", renderer: cf.authorizationTab.renderDeleteCheckbox},
			{header: "<?php echo __('archive workflow',null,'systemsetting'); ?>",  width: 120, sortable: false, dataIndex: 'archive_workflow', css : "text-align :left; font-size:12px;", renderer: cf.authorizationTab.renderArchiveCheckbox},
			{header: "<?php echo __('stop/new workflow',null,'systemsetting'); ?>",  width: 120, sortable: false, dataIndex: 'stop_new_workflow', css : "text-align :left; font-size:12px;", renderer: cf.authorizationTab.renderStopNewCheckbox},
			{header: "<?php echo __('show workflow details',null,'systemsetting'); ?>",  width: 130, sortable: false, dataIndex: 'details_workflow', css : "text-align :left; font-size:12px;", renderer: cf.authorizationTab.renderShowCheckbox}
		]);	
	},
	
	initStore: function () {
		this.theAuthorizationStore = new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('systemsetting/LoadAuthorization')?>',
				fields: [
					{name: 'type'},
					{name: 'id'},
					{name: 'delete_workflow'},
					{name: 'archive_workflow'},
					{name: 'stop_new_workflow'},
					{name: 'details_workflow'}
				]
		});
		cf.authorizationTab.theAuthorizationStore.load();

	
	},
	
	initAuthorizationTab: function () {
		this.theAuthorizationTab = new Ext.Panel({
			modal: true,
			closable: false,
			modal: true,
			width: 800,
			height: 600,
			autoScroll: false,
			title: '<?php echo __('Authorization Settings',null,'systemsetting'); ?>',
			shadow: false,
			minimizable: false,
			draggable: false,
			resizable: false,
	        plain: false
		});
	},
	
	initFieldset: function () {
		this.theAuthorizationFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Authorization Settings',null,'systemsetting'); ?>',
			width: 750,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330
		});
	},
	
		/** render checkbox to grid **/
	renderDeleteCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['id'];
		cf.authorizationTab.createCheckbox.defer(500,this, [id, 'authorizationCheckboxDelete_'+ id, 'delete_workflow', record.data['delete_workflow']]);
		return '<center><table><tr><td><div id="authorizationCheckboxDelete_'+ id +'"></div></td></tr></table></center>';
	},
	renderArchiveCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['id'];
		cf.authorizationTab.createCheckbox.defer(500,this, [id, 'authorizationCheckboxArchive_'+ id, 'archive_workflow', record.data['archive_workflow']]);
		return '<center><table><tr><td><div id="authorizationCheckboxArchive_'+ id +'"></div></td></tr></table></center>';
	},
	renderStopNewCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['id'];
		cf.authorizationTab.createCheckbox.defer(500,this, [id, 'authorizationCheckboxStopNew_'+ id, 'stop_new_workflow', record.data['stop_new_workflow']]);
		return '<center><table><tr><td><div id="authorizationCheckboxStopNew_'+ id +'"></div></td></tr></table></center>';
	},
	renderShowCheckbox: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['id'];
		cf.authorizationTab.createCheckbox.defer(500,this, [id, 'authorizationCheckboxShow_'+ id, 'details_workflow', record.data['details_workflow']]);
		return '<center><table><tr><td><div id="authorizationCheckboxShow_'+ id +'"></div></td></tr></table></center>';
	},
	
	/** create checkbox **/
	createCheckbox: function (id, div, table, value) {
		
		value = value == 0 ? false : true;
		
		var name = id + '__' + table;
		var check = new Ext.form.Checkbox({
			renderTo: div,
			name: 'authorizationTab[' + name + ']',
			inputValue: 1,
			checked: value
		});
	}

	
};}();