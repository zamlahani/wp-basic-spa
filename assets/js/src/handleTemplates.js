(function ($) {
    var root = null;
    var useHash = true; // Defaults to: false
    var router = new Navigo(root, useHash);

    // your javascript functions
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

    window.asvzHistory = []

    router
        .on({
            '/': function () {
                // show home page here
                navigate('welcome', 0)
            },
            '/category': () => {
                navigate('category', 1)
            },
            '/category/:categorySlug': (params) => {
                navigate(params.categorySlug, 2)
            },
            '/category/:categorySlug/:taskSlug': (params) => {
                navigate({ task: params.taskSlug, category: params.categorySlug }, 3)
            },
            '/product': () => {
                navigate('product', 4)
            },
            '/product/:productSlug': (params) => {
                navigate(params.productSlug, 5)
            },
            '/contact': () => {
                navigate('contact', 6)
            },
            '/faq': () => {
                navigate('faq', 7)
            },
            '/tips': () => {
                navigate('tips', 8)
            },
            '/tips/:slug': (params) => {
                navigate(params.slug, 9)
            },
        })
        .resolve();

    //handle list of completed material
    window.checkedMaterials = [];

    if (!location.hash) {
        if (history.pushState) {
            history.pushState(null, null, '#');
        }
        else {
            location.hash = '/';
        }
    }

    $('#root').on('click', '.back-btn', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        history.back()
    });

})(jQuery);

