/** init the grid to display all items **/
cf.additionalTextGrid = function(){return {
	
	theTextGrid 				:false,
	theTextStore				:false,
	theTextCM					:false,
	theTopToolbar				:false,

	/** init the grid **/
	init: function () {
		this.initTopToolbar();
		this.initStore();
		this.initCM();
		this.initGrid();
	},
	

	
	/** load store **/
	initStore: function () {
		this.theTextStore = new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('additionaltext/LoadAllText')?>',
				fields: [
					{name: '#'},
					{name: 'id'},
					{name: 'content_type'},
					{name: 'is_active'},
					{name: 'title'}
				]
		});
	},
	
	/** load columnmodel **/
	initCM: function () {
		this.theTextCM  =  new Ext.grid.ColumnModel([
			{header: "#", width: 50, sortable: false, dataIndex: '#', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Title',null,'additionaltext'); ?>", width: 380, sortable: false, dataIndex: 'title', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Content Type',null,'additionaltext'); ?>", width: 80, sortable: false, dataIndex: 'content_type', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Standard',null,'additionaltext'); ?>", width: 80, sortable: true, dataIndex: 'is_active', css : "text-align : left;font-size:12px;align:center;", renderer: cf.additionalTextGrid.renderRadiogroup},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/script_code_red.png' />&nbsp;&nbsp;</td><td><?php echo __('Copy Text',null,'additionaltext'); ?></td></tr><tr><td><img src='/images/icons/script_edit.png' />&nbsp;&nbsp;</td><td><?php echo __('Edit Text',null,'additionaltext'); ?></td></tr><tr><td><img src='/images/icons/script_delete.png' />&nbsp;&nbsp;</td><td><?php echo __('Remove Text',null,'additionaltext'); ?></td></tr></table>\" ext:qwidth=\"200\"><?php echo __('Action',null,'additionaltext'); ?></div>", width: 80, sortable: true, dataIndex: 'id', css : "text-align : left;font-size:12px;align:center;", renderer: cf.additionalTextGrid.renderButtons }
		]);
	},
	
	/** init the grid **/
	initGrid: function () {
		this.theTextGrid = new Ext.grid.GridPanel({ 
			frame:false,
			autoScroll: true,
			collapsible:false,
			loadMask: true,
			closable: false,
			title: '<?php echo __('Available Additional Textes',null,'additionaltext'); ?>',
			border: true,
			store: this.theTextStore,
			cm: this.theTextCM,
			tbar: this.theTopToolbar
		});
		this.theTextGrid.on('afterrender', function(grid) {
			cf.additionalTextGrid.theTextStore.load();
		});
	},
	
	
	/** initToolbar with livesearch**/
	initTopToolbar: function () {
		this.theTopToolbar = new Ext.Toolbar({
			items: [{
				xtype: 'textfield',
				id: 'additionaltext_searchtextfield',
				emptyText:'<?php echo __('Search for...',null,'additionaltext'); ?>',
				width: 150,
				enableKeyEvents: true,
				listeners: {
					keyup: function(el, type) {
						var grid = cf.additionalTextGrid.theTextGrid;
						var needle = Ext.getCmp('additionaltext_searchcombobox').getValue();
						grid.store.filter(needle, el.getValue());
					}
				}
			},'-',{
				xtype: 'combo',
				id: 'additionaltext_searchcombobox',
				editable:false,
				triggerAction: 'all',
				foreSelection: true,
				mode: 'local',
				value: 'title',
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[['title', '<?php echo __('Title',null,'additionaltext'); ?>'],['content_type', '<?php echo __('Content Type',null,'additionaltext'); ?>']]
   				}),
 				valueField:'id',
				displayField:'text',
				width:130
			},'-',{
				icon: '/images/icons/delete.png',
				tooltip: '<?php echo __('Clear field',null,'additionaltext'); ?>',
				handler: function () {
					Ext.getCmp('additionaltext_searchtextfield').setValue();
					var needle = Ext.getCmp('additionaltext_searchcombobox').getValue();
					cf.additionalTextGrid.theTextGrid.store.filter(needle, '');
				}
			},'-',{
				icon: '/images/icons/script_add.png',
				tooltip: '<?php echo __('Add new Text',null,'additionaltext'); ?>',
				handler: function () {
					cf.additionalTextPopUpWindow.init('');
				}
			}]
		});
	},
	
	/** renders radiobutton to grid **/
	renderRadiogroup: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['id'];
		var is_active = record.data['is_active'];
		var radio = cf.additionalTextGrid.createRadiobutton.defer(1,this, [id,is_active]);
		return '<center><table><tr><td><div id="radioboxAdditionalText_'+ id + '"></div></td></tr></table>';
	},
	
	/** 
	*
	* create radio button
	*
	* @param int id, id of the record, 
	* @param boolean is_active, true/false if record is standard
	*/
	createRadiobutton: function (id,is_active) {
		if (is_active == 1) {
			var check = true;
		}
		else {
			var check = false;
		}
		var radio = new Ext.form.Radio({
			renderTo: 'radioboxAdditionalText_' + id,
			name: 'additionalTextGrid_radioStandard',
			checked: check,
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							Ext.Ajax.request({  
								url : '<?php echo build_dynamic_javascript_url('additionaltext/SetStandard')?>/id/' + id, 
								success: function(objServerResponse){  
								}
							});
						},
						scope: c
					});
				}
			}
	
			
		});
	},
	
	/** function to render copy, edit and delete button **/
	renderButtons: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var id = record.data['id'];
		var btnCopy = cf.additionalTextGrid.createCopyButton.defer(1,this, [id]);
		var btnEdit = cf.additionalTextGrid.createEditButton.defer(1,this, [id]);
		var btnCDelete = cf.additionalTextGrid.createDeleteButton.defer(1,this, [id]);
		return '<center><table><tr><td width="16"><div id="copyAdditionalText_'+ id +'"></div></td><td width="16"><div id="editAdditionalText_'+ id +'"></div></td><td width="16"><div id="deleteAdditionalText_'+ id +'"></div></td></tr></table></center>';
	},
	
	/**
	* Create copy button
	* 
	* @param int id, id of the record, 
	*/
	createCopyButton: function (id) {
		var btn_copy = new Ext.form.Label({
			renderTo: 'copyAdditionalText_' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/script_code_red.png" /></span>',
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							cf.additionalTextCRUD.initCopy(id);
						},
					scope: c
					});
				}
			}
		});
	},
	
	/**
	* Create edit button
	* 
	* @param int id, id of the record, 
	*/
	createEditButton: function (id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'editAdditionalText_' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/script_edit.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							cf.additionalTextPopUpWindow.init(id);
						},
					scope: c
				});
				}
			}
		});
	},
	
	/**
	* Create delete button
	* 
	* @param int id, id of the record, 
	*/
	createDeleteButton: function (id) {
		var btn_delete = new Ext.form.Label({
			renderTo: 'deleteAdditionalText_' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/script_delete.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							Ext.Msg.show({
							   title:'<?php echo __('Delete text?',null,'additionaltext'); ?>',
							   msg: '<?php echo __('Delete text?',null,'additionaltext'); ?>',
							   buttons: Ext.Msg.YESNO,
							   fn: function(btn, text) {
									if(btn == 'yes') {
										cf.additionalTextCRUD.initDelete(id);
									}
							   }
							});
						},
					scope: c
				});
				}
			}
		});
	}
	
	
	
	
	
	

};}();