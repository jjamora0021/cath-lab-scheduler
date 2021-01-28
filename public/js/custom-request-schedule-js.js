/**
 * [requestScheduleFunctions description]
 * @type {Object}
 */
requestScheduleFunctions = {
	/**
	 * [addAllergies description]
	 * @return {[type]} [description]
	 */
	addAllergies: function() 
	{
		var allery_count = $('#allergy-count').val();
		var allergy = $('#allergies').val();
		allery_count++;
		$('#allergy-count').val(allery_count);
		requestScheduleFunctions.repopulateList(allergy,allery_count);
		$('#allergies').val('');
	},

	/**
	 * [repopulateList description]
	 * @return {[type]} [description]
	 */
	repopulateList: function(allergy, allergy_count) 
	{
		var del = "requestScheduleFunctions.deleteAllergy("+allergy_count+")";
		var delete_btn = '<a href="javascript:void(0)" class="col-lg-2 text-right text-danger" onclick="'+del+'">Remove</a>';

		var row = 	'<li class="list-group-item" id="li-allergy-'+allergy_count+'">\
                        <div class="row">\
                            <div class="col-lg-10 text-left align-middle"><span id="allergy-'+allergy_count+'">'+allergy+'</span></div>\
                            <input type="hidden" id="patient-allergy['+allergy_count+']" name="patient-allergy['+allergy_count+']" value="'+allergy+'">\
                            '+delete_btn+'\
                        </div>\
                    </li>';

        $('ul#allergies').append(row);
	},

	/**
	 * [deleteAllergy description]
	 * @param  {[type]} allergy_count [description]
	 * @return {[type]}               [description]
	 */
	deleteAllergy: function(allergy_count)
	{
		$('ul#allergies #li-allergy-'+allergy_count).remove();
	},

	/**
	 * [checkSchedule description]
	 * @param  {[type]} date [description]
	 * @param  {[type]} time [description]
	 * @return {[type]}      [description]
	 */
	checkSchedule: function(date, time)
	{
		$.ajax({
			url: window.location.origin + '/check-schedule',
			type: 'GET',
			data: {
				date: date,
				time: time
			},
			success: function(response) {
				if(response != 0)
				{
					$('#schedule-validator-modal').modal();
					$('#save-schedule').attr('disabled',true);
				}
				else
				{
					$('#save-schedule').attr('disabled',false);
				}
			}
		});
	},

	/**
	 * [fetchSchedule description]
	 * @param  {[type]} patien_info_id [description]
	 * @return {[type]}                [description]
	 */
	fetchSchedule: function(patien_info_id)
	{
		$.ajax({
			url: window.location.origin + '/fetch-schedule-info',
			type: 'GET',
			data: {
				id: patien_info_id
			},
			success: function(response) {
				var data = response[0];

				var ptx_name = data.first_name + ' ' + data.middle_name + ' ' + data.last_name;
				$('#schedule-info-modal #patient_name').empty().append(ptx_name);

				var age = data.age;
				$('#schedule-info-modal #age').empty().append(age);

				var pt_ptt = data.pt_ptt;
				$('#schedule-info-modal #pt_ptt').empty().append(pt_ptt);

				var weight = data.weight;
				$('#schedule-info-modal #weight').empty().append(weight);

				var height = data.height;
				$('#schedule-info-modal #height').empty().append(height);

				$('#schedule-info-modal #allergies-list').empty();
				$.each(JSON.parse(data.allergies), function(index, el) {
					var list = '<li class="list-group-item">'+el+'</li>';
					$('#schedule-info-modal #allergies-list').append(list);
				});

				var room_number = data.room_number;
				$('#schedule-info-modal #room_number').empty().append(room_number);

				var bed_number = data.bed_number;
				$('#schedule-info-modal #bed_number').empty().append(bed_number);
				
				var diagnosis = data.diagnosis;
				$('#schedule-info-modal #diagnosis').empty().append(diagnosis);
				
				var operation = data.operation;
				$('#schedule-info-modal #operation').empty().append(operation);

				var surgeon = data.surgeon;
				$('#schedule-info-modal #surgeon').empty().append(surgeon);

				var anesthesiologist = data.anesthesiologist;
				$('#schedule-info-modal #anesthesiologist').empty().append(anesthesiologist);

				var urgency = data.urgency;
				$('#schedule-info-modal #urgency').empty().append(urgency);

				var status = data.status;
				$('#schedule-info-modal #status').empty().append(status);

				var date = data.date.split('-');
				var dateToday = new Date();
				var rangemaxdate = new Date(dateToday.getFullYear(), dateToday.getMonth(),dateToday.getDate() + 31);
				$('#schedule-info-modal #date').empty().val(date[1]+"/"+date[2]+"/"+date[0]).datetimepicker({ 
					minDate: dateToday,
					maxDate: rangemaxdate
				});

				var time = data.time;
				$('#schedule-info-modal #time').empty().val(time).datetimepicker({
					format: 'LT'
				});

				$('#btn-approve').attr('onclick',  'requestScheduleFunctions.updateSchedule('+ data.id +', "approved")');
				$('#btn-decline').attr('onclick',  'requestScheduleFunctions.updateSchedule('+ data.id +', "decline")')
			}
		})
		.done(function() {
			$('#schedule-info-modal').modal();
		});
	},

	/**
	 * [updateSchedule description]
	 * @param  {[type]} patien_info_id [description]
	 * @param  {[type]} approval       [description]
	 * @return {[type]}                [description]
	 */
	updateSchedule: function(patien_info_id, approval)
	{
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
			url: window.location.origin + '/update-schedule',
			type: 'PUT',
			data: {
				id: patien_info_id,
				approval: approval,
				date: $('#schedule-info-modal #date').val(),
				time: $('#schedule-info-modal #time').val(),
			},
			success: function(response) {
				if(response == 1)
				{
					$('#schedule-info-modal #status').text('').append(approval);

					$('#alert-success').toggleClass('d-none');
					$('#alert-success span#changed-status').empty().append(approval);

					$('#close-btn').attr('onclick',location.reload());
				}
				else
				{
					$('#alert-danger').toggleClass('d-none');
				}
			}
		});
	},
}
