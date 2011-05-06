/**
* Entry point of Login Mask.
*
*/


Ext.namespace('cf');
Ext.BLANK_IMAGE_URL = '/images/default/s.gif';


cf.Main = function(){return {
	/** Calls layout class to init **/
	init: function(){
		cf.Layout.init();
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
Ext.onReady(cf.Main.init, cf.Main);