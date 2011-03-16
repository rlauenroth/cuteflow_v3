cf.workflowFilterFilter = function(){return {
	
	
	
	thePanel				:false,
	theGrid					:false,
	theCM					:false,
	theStore				:false,
	theId					:false,
	theLoadingMask			:false,
	
	
	init: function () {
		this.initStore();
		this.initCM();
		this.initGrid();
		this.initPanel();
		this.thePanel.add(this.theGrid);
		
	},
	
	initStore: function () {
		this.theStore = new Ext.data.JsonStore({
			root: 'result',
			url: '<?php echo build_dynamic_javascript_url('filter/LoadFilter')?>',
			autoload: false,
			fields: [
				{name: 'id'},
				{name: 'filtername'}
			]
		});	
	},
	
	initCM: function () {
		this.theCM = new Ext.grid.ColumnModel([
			{header: "<?php echo __('Filter Name',null,'workflowmanagement'); ?>", width: 160, sortable: true, dataIndex: 'filtername', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/wand.png' />&nbsp;&nbsp;</td><td><?php echo __('Load Filter',null,'workflowmanagement'); ?></td></tr><tr><td><img src='/images/icons/zoom_out.png' />&nbsp;&nbsp;</td><td><?php echo __('Delete Filter',null,'workflowmanagement'); ?></td></tr></table>\" ext:qwidth=\"80\"><?php echo __('Action',null,'workflowmanagement'); ?></div>", width: 45, sortable: true, dataIndex: 'id', css : "text-align : left;font-size:12px;align:center;", renderer: this.renderButton}		
		]);
		
	},
	
	
	renderButton: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['id'];
		var btnEdit1 = cf.workflowFilterFilter.createLoadButton.defer(10,this, [id]);
		var btnEdit2 = cf.workflowFilterFilter.createDeleteButton.defer(10,this, [id]);
		return '<center><table><tr><td width="16"><div id="workflowFilterLoad'+ id +'"></div></td><td width="16"><div id="workflowFilterDelete'+ id +'"></div></td></tr></table></center>';
	},
	
	createLoadButton: function (id, idName) {
		var btn_copy = new Ext.form.Label({
			html: '<span style="cursor:pointer;"><img src="/images/icons/wand.png" /></span>',
			renderTo: 'workflowFilterLoad'+ id,
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							cf.workflowFilterPanel.theSearchPanel.getForm().reset();
							cf.workflowFilterPanel.theFieldGrid.store.removeAll();
							cf.workflowFilterPanel.theCounter = 0;
							cf.workflowFilterFilter.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Filter',null,'workflowmanagement'); ?>...'});					
							cf.workflowFilterFilter.theLoadingMask.show();
							Ext.Ajax.request({  
								url : '<?php echo build_dynamic_javascript_url('filter/LoadSingleFilter')?>/id/' + id,
								success: function(objServerResponse){
									
									var filterData = Ext.util.JSON.decode(objServerResponse.responseText);
									var data = filterData.result;
									
									if(data.name != '') {
										cf.workflowFilterPanel.theName.setValue(data.name);
									}
									if (data.sender_id != 0 && data.sender_id != '' && data.sender_id != -1) {
										cf.workflowFilterPanel.theSenderCombo.setValue(data.sender_id);
									}
									if (data.daysfrom != '') {
										Ext.getCmp('workflowfilter_daysfrom').setValue(data.daysfrom);
									}
									if (data.daysto != '') {
										Ext.getCmp('workflowfilter_daysto').setValue(data.daysto);
									}
									
									if(data.sendetfrom != '') {
										Ext.getCmp('workflowfilter_sendetfrom').setValue(data.sendetfrom);
									}
									if (data.sendetto != '') {
										Ext.getCmp('workflowfilter_sendetto').setValue(data.sendetto);
									}
									
									if(data.workflowprocessuser_id != 0 && data.workflowprocessuser_id != '' & data.workflowprocessuser_id != -1) {
										cf.workflowFilterPanel.theCurrentStation.setValue(data.workflowprocessuser_id);
									}
									
									if(data.documenttemplateversion_id != 0 && data.documenttemplateversion_id != '' && data.documenttemplateversion_id != -1) {
										cf.workflowFilterPanel.theDocumenttemplateCombo.setValue(data.documenttemplateversion_id);
									}
									
									if(data.mailinglistversion_id != 0 && data.mailinglistversion_id != '' && data.mailinglistversion_id != -1) {
										cf.workflowFilterPanel.theMailinglistCombo.setValue(data.mailinglistversion_id);
									}
									
									try{
										var fields = data.fields;
										for(var a=0;a<fields.length;a++) {
											var item = fields[a];
											var counter = cf.workflowFilterPanel.theCounter;
											var Rec = Ext.data.Record.create({name: 'field'},{name: 'operator'},{name: 'value'},{name: 'unique_id'});
											cf.workflowFilterPanel.theFieldGrid.store.add(new Rec({field: counter, operator: 'OPERATOR_' + counter, value: 'VALUE_' + counter, unique_id: counter}));
											cf.workflowFilterFilter.addValues.defer(700,this,[a, item.field_id, item.operator, item.value]);
										}
										
										
									}
									catch(e) {
										
									}
									cf.workflowFilterFilter.theLoadingMask.hide();
									
								}
							});
						},
					scope: c
					});
				}
			}
		});
	},
	
	addValues: function (id, field_id, operator, value) {
		Ext.getCmp('workflowFilterField_' + id).setValue(field_id);
		Ext.getCmp('workflowFilterOperator_' + id).setValue(operator);
		Ext.getCmp('workflowFilterValue_' + id).setValue(value);
	},
	createDeleteButton: function (id, idName) {
		var btn_copy = new Ext.form.Label({
			html: '<span style="cursor:pointer;"><img src="/images/icons/zoom_out.png" /></span>',
			renderTo: 'workflowFilterDelete'+ id,
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							Ext.Msg.show({
							   title:'<?php echo __('Delete Filter',null,'workflowmanagement'); ?>?',
							   msg: '<?php echo __('Delete Filter',null,'workflowmanagement'); ?>?',
							   buttons: Ext.Msg.YESNO,
							   fn: function(btn, text) {
									if(btn == 'yes') {
										cf.workflowFilterCRUD.deleteFilter(id);
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
	
	initGrid: function () {
		this.theGrid = new Ext.grid.GridPanel({
			title: '<?php echo __('Available Filters',null,'workflowmanagement'); ?>',
			stripeRows: true,
			border: true,
			width: 220,
			autoScroll: true,
			height: 449,
			collapsible: true,
			collapsed: false,
			style:'margin-top:1px;margin-left:20px;',
			store: this.theStore,
			cm: this.theCM
		});
		this.theGrid.on('afterrender', function(grid) {
			grid.store.load();
		});	
	},
	
	initPanel: function () {
		this.thePanel = new Ext.Panel({
			closable: false,
			plain: false,
			frame: false,
			border: false,
			layout: 'form',
			width: 240,
			autoScroll:true,
			height: 500,
			style:'margin-top:5px;margin-left:5px;',
			collapsible:true,
			collapsed: false
		});
		
		
	}
	
	
	
	
};}();