cf.workfloweditCRUD = function(){return {	
	
	thePanel						: false,
	theNumberRegEx 					: '^(NUMBER__){1}[0-9]{1,}$',
	theTextfieldRegEx 				: '^(TEXTFIELD__){1}[0-9]{1,}$',
	theTextareaRegEx 				: '^(TEXTAREA__){1}[0-9]{1,}$',
	theFilefieldRegEx 				: '^(FILE__){1}[0-9]{1,}$',
	
	
	
	
	
	
	createSavePanel: function (workflow_template_id, version_id) {
		this.initSavePanel();
		if (cf.workfloweditAcceptWorkflow.theHiddenField.getValue() == 1) {
			var check = false;
			check = this.checkFields();
			if(check == true) {
				this.addFieldsToPanel();
				this.doSubmit(workflow_template_id, version_id);
			}
		}
		else {
			cf.workfloweditCRUD.doSubmit(workflow_template_id, version_id);
		}
		
	},
	
	
	addFieldsToPanel: function() {
		var panel = cf.workfloweditSlot.theFieldset;
		var slotcounter = 0;
		var fieldcounter = 0;	
		
		for(var a=0;a<panel.items.length;a++) {
			var fieldset = panel.getComponent(a);
			var columnpanel = fieldset.getComponent(0);
			
			if(columnpanel.disabled == false) {
				var workflow_slot_id = fieldset.getId().split('__');

				var leftPanel = columnpanel.getComponent(0);
				var rightPanel = columnpanel.getComponent(1);
				
				var hiddenfield = new Ext.form.Field({
					autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][workflow_slot_id]', value:workflow_slot_id[1], width: 0}			
				});
				slotcounter++;
				cf.workfloweditCRUD.thePanel.add(hiddenfield);
				
				for(var c=0;c<leftPanel.items.length;c++) {
					var leftItem = leftPanel.getComponent(c);
					var leftId = leftItem.getId().split('__');
					this.checkField(leftId, leftItem, fieldcounter);
					fieldcounter++;
					
					try {
						var rightItem = rightPanel.getComponent(c); 
						var rightId = rightItem.getId().split('__');
						this.checkField(rightId, rightItem, fieldcounter);
						fieldcounter++;
					}
					catch(e) {}
				}
		
			}
		}
		this.thePanel.doLayout();
		cf.workflowedit.thePanel.add(this.thePanel);
		cf.workflowedit.thePanel.doLayout();
		
	},
	
	
	checkField: function (fieldId, panel, fieldcounter) {
		switch (fieldId[0]) {
			case "TEXTFIELD":
				this.addTextfield(fieldId, panel, fieldcounter);
			    break;
			case "CHECKBOX":
				this.addTextfield(fieldId, panel, fieldcounter);
				break;
			case "NUMBER":
				this.addTextfield(fieldId, panel, fieldcounter);
				break;
			case "DATE":
				this.addDatefield(fieldId, panel, fieldcounter);
				break;
			case "TEXTAREA":
				this.addTextfield(fieldId, panel, fieldcounter);
				break;
			case "RADIOGROUP":
				this.addGroup(fieldId, panel, fieldcounter);
				break;
			case "CHECKBOXGROUP":
				this.addGroup(fieldId, panel, fieldcounter);
				break;
			case "COMBOBOX":
				this.addCombo(fieldId, panel, fieldcounter);
				break;
			case "FILE":
				
				break;
		}
		//alert(fieldId[0]);
	},
	
	
	addTextfield: function (fieldid, panel, fieldcounter) {
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][field_id]', value:fieldid[1], width: 0}			
		});
		cf.workfloweditCRUD.thePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][type]', value:fieldid[0], width: 0}			
		});
		cf.workfloweditCRUD.thePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][value]', value:panel.getValue(), width: 0}			
		});
		cf.workfloweditCRUD.thePanel.add(hiddenfield);
	},
	
	
	addDatefield: function (fieldid, panel, fieldcounter) {
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][field_id]', value:fieldid[1], width: 0}			
		});
		cf.workfloweditCRUD.thePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][type]', value:fieldid[0], width: 0}			
		});
		cf.workfloweditCRUD.thePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][value]', value:panel.getRawValue(), width: 0}			
		});
		cf.workfloweditCRUD.thePanel.add(hiddenfield);
	},
	
	addGroup: function (fieldid, panel, fieldcounter) {
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][field_id]', value:fieldid[1], width: 0}			
		});
		cf.workfloweditCRUD.thePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][type]', value:fieldid[0], width: 0}			
		});
		cf.workfloweditCRUD.thePanel.add(hiddenfield);
		for(var a=0;a<panel.items.length;a++) {
			var item = panel.items.get(a);
			var itemid = item.getId().split('__');
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][item]['+a+'][value]', value:item.getValue(), width: 0}			
			});
			cf.workfloweditCRUD.thePanel.add(hiddenfield);
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][item]['+a+'][id]', value:itemid[1], width: 0}			
			});
			cf.workfloweditCRUD.thePanel.add(hiddenfield);	
		}
		
	},
	
	addCombo: function (fieldid, panel, fieldcounter) {
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][field_id]', value:fieldid[1], width: 0}			
		});
		cf.workfloweditCRUD.thePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][type]', value:fieldid[0], width: 0}			
		});
		cf.workfloweditCRUD.thePanel.add(hiddenfield);
		for(var a=0;a<panel.store.getCount();a++) {
			var row = panel.getStore().getAt(a);
			var value = row.data.value == panel.getValue() ? true : false;
			if(panel.getValue() == '') {
				var value = false;
			}
			else {
				var value = panel.getValue() == row.data.value ? true : false;
			}
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][item]['+a+'][value]', value:value, width: 0}			
			});
			cf.workfloweditCRUD.thePanel.add(hiddenfield);
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'field['+fieldcounter+'][item]['+a+'][id]', value:row.data.value, width: 0}			
			});
			cf.workfloweditCRUD.thePanel.add(hiddenfield);
		}
		
	},
	
	
	
	checkFields: function () {
		var panel = cf.workfloweditSlot.theFieldset;
		var failureStore = new Array();
		var counter = 0;
		var failure_flag = false;
		for(var a=0;a<panel.items.length;a++) {
			var fieldset = panel.getComponent(a);
		    var columnpanel = fieldset.getComponent(0);

			if(columnpanel.disabled == false) {
				var leftColumn = columnpanel.getComponent(0);
				var rightColumn = columnpanel.getComponent(1);			
				var failure = true;
				
				for(var b=0;b<leftColumn.items.length;b++) {
					var component = leftColumn.getComponent(b);
					var failure = this.checkComponent(component);
					if(failure != true) {
						failureStore[counter++] = failure;
						failure_flag = true;
					}
				}
				for(var c=0;c<rightColumn.items.length;c++) {
					var component = rightColumn.getComponent(c);
					var failure = this.checkComponent(component);
					if(failure != true) {
						failureStore[counter++] = failure;
						failure_flag = true;
					}
				}
			}
		}
		if(failure_flag == true) {
			var failureString = '';
			for(var d=0;d<failureStore.length;d++) {
				failureString += failureStore[d];
				Ext.Msg.minWidth = 400;
				Ext.MessageBox.alert('<?php echo __('Error',null,'workflowmanagement'); ?>','<table>' + failureString + '</table>');
			}
			return false;
		}
		else {
			return true;
		}
	},
	
	
	
	
	checkComponent: function(component) {
		var component_id = component.getId();
		var number = new RegExp(cf.workfloweditCRUD.theNumberRegEx,"m");
		var textfield = new RegExp(cf.workfloweditCRUD.theTextfieldRegEx,"m");
		var textarea = new RegExp(cf.workfloweditCRUD.theTextareaRegEx,"m");
		
		
		if(number.test(component_id) == true) {
			var regEx = component.getName().replace('REGEX__', '');
			var value = component.getValue();
			if(regEx != 'null' && value != '') {
				try{
					var regCheck = new RegExp(regEx,"m");
					if(regCheck.test(value) == true) {
						return true;
					}
					else {
						return  '<tr><td width="100"><b>' + component.fieldLabel + ':</b></td><td><?php echo __('Numberformat is not correct',null,'workflowmanagement'); ?></td></tr>';
					}
				}
				catch(e) {
					return  '<tr><td width="100"><b>' + component.fieldLabel + ':</b></td><td><?php echo __('Regular Expression is not correct',null,'workflowmanagement'); ?></td></tr>';
				}
			}	
			return true;
		}
		else if(textfield.test(component_id) == true) {
			var regEx = component.getName().replace('REGEX__', '');
			var value = component.getValue();
			if(regEx != 'null' && value != '') {
				try{
					var regCheck = new RegExp(regEx,"m");
					if(regCheck.test(value) == true) {
						return true;
					}
					else {
						return  '<tr><td width="100"><b>' + component.fieldLabel + ':</b></td><td><?php echo __('Textfieldvalue is not correct',null,'workflowmanagement'); ?></td></tr>';
					}
				}
				catch(e) {
					return  '<tr><td width="100"><b>' + component.fieldLabel + ':</b></td><td><?php echo __('Regular Expression is not correct',null,'workflowmanagement'); ?></td></tr>';
				}
			}
			return true;
			
		}
		else {
			return true;
		}		
	},
	
	
	initSavePanel: function () {
		this.thePanel = new Ext.Panel({
			
		});
	},
	
	
	
	
	
	
	doSubmit: function(workflow_template_id, version_id) {
		cf.workflowedit.thePanel.getForm().submit({
			url: '<?php echo build_dynamic_javascript_url('workflowedit/SaveWorkflow')?>/workflowid/' + workflow_template_id + '/versionid/' + version_id,
			method: 'POST',
			waitMsg: '<?php echo __('Saving Data',null,'workflowmanagement'); ?>',
			success: function(objServerResponse){
				try {
					cf.todoPanelGrid.theTodoStore.reload();
				}
				catch(e) {
					
				}
				try {
					cf.workflowmanagementPanelGrid.theWorkflowGrid.reload();
				}
				catch(e) {
					
				}
				cf.workflowedit.thePopUpWindow.hide();
				cf.workflowedit.thePopUpWindow.destroy();
				Ext.Msg.minWidth = 300;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>','<?php echo __('Workflow saved',null,'workflowmanagement'); ?>');

			}
		});
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
};}();