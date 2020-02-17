"use strict";

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

// https://tc39.github.io/ecma262/#sec-array.prototype.findindex
if (!Array.prototype.findIndex) {
  Object.defineProperty(Array.prototype, 'findIndex', {
    value: function value(predicate) {
      // 1. Let O be ? ToObject(this value).
      if (this == null) {
        throw new TypeError('"this" is null or not defined');
      }

      var o = Object(this); // 2. Let len be ? ToLength(? Get(O, "length")).

      var len = o.length >>> 0; // 3. If IsCallable(predicate) is false, throw a TypeError exception.

      if (typeof predicate !== 'function') {
        throw new TypeError('predicate must be a function');
      } // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.


      var thisArg = arguments[1]; // 5. Let k be 0.

      var k = 0; // 6. Repeat, while k < len

      while (k < len) {
        // a. Let Pk be ! ToString(k).
        // b. Let kValue be ? Get(O, Pk).
        // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
        // d. If testResult is true, return k.
        var kValue = o[k];

        if (predicate.call(thisArg, kValue, k, o)) {
          return k;
        } // e. Increase k by 1.


        k++;
      } // 7. Return -1.


      return -1;
    },
    configurable: true,
    writable: true
  });
} // https://tc39.github.io/ecma262/#sec-array.prototype.find


if (!Array.prototype.find) {
  Object.defineProperty(Array.prototype, 'find', {
    value: function value(predicate) {
      // 1. Let O be ? ToObject(this value).
      if (this == null) {
        throw new TypeError('"this" is null or not defined');
      }

      var o = Object(this); // 2. Let len be ? ToLength(? Get(O, "length")).

      var len = o.length >>> 0; // 3. If IsCallable(predicate) is false, throw a TypeError exception.

      if (typeof predicate !== 'function') {
        throw new TypeError('predicate must be a function');
      } // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.


      var thisArg = arguments[1]; // 5. Let k be 0.

      var k = 0; // 6. Repeat, while k < len

      while (k < len) {
        // a. Let Pk be ! ToString(k).
        // b. Let kValue be ? Get(O, Pk).
        // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
        // d. If testResult is true, return kValue.
        var kValue = o[k];

        if (predicate.call(thisArg, kValue, k, o)) {
          return kValue;
        } // e. Increase k by 1.


        k++;
      } // 7. Return undefined.


      return undefined;
    },
    configurable: true,
    writable: true
  });
}

