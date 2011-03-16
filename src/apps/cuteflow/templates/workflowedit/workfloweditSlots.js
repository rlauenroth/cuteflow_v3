cf.workfloweditSlot = function(){return {
	
	theFieldset				:false,
	theUniqueId				:false,
	theFielUniqueId			:false,
	
	
	init:function(data) {
		this.theUniqueId = 0;
		this.theFielUniqueId = 0;
		this.initSlotFieldset();
		for(var a=0;a<data.length;a++) {
			var slot = data[a];
			var columnPanel = this.createColumnpanel(slot.isdisabled);
			var fieldset = this.initFieldset(slot.slotname, slot.workflowslot_id);
			
			var leftPanel = this.createPanel();		
			var rightPanel = this.createPanel();
			var attachment = this.createAttachment();
		
				
			for(var b=0;b<slot.fields.length;b++) {
				var field = slot.fields[b];	
				if(field.color == null) {
					field.color = '';
				}
				switch (field.type) {
					case "TEXTFIELD":
						var label = this.createTextfield(field.workflowslotfield_id, field.fieldname, field.items.value, field.writeprotected, field.color, field.items.regex);
						field.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
					    break;
					case "CHECKBOX":
						var label = this.createCheckbox(field.workflowslotfield_id,field.fieldname, field.items.value, field.writeprotected, field.color);
						field.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
					    break;
					case "NUMBER":
						var label = this.createNumber(field.workflowslotfield_id, field.fieldname, field.items.value, field.writeprotected, field.color, field.items.regex,field.items.emptytext );
						field.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
					    break;
					case "TEXTAREA":
						var label = this.createTextarea(field.workflowslotfield_id, field.fieldname, field.items.value, field.writeprotected, field.color,field.items.contenttype );
						field.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
					    break;
					case "DATE":
						var label = this.createDatefield(field.workflowslotfield_id, field.fieldname, field.items.value, field.writeprotected, field.color ,field.items.dateformat);
						field.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
					    break;
					case "RADIOGROUP":
						var label = this.createRadiogroup(field.workflowslotfield_id, field.fieldname, field.items, field.writeprotected, field.color);
						field.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
					    break;
	    			case "CHECKBOXGROUP":
						var label = this.createCheckboxgroup(field.workflowslotfield_id, field.fieldname, field.items, field.writeprotected, field.color);
						field.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
					    break;
	    			case "COMBOBOX":
						var label = this.createCombobox(field.workflowslotfield_id, field.fieldname, field.items, field.writeprotected, field.color);
						field.column == 'LEFT' ? leftPanel.add(label) : rightPanel.add(label);
					    break;
	    			case "FILE":
						var label = this.createFile(field.items.link);
						attachment.add(label);
						if(slot.isdisabled == 1) {
							attachment.setVisible(false);
						}
						else {
							attachment.setVisible(true);
						}
					    break;
				}
			}
			columnPanel.add(leftPanel);
			columnPanel.add(rightPanel);
			fieldset.add(columnPanel);
			fieldset.add(attachment);
			this.theFieldset.add(fieldset);
		}
		this.theFieldset.doLayout();
	},
	
	
	createTextfield: function (id, name, value, writeprotected, color, regex) {
		
		var disabled = writeprotected == 1 ? true : false;
		var textfield = new Ext.form.TextField({
			fieldLabel: name,
			disabled: disabled,
			value: value,
			id: 'TEXTFIELD__' + id,
			name: 'REGEX__' + regex,
			width: 200
		});
		if (color != '' && color != '#FFFFFF') {
			textfield.style = 'background-color: '+color+'; background-image:none;';
		}
		return textfield;
	},

	createAttachment: function () {
		var theFieldset = new Ext.form.FieldSet({
			title: '<table><tr><td><img src="/images/icons/attach.png" /> </td><td><?php echo __('Attachments',null,'workflowmanagement'); ?></td></tr></table>',
			frame:false,
			autoScroll: true,
			hidden: true,
		    width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 180,
		    height:'auto'
		});
		return theFieldset;
		
	},
	
	
	createFile: function (link) {
		var id = cf.workfloweditSlot.theFielUniqueId++;
		var label = new Ext.form.Label({
			html: '<table><tr><td><img src="/images/icons/attach.png" /> </td><td>'+ link +'</td></tr></table>',
			id: 'FILE__' + id,
			style: 'font-size:14px;'
		});
		return label;
		
	},
	
	createCombobox: function (id, name, items, writeprotected, color) {
		var disabled = writeprotected == 1 ? true : false;
		var combo =  new Ext.form.ComboBox({
			fieldLabel: name,
			valueField: 'value',
			displayField: 'text',
			editable: false,
			disabled: disabled,
			mode: 'local',
			store: new Ext.data.SimpleStore({
				fields: [
					{name: 'value'},
					{name: 'text'}
				]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			id: 'COMBOBOX__' + id,
			allowBlank: true,
			width:200,
			forceSelection:true
		});
		var activeId = -1;
		for(var a=0;a<items.length;a++){
			var item = items[a];
			var Rec = Ext.data.Record.create({name: 'value'},{name: 'text'});
			combo.store.add(new Rec({value: item.id, text: item.name}));
			if(item.value == 1) {
				activeId = item.id;
			}
		}
		
		if(activeId != -1) {
			combo.setValue(activeId);
		}
		
		if (Ext.isIE6 == true) {
			combo.style = 'margin-top:0px;margin-bottom:0px;';
		}	
		
		if (color != '' && color != '#FFFFFF') {
			combo.style = 'background-color: '+color+'; background-image:none;';
		}
		
		return combo;
		
	},
	
	
	createRadiogroup: function (id, name, items, writeprotected, color) {
		var store = new Array();
		var disabled = writeprotected == 1 ? true : false;
		for(var a=0;a<items.length;a++){
			var item = items[a];
			var activeitem = item.value == 1 ? true : false;
			var radio = new Ext.form.Radio({
				 boxLabel: item.name, 
				 checked: activeitem,
				 id: 'RADIOGROUPITEM__' + item.id,
				 name: 'RADIOGROUP__' + id, 
				 inputValue: 1
			});
			store[a] = radio;
		}
		var radiogroup = new Ext.form.RadioGroup({
			id: 'RADIOGROUP__' + id,
			fieldLabel: name,
			disabled: disabled,
			items:[store]			
		});
		
		if (color != '' && color != '#FFFFFF') {
			radiogroup.style = 'background-color: '+color+'; background-image:none;';
		}
		return radiogroup;
	},
	
	createCheckboxgroup: function (id, name, items, writeprotected, color) {
		var store = new Array();
		var disabled = writeprotected == 1 ? true : false;
		for(var a=0;a<items.length;a++){
			var item = items[a];
			var activeitem = item.value == 1 ? true : false;
			var radio = new Ext.form.Checkbox({
				 boxLabel: item.name, 
				 checked: activeitem,
				 id: 'CHECKBOXGROUPITEM__' + item.id,
				 name: 'CHECKBOXGROUP__' + id, 
				 inputValue: 1
			});
			store[a] = radio;
		}
		var radiogroup = new Ext.form.CheckboxGroup({
			id: 'CHECKBOXGROUP__' + id,
			fieldLabel: name,
			disabled: disabled,
			items:[store]			
		});
		if (color != '' && color != '#FFFFFF') {
			radiogroup.style = 'background-color: '+color+'; background-image:none;';
		}
		
		return radiogroup;
	},
	
	createDatefield: function (id, name, value, writeprotected, color, dateformat) {
		var disabled = writeprotected == 1 ? true : false;
		var textfield = new Ext.form.DateField({
			allowBlank:true,
			id: 'DATE__' + id,
			fieldLabel: name,
			format: dateformat,
			editable: false,
			disabled: disabled,
			value: value,
			width:200
		});	
		if (color != '' && color != '#FFFFFF') {
			textfield.style = 'background-color: '+color+'; background-image:none;';
		}
		return textfield;
	},
	
	createTextarea: function (id, name, value, writeprotected, color, contenttype) {
		var disabled = writeprotected == 1 ? true : false;
		if(contenttype == 'plain') {
			var textarea = new Ext.form.TextArea({
				fieldLabel: name,
				disabled: disabled,
				id: 'TEXTAREA__' + id,
				width: ((cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 180) / 2)-200,
				value: value,
				height: 150
			});
		}
		else {
			var textarea = new Ext.form.HtmlEditor({
				fieldLabel: name,
				id: 'TEXTAREA__' + id,
				disabled: disabled,
				width: ((cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 180) / 2)-200,
				value: value,
				height: 150
			});
		}
		if (color != '' && color != '#FFFFFF') {
			textarea.style = 'background-color: '+color+'; background-image:none;';
		}
		return textarea;
		
	},
	
	
	createCheckbox: function (id, name, value, writeprotected, color) {
		var checked = value == 1 ? true : false;
		var disabled = writeprotected == 1 ? true : false;
		var check = new Ext.form.Checkbox({
			 fieldLabel: name,
			 checked: checked,
			 disabled: disabled,
			 id: 'CHECKBOX__' + id,
			 style: 'margin-top:3px;margin-left:1px;',
			 inputValue: 1
		});
		if (color != '' && color != '#FFFFFF') {
			check.style = 'margin-top:3px;margin-left:1px;background-color: '+color+'; background-image:none;';
		}
		return check;
		
	},

	


	createNumber: function (id, name, value, writeprotected, color, regex, emptytext) {
		var disabled = writeprotected == 1 ? true : false;
		var textfield = new Ext.form.TextField({
			fieldLabel: name,
			disabled: disabled,
			value: value,
			id: 'NUMBER__' + id,
			name: 'REGEX__' + regex,
			emptyText: emptytext,
			width: 200
		});
		if (color != '' && color != '#FFFFFF') {
			textfield.style = 'background-color: '+color+'; background-image:none;';
		}
		return textfield;
	},

	
	initFieldset: function (slotname, id) {
		var theFieldset = new Ext.form.FieldSet({
			title: slotname,
			frame:false,
			autoScroll: true,
			style: 'margin-top:5px;margin-left:10px;margin-right:10px;',
			id: 'WORKFLOWSLOTID__' + id,
			width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 140,
			height: 'auto'
		});
		return theFieldset;
	},
	
	
	initSlotFieldset: function () {
		this.theFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Available slots to edit',null,'workflowmanagement'); ?>',
			autoScroll: false,
			style: 'margin-top:5px;margin-left:10px;',
			width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 100,
			height: 'auto'
		});
		
	},
	
	createPanel: function () {
		var panel = new Ext.Panel({
			frame:false,
			layout: 'form',
			style: 'border:none;',
			border: false,
			autoScroll: false,
			width: (cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 210) / 2,
			height: 'auto'
		});	
		return panel;
	},
	
	createColumnpanel: function (disabled) {
		var disabled = disabled == 1 ? true : false;
		var panel = new Ext.Panel({
		    layout: 'column',
		    width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 180,
		    height:'auto',
		    frame:false,
		    autoScroll:true,
		    disabled: disabled,
			border: false,
			style:'border:none;',
			layoutConfig: {
				columns: 2,
				fitHeight: true,
				split: true
			}
		});
		return panel;
	}
	
	
	
	
	
	
	
	
	
};}();