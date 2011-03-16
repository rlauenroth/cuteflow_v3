cf.restartWorkflowFirstTab = function(){return {
	
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
	theSendToAllSlots				:false,
	theStartPoint					:false,
	theHiddenField					:false,	
	
	
	init: function () {
		this.theUniqueFileStoreId = 1;
		this.theUniqueFileId = 0;
		this.initPanel();
		var fieldset1 = cf.restartWorkflowFirstTab.createFieldset('restartWorkflowFirstTab_fieldset1', '<?php echo __('Restart settings',null,'workflowmanagement'); ?>', false, 300, true, false);
		this.initFileGrid();
		this.initHiddenfield();
		this.initStartPoint();
		var cb7 = this.createCheckbox('restartWorkflowFirstTab_useoldvalues','<?php echo __('Use values from current version',null,'workflowmanagement'); ?>?',false,'', 1);
		
		
		fieldset1.add(this.theMailinglist);
		fieldset1.add(this.theStartPoint);
		fieldset1.add(cb7);	
		fieldset1.add(this.theFileUploadGrid);
		fieldset1.add(this.theHiddenField);
		
				
		
			
		var fieldset2 = cf.restartWorkflowFirstTab.createFieldset('restartWorkflowFirstTab_fieldset2', '<?php echo __('Select Additional text',null,'workflowmanagement'); ?>', false, 370, true, true);
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
		
		var fieldset3 = cf.restartWorkflowFirstTab.createFieldset('restartWorkflowFirstTab_fieldset3', '<?php echo __('Additional Settings',null,'workflowmanagement'); ?>', false, 250, true, true);
		var cb1 = this.createLabel();
		var cb2 = this.createCheckbox('restartWorkflowFirstTabSettings[0]','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('After succeeded circulation',null,'workflowmanagement'); ?>',true,'', 1);
		var cb3 = this.createCheckbox('restartWorkflowFirstTabSettings[1]','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('After succeeded slot end',null,'workflowmanagement'); ?>',false,'', 2);
		var cb4 = this.createCheckbox('restartWorkflowFirstTabSettings[2]','<?php echo __('Archive after succeeded circulation',null,'workflowmanagement'); ?>',true,'', 4);
		var cb5 = this.createCheckbox('restartWorkflowFirstTabSettings[3]','<?php echo __('Delete after succeeded circulation',null,'workflowmanagement'); ?>',false,'', 8);
		var cb6 = this.createCheckbox('restartWorkflowFirstTabSettings[4]','<?php echo __('Show receiver name in workflow',null,'workflowmanagement'); ?>',false,'', 16);
		
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
	
	initHiddenfield: function() {
		this.theHiddenField = new Ext.form.Hidden({
			id: 'restartWorkflowFirstTab_startpointid',
			allowBlank: true,
			width: 1
		});
	},
	
	initStartPoint: function () {
		this.theStartPoint = new Ext.form.ComboBox({
			fieldLabel: '<?php echo __('Start at Station',null,'workflowmanagement'); ?>',
			editable:false,
			triggerAction: 'all',
			foreSelection: true,
			id: 'restartWorkflowFirstTab_startpoint_id',
			hiddenName: 'restartWorkflowFirstTab_startpoint',
			mode: 'local',
			value: 'LASTSTATION',
			store: new Ext.data.SimpleStore({
				 fields:['id','text'],
				 data:[['BEGINNING', '<?php echo __('Start at the beginning',null,'workflowmanagement'); ?>'],['LASTSTATION', '<?php echo __('Start at last station',null,'workflowmanagement'); ?>'], ['STATION', '<?php echo __('Select other station',null,'workflowmanagement'); ?>']]
			}),
			valueField:'id',
			displayField:'text',
			width:400,
			listeners: {
	    		select: {
	    			fn:function(combo, value) {
						if(combo.getValue() == 'STATION') {
							cf.restartSelectStation.init();
						}
						else {
							cf.restartWorkflowFirstTab.theHiddenField.setValue(combo.getValue());
						}
	    			}
	    		}
	    	} 
		});
		cf.restartWorkflowFirstTab.theHiddenField.setValue('BEGINNING');
		
	},
	
	initSendToAllCheckbox: function () {
		this.theSendToAllSlots = new Ext.form.Checkbox({
			fieldLabel: '<?php echo __('Send to all slots at once?',null,'workflowmanagement'); ?>',
			inputValue: '1',
			style: 'margin-top:3px;',
			checked: false,
			id: 'restartWorkflowFirstTab_sendtoallslots'	
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
			id: 'restartWorkflowFirstTab_contenttype_id',
			hiddenName: 'restartWorkflowFirstTab_contenttype',
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
							cf.restartWorkflowFirstTab.theTextarea.setVisible(true);
							cf.restartWorkflowFirstTab.theTextarea.setSize({width: 450});
							cf.restartWorkflowFirstTab.theHtmlarea.setVisible(false);
	    				}
	    				else {
							cf.restartWorkflowFirstTab.theTextarea.setVisible(false);
							cf.restartWorkflowFirstTab.theHtmlarea.setSize({width: 450});
							cf.restartWorkflowFirstTab.theHtmlarea.setVisible(true);
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
	            	var id = cf.restartWorkflowFirstTab.theUniqueFileStoreId++;
					var Rec = Ext.data.Record.create({name: 'file'},{name: 'unique_id'});
					cf.restartWorkflowFirstTab.theFileUploadGrid.store.add(new Rec({unique_id: id, name: ''}));
	            	
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
		var id = cf.restartWorkflowFirstTab.theUniqueFileId;
		var btn = cf.restartWorkflowFirstTab.createRemoveButton.defer(3,this, [id]);
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
							var item = cf.restartWorkflowFirstTab.theFileUploadGrid.store.findExact('unique_id', id );
							cf.restartWorkflowFirstTab.theFileUploadGrid.store.remove(item);
						},
					scope: c
				});
				}
			}
		});
		
		
	},
	
	renderFileButton: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = cf.restartWorkflowFirstTab.theUniqueFileId++;
		var btn = cf.restartWorkflowFirstTab.createFileUpload.defer(3,this, [id]);
		return '<center><table><tr><td><div id="restart_uploadfile'+ id +'"></div></td></tr></table></center>';
	},
	
	
	createFileUpload: function (id) {
		var file = new Ext.form.FileUploadField({
		    fieldLabel: '<?php echo __('Select attachment',null,'workflowmanagement'); ?>',
		    name: 'uploadfile__'+id,
		    renderTo: 'restart_uploadfile'+id,
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
			id: 'restartWorkflowFirstTab_textarea',
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
				id: 'restartWorkflowFirstTab_htmlarea',
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
					{name: 'contenttype'},
					{name: 'content'},
					{name: 'text'}
				]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			id: 'restartWorkflowFirstTab_additionaltext_id',
			hiddenName: 'restartWorkflowFirstTab_additionaltext',
			allowBlank: true,
			forceSelection:true,
			listeners: {
				select: {
					fn:function(combo, value) {
						var item = combo.store.findExact('value', combo.getValue());
						if(item.data.contenttype == 'plain') {
							cf.restartWorkflowFirstTab.theTextarea.setVisible(true);
							cf.restartWorkflowFirstTab.theHtmlarea.setVisible(false);
							cf.restartWorkflowFirstTab.theTextarea.setSize({width: (cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth()) / 2});
							cf.restartWorkflowFirstTab.theTextarea.setValue(item.data.content);
						}
						else {
							cf.restartWorkflowFirstTab.theTextarea.setVisible(false);
							cf.restartWorkflowFirstTab.theHtmlarea.setVisible(true);
							cf.restartWorkflowFirstTab.theHtmlarea.setSize({width: (cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth()) / 2});
							cf.restartWorkflowFirstTab.theHtmlarea.setValue(item.data.content);
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
					var contenttype;
					var content;
					var data = theJsonTreeData.result;
					for(var a=0;a<data.length;a++) {
						var item = data[a];
						var Rec = Ext.data.Record.create({name: 'value'},{name: 'contenttype'},{name: 'content'},{name: 'text'});
						cf.restartWorkflowFirstTab.theAdditionaltextCombo.store.add(new Rec({value: item.id, contenttype: item.rawcontenttype,content: item.content, text: item.title}));
						if(item.isactive == 1) {
							contenttype = item.rawcontenttype;
							content = item.content;
							defaultdata = item.id;
						}
					}
					if(defaultdata != -1) {
						cf.restartWorkflowFirstTab.theAdditionaltextCombo.setValue(defaultdata);
						if(contenttype == 'plain') {
							cf.restartWorkflowFirstTab.theTextarea.setVisible(true);
							cf.restartWorkflowFirstTab.theHtmlarea.setVisible(false);
							cf.restartWorkflowFirstTab.theTextarea.setValue(content);
						}
						else {
							cf.restartWorkflowFirstTab.theTextarea.setVisible(false);
							cf.restartWorkflowFirstTab.theHtmlarea.setVisible(true);
							cf.restartWorkflowFirstTab.theHtmlarea.setValue(content);
						}
					}
					if(data.length == 0){
						cf.restartWorkflowFirstTab.theContenttypeCombo.setVisible(true);
						cf.restartWorkflowFirstTab.theAdditionaltextCombo.setVisible(false);
						cf.restartWorkflowFirstTab.theTextarea.setVisible(false);
						cf.restartWorkflowFirstTab.theHtmlarea.setVisible(true);
					}
					else {
						cf.restartWorkflowFirstTab.theContenttypeCombo.destroy();
					}
				}
			});

			
		});
	},
	
	initPanel: function () {
		this.theFirstTabPanel = new Ext.FormPanel({
			title: '<?php echo __('General Settings',null,'workflowmanagement'); ?>',
			frame:true,
			fileUpload: true,
			autoScroll: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 148
		});
	},
	
	
		
	createFieldset: function(id, label, collapsed, height, autoscroll, collapsible) {
		var fieldset = new Ext.form.FieldSet({
			title: label,
			height: 'auto',
			style: 'margin-left:5px;margin-top:5px',
			width:cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 100,
			autoScroll: autoscroll,
			collapsible: collapsible,
			collapsed: collapsed,
			id: id,
			labelWidth:220
		});
		return fieldset;
	},
	
	initNameTextfield: function () {
		this.theNameTextfield = new Ext.form.TextField({
			id: 'restartWorkflowFirstTab_name',
			fieldLabel: '<?php echo __('Workflow name',null,'workflowmanagement'); ?>',
			allowBlank: false,
			style: 'margin-top:5px;',
			width: 170
		});
	},
	
		
	/** render Move Function **/
	renderButton: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var btnMove = cf.restartWorkflowFirstTab.createMoveButton.defer(1,this, [data,record.data['text']]);
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
							cf.restartWorkflowFirstTab.movePlaceholder(text);
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
		if(cf.restartWorkflowFirstTab.theTextarea.hidden == false) {
			var visibleComponent = cf.restartWorkflowFirstTab.theTextarea;
		}
		else {
			var visibleComponent = cf.restartWorkflowFirstTab.theHtmlarea;
		}
		var content = visibleComponent.getValue();
		content = content + ' ' + value;
		visibleComponent.setValue(content);
		visibleComponent.focus();		
	}
	
	
	
};}();