function navigate(target, pageType, isBack = false) {
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
        tips = [
            {
                description: `<p>${lorem}</p>`
            },
            {
                description: `<p>${lorem}</p>`
            }
        ],
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
            var { title, subtitle, thumbnail, description, cta_button } = asvzObj && asvzObj.pages && asvzObj.pages.welcome ? asvzObj.pages.welcome : { title: 'Title', subtitle: 'Subtitle', thumbnail: imgUrl + '/koala.png', description: 'This is a description', cta_button: { text: 'Button Label' } };
            screenName = 'Welcome Page';
            path = '/welcome/'
            break;
        case 1:
            // Index page
            title = screenName = (typeof asvzObj.page_titles !== "undefined") ? asvzObj.page_titles.categories : 'Page Title'
            isIndex = true;
            childPageType = targetType + 1;
            showBackBtn = false;
            showMenuBtn = true;
            path = '/category/'
            var menuItems = (typeof asvzObj.menu_items !== "undefined") ? asvzObj.menu_items : []
            menus = [
                {
                    text: 'Categories',
                    icon: 'fab fa-js-square',
                    ...menuItems.categories,
                    menuTarget: 'category',
                    menuDepth: 1
                },
                {
                    text: 'Products',
                    icon: 'fab fa-js-square',
                    ...menuItems.materials,
                    menuTarget: 'product',
                    menuDepth: 4
                },
                {
                    text: 'Tips',
                    icon: 'fab fa-js-square',
                    ...menuItems.tips,
                    menuTarget: 'tips',
                    menuDepth: 8
                },
                {
                    text: 'FAQ',
                    icon: 'fab fa-js-square',
                    ...menuItems.faq,
                    menuTarget: 'faq',
                    menuDepth: 7
                },
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
            ]

            break;
        case 2:
            // Category page / Tasks list page
            if (target != 'all') {
                category = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find((value, index, array) => {
                    return value.slug == target
                }) : {
                        tips
                    }
                categoryId = category.term_id
                var filteredTasks = typeof asvzObj.tasks !== 'undefined' ? asvzObj.tasks.filter((value, index, array) => {
                    return value.category == categoryId
                }) : [{
                    post_title: 'Sass',
                    post_name: 'sass',
                    frequency: 'Seldom'
                }]
                var filteredTasksWithCategory = filteredTasks.map((taskVal) => {
                    var parentCategory = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find(categoryVal => categoryVal.term_id == taskVal.category).slug : 'wonderful'
                    return { ...taskVal, parentCategory }
                })
                tasks = filteredTasks.length > 0 ? filteredTasksWithCategory : [{
                    post_title: 'No tasks',
                    parentCategory: target
                }]
            } else {
                tasks = asvzObj.tasks.map((taskVal, i, arr) => {
                    var parentCategory = asvzObj.categories.find(categoryVal => categoryVal.term_id == taskVal.category).slug
                    return { ...taskVal, parentCategory }
                })
            }
            //console.log(categoryId);

            title = category.name ? category.name : typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.tasks : 'Wonderful'
            screenName = 'Category: ' + title
            categoryHeaderImage = category.header_image
            window.tasks = [...tasks]
            tips = category.tips ? category.tips : false
            isTasks = true;
            childPageType = targetType + 1;
            showBackBtn = true;
            showMenuBtn = false;
            path = '/category/' + target + '/'
            fabIcon = typeof asvzObj.popup !== 'undefined' ? asvzObj.popup.trigger.tips_icon : 'fab fa-suse'
            break;
        case 3:
            // Task detail
            window.task = target.task
            task = typeof asvzObj.tasks !== 'undefined' ? asvzObj.tasks.find((value, index, array) => {
                return value.post_name == target.task
            }) : {
                    post_title: 'Sass',
                    frequency: 'Seldom',
                    cover_type: 0,
                    cover_image: imgUrl + '/placeholder.png',
                }
            var parentCategory = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find(categoryVal => categoryVal.slug == target.category) : {}
            var filteredTasks = typeof asvzObj.tasks !== 'undefined' ? asvzObj.tasks.filter((taskValue, index, array) => {
                return taskValue.category == parentCategory.term_id
            }) : []
            taskIndex = filteredTasks.findIndex((value, index, array) => {
                return value.post_name == target.task
            })

            nextTask = filteredTasks[taskIndex + 1]
            window.nextTask = nextTask ? nextTask.post_name : ''
            taskSteps = typeof asvzObj.steps !== 'undefined' ? asvzObj.steps.find((value, index, array) => {
                return value.task_id == task.ID
            }) : {
                    steps: [
                        {
                            name: 'Step 1',
                            has_warning: true,

                        }, {
                            name: 'Step 2: Sedia payung sebelum hujan',

                        }
                    ]
                }
            //console.log(parentCategory);

            steps = taskSteps.steps
            title = task.post_title
            screenName = 'Task: ' + title
            taskId = task.ID;
            taskFrequency = task.frequency
            switch (task.cover_type) {
                case 0:
                    isImage = true
                    coverUrl = task.cover_image
                    break;
                case 1:
                    isLocalVideo = true
                    coverUrl = task.cover_video
                    break;
                case 2:
                    isEmbed = true
                    embed = task.cover_embed
                    break;
            }
            coverThumbnail = task.cover_video_thumbnail;
            isTasksDetail = true;
            childPageType = targetType + 1;
            showBackBtn = true;
            showMenuBtn = false;
            fabIcon = typeof asvzObj.popup !== 'undefined' ? asvzObj.popup.trigger.wizard_icon : 'fab fa-suse'
            path = '/task/' + target + '/'
            break;
        case 4:
            // Product List
            title = screenName = typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.products : 'Some list'
            showBackBtn = true
            isProductList = true
            materials = asvzObj.materials ? asvzObj.materials : [
                {
                    post_name: 'name-1',
                    post_title: 'The title',
                    thumbnail: imgUrl + '/ox.png'
                },
                {
                    post_name: 'name-2',
                    post_title: 'Second item',
                    thumbnail: imgUrl + '/chick.png'
                },
            ]
            childPageType = targetType + 1
            path = '/product/'
            break;
        case 5:
            // Product detail
            product = typeof asvzObj.materials !== 'undefined' ? asvzObj.materials.find((val, i, arr) => {
                return target == val.post_name
            }) : {
                    post_title: 'The title',
                    carousel_images: [{ sizes: { medium_square: imgUrl + '/ox512.png' } }],
                    description: lorem
                }
            title = product.post_title
            screenName = 'Product: ' + title
            showBackBtn = true
            isProductDetail = true
            path = '/product/' + target + '/'
            break;
        case 6:
            // Contact page
            title = screenName = typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.contact : 'Titel'
            showBackBtn = true
            isContact = true
            contact = asvzObj.contact_form
            path = '/contact/'
            break;
        case 7:
            // FAQ page
            title = screenName = typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.faq : 'Title'
            showBackBtn = true
            isFaq = true
            questions = asvzObj.faqs ? asvzObj.faqs : [
                {
                    post_title: 'Accordion 1',
                    post_content: lorem
                },
                {
                    post_title: 'Accordion 2',
                    post_content: lorem
                }
            ]
            path = '/faq/'
            //console.log(questions);
            break;
        case 8:
            // Tips List
            title = screenName = typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.tips : 'Title'
            showBackBtn = true
            isTipsList = true
            childPageType = targetType + 1
            path = '/tips/'
            break;
        case 9:
            // Tips detail
            category = typeof asvzObj.categories !== 'undefined' ? asvzObj.categories.find((value, index, array) => {
                return value.slug == target
            }) : {
                    tips
                }
            title = screenName = typeof asvzObj.page_titles !== 'undefined' ? asvzObj.page_titles.tips + ': ' + category.name : 'Title'
            tips = [...category.tips]
            showBackBtn = true
            isTipsDetail = true
            path = '/tips/' + target + '/'
            break;
    }
    templateId = pageType ? '#page-template' : '#welcome-template';
    className = pageType ? '.app-page' : '.welcome';

    context = {
        title,
        subtitle,
        description,
        thumbnail,
        cta_button,
        categories: typeof asvzObj.categories !== 'undefined' ? asvzObj.categories : [
            {
                name: 'Category Example',
                icon: imgUrl + '/super0.png',
                header_image: imgUrl + '/super0.png',
                slug: 'wonderful'
            },
            {
                name: 'Sample Category',
                icon: imgUrl + '/super1.png',
                header_image: imgUrl + '/super1.png',
                slug: 'wonderful'
            }
        ],
        tasks,
        taskId,
        taskFrequency,
        categoryId,
        categoryHeaderImage,
        steps,
        materials,
        ...product,
        questions,
        alternatives,
        tips,
        contact,
        isImage,
        isLocalVideo,
        isEmbed,
        coverUrl,
        embed,
        coverThumbnail,
        showBackBtn,
        showMenuBtn,
        isIndex,
        isTasks,
        isTasksDetail,
        isProductList,
        isProductDetail,
        isContact,
        isFaq,
        isTipsList,
        isTipsDetail,
        childPageType,
        prevPageType,
        currentSlug: target,
        prevSlug,
        menus,
        fabIcon,
        powered_by: 'Footer text',
        material_needed: 'Button'
    };

    //console.log(asvzObj.general_labels);

    showFade(templateId, className, context, isBack);
    //console.log(product);
    jQuery(document).triggerHandler('asvzNavigate', {
        screenName,
        title: screenName,
        page: path,
        appName: 'ASVZ'
    })
    //SearchAutocomplete.init();

    if (targetType == 2) {
        var taskSlider = jQuery("#task-slider");
        taskSlider.owlCarousel({
            autoplay: true,
            loop: true,
            autoWidth: true,
            center: true,
            nav: true,
            navText: ['<i class="far text-white fa-chevron-left"></i>', '<i class="far text-white fa-chevron-right"></i>', '3', '4'],
            onTranslated: (x) => {
                var allLabel = jQuery('.task .label');
                var allArrow = jQuery('.task .arrow');
                var activeTask = jQuery(`.task:nth-child(${x.page.index + 1})`);
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
            onInitialized: (x) => {
                //console.log(x);
                var allLabel = jQuery('.task .label');
                var allArrow = jQuery('.task .arrow');
                var firstTask = jQuery(`.task:first-child()`);
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
            success: function (media, node, instance) {
                jQuery(document).on('asvzPopup', () => {
                    media.pause()
                })
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
            navText: ['<i class="far text-white fa-chevron-left"></i>', '<i class="far text-white fa-chevron-right"></i>', '3', '4'],
        })
        jQuery('.message').each(function () {
            if (jQuery(this)[0].scrollHeight > 24) {
                jQuery(this).css({ whiteSpace: 'nowrap' })
            } else {
                jQuery(this).siblings('.arrow').hide()
            }
        })
    } else {
        if (productSlider) {
            productSlider.trigger(destroy.owl.carousel);
        }
    }
    if (targetType == 9) {
        jQuery('.message').each(function () {
            if (jQuery(this)[0].scrollHeight > 24) {
                jQuery(this).find('p').css({ whiteSpace: 'nowrap' })
            } else {
                jQuery(this).siblings('.arrow').hide()
            }
        })
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
    var direction = isBack ? 'left' : 'right'
    jQuery(className).show('slide', { direction });
}

function showFade(templateId, className, context, isBack) {
    // templateId include # sign
    render(templateId, context);
    jQuery(className).fadeIn({
        complete: () => {
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
    jQuery("body").removeAttr("style")
}

function showLightbox(templateId, context, eventLabel) {
    // templateId include # sign
    render(templateId, context);
    setTimeout(() => {
        jQuery('.lightbox').removeClass('hide');
    }, 100);
    lightboxEvent('open', eventLabel)
    jQuery('body').css('overflow', 'hidden')
};

function destroyLightbox(lightboxId, eventLabel) {
    // templateId include # sign
    var lightBox = jQuery(lightboxId);
    lightBox.addClass('hide');
    setTimeout(() => {
        jQuery(lightBox).remove();
    }, 300);
    lightboxEvent('close', eventLabel)
    jQuery("body").removeAttr("style")
}

function lightboxEvent(eventAction, eventLabel) {
    jQuery(document).triggerHandler('asvzPopup', {
        eventCategory: 'Popup', //Popup
        eventAction, //open or close
        eventLabel, //popup title
        appName: 'ASVZ'
    })
}

function toggleSearchBox(el) {
    var searchBox = jQuery(el).closest('.header').find('.search-box')
    searchBox.toggle('slide', { direction: 'up' })
}