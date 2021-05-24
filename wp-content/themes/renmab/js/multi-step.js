jQuery(function ($){
	$(document).ready(function() {
		panels = $('.multi-steps');
		panelNav = panels.find('.multi-nav');
		if( panels.length ) {
			multiPanel();
			//asideStick(panelNav);
		}
	})
})

function multiPanel() {
	var panels = jQuery('.multi-steps');

	jQuery.each(panels, function(){
		var buttons = jQuery(this).find('.multi-nav button'),
			select = jQuery(this).find('select'),
		    currentSet = jQuery(this).find('.multi-step'),
		    translate = 0;

		jQuery.each(currentSet, function() {
			jQuery(this).css('transform', 'translateZ('+ translate + 'px)');
			translate -= 100;
		})

		var firstPanel = currentSet.first();
		var speed = 400;

		jQuery.when(firstPanel.fadeIn(speed)).promise().done(function() {
			calcHeight(firstPanel);	
		});

		select.on('change', function() {
			var val = this.value,
			    panelName = '.multi-step-'+val,
			    navName = '.multi-nav-'+val;

			    jQuery(navName).parent().addClass('active');
				jQuery(navName).parent().siblings().removeClass('active');

			var panel = currentSet.filter( jQuery(panelName) );
				panel.fadeIn(speed);
				panel.css('transform', 'translateZ(0px)');
				calcHeight(panel);

				var prevSiblings = panel.prevAll('.multi-step'),
					nextSiblings = panel.nextAll('.multi-step');

				prevSiblings.css('transform', 'translateZ(100px)');
				prevSiblings.fadeOut(speed);

				nextSiblings.css('transform', 'translateZ(-100px)');
				nextSiblings.fadeOut(speed);
		})

		jQuery.each(buttons, function() {
			var className = this.className.match(/multi-nav-(\d+)/)[1],
			    panelName = '.multi-step-'+className;
			
			var panel = currentSet.filter( jQuery(panelName) );

			jQuery(this).click(function() {
				jQuery(this).parent().addClass('active');
				jQuery(this).parent().siblings().removeClass('active');
				
				panel.fadeIn(speed);
				panel.css('transform', 'translateZ(0px)');
				calcHeight(panel);

				var prevSiblings = panel.prevAll('.multi-step'),
					nextSiblings = panel.nextAll('.multi-step');

				prevSiblings.css('transform', 'translateZ(100px)');
				prevSiblings.fadeOut(speed);

				nextSiblings.css('transform', 'translateZ(-100px)');
				nextSiblings.fadeOut(speed);
			})
		})
	});
}

function calcHeight(el) {
	var thisPanel = el,
		panelHeight = thisPanel.outerHeight(),
		tabs = thisPanel.find('.data-tab'),
	    tabLabels = thisPanel.find('.data-labels button');

	if ( tabs.length ) {
		tabs.hide().removeClass('active');
		tabLabels.removeClass('active');
		tabs.first().show();
		tabLabels.first().addClass('active');
		tabsHeight = tabs.first().height();
		panelHeight = panelHeight + tabsHeight;

		jQuery.each(tabLabels, function() {
			var labelName = this.className.match(/data-label-(\d+)/)[1],
		    	tabName = '.data-tab-'+labelName,
		    	tab = tabs.filter( jQuery(tabName) );
			jQuery(this).click(function() {
				panelHeight = thisPanel.outerHeight();
				jQuery(this).addClass('active');
				jQuery(this).siblings().removeClass('active');
				tab.fadeIn();
				tab.siblings().fadeOut();
				tabsHeight = tab.height();
				if (tabsHeight > 0) {
					panelHeight = panelHeight + tabsHeight;
					thisPanel.parent().css('height', panelHeight);
				}
			})
		})
	}
	thisPanel.parent().css('height', panelHeight);
}