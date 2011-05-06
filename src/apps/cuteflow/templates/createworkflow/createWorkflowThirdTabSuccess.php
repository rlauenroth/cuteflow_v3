cf.createWorkflowThirdTab = function(){return {
	
	
	theThirdPanel				:false,
	theUniqueFieldsetId			:false,
	theUniqueFieldId			:false,
	
	
	init:function(id) {
		this.theUniqueFieldsetId = 1;
		this.theUniqueFieldId = 1;
		this.initPanel();
		this.loadData(id);
	},
	
	
	loadData: function (id) {
		Ext.Ajax.request({  
			url: '<?php echo build_dynamic_javascript_url('createworkflow/LoadAllField')?>/id/' + id,
			success: function(objServerResponse){
				theJsonTreeData = Ext.util.JSON.decode(objServerResponse.responseText);
				cf.createWorkflowThirdTab.addData(theJsonTreeData, false);
			}
		});		
	},
	
	
	initPanel: function () {
		this.theThirdPanel = new Ext.Panel({
			title: '<?php echo __('Fields',null,'workflowmanagement'); ?>',
			frame:true,
			autoScroll: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 148,
			width: 600,
			border: false,
			style: 'border:none;'
		});
	},
	
	addData: function (result, collapsed) {
		var data = result.result;
		
		for(var a=0;a<data.length;a++) {
			var item = data[a];
			var fieldset = cf.createWorkflowThirdTab.createFieldset(item.slot_id, collapsed, item.slot_name);
			var columnpanel = cf.createWorkflowThirdTab.createColumnPanel('');
			var leftPanel = cf.createWorkflowThirdTab.createPanel();
			var rightPanel = cf.createWorkflowThirdTab.createPanel();
			columnpanel.add(leftPanel);
			columnpanel.add(rightPanel);
			fieldset.add(columnpanel);
			for(var b=0;b<item.fields.length;b++) {
				var fielditem = item.fields[b];
				switch (fielditem.type) {
					case "TEXTFIELD":
						var textfield = cf.createWorkflowThirdTab.createTextfield(fielditem, false);
						fielditem.assign == 'LEFT' ? leftPanel.add(textfield) : rightPanel.add(textfield);
					    break;
					case "CHECKBOX":
						var checkbox = cf.createWorkflowThirdTab.createCheckbox(fielditem, false);
						fielditem.assign == 'LEFT' ? leftPanel.add(checkbox) : rightPanel.add(checkbox);
						break;
					case "NUMBER":
						var number = cf.createWorkflowThirdTab.createNumberfield(fielditem, false);
						fielditem.assign == 'LEFT' ? leftPanel.add(number) : rightPanel.add(number);
						break;
					case "DATE":
						var date = cf.createWorkflowThirdTab.createDatefield(fielditem, false);
						fielditem.assign == 'LEFT' ? leftPanel.add(date) : rightPanel.add(date);
						break;
					case "TEXTAREA":
						var textarea = cf.createWorkflowThirdTab.createTextarea(fielditem, false);
						fielditem.assign == 'LEFT' ? leftPanel.add(textarea) : rightPanel.add(textarea);
						break;
					case "RADIOGROUP":
						var radiogroup = cf.createWorkflowThirdTab.createRadiogroup(fielditem, false);
						fielditem.assign == 'LEFT' ? leftPanel.add(radiogroup) : rightPanel.add(radiogroup);
						break;
					case "CHECKBOXGROUP":
						var checkboxgroup = cf.createWorkflowThirdTab.createCheckboxgroup(fielditem, false);
						fielditem.assign == 'LEFT' ? leftPanel.add(checkboxgroup) : rightPanel.add(checkboxgroup);
						break;
					case "COMBOBOX":
						var combobox = cf.createWorkflowThirdTab.createCombobox(fielditem, false);
						fielditem.assign == 'LEFT' ? leftPanel.add(combobox) : rightPanel.add(combobox);
						break;
					case "FILE":
						var file = cf.createWorkflowThirdTab.createFile(fielditem, false);
						var fileHidden = cf.createWorkflowThirdTab.createHiddenFile(fielditem, false);
						fielditem.assign == 'LEFT' ? leftPanel.add(file) : rightPanel.add(file);
						cf.createWorkflowWindow.theFormPanel.add(fileHidden);
					break;
				}			

			}
			cf.createWorkflowThirdTab.theThirdPanel.add(fieldset);
		}
		cf.createWorkflowThirdTab.theThirdPanel.doLayout();
	},
	

	
	createPanel: function () {
		var panel = new Ext.Panel({
			frame:false,
			layout: 'form',
			border: false,
			autoScroll: true,
			width: (cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 180) / 2,
			height: 'auto'
		});	
		return panel;
	},
	
	createCombobox: function (data, editable) {
		var combo =  new Ext.form.ComboBox({
			fieldLabel: data.field_name,
			valueField: 'value',
			displayField: 'text',
			editable: false,
			disabled: editable,
			mode: 'local',
			store: new Ext.data.SimpleStore({
				fields: [
					{name: 'value'},
					{name: 'text'}
				]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			id: 'COMBOBOX_' + data.field_id + '_' + cf.createWorkflowThirdTab.theUniqueFieldId++,
			allowBlank: true,
			width:200,
			forceSelection:true
		});
		var activeId = -1;
		for(var a=0;a<data.items.length;a++){
			var item = data.items[a];
			var Rec = Ext.data.Record.create({name: 'value'},{name: 'text'});
			combo.store.add(new Rec({value: item.id, text: item.value}));
			if(item.isactive == 1) {
				activeId = item.id;
			}
		}
		
		if(activeId != -1) {
			combo.setValue(activeId);
		}
		
		if (Ext.isIE6 == true) {
			combo.style = 'margin-top:0px;margin-bottom:0px;';
		}
		
		return combo;
		
	},
	createHiddenFile:function (data, editable) {
		var id = cf.createWorkflowThirdTab.theUniqueFieldId;
		id -= 1;
		var hiddenfield =  new Ext.form.Hidden({
			id: 'FILE_' + data.field_id + '_' + id + '_REGEX',
			value: 'REGEX_' + data.items.regex
		});
		return hiddenfield;
	},
	
	createFile: function (data, editable) {
		var id = cf.createWorkflowThirdTab.theUniqueFieldId++;
		var file = new Ext.form.FileUploadField({
		    fieldLabel: data.field_name,
			id: 'FILE_' + data.field_id + '_' + id,
			disabled: editable,
			emptyText:  '<?php echo __('Select a file',null,'workflowmanagement'); ?>',
			width: 200
		});
		if (Ext.isIE6 == true) {			
			file.style = 'margin-top:0px;margin-bottom:0px;';
		}
		else if (Ext.isIE7 == true) {
			file.style = 'margin-top:0px;margin-bottom:0px;';
		}
		

		
		return file;
	},
	
	createCheckboxgroup: function (data, editable) {
		var store = new Array();
		var id = cf.createWorkflowThirdTab.theUniqueFieldId++;
		for(var a=0;a<data.items.length;a++){
			var item = data.items[a];
			var activeitem = item.isactive == 1 ? true : false;
			var check = new Ext.form.Checkbox({
				 boxLabel: item.value, 
				 checked: activeitem,
				 id: 'CHECKBOXITEM_' + id + '_' + item.id, 
				 name: 'CHECKBOXGROUP_' + data.field_id + '_' + id + '_name', 
				 inputValue: 1
			});
			store[a] = check;
		}
		var checkboxgroup = new Ext.form.CheckboxGroup({
			id: 'CHECKBOXGROUP_' + data.field_id + '_' + id,
			fieldLabel: data.field_name,
			disabled: editable,
			items:[store]			
		});
		
		return checkboxgroup;

	},
	
	createRadiogroup: function (data, editable) {
		var store = new Array();
		var id = cf.createWorkflowThirdTab.theUniqueFieldId++;
		for(var a=0;a<data.items.length;a++){
			var item = data.items[a];
			var activeitem = item.isactive == 1 ? true : false;
			var radio = new Ext.form.Radio({
				 boxLabel: item.value, 
				 checked: activeitem,
				 id: 'RADIOGROUPITEM_' + id + '_' + item.id, 
				 name: 'RADIOGROUP_' + data.field_id + '_' + id + '_name', 
				 inputValue: 1
			});
			store[a] = radio;
		}
		var radiogroup = new Ext.form.RadioGroup({
			id: 'RADIOGROUP_' + data.field_id + '_' + id,
			fieldLabel: data.field_name,
			disabled: editable,
			items:[store]			
		});
		
		return radiogroup;
	},
	
	createTextarea: function (data, editable) {
		if(data.items.contenttype == 'plain') {
			var textarea = new Ext.form.TextArea({
				fieldLabel: data.field_name,
				width: ((cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 180) / 2)-200,
				value: data.items.content,
				disabled: editable,
				id: 'TEXTAREA_' + data.field_id + '_' + cf.createWorkflowThirdTab.theUniqueFieldId++,
				height: 150
			});
		}
		else {
			var textarea = new Ext.form.HtmlEditor({
				fieldLabel: data.field_name,
				value: data.items.content,
				disabled: editable,
				width: ((cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 180) / 2)-200,
				id: 'TEXTAREA_' + data.field_id + '_' + cf.createWorkflowThirdTab.theUniqueFieldId++,
				height: 150
			});
		}
		return textarea;
		
	},
	
	createDatefield: function (data, editable) {
		var textfield = new Ext.form.DateField({
			allowBlank:true,
			format: data.items.dateformat,
			id: 'DATE_' + data.field_id + '_' + cf.createWorkflowThirdTab.theUniqueFieldId++,
			fieldLabel: data.field_name,
			disabled: false,
			editable: false,
			value: data.items.defaultvalue,
			width:200
		});	
		return textfield;
	},
	
	
	createNumberfield: function (data, editable) {
		var textfield = new Ext.form.TextField({
			fieldLabel: data.field_name,
			id: 'NUMBER_' + data.field_id + '_' + cf.createWorkflowThirdTab.theUniqueFieldId++,
			allowBlank: true,
			disabled: editable,
			name: 'REGEX_' + data.items.regex,
			emptyText: data.items.comboboxtext,
			value: data.items.defaultvalue,
			width: 200
		});
		return textfield;
		
	},
	
	createCheckbox: function (data, editable) {
		var checkbox = new Ext.form.Checkbox({
			fieldLabel: data.field_name,
			inputValue: '1',
			disabled: editable,
			style: 'margin-top:5px;',
			id: 'CHECKBOX_' + data.field_id + '_' + cf.createWorkflowThirdTab.theUniqueFieldId++
		});
		return checkbox;
	},
	
	createTextfield: function (data, editable) {
		var textfield = new Ext.form.TextField({
			fieldLabel: data.field_name,
			id: 'TEXTFIELD_' + data.field_id + '_' + cf.createWorkflowThirdTab.theUniqueFieldId++,
			allowBlank: true,
			disabled: editable,
			name: 'REGEX_' + data.items.regex,
			value: data.items.defaultvalue,
			width: 200
		});
		return textfield;
	},
	
	
	createColumnPanel: function (id) {
		var panel = new Ext.Panel({
		    layout: 'column',
		    width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 150,
		    height:'auto',
		    autoScroll:true,
			border: 'none',
			layoutConfig: {
				columns: 2,
				fitHeight: true,
				split: true
			}
		});
		return panel;
	},
	
	createFieldset: function (id, collapsed, name) {
		var fieldset = new Ext.form.FieldSet({
			title: name,
			height: 'auto',
			style: 'margin-left:5px;margin-top:5px',
			width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 100,
			autoScroll: true,
			collapsible: true,
			collapsed: collapsed,
			id: 'WORKFLOWFIELDSLOT_' + id,
			labelWidth:220
		});
		return fieldset;
	}
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
};}();