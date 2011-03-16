/**
* Is main Entry Point for Application
* Class sets namesapce and calls Layout Class to initalize the layout.
*/
Ext.namespace('cf');
Ext.BLANK_IMAGE_URL = '/images/default/s.gif';

cf.Main = function(){return {
	
	theUserRole                : false,
	theLoadingMask			   : false,

	
	/*********************************/
	
	/** call to init main layout **/
	init: function(){
		cf.Main.hideLoadingMask();
		setTimeout('cf.Main.sessionCheck()',600000);// 600.000 = 10 mins
		cf.Layout.init();
	},
	
	
	
	sessionCheck: function () {
		setTimeout('cf.Main.sessionCheck()',600000);// 600.000 = 10 mins
		Ext.Ajax.request({  
		url : '<?php echo build_dynamic_javascript_url('layout/CheckSession')?>',
			success: function(objServerResponse){
				theJsonTreeData = Ext.util.JSON.decode(objServerResponse.responseText);
				var session = theJsonTreeData.result;
				if(session != 1) {
					window.location.href = '<?php echo build_dynamic_javascript_url('login/index')?>';
				}
				
				
			}
		});
	},
	
	hideLoadingMask: function () {
		var loadingMask = Ext.get('loading-message');
	    loadingMask.shift({
			remove: true,
			duration: 1,
			opacity: 0.1,
			easing: 'bounceOut'
     	});

	}
	
	
	
};}();

Ext.lib.Event.resolveTextNode = Ext.isGecko ? function(node){
	if(!node){
		return;
	}
	var s = HTMLElement.prototype.toString.call(node);
	if(s == '[xpconnect wrapped native prototype]' || s == '[object XULElement]'){
		return;
	}
	return node.nodeType == 3 ? node.parentNode : node;
} : function(node){
	return node && node.nodeType == 3 ? node.parentNode : node;
};

Ext.override(Ext.Component, {
	hideMode : "offsets"
});            
Ext.override(Ext.layout.CardLayout, {
	deferredRender : false
});            
Ext.override(Ext.TabPanel, {
	deferredRender : false
});

Ext.QuickTips.init();
Ext.onReady(cf.Main.init, cf.Main);