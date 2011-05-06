cf.todoFilterCRUD = function(){return {

	theWindow					:false,
	theTextfield				:false,
	
	
	initWindow: function () {
		this.theWindow = new Ext.Window({
			modal: true,
			closable: true,
			modal: true,
			height: 100,
			width: 200,
			autoScroll: false,
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: false,
	        border:false,
			title:  '<?php echo __('Enter Filtername',null,'workflowmanagement'); ?>',
	        buttonAlign: 'center',
			buttons:[{
				text:'<?php echo __('Store',null,'workflowmanagement'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () {
					if(cf.todoFilterCRUD.theTextfield.getValue() != '') {
						cf.todoFilterCRUD.save();
					}
					else {
						Ext.Msg.minWidth = 200;
						Ext.MessageBox.alert('<?php echo __('Error',null,'workflowmanagement'); ?>','<?php echo __('Please enter Filtername',null,'workflowmanagement'); ?>');
					}
					
				}
			},{
				text:'<?php echo __('Close',null,'workflowmanagement'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {
					cf.todoFilterCRUD.theWindow.hide();
					cf.todoFilterCRUD.theWindow.destroy();
				}
			}]
		});
		this.theWindow.on('close', function() {
			cf.todoFilterCRUD.theWindow.hide();
			cf.todoFilterCRUD.theWindow.destroy();
		});
	},
	
	saveFilter: function () {
		this.initTextfield();
		this.initWindow();
		this.theWindow.add(this.theTextfield);
		this.theWindow.doLayout();
		this.theWindow.show();
	},
	
	
	initTextfield: function() {
		this.theTextfield = new Ext.form.TextField({
			allowBlank: false,
			style: 'margin-top:2px;',
			width: 187
		});
	},
	

	
	save: function () {
		cf.todoFilterPanel.theHiddenFilterName.setValue(cf.todoFilterCRUD.theTextfield.getValue());
		
		cf.todoFilterPanel.theSearchPanel.getForm().submit({
			url: '<?php echo build_dynamic_javascript_url('filter/SaveFilter')?>',
			method: 'POST',
			waitMsg: '<?php echo __('Saving Data',null,'workflowmanagement'); ?>',
			success: function(objServerResponse){
				cf.todoFilterCRUD.reloadGrid();
				cf.todoFilterCRUD.theWindow.hide();
				cf.todoFilterCRUD.theWindow.destroy();
				cf.todoFilterPanel.theHiddenFilterName.setValue();
			}
		});
	},
	
	
	deleteFilter: function (id) {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('filter/DeleteFilter')?>/id/' + id,
			success: function(objServerResponse){
				cf.todoFilterCRUD.reloadGrid();
			}
		});
	},
	
	reloadGrid: function () {
		try {
			cf.todoFilterFilter.theStore.reload();
		}
		catch(e) {
			
		}
		try {
			cf.workflowFilterFilter.theStore.reload();
		}
		catch(e) {
			
		}
		try {
			cf.archiveFilterFilter.theStore.reload();
		}
		catch(e) {
			
		}
		
		
		
	}

	
	
	
};}();