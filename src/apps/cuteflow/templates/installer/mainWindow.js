cf.mainWindow = function(){return {
	
	
	thePanel				:false,
	theWindow				:false,
	theLoadingMask			:false,
	theCardLayout			:false,
	theLayoutCounter		:false,
	
	/** Calls all necessary function to display the login form **/
	init: function(){
		this.theLayoutCounter = 0;
		cf.mainWindow.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Data...',null,'installer'); ?>'});					
		cf.mainWindow.theLoadingMask.show();
		
		cf.startTab.init();
		cf.installerSettingsTab.init();
		cf.firstTab.init();
		cf.secondTab.init();
		this.initWindow();
		this.initPanel();
		this.initCardLayout();
		
		this.theCardLayout.add(cf.installerSettingsTab.thePanel);
		this.theCardLayout.add(cf.startTab.thePanel);
		this.theCardLayout.add(cf.firstTab.thePanel);
		this.theCardLayout.add(cf.secondTab.thePanel);
		this.theWindow.add(this.theCardLayout);
		cf.mainWindow.theLoadingMask.hide();
	},
	
	initCardLayout: function() {
		this.theCardLayout = new Ext.FormPanel({
			    layout:'card',
			    forceLayout:true,
			    border: false,
			    hideMode: 'offsets',
			    layoutOnCardChange : true,
			    activeItem: 0, 
			    bodyStyle: 'padding:15px',
			    bbar: [{
			            id: 'move-prev',
			            text: '<table><tr><td><img src="/images/icons/arrow_left.png"></td><td><?php echo __('Previous Step',null,'installer'); ?></td></tr></table>',
			            handler: this.navHandler.createDelegate(this, [-1]),
			            disabled: true
			        },'->',{
			            id: 'move-next',
			            text: '<table><tr><td><?php echo __('Next Step',null,'installer'); ?></td><td><img src="/images/icons/arrow_right.png"></tr></table>',
			            handler: this.navHandler.createDelegate(this, [1])
			        }]
			});
	},
	
	navHandler: function (direction) {
		
		if(this.theLayoutCounter == 1 && direction == -1) {
			Ext.getCmp('move-prev').setDisabled(true);
		}
		else {
			Ext.getCmp('move-prev').setDisabled(false);
		}
		
		if(this.theLayoutCounter == 2 && direction == 1) {
			Ext.getCmp('move-next').setDisabled(true);
		}
		else {
			Ext.getCmp('move-next').setDisabled(false);
		}
		
		if(direction == 1 && this.theLayoutCounter <= 3) {
			this.theLayoutCounter++;
		}
		if(direction == -1 && this.theLayoutCounter >= 0) {
			this.theLayoutCounter--;
		}
		if(this.theLayoutCounter == 3) {
			Ext.getCmp('installer_saveButton').setVisible(true);
			Ext.getCmp('installer_closeButton').setVisible(true);
		}
		cf.mainWindow.theCardLayout.getLayout().setActiveItem(this.theLayoutCounter);
	},
	
	
	initTabPanel: function (){
		this.theTabPanel = new Ext.TabPanel({
			activeTab: 0,
			enableTabScroll:true,
			border: false,
			deferredRender:true,
			frame: true,
			layoutOnTabChange: true,
			style: 'margin-top:5px;',
			plain: true,
			closable:false
		});		
	},
	
	initWindow: function () {
		this.theWindow = new Ext.Window({
			modal: true,
			closable: false,
			modal: true,
			width: 850,
			height: 620,
			autoScroll: true,
			title: '<?php echo __('CuteFlow Installer',null,'installer'); ?>',
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: true,
	        buttonAlign: 'center',
			buttons:[{
				text:'<?php echo __('Store',null,'installer'); ?>', 
				icon: '/images/icons/accept.png',
				id: 'installer_saveButton',
				hidden: true,
				handler: function () {
					var checkUrl = Ext.get('url_check').dom.value;
					cf.mainWindow.theCardLayout.getForm().submit({
							url: checkUrl,
							method: 'POST',
							waitMsg: '<?php echo __('Checking Settings',null,'installer'); ?>',
							success: function(objServerResponse){
								var url = Ext.get('url_save').dom.value;
								cf.mainWindow.theCardLayout.getForm().submit({
									url: url,
									method: 'POST',
									waitMsg: '<?php echo __('Building System',null,'installer'); ?>',
									success: function(objServerResponse){
										Ext.Msg.minWidth = 200;
										Ext.MessageBox.alert('<?php echo __('CuteFlow installed',null,'installer'); ?>','<?php echo __('CuteFlow installed',null,'installer'); ?>');
										var url = Ext.get('url_login').dom.value;
										window.location.href = url;
									},
									failure: function (objServerResponse) {
										Ext.Msg.minWidth = 200;
										Ext.MessageBox.alert('<?php echo __('CuteFlow installed',null,'installer'); ?>','<?php echo __('CuteFlow installed',null,'installer'); ?>');
										var url = Ext.get('url_login').dom.value;
										window.location.href = url;
										
									}
								});
							},
							failure: function(objServerResponse) {
								Ext.Msg.minWidth = 250;
								Ext.MessageBox.alert('<?php echo __('Failure',null,'installer'); ?>','<?php echo __('Database connection is not valid',null,'installer'); ?>');
							}
						});

					
					
				}
			},{
				text:'<?php echo __('Close',null,'installer'); ?>', 
				icon: '/images/icons/cancel.png',
				id: 'installer_closeButton',
				hidden: true,
				handler: function () {
					cf.mainWindow.theWindow.hide();
					cf.mainWindow.theWindow.destroy();
				}
			}]
		});
		
		
	},
	
	initPanel: function () {
		this.thePanel = new Ext.FormPanel({
			modal: false,
			closable: false,
			modal: true,
			bodyStyle: 'background-color: #CCD8E7;',
			layout: 'form',
			autoScroll: true,
			shadow: false,
			minimizable: false,
			autoScroll: false,
			draggable: false,
			resizable: false,
			border: false,
			plain: true
		});
		
		
	}
	
	
	
};}();

