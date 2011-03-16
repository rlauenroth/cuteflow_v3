cf.workfloweditHiddenPanel = function(){return {
	
	theGrid 					:false,
	theStore					:false,
	theCM						:false,
	
	
	init:function (data, showNames) {
		this.initStore();
		this.initCM();
		this.initGrid(data, showNames);
	},
	
	
	initGrid:function (data, showNames) {
		this.theGrid = new Ext.grid.GridPanel({
			stripeRows: true,
			border: true,
			width: 270,
			height:  cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 170,
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
			cf.workfloweditHiddenPanel.addItems(grid, data, showNames);			
		});
	},
	
	
	
	addItems: function (grid, data, showNames) {
		for(var a=0;a<data.length;a++) {
			var slot = data[a];
			for(var b=0;b<slot.user.length;b++) {
				var user = slot.user[b];
				var Rec = Ext.data.Record.create(
					{name: 'id'},
					{name: 'decission_id'},
					{name: 'senttoallatonce'},
					{name: 'sendtoallreceivers'},
					{name: 'station'},
					{name: 'receivedat'},
					{name: 'statusinwords'},
					{name: 'workflowslot_id'},
					{name: 'status'},
					{name: 'isuseragentof'},
					{name: 'user_id'},
					{name: 'duration'},
					{name: 'slotgroup'},
					{name: 'version_id'},
					{name: 'action'}	
				);	
				
				if(showNames != 1) {
					user.username = '-';
				}
				
				grid.store.add(new Rec({
					id: user.id,
					senttoallatonce: slot.senttoallatonce, 
					sendtoallreceivers: slot.sendtoallreceivers, 
					decission_id: user.decission_id,
					version_id: user.templateversion_id, 
					station: user.username, 
					isuseragentof: user.isuseragentof, 
					status:user.decissionstate, 
					workflowslot_id:slot.workflowslot_id,
					receivedat:user.received,
					user_id:user.user_id,
					statusinwords:user.decissioninwords,
					duration: user.received == null ? '' : user.inprogresssince ,
					slotgroup: user.slotgroup
				}));	
			}	
		}
	},
	
	initStore: function () {
		var reader = new Ext.data.ArrayReader({}, [
			{name: 'id'},
			{name: 'station'},
			{name: 'receivedat'},
			{name: 'decission_id'},
			{name: 'workflowslot_id'},
			{name: 'statusinwords'},
			{name: 'senttoallatonce'},
			{name: 'sendtoallreceivers'},
			{name: 'isuseragentof'},
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
			{header: "<?php echo __('Station',null,'workflowmanagement'); ?>", width: 120, sortable: false, dataIndex: 'station', css : "text-align : left;font-size:12px;align:center;", hidden: false},
			{header: "<?php echo __('Status',null,'workflowmanagement'); ?>", width: 185, sortable: false, dataIndex: 'statusinwords', css : "text-align : left;font-size:12px;align:center;", hidden: false},
			{header: "<?php echo __('Group',null,'workflowmanagement'); ?>", width: 150, sortable: false, dataIndex: 'slotgroup', css : "text-align : left;font-size:12px;align:center;",  hidden: true}
		]);
		
	}
	
	
	
	
	
	
};}();