cf.archiveFilterPanel = function(){return {
	
	theUrl 						:false,
	theSearchPanel				:false,
	theMailinglistCombo			:false,
	theDocumenttemplateCombo	:false,
	theName						:false,
	theSenderCombo				:false,
	theCurrentStation			:false,		
	sendetAt					:false,
	theToolBar					:false,
	theFieldGrid				:false,
	theFieldData				:false,
	theCounter					:false,
	theSaveButton				:false,
	theHiddenFilterName			:false,
	theColumnPanel				:false,
	theId						:false,
	
	init: function () {
		this.initHiddenFilterName();
		cf.archiveFilterFilter.init();
		this.theCounter = 0;
		this.initColumnPanel();
		this.initMailinglistCombo();
		
		this.initDocumenttemplateCombo();
		this.initSenderCombo();
		this.initName();
		this.initCurrentStationCombo();
		this.initDaysInProgress();
		this.initSendetAt();
		this.initPanel();
		this.initCM();
		this.initTopToolBar();
		this.initFieldGrid();
		this.initSaveButton();
		this.theSearchPanel.add(this.theName);
		this.theSearchPanel.add(this.theSenderCombo);
		this.theSearchPanel.add(this.daysInProgress);
		this.theSearchPanel.add(this.sendetAt);
		this.theSearchPanel.add(this.theCurrentStation);
		this.theSearchPanel.add(this.theMailinglistCombo);
		this.theSearchPanel.add(this.theDocumenttemplateCombo);
		this.theSearchPanel.add(this.theFieldGrid);
		this.theSearchPanel.add(this.theSaveButton);
		this.theSearchPanel.add(this.theHiddenFilterName);
		Ext.getCmp('archiveColumnPanel').add(this.theSearchPanel);
		Ext.getCmp('archiveColumnPanel').add(cf.archiveFilterFilter.thePanel);
		
	},
	
	initColumnPanel: function () {
		this.theColumnPanel = new Ext.Panel({
		    layout: 'column',
		    plain: false,
		    width: 'auto',
		    style:'margin-top:5px;margin-left:5px;margin-right:5px;',
		    height: 480,
		    id: 'archiveColumnPanel',
			collapsible:true,
			collapsed: true,
		    title: '<?php echo __('Searchbar',null,'workflowmanagement'); ?>',
			border: true,
			layoutConfig: {
				columns: 2,
				fitHeight: true,
				split: true
			}
		});
		this.theColumnPanel.on('beforeexpand', function(panel) {
			cf.archiveFilterPanel.theMailinglistCombo.store.load();
			cf.archiveFilterPanel.theDocumenttemplateCombo.store.load();
			cf.archiveFilterPanel.theSenderCombo.store.load();
			cf.archiveFilterPanel.theCurrentStation.store.load();
		});
		
		
	},
	
	initHiddenFilterName: function () {
		this.theHiddenFilterName =  new Ext.form.Hidden({
			name: 'filter_hiddenname',
			allowBlank: true,
			value: '',
			width: 5
		});
	},
	
	initPanel: function () {
		this.theSearchPanel = new Ext.FormPanel({
			closable: false,
			plain: false,
			frame: false,
			border: true,
			labelWidth:170,
			layout: 'form',
			autoScroll:true,
			height: 450,
			style:'margin-top:5px;margin-left:5px;',
			collapsible:true,
			collapsed: false
		});
	},
	
	initSaveButton: function () {
		this.theSaveButton = new Ext.form.FieldSet({
			autoHeight: true,
	        border: false,
	        style:'margin-left:50px;',
	        defaultType: 'textfield',
	        layout: 'column',
	        items:[{
				xtype: 'button',
				icon: '/images/icons/zoom.png',
				text: '<?php echo __('Search',null,'workflowmanagement'); ?>',
				width: 70,
				height:25,
				style:'margin-bottom:5px;margin-left:35px;',
				handler: function (){
					var url = cf.createFilterUrl.buildUrl(cf.archiveFilterPanel.theName, cf.archiveFilterPanel.theSenderCombo, Ext.getCmp('archivefilter_daysfrom'), Ext.getCmp('archivefilter_daysto'), Ext.getCmp('archivefilter_sendetfrom'),Ext.getCmp('archivefilter_sendetto'), cf.archiveFilterPanel.theCurrentStation, cf.archiveFilterPanel.theMailinglistCombo, cf.archiveFilterPanel.theDocumenttemplateCombo, cf.archiveFilterPanel.theFieldGrid, 'archive');                                         
					if(url != '') {
						var loadUrl = encodeURI('<?php echo build_dynamic_javascript_url('archiveoverview/LoadAllArchivedWorkflowByFilter')?>' + url);
						cf.archiveWorkflow.theArchiveStore.proxy.setApi(Ext.data.Api.actions.read,loadUrl);
						cf.archiveWorkflow.theArchiveStore.load();
					}	
					cf.archiveFilterPanel.theColumnPanel.expand(false);
					cf.archiveFilterPanel.theColumnPanel.collapse(true);
				}
			},{
				xtype: 'button',
				icon: '/images/icons/disk.png',
				text: '<?php echo __('Save filter',null,'workflowmanagement'); ?>',
				width: 100,
				height:25,
				style:'margin-bottom:5px;margin-left:35px;',
				handler: function (){
					cf.archiveFilterCRUD.saveFilter();
				}
			},{
				xtype: 'button',
				icon: '/images/icons/delete.png',
				text: '<?php echo __('Reset',null,'workflowmanagement'); ?>',
				width: 100,
				height:25,
				type: 'reset',
				style:'margin-bottom:5px;margin-left:25px;',
				handler: function () {
					cf.archiveFilterPanel.theCounter = 0;
					cf.archiveFilterPanel.theSearchPanel.getForm().reset();
					cf.archiveFilterPanel.theFieldGrid.store.removeAll();
					var loadUrl = '<?php echo build_dynamic_javascript_url('archiveoverview/LoadAllArchivedWorkflow')?>';
					cf.archiveWorkflow.theArchiveStore.proxy.setApi(Ext.data.Api.actions.read,loadUrl);
					cf.archiveWorkflow.theArchiveStore.load();
				}
			}]
		});
		
	},
	
	addSearchItem: function () {
		var counter = cf.archiveFilterPanel.theCounter;
		var Rec = Ext.data.Record.create({name: 'field'},{name: 'operator'},{name: 'value'},{name: 'unique_id'});
		cf.archiveFilterPanel.theFieldGrid.store.add(new Rec({field: counter, operator: 'OPERATOR_' + counter, value: 'VALUE_' + counter, unique_id: counter}));
	},
	
	initTopToolBar: function () {
		this.theToolBar = new Ext.Toolbar({
			items:[{
				icon: '/images/icons/zoom_in.png',
		        tooltip:'<?php echo __('Add new Search item',null,'workflowmanagement'); ?>',
		        handler: function () {
		        	cf.archiveFilterPanel.addSearchItem();
		        }
	        }]
		});
		
	},
	
	addFieldCombo: function (id) {
		var combo = new Ext.form.ComboBox({
			valueField: 'id',
			displayField: 'title',
			id: 'archiveFilterField_' + id,
			editable: false,
			hiddenName: 'field['+id+']',
			mode: 'local',
			store: new Ext.data.SimpleStore({
				fields: [
					{name: 'id'},
					{name: 'title'}
				]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: true,
			width:150,
			forceSelection:true
		});	
		for(var a=0;a<cf.archiveFilterPanel.theFieldData.result.length;a++) {
			var item = cf.archiveFilterPanel.theFieldData.result[a];
			var Rec = Ext.data.Record.create({name: 'id'},{name: 'title'});
			combo.store.add(new Rec({id: item.id, title: item.title}));
		}
		combo.render('ARCHIVEFIELD_' + id);
	},
	
	renderCombo: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var counter = cf.archiveFilterPanel.theCounter;
		cf.archiveFilterPanel.addFieldCombo.defer(100,this,[counter]);
		return '<div id="ARCHIVEFIELD_'+ counter +'"></div>';
	},
	
	renderOperator: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var counter = cf.archiveFilterPanel.theCounter;
		cf.archiveFilterPanel.addOperatorCombo.defer(100,this,[counter]);
		return '<div id="ARCHIVEOPERATOR_'+ counter +'"></div>';
	},
	
	renderTextfeld: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var counter = cf.archiveFilterPanel.theCounter;
		cf.archiveFilterPanel.addValueTextfield.defer(100,this,[counter]);
		return '<div id="ARCHIVEVALUE_'+ counter +'"></div>';
	},
	
	renderAction: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var counter = cf.archiveFilterPanel.theCounter++;
		cf.archiveFilterPanel.addDeleteButton.defer(100,this,[counter]);
		return '<div id="ARCHIVEACTION_'+ counter +'"></div>';
	},
	
	
	addValueTextfield: function (id) {
		var textfield = new Ext.form.TextField({
			allowBlank: true,
			id: 'archiveFilterValue_' + id,
			name: 'value['+id+']',
			width: 110
		});
		textfield.render('ARCHIVEVALUE_' + id);
	},
	
	addDeleteButton: function (id) {
		var btn_copy = new Ext.form.Label({
			renderTo: 'ARCHIVEACTION_' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/delete.png" /></span>',
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							var item = cf.archiveFilterPanel.theFieldGrid.store.findExact('unique_id', id);
							cf.archiveFilterPanel.theFieldGrid.store.remove(item);
						},
					scope: c
					});
				}
			}
		});
	},
	
	addOperatorCombo: function (id) {
		var combo = new Ext.form.ComboBox({
			valueField: 'id',
			displayField: 'title',
			editable: false,
			id: 'archiveFilterOperator_' + id,
			hiddenName: 'operator['+id+']',
			mode: 'local',
			store: new Ext.data.SimpleStore({
				fields: [{name: 'id'},{name: 'title'}],
				data:[['=', '='],['<','<'],['>', '>'],['<=', '<='],['>=', '>='],['~', '<?php echo __('~ (like)',null,'workflowmanagement'); ?>']]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: true,
			width:120,
			forceSelection:true
		});	
		combo.render('ARCHIVEOPERATOR_' + id);
	},
	
	initCM: function () {
		this.theGridCM = new Ext.grid.ColumnModel([
			{header: "<?php echo __('Field',null,'workflowmanagement'); ?>", width: 160, sortable: true, dataIndex: 'field', css : "text-align : left;font-size:12px;align:center;", renderer: this.renderCombo},
			{header: "<?php echo __('Operator',null,'workflowmanagement'); ?>", width: 130, sortable: true, dataIndex: 'operator', css : "text-align : left;font-size:12px;align:center;", renderer: this.renderOperator},
			{header: "<?php echo __('Value',null,'workflowmanagement'); ?>", width: 130, sortable: true, dataIndex: 'value', css : "text-align : left;font-size:12px;align:center;", renderer:this.renderTextfeld},
			{header: "<?php echo __('Action',null,'workflowmanagement'); ?>", width: 45, sortable: true, dataIndex: 'unique_id', css : "text-align : left;font-size:12px;align:center;", renderer:this.renderAction}		
		]);
		
	},
	
	
	
	initFieldGrid: function () {
		this.theFieldGrid = new Ext.grid.GridPanel({
			title: '<?php echo __('Fields',null,'workflowmanagement'); ?>',
			stripeRows: true,
			border: true,
			width: 500,
			autoScroll: true,
			tbar: this.theToolBar,
			height: 200,
			collapsible: false,
			style:'margin-top:5px;margin-right:5px;',
			store: new Ext.data.SimpleStore({
				 fields:['field','operator','value','unique_id']
			}),
			cm: this.theGridCM
		});
		this.theFieldGrid.on('afterrender', function(grid) {
			Ext.Ajax.request({  
				url : '<?php echo build_dynamic_javascript_url('filter/LoadFields')?>',
				success: function(objServerResponse){
					cf.archiveFilterPanel.theFieldData = Ext.util.JSON.decode(objServerResponse.responseText);
				}
			});
		});	
	},
	
	initDaysInProgress: function () {
		this.daysInProgress = new Ext.Panel({
			fieldLabel: '<?php echo __('Days from',null,'workflowmanagement'); ?>...<?php echo __('to',null,'workflowmanagement'); ?>',
			border: false,
			layout: 'column',
			layoutConfig: {
				columns: 2
			},
			items:[{
				xtype: 'textfield',
				style: 'margin-right:5px;',
				id: 'archivefilter_daysfrom',
				name: 'filter_daysinprogress_from',
				allowBlank: true,
				width: 116
			},{
				xtype: 'textfield',
				allowBlank: true,
				id: 'archivefilter_daysto',
				name: 'filter_daysinprogress_to',
				style: 'margin-right:5px;',
				width: 116
			}]
		});	
		
	},
	
	initSendetAt: function () {
		this.sendetAt = new Ext.Panel({
			fieldLabel: '<?php echo __('Sendet from',null,'workflowmanagement'); ?>...<?php echo __('to',null,'workflowmanagement'); ?>',
			border: false,
			layout: 'column',
			layoutConfig: {
				columns: 2
			},
			items:[{
                xtype:'datefield',
                name: 'filter_sendet_from',
                format: 'Y-m-d',
                id: 'archivefilter_sendetfrom',
            	allowBlank:true,
                width: 111

			},{
				xtype: 'panel',
				html : '&nbsp;',
				border: false,
			},{
                xtype:'datefield',
                name: 'filter_sendet_to',
                id: 'archivefilter_sendetto',
                format: 'Y-m-d',
            	allowBlank:true,
                width: 110
			}]
		});	
		
	},
	
	initName: function () {
		this.theName = new Ext.form.TextField({
			fieldLabel: '<?php echo __('Name',null,'workflowmanagement'); ?>',
			allowBlank: true,
			style: 'margin-top:2px;',
			name: 'filter_name',
			width: 225
		});
	},
	
	initMailinglistCombo: function () {
		this.theMailinglistCombo = 	new Ext.form.ComboBox({
			fieldLabel: '<?php echo __('Mailing list',null,'workflowmanagement'); ?>',
			valueField: 'id',
			displayField: 'name',
			hiddenName:'filter_mailinglist',
			editable: false,
			mode: 'local',
			store: new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('filter/LoadMailinglist')?>',
				autoload: true,
				fields: [
					{name: 'id'},
					{name: 'name'}
				]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: true,
			forceSelection:true,
			labelWidth:300,
			width: 225
		});
		
	},
	
	
	initDocumenttemplateCombo: function (){
		this.theDocumenttemplateCombo = new Ext.form.ComboBox({
			fieldLabel: '<?php echo __('Documenttemplate',null,'workflowmanagement'); ?>',
			valueField: 'id',
			displayField: 'name',
			editable: false,
			hiddenName: 'filter_documenttemplate',
			mode: 'local',
			store: new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('filter/LoadDocumenttemplate')?>',
				autoload: true,
				fields: [
					{name: 'id'},
					{name: 'name'}
				]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: true,
			forceSelection:true,
			width: 225
		});
		
	},
	
	
	initSenderCombo: function () {
		this.theSenderCombo = new Ext.form.ComboBox({
			fieldLabel: '<?php echo __('Sender',null,'workflowmanagement'); ?>',
			valueField: 'id',
			displayField: 'name',			
			hiddenName:'filter_sender',
			editable: false,
			mode: 'local',
			store: new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('filter/LoadSender')?>',
				autoload: true,
				fields: [
					{name: 'id'},
					{name: 'name'}
				]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: true,
			forceSelection:true,
			labelWidth:300,
			width: 225
		});
		
		
	},
	
	initCurrentStationCombo: function () {
		this.theCurrentStation = new Ext.form.ComboBox({
			fieldLabel: '<?php echo __('Active Station',null,'workflowmanagement'); ?>',
			valueField: 'id',
			displayField: 'name',
			editable: false,
			hiddenName: 'filter_currentstation',
			mode: 'local',
			store: new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('filter/LoadStation')?>',
				autoload: true,
				fields: [
					{name: 'id'},
					{name: 'name'}
				]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: true,
			forceSelection:true,
			labelWidth:300,
			width: 225
		});
		
		
		
	}
	
	
	
	
	
	
	
	
	
};}();