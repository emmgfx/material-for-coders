// When the page is fully loaded:

$(window).load(function() {
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

$(document).ready(function() {

	$(".header").headroom({
		offset: 85,
		tolerance : {
			up : 10,
			down : 10
		}
	});

	$(document).on('click', '.menu-2-toggler', function(){
		$(this).find('i').toggleClass('fa-caret-down fa-caret-up');
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

});
