var lorem = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
	imgUrl = asvzObj.themeUrl + '/assets/images/'

function openProduct(id) {
	var material = asvzObj.materials.find((value, index, array) => {
		return value.ID == id
	})
	//console.log(material);
	window.product = material.post_title
	showLightbox('#product-lightbox-template', { ...material }, 'Product: ' + window.product);
}

function closeProduct() {
	destroyLightbox('#product-lightbox', 'Product: ' + window.product);
	jQuery('.btn-product').prop('disabled', false);
}

function openMaterials(id) {
	var isAllChecked = false;
	var task = typeof asvzObj.tasks !== 'undefined' ? asvzObj.tasks.find((value, index, arr) => {
		return value.ID == id
	}) : {
			materials: [1]
		}
	var materials = task.materials.map(element => {
		var item = typeof asvzObj.materials !== 'undefined' ? asvzObj.materials.find((value, index, arr) => {
			return value.ID == element
		}) : {
				post_title: 'Item Name',
				thumbnail: imgUrl + 'ox.png'
			}
		var isChecked = false
		if (parseInt(localStorage.getItem("item" + item.ID + "task" + id)) > Date.now()) {
			isChecked = true
		}
		return { ...item, isChecked }
	});

	//console.log(materials);
	window.taskTitle = task.post_title

	showLightbox('#materials-lightbox-template', { materials, taskId: task.ID, isAllChecked, completeLabel: typeof asvzObj.general_labels !== 'undefined' ? asvzObj.general_labels.completed_material : 'Completed!' }, 'Materials & resources for task: ' + window.taskTitle);
	jQuery(".scrollable").mCustomScrollbar({
		autoHideScrollbar: true,
		theme: "dark"
	});
	var $dialog = jQuery('.materials .dialog')
	var checkedCount = $dialog.find('.list i.fa-check-circle').length;
	var itemCount = $dialog.find('.list .item').length;
	if (checkedCount == itemCount) {
		jQuery('.checked-confirmation').show()
	}
}

function closeMaterials() {
	destroyLightbox('#materials-lightbox', 'Materials & resources for task: ' + window.taskTitle);
	jQuery('.btn-checklist').prop('disabled', false);
}

function openWizard(id) {
	var taskSteps = typeof asvzObj.steps !== 'undefined' ? asvzObj.steps.find((value, index, arr) => {
		return value.task_id == id
	}) : {
			steps: [
				{
					name: 'Rajin pangkal kaya',
					has_warning: true,
					image: imgUrl + '/ox.png'

				}, {
					name: 'Sedia payung sebelum hujan',
					image: imgUrl + '/chick.png'

				}
			],
			intro: {
				header: 'Header',
				body: lorem,
				footer: 'Footer'
			},
			celebratory: {
				text: 'Celebration text',
				image: imgUrl + '/ox.png'
			}
		}
	var task = typeof asvzObj.tasks !== 'undefined' ? asvzObj.tasks.find((val, i, arr) => {
		return val.ID == id
	}) : {
			post_title: 'Sass',
			frequency: 'Seldom',
			cover_type: 0,
			cover_image: imgUrl + '/placeholder.png',
		}
	var parentCategory = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find(categoryVal => categoryVal.term_id == task.category).slug : 'ok'
	var { intro, celebratory: { text, image } } = taskSteps
	var steps = [...taskSteps.steps]
	steps.push({ title: "WOW!", name: text, image, lastSlide: true })
	window.taskTitle = task.post_title
	//console.log(task);

	showLightbox('#wizard-lightbox-template', { intro, steps, nextTask: window.nextTask, parentCategory }, 'Wizard for task: ' + window.taskTitle);
	jQuery('.wizard-carousel').owlCarousel({
		dots: false,
		items: 1,
		autoHeight: true,
		onChanged: function (e) {
			//console.log(e);
			var { index, count } = e.item,
				wizardClose = jQuery('#wizard-lightbox .links .wizard-close');
			jQuery('.owl-dots').html(`${index + 1}/${count}`)
			if (index == count - 1) {
				wizardClose.show()
			} else {
				wizardClose.hide()
			}
		},
	})
}

function closeWizard() {
	destroyLightbox('#wizard-lightbox', 'Wizard for task: ' + window.taskTitle);
}

function openMenu() {
	jQuery('#menu').removeClass('hide');
}

function closeMenu() {
	jQuery('#menu').addClass('hide');
}

function openFeedback(id) {
	var task = asvzObj.tasks.find((val, i, arr) => {
		return val.ID == id
	})
	var { feedback_form } = asvzObj
	window.taskTitle = task.post_title
	showLightbox('#feedback-lightbox-template', { id, ...feedback_form, stars: [1, 0, 0, 0, 0, 0] }, 'Feedback for task: ' + window.taskTitle);
}

function closeFeedback() {
	destroyLightbox('#feedback-lightbox', 'Feedback for task: ' + window.taskTitle);
}

function openContactFeedback() {
	showLightbox('#contact-feedback-lightbox-template', asvzObj.contact_form.messages.success, 'Contact Feedback')
}

function closeContactFeedback() {
	destroyLightbox('#contact-feedback-lightbox', 'Contact Feedback');
}

function openTips(id) {
	var category = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find((val, i, arr) => {
		return val.term_id == id
	}) : {
			tips: [
				{
					description: `<p>${lorem}</p>`
				},
				{
					description: `<p>${lorem}</p>`
				}
			]
		}
	showLightbox('#tips-lightbox-template', { title: typeof asvzObj.general_labels !== 'undefined' ? asvzObj.general_labels.tips_title : 'Title', tips: category.tips }, 'Tips')
}

function closeTips() {
	destroyLightbox('#tips-lightbox', 'Tips')
}
