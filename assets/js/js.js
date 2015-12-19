// When the page is fully loaded:

jQuery(window).load(function() {

	$ = jQuery;

	function stickyFooter(){

		var	footer = $(".footer-wrapper");

		footer.css("position","static");

		if ( $(document.body).height() < $(window).height()) {
			footer.css({
				"position":"absolute",
				"bottom":0,
				"width":"100%"
			});
		} else {
			footer.css("position","static");
		}
	}

	stickyFooter();

	$(window).resize(function() {
		stickyFooter();
	});
});

// When the dom is ready:

jQuery(document).ready(function() {

	$ = jQuery;

	$(".header").headroom({
		offset: 85,
		tolerance : {
			up : 10,
			down : 10
		}
	});

	$(document).on('click', '.menu-2-toggler', function(){
		var icon = $(this).find('i');

		if(icon.text() == 'keyboard_arrow_right')
			icon.text('expand_more');
		else
			icon.text('keyboard_arrow_right');

		$(".menu-2 #blog").toggleClass('collapsed');
		return false;
	});

	$(document).on('click', '.mobile-menu-toggler', function(){
		$('div.menu-mobile-wrapper').toggleClass('opened');
		return false;
	});

	$(document).on('click', 'div.menu-mobile-wrapper', function(e){
		if(e.target != this) return;
		$('div.menu-mobile-wrapper').toggleClass('opened');
		return false;
	});
	
	$('iframe[src*="youtube.com"],iframe[src*="youtu.be"],iframe[src*="vimeo.com"]').each(function() {
         $(this).addClass('embed-responsive-item');
         $(this).wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
    });

});
