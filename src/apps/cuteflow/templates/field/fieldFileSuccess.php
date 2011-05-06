/** inits fieldset for files **/
cf.fieldFile = function(){return {
	
	theFileFieldset			:false,
	
	/** calls all necessarry functions **/
	init: function () {
		this.initFieldset();
	},
	
	
	/** build fieldset **/
	initFieldset: function () {
		this.theFileFieldset = new Ext.form.FieldSet({
			title: '<table><tr><td><img src="/images/icons/information.png"  ext:qtip=\"<?php echo __('During the Circulation you can choose and upload a file',null,'field'); ?>\" ext:qwidth=\"300\"/></td><td>&nbsp;&nbsp;<?php echo __('File settings',null,'file'); ?></td></tr></table>',
			width: 600,
			height: 'auto',
			hidden: true,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 170,
			items:[{
				xtype: 'textfield',
				allowBlank:true,
				id: 'fieldFile_regularexpression',
   				fieldLabel: '<?php echo __('Regular expression',null,'field'); ?>',
   				width:230		
			}]
		});
	},
	
	/** function checks file **/
	checkBeforeSubmit: function() {
		return true;
	},
	
	/** add data to fieldset when in editmode **/
	addData: function (data) {
		Ext.getCmp('fieldFile_regularexpression').setValue(data.regex);
		
	}
	
	
	
	
	
};}();