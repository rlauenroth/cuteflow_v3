cf.workflowdetailsValue = function(){return {
	
	theFieldset					:false,
	
	init:function(data) {
		this.initFieldset();
		this.addData(data);
	},
	
	
	
	initFieldset: function () {
		this.theFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Workflow values',null,'workflowmanagement'); ?>',
			allowBlank: false,
			autoScroll: true,
			style: 'margin-top:5px;margin-left:10px;',
			width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 100,
			height: 'auto'
		});
	},
	
	
	addData: function (data) {
		for(var a=0;a<data.length;a++) {
			var slot = data[a];
			var fieldset = this.createFieldset(slot.slotname);
			var columnPanel = this.createColumnpanel();
			var leftPanel = this.createPanel();		
			var rightPanel = this.createPanel();

			
			
			for(var b=0;b<slot.fields.length;b++) {
				var fielditem = slot.fields[b];
				switch (fielditem.type) {
					case "TEXTFIELD":
						var label = this.createTextfield(fielditem.title, fielditem.items.value);
						fielditem.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
					    break;
					case "CHECKBOX":
						var label = this.createCheckbox(fielditem.title, fielditem.items.value);
						fielditem.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
						break;
					case "NUMBER":
						var label = this.createTextfield(fielditem.title, fielditem.items.value);
						fielditem.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
						break;
					case "DATE":
						var label = this.createTextfield(fielditem.title, fielditem.items.value);
						fielditem.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
						break;
					case "TEXTAREA":
						var label = this.createTextarea(fielditem.title, fielditem.items.value, fielditem.items.contenttype);
						fielditem.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
					    break;
					case "RADIOGROUP":
						var label = this.createRadiogroup(fielditem.title, fielditem);
						fielditem.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
						break;
					case "CHECKBOXGROUP":
						var label = this.createCheckboxgroup(fielditem.title, fielditem);
						fielditem.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
						break;
					case "COMBOBOX":
						var label = this.createCombobox(fielditem.title, fielditem);
						fielditem.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
						break;
					case "FILE":
						var label = this.createFile(fielditem);
						fieldset.insert(0,label);
					break;
				}	
				
				
			}
			columnPanel.add(leftPanel);
			columnPanel.add(rightPanel);
			fieldset.add(columnPanel);
			this.theFieldset.add(fieldset);
		}

		this.theFieldset.doLayout();		
		
	},
	createFile: function (data) {
		var label = new Ext.form.Label({
			html: '<table><tr><td><img src="/images/icons/attach.png" /> </td><td>'+ data.items.link +'</td></tr></table>',
			style: 'font-size:14px;'
		});
		return label;
		
	},
	createCombobox: function (name, data) {
		var combo =  new Ext.form.ComboBox({
			fieldLabel: name,
			valueField: 'value',
			displayField: 'text',
			editable: false,
			mode: 'local',
			store: new Ext.data.SimpleStore({
				fields: [
					{name: 'text'}
				]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: true,
			width:200,
			forceSelection:true
		});
		var activeName = -1;
		for(var a=0;a<data.items.length;a++){
			var item = data.items[a];
			if(item.value == 1) {
				activeName = item.name;
			}
		}
		
		if(activeName != -1) {
			combo.setValue(activeName);
		}
		return combo;
		
	},
	
	createRadiogroup: function (name, data) {
		var store = new Array();
		for(var a=0;a<data.items.length;a++){
			var item = data.items[a];
			var activeitem = item.value == 1 ? true : false;
			var check = new Ext.form.Radio({
				 boxLabel: item.name, 
				 checked: activeitem
			});
			store[a] = check;
		}
		var checkboxgroup = new Ext.form.RadioGroup({
			fieldLabel: name,
			items:[store]			
		});
		
		return checkboxgroup;

	},
		
	createCheckboxgroup: function (name, data) {
		var store = new Array();
		for(var a=0;a<data.items.length;a++){
			var item = data.items[a];
			var activeitem = item.value == 1 ? true : false;
			var check = new Ext.form.Checkbox({
				 boxLabel: item.name, 
				 checked: activeitem
			});
			store[a] = check;
		}
		var checkboxgroup = new Ext.form.CheckboxGroup({
			fieldLabel: name,
			items:[store]			
		});
		
		return checkboxgroup;

	},
	
	createTextfield: function (name, value) {
		var textfield = new Ext.form.TextField({
			fieldLabel: name,
			value: value,
			width: 200
		});
		return textfield;
	},
	
	
	createTextarea: function (name, value, contenttype) {
		if(contenttype == 'plain') {
			var textarea = new Ext.form.TextArea({
				fieldLabel: name,
				width: ((cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 180) / 2)-200,
				value: value,
				height: 150
			});
		}
		else {
			var textarea = new Ext.form.HtmlEditor({
				fieldLabel: name,
				width: ((cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 180) / 2)-200,
				value: value,
				height: 150
			});
		}
		return textarea;
		
	},
	
	createCheckbox: function (name, value) {
		var checked = value == 1 ? true : false;
		var check = new Ext.form.Checkbox({
			 fieldLabel: name,
			 checked: checked,
			 disabled: false,
			 style: 'margin-top:3px;margin-left:1px;',
			 inputValue: 1
		});
		return check;
		
	},
	
	createLabel : function (name, value) {
		var label = new Ext.form.Label({
			html: '<table><tr><td width="150">'+name+': </td><td>'+value+'</td></tr></table>'
		});
		return label;
	},
	
	
	createPanel: function () {
		var panel = new Ext.Panel({
			frame:false,
			layout: 'form',
			border: false,
			autoScroll: true,
			width: (cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 210) / 2,
			height: 'auto'
		});	
		return panel;
	},
	
	createColumnpanel: function () {
		var panel = new Ext.Panel({
		    layout: 'column',
		    width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 180,
		    height:'auto',
			disabled: true,
			editable: false,
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
	
	createFieldset: function(slotname) {
		var fieldset = new Ext.form.FieldSet({
			title: slotname,
			allowBlank: false,
			autoScroll: true,
			style: 'margin-top:5px;margin-left:10px;',
			width:'auto',
			height: 'auto'
		});
		return fieldset;
	}
	
	
	
	
	
	
	
};}();