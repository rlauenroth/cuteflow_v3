/** class builds grid for Menueitems in one group **/
cf.menueSettingGroupGrid = function(){return {
	
	theGroupGrid 				:false,
	theGroupStore				:false,
	theGroupCM					:false,
	
	
	
	/**
	*
	* init function
	*
	* @param int id, id of the loaded Group
	*/
	init: function (id) {
		this.initCM();
		this.initStore(id);
		this.initGrid();
	},
	
	
	/** init cm **/
	initCM: function () {
		this.theGroupCM  =  new Ext.grid.ColumnModel([
			{header: "#", width: 50, sortable: false, dataIndex: '#', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Module',null,'menuesetting'); ?>", width: 225, sortable: false, dataIndex: 'module', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Group',null,'menuesetting'); ?>", width: 225, sortable: false, dataIndex: 'group', css : "text-align : left;font-size:12px;align:center;"}
		]);
		
	},
	
	/**
	*
	* init Store for grid
	*
	* @param int id, id of the loaded Group
	*/
	
	initStore: function (id) {
		this.theGroupStore = new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('menuesetting/LoadGroup')?>/id/' + id,
				fields: [
					{name: '#'},
					{name: 'id'},
					{name: 'group'},
					{name: 'module'},
					{name: 'module_id'},
					{name: 'group_id'}
				]
		});
		this.theGroupStore.load();
		
	},
	

	
	/** init grid for displaying items **/
	initGrid: function () {
		this.theGroupGrid = new Ext.grid.GridPanel({
			frame:false,
			autoScroll: true,
			collapsible:false,
			loadMask: true,
			closable: false,
			ddGroup : 'theGroupGridDD',
			allowContainerDrop : true,
			enableDragDrop:true,
		    ddText: '<?php echo __('Drag Drop to change order',null,'menuesetting'); ?>', 
			width: 530,
			title: '<?php echo __('Change order of module items',null,'menuesetting'); ?>',
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 180,
			style: 'margin-top:10px;margin-left:10px;',
			border: true,
			store: this.theGroupStore,
			cm: this.theGroupCM
		});
		
		// drag drop functionality added
		this.theGroupGrid.on('render', function(grid) {
			var secondGridDropTargetEl = grid.getView().scroller.dom;
			var secondGridDropTarget = new Ext.dd.DropTarget(secondGridDropTargetEl, {
				ddGroup: 'theGroupGridDD',
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
		
	}
	
	
	
};}();