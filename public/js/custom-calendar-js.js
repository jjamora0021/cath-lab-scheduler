/**
 * [schedulesFunctions description]
 * @type {Object}
 */
schedulesFunctions = {
	/**
	 * [onLoad description]
	 * @return {[type]} [description]
	 */
	onLoad: function() 
	{
		var calendarEl = document.getElementById('calendar');
		var dateToday = new Date().toISOString().slice(0,10);
		var calendar = new FullCalendar.Calendar(calendarEl, {
			initialView: 'dayGridMonth',
			headerToolbar: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
			},
			initialDate: dateToday,
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			selectable: true,
			dayMaxEvents: true,
			events: schedulesFunctions.loadEvents()
		});
		calendar.render();
	},

	/**
	 * [loadEvents description]
	 * @return {[type]} [description]
	 */
	loadEvents: function()
	{
		var events = [];
		$.ajax({
			url: window.location.origin + '/fetch-schedule',
			type: 'GET',
			async:false,
			success: function(response) {
				$.each(JSON.parse(response), function(index, el) {
					events.push(el)
				});
			}
		});

		return events;
	}
}