(function ($) {
  // your javascript functions
  $('#root').on('click', '#open-menu-btn', function () {
    $('.menu').show('slide');
    $('.menu').promise().done(function () {
      $('.menu').css('background-color', 'rgba(0,0,0,.5)');
    });
  });
  $('#root').on('click', '#close-menu-btn', function () {
    $('.menu').hide('slide');
    $('.menu').css('background-color', 'transparent');
    $('.menu').promise().done(function () {
      $('.menu').css('background-color', 'transparent');
    });
  });
  $('#root').on('click', '.btn-product', function (e) {
    $('.btn-product').prop('disabled', true);
    var productId = $(this).data('product-id');
    openProduct(productId);
  });
  $('#root').on('click', '.btn-checklist', function (e) {
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
      localStorage.removeItem('item' + itemId + 'task' + taskId);
    } else {
      $(this).html('<i class="fas fa-check-circle"></i>');
      localStorage.setItem('item' + itemId + 'task' + taskId, Date.now() + 1800000);
    }

    var checkedCount = $dialog.find('.list i.fa-check-circle').length;

    if (checkedCount == itemCount) {
      $('.checked-confirmation').show();
    } else {
      $('.checked-confirmation').hide();
    }
  });
  $('#root').on('click', '.dot', function (e) {
    e.preventDefault();
    var shiftedTarget = $(this).data('target') - 2;

    if (shiftedTarget > -2) {
      wizardNext(shiftedTarget);
    } else {
      wizardPrev(shiftedTarget + 2);
    }
  });
  $('#root').on('click', '.wizard-nav-back', function (e) {
    e.preventDefault();
    wizardPrev(0);
  });
  $('#root').on('submit', '.feedback-form', function (e) {
    e.preventDefault(); //e.stopImmediatePropagation()

    $('.feedback-form input[type="submit"]').prop('disabled', true);
    var data = {
      task_id: parseInt($('input[name="task-id"]').val()),
      rating: parseInt($('input[name="rating"]:checked').val()),
      review: $('textarea[name="review"]').val()
    };
    asvzFeedback.submit({
      data: data,
      done: function done() {// done dieksekusi ketika request selesai apapun kondisinya, baik itu validasi di server error atau berhasil
      },
      invalid: function invalid() {// invalid dieksekusi ketika request selesai tapi dia invalid request (ini ketika format respon dari server ga sesuai kode dari backend)
        // skip aja dah, gapatio penting
      },
      error: function error(msg) {
        // error ini dieksekusi ketika request selesai tapi validasi di server error (empty field, dsb)
        $('.feedback-form input[type="submit"]').prop('disabled', false);
        $('.review-invalid').html(msg);
        $('.review-invalid').show();
      },
      success: function success() {
        // success ini dieksekusi ketika request selesai dan data berhasil disimpan di server (berhasil insert post)
        closeFeedback();
      },
      failed: function failed() {
        // failed ini dieksekusi ketika request failed (seperti masalah network disconnect)
        // skip aja dah, gapatio penting
        $('.feedback-form input[type="submit"]').prop('disabled', false);
        $('.review-invalid').html('Error, try again later.');
        $('.review-invalid').show();
      },
      always: function always() {// ini dieksekusi apapun keadaannya (entah request done ataupun failed)
      }
    });
  });
  $('#root').on('submit', '.contact form', function (e) {
    e.preventDefault();
    $('.contact button[type="submit"]').prop('disabled', true);
    var $form = $(this)[0];
    var data = {
      subject: $('input[name="subject"]').val(),
      name: $('input[name="name"]').val(),
      email: $('input[name="email"]').val(),
      body: $('textarea[name="body"]').val()
    };
    asvzContact.submit({
      data: data,
      done: function done() {},
      invalid: function invalid() {},
      error: function error(msg) {},
      success: function success(msg) {
        openContactFeedback();
        $form.reset();
      },
      failed: function failed() {},
      always: function always() {}
    });
    $('.contact button[type="submit"]').prop('disabled', false);
  });
  $('#root').on('click', '.store.accordion,.risk.accordion', function (e) {
    var message = $(this).find('.message'),
        arrow = $(this).find('.arrow'),
        height = message.height();

    if (height > 24) {
      message.animate({
        height: '24px'
      }, 300);
      setTimeout(function () {
        message.css({
          whiteSpace: 'nowrap'
        });
        arrow.removeClass('fa-chevron-up');
        arrow.addClass('fa-chevron-down');
      }, 300);
    } else {
      message.css({
        whiteSpace: 'normal'
      });
      message.animate({
        height: message[0].scrollHeight + 'px'
      }, 300);
      setTimeout(function () {
        arrow.removeClass('fa-chevron-down');
        arrow.addClass('fa-chevron-up');
      }, 300);
    }
  });
  $('#root').on('click', '.question.accordion', function (e) {
    var body = $(this).find('.body'),
        arrow = $(this).find('.arrow');
    body.animate({
      height: 'toggle'
    }, 500);
    arrow.toggleClass('fa-chevron-down');
    arrow.toggleClass('fa-chevron-up');
  });
  $('#root').on('click', '.tips.accordion', function (e) {
    var message = $(this).find('.message'),
        arrow = $(this).find('.arrow'),
        height = message.height(),
        p = message.find('p');

    if (height > 24) {
      message.animate({
        height: '24px'
      }, 300);
      setTimeout(function () {
        p.css({
          whiteSpace: 'nowrap'
        });
        arrow.removeClass('fa-chevron-up');
        arrow.addClass('fa-chevron-down');
      }, 300);
    } else {
      p.css({
        whiteSpace: 'normal'
      });
      message.animate({
        height: message[0].scrollHeight + 'px'
      }, 300);
      setTimeout(function () {
        arrow.removeClass('fa-chevron-down');
        arrow.addClass('fa-chevron-up');
      }, 300);
    }
  });
  $('#root').on('click', '.wizard-begin', function (e) {
    e.preventDefault();
    wizardTo(0);
  });
  $('#root').on('click', '.wizard-close', function (e) {
    e.preventDefault();
    closeWizard();
  });
})(jQuery);

function wizardNext() {
  jQuery('.wizard-carousel').triggerHandler('next.owl.carousel');
}

