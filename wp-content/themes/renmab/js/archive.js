var form = jQuery('#filter'), 
	filters = form.find('input[type="checkbox"]'),
	input = form.find('input[type="text"]'),
	submit = form.find('button'),
    btn = jQuery('#load'),
    btnMod = jQuery('#past'),
    offset = 10,
    queryCount,
    search ='',
    mod = "future",
    close,
    checked = new Array();

function btnCheck() {
	if( offset >= queryCount || queryCount == undefined ) {
		btn.css('display', 'inline-block');
		btn.prop('disabled', true).html("No More " + typeName);
	} else {
		btn.css('display', 'inline-block');
		btn.prop('disabled', false).html("Load More " + typeName);
	}
}

function toTop() {
	var top = jQuery('.page-content').offset().top;
	jQuery(window).scrollTop(top - 60);
}

jQuery(function ($){
	var type = btn.attr('data-type');
	if (type == 'post') {
		typeName = 'Articles';
	} else {
		typeName = type;
	}

	queryCount = btn.data('total');
	btnCheck();

	jQuery.each(filters, function(){
		jQuery(this).on("change", function() {
			loadPosts();
			toTop();
		});
	});

	btn.click(function() {
		offset += 10;
		loadPosts();
	});

	btnMod.toggle(function() {
		queryCount = jQuery(this).data('total');
		offset = 10;
		btnCheck();
		mod = 'past';
		jQuery(this).html('Upcoming Events<span class="icon-rarr"></span>').addClass('button-future');
		jQuery('.page-header h1').html('Past Events');
		loadPosts();
		jQuery(window).scrollTop(top);
	}, function() {
		queryCount = btn.data('total');
		offset = 10;
		btnCheck();
		mod = 'future';
		jQuery(this).html('Past Events<span class="icon-rarr"></span>').removeClass('button-future');
		jQuery('.page-header h1').html('Upcoming Events');
		loadPosts();
		jQuery(window).scrollTop(top);
	});

	submit.click(function() {
		loadPosts();
	});

	input.on('keydown', function (e) {
	    if (e.keyCode === 13) {
	    	e.preventDefault();
	    	loadPosts();
	    	toTop();
	    }
	});

	function loadPosts() {		

		search = encodeURIComponent(jQuery(input).val());

		if(filters.length) {
			checked = [];
			jQuery.each(filters, function() {
				if ( jQuery(this).is(':checked') ) {
	       			checked.push(jQuery(this).attr('id'));
				}
			});
		}
		var filterStr = '&posts='+offset+'&categories='+checked+'&type='+type+'&search='+search+'&mod='+mod+'&action=renmab_ajax_get_filter_posts';

		jQuery.ajax({
			type : "POST",
			dataType: "html",
			url: renmab_posts_filter.ajax_url,
			data: filterStr,
			context: jQuery('.page-header'),
			success:function(data) {
            	var $data = $(data);
            	jQuery('.page-content').html($data);
            	
            	if(filters.length) {
            		queryCount = jQuery('.filtered-posts').data('filtered');
            	}

		        btnCheck();
		        if (search.length) {
		        	close = jQuery('.searchresults #searchclear');
		       		close.click(function () {
		       			search = '';
		       			input.val('');
		       			loadPosts();
		       		});	
		        }
			}
		});

		return false;
	}
} );

jQuery(function ($){ 
	if (form.length > 0) {
		var top = form.offset().top,
		    toggler = jQuery('#filter-toggle'),
		    toggled = jQuery('#filter-content'),
		    icon = jQuery(toggler).find('span');

		function filterStick() {
			var scroll = jQuery(window).scrollTop();

			if (scroll > top) {
				form.addClass('sticky'); 
			} else {
				form.removeClass('sticky'); 
				top = form.offset().top;
			}
		}

		function untoggler() {
			if ( jQuery(window).width() > 800 ) {
				jQuery('#filter-content').removeAttr('style');
				icon.removeClass("icon-minus").addClass("icon-plus");
			}
		}

		filterStick();

		jQuery(window).scroll(function() {
			filterStick();
		})

		jQuery(window).resize(function() {
			untoggler();
			filterStick();
		})
	}
})