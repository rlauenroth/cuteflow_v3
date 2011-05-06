/**
* Class inits the Searchbar for the usergrid, and handles also the searchrequest if 
* searchbutton is hit
* 
*/

cf.UserSearchbar = function(){return {

	theUserSearchbar			:false,
	theUserRoleStore			:false,
	theUserRoleStoreInitialized :false,
	
	/** init searchbar function, handles also search functioniality**/
	init: function () {
		this.initRoleStore();
		this.theUserSearchbar = new Ext.Panel({
				closable: false,
				plain: false,
				frame: false,
				height:220,
				title: '<?php echo __('Searchbar',null,'usermanagement'); ?>',
				style:'margin-top:5px;margin-left:5px;',
				collapsible:true,
				collapsed: true,
				items:[{
					layout: 'form',
					items: [{
						xtype:'textfield',
						fieldLabel: '&nbsp;<?php echo __('Firstname',null,'usermanagement'); ?>',
						style:'margin-top:2px;',
						name: 'searchbar_firstname',
						id: 'searchbar_firstname',
						width:150
					},{
						xtype:'textfield',
						fieldLabel: '&nbsp;<?php echo __('Lastname',null,'usermanagement'); ?>',
						name: 'searchbar_lastname',
						id: 'searchbar_lastname',
						width:150
					},{
						xtype:'textfield',
						fieldLabel: '&nbsp;<?php echo __('Email',null,'usermanagement'); ?>',
						name: 'searchbar_email',
						id: 'searchbar_email',
						width:150
					},{
						xtype:'textfield',
						fieldLabel: '&nbsp;<?php echo __('Username',null,'usermanagement'); ?>',
						name: 'searchbar_username',
						id: 'searchbar_username',
						width:150
					},{
						xtype: 'combo',
						fieldLabel : '&nbsp;<?php echo __('Userrole',null,'usermanagement'); ?>',
						id: 'searchbar_userrole',
						valueField: 'id',
						mode: 'remote',
						displayField: 'description',
						store: this.theUserRoleStore,
						editable: false,
						typeAhead: false,
						triggerAction: 'all',
						allowBlank: true,
						width: 150
					},{
				        xtype: 'fieldset',
						autoHeight: true,
				        border: false,
				        defaultType: 'textfield',
				        layout: 'column',
				        items:[{
							xtype: 'button',
							icon: '/images/icons/zoom.png',
							text: '<?php echo __('Search',null,'usermanagement'); ?>',
							width: 70,
							height:25,
							style:'margin-bottom:5px;margin-left:35px;',
							handler: function (){
								
								var flag = false;
								var append = '';
								
								if(Ext.getCmp('searchbar_firstname').getValue() != '') {
									append += '/firstname/' + Ext.getCmp('searchbar_firstname').getValue();
									flag = true;
								}
								if(Ext.getCmp('searchbar_lastname').getValue() != '') {
									append += '/lastname/' + Ext.getCmp('searchbar_lastname').getValue();
									flag = true;
								}
								if(Ext.getCmp('searchbar_email').getValue() != '') {
									append += '/email/' + Ext.getCmp('searchbar_email').getValue();
									flag = true;
								}
								if(Ext.getCmp('searchbar_username').getValue() != '') {
									append += '/username/' + Ext.getCmp('searchbar_username').getValue();
									flag = true;
								}
								if(Ext.getCmp('searchbar_userrole').getValue() != '') {
									append += '/userrole/' + Ext.getCmp('searchbar_userrole').getValue();
									flag = true;
								}
	
								if (flag == true) {
									var url = encodeURI('<?php echo build_dynamic_javascript_url('usermanagement/LoadAllUserFilter')?>' + append);
									cf.UserGrid.theUserStore.proxy.setApi(Ext.data.Api.actions.read,url);
									cf.UserGrid.theUserStore.reload();
								}
								else {
									var url = encodeURI('<?php echo build_dynamic_javascript_url('usermanagement/LoadAllUser')?>');
									cf.UserGrid.theUserStore.proxy.setApi(Ext.data.Api.actions.read,url);
								}
							}
						},{
							xtype: 'button',
							icon: '/images/icons/delete.png',
							text: '<?php echo __('Discard',null,'usermanagement'); ?>',
							width: 70,
							height:25,
							style:'margin-bottom:5px;margin-left:25px;',
							handler: function () {
								Ext.getCmp('searchbar_firstname').setValue();
								Ext.getCmp('searchbar_lastname').setValue();
								Ext.getCmp('searchbar_email').setValue();
								Ext.getCmp('searchbar_username').setValue();
								Ext.getCmp('searchbar_userrole').setValue();
								var url = encodeURI('<?php echo build_dynamic_javascript_url('usermanagement/LoadAllUser')?>');
								cf.UserGrid.theUserStore.proxy.setApi(Ext.data.Api.actions.read,url);
								cf.UserGrid.theUserStore.reload();
							}
						}]
					}]
				}]
		});
		
		this.theUserSearchbar.on('expand', function() {
			cf.UserGrid.theGridPanel.setSize({width: 'auto', height: cf.Layout.theRegionWest.getHeight() - 262});
			cf.UserGrid.theUserGrid.setSize({width: 'auto', height: cf.Layout.theRegionWest.getHeight() - 282});
		});
		this.theUserSearchbar.on('collapse', function() {
			cf.UserGrid.theGridPanel.setSize({width: 'auto', height: cf.Layout.theRegionWest.getHeight() - 70});
			cf.UserGrid.theUserGrid.setSize({width: 'auto', height: cf.Layout.theRegionWest.getHeight() - 90});
		});
	},
	
	/** store for roles in searchbar **/
	initRoleStore: function () {
		this.theUserRoleStoreInitialized = true;
		this.theUserRoleStore = new Ext.data.JsonStore({
				root: 'result',
				url: '<?php echo build_dynamic_javascript_url('usermanagement/LoadAllRole')?>',
				autoload: true,
				fields: [
					{name: 'id'},
					{name: 'description'}
				]
		});
	}
	
	
};}();