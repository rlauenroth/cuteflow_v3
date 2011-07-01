/** save a user **/
cf.saveUser = function(){return {
	
	
	theHiddenPanel			:false,
	
	/** init save function **/
	initSave: function (theFormpanel) {
		this.initHiddenPanel();
		this.buildUserAgent(theFormpanel);
		this.buildWorkflow(theFormpanel);
		this.doSubmit(theFormpanel);

	},
	
	/** panle to add save data **/
	initHiddenPanel:function () {
		this.theHiddenPanel = new Ext.Panel({
			border: false,
			width:0,
			height:0
		});
		
	},
	
	/** build worklfow hiddden fields **/
	buildWorkflow: function (theFormpanel) {
		var grid =cf.userFourthTab.theFourthGrid;
		for(var a=0;a<grid.store.getCount();a++) {
			var row = grid.getStore().getAt(a);
			if(row.data.column == 'USERDEFINED1') {
				var combo = Ext.getCmp('userdefined_firstcombo');
				var hiddenfield = new Ext.form.Field({
					autoCreate : {tag:'input', type: 'hidden', name: 'worklfow[userdefined1][fieldid]', value:combo.getValue(), width: 0}			
				});
				cf.saveUser.theHiddenPanel.add(hiddenfield);
				
				var hiddenfield = new Ext.form.Field({
					autoCreate : {tag:'input', type: 'hidden', name: 'worklfow[userdefined1][is_active]', value:row.data.is_active, width: 0}			
				});
				cf.saveUser.theHiddenPanel.add(hiddenfield);
			}
			else if(row.data.column == 'USERDEFINED2') {
				var combo = Ext.getCmp('userdefined_secondcombo');
				var hiddenfield = new Ext.form.Field({
					autoCreate : {tag:'input', type: 'hidden', name: 'worklfow[userdefined2][fieldid]', value:combo.getValue(), width: 0}			
				});
				cf.saveUser.theHiddenPanel.add(hiddenfield);
				
				var hiddenfield = new Ext.form.Field({
					autoCreate : {tag:'input', type: 'hidden', name: 'worklfow[userdefined2][is_active]', value:row.data.is_active, width: 0}			
				});
				cf.saveUser.theHiddenPanel.add(hiddenfield);
			}
			else {
				var hiddenfield = new Ext.form.Field({
					autoCreate : {tag:'input', type: 'hidden', name: 'worklfow['+row.data.column+']', value:row.data.is_active, width: 0}			
				});
				cf.saveUser.theHiddenPanel.add(hiddenfield);
			}
		}
		theFormpanel.add(cf.saveUser.theHiddenPanel);
		theFormpanel.doLayout();	
	},
	
	/** build useragent hiddenfields **/
	buildUserAgent: function (theFormpanel) {
		var grid = cf.userSecondTab.theUserAgentGrid;
		var hiddenfield = new Ext.form.Field({
			autoCreate : {tag:'input', type: 'hidden', name: 'removeUseragent', value:cf.userSecondTab.theRemoveField, width: 0}			
		});
		cf.saveUser.theHiddenPanel.add(hiddenfield);
		for(var a=0;a<grid.store.getCount();a++) {
			var row = grid.getStore().getAt(a);
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'useragents['+a+'][id]', value:row.data.user_id, width: 0}			
			});
			cf.saveUser.theHiddenPanel.add(hiddenfield);
			var hiddenfield = new Ext.form.Field({
				autoCreate : {tag:'input', type: 'hidden', name: 'useragents['+a+'][databaseId]', value:row.data.databaseId, width: 0}			
			});
			cf.saveUser.theHiddenPanel.add(hiddenfield);
		}
		theFormpanel.add(cf.saveUser.theHiddenPanel);
		theFormpanel.doLayout();
	},
	
	/** submit **/
	doSubmit: function (theFormpanel) {
		var username = Ext.getCmp('userFirstTab_username').getValue();
		if(username != '') {
			Ext.Ajax.request({
				url : '<?php echo build_dynamic_javascript_url('usermanagement/CheckForExistingUser')?>/username/' + username,
				success: function(objServerResponse){  
					if(objServerResponse.responseText == 1) {
						theFormpanel.getForm().submit({
							url: '<?php echo build_dynamic_javascript_url('usermanagement/SaveUser')?>',
							method: 'POST',
							waitMsg: '<?php echo __('Saving Data',null,'usermanagement'); ?>',
							success: function(objServerResponse){
								try {
									Ext.destroy.apply(Ext, cf.saveUser.theHiddenPanel.items.items);
									cf.saveUser.theHiddenPanel.items.clear();
									cf.saveUser.theHiddenPanel.body.update('');
								}
								catch(e) {}
								Ext.Msg.minWidth = 200;
								Ext.MessageBox.alert('<?php echo __('OK',null,'usermanagement'); ?>', '<?php echo __('User added',null,'usermanagement'); ?>');
								cf.UserGrid.theUserStore.reload();
								cf.createUserWindow.theAddUserWindow.hide();
								cf.createUserWindow.theAddUserWindow.destroy();
							}
						});
					}
					else {
						Ext.Msg.minWidth = 200;
						Ext.MessageBox.alert('<?php echo __('Error',null,'usermanagement'); ?>', '<?php echo __('Username already exists',null,'usermanagement'); ?>');
						cf.TabPanel.theTabPanel.setActiveTab(0);
					}
				}
			});
		}
	}
	
	
	
	
	
	
	
	
	
};}();