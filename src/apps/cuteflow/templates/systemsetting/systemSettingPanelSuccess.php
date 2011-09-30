/** class for pop, when changing order of menue items **/
cf.administration_systemsetting = function(){return {
	
	theSystemSettingPanel: false,
	theFormPanel: false,
	isInitialized: false,
	theTabPanel: false,
	theMainPanel: false,
	theLoadingMask: false,
	
	
	/** 
	*
	* init function 
	*
	* @param int id, id of the loaded record
	**/
	init: function () {
		if (this.isInitialized == false) {
			this.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Data...',null,'systemsetting'); ?>'});					
			this.theLoadingMask.show();
			
			//cf.databaseTab.init();
			cf.emailTab.init();
			cf.systemTab.init();
			cf.authTab.init();
			cf.userTab.init();
			cf.guiTab.init();
			cf.authorizationTab.init();
			cf.userAgentSetting.init();
			this.initTabPanel();
			this.initFormPanel();
			this.initPanel();
			this.initMainPanel();
			//this.theTabPanel.add(cf.databaseTab.theDatabaseTab);
			this.theTabPanel.add(cf.emailTab.theEmailTab);
			this.theTabPanel.add(cf.systemTab.theSystemTab);
			this.theTabPanel.add(cf.authTab.theAuthTab);
			this.theTabPanel.add(cf.userTab.theUserTab);
			this.theTabPanel.add(cf.guiTab.theGuiTab);
			this.theTabPanel.add(cf.authorizationTab.theAuthorizationTab);
			this.theTabPanel.add(cf.userAgentSetting.theUserAgentTab);
			this.theFormPanel.add(this.theTabPanel);
			this.theMainPanel.add(this.theSystemSettingPanel);
			this.theSystemSettingPanel.add(this.theFormPanel);
			cf.systemTab.theComboStore.load();
			cf.systemTab.theComboStore.on('load', function(store,records,bcd){
				cf.administration_systemsetting.initLoadData();
			});	
			
		}
		
	},
	
	/** functions loads all system data and calls addData function to add data **/
	initLoadData: function () {
		Ext.Ajax.request({  
			url : '<?php echo build_dynamic_javascript_url('systemsetting/LoadSystem')?>',
			success: function(objServerResponse){  
				var data = Ext.util.JSON.decode(objServerResponse.responseText);
				cf.emailTab.addData.defer(1000, this, [data.email]);
				cf.systemTab.addData.defer(1000, this, [data.system]);
				cf.authTab.addData.defer(1000, this, [data.auth]);
				cf.userTab.addData.defer(1000, this, [data.user]);
				cf.userAgentSetting.addData.defer(1000, this, [data.useragent]);
				cf.administration_systemsetting.theTabPanel.setActiveTab(6);
				cf.administration_systemsetting.theTabPanel.setActiveTab(0);
			}
		});
	},
	
	/** init tabpanel for all tabs **/
	initTabPanel: function () {
		this.theTabPanel = new Ext.TabPanel({
			activeTab: 0,
			enableTabScroll: true,
			border: false,
			deferredRender: true,
			frame: true,
			layoutOnTabChange: true,
			style: 'margin-top:5px;',
			plain: false,
			closable: false
		});	
		
	},
	
	/** formpanel **/
	initFormPanel: function () {
		this.theFormPanel = new Ext.FormPanel({
		});

	},
	
	/**
	* inits popup window with buttons
	*
	* @param int id, id of the loaded record
	*/
	initPanel: function () {
		this.isInitialized = true;
		this.theSystemSettingPanel = new Ext.Panel({
			modal: true,
			closable: true,
			modal: true,
			height: 600,
			layout: 'fit',
			autoScroll: false,
			title: '<?php echo __('System Settings',null,'systemsetting'); ?>',
			shadow: false,
			minimizable: false,
			draggable: false,
			style: 'margin-top:5px;margin-left:5px;',
			border: true,
			resizable: false,
	        plain: false,
	        buttonAlign: 'center',
			close : function(){
				var activeTab = cf.TabPanel.theTabPanel.getActiveTab();
				cf.TabPanel.theTabPanel.remove(activeTab);
				cf.administration_systemsetting.theSystemSettingPanel.hide();
				cf.administration_systemsetting.theSystemSettingPanel.destroy();
			},
			buttons:[{
				text:'<?php echo __('Store',null,'systemsetting'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () {
					cf.systemSettingCRUD.initSave();
				}
			},{
				text:'<?php echo __('Close',null,'systemsetting'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {
					var activeTab = cf.TabPanel.theTabPanel.getActiveTab();
					cf.TabPanel.theTabPanel.remove(activeTab);
					cf.administration_systemsetting.theSystemSettingPanel.hide();
					cf.administration_systemsetting.theSystemSettingPanel.destroy();
				}
			}]
			
		});
		
	},
	
	/** init main panel **/
	initMainPanel: function () {
		this.theMainPanel = new Ext.Panel({
			modal: true,
			closable: true,
			modal: true,
			width: 720,
			height: 900,
			autoScroll: true,
			title: '<?php echo __('System Settings',null,'systemsetting'); ?>',
			shadow: false,
			minimizable: false,
			draggable: false,
			resizable: false,
	        plain: false
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
		return this.theMainPanel;
	}
	
	
	
};}();