function wizardPrev() {
  jQuery('.wizard-carousel').triggerHandler('prev.owl.carousel');
}

function wizardTo(index) {
  jQuery('.wizard-carousel').triggerHandler('to.owl.carousel', [index]);
}

(function ($) {
  var root = null;
  var useHash = true; // Defaults to: false

  var router = new Navigo(root, useHash); // your javascript functions

  regPart('floatTemplate', '#float-template');
  regPart('headerTemplate', '#header-template');
  regPart('footerTemplate', '#footer-template');
  regPart('indexTemplate', '#index-template');
  regPart('tasksTemplate', '#tasks-template');
  regPart('tasksDetailTemplate', '#tasks-detail-template');
  regPart('productListTemplate', '#product-list-template');
  regPart('productDetailTemplate', '#product-detail-template');
  regPart('tipsListTemplate', '#tips-list-template');
  regPart('tipsDetailTemplate', '#tips-detail-template');
  regPart('contactTemplate', '#contact-template');
  regPart('faqTemplate', '#faq-template');
  regPart('wizardDialogTemplate', '#wizard-dialog-template');
  regPart('wizardIntroTemplate', '#wizard-intro-template');
  Handlebars.registerHelper("inc", function (value, options) {
    return parseInt(value) + 1;
  });
  window.asvzHistory = [];
  router.on({
    '/': function _() {
      // show home page here
      navigate('welcome', 0);
    },
    '/category': function category() {
      navigate('category', 1);
    },
    '/category/:categorySlug': function categoryCategorySlug(params) {
      navigate(params.categorySlug, 2);
    },
    '/category/:categorySlug/:taskSlug': function categoryCategorySlugTaskSlug(params) {
      navigate({
        task: params.taskSlug,
        category: params.categorySlug
      }, 3);
    },
    '/product': function product() {
      navigate('product', 4);
    },
    '/product/:productSlug': function productProductSlug(params) {
      navigate(params.productSlug, 5);
    },
    '/contact': function contact() {
      navigate('contact', 6);
    },
    '/faq': function faq() {
      navigate('faq', 7);
    },
    '/tips': function tips() {
      navigate('tips', 8);
    },
    '/tips/:slug': function tipsSlug(params) {
      navigate(params.slug, 9);
    }
  }).resolve(); //handle list of completed material

  window.checkedMaterials = [];

  if (!location.hash) {
    if (history.pushState) {
      history.pushState(null, null, '#');
    } else {
      location.hash = '/';
    }
  }

  $('#root').on('click', '.back-btn', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    history.back();
  });
})(jQuery);

