var floaterDeBouncer = function($,cf,of, interval){
	var debounce = function (func, threshold, execAsap) {
		var timeout;
		return function debounced () {
			var obj = this, args = arguments;
			function delayed () {
				if (!execAsap)
					func.apply(obj, args);
				timeout = null;
			}
			if (timeout)
				clearTimeout(timeout);
			else if (execAsap)
				func.apply(obj, args);
			timeout = setTimeout(delayed, threshold || interval);
		};
	};
	jQuery.fn[cf] = function(fn){  return fn ? this.bind(of, debounce(fn)) : this.trigger(cf); };
};

floaterDeBouncer(jQuery,'smartscroll', 'scroll', 100);

jQuery(document).ready(function($) {

	var floatercookie = jQuery.cookie("floater");

	jQuery('.floater-close').click(function(e) {
		e.preventDefault();
		jQuery("#floater-sidebar").removeClass('visible');
		jQuery.cookie("floater", "1", { expires: 7, path: '/' });
	});
});

jQuery(window).smartscroll(function () {

	var floatercookie = jQuery.cookie("floater");

	if (floatercookie != 1) {
		if ( jQuery(window).width() > 640 ) {
			if ( jQuery(document).scrollTop() > 200) {
				jQuery('#floater-sidebar').addClass('visible');
			} else {
				jQuery('#floater-sidebar').removeClass('visible');
			}
		}
	}
});