cf.workflowFilterCRUD = function(){return {

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
					if(cf.workflowFilterCRUD.theTextfield.getValue() != '') {
						cf.workflowFilterCRUD.save();
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
					cf.workflowFilterCRUD.theWindow.hide();
					cf.workflowFilterCRUD.theWindow.destroy();
				}
			}]
		});
		this.theWindow.on('close', function() {
			cf.workflowFilterCRUD.theWindow.hide();
			cf.workflowFilterCRUD.theWindow.destroy();
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
		cf.workflowFilterPanel.theHiddenFilterName.setValue(cf.workflowFilterCRUD.theTextfield.getValue());
		
		cf.workflowFilterPanel.theSearchPanel.getForm().submit({
			url: '<?php echo build_dynamic_javascript_url('filter/SaveFilter')?>',
			method: 'POST',
			waitMsg: '<?php echo __('Saving Data',null,'workflowmanagement'); ?>',
			success: function(objServerResponse){
				cf.workflowFilterCRUD.reloadGrid();
				cf.workflowFilterCRUD.theWindow.hide();
				cf.workflowFilterCRUD.theWindow.destroy();
				cf.workflowFilterPanel.theHiddenFilterName.setValue();
			}
		});
	},
	
	
	deleteFilter: function (id) {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('filter/DeleteFilter')?>/id/' + id,
			success: function(objServerResponse){
				cf.workflowFilterCRUD.reloadGrid();
			}
		});
	},
	
	reloadGrid: function () {
		try {
			cf.workflowFilterFilter.theStore.reload();
		}
		catch(e) {
			
		}
		try {
			cf.workflowFilterFilter.theStore.reload();
		}
		catch(e) {
			
		}
		try {
			cf.workflowFilterFilter.theStore.reload();
		}
		catch(e) {
			
		}
		
		
		
	}

	
	
	
};}();