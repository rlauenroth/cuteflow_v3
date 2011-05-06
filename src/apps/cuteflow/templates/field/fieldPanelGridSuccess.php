/** class loads the overview grid **/
cf.fieldPanelGrid = function(){return {
	
	theFieldGrid					:false,
	isInitialized					:false,
	theFieldStore					:false,
	theFieldCM						:false,
	theTopToolBar					:false,
	theSearchbarTextfield			:false,
	theSearchbarCombobox			:false,
	theSearchbarComboboxSelect		:false,
	
	/** inits all necessary functions to build the grid and its toolbars **/
	init: function () {
		this.initSearchbarTextfield();
		this.initSearchbarCombobox();
		this.initSearchbarComboboxSelect();
		this.initCM();
		this.initStore();
		this.initTopToolBar();
		this.initGrid();
	},

	/** init live-search **/
	initSearchbarTextfield: function () {
		this.theSearchbarTextfield = new Ext.form.TextField({
			allowBlank: true,
			emptyText:'<?php echo __('Search for...',null,'field'); ?>',
			enableKeyEvents: true,
			width: 225,
			listeners: {
				keyup: function(el, type) {
					var grid = cf.fieldPanelGrid.theFieldGrid;
					var needle = cf.fieldPanelGrid.theSearchbarComboboxSelect.getValue();
					grid.store.filter(needle, el.getValue());
				}
			}
		});
	},
	
	/** init combobox to search by fields **/
	initSearchbarCombobox: function () {
		this.theSearchbarCombobox = new Ext.form.ComboBox({
			valueField: 'id',
			displayField: 'text',
			editable: false,
			mode: 'local',
			emptyText:'<?php echo __('Search for...',null,'field'); ?>',
			store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[
       					 ['TEXTFIELD', '<?php echo __('Textfield',null,'field'); ?>'],
	       				 ['CHECKBOX', '<?php echo __('Checkbox (yes/no)',null,'field'); ?>'],
	       				 ['NUMBER', '<?php echo __('Number',null,'field'); ?>'],
	       				 ['DATE', '<?php echo __('Date',null,'field'); ?>'],
	       				 ['TEXTAREA', '<?php echo __('Textarea',null,'field'); ?>'],
	       				 ['RADIOGROUP', '<?php echo __('Radiogroup',null,'field'); ?>'],
	       				 ['CHECKBOXGROUP', '<?php echo __('Checkboxgroup',null,'field'); ?>'],
	       				 ['COMBOBOX', '<?php echo __('Combobox',null,'field'); ?>'],
	       				 ['FILE', '<?php echo __('File',null,'field'); ?>']
       				 ]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: true,
			hidden: true,
			forceSelection:true,
			width: 225
		});
		this.theSearchbarCombobox.on('select', function(combo) {
			var grid = cf.fieldPanelGrid.theFieldGrid;
			var needle = cf.fieldPanelGrid.theSearchbarCombobox.getRawValue();
			grid.store.filter('type', needle);
		});	
	},
	 /** inint combo to chanage the search options **/
	initSearchbarComboboxSelect: function () {
		this.theSearchbarComboboxSelect	= new Ext.form.ComboBox({
			valueField: 'id',
			displayField: 'text',
			editable: false,
			mode: 'local',
			store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[['title', '<?php echo __('Title',null,'field'); ?>'],['type', '<?php echo __('Field type',null,'field'); ?>'],['writeprotected', '<?php echo __('Write protected',null,'field'); ?>']]
			}),
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: true,
			forceSelection:true,
			value: 'title',
			width: 150,
			listeners: {
				select: {
					fn:function(combo, value) {
						if(combo.getValue() == 'title' || combo.getValue() == 'writeprotected') {
							cf.fieldPanelGrid.theSearchbarTextfield.setVisible(true);
							cf.fieldPanelGrid.theSearchbarCombobox.setVisible(false);
							cf.fieldPanelGrid.theSearchbarTextfield.setValue();
						}
						else {
							cf.fieldPanelGrid.theSearchbarCombobox.setVisible(true);
							cf.fieldPanelGrid.theSearchbarTextfield.setVisible(false);
							cf.fieldPanelGrid.theSearchbarTextfield.setValue();
							
						}
					}
				}
			}
		});
	},
	
	
	/** init CM for the grid **/
	initCM: function () {
		this.theFieldCM  =  new Ext.grid.ColumnModel([
			{header: "#", width: 50, sortable: true, dataIndex: '#', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Title',null,'field'); ?>", width: 280, sortable: false, dataIndex: 'title', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Field type',null,'field'); ?>", width: 150, sortable: false, dataIndex: 'type', css : "text-align:left;font-size:12px;align:center;"},
			{header: "<?php echo __('Write protected',null,'field'); ?>", width: 150, sortable: false, dataIndex: 'writeprotected', css : "text-align:left;font-size:12px;align:center;"},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/application_form_edit.png' />&nbsp;&nbsp;</td><td><?php echo __('Edit Field',null,'field'); ?></td></tr><tr><td><img src='/images/icons/application_form_delete.png' />&nbsp;&nbsp;</td><td><?php echo __('Delete field',null,'field'); ?></td></tr></table>\" ext:qwidth=\"200\"><?php echo __('Action',null,'field'); ?></div>", width: 80, sortable: false, dataIndex: 'action', css : "text-align : left;font-size:12px;align:center;" ,renderer: this.renderAction }
		]);
	},
	
	/** init store for the grid **/
	initStore: function () {
		this.theFieldStore = new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('field/LoadAllFields')?>',
				autoload: false,
				fields: [
					{name: '#'},
					{name: 'id'},
					{name: 'title'},
					{name: 'type'},
					{name: 'writeprotected'}
				]
		});
		
		//this.theFieldStore.reload();
	},
	/** init toolbar for grid **/
	initTopToolBar: function () {
		this.theTopToolBar = new Ext.Toolbar({
			items: [this.theSearchbarTextfield,this.theSearchbarCombobox,'-',this.theSearchbarComboboxSelect,'-',
			{
				icon: '/images/icons/delete.png',
	            tooltip:'<?php echo __('Clear field',null,'field'); ?>',
	            handler: function () {
					cf.fieldPanelGrid.theSearchbarTextfield.setValue();
					cf.fieldPanelGrid.theSearchbarCombobox.setValue();
					var grid = cf.fieldPanelGrid.theFieldGrid;
					var needle = cf.fieldPanelGrid.theSearchbarCombobox.getRawValue();
					grid.store.filter('title', '');
	            }
			},'-',{
				icon: '/images/icons/application_form_add.png',
	            tooltip:'<?php echo __('Add new Field',null,'field'); ?>',
	            handler: function () {
					cf.createFileWindow.initNewField('');
	            }
				
			}]
		});	
		
	},
	
	/** init grid **/
	initGrid: function () {
		this.theFieldGrid = new Ext.grid.GridPanel({
			title: '<?php echo __('Field Management',null,'field'); ?>',
			stripeRows: true,
			border: true,
			width: 'auto',
			height: cf.Layout.theRegionWest.getHeight() - 100,
			collapsible: false,
			loadMask: true,
			style:'margin-top:5px;margin-left:5px;margin-right:5px;',
			store: this.theFieldStore,
			tbar: this.theTopToolBar,
			cm: this.theFieldCM
		});
		this.theFieldGrid.on('afterrender', function(grid) {
			cf.fieldPanelGrid.theFieldStore.load();
		});	
		
	}, 
	
	/** button renderer for edit and delete **/
	renderAction: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		cf.fieldPanelGrid.createEditButton.defer(500,this, [record.data['id']]);
		cf.fieldPanelGrid.createDeleteButton.defer(500,this, [record.data['id']]);
		return '<center><table><tr><td width="16"><div id="field_edit'+ record.data['id'] +'"></div></td><td width="16"><div id="field_delete'+ record.data['id'] +'"></div></td></tr></table></center>';
	},
	
	/**
	* edit button
	*
	*@param int id, id of the record
	*/
	createEditButton: function (id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'field_edit' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/application_form_edit.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							if (c.disabled == false) {
								cf.createFileWindow.initUpdateField(id);
							}
						},
					scope: c
				});
				}
			}
		});
	},
	/**
	* create delete button
	*
	*@param int id, id of record
	*
	*/
	createDeleteButton: function (id) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'field_delete' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/application_form_delete.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							if (c.disabled == false) {
								Ext.Msg.show({
								   title:'<?php echo __('Delete field?',null,'field'); ?>',
								   msg: '<?php echo __('Delete field?',null,'field'); ?>',
								   buttons: Ext.Msg.YESNO,
								   fn: function(btn, text) {
										if(btn == 'yes') {
											cf.fieldCRUD.initDelete(id);
										}
								   }
								});
							}
						},
					scope: c
				});
				}
			}
		});
	}
	
	
	
	
	
	
	
	
	
};}();