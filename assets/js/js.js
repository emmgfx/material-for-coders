$(function(){
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

	$(document).on('click', '.mobile-menu-toggler', function(){
		$('div.menu-mobile-wrapper').toggleClass('opened');
	});

	$(document).on('click', 'div.menu-mobile-wrapper', function(e){
		if(e.target != this) return;
		$('div.menu-mobile-wrapper').toggleClass('opened');
		return false;
	});

});
