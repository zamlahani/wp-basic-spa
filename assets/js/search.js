"use strict";

var SearchAutocomplete = function ($) {
  function init() {
    setupData();
    setupAutocomplete();
    setupEvents();
  }

  function setupData() {
    asvzObj.searchData = [];

    if (asvzObj.categories.length) {
      asvzObj.categories.forEach(function (el, i) {
        asvzObj.searchData.push({
          name: el.name,
          slug: el.slug,
          id: el.term_id,
          type: 'category',
          thumb: asvzObj.type_icons.category
        });
      });
    }

    if (asvzObj.tasks.length) {
      asvzObj.tasks.forEach(function (el, i) {
        var categorySlug = asvzObj.categories.find(function (val, i, arr) {
          return val.term_id == el.category;
        }).slug;
        asvzObj.searchData.push({
          name: el.post_title,
          slug: el.post_name,
          id: el.ID,
          category: el.category,
          categorySlug: categorySlug,
          type: 'task',
          thumb: asvzObj.type_icons.task
        });
      });
    }

    if (asvzObj.steps.length) {
      asvzObj.steps.forEach(function (arr, i) {
        var steps = arr.steps;

        if (steps.length) {
          steps.forEach(function (step, i) {
            asvzObj.searchData.push({
              name: step.name,
              task_id: arr.task_id,
              type: 'step',
              thumb: asvzObj.type_icons.step
            });
          });
        }
      });
    }

    if (asvzObj.materials.length) {
      asvzObj.materials.forEach(function (material, i) {
        asvzObj.searchData.push({
          name: material.post_title,
          slug: material.post_name,
          id: material.ID,
          type: 'material',
          thumb: asvzObj.type_icons.material
        });
      });
    }

    if (asvzObj.faqs.length) {
      asvzObj.faqs.forEach(function (faq, i) {
        asvzObj.searchData.push({
          name: faq.post_title,
          slug: faq.post_name,
          id: faq.ID,
          type: 'faq',
          thumb: asvzObj.type_icons.faq
        });
      });
    }
  }

  function setupAutocomplete() {
    var options = {
      minLength: 2,
      searchIn: ['name'],
      searchContain: true,
      iconProperty: 'thumb',
      visibleProperties: ['thumb', 'name'],
      data: asvzObj.searchData
    };
    $(".autocomplete").flexdatalist(options);
  }

  function setupEvents() {
    $(".autocomplete").on('select:flexdatalist', function (e, o, opts) {
      var task, categorySlug;

      if (o.type === 'category') {
        window.location.href = "/#/category/" + o.slug;
      } else if (o.type === 'task') {
        window.location.href = "/#/category/".concat(o.categorySlug, "/").concat(o.slug);
      } else if (o.type === 'step') {
        task = asvzObj.tasks.find(function (item, i) {
          return item.ID === o.task_id;
        });
        categorySlug = asvzObj.categories.find(function (val, i, arr) {
          return val.term_id == task.category;
        }).slug;

        if (task) {
          window.location.href = "/#/category/".concat(categorySlug, "/").concat(task.post_name);
        }
      } else if (o.type === 'material') {
        window.location.href = "/#/product/".concat(o.slug);
      } else if (o.type === 'faq') {
        window.location.href = "/#/faq";
      }
    });
  }

  return {
    init: init
  };
}(jQuery);