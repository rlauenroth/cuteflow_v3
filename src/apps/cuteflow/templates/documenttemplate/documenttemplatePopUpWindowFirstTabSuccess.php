cf.documenttemplatePopUpFirstTab = function(){return {


	theFirstTabPanel			:false,
	theFirstTabFieldset			:false,

	/** init first tab of pop up panel **/
	init: function () {
		this.initFirstTabPanel();
		this.initFirstTabFieldset();
		this.theFirstTabPanel.add(this.theFirstTabFieldset);
	},

	/** init first tab to enter description of the template **/
	initFirstTabPanel: function () {
		this.theFirstTabPanel = new Ext.FormPanel({
			title: '<?php echo __('Description',null,'documenttemplate'); ?>',
			frame:true,
			height: cf.Layout.theRegionWest.getHeight() + cf.Layout.theRegionNorth.getHeight() - 148
		});
	},

	/** init fieldset for first tab, with description **/
	initFirstTabFieldset: function () {
		this.theFirstTabFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Set name of Document template',null,'documenttemplate'); ?>',
			width: 600,
			height: 'auto',
			style: 'margin-top:20px;margin-left:5px;',
			labelWidth: 170,
			items: [{
				xtype: 'textfield',
				id:'documenttemplatePopUpFirstTab_fieldname',
				allowBlank: true,
				fieldLabel: '<?php echo __('Name',null,'documenttemplate'); ?>',
				width:220
			}]
		});
	
	}


};}();