function navigate(target, pageType) {
  var isBack = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
  //console.log('navigating',target);
  var targetType = pageType ? pageType : 0;
  var templateId = '#welcome-template',
      className = '.welcome',
      lorem = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
      screenName,
      path,
      context = {},
      imgUrl = asvzObj.themeUrl + '/assets/images/',
      isIndex = false,
      isTasks = false,
      isTasksDetail = false,
      isProductList = false,
      isProductDetail = false,
      isTipsList = false,
      isTipsDetail = false,
      isContact = false,
      isFaq = false,
      isLocalVideo,
      isImage,
      isEmbed,
      category = {},
      categoryId,
      categoryHeaderImage,
      tasks = [],
      task = {},
      taskIndex,
      taskId,
      taskFrequency,
      embed,
      nextTask,
      taskSteps = {},
      steps = [],
      materials = [],
      product = {},
      questions = [],
      alternatives = [],
      tips = [{
    description: "<p>".concat(lorem, "</p>")
  }, {
    description: "<p>".concat(lorem, "</p>")
  }],
      contact = {},
      coverUrl,
      coverThumbnail,
      prevSlug,
      prevPageType,
      childPageType,
      title,
      showBackBtn,
      showMenuBtn,
      fabIcon,
      menus = [];

  switch (targetType) {
    case 0:
      // Welcome page
      var _ref = asvzObj && asvzObj.pages && asvzObj.pages.welcome ? asvzObj.pages.welcome : {
        title: 'Title',
        subtitle: 'Subtitle',
        thumbnail: imgUrl + '/koala.png',
        description: 'This is a description',
        cta_button: {
          text: 'Button Label'
        }
      },
          title = _ref.title,
          subtitle = _ref.subtitle,
          thumbnail = _ref.thumbnail,
          description = _ref.description,
          cta_button = _ref.cta_button;

      screenName = 'Welcome Page';
      path = '/welcome/';
      break;

    case 1:
      // Index page
      title = screenName = typeof asvzObj.page_titles !== "undefined" ? asvzObj.page_titles.categories : 'Page Title';
      isIndex = true;
      childPageType = targetType + 1;
      showBackBtn = false;
      showMenuBtn = true;
      path = '/category/';
      var menuItems = typeof asvzObj.menu_items !== "undefined" ? asvzObj.menu_items : [];
      menus = [_objectSpread({
        text: 'Categories',
        icon: 'fab fa-js-square'
      }, menuItems.categories, {
        menuTarget: 'category',
        menuDepth: 1
      }), _objectSpread({
        text: 'Products',
        icon: 'fab fa-js-square'
      }, menuItems.materials, {
        menuTarget: 'product',
        menuDepth: 4
      }), _objectSpread({
        text: 'Tips',
        icon: 'fab fa-js-square'
      }, menuItems.tips, {
        menuTarget: 'tips',
        menuDepth: 8
      }), _objectSpread({
        text: 'FAQ',
        icon: 'fab fa-js-square'
      }, menuItems.faq, {
        menuTarget: 'faq',
        menuDepth: 7
      })
      /* {
          text: 'Contact',
          icon: 'fab fa-js-square',
          ...menuItems.contact,
          menuTarget: 'contact',
          menuDepth: 6
      }, */

      /*
      {
          ...menuItems.tasks,
          menuTarget: 'category/all',
          menuDepth: 2
      }, */
      ];
      break;

    case 2:
      // Category page / Tasks list page
      if (target != 'all') {
        category = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find(function (value, index, array) {
          return value.slug == target;
        }) : {
          tips: tips
        };
        categoryId = category.term_id;
        var filteredTasks = typeof asvzObj.tasks !== 'undefined' ? asvzObj.tasks.filter(function (value, index, array) {
          return value.category == categoryId;
        }) : [{
          post_title: 'Sass',
          post_name: 'sass',
          frequency: 'Seldom'
        }];
        var filteredTasksWithCategory = filteredTasks.map(function (taskVal) {
          var parentCategory = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find(function (categoryVal) {
            return categoryVal.term_id == taskVal.category;
          }).slug : 'wonderful';
          return _objectSpread({}, taskVal, {
            parentCategory: parentCategory
          });
        });
        tasks = filteredTasks.length > 0 ? filteredTasksWithCategory : [{
          post_title: 'No tasks',
          parentCategory: target
        }];
      } else {
        tasks = asvzObj.tasks.map(function (taskVal, i, arr) {
          var parentCategory = asvzObj.categories.find(function (categoryVal) {
            return categoryVal.term_id == taskVal.category;
          }).slug;
          return _objectSpread({}, taskVal, {
            parentCategory: parentCategory
          });
        });
      } //console.log(categoryId);


      title = category.name ? category.name : typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.tasks : 'Wonderful';
      screenName = 'Category: ' + title;
      categoryHeaderImage = category.header_image;
      window.tasks = _toConsumableArray(tasks);
      tips = category.tips ? category.tips : false;
      isTasks = true;
      childPageType = targetType + 1;
      showBackBtn = true;
      showMenuBtn = false;
      path = '/category/' + target + '/';
      fabIcon = typeof asvzObj.popup !== 'undefined' ? asvzObj.popup.trigger.tips_icon : 'fab fa-suse';
      break;

    case 3:
      // Task detail
      window.task = target.task;
      task = typeof asvzObj.tasks !== 'undefined' ? asvzObj.tasks.find(function (value, index, array) {
        return value.post_name == target.task;
      }) : {
        post_title: 'Sass',
        frequency: 'Seldom',
        cover_type: 0,
        cover_image: imgUrl + '/placeholder.png'
      };
      var parentCategory = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find(function (categoryVal) {
        return categoryVal.slug == target.category;
      }) : {};
      var filteredTasks = typeof asvzObj.tasks !== 'undefined' ? asvzObj.tasks.filter(function (taskValue, index, array) {
        return taskValue.category == parentCategory.term_id;
      }) : [];
      taskIndex = filteredTasks.findIndex(function (value, index, array) {
        return value.post_name == target.task;
      });
      nextTask = filteredTasks[taskIndex + 1];
      window.nextTask = nextTask ? nextTask.post_name : '';
      taskSteps = typeof asvzObj.steps !== 'undefined' ? asvzObj.steps.find(function (value, index, array) {
        return value.task_id == task.ID;
      }) : {
        steps: [{
          name: 'Step 1',
          has_warning: true
        }, {
          name: 'Step 2: Sedia payung sebelum hujan'
        }]
      }; //console.log(parentCategory);

      steps = taskSteps.steps;
      title = task.post_title;
      screenName = 'Task: ' + title;
      taskId = task.ID;
      taskFrequency = task.frequency;

      switch (task.cover_type) {
        case 0:
          isImage = true;
          coverUrl = task.cover_image;
          break;

        case 1:
          isLocalVideo = true;
          coverUrl = task.cover_video;
          break;

        case 2:
          isEmbed = true;
          embed = task.cover_embed;
          break;
      }

      coverThumbnail = task.cover_video_thumbnail;
      isTasksDetail = true;
      childPageType = targetType + 1;
      showBackBtn = true;
      showMenuBtn = false;
      fabIcon = typeof asvzObj.popup !== 'undefined' ? asvzObj.popup.trigger.wizard_icon : 'fab fa-suse';
      path = '/task/' + target + '/';
      break;

    case 4:
      // Product List
      title = screenName = typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.products : 'Some list';
      showBackBtn = true;
      isProductList = true;
      materials = asvzObj.materials ? asvzObj.materials : [{
        post_name: 'name-1',
        post_title: 'The title',
        thumbnail: imgUrl + '/ox.png'
      }, {
        post_name: 'name-2',
        post_title: 'Second item',
        thumbnail: imgUrl + '/chick.png'
      }];
      childPageType = targetType + 1;
      path = '/product/';
      break;

    case 5:
      // Product detail
      product = typeof asvzObj.materials !== 'undefined' ? asvzObj.materials.find(function (val, i, arr) {
        return target == val.post_name;
      }) : {
        post_title: 'The title',
        carousel_images: [{
          sizes: {
            medium_square: imgUrl + '/ox512.png'
          }
        }],
        description: lorem
      };
      title = product.post_title;
      screenName = 'Product: ' + title;
      showBackBtn = true;
      isProductDetail = true;
      path = '/product/' + target + '/';
      break;

    case 6:
      // Contact page
      title = screenName = typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.contact : 'Titel';
      showBackBtn = true;
      isContact = true;
      contact = asvzObj.contact_form;
      path = '/contact/';
      break;

    case 7:
      // FAQ page
      title = screenName = typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.faq : 'Title';
      showBackBtn = true;
      isFaq = true;
      questions = asvzObj.faqs ? asvzObj.faqs : [{
        post_title: 'Accordion 1',
        post_content: lorem
      }, {
        post_title: 'Accordion 2',
        post_content: lorem
      }];
      path = '/faq/'; //console.log(questions);

      break;

    case 8:
      // Tips List
      title = screenName = typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.tips : 'Title';
      showBackBtn = true;
      isTipsList = true;
      childPageType = targetType + 1;
      path = '/tips/';
      break;

    case 9:
      // Tips detail
      category = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find(function (value, index, array) {
        return value.slug == target;
      }) : {
        tips: tips
      };
      title = screenName = typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.tips + ': ' + category.name : 'Title';
      tips = _toConsumableArray(category.tips);
      showBackBtn = true;
      isTipsDetail = true;
      path = '/tips/' + target + '/';
      break;
  }

  templateId = pageType ? '#page-template' : '#welcome-template';
  className = pageType ? '.app-page' : '.welcome';
  context = _objectSpread({
    title: title,
    subtitle: subtitle,
    description: description,
    thumbnail: thumbnail,
    cta_button: cta_button,
    categories: typeof asvzObj.categories !== 'undefined' ? asvzObj.categories : [{
      name: 'Category Example',
      icon: imgUrl + '/super0.png',
      header_image: imgUrl + '/super0.png',
      slug: 'wonderful'
    }, {
      name: 'Sample Category',
      icon: imgUrl + '/super1.png',
      header_image: imgUrl + '/super1.png',
      slug: 'wonderful'
    }],
    tasks: tasks,
    taskId: taskId,
    taskFrequency: taskFrequency,
    categoryId: categoryId,
    categoryHeaderImage: categoryHeaderImage,
    steps: steps,
    materials: materials
  }, product, {
    questions: questions,
    alternatives: alternatives,
    tips: tips,
    contact: contact,
    isImage: isImage,
    isLocalVideo: isLocalVideo,
    isEmbed: isEmbed,
    coverUrl: coverUrl,
    embed: embed,
    coverThumbnail: coverThumbnail,
    showBackBtn: showBackBtn,
    showMenuBtn: showMenuBtn,
    isIndex: isIndex,
    isTasks: isTasks,
    isTasksDetail: isTasksDetail,
    isProductList: isProductList,
    isProductDetail: isProductDetail,
    isContact: isContact,
    isFaq: isFaq,
    isTipsList: isTipsList,
    isTipsDetail: isTipsDetail,
    childPageType: childPageType,
    prevPageType: prevPageType,
    currentSlug: target,
    prevSlug: prevSlug,
    menus: menus,
    fabIcon: fabIcon,
    powered_by: 'Footer text',
    material_needed: 'Button'
  }); //console.log(asvzObj.general_labels);

  showFade(templateId, className, context, isBack); //console.log(product);

  jQuery(document).triggerHandler('asvzNavigate', {
    screenName: screenName,
    title: screenName,
    page: path,
    appName: 'ASVZ'
  }); //SearchAutocomplete.init();

  if (targetType == 2) {
    var taskSlider = jQuery("#task-slider");
    taskSlider.owlCarousel({
      autoplay: true,
      loop: true,
      autoWidth: true,
      center: true,
      nav: true,
      navText: ['<i class="far text-white fa-chevron-left"></i>', '<i class="far text-white fa-chevron-right"></i>', '3', '4'],
      onTranslated: function onTranslated(x) {
        var allLabel = jQuery('.task .label');
        var allArrow = jQuery('.task .arrow');
        var activeTask = jQuery(".task:nth-child(".concat(x.page.index + 1, ")"));
        var activeLabel = activeTask.find('.label');
        var activeArrow = activeTask.find('.arrow');
        allLabel.removeClass("bg-pink");
        allLabel.addClass("bg-blue");
        allArrow.removeClass("bg-pink-2");
        allArrow.addClass("bg-blue-2");
        activeLabel.removeClass("bg-blue");
        activeLabel.addClass("bg-pink");
        activeArrow.removeClass("bg-blue-2");
        activeArrow.addClass("bg-pink-2");
      },
      onInitialized: function onInitialized(x) {
        //console.log(x);
        var allLabel = jQuery('.task .label');
        var allArrow = jQuery('.task .arrow');
        var firstTask = jQuery(".task:first-child()");
        var firstLabel = firstTask.find('.label');
        var firstArrow = firstTask.find('.arrow');
        allLabel.addClass("bg-blue");
        allArrow.addClass("bg-blue-2");
        firstLabel.removeClass("bg-blue");
        firstLabel.addClass("bg-pink");
        firstArrow.removeClass("bg-blue-2");
        firstArrow.addClass("bg-pink-2");
      }
    });
  } else {
    if (taskSlider) {
      taskSlider.trigger(destroy.owl.carousel);
    }
  }

  if (targetType == 3) {
    var mediaElement = jQuery('#media-element');
    mediaElement.mediaelementplayer({
      stretching: 'responsive',
      hideVideoControlsOnLoad: true,
      success: function success(media, node, instance) {
        jQuery(document).on('asvzPopup', function () {
          media.pause();
        });
      }
    });
  } else {
    var playerId = jQuery('#media-element').closest('.mejs__container').attr('id');

    if (playerId) {
      var player = mejs.players[playerId];
      player.remove();
    }
  }

  if (targetType == 5) {
    var productSlider = jQuery("#product-slider");
    productSlider.owlCarousel({
      autoplay: true,
      loop: true,
      items: 1,
      nav: true,
      navText: ['<i class="far text-white fa-chevron-left"></i>', '<i class="far text-white fa-chevron-right"></i>', '3', '4']
    });
    jQuery('.message').each(function () {
      if (jQuery(this)[0].scrollHeight > 24) {
        jQuery(this).css({
          whiteSpace: 'nowrap'
        });
      } else {
        jQuery(this).siblings('.arrow').hide();
      }
    });
  } else {
    if (productSlider) {
      productSlider.trigger(destroy.owl.carousel);
    }
  }

  if (targetType == 9) {
    jQuery('.message').each(function () {
      if (jQuery(this)[0].scrollHeight > 24) {
        jQuery(this).find('p').css({
          whiteSpace: 'nowrap'
        });
      } else {
        jQuery(this).siblings('.arrow').hide();
      }
    });
  }
}

