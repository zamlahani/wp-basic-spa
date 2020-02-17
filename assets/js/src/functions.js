(function ($) {
	// your javascript functions

	$('#root').on('click', '#open-menu-btn', function () {
		$('.menu').show('slide');
		$('.menu').promise().done(() => {
			$('.menu').css('background-color', 'rgba(0,0,0,.5)');
		});
	});

	$('#root').on('click', '#close-menu-btn', function () {
		$('.menu').hide('slide');
		$('.menu').css('background-color', 'transparent');
		$('.menu').promise().done(() => {
			$('.menu').css('background-color', 'transparent');
		});
	});

	$('#root').on('click', '.btn-product', function (e) {
		$('.btn-product').prop('disabled', true);
		var productId = $(this).data('product-id')

		openProduct(productId);
	});

	$('#root').on('click', '.btn-checklist', (e) => {
		$('.btn-checklist').prop('disabled', true);
		var id = $('.btn-checklist').data('task-id');
		openMaterials(id);
	});

	$('#root').on('click', '#materials-lightbox .check', function (e) {
		var $dialog = $(this).parents('.dialog');
		var itemId = parseInt($(this).data('item-id'));
		var taskId = $dialog.attr('data-task-id');
		var itemCount = $dialog.find('.list .item').length;
		if ($(this).find('i').hasClass('fa-check-circle')) {
			$(this).html('<i class="fal fa-circle"></i>');
			localStorage.removeItem('item' + itemId + 'task' + taskId)
		} else {
			$(this).html('<i class="fas fa-check-circle"></i>');
			localStorage.setItem('item' + itemId + 'task' + taskId, Date.now() + 1800000)
		}

		var checkedCount = $dialog.find('.list i.fa-check-circle').length;
		if (checkedCount == itemCount) {
			$('.checked-confirmation').show()
		} else {
			$('.checked-confirmation').hide()
		}
	});

	$('#root').on('click', '.dot', function (e) {
		e.preventDefault()
		var shiftedTarget = $(this).data('target') - 2
		if (shiftedTarget > -2) {
			wizardNext(shiftedTarget)
		} else {
			wizardPrev(shiftedTarget + 2)
		}
	})

	$('#root').on('click', '.wizard-nav-back', function (e) {
		e.preventDefault()
		wizardPrev(0)
	})

	$('#root').on('submit', '.feedback-form', function (e) {
		e.preventDefault()
		//e.stopImmediatePropagation()
		$('.feedback-form input[type="submit"]').prop('disabled', true);

		var data = {
			task_id: parseInt($('input[name="task-id"]').val()),
			rating: parseInt($('input[name="rating"]:checked').val()),
			review: $('textarea[name="review"]').val()
		}
		asvzFeedback.submit({
			data,
			done: function () {
				// done dieksekusi ketika request selesai apapun kondisinya, baik itu validasi di server error atau berhasil

			},
			invalid: function () {
				// invalid dieksekusi ketika request selesai tapi dia invalid request (ini ketika format respon dari server ga sesuai kode dari backend)
				// skip aja dah, gapatio penting
			},
			error: function (msg) {
				// error ini dieksekusi ketika request selesai tapi validasi di server error (empty field, dsb)

				$('.feedback-form input[type="submit"]').prop('disabled', false);
				$('.review-invalid').html(msg)
				$('.review-invalid').show()
			},
			success: function () {
				// success ini dieksekusi ketika request selesai dan data berhasil disimpan di server (berhasil insert post)

				closeFeedback()
			},
			failed: function () {
				// failed ini dieksekusi ketika request failed (seperti masalah network disconnect)
				// skip aja dah, gapatio penting

				$('.feedback-form input[type="submit"]').prop('disabled', false);
				$('.review-invalid').html('Error, try again later.')
				$('.review-invalid').show()
			},
			always: function () {
				// ini dieksekusi apapun keadaannya (entah request done ataupun failed)

			}
		});

	})

	$('#root').on('submit', '.contact form', function (e) {
		e.preventDefault()
		$('.contact button[type="submit"]').prop('disabled', true);
		var $form = $(this)[0]
		var data = {
			subject: $('input[name="subject"]').val(),
			name: $('input[name="name"]').val(),
			email: $('input[name="email"]').val(),
			body: $('textarea[name="body"]').val()
		}
		asvzContact.submit({
			data,
			done: function () {

			},
			invalid: function () {

			},
			error: function (msg) {

			},
			success: function (msg) {
				openContactFeedback()
				$form.reset()
			},
			failed: function () {

			},
			always: function () {
			}
		});

		$('.contact button[type="submit"]').prop('disabled', false);
	})

	$('#root').on('click', '.store.accordion,.risk.accordion', function (e) {
		var message = $(this).find('.message'),
			arrow = $(this).find('.arrow'),
			height = message.height()
		if (height > 24) {
			message.animate({ height: '24px' }, 300)
			setTimeout(() => {
				message.css({
					whiteSpace: 'nowrap',
				})
				arrow.removeClass('fa-chevron-up')
				arrow.addClass('fa-chevron-down')
			}, 300)
		} else {
			message.css({ whiteSpace: 'normal' })
			message.animate({ height: message[0].scrollHeight + 'px' }, 300)
			setTimeout(() => {
				arrow.removeClass('fa-chevron-down')
				arrow.addClass('fa-chevron-up')
			}, 300)
		}
	})

	$('#root').on('click', '.question.accordion', function (e) {
		var body = $(this).find('.body'),
			arrow = $(this).find('.arrow')
		body.animate({
			height: 'toggle'
		}, 500)
		arrow.toggleClass('fa-chevron-down')
		arrow.toggleClass('fa-chevron-up')
	})

	$('#root').on('click', '.tips.accordion', function (e) {
		var message = $(this).find('.message'),
			arrow = $(this).find('.arrow'),
			height = message.height(),
			p = message.find('p');
		if (height > 24) {
			message.animate({ height: '24px' }, 300)
			setTimeout(() => {
				p.css({
					whiteSpace: 'nowrap',
				})
				arrow.removeClass('fa-chevron-up')
				arrow.addClass('fa-chevron-down')
			}, 300)
		} else {
			p.css({ whiteSpace: 'normal' })
			message.animate({ height: message[0].scrollHeight + 'px' }, 300)
			setTimeout(() => {
				arrow.removeClass('fa-chevron-down')
				arrow.addClass('fa-chevron-up')
			}, 300)
		}
	})

	$('#root').on('click', '.wizard-begin', function (e) {
		e.preventDefault()
		wizardTo(0)
	})

	$('#root').on('click', '.wizard-close', function (e) {
		e.preventDefault()
		closeWizard()
	})

})(jQuery);

function wizardNext() {
	jQuery('.wizard-carousel').triggerHandler('next.owl.carousel')
}

function wizardPrev() {
	jQuery('.wizard-carousel').triggerHandler('prev.owl.carousel')
}

function wizardTo(index) {
	jQuery('.wizard-carousel').triggerHandler('to.owl.carousel', [index])
}