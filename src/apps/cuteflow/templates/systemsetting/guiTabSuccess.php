/** init gui tab **/
cf.guiTab = function(){return {
	
	theGuiTab					:false,
	theGuiFieldset				:false,
	theGuiGrid					:false,
	theGuiCM					:false,
	theGuiStore					:false,
	thePanel					:false,
	theThemeFieldset			:false,
	theComboBox					:false,
	theComboStore				:false,
	
	
	
		/** load all nedded functions **/
	init: function () {
		this.initThemeFieldset();
		this.initComboStore();
		this.initCombo();
		this.theThemeFieldset.add(this.theComboBox);
		this.initCM();
		this.initStore();
		this.initGrid();
		this.initPanel();
		this.initGuiTab();
		this.initGuiFieldset();
		this.thePanel.add(this.theGuiGrid);
		this.theGuiFieldset.add(this.thePanel);
		this.theGuiTab.add(this.theThemeFieldset);
		this.theGuiTab.add(this.theGuiFieldset);
	},
	
	
	initCombo: function () {
		this.theComboBox = new Ext.form.ComboBox({
			fieldLabel: '<?php echo __('Select Theme',null,'systemsetting'); ?>',
			valueField: 'plain',
			displayField: 'translation',
			editable: false,
			id: 'guitab_theme_id',
			hiddenName : 'guitab_theme',
			mode: 'local',
			store: this.theComboStore,
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: true,
			forceSelection:true,
			width: 225
		});
		this.theComboBox.on('render', function(combo) {
			Ext.Ajax.request({  
				url: '<?php echo build_dynamic_javascript_url('theme/LoadAllTheme')?>',
				success: function(objServerResponse){
					data = Ext.util.JSON.decode(objServerResponse.responseText);
					var result = data.result;
					var defaultData;
					for(var a=0;a<result.length;a++) {
						var item = result[a];
						var Rec = Ext.data.Record.create({name: 'plain'},{name: 'translation'},{name: 'isDefault'});
						cf.guiTab.theComboBox.store.add(new Rec({plain: item.plain, translation: item.translation,isDefault: item.isDefault}));
						if(item.isDefault == 1) {
							defaultData = item.plain;
						}
					}
					cf.guiTab.theComboBox.setValue(defaultData);
					
				}	
			}); 
	    });	
	},
	
	initComboStore: function () {
		this.theComboStore = new Ext.data.SimpleStore({
			fields: [{name: 'plain'},{name: 'translation'},{name: 'isDefault'}]
		});
		
	},
	
	initThemeFieldset: function () {
		this.theThemeFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Set Default Theme',null,'systemsetting'); ?>',
			width: 430,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 150
		});
		
	},
	
	/** init the panel for tab **/
	initPanel: function () {
		this.thePanel = new Ext.Panel({
			style: 'margin-left:5px;',
			border: false
		});
		
	},
	
	/** init gui panel **/
	initGuiTab: function () {
		this.theGuiTab = new Ext.Panel({
			modal: true,
			closable: false,
			modal: true,
			width: 650,
			height: 750,
			autoScroll: false,
			title: '<?php echo __('GUI Settings',null,'systemsetting'); ?>',
			shadow: false,
			minimizable: false,
			draggable: false,
			resizable: false,
	        plain: false
		});
	},
	
	/** init a fieldset **/
	initGuiFieldset: function () {
		this.theGuiFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('GUI Workflow Settings',null,'systemsetting'); ?>',
			width: 430,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330
		});
		
	},
	
	/** init grid to set worklfow desgin **/
	initGrid: function () {
		this.theGuiGrid = new Ext.grid.GridPanel({
			frame:false,
			autoScroll: true,
			collapsible:false,
			closable: false,
			ddGroup : 'theguiTabGridDD',
			//title: '<?php echo __('Change order',null,'systemsetting'); ?>',
			height: 400,
			width: 400,
			allowContainerDrop : true,
			enableDragDrop:true,
			border: true,
			store: this.theGuiStore,
			cm: this.theGuiCM
		});
		
		this.theGuiGrid.on('render', function(grid) {
			var ddrow = new Ext.dd.DropTarget(grid.container, {
                ddGroup: 'theguiTabGridDD',
                copy:false,
                notifyDrop: function(ddSource, e, data){
					var sm = grid.getSelectionModel();  
					var rows = sm.getSelections();  
					var cindex = ddSource.getDragData(e).rowIndex;  
					 if (sm.hasSelection()) {  
						if(typeof(cindex) != "undefined") {
							for (i = 0; i < rows.length; i++) {  
								grid.store.remove(grid.store.getById(rows[i].id));  
								grid.store.insert(cindex,rows[i]);  
							}  
						}
						else { // when trying to add data to the end of the grid
							var total_length = grid.store.data.length+1;
							for (i = 0; i < rows.length; i++) {  
								grid.store.remove(grid.store.getById(rows[i].id));
							}
							grid.store.add(rows);
						}
					} 
					sm.clearSelections();
				}
			   }); 
		});
	},
	
	/** store for grid **/
	initStore: function () {
		this.theGuiStore = new Ext.data.JsonStore({
				totalProperty: 'total',
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('systemsetting/LoadCirculationColumns')?>',
				fields: [
					{name: 'id'},
					{name: 'column_text'},
					{name: 'column'},
					{name: 'is_active',type: 'bool'}
				]
		});
		cf.guiTab.theGuiStore.load();
	},
	
	/** cm for grid **/
	initCM : function () {
		this.theGuiCM  =  new Ext.grid.ColumnModel([
			{header: "<?php echo __('Activate Item',null,'systemsetting'); ?>",  width: 90, sortable: false, dataIndex: 'id', css : "text-align :left; font-size:12px;", renderer: cf.guiTab.renderAction},
			{header: "<?php echo __('Column',null,'systemsetting'); ?>",  width: 200, sortable: false, dataIndex: 'column_text', css : "text-align :left; font-size:12px;"}
		]);	
		
	},
	
	/** render checkbox to grid **/
	renderAction: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['id'];
		cf.guiTab.createCheckbox.defer(500,this, [id,  record.data['is_active']]);
		return '<center><table><tr><td><div id="guiTabCheckbox_'+ id +'"></div></td></tr></table></center>';
	},
	
	/** create checkbox **/
	createCheckbox: function (id, check_value) {
		var check = new Ext.form.Checkbox({
			renderTo: 'guiTabCheckbox_' + id,
			checked: check_value,
			handler: function (checkbox) {
				cf.guiTab.theGuiGrid.store.findExact('id', id ).data.is_active = checkbox.checked;
            }
		});
	}
	
		
	

	
	
};}();