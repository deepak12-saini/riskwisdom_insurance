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

		// Sync body class when mobile menu opens — hides header widgets & page sidebar.
		function syncMobileNavState() {
			var open = $('.bodybackground').hasClass('bodybackground-activated');
			$('body').toggleClass('rw-nav-open', open).css('overflow', open ? 'hidden' : '');
		}

		function closeMobileNav() {
			if (!$('.bodybackground').hasClass('bodybackground-activated')) {
				return;
			}

			$('.side-collapse').addClass('in');
			$('.side-collapse-container').removeClass('out');
			$('.navbar').removeClass('navbarclick');
			$('.bodybackground').removeClass('bodybackground-activated');
			$('[data-toggle=collapse-side]').removeClass('open2');
			$('body').removeClass('rw-nav-open').css('overflow', '');
		}

		function isMobileNavLink($link) {
			var href = ($link.attr('href') || '').trim();
			return href && href !== '#' && href !== '#0';
		}

		$(document).on('click', '[data-toggle=collapse-side]', function () {
			setTimeout(syncMobileNavState, 0);
			setTimeout(syncMobileNavState, 50);
		});

		$(document).on('click', '.bodybackground.bodybackground-activated', function () {
			closeMobileNav();
		});

		// Mobile Services/parent submenu toggle in the slide-out panel.
		$(document).on('click', '.side-collapse li.menu-item-has-children > a', function (e) {
			if (window.innerWidth >= 992) {
				return;
			}

			e.preventDefault();
			e.stopPropagation();

			var $li = $(this).parent('li.menu-item-has-children');
			var isOpen = $li.hasClass('open');

			$li.siblings('.menu-item-has-children').removeClass('open');
			$li.toggleClass('open', !isOpen);
		});

		// Close menu when any real nav link is tapped (top-level or submenu).
		$(document).on('click', '.side-collapse a', function () {
			if (window.innerWidth >= 992) {
				return;
			}

			if (!isMobileNavLink($(this))) {
				return;
			}

			// Let parent "#" items expand submenu only.
			if ($(this).closest('li.menu-item-has-children').length && $(this).parent('li.menu-item-has-children').length) {
				return;
			}

			closeMobileNav();
		});

		syncMobileNavState();
	});
})(jQuery);
