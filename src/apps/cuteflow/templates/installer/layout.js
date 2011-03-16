/**
* Layout Class puts all login elements into one window, and inits all elements
*
*/


cf.Layout = function(){return {
	
	
	/** Calls all necessary function to display the login form **/
	init: function(){
		cf.mainWindow.init();
		cf.mainWindow.theWindow.doLayout();
		cf.mainWindow.theWindow.show();
	}
};}();
