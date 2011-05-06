/** tab to change emailsending settings **/
cf.emailTab = function(){return {
	
	theEmailTab				:false,
	theEmailReplay			:false,
	theEmailSendingType		:false,
	
	/** call all necessary functions **/
	init: function () {
		this.initEmail();
		this.initSendingType();
		this.initEmailTab();
		this.theEmailTab.add(this.theEmailReplay);
		this.theEmailTab.add(this.theEmailSendingType);
	},
	
	/** builds the tab **/
	initEmailTab: function () {
		this.theEmailTab = new Ext.Panel({
			modal: true,
			closable: false,
			modal: true,
			width: 650,
			height: 600,
			autoScroll: true,
			title: '<?php echo __('Email',null,'systemsetting'); ?>',
			shadow: false,
			minimizable: false,
			draggable: false,
			resizable: false,
	        plain: false
		});
	},
	
	/** set Fieldset with textfield to enter Systemreplayaddress **/
	initEmail: function () {
		this.theEmailReplay = new Ext.form.FieldSet({
			title: '<?php echo __('Reply Settings',null,'systemsetting'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 330,
			items:[{
				xtype: 'checkbox',
				width: 200,
				id: 'emailtab_allowsendingemails',
				allowBlank: false,
				inputValue: "1",
				fieldLabel: '<?php echo __('Allow System to send Emails',null,'systemsetting'); ?>?'
			},{
				xtype: 'textfield',
				width: 200,
				id: 'emailtab_systemreplyaddress',
				allowBlank: false,
				vtype:'email',
				fieldLabel: '<?php echo __('System reply address',null,'systemsetting'); ?>'
			}]
		});
	},
	
	/** 
	*
	* inits fieldset with combo to change the sending type. choose between smtp, mail, sendmail 
	* functions contains changing code
	**/
	initSendingType: function () {
		this.theEmailSendingType = new Ext.form.FieldSet({
			title: '<?php echo __('Email Settings',null,'systemsetting'); ?>',
			width: 600,
			height: 'auto',
			labelWidth: 330,
			style: 'margin-top:20px;margin-left:5px;',
			items:[{
				xtype: 'combo',
				mode: 'local',
				editable:false,
 				valueField:'id',
 				value: 'SMTP',
 				disabled: false,
 				id: 'emailtab_emailtype_id',
 				hiddenName : 'emailtab_emailtype',
				displayField:'text',
				selectOnFocus: true,
				triggerAction: 'all',
				foreSelection: true,
   				fieldLabel: '<?php echo __('Sending type of email',null,'systemsetting'); ?>',
   				width: 200,
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[['SMTP', '<?php echo __('SMTP',null,'systemsetting'); ?>'],['MAIL', '<?php echo __('PHP Mail',null,'systemsetting'); ?>'],['SENDMAIL', '<?php echo __('Sendmail',null,'systemsetting'); ?>']]
   				}),
				listeners: {
					select: {
						fn:function(combo, value) {
							if(combo.getValue() == 'SMTP') {
								Ext.getCmp('email_sendmail').hide();
								Ext.getCmp('email_smtp_server').setVisible(true);
								Ext.getCmp('email_smtp_port').setVisible(true);
								Ext.getCmp('email_smtp_username').setVisible(true);
								Ext.getCmp('email_smtp_password').setVisible(true);
								//Ext.getCmp('email_smtp_auth').setVisible(true);
								Ext.getCmp('emailtab_encryption_id').setVisible(true);
								//cf.emailTab.theEmailSendingType.setHeight(250);
							}
							else if (combo.getValue() == 'SENDMAIL') {
								Ext.getCmp('email_smtp_server').hide();
								Ext.getCmp('email_smtp_port').hide();
								Ext.getCmp('email_smtp_username').hide();
								Ext.getCmp('email_smtp_password').hide();
								//Ext.getCmp('email_smtp_auth').hide();
								Ext.getCmp('emailtab_encryption_id').hide();
								Ext.getCmp('email_sendmail').setVisible(true);
								//cf.emailTab.theEmailSendingType.setHeight(100);
							}
							else {
								
								Ext.getCmp('email_smtp_server').hide();
								Ext.getCmp('email_smtp_port').hide();
								Ext.getCmp('email_smtp_username').hide();
								Ext.getCmp('email_smtp_password').hide();
								Ext.getCmp('email_sendmail').hide();
								//Ext.getCmp('email_smtp_auth').hide();
								Ext.getCmp('emailtab_encryption_id').hide();
								//cf.emailTab.theEmailSendingType.setHeight(80);
							}
						}
					}
				}
				
			},{
				xtype : 'textfield',
				fieldLabel: '<?php echo __('SMTP Host',null,'systemsetting'); ?>',
				id: 'email_smtp_server',
				width:200
			},{
				xtype : 'textfield',
				fieldLabel: '<?php echo __('SMTP Port',null,'systemsetting'); ?>',
				id: 'email_smtp_port',
				width:200
			},{
				xtype : 'textfield',
				fieldLabel: '<?php echo __('SMTP Username',null,'systemsetting'); ?>',
				id: 'email_smtp_username',
				width:200
			},{
				xtype : 'textfield',
				fieldLabel: '<?php echo __('SMTP Password',null,'systemsetting'); ?>',
				id: 'email_smtp_password',
				width:200
			},{
				xtype : 'checkbox',
				fieldLabel: '<?php echo __('SMTP Use authentication',null,'systemsetting'); ?>',
				id: 'email_smtp_auth',
				hidden: true,
				width:200
				
			},{
				xtype: 'combo',
				mode: 'local',
				editable:false,
 				valueField:'id',
 				value: 'NONE',
 				id: 'emailtab_encryption_id',
 				hiddenName : 'emailtab_encryption',
				displayField:'text',
				triggerAction: 'all',
				foreSelection: true,
   				fieldLabel: '<?php echo __('SMPT Used Encryption',null,'systemsetting'); ?>',
   				width:200,
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[['NONE', '<?php echo __('no encryption',null,'systemsetting'); ?>'],['ssl', '<?php echo __('SSL',null,'systemsetting'); ?>'],['tls', '<?php echo __('TLS',null,'systemsetting'); ?>']]
   				})
				
			},{
				xtype : 'textfield',
				fieldLabel: '<?php echo __('Absolute path of Sendmail',null,'systemsetting'); ?> (<?php echo __('e.g.',null,'systemsetting'); ?> /usr/bin/sendmail -bs)',
				id: 'email_sendmail',
				width:200
			}]

		});
		
	},
	
	/** add data for email tab to the combo and textfields **/
	addData: function (data) {
			Ext.getCmp('emailtab_systemreplyaddress').setValue(data.systemreplyaddress);
			Ext.getCmp('emailtab_allowsendingemails').setValue(data.allowemailtransport);
			
			
			Ext.getCmp('email_sendmail').setValue(data.sendmailpath);
			Ext.getCmp('email_smtp_server').setValue(data.smtphost);
			Ext.getCmp('email_smtp_port').setValue(data.smtpport);
			Ext.getCmp('email_smtp_username').setValue(data.smtpusername);
			Ext.getCmp('email_smtp_password').setValue(data.smtppassword);
			
			//Ext.getCmp('email_smtp_auth').setValue(data.smtpuseauth);
			Ext.getCmp('emailtab_encryption_id').setValue(data.smtpencryption);
			Ext.getCmp('emailtab_emailtype_id').setValue(data.activetype);
			Ext.getCmp('emailtab_systemreplyaddress').setValue(data.systemreplyaddress);
			
			if (data.activetype == 'SMTP'){
				Ext.getCmp('email_sendmail').hide();
				//cf.emailTab.theEmailSendingType.setHeight(250);
				cf.emailTab.theEmailSendingType.setWidth(600);
			}
			else if(data.activetype == 'SENDMAIL') {
				Ext.getCmp('email_smtp_server').hide();
				Ext.getCmp('email_smtp_port').hide();
				Ext.getCmp('email_smtp_username').hide();
				Ext.getCmp('email_smtp_password').hide();
				//Ext.getCmp('email_smtp_auth').hide();
				Ext.getCmp('emailtab_encryption_id').hide();
				//cf.emailTab.theEmailSendingType.setHeight(100);
				cf.emailTab.theEmailSendingType.setWidth(600);
			}
			else {
				Ext.getCmp('email_smtp_server').hide();
				Ext.getCmp('email_smtp_port').hide();
				Ext.getCmp('email_smtp_username').hide();
				Ext.getCmp('email_smtp_password').hide();
				Ext.getCmp('email_smtp_auth').hide();
				Ext.getCmp('email_sendmail').hide();
				Ext.getCmp('emailtab_encryption_id').hide();
				//cf.emailTab.theEmailSendingType.setHeight(80);
				cf.emailTab.theEmailSendingType.setWidth(600);
			}
		}

};}();

Ext.override(Ext.layout.FormLayout, {
	renderItem : function(c, position, target){
		if(c && !c.rendered && (c.isFormField || c.fieldLabel) && c.inputType != 'hidden'){
			var args = this.getTemplateArgs(c);
			if(typeof position == 'number'){
				position = target.dom.childNodes[position] || null;
			}
			if(position){
				c.itemCt = this.fieldTpl.insertBefore(position, args, true);
			}else{
				c.itemCt = this.fieldTpl.append(target, args, true);
			}
			c.actionMode = 'itemCt';
			c.render('x-form-el-'+c.id);
			c.container = c.itemCt;
			c.actionMode = 'container';
		}else {
			Ext.layout.FormLayout.superclass.renderItem.apply(this, arguments);
		}
	}
});
Ext.override(Ext.form.Field, {
	getItemCt : function(){
		return this.itemCt;
	}
});