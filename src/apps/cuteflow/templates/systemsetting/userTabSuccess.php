/** init tab for usersettings **/
cf.userTab = function(){return {
	
	
	theUserTab					:false,
	theUserSystemFieldset		:false,
	theUserGuiFieldset			:false,
	theComboRoleStore			:false,
	theLanguageStore			:false,
	
	
	/** load all nedded functions **/
	init: function () {
		this.initLanguageStore();
		this.initRoleStore();
		this.initUserTab();
		this.initDefaultUserSystemFieldset();
		this.initDefaultUserGuiFieldset();
		this.theUserTab.add(this.theUserSystemFieldset);
		this.theUserTab.add(this.theUserGuiFieldset);
		
	},
	
	/** init the tab **/
	initUserTab: function () {
		this.theUserTab = new Ext.Panel({
			modal: true,
			closable: false,
			modal: true,
			width: 650,
			height: 600,
			autoScroll: false,
			title: '<?php echo __('User Settings',null,'systemsetting'); ?>',
			shadow: false,
			minimizable: false,
			draggable: false,
			resizable: false,
	        plain: false
		});
	},
	
	/** init tab for default gui settings **/
	initDefaultUserGuiFieldset: function () {
		this.theUserGuiFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Default user GUI settings',null,'systemsetting'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330,
			items:[{
				xtype: 'combo', // number of records to display in grid
				id: 'userTab_itemsperpage_id',
				mode: 'local',
				value: '25',
				fieldLabel: '<?php echo __('Items per page',null,'systemsetting'); ?>',
				editable:false,
				allowBlank: true,
				autoHeight:true,
				hiddenName: 'userTab_itemsperpage',
				triggerAction: 'all',
				foreSelection: true,
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[[25, '25'],[50, '50'],[75, '75'],[100, '100']]
   				}),
 				valueField:'id',
				displayField:'text',
				width:50
			},{
				xtype: 'combo', // number of records to display in grid
				id: 'userTab_refreshtime_id',
				mode: 'local',
				value: '30',
				fieldLabel: '<?php echo __('Refreshtime in seconds',null,'systemsetting'); ?>',
				editable:false,
				allowBlank: true,
				autoHeight:true,
				hiddenName: 'userTab_refreshtime',
				triggerAction: 'all',
				foreSelection: true,
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[[30, '30'],[60, '60'],[120, '120'],[180, '180'],[240, '240'], [300, '300']]
   				}),
 				valueField:'id',
				displayField:'text',
				width:50
			},{
				xtype: 'panel',
				layout: 'column',
				border: false,
				layoutConfig: {
					columns:3
				},
				labelWidth: 150,
				fieldLabel: '<?php echo __('Circulations default sort',null,'systemsetting'); ?>',
				width: 200,
				items: [{
					xtype: 'combo', // number of records to display in grid
					id: 'userTab_circulationdefaultsortcolumn_id',
					name: 'type',
					mode: 'local',
					value: 'NAME',
					editable:false,
					allowBlank: true,
					autoHeight:true,
					hiddenName: 'userTab_circulationdefaultsortcolumn',
					triggerAction: 'all',
					foreSelection: true,
					store: new Ext.data.SimpleStore({
						 fields:['id','text'],
	       				 data:[['NAME', '<?php echo __('Name',null,'systemsetting'); ?>'],['STATION', '<?php echo __('Station',null,'systemsetting'); ?>'],['DAYS', '<?php echo __('Days',null,'systemsetting'); ?>'],['START', '<?php echo __('Start',null,'systemsetting'); ?>'],['SENDER', '<?php echo __('Sender',null,'systemsetting'); ?>'],['TOTALTIME', '<?php echo __('Total time',null,'systemsetting'); ?>'],['MAILINGLIST', '<?php echo __('Mailing list',null,'systemsetting'); ?>'],['TEMPLATE', '<?php echo __('Template',null,'systemsetting'); ?>']]
	   				}),
	 				valueField:'id',
					displayField:'text',
					width:85				
				},{
    				xtype: 'panel',
    				html : '&nbsp;',
    				border: false,
					id: 'userTab_spacepanel1'
    			},{
					xtype: 'combo', // number of records to display in grid
					id: 'userTab_circulationdefaultsortdirection_id',
					name: 'type',
					mode: 'local',
					value: 'ASC',
					editable:false,
					allowBlank: true,
					autoHeight:true,
					hiddenName: 'userTab_circulationdefaultsortdirection',
					triggerAction: 'all',
					foreSelection: true,
					store: new Ext.data.SimpleStore({
						 fields:['id','text'],
	       				 data:[['ASC', '<?php echo __('Ascending',null,'systemsetting'); ?>'],['DESC', '<?php echo __('Descending',null,'systemsetting'); ?>']]
	   				}),
	 				valueField:'id',
					displayField:'text',
					width:100
				}]
			},{
				xtype:'textfield',
				fieldLabel: '<?php echo __('Change yellow after...days',null,'systemsetting'); ?>',
				width:40,
				value: '7',
				id:'userTab_markyellow'
			},{
				xtype:'textfield',
				fieldLabel: '<?php echo __('Change orange after...days',null,'systemsetting'); ?>',
				width:40,
				value: '10',
				id:'userTab_markorange'
			},{
				xtype:'textfield',
				fieldLabel: '<?php echo __('Change red after...days',null,'systemsetting'); ?>',
				width:40,
				value: '12',
				id:'userTab_markred'
			}]
		});
	},
	
	/** init tab for default system user settings **/
	initDefaultUserSystemFieldset: function () {
		this.theUserSystemFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Default user system settings',null,'systemsetting'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330,
			items:[{
				xtype: 'textfield',
				fieldLabel: '<?php echo __('Default Password',null,'systemsetting'); ?>',
				id: 'userTab_defaultpassword',
				width:197
			},{
				xtype: 'panel',
				layout: 'column',
				border: false,
				labelWidth: 150,
				fieldLabel: '<?php echo __('Useragent time',null,'systemsetting'); ?>',
				width: 200,
				layoutConfig: {
					columns: 3
				},
				items: [{
					xtype: 'textfield',
					id: 'userTab_defaultdurationlength',
					value: 1,
					allowBlank: false,
					style: 'margin-top:1px;',
					width:40
    			},{
    				xtype: 'panel',
    				html : '&nbsp;',
					id: 'userTab_spacepanel3',
    				border: false
    			},{
   
					xtype: 'combo', // number of records to display in grid
					id: 'userTab_defaultdurationtype_id',
					name: 'type',
					mode: 'local',
					value: 'DAYS',
					editable:false,
					height: 24,
					allowBlank: true,
					autoHeight:true,
					hiddenName: 'userTab_defaultdurationtype',
					triggerAction: 'all',
					foreSelection: true,
					store: new Ext.data.SimpleStore({
						 fields:['id','text'],
	       				 data:[['DAYS', '<?php echo __('Day(s)',null,'systemsetting'); ?>'],['HOURS', '<?php echo __('Hour(s)',null,'systemsetting'); ?>'],['MINUTES', '<?php echo __('Minute(s)',null,'systemsetting'); ?>']]
	   				}),
	 				valueField:'id',
					displayField:'text',
					width:159,
					height: 22
		
				}]
				},{
				xtype: 'panel',
				layout: 'column',
				border: false,
				layoutConfig: {
					columns: 3
				},
				labelWidth: 150,
				fieldLabel: '<?php echo __('Email Format',null,'systemsetting'); ?>',
				width: 200,
				items: [{
					xtype: 'combo',
					id: 'userTab_emailformat_id',
					mode: 'local',
					value: 'plain',
					editable:false,
					allowBlank: true,
					autoHeight:true,
					hiddenName: 'userTab_emailformat',
					triggerAction: 'all',
					foreSelection: true,
					store: new Ext.data.SimpleStore({
						 fields:['id','text'],
	       				 data:[['plain', '<?php echo __('Plain',null,'systemsetting'); ?>'],['html', '<?php echo __('HTML',null,'systemsetting'); ?>']]
	   				}),
	 				valueField:'id',
					displayField:'text',
					width:60,
					listeners: {
						select: {
							fn:function(combo, value) {
								if (Ext.getCmp('userTab_emailformat_id').getValue() == 'plain' && Ext.getCmp('userTab_emailtype_id').getValue() == 'IFRAME') {
									Ext.Msg.minWidth = 200;
									Ext.MessageBox.alert('<?php echo __('Notice',null,'usermanagement'); ?>', '<?php echo __('Plain cannot be combined with IFrame',null,'usermanagement'); ?>');
									Ext.getCmp('userTab_emailtype_id').setValue('VALUES');
								}
							}
						}
					}					
    			},{
    				xtype: 'panel',
    				html : '&nbsp;',
    				border: false,
					id: 'userTab_spacepanel2'
    			},{
					xtype: 'combo', // number of records to display in grid
					id: 'userTab_emailtype_id',
					mode: 'local',
					value: 'NONE',
					editable:false,
					allowBlank: true,
					autoHeight:true,
					hiddenName: 'userTab_emailtype',
					triggerAction: 'all',
					foreSelection: true,
					store: new Ext.data.SimpleStore({
						 fields:['id','text'],
	       				 data:[['NONE', '<?php echo __('None',null,'systemsetting'); ?>'],['VALUES', '<?php echo __('Only values',null,'systemsetting'); ?>'],['IFRAME', '<?php echo __('IFrame',null,'systemsetting'); ?>']]
	   				}),
	 				valueField:'id',
					displayField:'text',
					width:133,
					listeners: {
						select: {
							fn:function(combo, value) {
								if (Ext.getCmp('userTab_emailformat_id').getValue() == 'plain' && combo.getValue() == 'IFRAME') {
									Ext.Msg.minWidth = 200;
									Ext.MessageBox.alert('<?php echo __('Notice',null,'systemsetting'); ?>', '<?php echo __('Plain cannot be combined with IFrame',null,'systemsetting'); ?>');
									combo.setValue('VALUES');
								}
							}
						}
					}
					}]
				},{
					xtype: 'combo',
					fieldLabel : '<?php echo __('Userrole',null,'systemsetting'); ?>',
					id: 'userTab_userrole_id',
					valueField: 'id',
					mode: 'local',
					hiddenName : 'userTab_userrole',
					displayField: 'description',
					store: this.theComboRoleStore,
					editable: false,
					typeAhead: false,
					allowBlank: true,
					triggerAction: 'all',
					foreSelection: true,
					width: 197
				},{
					xtype: 'combo',
					fieldLabel : '<?php echo __('User language',null,'systemsetting'); ?>',
					id: 'userTab_language_id',
					valueField: 'value',
					displayField: 'text',
					mode: 'local',
					hiddenName : 'userTab_language',
					store: this.theLanguageStore,
					editable: false,
					typeAhead: false,
					allowBlank: true,
					triggerAction: 'all',
					foreSelection: true,
					width: 197
				}]
		});
		
	},
	
	/** set the userrole store **/
	initRoleStore: function () {
		this.theComboRoleStore = new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('usermanagement/LoadAllRole')?>',
				autoload: true,
				fields: [
					{name: 'id'},
					{name: 'description'}
				]
		});
		cf.userTab.theComboRoleStore.load();
	},
	
	initLanguageStore:function () {
		this.theLanguageStore = new Ext.data.JsonStore({
			mode: 'local',
			autoload: true,
			url: '<?php echo build_dynamic_javascript_url('login/LoadLanguage')?>',
			root: 'result',
			fields: [
				{name: 'value'},
				{name: 'text'}
			]
		});
		cf.userTab.theLanguageStore.load();
	},
	
	addData: function (data) {
		Ext.getCmp('userTab_defaultpassword').setValue(data.password);
		Ext.getCmp('userTab_defaultdurationlength').setValue(data.duration_length);
		Ext.getCmp('userTab_defaultdurationtype_id').setValue(data.duration_type);
		Ext.getCmp('userTab_emailformat_id').setValue(data.email_format);
		Ext.getCmp('userTab_emailtype_id').setValue(data.email_type);
		Ext.getCmp('userTab_userrole_id').setValue(data.role_id);
		
		Ext.getCmp('userTab_itemsperpage_id').setValue(data.displayed_item);
		Ext.getCmp('userTab_refreshtime_id').setValue(data.refresh_time);
		Ext.getCmp('userTab_circulationdefaultsortcolumn_id').setValue(data.circulation_default_sort_column);
		Ext.getCmp('userTab_circulationdefaultsortdirection_id').setValue(data.circulation_default_sort_direction);
		Ext.getCmp('userTab_markyellow').setValue(data.markyellow);
		Ext.getCmp('userTab_markorange').setValue(data.markorange);
		Ext.getCmp('userTab_markred').setValue(data.markred);
		
		Ext.getCmp('userTab_language_id').setValue(data.language);
		cf.administration_systemsetting.theLoadingMask.hide();
		
		
		if (Ext.isIE6 == true) {
			Ext.getCmp('userTab_defaultdurationlength').setSize({width:40, height: 24});
			Ext.getCmp('userTab_defaultdurationlength').style = ('margin-bottom:1px;margin-top:0px;margin-right:5px;');
			
			
			Ext.getCmp('userTab_spacepanel1').html = '';
			Ext.getCmp('userTab_spacepanel1').setSize({width:5,height:0});
			Ext.getCmp('userTab_spacepanel2').html = '';
			Ext.getCmp('userTab_spacepanel2').setSize({width:5,height:0});
			Ext.getCmp('userTab_spacepanel3').html = '';
			Ext.getCmp('userTab_spacepanel3').setSize({width:20,height:0});
			
		}
		else if(Ext.isOpera == true || Ext.isSafari == true) {
			Ext.getCmp('userTab_defaultdurationlength').setSize({width:40, height: 24});
			Ext.getCmp('userTab_defaultdurationlength').style = 'margin-bottom:1px;';
		}
		else if (Ext.isIE7 == true) {
			Ext.getCmp('userTab_defaultdurationlength').setSize({width:40, height: 24});

		}
		else if (Ext.isGecko == true) {
			Ext.getCmp('userTab_defaultdurationlength').style = 'margin-bottom:1px;';
			
		}
		
	}
	
	
	
	
	
	
};}();










