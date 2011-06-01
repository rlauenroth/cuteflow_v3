/**
* Class opens new window, to add a new user
*/
cf.createUserWindow = function(){return {
	isInitialized 	                 : false,
	theUserId						 : false,
	theAddUserWindow	  	         : false,
	theTabPanel						 : false,
	theFormPanel				     : false,
	theLoadingMask					 : false,

	/** calls all necessary functions **/
	init:function () {
		if(cf.administration_myprofile.isInitialized == false) {
			this.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Data...',null,'usermanagement'); ?>'});					
			this.theLoadingMask.show();
			
			this.theUserId = '';
			cf.userFirstTab.init();
			cf.userSecondTab.init(this.theUserId);
			cf.userThirdTab.init();
			cf.userFourthTab.init('<?php echo build_dynamic_javascript_url('systemsetting/LoadCirculationColumns')?>', '<?php echo build_dynamic_javascript_url('theme/LoadAllTheme')?>');
			this.initFormPanel();
			this.initTabPanel();
			this.initWindow();
			this.theTabPanel.add(cf.userFirstTab.thePanel);
			this.theTabPanel.add(cf.userSecondTab.thePanel);
			this.theTabPanel.add(cf.userThirdTab.thePanel);
			this.theTabPanel.add(cf.userFourthTab.thePanel);
			this.theFormPanel.add(this.theTabPanel);
			this.theAddUserWindow.add(this.theFormPanel);
			this.addData();
		}
		else {
			Ext.Msg.minWidth = 200;
			Ext.MessageBox.alert('<?php echo __('Error',null,'usermanagement'); ?>', '<?php echo __('Profile changes and editing/creating user at same time is not supported',null,'usermanagement'); ?>');
		}
	},
	
	/** init tabpanel **/
	initTabPanel: function () {
		this.theTabPanel = new Ext.TabPanel({
			activeTab: 0,
			enableTabScroll:true,
			border: false,
			deferredRender:true,
			frame: true,
			layoutOnTabChange: true,
			forceLayout : true,
			plain: false,
			closable:false
		});	
		
	},
	/** load default data **/
	addData: function () {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('usermanagement/LoadDefaultData')?>',
			success: function(objServerResponse){  
				try {
					var data = Ext.util.JSON.decode(objServerResponse.responseText);

					// first Tab
					Ext.getCmp('userFirstTab_username').setValue(data.result.username);
					Ext.getCmp('userFirstTab_password').setValue(data.result.password);
					Ext.getCmp('userFirstTab_passwordagain').setValue(data.result.password);
					
					Ext.getCmp('userFirstTab_emailformat_id').setValue(data.result.emailformat);
					Ext.getCmp('userFirstTab_emailtype_id').setValue(data.result.emailtype);
					
					
					// second Tab, load Grid here
					Ext.getCmp('userSecondTab_durationlength').setValue(data.result.duration_length);
					Ext.getCmp('userSecondTab_durationlength_type_id').setValue(data.result.duration_type);
	
					// fourth tab
					Ext.getCmp('userFourthTab_itemsperpage_id').setValue(data.result.displayed_item);
					Ext.getCmp('userFourthTab_refreshtime_id').setValue(data.result.refresh_time);
					Ext.getCmp('userFourthTab_circulationdefaultsortcolumn_id').setValue(data.result.circulationdefaultsortcolumn);
					Ext.getCmp('userFourthTab_circulationdefaultsortdirection_id').setValue(data.result.circulationdefaultsortdirection);
					
					Ext.getCmp('userFourthTab_markyellow').setValue(data.result.markyellow);
					Ext.getCmp('userFourthTab_markorange').setValue(data.result.markorange);
					Ext.getCmp('userFourthTab_markred').setValue(data.result.markred);
					
					cf.userFirstTab.thePanel.frame = true;
					cf.userSecondTab.thePanel.frame = true;
					cf.userThirdTab.thePanel.frame = true;
					cf.userFourthTab.thePanel.frame = true;
					
					cf.userFirstTab.thePanel.autoScroll = true;
					cf.userSecondTab.thePanel.autoScroll = true;
					cf.userThirdTab.thePanel.autoScroll = true;
					cf.userFourthTab.thePanel.autoScroll = true;
					
					
					
					
					cf.createUserWindow.theAddUserWindow.show();
					cf.createUserWindow.theTabPanel.setActiveTab(3);
					
					cf.userFirstTab.theComboRoleStore.load();
					cf.userFirstTab.theLanguageStore.load();
					
					cf.createUserWindow.theTabPanel.setActiveTab(0);
					cf.userFirstTab.theLanguageStore.on('load', function(store,records,bcd){
						Ext.getCmp('userFirstTab_language_id').setValue(data.result.language);
					});	
					
					cf.userFirstTab.theComboRoleStore.on('load', function(store,records,bcd){
						Ext.getCmp('userFirstTab_userrole_id').setValue(data.result.role_id);
						cf.createUserWindow.theLoadingMask.hide();
					});	
				}
				catch(e) {
					
				}
			}
		});
	},
	
	/** init form panel **/
	initFormPanel: function () {
		this.theFormPanel = new Ext.FormPanel({
			frame:true       
		});
		
	},
	
	/** init popup window **/
	initWindow: function () {
		this.isInitialized = true;
		this.theAddUserWindow = new Ext.Window({
			modal: true,
			closable: true,
			modal: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 120,
			width: 700,
			autoScroll: false,
			shadow: false,
			minimizable: false,
			draggable: false,
			resizable: false,
	        plain: true,
			title: '<?php echo __('Create new User',null,'usermanagement'); ?>',
	        buttonAlign: 'center',
			buttons:[{
				text:'<?php echo __('Store',null,'myprofile'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () {
					if(Ext.getCmp('userFirstTab_password').getValue() == Ext.getCmp('userFirstTab_passwordagain').getValue()) {
						cf.saveUser.initSave(cf.createUserWindow.theFormPanel);
						cf.createUserWindow.isInitialized = false;
					}
					else {
						Ext.MessageBox.alert('<?php echo __('Error',null,'usermanagement'); ?>', '<?php echo __('Passwords not equal',null,'usermanagement'); ?>');
						cf.createUserWindow.theTabPanel.setActiveTab(0);
					}
				}
			},{
				text:'<?php echo __('Close',null,'usermanagement'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {
					cf.createUserWindow.isInitialized = false;
					cf.createUserWindow.theAddUserWindow.hide();
					cf.createUserWindow.theAddUserWindow.destroy();
				}
			}]
		});
		this.theAddUserWindow.on('close', function() {
			cf.createUserWindow.isInitialized = false;
			cf.createUserWindow.theAddUserWindow.hide();
			cf.createUserWindow.theAddUserWindow.destroy();
		});
	}
	
	
	
};}();