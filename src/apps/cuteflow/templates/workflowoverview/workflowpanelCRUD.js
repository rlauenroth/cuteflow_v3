cf.workflowmanagementPanelCRUD = function(){return {
	
	theLoadingMask					:false,
	
	stopWorkflow: function (workflow_id, version_id) {
		cf.workflowmanagementPanelCRUD.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Stopping workflow...',null,'workflowmanagement'); ?>'});					
		cf.workflowmanagementPanelCRUD.theLoadingMask.show();
		
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('workflowoverview/StopWorkflow')?>/versionid/' + version_id + '/workflowtemplateid/' + workflow_id,
			success: function(objServerResponse){
				cf.workflowmanagementPanelCRUD.reloadAll();
				cf.workflowmanagementPanelCRUD.theLoadingMask.hide();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>', '<?php echo __('Workflow stopped',null,'workflowmanagement'); ?>');
			}
		});
	},
	
	
	startWorkflow: function (version_id) {
		cf.workflowmanagementPanelCRUD.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Starting workflow...',null,'workflowmanagement'); ?>'});					
		cf.workflowmanagementPanelCRUD.theLoadingMask.show();
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('workflowoverview/StartWorkflow')?>/versionid/' + version_id,
			success: function(objServerResponse){
				cf.workflowmanagementPanelCRUD.reloadAll();
				cf.workflowmanagementPanelCRUD.theLoadingMask.hide();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>', '<?php echo __('Workflow has been started',null,'workflowmanagement'); ?>');
			}
		});	
		
	},
	
	
	deleteWorkflow: function (workflow_id, version_id) {
		cf.workflowmanagementPanelCRUD.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Deleting workflow...',null,'workflowmanagement'); ?>'});					
		cf.workflowmanagementPanelCRUD.theLoadingMask.show();
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('workflowoverview/DeleteWorkflow')?>/versionid/' + version_id + '/workflowtemplateid/' + workflow_id,
			success: function(objServerResponse){
				cf.workflowmanagementPanelCRUD.reloadAll();
				cf.workflowmanagementPanelCRUD.theLoadingMask.hide();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>', '<?php echo __('Workflow deleted',null,'workflowmanagement'); ?>');
			}
		});
		
	},
	
	archiveWorkflow: function (workflow_id, version_id) {
		cf.workflowmanagementPanelCRUD.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Archive workflow...',null,'workflowmanagement'); ?>'});					
		cf.workflowmanagementPanelCRUD.theLoadingMask.show();
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('workflowoverview/ArchiveWorkflow')?>/versionid/' + version_id + '/workflowtemplateid/' + workflow_id,
			success: function(objServerResponse){
				cf.workflowmanagementPanelCRUD.reloadAll();
				cf.workflowmanagementPanelCRUD.theLoadingMask.hide();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>', '<?php echo __('Workflow archived',null,'workflowmanagement'); ?>');
			}
		});
	},
	
	
	reloadAll: function () {
		try {
			cf.todoPanelGrid.theTodoStore.reload();
		}	
		catch(e) {
			
		}
		
		try {
			cf.archiveWorkflow.theArchiveStore.reload();
		}
		catch(e) {
			
		}
		try{
			cf.workflowmanagementPanelGrid.theWorkflowStore.reload();
		}
		catch(e){
			
		}
	}
	
	
	
	
	
	
	
};}();