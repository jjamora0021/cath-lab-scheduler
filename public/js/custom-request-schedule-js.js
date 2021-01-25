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
	}
}