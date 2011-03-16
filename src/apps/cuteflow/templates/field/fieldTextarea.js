/** calls fieldset for textarea **/
cf.fieldTextarea = function(){return {
	
	theTextarea				:false,
	theHTMLarea				:false,
	theCombo				:false,
	theTextareaFieldset		:false,
	
	
	/** call all necessary functions **/
	init: function () {
		this.initTextarea();
		this.initHTMLarea();
		this.initCombobox();
		this.initFieldset();
		this.theTextareaFieldset.add(this.theCombo);
		this.theTextareaFieldset.add(this.theTextarea);
		this.theTextareaFieldset.add(this.theHTMLarea);
	},
	
	/** init fieldset **/
	initFieldset: function () {
		this.theTextareaFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Textarea settings',null,'field'); ?>',
			width: 600,
			height: 'auto',
			hidden: true,
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 170
		});
	},
	/** init Textarea **/
	initTextarea: function () {
		this.theTextarea = new Ext.form.TextArea({
			fieldLabel: '<?php echo __('Input default Text',null,'field'); ?>',
			width: 350,
			id: 'fieldTextarea_textarea',
			height: 150
		});
	},
	/** init HTML area **/
	initHTMLarea: function () {
		this.theHTMLarea = new Ext.form.HtmlEditor({
			fieldLabel: '<?php echo __('Input default HTML-Text',null,'field'); ?>',
			width: 350,
			hidden:true,
			id: 'fieldTextarea_htmlarea',
			height: 150
		});
	},
	
	/** init combo to change between textarea htmlarea **/
	initCombobox: function () {
		this.theCombo = new Ext.form.ComboBox ({
			fieldLabel: '<?php echo __('Content Type',null,'field'); ?>',
			width: 300,
			editable:false,
			triggerAction: 'all',
			foreSelection: true,
			hiddenName: 'fieldTextarea_contenttype',
			id: 'fieldTextarea_contenttype_id',
			mode: 'local',
			value: 'plain',
			store: new Ext.data.SimpleStore({
				 fields:['id','text'],
   				 data:[['plain', '<?php echo __('Plain',null,'field'); ?>'],['html', '<?php echo __('HTML',null,'field'); ?>']]
				}),
			valueField:'id',
			displayField:'text',
			width:350,
			listeners: {
	    		select: {
	    			fn:function(combo, value) {
	    				if(combo.getValue() == 'plain'){
	    					var value = cf.fieldTextarea.theHTMLarea.getValue();
	    					cf.fieldTextarea.theHTMLarea.setVisible(false);
	    					cf.fieldTextarea.theTextarea.setVisible(true);
	    					//cf.fieldTextarea.theTextarea.setValue(value);
	    				}
	    				else {
	    					var value = cf.fieldTextarea.theTextarea.getValue();
	    					cf.fieldTextarea.theHTMLarea.setVisible(true);
	    					cf.fieldTextarea.theTextarea.setVisible(false);
	    					//cf.fieldTextarea.theHTMLarea.setValue(value);
	    				}
	    			}
	    		}
	    	}
		});
	},
	/** function checks numbers **/
	checkBeforeSubmit: function() {
		return true;
	},
	/** add data when in editmode **/
	addData: function (data) {
		Ext.getCmp('fieldTextarea_contenttype_id').setValue(data.contenttype);
		Ext.getCmp('fieldTextarea_htmlarea').setValue(data.content);
		Ext.getCmp('fieldTextarea_textarea').setValue(data.content);
		if(data.contenttype == 'html') {
			Ext.getCmp('fieldTextarea_htmlarea').setVisible(true);
			Ext.getCmp('fieldTextarea_textarea').setVisible(false);
		}
		
	}
	
	
	
	
	
	
	
};}();