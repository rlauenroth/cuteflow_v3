cf.startTab = function(){return {
	
	thePanel			:false,
	
	init: function () {
		this.initPanel();
		
	},
	
	initPanel: function () {
		this.thePanel = new Ext.Panel({
			modal: false,
			closable: false,
			title: '<?php echo __('Welcome to CuteFlow installer',null,'installer'); ?>, <?php echo __('Step',null,'installer'); ?>: 2/4',
			layout: 'form',
			width: 750,
			height: 490,
			autoScroll: true,
			shadow: false,
			minimizable: false,
			autoScroll: false,
			draggable: false,
			resizable: false,
			plain: false,
			html: '<?php echo __('Installertext1',null,'installer'); ?><br /><br /><?php echo __('Installertext2',null,'installer'); ?><br /><br /><?php echo __('Installertext3',null,'installer'); ?><br /><br /><center><img src="/images/icons/cf_schema_large.png" width="400"/></center>'
		});
		
	}
	
	
};}();