function regPart(name, src) {
  var source = jQuery(src).html();
  Handlebars.registerPartial(name, source);
}

function createElement(templateId, context) {
  // templateId include # sign
  var source = jQuery(templateId).html();
  var template = Handlebars.compile(source);
  var html = template(context);
  return html;
}

function render(templateId, context) {
  // templateId include # sign
  var html = createElement(templateId, context);
  jQuery('#root').prepend(html);
}

function showSlide(templateId, className, context, isBack) {
  // templateId include # sign
  render(templateId, context);
  var direction = isBack ? 'left' : 'right';
  jQuery(className).show('slide', {
    direction: direction
  });
}

function showFade(templateId, className, context, isBack) {
  // templateId include # sign
  render(templateId, context);
  jQuery(className).fadeIn({
    complete: function complete() {
      if (jQuery('#root>*').length > 1) {
        jQuery('#root>div:last-child').remove();
      }

      jQuery('.lightbox').remove();
      jQuery(className).css({
        zIndex: 0,
        position: 'static',
        display: 'flex',
        flexDirection: 'column'
      });
      jQuery(window).scrollTop(0);
    }
  });
  jQuery("body").removeAttr("style");
}

function showLightbox(templateId, context, eventLabel) {
  // templateId include # sign
  render(templateId, context);
  setTimeout(function () {
    jQuery('.lightbox').removeClass('hide');
  }, 100);
  lightboxEvent('open', eventLabel);
  jQuery('body').css('overflow', 'hidden');
}

