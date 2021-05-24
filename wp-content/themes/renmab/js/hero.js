jQuery(function ($){
	$(document).ready(function() {
		vid = $('.hero.has-vid');
		if( vid.length ) {
			drift();
		}
	})
});

function drift() {
	var sphere = jQuery('.hero .sphere');
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
		    top = posTop + 3 * ( Math.random() * 2 - 1),
    	    left = posLeft + 1.5 * ( Math.random() * 2 - 1);

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