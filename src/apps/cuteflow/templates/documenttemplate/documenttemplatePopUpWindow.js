/** init popupwindow to create/update a template **/
cf.documenttemplatePopUpWindow = function(){return {
	
	theDocumenttemplatePopUpWindow	:false,
	theLoadingMask					:false,
	theTabPanel						:false,
	theFirstTab						:false,
	theFirstTabFieldset				:false,
	theLoadingMaskShowTime			:false,

	/**
	* calls all necessary functions, to create a new form
	*@param int id, id of the record is empty, only set in editmode
	*/
	initNewDocumenttemplate: function (id) {
		cf.documenttemplatePopUpFirstTab.init();
		this.initTabPanel();
		this.theTabPanel.add(cf.documenttemplatePopUpFirstTab.theFirstTabPanel);
		cf.documenttemplatePopUpSecondTab.init();
		this.theTabPanel.add(cf.documenttemplatePopUpSecondTab.theColumnPanel);
		this.initWindow(id, '<?php echo __('Create new document template',null,'documenttemplate'); ?>');
		this.theDocumenttemplatePopUpWindow.add(this.theTabPanel);
		this.theDocumenttemplatePopUpWindow.show();
		this.theTabPanel.setActiveTab(1);
	},

	
	/**
	* calls all necessary functions, to edit a  form
	*@param int id, id is set
	*/
	initEditDocumenttemplate: function (id) {
		cf.documenttemplatePopUpFirstTab.init();
		this.initTabPanel();
		this.theTabPanel.add(cf.documenttemplatePopUpFirstTab.theFirstTabPanel);
		cf.documenttemplatePopUpSecondTab.init();
		this.theTabPanel.add(cf.documenttemplatePopUpSecondTab.theColumnPanel);
		this.initWindow(id, '<?php echo __('Edit document template',null,'documenttemplate'); ?>');
		this.theDocumenttemplatePopUpWindow.add(this.theTabPanel);
		this.theDocumenttemplatePopUpWindow.show();
		this.theTabPanel.setActiveTab(1);
		this.addData(id); // load data
		
	},
	
	/**
	* Load the data when in editmode
	*
	*@param int id, id of the record to edit
	*
	*/
	addData: function (id) {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('documenttemplate/LoadSingleDocumenttemplate')?>/id/' + id, 
			success: function(objServerResponse){
				theJsonTreeData = Ext.util.JSON.decode(objServerResponse.responseText);
				Ext.getCmp('documenttemplatePopUpFirstTab_fieldname').setValue(theJsonTreeData.result.name);
				Ext.getCmp('documenttemplatePopUpFirstTab_fieldname').setDisabled(true);
				var data = theJsonTreeData.result;
				for(var a=0;a<data.slots.length;a++) { // call function to create fieldset
					var checked = data.slots[a].receiver == 0 ? false : true;
					
					var uniquefieldset_id = cf.documenttemplatePopUpSecondTabLeftColumn.theUniqueFieldsetId++;
					
					var fieldset = cf.documenttemplatePopUpSecondTabLeftColumn.buildFieldset(uniquefieldset_id,data.slots[a].name,true);
					var namefield = cf.documenttemplatePopUpSecondTabLeftColumn.buildTextfield(uniquefieldset_id, data.slots[a].name);
					var checkbox = cf.documenttemplatePopUpSecondTabLeftColumn.buildCheckbox(checked,data.slots[a].fields);
					var grid = cf.documenttemplatePopUpSecondTabLeftColumn.buildGrid(uniquefieldset_id);
					var hidden = cf.documenttemplatePopUpSecondTabLeftColumn.buildHiddenfield(data.slots[a].slot_id);
					fieldset.add(namefield);
					fieldset.add(checkbox);
					fieldset.add(grid);
					fieldset.add(hidden);
					cf.documenttemplatePopUpSecondTab.theLeftColumnPanel.add(fieldset);
					cf.documenttemplatePopUpSecondTabLeftColumn.createDeleteButton.defer(100,this, [uniquefieldset_id]);
					cf.documenttemplatePopUpSecondTabLeftColumn.createAddButton.defer(100,this, [uniquefieldset_id]);
					cf.documenttemplatePopUpSecondTab.theLeftColumnPanel.doLayout();
					for(var b=0;b<data.slots[a].fields.length;b++) {
						var item = data.slots[a].fields[b];
						var Rec = Ext.data.Record.create({name: 'unique_id'},{name: 'id'},{name: 'title'});
						grid.store.add(new Rec({unique_id: cf.documenttemplatePopUpSecondTabLeftColumn.theUniqueGridId++, id: item.field_id, title: item.title}));
					}
				}
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
		this.theDocumenttemplatePopUpWindow = new Ext.Window({
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
				text:'<?php echo __('Store',null,'documenttemplate'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () {
					cf.documenttemplateCRUD.initSave(id);
				}
			},{
				text:'<?php echo __('Close',null,'documenttemplate'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {
					cf.documenttemplatePopUpWindow.theDocumenttemplatePopUpWindow.hide();
					cf.documenttemplatePopUpWindow.theDocumenttemplatePopUpWindow.destroy();
				}
			}]
		});
		this.theDocumenttemplatePopUpWindow.on('close', function() {
			cf.documenttemplatePopUpWindow.theDocumenttemplatePopUpWindow.hide();
			cf.documenttemplatePopUpWindow.theDocumenttemplatePopUpWindow.destroy();
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