;

function destroyLightbox(lightboxId, eventLabel) {
  // templateId include # sign
  var lightBox = jQuery(lightboxId);
  lightBox.addClass('hide');
  setTimeout(function () {
    jQuery(lightBox).remove();
  }, 300);
  lightboxEvent('close', eventLabel);
  jQuery("body").removeAttr("style");
}

function lightboxEvent(eventAction, eventLabel) {
  jQuery(document).triggerHandler('asvzPopup', {
    eventCategory: 'Popup',
    //Popup
    eventAction: eventAction,
    //open or close
    eventLabel: eventLabel,
    //popup title
    appName: 'ASVZ'
  });
}

function toggleSearchBox(el) {
  var searchBox = jQuery(el).closest('.header').find('.search-box');
  searchBox.toggle('slide', {
    direction: 'up'
  });
}

var lorem = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
    imgUrl = asvzObj.themeUrl + '/assets/images/';

function openProduct(id) {
  var material = asvzObj.materials.find(function (value, index, array) {
    return value.ID == id;
  }); //console.log(material);

  window.product = material.post_title;
  showLightbox('#product-lightbox-template', _objectSpread({}, material), 'Product: ' + window.product);
}

function closeProduct() {
  destroyLightbox('#product-lightbox', 'Product: ' + window.product);
  jQuery('.btn-product').prop('disabled', false);
}

