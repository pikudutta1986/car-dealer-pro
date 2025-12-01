// FUNCTION TO FETCH MODELS ACCORDING TO MAKE CHANGES.
function ChangeMake(make_slug, model_div_id) {
	console.log(make_slug);
	console.log(model_div_id);
    $("#"+model_div_id).html('<option value="">Please wait</option>');
	if(make_slug == '')
	{
		 $("#"+model_div_id).html('<option value="">Any</option>');
	}
    $.ajax({
        url: SITE_URL+"/ajax/model_by_make.php",
        data: {
            make_slug: make_slug
        },
        success: function(response) {
            var options = '<option value="">Any</option>';
			$("#"+model_div_id).niceSelect('destroy');
            if (response) {
                for (var i = 0; i < response.length; i++) 
                {
                    if (response[i]['model'] && response[i]['model'] != '') 
                    {
                        options += '<option value="' + response[i]['model_slug'] + '">' + response[i]['model'] + '</option>';
                    }
                }
				console.log(options);
               
            }
			$("#"+model_div_id).html(options);
			$("#"+model_div_id).niceSelect();
        }
    });
}