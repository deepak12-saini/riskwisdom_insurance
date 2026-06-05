(function () {
	'use strict';

	var section = document.getElementById('riskwisdom-brochure');
	if (!section) {
		return;
	}

	var viewer = section.querySelector('[data-rw-brochure-viewer]');
	var toggleBtn = section.querySelector('[data-rw-brochure-toggle]');
	var toggleLabel = section.querySelector('[data-rw-brochure-toggle-label]');
	var frame = section.querySelector('[data-rw-brochure-frame]');
	var frameWrap = section.querySelector('[data-rw-brochure-frame-wrap]');
	var zoomLevelEl = section.querySelector('[data-rw-brochure-zoom-level]');
	var zoom = 100;
	var isOpen = true;

	if (viewer) {
		viewer.classList.remove('is-collapsed');
	}

	function setZoom(value) {
		zoom = Math.min(150, Math.max(75, value));
		if (frame) {
			frame.style.transform = 'scale(' + (zoom / 100) + ')';
		}
		if (zoomLevelEl) {
			zoomLevelEl.textContent = zoom + '%';
		}
	}

	function openViewer() {
		if (!viewer) {
			return;
		}
		isOpen = true;
		viewer.classList.remove('is-collapsed');
		if (toggleLabel) {
			toggleLabel.textContent = 'Hide brochure';
		}
		viewer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
	}

	function closeViewer() {
		if (!viewer) {
			return;
		}
		isOpen = false;
		viewer.classList.add('is-collapsed');
		if (toggleLabel) {
			toggleLabel.textContent = 'View brochure';
		}
		if (frameWrap) {
			frameWrap.classList.remove('is-fullscreen');
		}
	}

	if (toggleBtn) {
		toggleBtn.addEventListener('click', function () {
			if (isOpen) {
				closeViewer();
			} else {
				openViewer();
			}
		});
	}

	section.querySelectorAll('[data-rw-brochure-zoom]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var dir = btn.getAttribute('data-rw-brochure-zoom');
			setZoom(dir === 'in' ? zoom + 10 : zoom - 10);
		});
	});

	var fullscreenBtn = section.querySelector('[data-rw-brochure-fullscreen]');
	if (fullscreenBtn && frameWrap) {
		fullscreenBtn.addEventListener('click', function () {
			if (!document.fullscreenElement) {
				if (frameWrap.requestFullscreen) {
					frameWrap.requestFullscreen();
				} else if (frameWrap.webkitRequestFullscreen) {
					frameWrap.webkitRequestFullscreen();
				}
				frameWrap.classList.add('is-fullscreen');
			} else if (document.exitFullscreen) {
				document.exitFullscreen();
				frameWrap.classList.remove('is-fullscreen');
			}
		});

		document.addEventListener('fullscreenchange', function () {
			if (!document.fullscreenElement && frameWrap) {
				frameWrap.classList.remove('is-fullscreen');
			}
		});
	}
})();
