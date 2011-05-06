cf.archivePanelCRUD = function(){return {
	
	theLoadingMask					:false,
	
	removeFromArchive: function (workflow_id, version_id) {
		cf.todoPanelCRUD.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Moving workflow...',null,'workflowmanagement'); ?>'});					
		cf.todoPanelCRUD.theLoadingMask.show();
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('archiveoverview/RemoveFromArchive')?>/versionid/' + version_id + '/workflowtemplateid/' + workflow_id,
			success: function(objServerResponse){
				cf.archiveWorkflow.theArchiveStore.reload();
				try {
					cf.workflowmanagementPanelGrid.theWorkflowGrid.reload();
				}
				catch(e) {
					
				}
				cf.todoPanelCRUD.theLoadingMask.hide();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>', '<?php echo __('Workflow moved',null,'workflowmanagement'); ?>');
			}
		});
	}
	
	
	
	
	
	
};}();