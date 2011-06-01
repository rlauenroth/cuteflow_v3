/** tab to change authentication settings **/
cf.authTab = function(){return {

	theAuthTab				:false,
	theFieldset				:false,
	theOpenIdFieldset		:false,
	theLdapFieldset			:false,

	
	/** init all needed functions **/
	init: function () {
		this.initOpenIdFieldset();
		this.initLdapFieldset();
		this.initTypeFieldset();
		this.initAuthTab();
		this.theAuthTab.add(this.theFieldset);
		this.theAuthTab.add(this.theOpenIdFieldset);
		this.theAuthTab.add(this.theLdapFieldset);
	},
	
	/** fieldset for ldap authentication **/
	initLdapFieldset: function () {
		this.theLdapFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('LDAP Settings',null,'systemsetting'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330,
			items: [{
				xtype: 'checkbox',
				fieldLabel: '<?php echo __('Add User automatic to Cuteflowdatabase when in LDAP',null,'systemsetting'); ?>?',
				inputValue: "1",
				id: 'auth_ladp_adduser'	
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_host',
				fieldLabel: '<?php echo __('LDAP Host',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_domain',
				fieldLabel: '<?php echo __('LDAP Domain',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_bindusernameandcontext',
				fieldLabel: '<?php echo __('LDAP Bind Username and Context',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_password',
				fieldLabel: '<?php echo __('LDAP Password',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_rootcontext',
				fieldLabel: '<?php echo __('LDAP Root Context',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_usersearchattribute',
				fieldLabel: '<?php echo __('LDAP User Search Attribute',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_firstname',
				fieldLabel: '<?php echo __('LDAP Firstname Attribute',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_lastname',
				fieldLabel: '<?php echo __('LDAP Lastname Attribute',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_username',
				fieldLabel: '<?php echo __('LDAP Username Attribute',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_email',
				fieldLabel: '<?php echo __('LDAP Email Attribute',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_office',
				fieldLabel: '<?php echo __('LDAP Office Attribute',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_phone',
				fieldLabel: '<?php echo __('LDAP Phone Attribute',null,'systemsetting'); ?>'
			},{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_ladp_context',
				fieldLabel: '<?php echo __('LDAP Context',null,'systemsetting'); ?>'
			}]
		});
	},
	
	/** fieldset for OpenID authentication **/
	initOpenIdFieldset: function () {
		this.theOpenIdFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('OpenID Server',null,'systemsetting'); ?>',
			width: 600,
			height: 80,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330,
			items: [{
				xtype:'textfield',
				allowBlank: true,
				width: 230, 
				id: 'auth_openid_server',
				fieldLabel: '<?php echo __('OpenID Server',null,'systemsetting'); ?>'
			}]
		});
	},
	
	/** init the panel **/
	initAuthTab: function () {
		this.theAuthTab = new Ext.Panel({
			modal: true,
			closable: false,
			modal: true,
			width: 650,
			height: 600,
			autoScroll: true,
			title: '<?php echo __('Authentication settings',null,'systemsetting'); ?>',
			shadow: false,
			minimizable: false,
			draggable: false,
			resizable: false,
	        plain: false
		});
	},
	
	/** init fieldset, with combo to change the authentication type **/
	initTypeFieldset: function () {
		this.theFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('use only CuteFLow Database',null,'systemsetting'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330,
			items: [{
				xtype: 'combo',
				fieldLabel: '<?php echo __('Select authentication type',null,'systemsetting'); ?>',
				mode: 'local',
				editable:false,
 				valueField:'id',
 				id: 'authentication_type_id',
 				hiddenName : 'authentication_type',
				displayField:'text',
				triggerAction: 'all',
				foreSelection: true,
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[['DBONLY', '<?php echo __('use only CuteFlow Database',null,'systemsetting'); ?>'],['DATABASE_LDAP', '<?php echo __('use CuteFlow Database and LDAP',null,'systemsetting'); ?>'],['DATABASE_OPENID', '<?php echo __('use CuteFlow Database and OpenID',null,'systemsetting'); ?>']]
   				}),
   				fieldLabel: '<?php echo __('Select Authentication',null,'systemsetting'); ?>',
   				width:230,
				listeners: {
					select: {
						fn:function(combo, value) {
							if(combo.getValue() == 'DBONLY') {
								cf.authTab.theOpenIdFieldset.setVisible(false);
								cf.authTab.theLdapFieldset.setVisible(false);
							}
							else if (combo.getValue() == 'DATABASE_LDAP') {
								cf.authTab.theLdapFieldset.setVisible(true);
								cf.authTab.theOpenIdFieldset.setVisible(false);
							}
							else {
								cf.authTab.theOpenIdFieldset.setVisible(true);
								cf.authTab.theLdapFieldset.setVisible(false);
							}
						}
					}
				}
			},{
				xtype: 'checkbox',
				fieldLabel: '<?php echo __('Show MyProfile Tab on Users First-Login',null,'systemsetting'); ?>?',
				style: 'margin-top:3px;',
				inputValue: "1",
				id: 'authentication_firstlogin'
			},{
				xtype: 'checkbox',
				fieldLabel: '<?php echo __('Allow direct Login from Emails',null,'systemsetting'); ?>?',
				style: 'margin-top:3px;',
				inputValue: "1",
				id: 'authentication_allowdirectlogin'
			}]
		});
	},
	
	/** 
	*
	* write all data to auth Tab 
	* @param json_collection data, json data
	*/
	addData: function (data) {
		
		Ext.getCmp('auth_openid_server').setValue(data.openidserver);
		
		Ext.getCmp('auth_ladp_adduser').setValue(data.ldap_add_user);
		Ext.getCmp('auth_ladp_host').setValue(data.ldap_host);
		Ext.getCmp('auth_ladp_domain').setValue(data.ldap_domain);
		Ext.getCmp('auth_ladp_bindusernameandcontext').setValue(data.ldap_bind_username_and_context);
		Ext.getCmp('auth_ladp_password').setValue(data.ldap_password);
		Ext.getCmp('auth_ladp_rootcontext').setValue(data.ldap_root_context);
		Ext.getCmp('auth_ladp_usersearchattribute').setValue(data.ldap_user_search_attribute);
		Ext.getCmp('auth_ladp_firstname').setValue(data.ldap_firstname);
		Ext.getCmp('auth_ladp_lastname').setValue(data.ldap_lastname);
		Ext.getCmp('auth_ladp_username').setValue(data.ldap_username);
		Ext.getCmp('auth_ladp_email').setValue(data.ldap_email);
		Ext.getCmp('auth_ladp_office').setValue(data.ldap_office);
		Ext.getCmp('auth_ladp_phone').setValue(data.ldap_phone);
		Ext.getCmp('auth_ladp_context').setValue(data.ldap_context);
		Ext.getCmp('authentication_firstlogin').setValue(data.first_login);
		Ext.getCmp('authentication_allowdirectlogin').setValue(data.allow_direct_login);
		
		
		if(data.authentication_type == 'DBONLY') {
			cf.authTab.theOpenIdFieldset.setVisible(false);
			cf.authTab.theLdapFieldset.setVisible(false);
		}
		else if (data.authentication_type == 'DATABASE_LDAP') {
			cf.authTab.theLdapFieldset.setVisible(true);
			cf.authTab.theOpenIdFieldset.setVisible(false);
		}
		else {
			cf.authTab.theOpenIdFieldset.setVisible(true);
			cf.authTab.theLdapFieldset.setVisible(false);
		}
		
		Ext.getCmp('authentication_type_id').setValue(data.authentication_type);
		
		
	}


};}();