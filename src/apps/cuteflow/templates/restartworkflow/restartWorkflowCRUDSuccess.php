cf.restartWorkflowCRUD = function(){return {
	
	
	doSubmit: function (versionid) {
		Ext.getCmp('restartWorkflowFirstTab_fieldset2').expand();
		Ext.getCmp('restartWorkflowFirstTab_fieldset3').expand();
		Ext.getCmp('restartWorkflowFirstTab_fieldset1').expand();
		cf.restartWorkflowFirstTab.theFirstTabPanel.getForm().submit({
			url: '<?php echo build_dynamic_javascript_url('restartworkflow/RestartWorkflow')?>/versionid/' + versionid,
			method: 'POST',
			waitMsg: '<?php echo __('Saving Data',null,'usermanagement'); ?>',
			success: function(objServerResponse){
				cf.workflowmanagementPanelGrid.theWorkflowStore.reload();
				cf.restartWorkflowWindow.theRestartWorkflowWindow.hide();
				cf.restartWorkflowWindow.theRestartWorkflowWindow.destroy();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>','<?php echo __('Workflow restarted',null,'workflowmanagement'); ?>');
				try {
					cf.todoPanelGrid.theTodoStore.reload();
				}
				catch(e) {
					
				}

			},
			failure: function(objServerResponse){
				cf.workflowmanagementPanelGrid.theWorkflowStore.reload();
				cf.restartWorkflowWindow.theRestartWorkflowWindow.hide();
				cf.restartWorkflowWindow.theRestartWorkflowWindow.destroy();
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>','<?php echo __('Workflow restarted',null,'workflowmanagement'); ?>');
				try {
					cf.todoPanelGrid.theTodoStore.reload();
				}
				catch(e) {
					
				}

			}
		});
	}
	
	
	
	
	
};}();