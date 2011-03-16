/** creates Spaceholdergrid **/
cf.additionalTextPopUpGrid = function(){return {

	thePopUpGrid					:false,
	thePopUpCM						:false,
	thePopUpGridFieldset			:false,
	
	
	
	/** calls all needed functions **/
	init: function () {
		this.initGridFieldset();
		this.initCM();
		this.initGrid();
		this.thePopUpGridFieldset.add(this.thePopUpGrid);
	},
	
	/** fieldset for the grid **/
	initGridFieldset: function () {
		this.thePopUpGridFieldset = new Ext.form.FieldSet({
			title: '<?php echo __('Set Placeholder',null,'additionaltext'); ?>',
			allowBlank: false,
			style: 'margin-top:10px;margin-left:10px;',
			width: 285,
			height: 290
		});
	},
	
	
	/** init grid with store **/
	initGrid: function () {
		this.thePopUpGrid = new Ext.grid.GridPanel({ 
			frame:false,
			autoScroll: true,
			collapsible:false,
			closable: false,
			width: 250,
			height: 248,
			style: 'margin-top:5px;margin-left:5px;',
			border: true,
			store: new Ext.data.SimpleStore({
				fields:['id', 'text'],
				data:[[1,'{%CIRCULATION_TITLE%}'],[2,'{%SENDER_USERNAME%}'],[3,'{%SENDER_FULLNAME%}'],[4,'{%TIME%}'],[5,'{%DATE_SENDING%}']]
			}),
			cm: this.thePopUpCM
		});
	},
	
	/** init Columnmodel for grid **/
	initCM: function () {
		this.thePopUpCM =  new Ext.grid.ColumnModel([
			{header: "<div ext:qtip=\"<table><tr><td><img src='/images/icons/control_rewind_blue.png' /></td><td><?php echo __('Insert Placeholder',null,'additionaltext'); ?></td></tr></table>\" ext:qwidth=\"200\"><?php echo __('Action',null,'usermanagementpopup'); ?></div>", width: 50, sortable: true, dataIndex: 'id', css : "text-align : left;font-size:12px;align:center;", renderer: cf.additionalTextPopUpGrid.renderButton},
			{header: "<?php echo __('Spaceholder',null,'additionaltext'); ?>", width: 180, sortable: false, dataIndex: 'text', css : "text-align : left;font-size:12px;align:center;"}
		]);
	},
	
	/** render Move Function **/
	renderButton: function (data, cell, record, rowIndex, columnIndex, store, grid) {
		var btnMove = cf.additionalTextPopUpGrid.createMoveButton.defer(1,this, [data,record.data['text']]);
		return '<center><table><tr><td><div id="additionalTextPopUpGrid_moveButton_' + data + '"></div></td></tr></table></center>';
	},
	
	/** 
	* create movebutton 
	* @param int id, id of the clicked element
	* @param string text, value of the placeholder
	*/
	createMoveButton: function (id,text) {
		var btn_move = new Ext.form.Label({
			renderTo: 'additionalTextPopUpGrid_moveButton_' + id,
			html: '<span style="cursor:pointer;"><img src="/images/icons/control_rewind_blue.png" /></span>',
			listeners: {
				render: function(c){
					c.getEl().on({
						click: function(el){
							cf.additionalTextPopUpGrid.movePlaceholder(text);
						},
					scope: c
					});
				}
			}
		});
	},
	
	/** 
	* 
	* move functionality
	*
	* @param String value, value of the placeholder
	*/
	movePlaceholder: function (value) {
		if(cf.additionalTextPopUpWindow.theHTMLFieldset.hidden == false) {
			var contentField = Ext.getCmp('additionalTextPopUpWindow_HTMLarea');
		}
		else {
			var contentField = Ext.getCmp('additionalTextPopUpWindow_textarea');
		}
		
		var content = contentField.getValue();
		content = content + ' ' + value;
		contentField.setValue(content);
		contentField.focus();		
	}
	
};}();