cf.workflowdetailsDetails = function(){return {
	
	theFieldset 					:false,
	theCM							:false,
	theStore						:false,
	theGrid							:false,
	theWorkflowAdmin				:false,
	
	
	init: function (data, workflowadmin) {
		this.theWorkflowAdmin = workflowadmin;
		this.initCM();
		this.initStore();
		this.initGrid(data);
		this.initFieldset();
		this.theFieldset.add(this.theGrid);
		
	},
	
	
	initGrid: function (data) {
		this.theGrid = new Ext.grid.GridPanel({
			stripeRows: true,
			border: true,
			width: 'auto',
			height: 310,
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
			cf.workflowdetailsDetails.addItems(grid, data);			
		});
	},
	
	addItems: function (grid, data) {
		for(var a=0;a<data.length;a++) {
			var slot = data[a];
			for(var b=0;b<slot.user.length;b++) {
				var user = slot.user[b];
				var Rec = Ext.data.Record.create(
					{name: 'id'},
					{name: 'decission_id'},
					{name: 'senttoallatonce'},
					{name: 'send_to_all_receivers'},
					{name: 'station'},
					{name: 'receivedat'},
					{name: 'statusinwords'},
					{name: 'workflow_slot_id'},
					{name: 'status'},
					{name: 'is_user_agent_of'},
					{name: 'user_id'},
					{name: 'duration'},
					{name: 'slotgroup'},
					{name: 'version_id'},
					{name: 'action'}	
				);	
				
				if(user.decission_state == 'STOPPEDBYUSER') {
					user.decissioninwords = user.decissioninwords.replace('<table><tr>','<table><tr><td><img ext:qtip="<table><tr><td><?php echo __('Endreason',null,'workflowmanagement'); ?></td><td>'+user.endreasion+'</td></tr></table>" ext:qwidth="350" src="/images/icons/information.png" /></td>');
				}
				
				grid.store.add(new Rec({
					id: user.id,
					senttoallatonce: slot.senttoallatonce, 
					send_to_all_receivers: slot.send_to_all_receivers, 
					decission_id: user.decission_id,
					version_id: user.templateversion_id, 
					station: user.username, 
					is_user_agent_of: user.is_user_agent_of, 
					status:user.decission_state, 
					workflow_slot_id:slot.workflow_slot_id,
					receivedat:user.received,
					user_id:user.user_id,
					statusinwords:user.decissioninwords,
					duration: user.received == null ? '' : user.in_progress_since ,
					slotgroup: user.slotgroup
				}));	
			}
				
			
		}
		for(var a=0;a<grid.store.getCount();a++) {
			var row = grid.getStore().getAt(a);	
			if(row.data.receivedat == null || row.data.status != 'WAITING') {
				row.data.action = '';
			}
			else {
				var id = row.data.decission_id;
				var templateversion_id = row.data.version_id;
				var is_user_agent_of = row.data.is_user_agent_of;
				var workflow_slot_id = row.data.workflow_slot_id;
				var workflowuser_id = row.data.id;
				var sendtoallatonce = row.data.senttoallatonce;
				var workflowuserid = row.data.id;
				var send_to_all_receivers = row.data.send_to_all_receivers;
				var userid = row.data.user_id;
				row.data.action =  '<center><table><tr><td width="16"><div id="workflowdetailresend'+ id +'"></div></td><td width="16"><div id="workflowdetailskip'+ id +'"></div></td><td width="16"><div id="workflowdetailuseragent'+ id +'"></div></td><td width="16"><div id="workflowdetailselectstation'+ id +'"></div></td></tr></table></center>';
				var btnDetails = cf.workflowdetailsDetails.createResendButton.defer(1,this, [id,templateversion_id, userid]);
				var btnDetails = cf.workflowdetailsDetails.createSkipButton.defer(1,this, [id, templateversion_id, workflow_slot_id, workflowuser_id]);
				var btnDetails = cf.workflowdetailsDetails.createUserAgentButton.defer(1,this, [id, is_user_agent_of, templateversion_id]);
				var btnDetails = cf.workflowdetailsDetails.createSelectStationButton.defer(1,this, [id,templateversion_id,sendtoallatonce, workflowuserid]);
			}
		}
	},
	
	initStore: function () {
		var reader = new Ext.data.ArrayReader({}, [
			{name: 'id'},
			{name: 'station'},
			{name: 'receivedat'},
			{name: 'decission_id'},
			{name: 'workflow_slot_id'},
			{name: 'statusinwords'},
			{name: 'senttoallatonce'},
			{name: 'send_to_all_receivers'},
			{name: 'is_user_agent_of'},
			{name: 'status'},
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
	
	initCM: function () {
		this.theCM  =  new Ext.grid.ColumnModel([
			{header: "<?php echo __('Station',null,'workflowmanagement'); ?>", width: 150, sortable: false, dataIndex: 'station', css : "text-align : left;font-size:12px;align:center;", hidden: false},
			{header: "<?php echo __('Received at',null,'workflowmanagement'); ?>", width: 150, sortable: false, dataIndex: 'receivedat', css : "text-align : left;font-size:12px;align:center;", hidden: false},
			{header: "<?php echo __('Status',null,'workflowmanagement'); ?>", width: 150, sortable: false, dataIndex: 'statusinwords', css : "text-align : left;font-size:12px;align:center;", hidden: false},
			{header: "<?php echo __('In progress since',null,'workflowmanagement'); ?>", width: 150, sortable: false, dataIndex: 'duration', css : "text-align : left;font-size:12px;align:center;",  hidden: false},
			{header: "<?php echo __('Group',null,'workflowmanagement'); ?>", width: 150, sortable: false, dataIndex: 'slotgroup', css : "text-align : left;font-size:12px;align:center;",  hidden: true},
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/retry.png' />&nbsp;&nbsp;</td><td><?php echo __('Send again to station',null,'workflowmanagement'); ?></td></tr><tr><td><img src='/images/icons/state_skip.png' />&nbsp;&nbsp;</td><td><?php echo __('Skip station',null,'workflowmanagement'); ?></td></tr><tr><td><img src='/images/icons/cs_subs.jpg' />&nbsp;&nbsp;</td><td><?php echo __('Select Useragent',null,'workflowmanagement'); ?></td></tr><tr><td><img src='/images/icons/cs.jpg' />&nbsp;&nbsp;</td><td><?php echo __('Change current station',null,'workflowmanagement'); ?></td></tr></table>\" ext:qwidth=\"230\"><?php echo __('Action',null,'documenttemplate'); ?></div>", width: 80, sortable: false, dataIndex: 'action', css : "text-align : left;font-size:12px;align:center;"}
		]);
		
	},
	
	initFieldset: function () {
		this.theFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Workflow details',null,'workflowmanagement'); ?>',
			allowBlank: false,
			style: 'margin-top:5px;margin-left:10px;',
			width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 100,
			height: 350
		});
	},
	
	createResendButton: function (id, version_id, userid) {
		var btn_copy = new Ext.form.Label({
			renderTo: 'workflowdetailresend' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/retry.png" /></span>',
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							cf.workflowdetailsCRUD.resendStation(version_id, userid);
						},
					scope: c
					});
				}
			}
		});
	}, 
	
	createSkipButton: function (id, templateversion_id, workflow_slot_id, workflowuser_id) {
		var btn_copy = new Ext.form.Label({
			renderTo: 'workflowdetailskip' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/state_skip.png" /></span>',
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							if (c.disabled == false) {
								cf.workflowdetailsCRUD.skipStation(id, templateversion_id, workflow_slot_id, workflowuser_id);
							}
							else {
								
							}
						},
					scope: c
					});
				}
			}
		});
	}, 
	createUserAgentButton: function (id, is_user_agent_of, templateversion_id) {
		if(is_user_agent_of == null || is_user_agent_of == '') {
			var disabled = false;
		}
		else {
			var disabled = true;
		}
		var btn_copy = new Ext.form.Label({
			renderTo: 'workflowdetailuseragent' + id,
			disabled : disabled,
			html: '<span style="cursor:pointer;"><img src="/images/icons/cs_subs.jpg" /></span>',
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							if (c.disabled == false) {
								//alert(id);
								cf.workflowdetailsSelectUseragent.init(id, templateversion_id);
							}
							else {
								
							}
						},
					scope: c
					});
				}
			}
		});
	}, 
	createSelectStationButton: function (id, templateversion_id,sendtoallatonce, workflowuser_id) {
		var disabled = sendtoallatonce == 1 ? true : false;
		var btn_copy = new Ext.form.Label({
			renderTo: 'workflowdetailselectstation' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/cs.jpg" /></span>',
			disabled: disabled,
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							if (c.disabled == false) {
								cf.workflowdetailsSelectStation.init(id, templateversion_id, workflowuser_id);
							}
							else {
								
							}
						},
					scope: c
					});
				}
			}
		});
	}
	
	
	
	
	
	
	
	
};}();