(function ($) {
	'use strict';

	$(function () {
		// Faster preloader — theme default is 800ms fade after window load.
		if ($('.preloader').length) {
			setTimeout(function () {
				$('.preloader').fadeOut(350);
			}, 250);
		}

		// FAQ search filters accordion sections by heading text.
		var $faqSearch = $('#rw-faq-search');
		if ($faqSearch.length) {
			var $sections = $('.kc_accordion_section');
			if (!$sections.length) {
				$sections = $('#wrapperpages .toggle, #wrapperpages .accordion-group > div');
			}

			$faqSearch.on('input', function () {
				var q = $(this).val().toLowerCase().trim();
				$sections.each(function () {
					var text = $(this).text().toLowerCase();
					var show = q === '' || text.indexOf(q) !== -1;
					$(this).toggle(show);
				});
			});
		}

		// Move FAQ search above first accordion on FAQ page.
		var $faqWrap = $('.rw-faq-search-wrap');
		if ($faqWrap.length) {
			var $accordion = $('#wrapperpages .kc_accordion_wrapper').first();
			if ($accordion.length) {
				$faqWrap.insertBefore($accordion);
			} else {
				$faqWrap.prependTo('#wrapperpages .container').first();
			}
		}
	});
})(jQuery);
