/** inits fieldset for numbers **/
cf.fieldNumber = function(){return {
	
	theNumberFieldset					:false,
	// reg ex can be changed here
	theRegularExpressionPositive		: '^[0-9]{0,}[,]{0,1}[.]{0,1}[0-9]{0,}$',
	theRegularExpressionNegative		: '^[-]{1}[0-9]{0,}[,]{0,1}[.]{0,1}[0-9]{0,}$',
	theRegularExpressionAll				: '^[-]{0,1}[0-9]{0,}[,]{0,1}[.]{0,1}[0-9]{0,}$',
	
	
	/** init fieldset **/
	init: function () {
		this.initFieldset();
	},
	
	/** inits number fieldset **/
	initFieldset: function () {
		this.theNumberFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Number settings',null,'field'); ?>',
			width: 600,
			height: 'auto',
			hidden: true,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 170,
			items:[{
				xtype: 'textfield',
 				id: 'fieldNumber_standard',
 				allowBlank:true,
 				fieldLabel: '<?php echo __('Default value',null,'field'); ?>',
   				width:280		
			},{
				xtype: 'combo',
				mode: 'local',
				editable:false,
 				valueField:'id',
 				id: 'fieldNumber_regularexpressioncombo_id',
 				hiddenName : 'fieldNumber_regularexpressioncombo',
 				allowBlank:true,
				displayField:'text',
				triggerAction: 'all',
				value: 'EMPTY',
				foreSelection: false,
   				fieldLabel: '<?php echo __('Select regular Expression',null,'field'); ?>',
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[['EMPTY','<?php echo __('define own regular expression',null,'field'); ?>'],['NORESTRICTION', '<?php echo __('no restriction',null,'field'); ?>'],['POSITIVE', '<?php echo __('positive numbers only',null,'field'); ?>'],['NEGATIVE', '<?php echo __('negative numbers only',null,'field'); ?>']]
				}),
   				width:280,
				listeners: {
					select: {
						fn:function(combo, value) {
							if(combo.getValue() == 'EMPTY') {
								Ext.getCmp('fieldNumber_regularexpression').setValue();
								Ext.getCmp('fieldNumber_regularexpression').setDisabled(false);
							}
							else if(combo.getValue() == 'NORESTRICTION') {
								Ext.getCmp('fieldNumber_regularexpression').setValue(cf.fieldNumber.theRegularExpressionAll);
								Ext.getCmp('fieldNumber_regularexpression').setDisabled(true);
							}
							else if(combo.getValue() == 'POSITIVE'){
								Ext.getCmp('fieldNumber_regularexpression').setValue(cf.fieldNumber.theRegularExpressionPositive);
								Ext.getCmp('fieldNumber_regularexpression').setDisabled(true);
							}
							else {
								Ext.getCmp('fieldNumber_regularexpression').setValue(cf.fieldNumber.theRegularExpressionNegative);
								Ext.getCmp('fieldNumber_regularexpression').setDisabled(true);
							}
						}
					}
				}		
			},{
				xtype: 'textfield',
 				id: 'fieldNumber_regularexpression',
 				allowBlank:true,
				disabled: false,
 				fieldLabel: '<?php echo __('Regular expression',null,'field'); ?>',
   				width:280
			}]
		});

		
	},
	/** 
	* function checks numbers if all values are correct
	* @return boolean true/false, true if all data is correct-> save, false if data is not correct
	**/
	checkBeforeSubmit: function() {
		var combobox = Ext.getCmp('fieldNumber_regularexpressioncombo_id').getValue();
		var regEx = Ext.getCmp('fieldNumber_regularexpression').getValue();
		var input = Ext.getCmp('fieldNumber_standard').getValue();

		
		if(combobox == 'NORESTRICTION') {
			if(input != '') { // default value is set
				var regObject = new RegExp(cf.fieldNumber.theRegularExpressionAll,"m");
				if(regObject.test(input) == true) {
					Ext.getCmp('fieldNumber_regularexpression').setDisabled(false);
					return true;
				}
				else {
					Ext.Msg.minWidth = 200;
					Ext.MessageBox.alert('<?php echo __('Error',null,'field'); ?>', '<?php echo __('Input value is no number',null,'field'); ?>');
					return false;
				}
			}
			else {
				Ext.getCmp('fieldNumber_regularexpression').setDisabled(false);
				return true;
			}
		}
		else if (combobox == 'EMPTY') {
			if(regEx == '') {
				if(input == ''){
					Ext.getCmp('fieldNumber_regularexpression').setValue(cf.fieldNumber.theRegularExpressionAll);
					Ext.getCmp('fieldNumber_regularexpression').setDisabled(false);
					return true;
				}
				else {
					var regObject = new RegExp(cf.fieldNumber.theRegularExpressionAll,"m");
					if(regObject.test(input) == true) {
						Ext.getCmp('fieldNumber_regularexpression').setValue(cf.fieldNumber.theRegularExpressionAll);
						Ext.getCmp('fieldNumber_regularexpression').setDisabled(false);
						return true;
					}
					else {
						Ext.Msg.minWidth = 200;
						Ext.MessageBox.alert('<?php echo __('Error',null,'field'); ?>', '<?php echo __('Input value is no number',null,'field'); ?>');
						return false;
					}
				}
			}
			else {
				if(input == ''){
					Ext.getCmp('fieldNumber_regularexpression').setDisabled(false);
					return true;
				}
				else {
					try {
						var regObject = new RegExp(regEx,"m");
						if(regObject.test(input) == true) {
							Ext.getCmp('fieldNumber_regularexpression').setDisabled(false);
							return true;
						}
						else {
							Ext.Msg.minWidth = 200;
							Ext.MessageBox.alert('<?php echo __('Error',null,'field'); ?>', '<?php echo __('Input value is no number or RegEx is not valid',null,'field'); ?>');
							return false;
						}
					}
					catch(e) {
						Ext.Msg.minWidth = 200;
						Ext.MessageBox.alert('<?php echo __('Error',null,'field'); ?>', '<?php echo __('RegEx is not valid',null,'field'); ?>');
						return false;
					}
				}
				
			}
		}
		else {
			if(input == ''){
				Ext.getCmp('fieldNumber_regularexpression').setDisabled(false);
				return true;
			}
			else {
				var object = new RegExp(regEx,"m");
				if(object.test(input) == true) {
					Ext.getCmp('fieldNumber_regularexpression').setDisabled(false);
					return true;
				}
				else {
					Ext.Msg.minWidth = 200;
					Ext.MessageBox.alert('<?php echo __('Error',null,'field'); ?>', '<?php echo __('Input does not match to RegEx',null,'field'); ?>');
					return false;
				}
				
			}
		}
	},
	
	/** add data to componentes when in edit mode **/
	addData: function (data) {
		Ext.getCmp('fieldNumber_standard').setValue(data.defaultvalue);
		Ext.getCmp('fieldNumber_regularexpressioncombo_id').setValue(data.comboboxvalue);
		Ext.getCmp('fieldNumber_regularexpression').setValue(data.regex);
		if(data.comboboxvalue == 'POSITIVE' || data.comboboxvalue == 'NEGATIVE' || data.comboboxvalue == 'NORESTRICTION') {
			Ext.getCmp('fieldNumber_regularexpression').setDisabled(true);
		}
		
	}
	
	
	
	
	
	
};}();