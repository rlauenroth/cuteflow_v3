cf.createFilterUrl = function(){return {
	
	
	
	buildUrl: function (name, sender, daysfrom, daysto, sendetfrom, sendetto, activestation, mailinglist, documenttemplate, grid, id) {
		var url = '';
		
		if(name.getValue() != '') {
			url += '/name/' + name.getValue();
		}
		
		if (sender.getValue() != '') {
			url += '/sender/' + sender.getValue();
		}
		if (daysfrom.getValue() != '' || daysto.getValue() != '') {
			var daysfromValue = '';
			var daystoValue = '';
			if(daysfrom.getValue() == '') {
				daysfromValue = 0;
			}
			else {
				daysfromValue = daysfrom.getValue();
			}


			if(daysto.getValue() == '') {
				daystoValue = -1;
			}
			else {
				daystoValue = daysto.getValue();
			}
			url += '/daysfrom/' + daysfromValue + '/daysto/' + daystoValue;
		}
		
		var regEx = '^^[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}$';
		
		var regObject = new RegExp(regEx,"m");
		if(regObject.test(sendetfrom.getRawValue()) == true || regObject.test(sendetto.getRawValue()) == true) {
			var sendetfromValue = '';
			var sendettoValue = '';
			if(regObject.test(sendetfrom.getRawValue()) == false ) {
				sendetfromValue = '1970-01-01';
			}
			else {
				sendetfromValue = sendetfrom.getRawValue();
			}
			
			if(regObject.test(sendetto.getRawValue()) == false ) {
				sendettoValue = '2100-01-01';
			}
			else {
				sendettoValue = sendetto.getRawValue();
			}
			url += '/sendetfrom/' + sendetfromValue + '/sendetto/' + sendettoValue;
		}
		
		if(activestation.getValue() != '') {
			url += '/activestation/' + activestation.getValue();
		}
		
		if(mailinglist.getValue() != '') {
			url += '/mailinglist/' + mailinglist.getValue();
		}
		
		if(documenttemplate.getValue() != '') {
			url += '/documenttemplate/' + mailinglist.getValue();
		}
		for(var a=0;a<grid.store.getCount();a++) {
			var row = grid.getStore().getAt(a);
			var counterId = row.data.unique_id;
			var field = Ext.getCmp(id + 'FilterField_' + counterId).getValue();
			var operator = Ext.getCmp(id + 'FilterOperator_' + counterId).getValue();
			var value = Ext.getCmp(id + 'FilterValue_' + counterId).getValue();
			var filterCounter = 0;
			if(field != '' && operator != '' && value != '') {
				url += '/field'+filterCounter+'/' + field + '/operator'+filterCounter+'/' + operator + '/value'+filterCounter+'/' + value;
				filterCounter++;
			}
		}
		return url;
	}
	
	
};}();