cf.todoPanelCRUD = function(){return {
	
	
	
	stopWorkflow: function (workflow_id, version_id) {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('workflowoverview/StopWorkflow')?>/versionid/' + version_id + '/workflowtemplateid/' + workflow_id,
			success: function(objServerResponse){
				cf.workflowmanagementPanelGrid.theWorkflowStore.reload();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>', '<?php echo __('Workflow stopped',null,'workflowmanagement'); ?>');
			}
		});
		
		
		
	}
	
	
	
	
	
	
};}();