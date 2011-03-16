cf.createWorkflowSecondTab = function(){return {
	
	
	theSecondPanel				:false,
	theLeftPanel				:false,
	theRightPanel				:false,
	theGrid						:false,
	theStore					:false,
	theCM						:false,
	theToolbar					:false,
	theSlotCM					:false,
	theUniqueId					:false,
	
	
	
	init:function(id) {
		this.initPanel();
		this.initSlotCM();
		this.initToolbar();
		this.initStore();
		this.initCM();
		this.initGrid();
		this.initLeftPanel();
		this.initRightPanel();
		this.theRightPanel.add(this.theGrid);
		this.initPanel();
		this.theSecondPanel.add(this.theRightPanel)
		this.theSecondPanel.add(this.theLeftPanel);;
		this.loadData(id);
	},
	
	
	loadData: function (id) {
		Ext.Ajax.request({  
			url: '<?php echo build_dynamic_javascript_url('mailinglist/LoadSingleMailinglist')?>/id/' + id,
			success: function(objServerResponse){
				theJsonTreeData = Ext.util.JSON.decode(objServerResponse.responseText);
				cf.createWorkflowSecondTab.addData(theJsonTreeData, true);
			}
		});		
	},
	
	
	/** init toolbar for ajax search **/
	initToolbar: function () {
		this.theToolbar = new Ext.Toolbar({
			items: [{
				xtype: 'textfield',
				id: 'createWorkflowSecondTab_UserLivesearch',
				emptyText:'<?php echo __('Search for User...',null,'mailinglist'); ?>',
				width: 200,
				enableKeyEvents: true,
				listeners: {
					keyup: function(el, type) {
						var grid = cf.createWorkflowSecondTab.theGrid;
						grid.store.filter('textwithoutimage', el.getValue());
					}
				}
			},'-',{
				icon: '/images/icons/delete.png',
				tooltip: '<?php echo __('Clear field',null,'mailinglist'); ?>',
				handler: function () {
					Ext.getCmp('createWorkflowSecondTab_UserLivesearch').setValue();
					cf.createWorkflowSecondTab.theGrid.store.filter('textwithoutimage', '');
                }
			}]
		});
	},
	
	/** init store to load user **/
	initStore: function () {
		this.theStore = new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('mailinglist/BuildReceiver')?>',
				autoload: true,
				fields: [
					{name: 'id'},
					{name: 'textwithoutimage'},
					{name: 'text'}
				]
		});
		cf.createWorkflowSecondTab.theStore.on('load', function(grid) {
			var Rec = Ext.data.Record.create({name: 'id'},{name: 'text'}, {name: 'textwithoutimage'});
			cf.createWorkflowSecondTab.theStore.insert(0,new Rec({id: -2, text: '<table><tr><td width="18" ><img src="/images/icons/user_red.png" /></td><td>&nbsp;&nbsp;<?php echo __('Sender of circulation',null,'mailinglist'); ?></td></tr></table>', textwithoutimage: '<?php echo __('Sender of circulation',null,'mailinglist'); ?>'})); // important to add unique ID's
		});
		
		
	},
	
	/** init CM **/
	initCM: function () {
		this.theCM = new Ext.grid.ColumnModel([
			{header: "<?php echo __('User',null,'mailinglist'); ?>", width: 270, sortable: false, dataIndex: 'text', css : "text-align : left;font-size:12px;align:center;"}
		]);
		
	},
	
	/** init grid **/
	initGrid: function () {
		this.theGrid = new Ext.grid.GridPanel({
			frame:true,
			autoScroll: true,
			collapsible:false,
			closable: false,
            ddText: '<?php echo __('Move right',null,'workflowmanagement'); ?>',  
			title: '<table><tr><td><img src="/images/icons/user_suit.png" /></td><td><?php echo __('User',null,'mailinglist'); ?></td></tr></table>',
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 190,
			width:340,
			border: true,
			style: 'margin-right:20px;',
			ddGroup : 'workflowsecondtabdd',
			plain: false,
			enableDragDrop:true,
			expand: true,
			store: this.theStore,
			tbar: this.theToolbar,
			cm: this.theCM
		});
		
		this.theGrid.on('render', function(grid) {
			cf.createWorkflowSecondTab.theStore.load();
		});
		
	},
	
	
	/** left panel **/
	initLeftPanel: function () {
		this.theLeftPanel = new Ext.Panel ({
			frame:true,
			border: false,
			columnWidth: .5,
			autoScroll: true,
			width: 290,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 170
		});
		
	},
	
	/** right panel **/
	initRightPanel: function () {
		this.theRightPanel = new Ext.Panel ({
			frame:true,
			border: false,
			columnWidth: .5,
			autoScroll: true,
			width: 280,
		    height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 170
		});
	},	
	
	
	/**
	* init column panel
	*
	*@param string tab_title, tab title
	*/
	initPanel: function () {
		this.theSecondPanel = new Ext.Panel({
			title: '<?php echo __('Mailing list',null,'workflowmanagement'); ?>',
			frame: false,
			layout: 'column',
			autoScroll: true,
			height: 'auto',
			width: 600,			
			border: 'none',
			style: 'border:none;',
			layoutConfig: {
				columns: 2
			}
		});
	},
	
	
	
	/**
	*
	*
	*@param string result, data
	*@param boolean collapsed
	*
	*/
	addData: function (result, collapsed) {
		var data = result.result;
		for(var a=0;a<data.slots.length;a++) {
			var fieldset = cf.createWorkflowSecondTab.createFieldset(data.slots[a].slot_id,data.slots[a].name,collapsed);
			var grid = cf.createWorkflowSecondTab.createGrid();
			
			for(var b=0;b<data.slots[a].users.length;b++) {
				var row = data.slots[a].users[b];
				var unique_id = cf.createWorkflowSecondTab.theUniqueId++
				var Rec = Ext.data.Record.create({name: 'unique_id'},{name: 'id'},{name: 'text'});
				grid.store.add(new Rec({unique_id: unique_id, id: row.user_id, text: row.name})); 
			}
			fieldset.add(grid);
			cf.createWorkflowSecondTab.theLeftPanel.add(fieldset);
		}
	},
	
	/**
	*
	* create a fieldset
	*
	*@param int slot_id, database id of the slot
	*@param string name, name of the slot
	*@param boolean collapsed
	*/
	createFieldset: function (slot_id, name, collapsed) {
		var fieldset =  new Ext.form.FieldSet({
			title: '<?php echo __('Slot: ',null,'mailinglist'); ?> ' + name,
			height: 220,
			width:'auto',
			id: 'WORKFLOWUSERSLOT_' + slot_id,
			collapsible: true,
			collapsed: collapsed
		});
		return fieldset;
	},
	
	/** add grid for fieldset **/
	createGrid: function () {
		var grid = new Ext.grid.GridPanel({
			stripeRows: true,
			border: true,
			enableDragDrop:true,
			autoScroll: true,
			ddGroup : 'workflowsecondtabdd',
			allowContainerDrop : true,
			width: 310,
			height: 170,
			collapsible: false,
			style:'margin-top:5px;',
			store: new Ext.data.SimpleStore({
				fields: [{name: 'unique_id'},{name: 'id'},{name: 'text'}]
			}),
			cm: this.theSlotCM
		});
		
		grid.on('render', function(grid) { // render drag drop
			var ddrow = new Ext.dd.DropTarget(grid.container, {
                ddGroup: 'workflowsecondtabdd',
				copy: false,
				notifyDrop: function(ddSource, e, data){ // when droppping a container in the right grid
					if (ddSource.grid != grid){
						for(var a=0;a<data.selections.length;a++) { // if data is from right grid, add it to store. 
							var item = data.selections[a].data;
							var Rec = Ext.data.Record.create({name: 'unique_id'},{name: 'id'},{name: 'text'});
							grid.store.add(new Rec({unique_id: cf.createWorkflowSecondTab.theUniqueId++, id: item.id, text: item.textwithoutimage})); // important to add unique ID's
						}
					}
					else { // if data is coming from left, then reorder is done.
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
					return true;
				}
		    }); 
		});
		return grid;
	},
	
	/** init CM for slots **/
	initSlotCM: function () {
		this.theSlotCM = new Ext.grid.ColumnModel([
			{header: "<?php echo __('User',null,'mailinglist'); ?>", width: 230, sortable: false, dataIndex: 'text', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/user_delete.png' />&nbsp;&nbsp;</td><td><?php echo __('Remove user',null,'mailinglist'); ?></td></tr></table>\" ext:qwidth=\"200\"><?php echo __('Action',null,'mailinglist'); ?></div>", width: 50, sortable: true, css : "text-align : left;font-size:12px;align:center;", renderer:this.deleteUserButton}
		]);
		
	},
	
		/** button renderer for  delete  a row in each fieldset grid**/
	deleteUserButton: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		cf.createWorkflowSecondTab.createDeleteUserButton.defer(100,this, [record.data['unique_id'],store]);
		return '<center><table><tr><td width="16"><div id="mailinglistleftgrid_'+ record.data['unique_id'] +'"></div></td></tr></table></center>';
	},
	
	
	/**
	* delete button, to remove a row in a grid
	*
	*@param int id, id of the record
	*@param SimpleStore theStore, remove record from stroe
	*/
	createDeleteUserButton: function (id, theStore) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'mailinglistleftgrid_' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/user_delete.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							var item = theStore.findExact('unique_id', id );
							theStore.remove(item);
							if(item.data.databaseId != '') {
								if(cf.createWorkflowSecondTab.theRemoveUser  == false) {
									cf.createWorkflowSecondTab.theRemoveUser = item.data.databaseId;
								}
								else {
									cf.createWorkflowSecondTab.theRemoveUser = cf.createWorkflowSecondTab.theRemoveUser  + ',' + item.data.databaseId;
								}	
							}
						},
					scope: c
				});
				}
			}
		});

	}
	
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
};}();