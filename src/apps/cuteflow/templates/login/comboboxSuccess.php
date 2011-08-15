/**
* Class builds the combobox for the login page, and
* implements Ajax functionality to change the language on the fly.
*
*/


cf.ComboBox = function(){return {
	theComboBox : false,
	theComboStore: false,
	
	/** Function inits the Store for combo and the combobox **/
	init: function () {
		this.initStore();
		this.initCombobox();
	},
	

	/** Combobox is initialzed here, the Combo is needed to change the language before login, Combo also handles ajax functionality to change the language in frontend **/
	initCombobox: function () {
		this.theComboBox = new Ext.form.ComboBox({
			fieldLabel: '<?php echo __('Language',null,'login'); ?>',
			valueField: 'value',
			displayField: 'text',
			editable: false,
			mode: 'local',
			store: this.theComboStore,
			triggerAction: 'all',
			selectOnFocus:true,
			allowBlank: true,
			forceSelection:true,
			id:'language',
			value: '<?php echo I18nUtil::buildDefaultLanguage(SystemConfigurationTable::getInstance()->loadDefaultLanguage());?>',
			width: 225,
			listeners: {
				select: {
					fn:function(combo, value) {
						Ext.Ajax.request({  
							url : Ext.get('hidden_changelanguage').dom.value + '/language/' + combo.getValue(), 
							success: function(objServerResponse){  
								var ServerResult = Ext.util.JSON.decode(objServerResponse.responseText);
								cf.Textfield.theUsernameField.setLabel((ServerResult.result.username) + ':'); 
								cf.Textfield.theUserpasswordField.setLabel((ServerResult.result.password) + ':'); 
								combo.setLabel((ServerResult.result.language) + ':');	
								Ext.getCmp('loginButton').setText(ServerResult.result.login);
								Ext.getCmp('cancelButton').setText(ServerResult.result.close);
								cf.Window.theWindow.setTitle('<div style="float:left;"><img src="/images/icons/key.png" /></div><div>&nbsp;&nbsp;CuteFlow - ' + ServerResult.result.login + '</div>');
								// store selected language here
								cf.Textfield.theHiddenField.setValue(combo.getValue());
								// refresh ComboBox here
								var hasFocus = cf.ComboBox.theComboBox.hasFocus;
								cf.ComboBox.theComboBox.hasFocus = null;
								cf.ComboBox.theComboStore.reload({callback: function(){
										if(cf.ComboBox.theComboBox.hasFocus === null){
											cf.ComboBox.theComboBox.hasFocus = hasFocus;
										}
									}
								});
								cf.ComboBox.theComboBox.setValue(ServerResult.defaultValue);
								cf.Textfield.theUsernameField.focus();
							}
						});
					}
				
				}
			}
		});
		if (Ext.isGecko == true) {
			Ext.getCmp('language').style = 'margin-bottom:1px;';
			
		}
	}, 
	
	/** Store for combo **/
	initStore: function () {
		this.theComboStore = new Ext.data.JsonStore({
			mode: 'local',
			autoload: true,
			url: Ext.get('hidden_loadlanguage').dom.value,
			root: 'result',
			fields: [{name: 'value'},{name: 'text'}]
		});
		cf.ComboBox.theComboStore.load();
	}
};}();

/** need to override extjs Field, to change the Labels on the fly using ajax **/
Ext.override(Ext.form.Field, {
   setLabel: function(text){
      var r = this.getEl().up('div.x-form-item');
      r.dom.firstChild.firstChild.nodeValue = String.format('{0}', text);
   }
});