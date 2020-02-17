(function ($) {
	function init() {
		if (!window.ga) {
			setTimeout(init, 100);
		} else {
			setupEvents();
		}
	}

	function setupEvents() {
		$(document).on('asvzNavigate', function (e, data) {
			ga('send', 'screenview', {
				appName: data.appName,
				screenName: data.screenName
			});

			ga('send', {
				hitType: 'pageview',
				title: data.title,
				page: data.page,
			});
		});

		$(document).on('asvzPopup', function (e, data) {
			ga('send', {
				hitType: 'event',
				eventCategory: data.eventCategory,
				eventAction: data.eventAction,
				eventLabel: data.eventLabel
			});
		});
	}

	init();
})(jQuery);