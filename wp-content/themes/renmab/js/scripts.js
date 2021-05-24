jQuery(function ($){

	$(document).ready(function() {
		document.addEventListener( 'wpcf7submit', function( event ) {
		  if ( '1048' == event.detail.contactFormId ) {
				location = '/contact-thank-you/';
		  }
		}, false );

		scroller();
		cta = $('.licensing-cta.stick');
		if ( cta.length && $(window).width() >= 800) {
			asideStick(cta);
		}

		$(window).resize(function() {
			if ( cta.length && $(window).width() >= 800) {
				asideStick(cta);
			}
		})

		$('.wpcf7-validates-as-required').parent().prevAll('label').after('<span class="required">*</span>');

		document.addEventListener( 'wpcf7submit', function( event ) {
			$('.wpcf7-not-valid').parent().prevAll('label').addClass('required');
		}, false );

		contact = $('#wpcf7-f1048-p98-o1');
		if( contact.length ) {
			referrer();
		}

		$('.sub-menu-bttn').click(function() {
			var parentLink = $(this).parent(),
				subMenu = parentLink.find('.sub-menu'),
				subMenuHeight = 0;

			subMenu.children().each(function(){
			    subMenuHeight = subMenuHeight + $(this).outerHeight(true);
			});

			if( !parentLink.hasClass('toggled') ) {
				parentLink.addClass('toggled');
				subMenu.css('max-height', subMenuHeight);
			} else {
				parentLink.removeClass('toggled');
				subMenu.removeAttr('style');
			}
		})
	})
})

function referrer() {
	const urlParams = new URLSearchParams(window.location.search);
	var queryString = urlParams.get('ref');

	if(!queryString) {
		queryString = 'general inquiry';
	}

	var checkboxes = jQuery('#wpcf7-f1048-p98-o1 input[type=checkbox]');
	var referred = false;

	checkboxes.each(function(){
		var val = jQuery(this).val();
		val = val.toLowerCase();
		if ( val == queryString ) {
			jQuery(this).prop("checked", true);
			referred = true;
		} 
	}) 
}

function scroller() {
	jQuery('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
		if ( location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = jQuery(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				event.preventDefault();
				$('html, body').animate({
					scrollTop: target.offset().top
				}, 1000, function() {

					var $target = $(target);
					$target.focus();
					if ($target.is(":focus")) { 
						return false;
					} else {
						$target.attr('tabindex','-1');
						$target.focus();
					};
				});
			}
		}
	});
}

function asideStick(obj) { 
	var timer;
	function stick() {
		obj.each(function() {
			var thisObj = jQuery(this);
			var top = thisObj.parent().offset().top,
			bottom = top + thisObj.parent().innerHeight(),
		    scroll = jQuery(window).scrollTop(),
		    asideBottom = thisObj.innerHeight() + scroll;
			pos = scroll - top;
			if ( ( scroll >  top - 100 ) && ( asideBottom < bottom ) ) {
				thisObj.css('top', pos + 100);
				thisObj.css('bottom', 'unset');
			} else if ( asideBottom >= bottom ){
				stop = thisObj.css('top');
				thisObj.css('top', stop);
				thisObj.css('bottom', '0');
			} else {
				thisObj.css('bottom', 'unset');
				thisObj.css('top', '50px');
			}
		})
	}
	stick();
	jQuery(window).scroll(function() {
		if ( timer ) clearTimeout(timer);
	    timer = setTimeout(function(){
			stick();
	    }, 30);
	})
	jQuery(window).resize(function() {
		if ( timer ) clearTimeout(timer);
	    timer = setTimeout(function(){
			stick();
	    }, 30);
	})
}

function toggleSection(id) {
	var toggler = '#' + id;
	icon = jQuery(toggler).find('span');
	var toggled = '#' + id.replace('toggle','content');
	toggled = jQuery(toggled);
	var speed = 550;

	if( toggled.is(":visible") ) {
		icon.removeClass("icon-minus").addClass("icon-plus");
		toggled.slideUp(speed).animate({ opacity: 0 }, { queue: false, duration: (speed - 150) } );
	} else {
		icon.removeClass("icon-plus").addClass("icon-minus");
		toggled.slideDown(speed).animate({ opacity: 1 }, { queue: false, duration: (speed - 150) } );

		//Remove 'Load More' button when clicked
		if(jQuery(toggler).hasClass('toggle-drugs')){
			jQuery(toggler).toggle();
		}
	}
}

function toggleKOView(reset=false){
	let toggle = '#mobile-view-toggle';
	if(reset){
		jQuery('.ko-drugs .ko-table-header').find('> p').removeAttr('style');
		jQuery('.ko-drugs .ko-table-content').find('> h4, > p, .toggle-trials').removeAttr('style');
		jQuery(toggle).removeClass('toggled');
	}else{
		jQuery('.ko-drugs .ko-table-header').find('> p').toggle();
		jQuery('.ko-drugs .ko-table-content').find('> h4, > p, .toggle-trials').toggle();
		jQuery(toggle).toggleClass('toggled');
	}
}

jQuery(window).on('resize', function(){
	if(jQuery(this).width() > 800){
		toggleKOView(true);
	}
})
