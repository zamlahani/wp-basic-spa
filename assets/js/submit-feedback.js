var asvzFeedback = (function ($) {
	function submit(opts) {
		if (!opts.data.nonce) {
			opts.data.nonce = asvzObj.nonces.submit_feedback;
		}

		if (!opts.data.action) {
			opts.data.action = 'submit_feedback';
		}

		$.ajax({
			url: asvzObj.ajaxUrl,
			dataType: 'json',
			type: 'post',
			data: opts.data
		}).done(function (r) {
			if (opts.done) {
				opts.done();
			}

			if (!r) {
				//console.log('Invalid request');

				if (opts.invalid) {
					opts.invalid(r.data);
				}

				return;
			}

			if (!r.success) {
				if (opts.error) {
					opts.error(r.data);
				}

				return;
			}

			if (opts.success) {
				opts.success(r.data);
			}
		}).fail(function () {
			//console.log('Request failed');

			if (opts.failed) {
				opts.failed();
			}
		}).always(function () {
			if (opts.always) {
				opts.always();
			}
		});
	}

	return {
		submit: submit
	};
})(jQuery);