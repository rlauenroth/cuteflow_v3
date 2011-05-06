/**
* Layout Class puts all login elements into one window, and inits all elements
*
*/


cf.Layout = function(){return {
	
	
	/** Calls all necessary function to display the login form **/
	init: function(){
		cf.ComboBox.init();
		cf.Textfield.init();
		cf.Window.init();
		
		cf.Textfield.thePanel.add(cf.Textfield.theUsernameField);
		cf.Textfield.thePanel.add(cf.Textfield.theUserpasswordField);
		cf.Textfield.thePanel.add(cf.Textfield.theHiddenField);
		cf.Textfield.thePanel.add(cf.Textfield.theHiddenURL);
		cf.Textfield.thePanel.add(cf.ComboBox.theComboBox);
		cf.Window.theWindow.add(cf.Textfield.thePanel);
		cf.Window.theWindow.show();
	}
};}();
