cf.workflowedit = function(){return {
	
	theLoadingMask				:false,
	thePopUpWindow				:false,
	thePanel					:false,
	theLeftPanel				:false,
	theHiddenfield				:false,
	
	
	init: function (workflow_template_id, version_id) {
		cf.workflowedit.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Data...',null,'workflowmanagement'); ?>'});					
		cf.workflowedit.theLoadingMask.show();
		
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('workflowedit/LoadWorkflowData')?>/versionid/' + version_id + '/workflowtemplateid/' + workflow_template_id,
			success: function(objServerResponse){
				cf.workflowedit.initPanel();
				var ServerResult = Ext.util.JSON.decode(objServerResponse.responseText);
				var generalData = ServerResult.generalData;
				var slotData = ServerResult.slotData;
				var attachments = ServerResult.workflowAttachment;
				var userData = ServerResult.userData;
				var showNames = ServerResult.showName;
				cf.workflowedit.initWindow(workflow_template_id, version_id);
				cf.workflowedit.initLeftNavi();
				
				cf.workfloweditGeneral.init(generalData, workflow_template_id);
				cf.workfloweditSlot.init(slotData);
				cf.workfloweditAcceptWorkflow.init();
				cf.workfloweditAttachments.init(attachments);
				cf.workfloweditHiddenPanel.init(userData, showNames);
				
				
				cf.workflowedit.thePanel.add(cf.workfloweditGeneral.theFieldset);
				cf.workflowedit.thePanel.add(cf.workfloweditAcceptWorkflow.theFieldset);
				cf.workflowedit.thePanel.add(cf.workfloweditAttachments.theFieldset);
				cf.workflowedit.thePanel.add(cf.workfloweditSlot.theFieldset);
				
				cf.workflowedit.theLeftPanel.add(cf.workfloweditHiddenPanel.theGrid);
				
				cf.workflowedit.thePopUpWindow.add(cf.workflowedit.theLeftPanel);
				cf.workflowedit.thePopUpWindow.add(cf.workflowedit.thePanel);
				cf.workflowedit.thePopUpWindow.doLayout();
				cf.workflowedit.thePopUpWindow.show();
				
				cf.workflowedit.theLoadingMask.hide();
			}
		});
		
	},
	
	initLeftNavi: function () {
		<?php $settings = SystemSetting::getShowPositionInMail(); ?>
		this.theLeftPanel = new Ext.Panel({
            title: '<?php echo __('Current Position',null,'workflowmanagement'); ?>',
            region: 'west',
            split: true,
            width: 280,
            hidden: <?php echo $settings['hidden']; ?>,
            collapsed:true,
            collapsible: <?php echo $settings['collapsible']; ?>,
            margins:'3 0 3 3',
            cmargins:'3 3 3 3'
		});
		
		
	},
	
	initPanel: function () {
		this.thePanel = new Ext.FormPanel({
			frame: true,
			region: 'center',
			width: 'auto',
			autoScroll:true,
			height: 'auto'
		});	
		
	},
	
	initWindow: function (workflow_template_id, version_id) {
		this.thePopUpWindow = new Ext.Window({
			modal: true,
			closable: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 40,
			width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 40,
			autoScroll: false,
			title: '<?php echo __('Edit workflow',null,'workflowmanagement'); ?>',
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: false,
	        layout: 'border',
	        buttonAlign: 'center',
			buttons:[{
				text:'<?php echo __('Store',null,'documenttemplate'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () {
					cf.workfloweditCRUD.createSavePanel(workflow_template_id, version_id);
				}
			},{
				text:'<?php echo __('Close',null,'documenttemplate'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {
					cf.workflowedit.thePopUpWindow.hide();
					cf.workflowedit.thePopUpWindow.destroy();
				}
			}],
			close : function(){
				cf.workflowedit.thePopUpWindow.hide();
				cf.workflowedit.thePopUpWindow.destroy();
			}
		});
	}
	
	
	
	
	
	
	
	
	
	
};}();