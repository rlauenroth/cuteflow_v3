cf.userAgentSetting = function(){return {
	
	theUserAgentTab			:false,
	theUserAgentFieldset	:false,
	theConfigFieldset		:false,
	

	init:function () {
		this.initUserAgentTab();
		this.initUserAgentFieldset();
		this.initConfigFieldset();
		this.theUserAgentTab.add(this.theUserAgentFieldset);
		this.theUserAgentTab.add(this.theConfigFieldset);
	},
	
	
	
	addData: function (data) {
		Ext.getCmp('useragent_useragentsettings').setValue(data.individualcronjob);
		if(data.individualcronjob == 1){
			cf.userAgentSetting.theConfigFieldset.setVisible(true);
		}
		else {
			cf.userAgentSetting.theConfigFieldset.setVisible(false);
		}
		Ext.getCmp('useragent_useragentcreation').setValue(data.setuseragenttype);
		for(var a=0;a<data.datestore.length;a++) {
			var item = data.datestore[a];
			var Rec = Ext.data.Record.create(
				{name: 'id'},
				{name: 'text'}
			);	
			Ext.getCmp('useragent_useragentsettings_to_id').store.add(new Rec({
				id: item.value,
				text: item.name
			}));
			Ext.getCmp('useragent_useragentsettings_from_id').store.add(new Rec({
				id: item.value,
				text: item.name
			}));
		}

		Ext.getCmp('useragent_useragentsettings_to_id').setValue(data.cronjobto);
		Ext.getCmp('useragent_useragentsettings_from_id').setValue(data.cronjobfrom);
		
		
		Ext.getCmp('useragent_useragentsettings_monday').setValue(data.cronjobdays.mon);
		Ext.getCmp('useragent_useragentsettings_tuesday').setValue(data.cronjobdays.tue);
		Ext.getCmp('useragent_useragentsettings_wednesday').setValue(data.cronjobdays.wed);
		
		Ext.getCmp('useragent_useragentsettings_thursday').setValue(data.cronjobdays.thu);
		Ext.getCmp('useragent_useragentsettings_friday').setValue(data.cronjobdays.fri);
		Ext.getCmp('useragent_useragentsettings_saturday').setValue(data.cronjobdays.sat);
		
		Ext.getCmp('useragent_useragentsettings_sunday').setValue(data.cronjobdays.son);
	},
	
	
	initUserAgentTab: function () {
		this.theUserAgentTab = new Ext.Panel({
			modal: true,
			closable: false,
			modal: true,
			width: 650,
			height: 600,
			autoScroll: false,
			title: '<?php echo __('Useragent Settings',null,'systemsetting'); ?>',
			shadow: false,
			minimizable: false,
			draggable: false,
			resizable: false,
	        plain: false
		});	
		
	},
	
	initConfigFieldset: function () {
		this.theConfigFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Useragent Settings',null,'systemsetting'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330,
			hidden: false,
			items:[{
				xtype:'label',
				html: '<span style="font-size:12px;font-family:Tahoma, Geneva, sans-serif;"><b><?php echo __('Cronjob will run on selected days',null,'systemsetting'); ?>:</b></span>'
			},{
				xtype:'checkbox',
				style: 'margin-top:3px;',
				inputValue: '1',
				name: 'useragenttime[0]',
				id: 'useragent_useragentsettings_monday',
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Monday',null,'systemsetting'); ?>'
			},{
				xtype:'checkbox',
				style: 'margin-top:3px;',
				inputValue: '2',
				id: 'useragent_useragentsettings_tuesday',
				name: 'useragenttime[1]',
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Tuesday',null,'systemsetting'); ?>'
			},{
				xtype:'checkbox',
				style: 'margin-top:3px;',
				inputValue: '4',
				name: 'useragenttime[2]',
				id: 'useragent_useragentsettings_wednesday',
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Wednesday',null,'systemsetting'); ?>'
			},{
				xtype:'checkbox',
				style: 'margin-top:3px;',
				inputValue: '8',
				name: 'useragenttime[3]',
				id: 'useragent_useragentsettings_thursday',
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Thursday',null,'systemsetting'); ?>'
			},{
				xtype:'checkbox',
				style: 'margin-top:3px;',
				inputValue: '16',
				name: 'useragenttime[4]',
				id: 'useragent_useragentsettings_friday',
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Friday',null,'systemsetting'); ?>'
			},{
				xtype:'checkbox',
				style: 'margin-top:3px;',
				inputValue: '32',
				name: 'useragenttime[5]',
				id: 'useragent_useragentsettings_saturday',
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Saturday',null,'systemsetting'); ?>'
			},{
				xtype:'checkbox',
				style: 'margin-top:3px;',
				inputValue: '64',
				name: 'useragenttime[6]',
				id: 'useragent_useragentsettings_sunday',
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Sonday',null,'systemsetting'); ?>'
			},{
				xtype:'label',
				html: '<span style="font-size:12px;font-family:Tahoma, Geneva, sans-serif;"><b><?php echo __('Set Time when cronjob will run',null,'systemsetting'); ?>:</b></span>'
			},{
				xtype: 'combo',
				mode: 'local',
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Time from',null,'systemsetting'); ?>',
				editable:false,
				id: 'useragent_useragentsettings_from_id',
				allowBlank: true,
				valueField:'id',
				hiddenName : 'useragent_useragentsettings_from',
				width: 70,
				displayField:'text',
				triggerAction: 'all',
				foreSelection: true,
				store: new Ext.data.SimpleStore({
					 fields:['id','text']
   				})
			},{
				
				xtype: 'combo',
				mode: 'local',
				editable:false,
				id: 'useragent_useragentsettings_to_id',
				allowBlank: true,
				valueField:'id',
				hiddenName : 'useragent_useragentsettings_to',
				width: 70,
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Time to',null,'systemsetting'); ?>',
				displayField:'text',
				triggerAction: 'all',
				foreSelection: true,
				store: new Ext.data.SimpleStore({
					 fields:['id','text']
   				})
			}]
		});	
	},
	
	initUserAgentFieldset: function () {
		this.theUserAgentFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Useragent Settings',null,'systemsetting'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330,
			items:[{
				xtype:'checkbox',
				style: 'margin-top:3px;',
				inputValue: '1',
				id: 'useragent_useragentsettings',
				fieldLabel: '<?php echo __('Set Time for UserAgent Cronjob',null,'systemsetting'); ?>',
				handler: function (check) {
					if(check.checked) {
						cf.userAgentSetting.theConfigFieldset.setVisible(true);
					}
					else {
						cf.userAgentSetting.theConfigFieldset.setVisible(false);
					}
				}
			},{
				xtype:'checkbox',
				style: 'margin-top:3px;',
				inputValue: '1',
				id: 'useragent_useragentcreation',
				fieldLabel: '<?php echo __('Add useragents when cronjob time is exceeded',null,'systemsetting'); ?>'			
			}]
		});
	}

	
};}();


