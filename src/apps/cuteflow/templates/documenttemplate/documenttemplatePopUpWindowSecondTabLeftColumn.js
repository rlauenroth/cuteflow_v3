/** left column **/
cf.documenttemplatePopUpSecondTabLeftColumn = function(){return {
	
	
	theTopToolBar				:false,
	theUniqueFieldsetId			:0,
	theGridCM					:false,
	theUniqueGridId				:false,
	theRemoveSlot				:false,
	
	/** init paneö **/
	init: function () {
		this.theRemoveSlot = '';
		this.initGridCM();
		this.initTopToolBar();
	},
	
	/** init toolbar to add new slot **/
	initTopToolBar: function () {
		this.theTopToolBar = new Ext.Toolbar({
			width:360,
			items: [{
				xtype: 'button',
				text: '<?php echo __('Add new slot',null,'documenttemplate'); ?>',
				icon: '/images/icons/shape_square_add.png',
	            tooltip:'<?php echo __('Add new slot',null,'documenttemplate'); ?>',
				style: 'margin-botton:10px;',
	            handler: function () {
					var uniquefieldset_id = cf.documenttemplatePopUpSecondTabLeftColumn.theUniqueFieldsetId++;
					var fieldset = cf.documenttemplatePopUpSecondTabLeftColumn.buildFieldset(uniquefieldset_id,'',false);
					var namefield = cf.documenttemplatePopUpSecondTabLeftColumn.buildTextfield(uniquefieldset_id, '');
					var checkbox = cf.documenttemplatePopUpSecondTabLeftColumn.buildCheckbox(false);
					var grid = cf.documenttemplatePopUpSecondTabLeftColumn.buildGrid(id);	
					var hidden = cf.documenttemplatePopUpSecondTabLeftColumn.buildHiddenfield('');
					
					fieldset.add(namefield);
					fieldset.add(checkbox);
					fieldset.add(grid);
					fieldset.add(hidden);
					cf.documenttemplatePopUpSecondTab.theLeftColumnPanel.add(fieldset);
					cf.documenttemplatePopUpSecondTabLeftColumn.createDeleteButton.defer(100,this, [uniquefieldset_id]);
					cf.documenttemplatePopUpSecondTabLeftColumn.createAddButton.defer(100,this, [uniquefieldset_id]);
					cf.documenttemplatePopUpSecondTab.theLeftColumnPanel.doLayout();
	            }
			}]
		});	
	},
	
	/** 
	* init grid for new slot 
	*@param int id, unique id
	*/
	buildGrid: function (id) {
			var grid =  new Ext.grid.GridPanel({
			stripeRows: true,
			border: true,
			enableDragDrop:true,
			autoScroll: true,
			id: 'documenttemplategridid_' + id,
			ddGroup : 'documenttemplaterid',
			allowContainerDrop : true,
			width: 'auto',
			height: 170,
			collapsible: false,
			style:'margin-top:5px;',
			store: new Ext.data.SimpleStore({
				fields: [{name: 'unique_id'},{name: 'id'},{name: 'title'}]
			}),
			cm: this.theGridCM
		});
		
		grid.on('render', function(grid) { // render drag drop
			var ddrow = new Ext.dd.DropTarget(grid.container, {
                ddGroup: 'documenttemplaterid',
				copy: false,
				notifyDrop: function(ddSource, e, data){ // when droppping a container in the right grid
					if (ddSource.grid != grid){
						for(var a=0;a<data.selections.length;a++) { // if data is from right grid, add it to store. 
							var item = data.selections[a].data;
							var Rec = Ext.data.Record.create({name: 'unique_id'},{name: 'id'},{name: 'title'});
							grid.store.add(new Rec({unique_id: cf.documenttemplatePopUpSecondTabLeftColumn.theUniqueGridId++, id: item.id, title: item.title})); // important to add unique ID's
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
	
	/** 
	* init checkbox for fieldset
	*@param boolean checked, checked value
	*/
	buildCheckbox: function (checked) {
		var checkbox = new Ext.form.Checkbox({
			style: 'margin-top:4px;',
			checked: checked,
			fieldLabel: '<?php echo __('To all Slot-Receivers at once',null,'documenttemplate'); ?>'
		});
		return checkbox;
	},
	
	/**
	* hiddenfield with database id
	*
	*@param int value, id
	*/
	buildHiddenfield: function (value) {
		var hiddenfield =  new Ext.form.Hidden({
			allowBlank: true,
			value: value,
			width: 1
		});
		return hiddenfield;
	},
	
	/**
	* Build textfield for slotname
	*
    *@param int id, unique id
	*@param string name, name of textfield
	*/
	buildTextfield: function (id, name) {
		var textfield = new Ext.form.TextField({
			id: 'slotfieldsettextfieldid_' + id,
			fieldLabel: '<?php echo __('Name',null,'documenttemplate'); ?>',
			allowBlank: true,
			value: name,
			enableKeyEvents : true,
			width: 130
		});
		Ext.getCmp('slotfieldsettextfieldid_' + id).on('keyup', function(el, type) {
			Ext.fly('slottitle_'+id).update(Ext.getCmp('slotfieldsettextfieldid_' + id).getValue());
		});
		return textfield;
	
	},
	
	/**
	* Build Fieldset for slotname
	*
    *@param int id, unique id
	*@param string title, name of textfield
	*@param boolean collapsed
	*/
	buildFieldset: function (id, title, collapsed) {
		var fieldset =  new Ext.form.FieldSet({
			title: '<table><tr><td><div id="deleteslot_' + id + '"></div></td><td></td><td><div id="addslotat_'+id+'"></div></td><td>&nbsp;&nbsp;&nbsp;<b id="slottitle_'+id+'">'+title+'<b></td></tr></table>',
			height: 260,
			width:360,
			collapsible: true,
			collapsed: collapsed,
			id: 'documenttemplatefieldset_' + id,
			labelWidth:170
		});
		return fieldset;
	},
	
	/** 
	* create a new slot
	*
	*@param int id, unique id
	*
	*/
	createAddButton: function (id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'addslotat_' + id,
			id: 'createaddbuttonid_' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/shape_square_add.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							for(var a=1;a<cf.documenttemplatePopUpSecondTab.theLeftColumnPanel.items.length;a++){
								var item = cf.documenttemplatePopUpSecondTab.theLeftColumnPanel.getComponent(a);
								var id = (c.getId());
								id = id.replace('createaddbuttonid_', 'documenttemplatefieldset_');
								var item_id = item.getId();
								if(item_id == id) {
									var insert_position = a+1;
									var uniquefieldset_id = cf.documenttemplatePopUpSecondTabLeftColumn.theUniqueFieldsetId++;
									var fieldset = cf.documenttemplatePopUpSecondTabLeftColumn.buildFieldset(uniquefieldset_id,'',false);
									var namefield = cf.documenttemplatePopUpSecondTabLeftColumn.buildTextfield(uniquefieldset_id, '');
									var checkbox = cf.documenttemplatePopUpSecondTabLeftColumn.buildCheckbox(false);
									var grid = cf.documenttemplatePopUpSecondTabLeftColumn.buildGrid(uniquefieldset_id);
									var hidden = cf.documenttemplatePopUpSecondTabLeftColumn.buildHiddenfield('');
									
									fieldset.add(namefield);
									fieldset.add(checkbox);
									fieldset.add(grid);
									fieldset.add(hidden);
									cf.documenttemplatePopUpSecondTab.theLeftColumnPanel.insert(insert_position,fieldset);
									cf.documenttemplatePopUpSecondTabLeftColumn.createDeleteButton.defer(100,this, [uniquefieldset_id]);
									cf.documenttemplatePopUpSecondTabLeftColumn.createAddButton.defer(100,this, [uniquefieldset_id]);
									cf.documenttemplatePopUpSecondTab.theLeftColumnPanel.doLayout();
								}
							}	
						},
					scope: c
				});
				}
			}
		});
	},
	
	/** 
	*
	* render delete button to remove a fieldset
	*
	*@param int id, unique id of the fieldset
    **/
	createDeleteButton: function (id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'deleteslot_' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/shape_square_delete.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							Ext.Msg.show({
							   title:'<?php echo __('Delete slot',null,'documenttemplate'); ?>?',
							   msg: '<?php echo __('Delete slot',null,'documenttemplate'); ?>?',
							   buttons: Ext.Msg.YESNO,
							   fn: function(btn, text) {
									if(btn == 'yes') {
										var fieldset = Ext.getCmp('documenttemplatefieldset_' + id);
										
										cf.documenttemplatePopUpSecondTab.theLeftColumnPanel.remove(fieldset);
										fieldset.destroy();
										cf.documenttemplatePopUpSecondTab.theLeftColumnPanel.doLayout();
										hidden = fieldset.getComponent(3);
										var databaseId = hidden.getValue();
										if (databaseId != '') {
											if(cf.documenttemplatePopUpSecondTabLeftColumn.theRemoveSlot  == false) {
												cf.documenttemplatePopUpSecondTabLeftColumn.theRemoveSlot = databaseId;
											}
											else {
												cf.documenttemplatePopUpSecondTabLeftColumn.theRemoveSlot = cf.documenttemplatePopUpSecondTabLeftColumn.theRemoveSlot + ',' + databaseId;
											}	
										}
									
									}
							   }
							});
							

						},
					scope: c
				});
				}
			}
		});
	
	},
	
	/** CM for all grids in fieldset **/
	initGridCM: function () {
		this.theGridCM = new Ext.grid.ColumnModel([
			{header: "<div ext:qtip=\"<?php echo __('Notice: empty records are not saved',null,'documenttemplate'); ?>\" ext:qwidth=\"200\"><?php echo __('Field',null,'documenttemplate'); ?></div>", width: 230, sortable: false, dataIndex: 'title', css : "text-align : left;font-size:12px;align:left;"},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/delete.png' />&nbsp;&nbsp;</td><td><?php echo __('Remove Field',null,'documenttemplate'); ?></td></tr></table>\" ext:qwidth=\"160\"><?php echo __('Action',null,'documenttemplate'); ?></div>", width: 60, sortable: false, dataIndex: 'unique_id', css : "text-align:left;font-size:12px;align:center;", renderer: this.renderRowDelete}
		]);
	},
	
	/** button renderer for  delete  a row in each fieldset grid**/
	renderRowDelete: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		cf.documenttemplatePopUpSecondTabLeftColumn.createDeleteRecordButton.defer(100,this, [record.data['unique_id'],store]);
		return '<center><table><tr><td width="16"><div id="documenttemplateleftgrid_'+ record.data['unique_id'] +'"></div></td></tr></table></center>';
	},
	
	/**
	* delete button, to remove a row in a grid
	*
	*@param int id, id of the record
	*@param SimpleStore theStore, remove record from stroe
	*/
	createDeleteRecordButton: function (id, theStore) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'documenttemplateleftgrid_' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/delete.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							var item = theStore.findExact('unique_id', id );
							theStore.remove(item);
						},
					scope: c
				});
				}
			}
		});

	}
	













};}();