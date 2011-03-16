cf.workfloweditAcceptWorkflow = function(){return {


	theFieldset 					:false,
	theRadiogroup					:false,
	theTextarea						:false,
	theHiddenField					:false,
	
	
	init: function () {
		this.initHiddenfield();
		this.initFieldset();
		this.initCheckbox();
		this.initTextarea();
		this.theFieldset.add(this.theRadiogroup);
		this.theFieldset.add(this.theTextarea);
		this.theFieldset.add(this.theHiddenField);
	},
	
	initHiddenfield: function () {
		this.theHiddenField =  new Ext.form.Hidden({
			name: 'workfloweditAcceptWorkflow_decission',
			value: '1',
			width: 1
		});
		
	},
	
	initCheckbox: function () {
		var store = new Array();
		var radio = new Ext.form.Radio({
			 boxLabel: '<?php echo __('Accept Workflow',null,'workflowmanagement'); ?>',
			 id: 'workfloweditAcceptWorkflow_acceptWorkflowTrue',
			 name: 'workfloweditAcceptWorkflow_acceptWorkflow',
			 checked: true,
			 inputValue: 1

		});
		store[0] = radio;
		
		var radio = new Ext.form.Radio({
			 boxLabel: '<?php echo __('Refuse Workflow',null,'workflowmanagement'); ?>',
			 id: 'workfloweditAcceptWorkflow_acceptWorkflowFalse',
			 name: 'workfloweditAcceptWorkflow_acceptWorkflow',
			 inputValue: 1

		});
		store[1] = radio;
		this.theRadiogroup = new Ext.form.RadioGroup({
			id: 'workfloweditAcceptWorkflow_acceptWorkflow',
			fieldLabel: '<?php echo __('Accept Workflow',null,'workflowmanagement'); ?>',
			items:[store],
			listeners: {
	    		change: {
	    			fn:function(radiogroup, radio) {
						if(radio.getId() == 'workfloweditAcceptWorkflow_acceptWorkflowFalse') {
							cf.workfloweditAcceptWorkflow.theTextarea.setVisible(true);
							cf.workfloweditAcceptWorkflow.theHiddenField.setValue('0');
						}
						else {
							cf.workfloweditAcceptWorkflow.theTextarea.setVisible(false);
							cf.workfloweditAcceptWorkflow.theHiddenField.setValue('1');
						}
						cf.workflowedit.thePanel.doLayout();
	    			}
	    		}
	    	} 

		});
		
		
	},
	
	initFieldset: function () {
		this.theFieldset = new Ext.form.FieldSet({
			title: '<table><tr><td><img src="/images/icons/exclamation.png" /></td><td><?php echo __('Accept Workflow',null,'workflowmanagement'); ?></td></tr></table>',
			autoScroll: true,
			style: 'margin-top:5px;margin-left:10px;margin-right:10px;',
			width: cf.Layout.theRegionWest.getWidth() +  cf.Layout.theRegionCenter.getWidth() - 100,
			height: 'auto'
		});
		
	},
	
	
	
	initTextarea: function () {
		this.theTextarea = new Ext.form.HtmlEditor({
			fieldLabel: '<?php echo __('End reason',null,'workflowmanagement'); ?>',
			id: 'workfloweditAcceptWorkflow_reason',
			hidden: true,
			width: 450,
			height: 150
		});
	}












};}();