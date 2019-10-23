$(document).ready(function () {
  var $checkMe = $('.asdh-check-me');
  $('#asdh-index-multiple-delete').change(function () {
    if ($(this).is(':checked')) {
      $checkMe.prop('checked', true);
    } else {
      $checkMe.prop('checked', false);
    }
  })
});

function convertToSlug(text) {
  return text
      .toLowerCase()
      .replace(/ /g, '-')
      .replace(/&/g, 'and')
      .replace(/[^\w-]+/g, '');
}