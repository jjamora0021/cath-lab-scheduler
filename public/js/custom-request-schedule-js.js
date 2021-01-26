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
				$('#schedule-info-modal #patient_name').text('');
				$('#schedule-info-modal #patient_name').append(ptx_name);

				var age = data.age;
				$('#schedule-info-modal #age').text('');
				$('#schedule-info-modal #age').append(age);

				var pt_ptt = data.pt_ptt;
				$('#schedule-info-modal #pt_ptt').text('');
				$('#schedule-info-modal #pt_ptt').append(pt_ptt);

				var weight = data.weight;
				$('#schedule-info-modal #weight').text('');
				$('#schedule-info-modal #weight').append(weight);

				var height = data.height;
				$('#schedule-info-modal #height').text('');
				$('#schedule-info-modal #height').append(height);

				$('#schedule-info-modal #allergies-list').text('');
				$.each(JSON.parse(data.allergies), function(index, el) {
					var list = '<li class="list-group-item">'+el+'</li>';
					$('#schedule-info-modal #allergies-list').append(list);
				});

				var room_number = data.room_number;
				$('#schedule-info-modal #room_number').text('');
				$('#schedule-info-modal #room_number').append(room_number);

				var bed_number = data.bed_number;
				$('#schedule-info-modal #bed_number').text('');
				$('#schedule-info-modal #bed_number').append(bed_number);
				
				var diagnosis = data.diagnosis;
				$('#schedule-info-modal #diagnosis').text('');
				$('#schedule-info-modal #diagnosis').append(diagnosis);
				
				var operation = data.operation;
				$('#schedule-info-modal #operation').text('');
				$('#schedule-info-modal #operation').append(operation);

				var surgeon = data.surgeon;
				$('#schedule-info-modal #surgeon').text('');
				$('#schedule-info-modal #surgeon').append(surgeon);

				var anesthesiologist = data.anesthesiologist;
				$('#schedule-info-modal #anesthesiologist').text('');
				$('#schedule-info-modal #anesthesiologist').append(anesthesiologist);

				var urgency = data.urgency;
				$('#schedule-info-modal #urgency').text('');
				$('#schedule-info-modal #urgency').append(urgency);

				var status = data.status;
				$('#schedule-info-modal #status').text('');
				$('#schedule-info-modal #status').append(status);
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
	updateSchedule: function(patien_info_id, status, approval)
	{
		$.ajax({
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
			url: window.location.origin + '/update-schedule',
			type: 'PUT',
			data: {
				id: patien_info_id,
				approval: approval
			},
			success: function(response) {
				var options = {
					decline : 'danger',
					pending : 'warning',
					approved : 'success'
				};
				if(response == 1)
				{
					$('#schedule-info-modal #status').text('');
					$('#schedule-info-modal #status').removeClass('text-' + options[status]).addClass('text-' + options[approval]).append(approval);

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
