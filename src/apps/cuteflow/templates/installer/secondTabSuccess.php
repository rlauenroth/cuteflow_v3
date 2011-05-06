cf.secondTab = function(){return {
	
	thePanel				:false,
	theProdFieldset			:false,
	theDataFieldset			:false,
	
	init: function(){
		
		this.initProd();
		this.initData();
		this.initPanel();
		this.thePanel.add(this.theProdFieldset);
		this.thePanel.add(this.theDataFieldset);
	},
	
	initPanel: function () {
		this.thePanel = new Ext.Panel({
			modal: true,
			closable: false,
			modal: true,
			title: '<?php echo __('Database Settings',null,'installer'); ?>, <?php echo __('Step',null,'installer'); ?>: 4/4',
			layout: 'form',
			width: 750,
			height: 490,
			autoScroll: true,
			forceLayout:true,
			shadow: false,
			minimizable: false,
			autoScroll: false,
			draggable: false,
			resizable: false,
			plain: false
		});
	},
	
	
	initData: function () {
		this.theDataFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Data to load',null,'installer'); ?>',
			width: 600,
			height: 100,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 240,
			items:[{
				xtype: 'combo',
				mode: 'local',
				editable:false,
 				valueField:'id',
 				value: 'systemData.yml',
 				disabled: false,
 				id: 'productive_data_id',
 				hiddenName : 'productive_data',
				displayField:'text',
				triggerAction: 'all',
				foreSelection: true,
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[['systemData.yml', '<?php echo __('System Data only',null,'installer'); ?>'],['data.yml', '<?php echo __('Data with some Examples',null,'installer'); ?>']]
   				}),
   				fieldLabel: '<?php echo __('System data',null,'installer'); ?>',
   				width:300
			},{
				xtype : 'textfield',
				fieldLabel: '<?php echo __('Set email adresse of admin',null,'installer'); ?>',
				id: 'productive_emailadresse',
				value: 'cuteflow@cuteflow.de',
				vtype:'email',
				disabled: false,
				width:300
			}]
		});
	},
	
	initProd: function () {
		this.theProdFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Database Settings',null,'systemsetting'); ?>',
			width: 600,
			height: 200,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 240,
			items:[{
				xtype: 'combo',
				mode: 'local',
				editable:false,
 				valueField:'id',
 				value: 'mysql',
 				disabled: false,
 				id: 'productive_database_id',
 				hiddenName : 'productive_database',
				displayField:'text',
				triggerAction: 'all',
				foreSelection: true,
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[
	       				 ['fbsql', '<?php echo __('FrontBase',null,'systemsetting'); ?>'],
	       				 ['ibase', '<?php echo __('Firebird/Interbase',null,'systemsetting'); ?>'],
	       				 ['mssql', '<?php echo __('MS SQL Server',null,'systemsetting'); ?>'],
 	       				 ['mysql', '<?php echo __('MySQL',null,'systemsetting'); ?>'],
	       				 ['mysqli', '<?php echo __('MySQL (supports new auth protocol)',null,'systemsetting'); ?>'],
	       				 ['oci', '<?php echo __('Oracle 7-10',null,'systemsetting'); ?>'],
 	       				 ['pgsql', '<?php echo __('PostgreSQL',null,'systemsetting'); ?>'],
	       				 ['querysim', '<?php echo __('QuerySim',null,'systemsetting'); ?>'],
	       				 ['sqlite', '<?php echo __('SQLite 2',null,'systemsetting'); ?>']
       				 ]
   				}),
   				fieldLabel: '<?php echo __('Select Database',null,'installer'); ?>',
   				width:300
			},{
				xtype : 'textfield',
				fieldLabel: '<?php echo __('Host',null,'installer'); ?>',
				id: 'productive_host',
				value: 'localhost',
				disabled: false,
				width:300
			},{
				xtype : 'textfield',
				fieldLabel: '<?php echo __('Databasename',null,'installer'); ?>',
				id: 'productive_databasename',
				value: 'cuteflow',
				disabled: false,
				width:300
			},{
				xtype : 'textfield',
				fieldLabel: '<?php echo __('Username',null,'installer'); ?>',
				id: 'productive_username',
				value: 'root',
				disabled: false,
				width:300
			},{
				xtype : 'textfield',
				fieldLabel: '<?php echo __('Password',null,'installer'); ?>',
				id: 'productive_password',
				disabled: false,
				width:300
			}]
		});
	}
	
};}();