function openMaterials(id) {
  var isAllChecked = false;
  var task = typeof asvzObj.tasks !== 'undefined' ? asvzObj.tasks.find(function (value, index, arr) {
    return value.ID == id;
  }) : {
    materials: [1]
  };
  var materials = task.materials.map(function (element) {
    var item = typeof asvzObj.materials !== 'undefined' ? asvzObj.materials.find(function (value, index, arr) {
      return value.ID == element;
    }) : {
      post_title: 'Item Name',
      thumbnail: imgUrl + 'ox.png'
    };
    var isChecked = false;

    if (parseInt(localStorage.getItem("item" + item.ID + "task" + id)) > Date.now()) {
      isChecked = true;
    }

    return _objectSpread({}, item, {
      isChecked: isChecked
    });
  }); //console.log(materials);

  window.taskTitle = task.post_title;
  showLightbox('#materials-lightbox-template', {
    materials: materials,
    taskId: task.ID,
    isAllChecked: isAllChecked,
    completeLabel: typeof asvzObj.general_labels !== 'undefined' ? asvzObj.general_labels.completed_material : 'Completed!'
  }, 'Materials & resources for task: ' + window.taskTitle);
  jQuery(".scrollable").mCustomScrollbar({
    autoHideScrollbar: true,
    theme: "dark"
  });
  var $dialog = jQuery('.materials .dialog');
  var checkedCount = $dialog.find('.list i.fa-check-circle').length;
  var itemCount = $dialog.find('.list .item').length;

  if (checkedCount == itemCount) {
    jQuery('.checked-confirmation').show();
  }
}

