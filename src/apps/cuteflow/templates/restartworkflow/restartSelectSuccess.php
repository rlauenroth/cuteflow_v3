cf.restartSelectStation = function(){return {
	
	theSelectStationWindow				:false,
	theStore							:false,
	theGrid								:false,
	theCM								:false,
	theUniqueId							:false,
	theLoadingMask						:false,


	init: function() {
		cf.restartSelectStation.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Data...',null,'workflowmanagement'); ?>'});					
		cf.restartSelectStation.theLoadingMask.show();
		this.theUniqueId = 0;
		this.initStore();
		this.initCM();
		this.initGrid();
		this.initWindow();
		this.theSelectStationWindow.add(this.theGrid);
		this.theSelectStationWindow.show();
	},


	initStore: function () {
		var reader = new Ext.data.ArrayReader({}, [
			{name: 'workflow_slot_user_id'},
			{name: 'user_id'},
			{name: 'slotgroup'},
			{name: 'plainusername'},
			{name: 'username'},
			{name: 'workflow_slot_id'},
			{name: 'slotposition'},
			{name: 'userposition'},
			{name: 'workflow_template_id'},
			{name: 'slotname'},
			{name: 'action'}
		]);
		this.theStore = new Ext.data.GroupingStore({
            reader: reader,
            groupField:'slotgroup'
        })
	},

	initGrid: function () {
		this.theGrid = new Ext.grid.GridPanel({
			stripeRows: true,
			border: true,
			width: 'auto',
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 340,
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
			Ext.Ajax.request({  
				url: '<?php echo build_dynamic_javascript_url('restartworkflow/LoadAllStation')?>/versionid/' + cf.restartWorkflowWindow.theTemplateId,
				success: function(objServerResponse){
					var ServerResult = Ext.util.JSON.decode(objServerResponse.responseText);
					var data = ServerResult.result;
					var sendtoallslots = ServerResult.sendtoallslots;
					cf.restartSelectStation.addData(data, sendtoallslots);
				}
			});
				
		});
	},
	
	addData: function (data, sendtoallslots) {
		if(sendtoallslots == 1) {
			cf.restartWorkflowFirstTab.theStartPoint.setValue('LASTSTATION');
			Ext.Msg.minWidth = 250;
			Ext.MessageBox.alert('<?php echo __('Notice',null,'workflowmanagement'); ?>','<?php echo __('Workflow is set to send all Slots at once. A station cannot be selected',null,'workflowmanagement'); ?>');
			cf.restartSelectStation.theSelectStationWindow.hide();
			cf.restartSelectStation.theSelectStationWindow.destroy();
			
		}
		else {
			for(var a=0;a<data.length;a++){
				var user = data[a];
				var uniqueId = cf.restartSelectStation.theUniqueId++;
				
				var Rec = Ext.data.Record.create(
					{name: 'workflow_slot_user_id'},
					{name: 'user_id'},
					{name: 'slotgroup'},
					{name: 'plainusername'},
					{name: 'slotposition'},
					{name: 'userposition'},
					{name: 'username'},
					{name: 'workflow_slot_id'},
					{name: 'workflow_template_id'},
					{name: 'slotname'},
					{name: 'action'}
				);	
	
				cf.restartSelectStation.theGrid.store.add(new Rec({
					workflow_slot_user_id: user.workflow_slot_user_id, 
					user_id: user.user_id,
					plainusername: user.plainusername,
					slotgroup: user.slotgroup, 
					slotposition: user.slotposition,
					userposition: user.userposition,
					username: user.username, 
					workflow_slot_id: user.workflow_slot_id, 
					workflow_template_id: user.workflow_template_id, 
					slotname: user.slotname, 
					action: '<center><table><tr><td width="16"><div id="selectNewStationForRestart'+ uniqueId +'"></div></td></tr></table></center>'
				}));
				
				cf.restartSelectStation.createSetStationButton.defer(10,this, [uniqueId, user.slotposition, user.userposition ,user.plainusername, user.slotgroup]);
				
			}
		}
		cf.restartSelectStation.theLoadingMask.hide();
	},
	
	createSetStationButton: function (uniqueId, slotposition, userposition, username, slotgroup) {
		var btn_edit = new Ext.form.Label({
			renderTo: 'selectNewStationForRestart' + uniqueId,
			html: '<span style="cursor:pointer;"><img src="/images/icons/user_go.png" /></span>',
			listeners: {
				render: function(c){
					  c.getEl().on({
						click: function(el){
							cf.restartWorkflowFirstTab.theStartPoint.setValue(slotgroup+': ' + ' ' + username);
							cf.restartWorkflowFirstTab.theHiddenField.setValue('SLOT__' + slotposition + '__USER__' + userposition);
							cf.restartSelectStation.theSelectStationWindow.hide();
							cf.restartSelectStation.theSelectStationWindow.destroy();
						},
					scope: c
				});
				}
			}
		});
		
	},
	
	
	initCM: function () {
		this.theCM = new Ext.grid.ColumnModel([
			{header: "<?php echo __('Name',null,'workflowmanagement'); ?>", width: 300, sortable: true, dataIndex: 'username', css : "text-align : left;font-size:12px;align:center;"},
			{header: "<?php echo __('Group',null,'workflowmanagement'); ?>", width: 10, sortable: false, dataIndex: 'slotgroup', css : "text-align : left;font-size:12px;align:center;",  hidden: true},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/user_go.png' />&nbsp;&nbsp;</td><td><?php echo __('Set as Useragent',null,'workflowmanagement'); ?></td></tr></table>\" ext:qwidth=\"200\"><?php echo __('Action',null,'workflowmanagement'); ?></div>", width: 60, sortable: false, dataIndex: 'action', css : "text-align : left;font-size:12px;align:center;"}
		]);
		
	},

	initWindow: function () {
		this.theSelectStationWindow = new Ext.Window({
			modal: true,
			closable: true,
			modal: true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 300,
			width: 550,
			autoScroll: false,
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: true,
			title:  '<?php echo __('Select a station',null,'workflowmanagement'); ?>'
		});
		this.theSelectStationWindow.on('close', function() {
			cf.restartWorkflowFirstTab.theStartPoint.setValue('LASTSTATION');
			cf.restartSelectStation.theSelectStationWindow.hide();
			cf.restartSelectStation.theSelectStationWindow.destroy();
		});
	}






};}();