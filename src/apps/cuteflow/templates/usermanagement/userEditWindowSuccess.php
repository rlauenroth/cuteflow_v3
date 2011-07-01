/**
* Class opens new window, toedit an exisiting user
*/
cf.editUserWindow = function(){return {
	isInitialized 	                 : false,
	theUserId						 : false,
	theEditUserWindow	  	         : false,
	theTabPanel						 : false,
	theFormPanel				     : false,
	theLoadingMask					 : false,

	/** calls all functions to init window **/
	init:function (id) {
		if(cf.administration_myprofile.isInitialized == false) {
			this.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Data...',null,'usermanagement'); ?>'});					
			this.theLoadingMask.show();
			
			this.theUserId = id;
			cf.userFirstTab.init();
			cf.userSecondTab.init(this.theUserId);
			cf.userThirdTab.init();
			cf.userFourthTab.init('<?php echo build_dynamic_javascript_url('myprofile/LoadUserCirculationColumns')?>/id/' + this.theUserId, '<?php echo build_dynamic_javascript_url('theme/LoadUserTheme')?>/id/' + this.theUserId);
			this.initFormPanel();
			this.initTabPanel();
			this.initWindow();
			this.theTabPanel.add(cf.userFirstTab.thePanel);
			this.theTabPanel.add(cf.userSecondTab.thePanel);
			this.theTabPanel.add(cf.userThirdTab.thePanel);
			this.theTabPanel.add(cf.userFourthTab.thePanel);
			this.theFormPanel.add(this.theTabPanel);
			this.theEditUserWindow.add(this.theFormPanel);
			this.addData();
		}
		else {
			Ext.Msg.minWidth = 450;
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
	
	/** loads data for a user and sets it **/
	addData: function () {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('usermanagement/LoadSingleUser')?>/id/' + cf.editUserWindow.theUserId,
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
					
					
					// second Tab, load Grid here
					Ext.getCmp('userSecondTab_durationlength').setValue(data.result.duration_length);
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
					
					cf.userFirstTab.thePanel.frame = true;
					cf.userSecondTab.thePanel.frame = true;
					cf.userThirdTab.thePanel.frame = true;
					cf.userFourthTab.thePanel.frame = true;
					
					cf.userFirstTab.thePanel.autoScroll = true;
					cf.userSecondTab.thePanel.autoScroll = true;
					cf.userThirdTab.thePanel.autoScroll = true;
					cf.userFourthTab.thePanel.autoScroll = true;
					
					//cf.editUserWindow.theTabPanel.setActiveTab(3);
					//cf.editUserWindow.theTabPanel.setActiveTab(0);
	
					cf.editUserWindow.theEditUserWindow.show();
					cf.editUserWindow.theTabPanel.setActiveTab(3);
					cf.userSecondTab.theUserAgentStore.load();
					cf.userFirstTab.theComboRoleStore.load();
					cf.userFirstTab.theLanguageStore.load();
					
					cf.userFirstTab.theLanguageStore.on('load', function(store,records,bcd){
						Ext.getCmp('userFirstTab_language_id').setValue(data.result.language);
					});	
					
					cf.editUserWindow.theTabPanel.setActiveTab(0);
					cf.userFirstTab.theComboRoleStore.on('load', function(store,records,bcd){
						Ext.getCmp('userFirstTab_userrole_id').setValue(data.result.role_id);
						cf.editUserWindow.theLoadingMask.hide();
					});				
				}
				catch(e) {
					
				}
			}
		});
	},
	/** init formpanel **/
	initFormPanel: function () {
		this.theFormPanel = new Ext.FormPanel({
			frame:true       
		});
		
	},
	
	/** init popup window **/
	initWindow: function () {
		this.isInitialized = true;
		this.theEditUserWindow = new Ext.Window({
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
			title: '<?php echo __('Edit existing User',null,'usermanagement'); ?>',
	        buttonAlign: 'center',
			buttons:[{
				text:'<?php echo __('Store',null,'myprofile'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () {
					if(Ext.getCmp('userFirstTab_password').getValue() == Ext.getCmp('userFirstTab_passwordagain').getValue()) {
						cf.updateUser.initSave(cf.editUserWindow.theFormPanel,cf.editUserWindow.theUserId);
					}
					else {
						Ext.MessageBox.alert('<?php echo __('Error',null,'usermanagement'); ?>', '<?php echo __('Passwords not equal',null,'usermanagement'); ?>');
						cf.editUserWindow.theTabPanel.setActiveTab(0);
					}
				}
			},{
				text:'<?php echo __('Close',null,'usermanagement'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {	
					cf.editUserWindow.isInitialized = false;
					cf.editUserWindow.theEditUserWindow.hide();
					cf.editUserWindow.theEditUserWindow.destroy();
				}
			}]
		});
		this.theEditUserWindow.on('close', function() {
			cf.editUserWindow.isInitialized = false;	
			cf.editUserWindow.theEditUserWindow.hide();
			cf.editUserWindow.theEditUserWindow.destroy();		
		});
	}
	
	
	
};}();