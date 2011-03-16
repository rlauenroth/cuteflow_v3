/** create the grid for the second tab **/
cf.documenttemplatePopUpSecondTabRightColumn = function(){return {

	theFieldGrid					:false,
	theFieldCM						:false,
	theFieldStore					:false,
	theSearchToolbar				:false,
	theSearchbarTextfield			:false,
	theSearchbarCombobox			:false,
	theSearchbarComboboxSelect		:false,
	theTopToolBar					:false,
	
	/** init grid for right panel **/
	init: function () {
		this.initSearchbarTextfield();
		this.initSearchbarCombobox();
		this.initSearchbarComboboxSelect();
		this.initCM();
		this.initStore();
		this.initTopToolBar();
		this.initGrid();
	},
	
	/** init toolbar for right grid with live-search **/
	initTopToolBar: function () {
		this.theTopToolBar = new Ext.Toolbar({
			items: [this.theSearchbarTextfield,this.theSearchbarCombobox,'-',this.theSearchbarComboboxSelect,'-',
			{
				icon: '/images/icons/delete.png',
	            tooltip:'<?php echo __('Clear field',null,'documenttemplate'); ?>',
	            handler: function () {
					cf.documenttemplatePopUpSecondTabRightColumn.theSearchbarTextfield.setValue();
					cf.documenttemplatePopUpSecondTabRightColumn.theSearchbarCombobox.setValue();
					var grid = cf.documenttemplatePopUpSecondTabRightColumn.theFieldGrid;
					var needle = cf.documenttemplatePopUpSecondTabRightColumn.theSearchbarCombobox.getRawValue();
					grid.store.filter('title', '');
	            }
			}]
		});	
		
	},
	/** init live-search **/
	initSearchbarTextfield: function () {
		this.theSearchbarTextfield = new Ext.form.TextField({
			allowBlank: true,
			emptyText:'<?php echo __('Search for...',null,'documenttemplate'); ?>',
			enableKeyEvents: true,
			width: 140,
			listeners: {
				keyup: function(el, type) {
					var grid = cf.documenttemplatePopUpSecondTabRightColumn.theFieldGrid;
					var needle = cf.documenttemplatePopUpSecondTabRightColumn.theSearchbarComboboxSelect.getValue();
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
			emptyText:'<?php echo __('Search for...',null,'documenttemplate'); ?>',
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
			width: 140
		});
		this.theSearchbarCombobox.on('select', function(combo) {
			var grid = cf.documenttemplatePopUpSecondTabRightColumn.theFieldGrid;
			var needle = cf.documenttemplatePopUpSecondTabRightColumn.theSearchbarCombobox.getRawValue();
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
       				 data:[['title', '<?php echo __('Title',null,'field'); ?>'],['type', '<?php echo __('Field type',null,'field'); ?>']]
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
						if(combo.getValue() == 'title') {
							cf.documenttemplatePopUpSecondTabRightColumn.theSearchbarTextfield.setVisible(true);
							cf.documenttemplatePopUpSecondTabRightColumn.theSearchbarCombobox.setVisible(false);
							cf.documenttemplatePopUpSecondTabRightColumn.theSearchbarTextfield.setValue();
						}
						else {
							cf.documenttemplatePopUpSecondTabRightColumn.theSearchbarCombobox.setVisible(true);
							cf.documenttemplatePopUpSecondTabRightColumn.theSearchbarTextfield.setVisible(false);
							cf.documenttemplatePopUpSecondTabRightColumn.theSearchbarTextfield.setValue();
							
						}
					}
				}
			}
		});
	},
	
	/** init CM for grid **/
	initCM: function () {
		this.theFieldCM = new Ext.grid.ColumnModel([
			{header: "#", width: 30, sortable: false, dataIndex: '#', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Field name',null,'documenttemplate'); ?>", width: 175, sortable: false, dataIndex: 'title', css : "text-align : left;font-size:12px;align:left;"},
			{header: "<?php echo __('Field type',null,'documenttemplate'); ?>", width: 120, sortable: false, dataIndex: 'type', css : "text-align : left;font-size:12px;align:left;"}
		]);
	},
	
	/** init store for grid **/
	initStore: function () {
		this.theFormStore = new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('documenttemplate/LoadAllFields')?>',
				autoload: false,
				fields: [
					{name: '#'},
					{name: 'id'},
					{name: 'type'},
					{name: 'title'}
				]
		});
	},
	
	/** init grid and load store **/
	initGrid: function () {
		this.theFieldGrid = new Ext.grid.GridPanel({
			title: '<?php echo __('Available Fields',null,'documenttemplate'); ?>',
			stripeRows: true,
			border: false,
			width: 'auto',
			enableDragDrop:true,
			autoScroll: true,
			ddGroup : 'documenttemplaterid',
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 190,
			width:'auto',
			collapsible: false,
			store: this.theFormStore,
			tbar: this.theTopToolBar,
			cm: this.theFieldCM
		});
		
		this.theFieldGrid.on('afterrender', function(grid) {
			cf.documenttemplatePopUpSecondTabRightColumn.theFormStore.load();
		});
	}


};}();