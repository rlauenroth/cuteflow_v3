cf.installerSettingsTab = function(){return {
	
	theLanguageFieldset				:false,
	theComboStore					:false,
	
	
	init: function () {
		this.initPanel();
		this.initStore();
		this.initLanguageFieldset();
		this.thePanel.add(this.theLanguageFieldset);
		
	},
	
	initPanel: function () {
		this.thePanel = new Ext.Panel({
			modal: false,
			closable: false,
			title: '<?php echo __('Installer language',null,'installer'); ?>, <?php echo __('Step',null,'installer'); ?>: 1/4',
			layout: 'form',
			width: 750,
			height: 490,
			autoScroll: true,
			shadow: false,
			minimizable: false,
			autoScroll: false,
			draggable: false,
			resizable: false,
			plain: false
		});
		
	},
	
	
	initLanguageFieldset: function () {
		var userLanguage = '<?php echo $sf_user->getCulture(); ?>';
		var systemLanguage = '<?php echo Installer::getInstallerLanguage(); ?>';
		if(userLanguage.length != 2) {
			var language = '<?php echo Installer::getLanguage($sf_user->getCulture());?>';
		}
		else {
			var language = systemLanguage;
		}
		this.theLanguageFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Installer language',null,'installer'); ?>',
			width: 600,
			height: 100,
			labelWidth: 220,
			style: 'margin-top:20px;margin-left:5px;',
			items:[{
				xtype: 'combo',
				mode: 'local',
				editable:false,
 				valueField:'value',
 				disabled: false,
 				id: 'installer_language_id',
 				hiddenName : 'installer_language',
				displayField:'text',
				selectOnFocus: true,
				value: language,
				triggerAction: 'all',
				foreSelection: true,
   				fieldLabel: '<?php echo __('Language',null,'installer'); ?>',
   				width: 200,
				store: this.theComboStore,
				listeners: {
					select: {
						fn:function(combo, value) {
							var id = (Ext.getCmp('installer_language_id').getValue());
							Ext.Ajax.request({
								url : '<?php echo build_dynamic_javascript_url('installer/changeLanguage')?>/value/' + id,
								success: function(objServerResponse){
									var url = Ext.get('url_installer').dom.value;
									window.location = url;
								}
							});
						}
					}
				}
				
			}]
		});
		Ext.getCmp('installer_language_id').on('afterrender', function(grid) {
			cf.installerSettingsTab.theComboStore.load();
		});
	},
	
	initStore: function () {
		this.theComboStore = new Ext.data.JsonStore({
			mode: 'local',
			autoload: true,
			url: Ext.get('hidden_loadlanguage').dom.value,
			root: 'result',
			fields: [
				{name: 'value'},
				{name: 'text'}
			]
		});
		
	}
	
	
	
	
};}();