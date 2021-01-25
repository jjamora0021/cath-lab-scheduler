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
			headerToolbar: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
			},
			initialDate: dateToday,
			navLinks: true, // can click day/week names to navigate views
			businessHours: true, // display business hours
			editable: true,
			selectable: true,
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
		var events = [
			{
				title: 'Business Lunch',
				start: '2021-01-03T13:00:00',
				constraint: 'businessHours'
			},
			{
				title: 'Meeting',
				start: '2021-01-13T11:00:00',
				constraint: 'availableForMeeting', // defined below
				color: '#257e4a'
			},
			{
				title: 'Conference',
				start: '2021-01-18',
				end: '2021-01-20'
			},
			{
				title: 'Party',
				start: '2021-01-29T20:00:00'
			},

			// areas where "Meeting" must be dropped
			{
				groupId: 'availableForMeeting',
				start: '2021-01-11T10:00:00',
				end: '2021-01-11T16:00:00',
				display: 'background'
			},
			{
				groupId: 'availableForMeeting',
				start: '2021-01-13T10:00:00',
				end: '2021-01-13T16:00:00',
				display: 'background'
			},

			// red areas where no events can be dropped
			{
				start: '2021-01-24',
				end: '2021-01-28',
				overlap: false,
				display: 'background',
				color: '#ff9f89'
			},
			{
				start: '2021-01-06',
				end: '2021-01-08',
				overlap: false,
				display: 'background',
				color: '#ff9f89'
			}
		];

		return events;
	}
}