function closeMaterials() {
  destroyLightbox('#materials-lightbox', 'Materials & resources for task: ' + window.taskTitle);
  jQuery('.btn-checklist').prop('disabled', false);
}

function openWizard(id) {
  var taskSteps = typeof asvzObj.steps !== 'undefined' ? asvzObj.steps.find(function (value, index, arr) {
    return value.task_id == id;
  }) : {
    steps: [{
      name: 'Rajin pangkal kaya',
      has_warning: true,
      image: imgUrl + '/ox.png'
    }, {
      name: 'Sedia payung sebelum hujan',
      image: imgUrl + '/chick.png'
    }],
    intro: {
      header: 'Header',
      body: lorem,
      footer: 'Footer'
    },
    celebratory: {
      text: 'Celebration text',
      image: imgUrl + '/ox.png'
    }
  };
  var task = typeof asvzObj.tasks !== 'undefined' ? asvzObj.tasks.find(function (val, i, arr) {
    return val.ID == id;
  }) : {
    post_title: 'Sass',
    frequency: 'Seldom',
    cover_type: 0,
    cover_image: imgUrl + '/placeholder.png'
  };
  var parentCategory = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find(function (categoryVal) {
    return categoryVal.term_id == task.category;
  }).slug : 'ok';
  var intro = taskSteps.intro,
      _taskSteps$celebrator = taskSteps.celebratory,
      text = _taskSteps$celebrator.text,
      image = _taskSteps$celebrator.image;

  var steps = _toConsumableArray(taskSteps.steps);

  steps.push({
    title: "WOW!",
    name: text,
    image: image,
    lastSlide: true
  });
  window.taskTitle = task.post_title; //console.log(task);

  showLightbox('#wizard-lightbox-template', {
    intro: intro,
    steps: steps,
    nextTask: window.nextTask,
    parentCategory: parentCategory
  }, 'Wizard for task: ' + window.taskTitle);
  jQuery('.wizard-carousel').owlCarousel({
    dots: false,
    items: 1,
    autoHeight: true,
    onChanged: function onChanged(e) {
      //console.log(e);
      var _e$item = e.item,
          index = _e$item.index,
          count = _e$item.count,
          wizardClose = jQuery('#wizard-lightbox .links .wizard-close');
      jQuery('.owl-dots').html("".concat(index + 1, "/").concat(count));

      if (index == count - 1) {
        wizardClose.show();
      } else {
        wizardClose.hide();
      }
    }
  });
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
  var task = asvzObj.tasks.find(function (val, i, arr) {
    return val.ID == id;
  });
  var _asvzObj = asvzObj,
      feedback_form = _asvzObj.feedback_form;
  window.taskTitle = task.post_title;
  showLightbox('#feedback-lightbox-template', _objectSpread({
    id: id
  }, feedback_form, {
    stars: [1, 0, 0, 0, 0, 0]
  }), 'Feedback for task: ' + window.taskTitle);
}

function closeFeedback() {
  destroyLightbox('#feedback-lightbox', 'Feedback for task: ' + window.taskTitle);
}

function openContactFeedback() {
  showLightbox('#contact-feedback-lightbox-template', asvzObj.contact_form.messages.success, 'Contact Feedback');
}

function closeContactFeedback() {
  destroyLightbox('#contact-feedback-lightbox', 'Contact Feedback');
}

function openTips(id) {
  var category = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find(function (val, i, arr) {
    return val.term_id == id;
  }) : {
    tips: [{
      description: "<p>".concat(lorem, "</p>")
    }, {
      description: "<p>".concat(lorem, "</p>")
    }]
  };
  showLightbox('#tips-lightbox-template', {
    title: typeof asvzObj.general_labels !== 'undefined' ? asvzObj.general_labels.tips_title : 'Title',
    tips: category.tips
  }, 'Tips');
}

function closeTips() {
  destroyLightbox('#tips-lightbox', 'Tips');
}