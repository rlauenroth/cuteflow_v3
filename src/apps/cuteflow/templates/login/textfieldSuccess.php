/**
* Class builds all all necessary Textfields for the Loginpage
*
*/


cf.Textfield = function(){return {
	
	theUsernameField   	: false,
	theUserpasswordField	: false,
	theHiddenField		: false,
	thePanel		: false,
	theHiddenURL		: false,
	
	/** Functions calls all necessary functions to init the login window **/
	init: function(){
		this.initUsernameField();
		this.initUserpasswordField();
		this.initHiddenField();
		this.initHiddenUrl();
		this.initPanel();
	}, 
	
	/** Textfield **/
	initUsernameField: function() {
		this.theUsernameField = new Ext.form.TextField({
			id: 'username',
			fieldLabel: '<?php echo __('Username',null,'login'); ?>',
			allowBlank: false,
			style: 'margin-top:2px',
			enableKeyEvents : true,
			width: 225
		});
		this.theUsernameField.on('keyup', function(field, event) {
			if(event.getCharCode() == 13) {
				cf.Window.handleLogin();
			}
		});
	},
	/** Hiddenfield **/
	initHiddenField: function () {
		this.theHiddenField =  new Ext.form.Hidden({
			name: 'hiddenfield_language',
			allowBlank: true,
			value: '<?php echo $sf_user->getCulture()?>',
			width: 225
		});
	},
	
	/** init hiddenurl **/
	initHiddenUrl: function () {
		this.theHiddenURL =  new Ext.form.Hidden({
			name: 'hidden_symfonyurl',
			allowBlank: true,
			width: 225
		});
		
	},
	
	/** Textfield **/
	initUserpasswordField: function() {
		this.theUserpasswordField = new Ext.form.TextField({
			id:'userpassword',
			fieldLabel: '<?php echo __('Password',null,'login'); ?>',
			allowBlank: false,
			inputType: 'password',
			enableKeyEvents: true,
			width: 225                       
		});
		this.theUserpasswordField.on('keyup', function(field, event) {
			if(event.getCharCode() == 13) {
				cf.Window.handleLogin();
			}
		});
	},
	
	/** Panel, where all textfields and combo will be added **/
	initPanel: function() {
		this.thePanel = new Ext.FormPanel({
			plain: false,
			frame: true,
			height: 100,
			layout : 'fit',
			buttonAlign: 'center',
		    layout: 'form'
		});
	}
	
};}();