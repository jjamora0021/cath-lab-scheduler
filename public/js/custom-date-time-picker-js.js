/**
 * [dateTimePickerFunctions description]
 * @type {Object}
 */
dateTimePickerFunctions = {
	onLoad: function() 
	{
		var dateToday = new Date();
		var holidays = [];
		$.ajax({
			url: window.location.origin + '/fetch-holidays',
			type: 'GET',
			async:false,
			success: function(response) {
				$.each(response, function(index, el) {
					holidays.push(el.date);
				});
			}
		});
		
		var rangemaxdate = new Date(dateToday.getFullYear(), dateToday.getMonth(),dateToday.getDate() + 31); 
		$('#date').datetimepicker({
			format: 'MM/DD/YYYY',
			defaultDate:false,
			minDate: dateToday,
			maxDate: rangemaxdate,
			disabledDates: holidays,
			daysOfWeekDisabled: [0,6]
		});
		$('#time').datetimepicker({
			format: 'LT'
		});
	},
}