cf.createWorkflowFirstTab = function(){return {
	
	theFirstTabPanel				:false,
	theNameTextfield				:false,
	theDatepicker					:false,
	theMailinglist					:false,
	theAdditionaltextCombo			:false,
	thePanel						:false,
	theColumnPanel					:false,
	theTextarea						:false,
	theHtmlarea						:false,
	thePlaceholderGrid				:false,
	theContenttypeCombo				:false,
	theFileUploadGrid				:false,
	theUniqueFileId					:false,
	theUniqueFileStoreId			:false,
	theLoadingMask					:false,
	theDatefieldCheckbox			:false,
	theTimePicker					:false,
	
	
	
	
	init: function () {
		this.theUniqueFileStoreId = 1;
		this.theUniqueFileId = 0;
		this.initPanel();
		var fieldset1 = this.createFieldset('createWorkflowFirstTab_fieldset1', '<?php echo __('Set name, mailinglist, attachments and start date',null,'workflowmanagement'); ?>', false, 350, true);
		this.initNameTextfield();
		this.initMailinglist();
		this.initTimePicker();
		this.initDatepicker();
		this.initFileGrid();
		this.initDatefieldCheckbox();
		fieldset1.add(this.theNameTextfield);
		fieldset1.add(this.theMailinglist);
		fieldset1.add(this.theDatefieldCheckbox);
		fieldset1.add(this.theDatepicker);
		fieldset1.add(this.theTimePicker);
		fieldset1.add(this.theFileUploadGrid);
		
		
			
		var fieldset2 = this.createFieldset('createWorkflowFirstTab_fieldset2', '<?php echo __('Select Additional text',null,'workflowmanagement'); ?>', false, 350, true);
		this.initAdditionaltextcombo();
		this.initContenttypecombo();
		this.initColumnPanel();
		this.initSinglePanel();
		this.initPlaceHolder();
		this.initTextarea();
		this.initHTMLarea();
		this.thePanel.add(this.theTextarea);
		this.thePanel.add(this.theHtmlarea);
		
		this.theColumnPanel.add(this.thePanel);
		this.theColumnPanel.add(this.thePlaceholderGrid);
		fieldset2.add(this.theAdditionaltextCombo);
		fieldset2.add(this.theContenttypeCombo);
		fieldset2.add(this.theColumnPanel);
		
		var fieldset3 = this.createFieldset('createWorkflowFirstTab_fieldset3', '<?php echo __('Additional Settings',null,'workflowmanagement'); ?>', false, 200, true);
		var cb1 = this.createLabel();
		var cb2 = this.createCheckbox('createWorkflowFirstTabSettings[0]','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('After succeeded circulation',null,'workflowmanagement'); ?>',true,'', 1);
		var cb3 = this.createCheckbox('createWorkflowFirstTabSettings[1]','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('After succeeded slot end',null,'workflowmanagement'); ?>',false,'', 2);
		var cb4 = this.createCheckbox('createWorkflowFirstTabSettings[2]','<?php echo __('Archive after succeeded circulation',null,'workflowmanagement'); ?>',true,'', 4);
		var cb5 = this.createCheckbox('createWorkflowFirstTabSettings[3]','<?php echo __('Delete after succeeded circulation',null,'workflowmanagement'); ?>',false,'', 8);
		var cb6 = this.createCheckbox('createWorkflowFirstTabSettings[4]','<?php echo __('Show receiver name in workflow',null,'workflowmanagement'); ?>',false,'', 16);
		fieldset3.add([cb1,cb2,cb3,cb4,cb5,cb6]);
		this.theFirstTabPanel.add(fieldset1);
		this.theFirstTabPanel.add(fieldset2);
		this.theFirstTabPanel.add(fieldset3);
	},
	


	createLabel: function () {
		var label = new Ext.form.Label({
			html: '<span style="font-size:12px;font-family:Tahoma, Geneva, sans-serif;"><?php echo __('Sending notification',null,'workflowmanagement'); ?>:</span>'
		});	
		return label;
	},
	
	initDatefieldCheckbox: function () {
		this.theDatefieldCheckbox = new Ext.form.Checkbox({
			fieldLabel: '<?php echo __('Start workflow immediately',null,'workflowmanagement'); ?>',
			inputValue: '1',
			style: 'margin-top:3px;',
			checked: true,
			id: 'createWorkflowFirstTab_startworkflowcheckbox',
			handler: function (checkbox) {
				if(checkbox.getValue() == 1) {
					cf.createWorkflowFirstTab.theDatepicker.setVisible(false);
					cf.createWorkflowFirstTab.theDatepicker.setValue();
					cf.createWorkflowFirstTab.theTimePicker.setVisible(false);
					cf.createWorkflowFirstTab.theTimePicker.setValue();
				}
				else {
					cf.createWorkflowFirstTab.theDatepicker.setVisible(true);
					cf.createWorkflowFirstTab.theDatepicker.setValue();
					cf.createWorkflowFirstTab.theTimePicker.setVisible(true);
					cf.createWorkflowFirstTab.theTimePicker.setValue();					
				}
			}	
		});
	},
	
	initContenttypecombo: function () {
		this.theContenttypeCombo = new Ext.form.ComboBox({
			fieldLabel: '<?php echo __('Content Type',null,'workflowmanagement'); ?>',
			width: 170,
			editable:false,
			triggerAction: 'all',
			foreSelection: true,
			hidden: true,
			id: 'createWorkflowFirstTab_contenttype_id',
			hiddenName: 'createWorkflowFirstTab_contenttype',
			mode: 'local',
			value: 'html',
			store: new Ext.data.SimpleStore({
				 fields:['id','text'],
   				 data:[['plain', '<?php echo __('Plain',null,'workflowmanagement'); ?>'],['html', '<?php echo __('HTML',null,'workflowmanagement'); ?>']]
			}),
			valueField:'id',
			displayField:'text',
			width:100,
			listeners: {
	    		select: {
	    			fn:function(combo, value) {
	    				if(combo.getValue() == 'plain') {
							cf.createWorkflowFirstTab.theTextarea.setVisible(true);
							cf.createWorkflowFirstTab.theTextarea.setSize({width: (cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth()) / 2});
							cf.createWorkflowFirstTab.theHtmlarea.setVisible(false);
	    				}
	    				else {
							cf.createWorkflowFirstTab.theTextarea.setVisible(false);
							cf.createWorkflowFirstTab.theHtmlarea.setSize({width: (cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth()) / 2});
							cf.createWorkflowFirstTab.theHtmlarea.setVisible(true);
	    				}
	    			}
	    		}
	    	} 
		});
	},
	
	createCheckbox: function (id, label, checked, style, inputValue) {
		var checkbox = new Ext.form.Checkbox({
			fieldLabel: label,
			inputValue: inputValue,
			style: style,
			checked: checked,
			name: id		
		});	
		return checkbox;
	},
	
	initPlaceHolder: function () {	
		var cm = new Ext.grid.ColumnModel([
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/control_rewind_blue.png' /></td><td><?php echo __('Insert Placeholder',null,'additionaltext'); ?></td></tr></table>\" ext:qwidth=\"200\"><?php echo __('Action',null,'usermanagementpopup'); ?></div>", width: 50, sortable: true, dataIndex: 'id', css : "text-align : left;font-size:12px;align:center;", renderer: this.renderButton},
			{header: "<?php echo __('Spaceholder',null,'additionaltext'); ?>", width: 180, sortable: false, dataIndex: 'text', css : "text-align : left;font-size:12px;align:center;"}
		]);
		
		this.thePlaceholderGrid = new Ext.grid.GridPanel({ 
			frame:true,
			autoScroll: true,
			collapsible:false,
			closable: false,
			width: 250,
			height: 248,
			style: 'margin-left:10px;',
			border: true,
			store: new Ext.data.SimpleStore({
				fields:['id', 'text'],
				data:[[1,'{%CIRCULATION_TITLE%}'],[2,'{%SENDER_USERNAME%}'],[3,'{%SENDER_FULLNAME%}'],[4,'{%TIME%}'],[5,'{%DATE_SENDING%}']]
			}),
			cm: cm
		});
		
	},
	
	initColumnPanel: function () {
		this.theColumnPanel = new Ext.Panel({
		    layout: 'column',
			border: 'none',
			layoutConfig: {
				columns: 2,
				fitHeight: true,
				split: true
			}
		});
		
	},
	
	
	
	initFileGrid: function () {
		var cm = new Ext.grid.ColumnModel([
			{header: "<?php echo __('File',null,'workflowmanagement'); ?>", width: 310, sortable: true, dataIndex: 'text', css : "text-align : left;font-size:12px;align:left;", renderer:this.renderFileButton},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/picture_delete.png' />&nbsp;&nbsp;</td><td><?php echo __('Remove file',null,'workflowmanagement'); ?></td></tr></table>\" ext:qwidth=\"80\"><?php echo __('Action',null,'workflowmanagement'); ?></div>", width: 60, sortable: true, css : "text-align : left;font-size:12px;align:center;", renderer:this.renderDeleteFile}
		]);
		
		var tbar = new Ext.Toolbar({
			items: [{
				icon: '/images/icons/picture_add.png',
	            tooltip:'<?php echo __('Add new attachment',null,'workflowmanagement'); ?>',
	            handler: function () {
	            	var id = cf.createWorkflowFirstTab.theUniqueFileStoreId++;
					var Rec = Ext.data.Record.create({name: 'file'},{name: 'unique_id'});
					cf.createWorkflowFirstTab.theFileUploadGrid.store.add(new Rec({unique_id: id, name: ''}));
	            	
	            }
			}]
		});
		
		this.theFileUploadGrid = new Ext.grid.GridPanel({ 
			frame:true,
			autoScroll: true,
			collapsible:false,
			closable: false,
			width: 400,
			fieldLabel: '<?php echo __('Add attachments',null,'workflowmanagement'); ?>',
			height: 200,
			tbar: tbar,
			border: false,
			store: new Ext.data.SimpleStore({
				fields:['file', 'unique_id']
			}),
			cm: cm
		});
	},
	
	renderDeleteFile: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = cf.createWorkflowFirstTab.theUniqueFileId;
		var btn = cf.createWorkflowFirstTab.createRemoveButton.defer(3,this, [id]);
		return '<center><table><tr><td><div id="remove_uploadfile'+ id +'"></div></td></tr></table></center>';
	},
	
	createRemoveButton: function(id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'remove_uploadfile' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/picture_delete.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							var item = cf.createWorkflowFirstTab.theFileUploadGrid.store.findExact('unique_id', id );
							cf.createWorkflowFirstTab.theFileUploadGrid.store.remove(item);
						},
					scope: c
				});
				}
			}
		});
		
		
	},
	
	renderFileButton: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = cf.createWorkflowFirstTab.theUniqueFileId++;
		var btn = cf.createWorkflowFirstTab.createFileUpload.defer(3,this, [id]);
		return '<center><table><tr><td><div id="create_uploadfile'+ id +'"></div></td></tr></table></center>';
	},
	
	
	createFileUpload: function (id) {
		var file = new Ext.form.FileUploadField({
		    fieldLabel: '<?php echo __('Select attachment',null,'workflowmanagement'); ?>',
		    name: 'uploadfile__'+id,
		    renderTo: 'create_uploadfile'+id,
			emptyText:  '<?php echo __('Select a file',null,'workflowmanagement'); ?>',
			width: 300
		});
		
		if (Ext.isIE6 == true) {			
			file.setSize({width:50});
		}
		else if (Ext.isIE7 == true) {
			file.setSize({width:50});
		}
		return file;
	},
	
	initSinglePanel: function () {
		this.thePanel = new Ext.Panel({});
	},
		
	initTextarea: function () {
		this.theTextarea = new Ext.form.TextArea({				
			id: 'createWorkflowFirstTab_textarea',
			labelSeparator: '',
			allowBlank: true,
			hidden: true,
			height: 250,
			width: 450,
			value: '',
			anchor: '100%'
		});
	},
	
	initHTMLarea: function () {
		this.theHtmlarea = new Ext.form.HtmlEditor({
				labelSeparator: '',			
				height: 250,
				id: 'createWorkflowFirstTab_htmlarea',
				hidden:false,
				width: 450,
				style: 'margin-top:5px;margin-left:5px;',
				allowBlank: true,
				value: '',
				anchor: '98%'
		});	
	},
	
	
	
	initAdditionaltextcombo: function () {
		this.theAdditionaltextCombo = new Ext.form.ComboBox({
			fieldLabel: '<?php echo __('Select Additional text',null,'workflowmanagement'); ?>',
			valueField: 'value',
			displayField: 'text',
			editable: false,
			mode: 'local',
			store: new Ext.data.SimpleStore({
				fields: [
					{name: 'value'},
					{name: 'content_type'},
					{name: 'content'},
					{name: 'text'}
				]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			id: 'createWorkflowFirstTab_additionaltext_id',
			hiddenName: 'createWorkflowFirstTab_additionaltext',
			allowBlank: true,
			forceSelection:true,
			listeners: {
				select: {
					fn:function(combo, value) {
						var item = combo.store.findExact('value', combo.getValue());
						if(item.data.content_type == 'plain') {
							cf.createWorkflowFirstTab.theTextarea.setVisible(true);
							cf.createWorkflowFirstTab.theHtmlarea.setVisible(false);
							cf.createWorkflowFirstTab.theTextarea.setSize({width: 450});
							cf.createWorkflowFirstTab.theTextarea.setValue(item.data.content);
						}
						else {
							cf.createWorkflowFirstTab.theTextarea.setVisible(false);
							cf.createWorkflowFirstTab.theHtmlarea.setVisible(true);
							cf.createWorkflowFirstTab.theHtmlarea.setSize({width: 450});
							cf.createWorkflowFirstTab.theHtmlarea.setValue(item.data.content);
						}
					}
				}
			},
			width: 170
		});
		this.theAdditionaltextCombo.on('render', function(combo) {
			Ext.Ajax.request({  
				url: '<?php echo build_dynamic_javascript_url('additionaltext/LoadAllText')?>',
				success: function(objServerResponse){ 
					theJsonTreeData = Ext.util.JSON.decode(objServerResponse.responseText);
					var defaultdata = -1;
					var content_type;
					var content;
					var data = theJsonTreeData.result;
					for(var a=0;a<data.length;a++) {
						var item = data[a];
						var Rec = Ext.data.Record.create({name: 'value'},{name: 'content_type'},{name: 'content'},{name: 'text'});
						cf.createWorkflowFirstTab.theAdditionaltextCombo.store.add(new Rec({value: item.id, content_type: item.rawcontenttype,content: item.content, text: item.title}));
						if(item.is_active == 1) {
							content_type = item.rawcontenttype;
							content = item.content;
							defaultdata = item.id;
						}
					}
					if(defaultdata != -1) {
						cf.createWorkflowFirstTab.theAdditionaltextCombo.setValue(defaultdata);
						if(content_type == 'plain') {
							cf.createWorkflowFirstTab.theTextarea.setVisible(true);
							cf.createWorkflowFirstTab.theHtmlarea.setVisible(false);
							cf.createWorkflowFirstTab.theTextarea.setValue(content);
						}
						else {
							cf.createWorkflowFirstTab.theTextarea.setVisible(false);
							cf.createWorkflowFirstTab.theHtmlarea.setVisible(true);
							cf.createWorkflowFirstTab.theHtmlarea.setValue(content);
						}
					}
					if(data.length == 0){
						cf.createWorkflowFirstTab.theContenttypeCombo.setVisible(true);
						cf.createWorkflowFirstTab.theAdditionaltextCombo.setVisible(false);
						cf.createWorkflowFirstTab.theTextarea.setVisible(false);
						cf.createWorkflowFirstTab.theHtmlarea.setVisible(true);
					}
					else {
						cf.createWorkflowFirstTab.theContenttypeCombo.destroy();
					}
				}
			});

			
		});
	},
	
	initTimePicker: function() {
		this.theTimePicker = new Ext.form.TimeField({
			fieldLabel : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Set Time',null,'workflowmanagement'); ?>',
			hidden:true,
			hiddenName: 'createWorkflowFirstTab_timepicker',
			format: 'H:i',
		    increment: 30,
			editable: false,
			autoSelect: false,
			forceSelection: true,  
			width:170	
		});	
	},
	
	initDatepicker: function () {
		this.theDatepicker = new Ext.form.DateField({
			allowBlank:true,
			hidden:true,
			editable: false,
			format:'d-m-Y',
			id: 'createWorkflowFirstTab_datepicker',
			fieldLabel: "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span ext:qtip=\"<table><tr><td><b><?php echo __('Datefield is empty',null,'workflowmanagement'); ?></b></td><td> : <?php echo __('Workflow will start immediately',null,'workflowmanagement'); ?></td></tr><tr><td><b><?php echo __('Datefield is set',null,'workflowmanagement'); ?></b></td><td> : <?php echo __('Workflow will start at selected date',null,'workflowmanagement'); ?></td></tr></table>\" ext:qwidth=\"350\"><?php echo __('Startdate of Workflow',null,'workflowmanagement'); ?></span>",
			width:170	
		});
		if (Ext.isIE6 == true) {
			this.theDatepicker.style = 'margin-top:0px;margin-bottom:0px;';
		}
	},
	
	initMailinglist: function () {
		this.theMailinglist = new Ext.form.ComboBox({
			fieldLabel: '<?php echo __('Mailinglist',null,'workflowmanagement'); ?>',
			valueField: 'value',
			id: 'createWorkflowFirstTab_mailinglist_id',
			displayField: 'text',
			editable: false,
			hiddenName: 'createWorkflowFirstTab_mailinglist',
			mode: 'local',
			store: new Ext.data.SimpleStore({
				fields: [
					{name: 'value'},
					{name: 'active_version_id'},
					{name: 'text'}
				]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: false,
			forceSelection:true,
			listeners: {
				select: {
					fn:function(combo, value) {
						try {
							cf.createWorkflowWindow.theTabPanel.remove(cf.createWorkflowSecondTab.theSecondPanel);
							cf.createWorkflowSecondTab.theSecondPanel.destroy();
							cf.createWorkflowWindow.theTabPanel.remove(cf.createWorkflowThirdTab.theThirdPanel);
							cf.createWorkflowSecondTab.theThirdPanel.destroy();
						}
						catch(e){
							
						}
						cf.createWorkflowFirstTab.theLoadingMask = new Ext.LoadMask(cf.createWorkflowWindow.theCreateWorkflowWindow.body, {msg:'<?php echo __('Preparing Data...',null,'workflowmanagement'); ?>'});					
						cf.createWorkflowFirstTab.theLoadingMask.show();
						var data = combo.store.findExact('value', combo.getValue());
						cf.createWorkflowSecondTab.init(data.data.active_version_id);
						cf.createWorkflowWindow.theTabPanel.add(cf.createWorkflowSecondTab.theSecondPanel);
						cf.createWorkflowThirdTab.init(data.data.active_version_id);
						cf.createWorkflowWindow.theTabPanel.add(cf.createWorkflowThirdTab.theThirdPanel);
						cf.createWorkflowFirstTab.showTab.defer(1,this,[2]);
						cf.createWorkflowFirstTab.showTab.defer(1200,this,[1]);
						cf.createWorkflowFirstTab.showTab.defer(1200,this,[0]);
						cf.createWorkflowFirstTab.hideLabel.defer(3000,this,[]);
						
					}
				}
			},
			width: 170
		});
		
		if (Ext.isIE6 == true) {
			this.theMailinglist.style = 'margin-top:0px;margin-bottom:0px;';
		}

		this.theMailinglist.on('render', function(combo) {
			cf.createWorkflowFirstTab.theLoadingMask = new Ext.LoadMask(cf.createWorkflowWindow.theCreateWorkflowWindow.body, {msg:'<?php echo __('Preparing Data...',null,'workflowmanagement'); ?>'});					
			cf.createWorkflowFirstTab.theLoadingMask.show();
			Ext.Ajax.request({  
				url: '<?php echo build_dynamic_javascript_url('createworkflow/LoadAllMailinglist')?>',
				success: function(objServerResponse){ 
					theJsonTreeData = Ext.util.JSON.decode(objServerResponse.responseText);
					var defaultdata = -1;
					var data = theJsonTreeData.result;
					for(var a=0;a<data.length;a++) {
						var item = data[a];
						var Rec = Ext.data.Record.create({name: 'value'},{name: 'text'}, {name: 'active_version_id'});
						combo.store.add(new Rec({value: item.id, text: item.name, active_version_id: item.active_version}));
						if(item.is_active == 1) {
							defaultdata = item.id;
							var singleData = combo.store.findExact('value', defaultdata);
						}
					}
					if(defaultdata != -1) {
						combo.setValue(defaultdata);
						cf.createWorkflowSecondTab.init(singleData.data.active_version_id);
						cf.createWorkflowWindow.theTabPanel.add(cf.createWorkflowSecondTab.theSecondPanel);
						cf.createWorkflowThirdTab.init(singleData.data.active_version_id);
						cf.createWorkflowWindow.theTabPanel.add(cf.createWorkflowThirdTab.theThirdPanel);
						cf.createWorkflowFirstTab.showTab.defer(1,this,[2]);
						cf.createWorkflowFirstTab.showTab.defer(1200,this,[1]);
						cf.createWorkflowFirstTab.showTab.defer(1200,this,[0]);
					}
					cf.createWorkflowFirstTab.hideLabel.defer(3000,this,[]);
				}
			});	
		});	
	},
	
	hideLabel: function () {
		cf.createWorkflowFirstTab.theLoadingMask.hide();
	},
	
	showTab: function (tab) {
		cf.createWorkflowWindow.theTabPanel.setActiveTab(tab);
		
	},
	
	initPanel: function () {
		this.theFirstTabPanel = new Ext.Panel({
			title: '<?php echo __('General Settings',null,'workflowmanagement'); ?>',
			frame:true,
			autoScroll: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 148
		});
	},
	
	
		
	createFieldset: function(id, label, collapsed, height, autoscroll) {
		var fieldset = new Ext.form.FieldSet({
			title: label,
			height: 'auto',
			style: 'margin-left:5px;margin-top:5px',
			width:cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 100,
			autoScroll: autoscroll,
			collapsible: true,
			collapsed: collapsed,
			id: id,
			labelWidth:220
		});
		return fieldset;
	},
	
	initNameTextfield: function () {
		this.theNameTextfield = new Ext.form.TextField({
			id: 'createWorkflowFirstTab_name',
			fieldLabel: '<?php echo __('Workflow name',null,'workflowmanagement'); ?>',
			allowBlank: false,
			style: 'margin-top:5px;',
			width: 170
		});
	},
	
		
	/** render Move Function **/
	renderButton: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var btnMove = cf.createWorkflowFirstTab.createMoveButton.defer(1,this, [data,record.data['text']]);
		return '<center><table><tr><td><div id="workflowplaceholder' + data + '"></div></td></tr></table></center>';
	},
	
	/** 
	* create movebutton 
	* @param int id, id of the clicked element
	* @param string text, value of the placeholder
	*/
	createMoveButton: function (id,text) {
		var btn_move = new Ext.form.Label({
			renderTo: 'workflowplaceholder' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/control_rewind_blue.png" /></span>',
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							cf.createWorkflowFirstTab.movePlaceholder(text);
						},
					scope: c
					});
				}
			}
		});
	},
	
	/** 
	* 
	* move functionality
	*
	* @param String value, value of the placeholder
	*/
	movePlaceholder: function (value) {
		if(cf.createWorkflowFirstTab.theTextarea.hidden == false) {
			var visibleComponent = cf.createWorkflowFirstTab.theTextarea;
		}
		else {
			var visibleComponent = cf.createWorkflowFirstTab.theHtmlarea;
		}
		var content = visibleComponent.getValue();
		content = content + ' ' + value;
		visibleComponent.setValue(content);
		visibleComponent.focus();		
	}
	
	
	
};}();