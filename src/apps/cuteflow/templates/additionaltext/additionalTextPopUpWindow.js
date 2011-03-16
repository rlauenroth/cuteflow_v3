/** popupwindow for edit or create new additional text **/
cf.additionalTextPopUpWindow = function(){return {
	
	thePopUpWindow				:false,
	theTitleFieldset			:false,
	theHTMLFieldset				:false,
	thePlainFieldset			:false,
	theTypeFieldset				:false,
	theFormPanel				:false,
	theContentPanel				:false,
	theLoadingMask					 : false,

	/**
	* calls all neded functions to build window
	*
	* @param int id, id is set, if user is in editmode of an record
	*
	*/
	init: function (id) {
		this.theLoadingMask = new Ext.LoadMask(Ext.getBody(), {msg:'<?php echo __('Loading Data...',null,'usermanagement'); ?>'});					
		this.theLoadingMask.show();
		cf.additionalTextPopUpGrid.init();
		this.initTitle();
		this.initContentPlain();
		this.initContentHTML();
		this.initType();
		this.initFormPanel();
		this.initContentPanel();
		this.initPopUpWindow(id);
		this.theContentPanel.add(this.theHTMLFieldset);
		this.theContentPanel.add(this.thePlainFieldset);
		this.theContentPanel.add(cf.additionalTextPopUpGrid.thePopUpGridFieldset);
		this.theFormPanel.add(this.theTitleFieldset);
		this.theFormPanel.add(this.theTypeFieldset);
		this.theFormPanel.add(this.theContentPanel);
		this.thePopUpWindow.add(this.theFormPanel);
		this.thePopUpWindow.show();
		this.initData(id);
		
	},
	
	/**
	* function loads data when in editmode
	*
	* @param int id, id is set, if user is in editmode of an record
	*/
	initData: function(id) {
		if(id != '') {
			Ext.Ajax.request({  
				url : '<?php echo build_dynamic_javascript_url('additionaltext/LoadText')?>/id/' + id, 
				success: function(objServerResponse){ 
					var ServerResult = Ext.util.JSON.decode(objServerResponse.responseText);
					Ext.getCmp('additionalTextPopUpWindow_titletextfield').setValue(ServerResult.result.title);
					if (ServerResult.result.contenttype == 'plain') {
						Ext.getCmp('additionalTextPopUpWindow_textarea').setValue(ServerResult.result.content);
						cf.additionalTextPopUpWindow.theHTMLFieldset.setVisible(false);
						Ext.getCmp('additionalTextPopUpWindow_typecombobox').setValue('plain');
					}
					else {
						Ext.getCmp('additionalTextPopUpWindow_HTMLarea').setValue(ServerResult.result.content);
						cf.additionalTextPopUpWindow.thePlainFieldset.setVisible(false);
						cf.additionalTextPopUpWindow.theHTMLFieldset.setVisible(true);
						Ext.getCmp('additionalTextPopUpWindow_typecombobox').setValue('html');
					}
					cf.additionalTextPopUpWindow.theLoadingMask.hide();
				}
				
			});
		}
		cf.additionalTextPopUpWindow.theLoadingMask.hide();
	},
	
	/** load formpanel **/
	initFormPanel: function () {
		this.theFormPanel = new Ext.FormPanel({
			plain: true,
			frame: true,
			border: false
		});
	},
	
	/** init column layout panel **/
	initContentPanel: function () {
		this.theContentPanel = new Ext.Panel({
		    layout: 'column',
			border: 'none',
			layoutConfig: {
				columns: 2,
				fitHeight: true,
				split: true
			}
		});
	},
	
	/**
	*
	* set main window
	* @param int id, id is set, if user is in editmode of an record
	*/
	initPopUpWindow: function (id) {
		if(id == '') {
			var title = '<?php echo __('Create new additional Text',null,'additionaltext'); ?>';
		}
		else {
			var title = '<?php echo __('Edit additional Text',null,'additionaltext'); ?>';
		}
		
		this.thePopUpWindow = new Ext.Window({
			modal: true,
			closable: true,
			modal: true,
			width: 930,
			height: 600,
			autoScroll: true,
			title: title,
			shadow: false,
			minimizable: false,
			draggable: true,
			resizable: true,
	        plain: false,
	        buttonAlign: 'center',
			close : function(){
				cf.additionalTextPopUpWindow.thePopUpWindow.hide();
				cf.additionalTextPopUpWindow.thePopUpWindow.destroy();
			},
			buttons:[{
				text:'<?php echo __('Store',null,'additionaltext'); ?>', 
				icon: '/images/icons/accept.png',
				handler: function () {
					cf.additionalTextCRUD.initSave(id);
				}
			},{
				text:'<?php echo __('Close',null,'additionaltext'); ?>', 
				icon: '/images/icons/cancel.png',
				handler: function () {
					cf.additionalTextPopUpWindow.thePopUpWindow.hide();
					cf.additionalTextPopUpWindow.thePopUpWindow.destroy();
				}
			}]
		});
	},
	
	/** init title fieldset **/
	initTitle: function () {
		this.theTitleFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Set Title',null,'additionaltext'); ?>',
			allowBlank: false,
			style: 'margin-top:5px;margin-left:10px;',
			width: 874,
			height: 'auto',
			items: [{
				xtype: 'textfield',
				name: 'title',
				allowBlank: false,
				id: 'additionalTextPopUpWindow_titletextfield',
				fieldLabel: '<?php echo __('Title',null,'additionaltext'); ?>',
				width: 300
			}]
		});
	},
	
	/** init type fieldset with combo **/
	initType: function () {
		this.theTypeFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Set Content Type',null,'additionaltext'); ?>',
			allowBlank: false,
			style: 'margin-top:5px;margin-left:10px;',
			width: 874,
			height: 'auto',
			items: [{
				xtype: 'combo',
				fieldLabel: '<?php echo __('Content Type',null,'additionaltext'); ?>',
				width: 300,
				editable:false,
				triggerAction: 'all',
				foreSelection: true,
				hiddenName : 'contenttype',
				id: 'additionalTextPopUpWindow_typecombobox',
				mode: 'local',
				value: 'plain',
				store: new Ext.data.SimpleStore({
					 fields:['id','text'],
       				 data:[['plain', '<?php echo __('Plain',null,'additionaltext'); ?>'],['html', '<?php echo __('HTML',null,'additionaltext'); ?>']]
   				}),
 				valueField:'id',
				displayField:'text',
				width:100,
				listeners: {
		    		select: {
		    			fn:function(combo, value) { 
							if(combo.getValue() == 'plain') {
								if(cf.additionalTextPopUpWindow.thePlainFieldset.hidden == true) {
									cf.additionalTextPopUpWindow.thePlainFieldset.setVisible(true);
									Ext.getCmp('additionalTextPopUpWindow_textarea').setValue(Ext.getCmp('additionalTextPopUpWindow_HTMLarea').getValue());
									cf.additionalTextPopUpWindow.theHTMLFieldset.setVisible(false);
								}
							}
							else {
								if(cf.additionalTextPopUpWindow.theHTMLFieldset.hidden == true) {
									cf.additionalTextPopUpWindow.theHTMLFieldset.setVisible(true);
									Ext.getCmp('additionalTextPopUpWindow_HTMLarea').setValue(Ext.getCmp('additionalTextPopUpWindow_textarea').getValue());
									cf.additionalTextPopUpWindow.thePlainFieldset.setVisible(false);
								}
							}
						}
					}
				}
			}]
		});
	},
	
	/** init fieldset for textarea (plain)**/
	initContentPlain: function () {
		this.thePlainFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Set Plain Body',null,'additionaltext'); ?>',
			allowBlank: false,
			style: 'margin-top:10px;margin-left:5px;',
			width: 620,
			height: 'auto',
			items: [{
				xtype: 'textarea',
				name: 'content_textarea',
				fieldLabel: '&nbsp;&nbsp;<?php echo __('Content',null,'additionaltext'); ?>:',
				id: 'additionalTextPopUpWindow_textarea',
				labelSeparator: '',
				allowBlank: true,
				height: 250,
				width: 200,
				value: '',
				anchor: '100%'
			}]
		});
	},
	
	/** init fieldset for htmlarea (html)**/
	initContentHTML: function () {
		this.theHTMLFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Set HTML Body',null,'additionaltext'); ?>',
			allowBlank: false,
			style: 'margin-top:10px;margin-left:10px;',
			width: 610,
			height: 'auto',
			hidden: true,
			items: [{
				xtype: 'htmleditor',
				name: 'content_htmleditor',
				fieldLabel: '&nbsp;&nbsp;<?php echo __('Content',null,'additionaltext'); ?>:',
				id: 'additionalTextPopUpWindow_HTMLarea',
				labelSeparator: '',			
				height: 250,
				width: 460,
				allowBlank: true,
				value: '',
				anchor: '98%'
			}]
		});
	}



};}();