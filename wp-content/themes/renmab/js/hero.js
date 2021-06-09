jQuery(function ($){
	$(document).ready(function() {
		vid = $('.home-hero');
		if( vid.length ) {
			drift();
		}
	})
});

function drift() {
	var sphere = jQuery('.home-hero .antibody');
	spheres();

	function spheres() {
		sphere.each(function() {
			var $this = jQuery(this),
			    pos = $this.position(),
				parentHeight = $this.parent().innerHeight(),
				parentWidth = $this.parent().innerWidth(),
			    posLeft = pos.left / parentWidth * 100,
			    posTop = pos.top / parentHeight * 100;
		    animation($this, posTop, posLeft);
		});
	}

	function animation(el, posTop, posLeft) {

		var delay = 1000 + ( Math.random() * 1000 ),
		    top = posTop + el.innerHeight()/180 * ( Math.random() - 1.2),
    	    left = posLeft + el.innerWidth()/180 * ( Math.random() - 1.2);

		el.animate({
       		'top': top + '%',
        	'left': left + '%'
    	}, delay, 'linear', function(){
    		animation(el, posTop, posLeft);
    	});
    }
   	
   	var resizeTimer;
	jQuery(window).on('resize', function(e){
		sphere.stop();
		clearTimeout(resizeTimer);
		 resizeTimer = setTimeout(function() {
		  	sphere.removeAttr('style');
		  	spheres();			    
		}, 250);
	})
}