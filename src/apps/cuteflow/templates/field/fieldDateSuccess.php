/** create fieldset for date **/
cf.fieldDate = function(){return {
	
	theDateFieldset					:false,
	// change regex here
	theDDMMYYYY						:'^[0-9]{2}[-]{1}[0-9]{2}[-]{1}[0-9]{4}$',
	theMMDDYYYY						:'^[0-9]{2}[-]{1}[0-9]{2}[-]{1}[0-9]{4}$',
	theYYYYMMDD						:'^[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}$',
	theRegExStore					:'^[0-9]{2}[-]{1}[0-9]{2}[-]{1}[0-9]{4}$',

	
	/** calls all neccessary functions **/
	init: function () {
		this.initFieldset();
	},
	
	
	/** inits fieldset **/
	initFieldset: function () {
		this.theDateFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Textfield settings',null,'field'); ?>',
			width: 600,
			height: 'auto',
			hidden: true,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 170,
			items:[{
				xtype: 'combo',
				mode: 'local',
				editable:false,
				value: 'd-m-Y',
 				valueField:'id',
 				id: 'fieldDate_format_id',
 				hiddenName : 'fieldDate_format',
 				allowBlank:true,
				displayField:'text',
				triggerAction: 'all',
				emptyText:'<?php echo __('Input default value or select one',null,'field'); ?>',
				foreSelection: false,
   				fieldLabel: '<?php echo __('Date format',null,'field'); ?>',
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[['d-m-Y', 'dd-mm-yyyy'],['m-d-Y', 'mm-dd-yyyy'],['Y-m-d', 'yyyy-mm-dd']]
				}),
   				width:280,
				listeners: {
					select: {
						fn:function(combo, value) {
							cf.fieldDate.buildDate(combo,Ext.getCmp('fieldDate_date'));
							switch (combo.getValue()) {
								case "d-m-Y":
									Ext.getCmp('fieldDate_regularexpression').setValue(cf.fieldDate.theDDMMYYYY);
									cf.fieldDate.theRegExStore = cf.fieldDate.theDDMMYYYY;
									break;
								case "m-d-Y":
									Ext.getCmp('fieldDate_regularexpression').setValue(cf.fieldDate.theMMDDYYYY);
									cf.fieldDate.theRegExStore = cf.fieldDate.theMMDDYYYY;
									break;
								case "Y-m-d":
									Ext.getCmp('fieldDate_regularexpression').setValue(cf.fieldDate.theYYYYMMDD);
									cf.fieldDate.theRegExStore = cf.fieldDate.theYYYYMMDD;
									break;
							}
						}
					}
				}					
			},{
				xtype: 'datefield',
				allowBlank:true,
				id: 'fieldDate_date',
				format:'d-m-Y',
   				fieldLabel: '<?php echo __('Default value',null,'field'); ?>',
   				width:280	
			},{
				xtype: 'textfield',
				allowBlank:true,
				id: 'fieldDate_regularexpression',
   				fieldLabel: '<?php echo __('Regular expression',null,'field'); ?>',
   				value: cf.fieldDate.theDDMMYYYY,
   				width:280	
			}]
		});
	
	},
	/**
	* function changes the date field to the select format in the combobox
	*@param object combo, Combobox
	*@param object datefield, Datefield
	*/
	buildDate: function (combo, datefield) {
		var currentDate = datefield.getValue();
		datefield.format = combo.getValue();
		datefield.setValue(currentDate);	
	},
	
	/**
	* checks date before submit
	*@return boolean true/false, true if all is ok, false if not
	**/
	checkBeforeSubmit: function() {
		var input = Ext.getCmp('fieldDate_date').getRawValue();
		var regex = Ext.getCmp('fieldDate_regularexpression').getValue();
		var regexStore = cf.fieldDate.theRegExStore;
		if(regex == '') {
			if(input == '') {
				return true;
			}
			else {
				var regObject = new RegExp(regexStore,"m");
				if(regObject.test(input) == true) {
					Ext.getCmp('fieldDate_regularexpression').setValue(regexStore);
					return true;
				}
				else {
					Ext.Msg.minWidth = 200;
					Ext.MessageBox.alert('<?php echo __('Error',null,'field'); ?>', '<?php echo __('Input value is no valid date format',null,'field'); ?>');
					return false;
				}
			}
		}
		else {
			if(input == '') {
				return true;
			}
			else {
				var regObject = new RegExp(regex,"m");
				if(regObject.test(input) == true) {
					return true;
				}
				else {
					Ext.Msg.minWidth = 200;
					Ext.MessageBox.alert('<?php echo __('Error',null,'field'); ?>', '<?php echo __('Input value is no valid date format',null,'field'); ?>');
					return false;
				}
			}
			
		}
	},
	/** add data to all fieldsets when in editmode **/
	addData: function (data) {
		Ext.getCmp('fieldDate_format_id').setValue(data.dateformat);
		Ext.getCmp('fieldDate_date').format = data.dateformat;
		Ext.getCmp('fieldDate_date').setValue(data.defaultvalue);
		Ext.getCmp('fieldDate_regularexpression').setValue(data.regex);
	}
	

};}();