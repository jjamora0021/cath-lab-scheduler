/**
 * [dateTimePickerFunctions description]
 * @type {Object}
 */
dateTimePickerFunctions = {
	onLoad: function() 
	{
		$('#date').datetimepicker({
			format: 'MM/DD/YYYY',
			defaultDate:false,
		});
		$('#time').datetimepicker({
			format: 'LT'
		});
	}
}