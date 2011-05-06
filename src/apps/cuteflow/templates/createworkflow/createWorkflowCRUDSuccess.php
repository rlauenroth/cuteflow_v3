cf.createWorkflowCRUD = function(){return {
	
	theNumberRegEx 					: '^(NUMBER_){1}[0-9]{1,}(_){1}[0-9]{1,}$',
	theTextfieldRegEx 				: '^(TEXTFIELD_){1}[0-9]{1,}(_){1}[0-9]{1,}$',
	theTextareaRegEx 				: '^(TEXTAREA_){1}[0-9]{1,}(_){1}[0-9]{1,}$',
	theFilefieldRegEx 				: '^(FILE_){1}[0-9]{1,}(_){1}[0-9]{1,}$',
	theLoadingMask					: false,
	
	theSavePanel					: false,
	
	createSavePanel: function () {
		this.initSavePanel();
		var slotcounter = 0;
		var fieldcounter = 0;
		
		var userPanel = cf.createWorkflowSecondTab.theLeftPanel;
		var fieldPanel = cf.createWorkflowThirdTab.theThirdPanel;
		for(var a=0;a<userPanel.items.length;a++) {
			var fieldsetUser = userPanel.getComponent(a);
			var fieldsetField = fieldPanel.getComponent(a);
			var slot_id = fieldsetUser.getId().replace('WORKFLOWUSERSLOT_','');
			var usergrid = fieldsetUser.getComponent(0);
			for(var b=0;b<usergrid.store.getCount();b++) { // save the users in the slots
				var row = usergrid.getStore().getAt(b);	
				var hiddenfield = new Ext.form.Field({
					autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][user]['+b+'][id]', value:row.data.id, width: 0}			
				});
				cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);	
			}
			
			
			var columnPanel = fieldsetField.getComponent(0); // save the fields in the slots
			var leftPanel = columnPanel.getComponent(0);
			var rightPanel = columnPanel.getComponent(1);
			for(var c=0;c<leftPanel.items.length;c++) {
				var leftItem = leftPanel.getComponent(c);
				var leftId = leftItem.getId().split('_');
				this.checkField(slotcounter, leftId, leftItem, fieldcounter);
				fieldcounter++;
				
				try {
					var rightItem = rightPanel.getComponent(c); 
					var rightId = rightItem.getId().split('_');
					this.checkField(slotcounter, rightId, rightItem, fieldcounter);
					fieldcounter++;
				}
				catch(e) {}

				
			}
			
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][id]', value:slot_id, width: 0}			
			});
			cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
			slotcounter++;
		}
		
		cf.createWorkflowWindow.theFormPanel.add(this.theSavePanel);
		cf.createWorkflowWindow.theFormPanel.doLayout();
		cf.createWorkflowCRUD.theLoadingMask.hide();
		this.doSubmit();	
	},
	
	
	
	checkField: function (slotcounter, fieldId, panel, fieldcounter) {
		switch (fieldId[0]) {
			case "TEXTFIELD":
				this.addTextfield(slotcounter, fieldId, panel, fieldcounter);
			    break;
			case "CHECKBOX":
				this.addCheckbox(slotcounter, fieldId, panel, fieldcounter);
				break;
			case "NUMBER":
				this.addTextfield(slotcounter, fieldId, panel, fieldcounter);
				break;
			case "DATE":
				this.addDatefield(slotcounter, fieldId, panel, fieldcounter);
				break;
			case "TEXTAREA":
				this.addTextfield(slotcounter, fieldId, panel, fieldcounter);
				break;
			case "RADIOGROUP":
				this.addGroup(slotcounter, fieldId, panel, fieldcounter);
				break;
			case "CHECKBOXGROUP":
				this.addGroup(slotcounter, fieldId, panel, fieldcounter);
				break;
			case "COMBOBOX":
				this.addCombo(slotcounter, fieldId, panel, fieldcounter);
				break;
			case "FILE":
				this.addFile(slotcounter, fieldId, panel, fieldcounter);
				break;
		}
		
		
	},
	
	addDatefield: function (slotcounter,fieldid, field, fieldcounter) {
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][field_id]', value:fieldid[1], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][type]', value:fieldid[0], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][value]', value:field.getRawValue(), width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);	
	},
	
	
	addFile: function (slotcounter,fieldid, field, fieldcounter) {
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][field_id]', value:fieldid[1], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][type]', value:fieldid[0], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		
		var theValue = field.getId().replace('_REGEX', '');
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][filearray]', value:theValue, width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		cf.createWorkflowWindow.theFormPanel.doLayout();
		
	},
	
	addCombo: function (slotcounter,fieldid, field, fieldcounter) {
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][field_id]', value:fieldid[1], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][type]', value:fieldid[0], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		for(var a=0;a<field.store.getCount();a++) {
			var row = field.getStore().getAt(a);
			var value = row.data.value == field.getValue() ? true : false;
			if(field.getValue() == '') {
				var value = false;
			}
			else {
				var value = field.getValue() == row.data.value ? true : false;
			}
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][item]['+a+'][value]', value:value, width: 0}			
			});
			cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][item]['+a+'][id]', value:row.data.value, width: 0}			
			});
			cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
			
		}
	},
	
	addGroup: function (slotcounter,fieldid, field, fieldcounter) {
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][field_id]', value:fieldid[1], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][type]', value:fieldid[0], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		for(var a=0;a<field.items.length;a++) {
			var item = field.items.get(a);
			var itemid = item.getId().split('_');
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][item]['+a+'][value]', value:item.getValue(), width: 0}			
			});
			cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][item]['+a+'][id]', value:itemid[2], width: 0}			
			});
			cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);	
		}
	},
	
	
	addTextfield: function (slotcounter,fieldid, field, fieldcounter) {
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][field_id]', value:fieldid[1], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][type]', value:fieldid[0], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][value]', value:field.getValue(), width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);	
	},
	
	addCheckbox: function (slotcounter, fieldid, field, fieldcounter) {
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][field_id]', value:fieldid[1], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][type]', value:fieldid[0], width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'slot['+slotcounter+'][slot][field]['+fieldcounter+'][value]', value:field.getValue(), width: 0}			
		});
		cf.createWorkflowCRUD.theSavePanel.add(hiddenfield);	
	},
	
	
	initSavePanel: function () {
		this.theSavePanel = new Ext.Panel({});
	},
	
	doSubmit: function () {
		cf.createWorkflowCRUD.theLoadingMask.hide();
		cf.createWorkflowWindow.theTabPanel.setActiveTab(0);
		Ext.getCmp('createWorkflowFirstTab_fieldset1').expand();
		Ext.getCmp('createWorkflowFirstTab_fieldset2').expand();
		Ext.getCmp('createWorkflowFirstTab_fieldset3').expand();
		cf.createWorkflowWindow.theFormPanel.getForm().submit({
			url: '<?php echo build_dynamic_javascript_url('createworkflow/CreateWorkflow')?>',
			method: 'POST',
			waitMsg: '<?php echo __('Saving Data',null,'workflowmanagement'); ?>',
			success: function(objServerResponse){
				cf.workflowmanagementPanelGrid.theWorkflowStore.reload();
				cf.createWorkflowWindow.theCreateWorkflowWindow.hide();
				cf.createWorkflowWindow.theCreateWorkflowWindow.destroy();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>','<?php echo __('Workflow created',null,'workflowmanagement'); ?>');
				try {
					cf.todoPanelGrid.theTodoStore.reload();
				}
				catch(e) {
					
				}
			},
			failure: function(objServerResponse){
				cf.workflowmanagementPanelGrid.theWorkflowStore.reload();
				cf.createWorkflowWindow.theCreateWorkflowWindow.hide();
				cf.createWorkflowWindow.theCreateWorkflowWindow.destroy();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>','<?php echo __('Workflow created',null,'workflowmanagement'); ?>');
				try {
					cf.todoPanelGrid.theTodoStore.reload();
				}
				catch(e) {
					
				}
			}
		});
	},
	
	
	
	
	
	
	initSave: function () {
		
		cf.createWorkflowCRUD.theLoadingMask = new Ext.LoadMask(cf.createWorkflowWindow.theCreateWorkflowWindow.body, {msg:'<?php echo __('Preparing Data...',null,'workflowmanagement'); ?>'});					
		cf.createWorkflowCRUD.theLoadingMask.show();
		if(cf.createWorkflowWindow.theTabPanel.items.length>1) {
			cf.createWorkflowWindow.theTabPanel.setActiveTab(0);
			var checkedGeneralSettings = this.checkSettings();
			if(checkedGeneralSettings == true) {
				cf.createWorkflowWindow.theTabPanel.setActiveTab(1);
				var checkedUsers = this.checkUser();
				if(checkedUsers == true) {
					cf.createWorkflowWindow.theTabPanel.setActiveTab(2);
					var checkedFields = this.checkFields();
					if(checkedFields == true) {
						//cf.createWorkflowCRUD.theLoadingMask.hide();
						cf.createWorkflowCRUD.createSavePanel.defer(3500,this,[]);
					}
				}
			}
		}
		else {
			var checkedFields = false;
			var checkedUsers = false;
			var checkedGeneralSettings = false;
			Ext.Msg.minWidth = 400;
			cf.createWorkflowCRUD.theLoadingMask.hide();
			Ext.MessageBox.alert('<?php echo __('Error',null,'workflowmanagement'); ?>','<?php echo __('Please select a Mailinglist',null,'workflowmanagement'); ?>');
			cf.createWorkflowWindow.theTabPanel.setActiveTab(0);
			
		}
	},
	
	
	
	checkSettings: function () {
		var name = cf.createWorkflowFirstTab.theNameTextfield.getValue();
		var mailinglist = cf.createWorkflowFirstTab.theMailinglist.getValue();
		if(name == '' || mailinglist == '') {
			Ext.Msg.minWidth = 400;
			cf.createWorkflowCRUD.theLoadingMask.hide();
			Ext.MessageBox.alert('<?php echo __('Error',null,'workflowmanagement'); ?>','<?php echo __('Please set a workflow name',null,'workflowmanagement'); ?>');
			return false;
		}
		return true;
	},
	
	
	checkUser: function () {
		var panel = cf.createWorkflowSecondTab.theLeftPanel;
		if(panel.items.length > 0) {
			var users = true;
			for(var a=0;a<panel.items.length;a++) {
				var fieldset = panel.getComponent(a);
				var grid = fieldset.getComponent(0);
				if(grid.store.getCount() == 0) {
					Ext.Msg.minWidth = 400;
					Ext.MessageBox.alert('<?php echo __('Error',null,'workflowmanagement'); ?>','<?php echo __('Add some Users to your slots',null,'workflowmanagement'); ?>');
					users = false;
				}
			}
			if(users == false){
				cf.createWorkflowCRUD.theLoadingMask.hide();
			}
			return users;
		}
		else {
			users =  false;
			return users;
		}
		
	},
	
	
	checkFields: function () {
		var panel = cf.createWorkflowThirdTab.theThirdPanel;
		var failureStore = new Array();
		var counter = 0;
		var failure_flag = false;
		for(var a=0;a<panel.items.length;a++) {
			var fieldset = panel.getComponent(a);
			var columnpanel = fieldset.getComponent(0);
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
		if(failure_flag == true) {
			var failureString = '';
			for(var d=0;d<failureStore.length;d++) {
				failureString += failureStore[d];
				Ext.Msg.minWidth = 400;
				Ext.MessageBox.alert('<?php echo __('Error',null,'workflowmanagement'); ?>','<table>' + failureString + '</table>');
			}
			cf.createWorkflowCRUD.theLoadingMask.hide();
			return false;
		}
		else {
			return true;
		}
	},
	
	
	checkComponent: function(component) {
		var component_id = component.getId();
		var number = new RegExp(cf.createWorkflowCRUD.theNumberRegEx,"m");
		var textfield = new RegExp(cf.createWorkflowCRUD.theTextfieldRegEx,"m");
		var textarea = new RegExp(cf.createWorkflowCRUD.theTextareaRegEx,"m");
		var file = new RegExp(cf.createWorkflowCRUD.theFilefieldRegEx,"m");
		
		if(number.test(component_id) == true) {
			var regEx = component.getName().replace('REGEX_', '');
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
			var regEx = component.getName().replace('REGEX_', '');
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
		else if(file.test(component_id) == true) {
			var compHidden = component.getId() + '_REGEX';
			var regEx = Ext.getCmp(compHidden).getValue();
			var regEx = regEx.replace('REGEX_','');
			var value = component.getValue();
			if(value == '') {
				return  '<tr><td width="100"><b>' + component.fieldLabel + ':</b></td><td><?php echo __('No attachment selected',null,'workflowmanagement'); ?></td></tr>'; 
			}
			else {
				if(regEx != '') {
					try{	
						var regCheck = new RegExp(regEx,"m");
						if(regCheck.test(value) == true) {
							return true;
						}
						else {
							return  '<tr><td width="100"><b>' + component.fieldLabel + ':</b></td><td><?php echo __('Attachment is not correct',null,'workflowmanagement'); ?></td></tr>'; 
						}
					}
					catch(e) {
						return  '<tr><td width="100"><b>' + component.fieldLabel + ':</b></td><td><?php echo __('Regular Expression is not correct',null,'workflowmanagement'); ?></td></tr>';
					}
				}
				else {
					return true;
				}
				
			}
		}
		else {
			return true;
		}		
	}
	
	
	
	
	
	
};}();