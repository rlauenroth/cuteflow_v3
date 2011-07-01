/** init my profile panel **/
cf.administration_myprofile = function(){return {
	
	isInitialized 	                 : false,
	theUserId						 : false,
	theMyProfilePanel	  	         : false,
	theTabPanel						 : false,
	theUserGridMask					 : false,

	/** init function, that calls all necessary functions **/
	init:function () {
		if(cf.editUserWindow.isInitialized == false && cf.createUserWindow.isInitialized == false) {
			this.theUserGridMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Data...',null,'myprofile'); ?>'});
			this.theUserGridMask.show();
			this.theUserId = '<?php echo $sf_user->getAttribute('id')?>';
			cf.userFirstTab.init();
			cf.userSecondTab.init(this.theUserId);
			cf.userThirdTab.init();
			cf.userFourthTab.init('<?php echo build_dynamic_javascript_url('myprofile/LoadUserCirculationColumns')?>/id/' + this.theUserId,  '<?php echo build_dynamic_javascript_url('theme/LoadUserTheme')?>/id/' + this.theUserId);
			this.initTabPanel();
			this.initWindow();
			this.theTabPanel.add(cf.userFirstTab.thePanel);
			this.theTabPanel.add(cf.userSecondTab.thePanel);
			this.theTabPanel.add(cf.userThirdTab.thePanel);
			this.theTabPanel.add(cf.userFourthTab.thePanel);
			this.theMyProfilePanel.add(this.theTabPanel);
			cf.administration_myprofile.theTabPanel.setActiveTab(3);
			this.addData();
			this.initUserRight();
		}
		else {
			Ext.Msg.minWidth = 450;
			Ext.MessageBox.alert('<?php echo __('Error',null,'myprofile'); ?>', '<?php echo __('Profile changes and editing/creating user at same time is not supported',null,'myprofile'); ?>');
		}

	},
	
	/** load userrights and set to panel **/
	initUserRight: function () {
		cf.userSecondTab.thePanel.setDisabled(<?php $arr = $sf_user->getAttribute('credential');echo $arr['administration_myprofile_changeUseragent'];?>);
		Ext.getCmp('userFirstTab_userrole_id').setDisabled(<?php $arr = $sf_user->getAttribute('credential');echo $arr['administration_myprofile_changeRole'];?>);
	},
	
	/** init tabpabel **/
	initTabPanel: function () {
		this.theTabPanel = new Ext.TabPanel({
			activeTab: 0,
			enableTabScroll:true,
			border: false,
			deferredRender:true,
			layoutOnTabChange: true,
			forceLayout : true,
			style: 'margin-top:5px;',
			closable:false
		});	
		
	},
	
	/** load and add userdata to elements **/
	addData: function () {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('usermanagement/LoadSingleUser')?>/id/' + cf.administration_myprofile.theUserId,
			success: function(objServerResponse){  
				try {
					var data = Ext.util.JSON.decode(objServerResponse.responseText);
					// first Tab
					Ext.getCmp('userFirstTab_firstname').setValue(data.result.firstname);
					Ext.getCmp('userFirstTab_lastname').setValue(data.result.lastname);
					Ext.getCmp('userFirstTab_email').setValue(data.result.email);
					Ext.getCmp('userFirstTab_username').setValue(data.result.username);
					Ext.getCmp('userFirstTab_username').setDisabled(true);
					Ext.getCmp('userFirstTab_password').setValue(data.result.password);
					Ext.getCmp('userFirstTab_passwordagain').setValue(data.result.password);
					Ext.getCmp('userFirstTab_emailformat_id').setValue(data.result.email_format);
					Ext.getCmp('userFirstTab_emailtype_id').setValue(data.result.email_type);
					Ext.getCmp('userFirstTab_language_id').setValue(data.result.language);
					
					
					// second Tab, load Grid here
					Ext.getCmp('userSecondTab_durationlength').setValue(data.result.durationlength);
					Ext.getCmp('userSecondTab_durationlength_type_id').setValue(data.result.duration_type);
					
					// third tab
					Ext.getCmp('userThirdTab_street').setValue(data.result.street);
					Ext.getCmp('userThirdTab_zip').setValue(data.result.zip);
					Ext.getCmp('userThirdTab_city').setValue(data.result.city);
					Ext.getCmp('userThirdTab_country').setValue(data.result.country);
					Ext.getCmp('userThirdTab_phone1').setValue(data.result.phone1);
					Ext.getCmp('userThirdTab_phone2').setValue(data.result.phone1);
					Ext.getCmp('userThirdTab_mobil').setValue(data.result.mobil);
					Ext.getCmp('userThirdTab_fax').setValue(data.result.fax);
					Ext.getCmp('userThirdTab_organisation').setValue(data.result.organisation);
					Ext.getCmp('userThirdTab_department').setValue(data.result.department);
					Ext.getCmp('userThirdTab_burdencenter').setValue(data.result.burdencenter);
					Ext.getCmp('userThirdTab_comment').setValue(data.result.comment);
					// fourth tab
					Ext.getCmp('userFourthTab_itemsperpage_id').setValue(data.result.displayed_item);
					Ext.getCmp('userFourthTab_refreshtime_id').setValue(data.result.refresh_time);
					Ext.getCmp('userFourthTab_circulationdefaultsortcolumn_id').setValue(data.result.circulation_default_sort_column);
					Ext.getCmp('userFourthTab_circulationdefaultsortdirection_id').setValue(data.result.circulation_default_sort_direction);
					Ext.getCmp('userFourthTab_markyellow').setValue(data.result.mark_yellow);
					Ext.getCmp('userFourthTab_markorange').setValue(data.result.mark_orange);
					Ext.getCmp('userFourthTab_markred').setValue(data.result.mark_red);
				
					
					cf.userSecondTab.theUserAgentStore.load();
					cf.userFirstTab.theComboRoleStore.load();
					cf.userFirstTab.theLanguageStore.load();
					cf.administration_myprofile.theTabPanel.setActiveTab(0);
					cf.userFirstTab.theLanguageStore.on('load', function(store,records,bcd){
						Ext.getCmp('userFirstTab_language_id').setValue(data.result.language);
					});	
					
					cf.userFirstTab.theComboRoleStore.on('load', function(store,records,bcd){
						Ext.getCmp('userFirstTab_userrole_id').setValue(data.result.role_id);
						cf.administration_myprofile.theUserGridMask.hide();
					});	
				}
				catch(e) {
					
				}
				
			}
		});
	},
	
	/** load formpanel **/
	initWindow: function () {
		this.isInitialized = true;
		this.theMyProfilePanel = new Ext.FormPanel({
			modal: true,
			closable: true,
			modal: true,
			layout: 'fit',
			autoScroll: false,
			title: '<?php echo __('Profile Settings',null,'myprofile'); ?>',
			shadow: false,
			minimizable: false,
			draggable: false,
			border: true,
			resizable: false,
	        plain: false,
	        buttonAlign: 'center',
			buttons:[{
				text:'<?php echo __('Store',null,'myprofile'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () {
					if(Ext.getCmp('userFirstTab_password').getValue() == Ext.getCmp('userFirstTab_passwordagain').getValue()) {
						cf.updateUser.initSave(cf.administration_myprofile.theMyProfilePanel,cf.administration_myprofile.theUserId);
						cf.administration_myprofile.isInitialized = false;
					}
					else {
						Ext.MessageBox.alert('<?php echo __('Error',null,'myprofile'); ?>', '<?php echo __('Passwords not equal',null,'myprofile'); ?>');
						cf.administration_myprofile.theTabPanel.setActiveTab(0);
					}
				}
			},{
				text:'<?php echo __('Close',null,'myprofile'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {
					var activeTab = cf.TabPanel.theTabPanel.getActiveTab();
					cf.TabPanel.theTabPanel.remove(activeTab);
					cf.administration_myprofile.isInitialized = false;
					cf.administration_myprofile.theMyProfilePanel.hide();
					cf.administration_myprofile.theMyProfilePanel.destroy();
				}
			}]
		});
		this.theMyProfilePanel.on('close', function() {
				cf.administration_myprofile.isInitialized = false;
				cf.administration_myprofile.theMyProfilePanel.hide();
				cf.administration_myprofile.theMyProfilePanel.destroy();
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
		return this.theMyProfilePanel;
	}
	
};}();