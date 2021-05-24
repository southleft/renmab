/*KO Library Lander scripts */

jQuery(function ($){

	var form  = jQuery('.pi-filters'),
		input = form.find('input[type="text"]'),
		link  = form.find('.button'),
		path  = link.attr('href');

	input.on('keydown', function(e) {
	    if (e.keyCode === 13) {
	    	e.preventDefault();
			location.href = path + input.val();
	    }
	});

	link.on('click', function(e) {
		 e.originalEvent.currentTarget.href = path + input.val();
	})
});