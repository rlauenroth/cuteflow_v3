/** init popupwindow to create/update a template **/
cf.mailinglistPopUpWindow = function(){return {
	
	theMailinglistPopUpWindow		:false,
	theLoadingMask					:false,
	theTabPanel						:false,

	/**
	* calls all necessary functions, to create a new form
	*@param int id, id of the record is empty, only set in editmode
	*/
	initNewMailinglist: function (id) {
		this.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Data...',null,'usermanagement'); ?>'});					
		this.theLoadingMask.show();
		cf.mailinglistFirstTab.init('<?php echo build_dynamic_javascript_url('mailinglist/Load')?>',id);
		cf.mailinglistThirdTab.init('<?php echo build_dynamic_javascript_url('mailinglist/LoadDefaultAuthorization')?>',id);
		this.initTabPanel();
		this.initWindow('','<?php echo __('Create new Mailing list',null,'mailinglist'); ?>');
		this.theTabPanel.add(cf.mailinglistFirstTab.theFormPanel);
		this.theTabPanel.add(cf.mailinglistThirdTab.thePanel);
		this.theMailinglistPopUpWindow.add(this.theTabPanel);
		this.theMailinglistPopUpWindow.doLayout();
		this.theMailinglistPopUpWindow.show();
		this.theTabPanel.setActiveTab(1);
		this.theTabPanel.setActiveTab(0);
		this.theLoadingMask.hide();
		
	},

	
	/**
	* calls all necessary functions, to edit a  form
	*@param int id, id is set
	*/
	initEdit: function (id, activeversion_id) {
		this.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Data...',null,'usermanagement'); ?>'});					
		this.theLoadingMask.show();
		cf.mailinglistFirstTab.init('<?php echo build_dynamic_javascript_url('mailinglist/LoadAuthorization')?>/id/'+activeversion_id,activeversion_id);
		cf.mailinglistThirdTab.init('<?php echo build_dynamic_javascript_url('mailinglist/LoadAuthorization')?>/id/'+activeversion_id,id);
		this.initTabPanel();
		this.initWindow(id,'<?php echo __('Edit existing Mailing list',null,'mailinglist'); ?>');
		this.theTabPanel.add(cf.mailinglistFirstTab.theFormPanel);
		this.theTabPanel.add(cf.mailinglistThirdTab.thePanel);
		this.theMailinglistPopUpWindow.add(this.theTabPanel);
		this.theMailinglistPopUpWindow.doLayout();
		this.theMailinglistPopUpWindow.show();
		this.theTabPanel.setActiveTab(1);
		this.theTabPanel.setActiveTab(0);
		this.addData(activeversion_id);
		this.theLoadingMask.hide();
		
	},
	
	/**
	* Load the data when in editmode
	*
	*@param int id, id of the record to edit
	*
	*/
	addData: function (id) {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('mailinglist/LoadSingleMailinglist')?>/id/' + id, 
			success: function(objServerResponse){
				theJsonTreeData = Ext.util.JSON.decode(objServerResponse.responseText);
				cf.mailinglistSecondTab.init(theJsonTreeData.result.documenttemplate_name);
				cf.mailinglistPopUpWindow.theTabPanel.add(cf.mailinglistSecondTab.thePanel);
				
				var Rec = Ext.data.Record.create({name: 'documenttemplate_id'},{name: 'name'});
				Ext.getCmp('mailinglistFirstTab_documenttemplate_id').store.add(new Rec({documenttemplate_id: theJsonTreeData.result.documenttemplate_id, name: theJsonTreeData.result.name})); 
				Ext.getCmp('mailinglistFirstTab_documenttemplate_id').setValue(theJsonTreeData.result.name);
				Ext.getCmp('mailinglistFirstTab_nametextfield').setValue(theJsonTreeData.result.documenttemplate_name);
				Ext.getCmp('mailinglistFirstTab_nametextfield').setDisabled(true);
				Ext.getCmp('mailinglistFirstTab_documenttemplate_id').setDisabled(true);
				
				
				var sendToAll = theJsonTreeData.result.sendtoallslotsatonce == 1 ? true : false;
				Ext.getCmp('mailinglistFirstTab_sendtoallslots').setValue(sendToAll);
				
				
				var data = theJsonTreeData.result;
				for(var a=0;a<data.slots.length;a++) {
					var fieldset = cf.mailinglistSecondTab.createFieldset(data.slots[a].slot_id,data.slots[a].name,true);
					var grid = cf.mailinglistSecondTab.createGrid();
					
					for(var b=0;b<data.slots[a].users.length;b++) {
						var row = data.slots[a].users[b];
						var unique_id = cf.mailinglistSecondTab.theUniqueId++
						var Rec = Ext.data.Record.create({name: 'unique_id'},{name: 'id'},{name: 'text'});
						grid.store.add(new Rec({unique_id: unique_id, id: row.user_id, text: row.name})); 
					}
					fieldset.add(grid);
					cf.mailinglistSecondTab.theLeftPanel.add(fieldset);
				}
				cf.mailinglistSecondTab.theLeftPanel.doLayout();
				cf.mailinglistPopUpWindow.theLoadingMask.hide();
			}
		});	
	},
	
	/**
	* init the popupwindow
	*
	* @param int id, id is set if in edit mode
	* @param string title, title of window
	*/
	initWindow: function (id, title) {
		this.theMailinglistPopUpWindow = new Ext.Window({
			modal: true,
			closable: true,
			modal: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 40,
			width: 820,
			autoScroll: false,
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: true,
			title: title,
	        buttonAlign: 'center',
			buttons:[{
				text:'<?php echo __('Store',null,'mailinglist'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () {
					cf.mailinglistCRUD.initSave(id);
				}
			},{
				text:'<?php echo __('Close',null,'mailinglist'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {
					cf.mailinglistPopUpWindow.theMailinglistPopUpWindow.hide();
					cf.mailinglistPopUpWindow.theMailinglistPopUpWindow.destroy();
				}
			}]
		});
		this.theMailinglistPopUpWindow.on('close', function() {
			cf.mailinglistPopUpWindow.theMailinglistPopUpWindow.hide();
			cf.mailinglistPopUpWindow.theMailinglistPopUpWindow.destroy();
		});
	},
	
	/** init tabpanel **/
	initTabPanel: function () {
		this.theTabPanel = new Ext.TabPanel({
			activeTab: 0,
			enableTabScroll:true,
			border: false,
			deferredRender:true,
			frame: true,
			layoutOnTabChange: true,
			style: 'margin-top:5px;',
			plain: false,
			closable:false
		});	
	}
	
};}();