/** class creates a panel to send message to all users **/
cf.administration_sendmessage = function(){return {
	
	theSystemMessageWindow			:false,
	theTxtfield						:false,
	isInitialized					:false,
	theSendMessagePanel				:false,
	theMessageBox					:false,
	theReceiver						:false,
	theButtons						:false,
	
	
	/** init function **/
	init:function () {
		if (this.isInitialized == false) {
			this.isInitialized = true;
			this.initSubject();
			this.initPanel();
			this.initMessagebox();
			this.initReceiver();
			this.initButtons();
			this.initWindow();
			this.theSendMessagePanel.add(this.theTxtfield);
			this.theSendMessagePanel.add(this.theMessageBox);
			this.theSendMessagePanel.add(this.theReceiver);
			this.theSendMessagePanel.add(this.theButtons);
			this.theSystemMessageWindow.add(this.theSendMessagePanel);
		}
		
	},
	
	
	/** set the tab to the window **/
	initWindow: function () {
		this.theSystemMessageWindow =  new Ext.Panel({
			modal: true,
			closable: true,
			modal: true,
			shadow: false,
			minimizable: false,
			draggable: false,
			resizable: false,
	        plain: false,
	        //width: 620,
	        //height: 600,
	        layout: 'fit',
	        title: '<?php echo __('Send Message',null,'sendmessage'); ?>'
	    });
		
	},
	
	/** init Formpanel **/
	initPanel: function () {
		this.theSendMessagePanel = new Ext.FormPanel({
			closable: false,
			plain: false,
			frame: false,
			layout: 'form',
			width: 620,
			height: 590,
			autoScroll: true,
			title: '<?php echo __('Send Message',null,'sendmessage'); ?>',
			style:'margin-top:5px;margin-left:5px;margin-right:10px;',
			collapsible:false
		});
	},
	
	/** init subject textareat **/
	initSubject: function () {
		this.theTxtfield = new Ext.form.FieldSet({
			title: '<?php echo __('Subject',null,'sendmessage'); ?>',
			allowBlank: false,
			height: 'auto',
			style:'margin-top:5px;margin-left:10px;',
			width: 600,
			items:[{
				xtype: 'textfield',
				allowBlank: true,
				fieldLabel: '<?php echo __('Subject',null,'sendmessage'); ?>',
				name: 'subject',
				id: 'subject',
				style:'margin-right:10px;',
				width: 460
			}]
		});
	},
	
	/** init the messagebox and comboxbox **/
	initMessagebox: function () {
		this.theMessageBox = new Ext.form.FieldSet({
			title: '<?php echo __('Email format and message',null,'sendmessage'); ?>',
			allowBlank: false,
			style:'margin-top:5px;margin-left:10px;',
			width: 600,
			height: 'auto',
			items:[{
				xtype: 'combo',
				mode: 'local',
				value: 'plain',
				editable:false,
				id:'administration_sendmessage_type_id',
				hiddenName : 'type',
				triggerAction: 'all',
				foreSelection: true,
				fieldLabel: '<?php echo __('Type',null,'sendmessage'); ?>',
				store: new Ext.data.SimpleStore({
					 fields:['type','text'],
       				 data:[['plain', '<?php echo __('Plain',null,'sendmessage'); ?>'],['html', '<?php echo __('HTML',null,'sendmessage'); ?>']]
   				}),
 				valueField:'type',
				displayField:'text',
				width:70,
				listeners: {
		    		select: {
		    			fn:function(combo, value) { // change the textarea and htmlarea
		    				if (combo.getValue() == 'plain') {
		    					var checkField = cf.administration_sendmessage.theMessageBox.findById('systemMessageTextarea');
		    					if (!checkField) {
		    					cf.administration_sendmessage.theMessageBox.add({
		    										xtype: 'textarea',
													name: 'description',
													fieldLabel: '<?php echo __('Subject',null,'sendmessage'); ?>:',
													id: 'systemMessageTextarea',
													labelSeparator: '',
													allowBlank: false,
													height: 250,
													width: 400,
													value: Ext.getCmp('systemMessageHTMLArea').getValue(),
													anchor: '100%'
		    						});
		    						cf.administration_sendmessage.theMessageBox.remove('systemMessageHTMLArea');
		    						cf.administration_sendmessage.theSystemMessageWindow.doLayout();
		    					}
		    				}
		    				else {
		    					var checkField = cf.administration_sendmessage.theMessageBox.findById('systemMessageHTMLArea');
		    					if (!checkField) {
			    					cf.administration_sendmessage.theMessageBox.add({
										xtype: 'htmleditor',
										name: 'description',
										fieldLabel: '<?php echo __('Subject',null,'sendmessage'); ?>:',
										id: 'systemMessageHTMLArea',
										labelSeparator: '',
										height: 250,
										width: 400,
										allowBlank: false,
										value: Ext.getCmp('systemMessageTextarea').getValue(),
										anchor: '98%'
		    						});	
		    						cf.administration_sendmessage.theMessageBox.remove('systemMessageTextarea');
		    						cf.administration_sendmessage.theSystemMessageWindow.doLayout();
		    					}
		    				}
		    			}
		    		}
		    	}
				
				
			},{
				xtype: 'textarea',
				name: 'description',
				fieldLabel: '<?php echo __('Subject',null,'sendmessage'); ?>:',
				id: 'systemMessageTextarea',
				labelSeparator: '',
				allowBlank: false,
				height: 250,
				width: 400,
				anchor: '100%'
			}]
		});
		
	},
	
	/** set receiver panel **/
	initReceiver: function () {
		this.theReceiver = new Ext.form.FieldSet({
			title: '<?php echo __('Receiver',null,'sendmessage'); ?>',
			allowBlank: false,
			style:'margin-top:5px;margin-left:10px;',
			width: 600,
			height: 'auto',
			items: [{
				xtype: 'combo',
				mode: 'local',
				id: 'administration_sendmessage_sendto_id',
				value: 'ALL',
				editable:false,
				hiddenName : 'receiver',
				triggerAction: 'all',
				foreSelection: true,
				fieldLabel: '<?php echo __('Send to',null,'sendmessage'); ?>',
				store: new Ext.data.SimpleStore({
					 fields:['type','text'],
       				 data:[['ALL', '<?php echo __('All',null,'sendmessage'); ?>'],['SENDER', '<?php echo __('Sender only',null,'sendmessage'); ?>'],['ONLINE', '<?php echo __('to online users',null,'sendmessage'); ?>']]
   				}),
 				valueField:'type',
				displayField:'text',
				width:200
			}]
		});
	},
	
	/** add buttons to form **/
	initButtons: function () {
		this.theButtons = new Ext.form.FieldSet({
			style:'margin-top:5px;margin-left:10px;',
			width: 600,
			height: 'auto',
			border: false,
			buttonAlign: 'center',
			buttons:[{
				text:'<?php echo __('Send',null,'sendmessage'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () {
					cf.administration_sendmessage.theSendMessagePanel.getForm().submit({
						url: '<?php echo build_dynamic_javascript_url('sendmessage/SendMail')?>',
						method: 'POST',
						waitMsg: '<?php echo __('Sending...',null,'sendmessage'); ?>',
						success: function() {
							cf.TabPanel.theTabPanel.remove(cf.administration_sendmessage.theSystemMessageWindow);
							cf.administration_sendmessage.theSystemMessageWindow.hide();
							cf.administration_sendmessage.theSystemMessageWindow.destroy();
							Ext.MessageBox.alert('<?php echo __('OK',null,'sendmessage'); ?>', '<?php echo __('Emails send',null,'sendmessage'); ?>');
						}
					});
					
				}
			},{
				text:'<?php echo __('Close',null,'sendmessage'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {
					cf.TabPanel.theTabPanel.remove(cf.administration_sendmessage.theSystemMessageWindow);
					cf.administration_sendmessage.theSystemMessageWindow.hide();
					cf.administration_sendmessage.theSystemMessageWindow.destroy();
				}
			}]
			
		});
	},
	
	
	/** 
	 * Part of the API
	 * set value if class is already initialized. 
	 * @param boolean value
	 *
	 **/
	setInitialized: function (value) {
		this.isInitialized = value;
	},
	
	
	/**
	* Part of the API
	* This function returns the window, to add it into tabpanel
	*
	*/
	getInstance: function() {
		return this.theSystemMessageWindow;
	}
	
};}();