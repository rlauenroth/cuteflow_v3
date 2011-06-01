/** tab to change systemsettings **/
cf.systemTab = function(){return {

	theSystemTab				:false,
	theLanguageFieldset			:false,
	theWorkflowFieldset			:false,
	theLanguageCombo			:false,
	theColorFieldset			:false,
	theComboStore				:false,
	thePicker					:false,
	
	
	/** load all nedded functions **/
	init: function () {
		this.initStore();
		this.initLanguageFieldset();
		this.initColorPicker();
		this.initColorFieldset();
		this.theColorFieldset.add(this.thePicker);
		this.initWorkflowSettingsFieldset();
		this.initSystemTab();
		this.theSystemTab.add(this.theLanguageFieldset);
		this.theSystemTab.add(this.theWorkflowFieldset);
		this.theSystemTab.add(this.theColorFieldset);
	},
	
	/** init the tab **/
	initSystemTab: function () {
		this.theSystemTab = new Ext.Panel({
			modal: true,
			closable: false,
			modal: true,
			width: 650,
			height: 600,
			autoScroll: false,
			title: '<?php echo __('System settings',null,'systemsetting'); ?>',
			shadow: false,
			minimizable: false,
			draggable: false,
			resizable: false,
	        plain: false
		});
	},
	
	initColorFieldset: function () {
		this.theColorFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Set Background of Navigation north',null,'systemsetting'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330
		});
			
		
	},
	
	initColorPicker: function () {
		this.thePicker = new Ext.form.ColorField({
			fieldLabel: '<?php echo __('Select color',null,'systemsetting'); ?>',
			id: 'systemsetting_color',
			width: 230,
			editable: true,
			allowBlank: false
		});
		
	},
	
	
	/** init workflow settings **/
	initWorkflowSettingsFieldset: function () {
		this.theWorkflowFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Workflow settings',null,'systemsetting'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330,
			items:[{
				xtype: 'checkbox',
				fieldLabel: '<?php echo __('Show position in Mail',null,'systemsetting'); ?>?',
				inputValue: "1",
				id: 'systemsetting_showposition'
			},{
				xtype: 'checkbox',
				fieldLabel: '<?php echo __('Send Mails to circulation receivers',null,'systemsetting'); ?>',
				inputValue: "1",
				id: 'systemsetting_sendreceivermail'
			},{
				xtype: 'checkbox',
				fieldLabel: '<?php echo __('Send Reminder-EMails with all open circulations',null,'systemsetting'); ?><br /> (<?php echo __('Activated Cronjob needed',null,'systemsetting'); ?>)',
				inputValue: "1",
				id: 'systemsetting_sendremindermail'
			},{
				xtype: 'combo',
				editable:false,
 				value: 'CURRENT',
				mode: 'local',
 				id: 'systemsetting_slotvisible_id',
 				displayField:'text',
 				valueField:'id',
				triggerAction: 'all',
				foreSelection: true,
 				hiddenName : 'systemsetting_slotvisible',
				fieldLabel: '<?php echo __('Slot-Visibility',null,'systemsetting'); ?>',
				width: 230,
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[['CURRENT', '<?php echo __('Only current user slot',null,'systemsetting'); ?>'],['TEMPLATE', '<?php echo __('All Slots, order as defined in template',null,'systemsetting'); ?>'],['TOPMOST', '<?php echo __('All Slots, current user slot topmost',null,'systemsetting'); ?>']]
   				})
			}]
		});
		
	},
	
	/** init language fieldset with combo **/
	initLanguageFieldset: function () {
		this.theLanguageFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Default system language',null,'systemsetting'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330,
			items:[{
				xtype: 'combo',
				editable:false,
 				valueField:'value',
				mode: 'local',
 				id: 'systemsetting_language_id',
 				hiddenName : 'systemsetting_language',
				value: '<?php echo Language::buildDefaultLanguage(Language::loadDefaultLanguage());?>',
				displayField:'text',
				fieldLabel: '<?php echo __('Select language',null,'systemsetting'); ?>',
				triggerAction: 'all',
				foreSelection: true,
				width: 230,
				store: this.theComboStore
			}]
		});
	},
	
	/** load store with all languages in the sysetm **/
	initStore: function () {
		this.theComboStore = new Ext.data.JsonStore({
			mode: 'local',
			autoload: true,
			url: '<?php echo build_dynamic_javascript_url('login/LoadLanguage')?>',
			root: 'result',
			fields: [
				{name: 'value'},
				{name: 'text'}
			]
		});
		
	},
	
	
	addData: function (data) {
		cf.systemTab.addLanguage.defer(500, this, [data.language]);
		
		Ext.getCmp('systemsetting_showposition').setValue(data.show_position_in_mail);
		Ext.getCmp('systemsetting_sendreceivermail').setValue(data.send_receiver_mail);
		Ext.getCmp('systemsetting_sendremindermail').setValue(data.send_reminder_mail);
		Ext.getCmp('systemsetting_slotvisible_id').setValue(data.visible_slots);
		Ext.getCmp('systemsetting_color').setValue(data.color_of_north_region);
		
	},
	
	addLanguage: function (data) {
		Ext.getCmp('systemsetting_language_id').setValue(data);
	}
	



};}();