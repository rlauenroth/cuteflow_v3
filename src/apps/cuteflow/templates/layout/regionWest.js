/**
* Class creates the Navigation for the west Region.
* Class also Handles the Click Functionality and adds Navigation Clicks to TabPanel
*
*/
cf.Navigation = function(){return {

	
	isInitialized                 : false,
	theAccordion            	  : false, // stores the left Navigationpabel
	theUserFirstLogin			  : false,
	theFirstLogin				  : false,
	theWorfklowVersionId		  : false,
	theWorfklowId		 		  : false,
	theWorklfowWindow			  : false,
	
	/** functions loads accordion for region west **/
	init: function () {
		
		this.theWorfklowVersionId = (Ext.get('version_id').dom.value);
		this.theWorfklowId = (Ext.get('workflow_id').dom.value);
		this.theWorklfowWindow = (Ext.get('window').dom.value);

		this.theUserFirstLogin = '<?php echo UserSettingClass::getFirstLogin();?>';
		this.theFirstLogin = '<?php echo SystemSetting::getFirstLogin();?>';
		this.initAccordion();
		this.initTree();
		cf.Navigation.initMyProfilePanel.defer(2000, this,'');
		
	},
	
	/** reloads navigation west **/
	reloadNavigation: function () {
		this.initAccordion();
		this.initTree();
	},
	
	/** functions loads all data for the navigation **/
	initTree: function () {
		var url =  '<?php echo build_dynamic_javascript_url('menue/loadMenue')?>';
		Ext.Ajax.request({  
			url : url,
			success: function(objServerResponse){
				theJsonTreeData = Ext.util.JSON.decode(objServerResponse.responseText);
				cf.Navigation.initNavigation(theJsonTreeData);
			}
		});
	},

	/** functions inits the left navigation out of the ext data **/
	initNavigation: function (theJsonTreeData) {
		for(var a=0;a<theJsonTreeData.result.length;a++) {
			var panel = new Ext.Panel({
                title: '<table><tr><td><div id="' + theJsonTreeData.result[a].usermodule.icon + '"></div></td><td style="font-size:15px;">&nbsp;&nbsp;<b>'+theJsonTreeData.result[a].usermodule.translation+'</b></td></tr></table>',
                id: 'regionWest_' + theJsonTreeData.result[a].usermodule.title,
				collapsed: true
            });
            var tree = new Ext.tree.TreePanel({
				frame: false,
				width: 230,
				animate: true,
			    enableDD: false,
				bodyStyle:'padding:5px;',
				rootVisible: false,
				border: false,
				expanded: true
        	});
        	var root = new Ext.tree.TreeNode({
        		text: 'root',
        		loaded: true,
        		expanded: true
        	});


        	for (var b=0;b<theJsonTreeData.result[a].usermodule.usergroup.length;b++) {
        		var myTreeItem = theJsonTreeData.result[a].usermodule.usergroup[b];
				var disabled = myTreeItem.disabled == 'true' ? true : false;
				root.appendChild(new Ext.tree.TreeNode({
					leaf: true,
					id: myTreeItem.object,
					disabled: disabled,
					iconCls: myTreeItem.icon,
					text:  '&nbsp;<span style="font-size:13px;">' + myTreeItem.translation + '</span>',
					listeners: {
						click: {
							fn:function(node,value) {
								if(node.disabled == false) {
									cf.Navigation.handleClick(node);
								}
							}
						}
					}
				}));
        	}
        	tree.setRootNode(root);
            panel.add(tree);
			this.theAccordion.add(panel);
		}
		this.theAccordion.doLayout();
		if(cf.Navigation.theWorfklowVersionId != -1) {
			if(cf.Navigation.theWorklfowWindow == 'edit') {
				cf.workflowedit.init(cf.Navigation.theWorfklowId, cf.Navigation.theWorfklowVersionId);
			}
			else {
				cf.workflowdetails.init(cf.Navigation.theWorfklowId,cf.Navigation.theWorfklowVersionId, true, false, true );
			}
		}
	},
	
	/** init my profile panel, when firstlogin is set **/
	initMyProfilePanel: function () {
		if(cf.Navigation.theFirstLogin == 1 && cf.Navigation.theUserFirstLogin == 1) {
			cf.Navigation.theUserFirstLogin = 0;
			cf.Navigation.theFirstLogin = 0;
			cf.administration_myprofile.init();
			cf.TabPanel.theTabPanel.add(cf.administration_myprofile.getInstance());	
			cf.TabPanel.theTabPanel.setActiveTab(cf.administration_myprofile.getInstance());
			Ext.Ajax.request({  
				url :  '<?php echo build_dynamic_javascript_url('layout/ChangeFirstLogin')?>',
				success: function(objServerResponse){
				}
			});
		}
		
	},
	
	/**
	* Function handles the click of a node an generates the window object
	*
	* @param Ext.tree.TreeNode node, Treenode object
	*
	*/
	handleClick: function (node) {
		
		var c = ('cf.'+node.id);
		var windowObject = eval(c);
		if(cf.TabPanel.theTabPanel.items.length > 0) {
			if (windowObject.isInitialized == false) {
				windowObject.init();
				cf.TabPanel.theTabPanel.add(windowObject.getInstance());	
				cf.TabPanel.theTabPanel.setActiveTab(windowObject.getInstance());
			}
			else {
				var windowLabel = windowObject.getInstance();
				var tab = cf.TabPanel.theTabPanel.findById(windowLabel.id);
				if(tab == null) {
					windowObject.setInitialized(false);
					windowObject.init();
					cf.TabPanel.theTabPanel.add(windowObject.getInstance());
					cf.TabPanel.theTabPanel.setActiveTab(windowObject.getInstance());
					cf.TabPanel.theTabPanel.doLayout();
				}
				else {
					cf.TabPanel.theTabPanel.setActiveTab(windowObject.getInstance());
				}
			}
		}
		else {
			cf.Layout.theRegionCenter.remove(cf.TabPanel.theTabPanel);
			cf.TabPanel.setInitialized(false);
			cf.TabPanel.init();
			windowObject.setInitialized(false);
			windowObject.init();
			cf.TabPanel.theTabPanel.add(windowObject.getInstance());
			cf.Layout.theRegionCenter.add(cf.TabPanel.theTabPanel);
			cf.Layout.theRegionCenter.doLayout();
		}
		
		
	},
	
	/** function inits the accordion panel **/
	initAccordion: function () {
		this.theAccordion = new Ext.Panel({
            margins:'5 0 5 5',
            split:true,
            autoScroll: false,
            width: 240,
			layoutConfig: {
				titleCollapse: true,
				animate: true
			},
			layout:'accordion'
        });
	}
	
	
	
	
};}();