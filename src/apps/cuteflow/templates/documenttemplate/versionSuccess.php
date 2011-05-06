/** init second tab for version popu**/
cf.documenttemplateVersionSecondTab = function(){return {
	
	theGridCM					:false,
	
	/**
	* add a new fieldset to the tabpanel
	*
	*@param int id, of the version
	*@param string data, data to add
	*@param string created_at, creation date of the record
	*@param int grid_id, id of the grid #
	*@param int documenttemplateid, id of the template
	*/
	init: function (id, data, created_at, grid_id, documenttemplateid) {
		this.initGridCM();
		var toolbar = this.initToolbar(id,documenttemplateid);
		var panel = this.initTab(id, created_at, grid_id);
		panel.add(toolbar);
		for(var a=0;a<data.slots.length;a++) {
			var checked = data.slots[a].receiver == 0 ? false : true;
			var fieldset = this.initFieldset(data.slots[a].name,checked);
			var grid = this.initGrid();
			fieldset.add(grid);
			panel.add(fieldset);
			for(var b=0;b<data.slots[a].fields.length;b++) {
				var item = data.slots[a].fields[b];
				var Rec = Ext.data.Record.create({name: 'title'});
				grid.store.add(new Rec({ title: item.title}));
			}
		}
		cf.documenttemplateVersionPopUp.theTabPanel.add(panel);
		cf.documenttemplateVersionPopUp.theTabPanel.setActiveTab(panel);
		cf.documenttemplateVersionFirstTab.theLoadingMask.hide();
		
	},
	
	/**
	* init toolbar
	*
	*@param int id, id of the version
	*@param int documenttemplateid, id of the template
	*
	*/
	initToolbar: function (id, documenttemplateid) {
	 var toolbar = new Ext.Toolbar({
			width: 'auto',
			items: [{
				xtype: 'button',
				text: '<?php echo __('Activate Document template',null,'documenttemplate'); ?>',
				icon: '/images/icons/clock_go.png',
	            tooltip:'<?php echo __('Set Template to active',null,'documenttemplate'); ?>',
				style: 'margin-botton:10px;',
	            handler: function () {
					Ext.Msg.show({
					   title:'<?php echo __('Activate Template',null,'documenttemplate'); ?>?',
					   msg: '<?php echo __('Activate Template',null,'documenttemplate'); ?>?',
					   buttons: Ext.Msg.YESNO,
					   fn: function(btn, text) {
							if(btn == 'yes') {
								Ext.Ajax.request({  
									url : '<?php echo build_dynamic_javascript_url('documenttemplate/ActivateDocumenttemplate')?>/id/' + id + '/documenttemplateid/' + documenttemplateid, 
									success: function(objServerResponse){
										cf.documenttemplateVersionPopUp.theVersionWindow.hide();
										cf.documenttemplateVersionPopUp.theVersionWindow.destroy();
										cf.documenttemplatePanelGrid.theDocumenttemplateStore.reload();
										Ext.Msg.minWidth = 200;
										Ext.MessageBox.alert('<?php echo __('OK',null,'documenttemplate'); ?>','<?php echo __('Template activated',null,'documenttemplate'); ?>');
									}
								});
							}
					   }
					});
	            }
			}]
		});	
		return toolbar;	
	},
	
	
	/** CM for all grids in fieldset **/
	initGridCM: function () {
		this.theGridCM = new Ext.grid.ColumnModel([
			{header: "<?php echo __('Field',null,'documenttemplate'); ?>", width: 230, sortable: false, dataIndex: 'title', css : "text-align : left;font-size:12px;align:left;"}
			
		]);
	},
	
	/** init grid **/
	initGrid: function () {
		var grid = new Ext.grid.GridPanel({
			stripeRows: true,
			border: true,
			enableDragDrop: false,
			autoScroll: true,
			allowContainerDrop : false,
			width: 280,
			height: 170,
			collapsible: false,
			style:'margin-top:5px;',
			store: new Ext.data.SimpleStore({
				fields: [{name: 'title'}]
			}),
			cm: this.theGridCM
		});
		return grid;
	},
	
	/**
	* init fieldset with checkbox and title
	*
	* @param string title, titel of slot and fieldset
	* @param boolean checked
	*
	*/
	initFieldset: function (title, checked) {
		var fieldset = new Ext.form.FieldSet({
			title: 'Slot: ' + title,
			width: 'auto',
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 170,
			items:[{
				xtype: 'checkbox',
				style: 'margin-top:4px;',
				checked: checked,
				fieldLabel: '<?php echo __('To all Slot-Receivers at once',null,'documenttemplate'); ?>'
			}]
		});
		return fieldset;
		
	},
	
	/**
	* init tab in tabpanel
	*
	*@param int id of the version
	*@param string created_at, creatíon time
	*@param int grid_id, # id of grid
	*
	*/
	initTab: function (id, created_at, grid_id) {
		var panel = new Ext.Panel({
			id: 'panel_' + id,
			title: grid_id + ': ' + created_at,
			closable: true,
			autoScroll: true,
			frame: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 148
		});
		return panel;
	}
	
	
	
	
	
	
	
	
};}();