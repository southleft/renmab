/* KO Library Archive scripts */

jQuery(function ($) {
  const loader = jQuery('.pi-loading');

  // jQuery('body').on('click', 'a.pi-knockout', function () {
  jQuery('body').on('click', '.ko-form--search-button', function () {
    var href = $(this).attr('href');
    var name = $(this).find('h3').text();

    loader.find('p').append(' ' + name + '...');

    loader.fadeIn(300, function () {
      window.location = href;
    });
    return false;
  });

  var form = jQuery('.pi-filters'),
    input = form.find('input[type="text"]'),
    submit = form.find('button.apply'),
    clear = form.find('button.clear'),
    results = form.find('.searchresults-wrap'),
    select = form.find('select'),
    searchCode = '';

  var sort = jQuery('.ko-sort-form'),
    sortOrder = sort.find('select');

  var queryParams = new URLSearchParams(window.location.search),
    querySearch = queryParams.get('search'),
    queryModel = queryParams.get('model');

  if (queryModel) {
    select.val(queryModel);
  }

  input.val(querySearch);

  jQuery(window).load(function () {
    loadKOs();
  });

  submit.click(function () {
    loadKOs();
  });

  clear.click(function () {
    input.val('');
    select.val('all');
    loadKOs();
  });

  input.on('keydown', function (e) {
    if (e.keyCode === 13) {
      e.preventDefault();
      loadKOs();
    }
  });

  jQuery('body').on('click', '.pi-models .loader', function () {
    let loadedModel = jQuery(this).attr('data-model');
    select.val(loadedModel);
    loadKOs();
    jQuery('html, body').animate({ scrollTop: form.offset().top - 50 }, 700);
  });

  form.on('click', '.model', function () {
    jQuery(this).remove();
    loadKOs('all');
  });

  form.on('click', '.keyword', function () {
    jQuery(this).remove();
    input.val('');
    loadKOs();
  });

  function loadKOs(model = select.val(), retry = false) {
    let keyword = input.val();
    let selectText = select.find(':selected').text();

    results.empty();
    if (model != 'all') {
      results.append(
        '<button class="pi-tag model"><span class="bubble icon-close"></span>' +
          selectText +
          '</button>'
      );
    }

    if (keyword) {
      results.append(
        '<button class="pi-tag keyword"><span class="bubble icon-close"></span>' +
          keyword +
          '</button>'
      );
      searchCode = '&search=' + encodeURIComponent(keyword);
    } else {
      searchCode = '';
    }

    var filterStr =
      '&model=' +
      model +
      searchCode +
      getSearchParams() +
      '&action=renmab_ajax_pi_filter_args';

    jQuery.ajax({
      type: 'POST',
      dataType: 'html',
      url: renmab_pi_filter.ajax_url,
      data: filterStr,
      cache: true,
      success: function (data) {
        var $data = $(data);

        if ($data.length && retry) {
          jQuery('.pi-models')
            .html($data)
            .prepend(
              '<p class="no-results lead lead-small">No results found for "' +
                keyword +
                '" in ' +
                selectText +
                '. Showing results for "' +
                keyword +
                '" in all areas.</p>'
            );
        } else if ($data.length) {
          jQuery('.pi-models').html($data);
        } else if (model == 'all') {
          jQuery('.pi-models').html(
            '<p class="no-results lead lead-small">No knockouts found for "' +
              keyword +
              '".</p>'
          );
        } else {
          loadKOs('all', true);
        }
        window.history.pushState(
          null,
          '',
          '?model=' + model + searchCode + getSearchParams()
        );
      },
    });
    return false;
  }
});

function getSearchParams() {
  let paramString = '';
  let modelSelects = document.querySelectorAll('input.model-select');
  modelSelects.forEach((model) =>
    model.checked ? (paramString += `&${model.id}=true`) : ''
  );
  let phaseSelects = document.querySelectorAll('input.phase-select');
  phaseSelects.forEach((phase) =>
    phase.checked ? (paramString += `&${phase.id}=true`) : ''
  );
  let excludeSelect = document.querySelector('input.exclude-select');
  excludeSelect.checked ? (paramString += `&exclude=true`) : '';
  let sortOptions = document.querySelectorAll('option.ko-form--sort-option');
  sortOptions.forEach((option) =>
    option.selected
      ? (paramString += `&order-by=${option.value.split('-')[0]}&order=${
          option.value.split('-')[1]
        }`)
      : ''
  );

  return paramString;
}
