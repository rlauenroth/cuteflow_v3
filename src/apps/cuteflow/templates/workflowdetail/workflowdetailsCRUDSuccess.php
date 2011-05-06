cf.workflowdetailsCRUD = function(){return {
	
	theLoadingMask					:false,
	
	
	
	skipStation: function (id, templateversion_id, workflowslot_id, workflowuser_id) {
		cf.workflowdetailsCRUD.theLoadingMask = new Ext.LoadMask(cf.workflowdetails.thePanelToShow.body, {msg:'<?php echo __('Updating Data...',null,'workflowmanagement'); ?>'});					
		cf.workflowdetailsCRUD.theLoadingMask.show();
		
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('workflowdetail/SkipStation')?>/versionid/' + templateversion_id + '/workflowprocessuserid/' + id + '/workflowslotid/' + workflowslot_id + '/workflowslotuserid/' + workflowuser_id,
			success: function(objServerResponse){
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>', '<?php echo __('Station skipped',null,'workflowmanagement'); ?>');
				var ServerResult = Ext.util.JSON.decode(objServerResponse.responseText);
				var detailData = ServerResult.detailData;
				if(cf.workflowdetailsDetails.theWorkflowAdmin == false) {
					cf.workflowdetailsCRUD.theLoadingMask.hide();
					cf.workflowdetails.thePanelToShow.hide();
					cf.workflowdetails.thePanelToShow.destroy();
					cf.todoPanelGrid.theTodoStore.reload();
					try {
						cf.workflowmanagementPanelGrid.theWorkflowStore.reload();
					}
					catch(e){}
					
				}
				else {
					cf.workflowdetailsCRUD.reloadData(detailData);
				}
			}
		});
	},
	
	setUseragent: function (user_id, workflowuserprocessid, templateversion_id) {
		cf.workflowdetailsCRUD.theLoadingMask = new Ext.LoadMask(cf.workflowdetailsSelectUseragent.thePopUpWindow.body, {msg:'<?php echo __('Updating Data...',null,'workflowmanagement'); ?>'});					
		cf.workflowdetailsCRUD.theLoadingMask.show();
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('workflowdetail/SetUseragent')?>/userid/' + user_id + '/workflowprocessuserid/' + workflowuserprocessid + '/versionid/' + templateversion_id,
			success: function(objServerResponse){
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>', '<?php echo __('Useragent set',null,'workflowmanagement'); ?>');
				var ServerResult = Ext.util.JSON.decode(objServerResponse.responseText);
				var detailData = ServerResult.detailData;
				cf.workflowdetailsSelectUseragent.thePopUpWindow.hide();
				cf.workflowdetailsSelectUseragent.thePopUpWindow.destroy();
				if(cf.workflowdetailsDetails.theWorkflowAdmin == false) {
					cf.workflowdetailsCRUD.theLoadingMask.hide();
					cf.workflowdetails.thePanelToShow.hide();
					cf.workflowdetails.thePanelToShow.destroy();
					cf.todoPanelGrid.theTodoStore.reload();
					try {
						cf.workflowmanagementPanelGrid.theWorkflowStore.reload();
					}
					catch(e){}
					
				}
				else {
					cf.workflowdetailsCRUD.reloadData(detailData);
				}
			}
		});
		
	},
	
	resendStation: function (versionid, userid) {
		cf.workflowdetailsCRUD.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Sending Email...',null,'workflowmanagement'); ?>'});					
		cf.workflowdetailsCRUD.theLoadingMask.show();
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('workflowdetail/ResendEmail')?>/versionid/' + versionid + '/userid/' + userid,
			success: function(objServerResponse){
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>', '<?php echo __('Email send',null,'workflowmanagement'); ?>');
				cf.workflowdetailsCRUD.theLoadingMask.hide();
			}
		});
			
	},
	
	
	
	setNewStation: function (templateversion_id, newWorkflowUserSlotId, currentWorkflowUserSlotId, direction) {
		cf.workflowdetailsCRUD.theLoadingMask = new Ext.LoadMask(cf.workflowdetailsSelectStation.thePopUpWindow.body, {msg:'<?php echo __('Updating Data...',null,'workflowmanagement'); ?>'});					
		cf.workflowdetailsCRUD.theLoadingMask.show();
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('workflowdetail/SetNewStation')?>/newworkflowuserslotid/' + newWorkflowUserSlotId + '/currentworkflowuserslotid/' + currentWorkflowUserSlotId + '/versionid/' + templateversion_id + '/direction/' + direction,
			success: function(objServerResponse){
				Ext.Msg.minWidth = 200;
				Ext.MessageBox.alert('<?php echo __('OK',null,'workflowmanagement'); ?>', '<?php echo __('Station set',null,'workflowmanagement'); ?>');
				var ServerResult = Ext.util.JSON.decode(objServerResponse.responseText);
				var detailData = ServerResult.detailData;
				cf.workflowdetailsSelectStation.thePopUpWindow.hide();
				cf.workflowdetailsSelectStation.thePopUpWindow.destroy();
				if(cf.workflowdetailsDetails.theWorkflowAdmin == false) {
					cf.workflowdetailsCRUD.theLoadingMask.hide();
					cf.workflowdetails.thePanelToShow.hide();
					cf.workflowdetails.thePanelToShow.destroy();
					cf.todoPanelGrid.theTodoStore.reload();
					try {
						cf.workflowmanagementPanelGrid.theWorkflowStore.reload();
					}
					catch(e){}
					
				}
				else {
					cf.workflowdetailsCRUD.reloadData(detailData);
				}	
			}
		});
		
		
			
	},
	
	
	
	
	
	
	
	reloadData: function (detailData) {		
		try {
			cf.workflowdetailsDetails.theGrid.destroy();
			cf.workflowmanagementPanelGrid.theWorkflowStore.reload();
			cf.workflowdetailsDetails.initCM();
			cf.workflowdetailsDetails.initStore();
			cf.workflowdetailsDetails.initGrid(detailData);
			cf.workflowdetailsDetails.theFieldset.add(cf.workflowdetailsDetails.theGrid);
			cf.workflowdetailsDetails.theFieldset.doLayout();
			cf.workflowdetailsCRUD.theLoadingMask.hide();
			
		}
		catch(e) {
	
		}
		try {
			cf.todoPanelGrid.theTodoStore.reload();
		}
		catch(e) {
			
		}
	}
	
	
	
	
	
	
};}();