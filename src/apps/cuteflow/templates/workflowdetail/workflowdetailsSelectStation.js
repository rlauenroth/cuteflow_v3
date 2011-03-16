cf.workflowdetailsSelectStation = function(){return {
	
	thePopUpWindow					:false,
	theCM							:false,
	theStore						:false,
	theGrid							:false,
	theToolbar						:false,
	theTemplateVersionId			:false,
	theLoadingMask					:false,
	theUniqueId						:false,
	theWorkflowSlotUserId			:false,
	theTemplateVersion				:false,
	
	init: function (workflowprocessuser_id, templateversion_id, workflowuser_id) {
		cf.workflowdetailsSelectStation.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Data...',null,'workflowmanagement'); ?>'});					
		cf.workflowdetailsSelectStation.theLoadingMask.show();
		this.theWorkflowSlotUserId = workflowuser_id;
		this.theTemplateVersion = templateversion_id;
		this.theUniqueId = 1;
		this.theTemplateVersionId = templateversion_id;
		this.initCM();
		this.initStore();
		this.initGrid();
		this.initWindow();
		this.thePopUpWindow.add(this.theGrid);
		this.thePopUpWindow.doLayout();
		this.thePopUpWindow.show();
		
	},
	
	
	
	initGrid: function () {
		this.theGrid = new Ext.grid.GridPanel({
			stripeRows: true,
			border: true,
			width: 'auto',
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 200,
			autoScroll: true,
			collapsible: false,
			style:'margin-top:5px;margin-left:5px;margin-right:5px;',
			store: this.theStore,
	        view: new Ext.grid.GroupingView({
	            forceFit:true,
    	        groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "<?php echo __('Stations',null,'workflowmanagement'); ?>" : "<?php echo __('Station',null,'workflowmanagement'); ?>"]})'
        	}),
			cm: this.theCM
		});
		this.theGrid.on('afterrender', function(grid) {
			cf.workflowdetailsSelectStation.addItems(grid, cf.workflowdetailsSelectStation.theTemplateVersionId);			
		});
	},
	
	initCM: function () {
		this.theCM = new Ext.grid.ColumnModel([
			{header: "<?php echo __('Name',null,'workflowmanagement'); ?>", width: 300, sortable: true, dataIndex: 'plainusername', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Group',null,'workflowmanagement'); ?>", width: 150, sortable: false, dataIndex: 'slotgroup', css : "text-align : left;font-size:12px;align:center;",  hidden: true},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/user_go.png' />&nbsp;&nbsp;</td><td><?php echo __('Set as Useragent',null,'workflowmanagement'); ?></td></tr></table>\" ext:qwidth=\"200\"><?php echo __('Action',null,'workflowmanagement'); ?></div>", width: 60, sortable: false, dataIndex: 'action', css : "text-align : left;font-size:12px;align:center;"}
		]);
		
	},
	
	addItems: function (grid, version_id) {
		Ext.Ajax.request({  
			url: '<?php echo build_dynamic_javascript_url('restartworkflow/LoadAllStation')?>/versionid/' + version_id,
			success: function(objServerResponse){
				var ServerResult = Ext.util.JSON.decode(objServerResponse.responseText);
				var detailData = ServerResult.result;
				for(var a=0;a<detailData.length;a++){
					var user = detailData[a];
					var uniqueId = cf.workflowdetailsSelectStation.theUniqueId++;
					
					var Rec = Ext.data.Record.create(
						{name: 'workflowslotuser_id'},
						{name: 'user_id'},
						{name: 'slotgroup'},
						{name: 'plainusername'},
						{name: 'username'},
						{name: 'sendtoallreceivers'},
						{name: 'workflowslot_id'},
						{name: 'workflowtemplate_id'},
						{name: 'slotname'},
						{name: 'action'}
					);	
		
					cf.workflowdetailsSelectStation.theGrid.store.add(new Rec({
						workflowslotuser_id: user.workflowslotuser_id, 
						user_id: user.user_id,
						plainusername: user.plainusername,
						slotgroup: user.slotgroup, 
						sendtoallreceivers: user.sendtoallreceivers, 
						username: user.username, 
						workflowslot_id: user.workflowslot_id, 
						workflowtemplate_id: user.workflowtemplate_id, 
						slotname: user.slotname, 
						action: '<center><table><tr><td width="16"><div id="selectNewStation'+ uniqueId +'"></div></td></tr></table></center>'
					}));
					cf.workflowdetailsSelectStation.createSetStationButton.defer(10,this, [uniqueId, user.workflowslotuser_id, cf.workflowdetailsSelectStation.theTemplateVersion, user.slotgroup, user.sendtoallreceivers]);
					
				}
				cf.workflowdetailsSelectStation.theLoadingMask.hide();
			}
			
		});
		
	},
	
	
	
	initStore: function () {
		var reader = new Ext.data.ArrayReader({}, [
			{name: 'id'},
			{name: 'decission_id'},
			{name: 'station'},
			{name: 'receivedat'},
			{name: 'plainusername'},
			{name: 'statusinwords'},
			{name: 'workflowslot_id'},
			{name: 'status'},
			{name: 'isuseragentof'},
			{name: 'duration'},
			{name: 'slotgroup'},
			{name: 'version_id'},
			{name: 'action'}
		]);
		this.theStore = new Ext.data.GroupingStore({
            reader: reader,
            groupField:'slotgroup'
        });
	},

	
	createSetStationButton: function (uniqueId, workflowslotuser_id, theTemplateId,slotgroup, sendtoallreceivers) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'selectNewStation' + uniqueId,
			html: '<span style="cursor:pointer;"><img src="/images/icons/user_go.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							if(sendtoallreceivers == 1) {
								Ext.Msg.minWidth = 300;
								Ext.Msg.show({
								   title:'<?php echo __('Notice',null,'workflowmanagement'); ?>',
								   msg: '<?php echo __('In this slot, all users receive the workflow at once.',null,'workflowmanagement'); ?><br /><?php echo __('Do you wish to proceed?',null,'workflowmanagement'); ?>',
								   buttons: Ext.Msg.YESNO,
								   fn: function(btn, text) {
										if(btn == 'yes') {
											if(workflowslotuser_id == cf.workflowdetailsSelectStation.theWorkflowSlotUserId) {
												Ext.Msg.minWidth = 200;
												Ext.MessageBox.alert('<?php echo __('Notice',null,'workflowmanagement'); ?>', '<?php echo __('Same station selected',null,'workflowmanagement'); ?>!');
											}
											else {
												var move;
												if(workflowslotuser_id < cf.workflowdetailsSelectStation.theWorkflowSlotUserId) {
													move = 'DOWN';
												}
												else {
													move = 'UP';
												}
												cf.workflowdetailsCRUD.setNewStation(theTemplateId,workflowslotuser_id, cf.workflowdetailsSelectStation.theWorkflowSlotUserId, move);
										   }
										}
								   }
								});
								
							}
							else {
								if(workflowslotuser_id == cf.workflowdetailsSelectStation.theWorkflowSlotUserId) {
									Ext.Msg.minWidth = 200;
									Ext.MessageBox.alert('<?php echo __('Notice',null,'workflowmanagement'); ?>', '<?php echo __('Same station selected!',null,'workflowmanagement'); ?>!');
								}
								else {
									var move;
									if(workflowslotuser_id < cf.workflowdetailsSelectStation.theWorkflowSlotUserId) {
										move = 'DOWN';
									}
									else {
										move = 'UP';
									}
									cf.workflowdetailsCRUD.setNewStation(theTemplateId,workflowslotuser_id, cf.workflowdetailsSelectStation.theWorkflowSlotUserId, move);
							   }
							}

						},
					scope: c
				});
				}
			}
		});
		
	},
	
	initWindow: function () {
		this.thePopUpWindow = new Ext.Window({
			modal: true,
			closable: true,
			modal: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 160,
			width: 550,
			autoScroll: true,
			title: '<?php echo __('Select a User from Slot',null,'workflowmanagement'); ?>',
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: false,
			close : function(){
				cf.workflowdetailsSelectStation.thePopUpWindow.hide();
				cf.workflowdetailsSelectStation.thePopUpWindow.destroy();
			}
		});
		
	}
	
	
	
	












};}();