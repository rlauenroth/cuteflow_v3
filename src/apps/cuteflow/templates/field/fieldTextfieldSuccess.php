/** calls functions for textfield **/
cf.fieldTextfield = function(){return {
	
	theTextfieldFieldset			:false,
	
	/** call all necessarry function **/
	init: function () {
		this.initFieldset();
	},
	/** init fieldset **/
	initFieldset: function () {
		this.theTextfieldFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Textfield settings',null,'field'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 170,
			items:[{
				xtype: 'combo',
				mode: 'local',
				editable:true,
 				valueField:'id',
 				id: 'fieldTextfield_standard_id',
 				hiddenName : 'fieldTextfield_standard',
 				allowBlank:true,
				displayField:'text',
				triggerAction: 'all',
				emptyText:'<?php echo __('Input default value or select one',null,'field'); ?>',
				foreSelection: false,
   				fieldLabel: '<?php echo __('Default value',null,'field'); ?>',
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[['EMPTY', '<font color="#808080"><?php echo __('Input default value',null,'field'); ?></font>'],['{%DATE_SENDING%}', '{%DATE_SENDING%}'],['{%TIME%}', '{%TIME%}'],['{%CIRCULATION_TITLE%}', '{%CIRCULATION_TITLE%}'],['{%CIRCULATION_ID%}', '{%CIRCULATION_ID%}']]
				}),
   				width:280,
				listeners: {
					select: {
						fn:function(combo) {
							if (combo.getValue() == 'EMPTY') {
								combo.setValue();
							}
						}
					}
				}
						
			},{
				xtype: 'textfield',
				allowBlank:true,
				id: 'fieldTextfield_regularexpression',
   				fieldLabel: '<?php echo __('Regular expression',null,'field'); ?>',
   				width:280	
			}]
		});
		
	},
	
	/** nothing to check at the moment **/
	checkBeforeSubmit: function() {
		return true;
	},
	
	/** add data to fieldset when in editmode **/
	addData: function (data) {
		Ext.getCmp('fieldTextfield_standard_id').setValue(data.default_value);
		Ext.getCmp('fieldTextfield_regularexpression').setValue(data.regex);
		if(data.default_value != '{%DATE_SENDING%}' && data.default_value != '{%TIME%}' && data.default_value != '{%CIRCULATION_TITLE%}' && data.default_value != '{%CIRCULATION_ID%}' && data.default_value != '') {
		    var store = Ext.getCmp('fieldTextfield_standard_id').store;
			var Record = store.recordType;
			var r = new Record({
				id: data.default_value,
				text: data.default_value
			});
			store.insert(1,r);
			
		}
	}
	
	
	
	
	
};}();