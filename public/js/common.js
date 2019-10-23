$(document).ready(function () {
  $('.asdh-make_inactive').click(function (e) {
    e.preventDefault();
  });

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('.asdh-center_image_inside_me').each(function () {
    asdhCenterImageInsideMe($(this));
  });

  // prevent multiple form submit
  $('.from-prevent-multiple-submit').submit(function () {
    var $buttonToDisable = $('.btn-prevent-multiple-submit');
    $buttonToDisable.prop('disabled', true);
    $buttonToDisable.html('<i class="fa fa-spinner fa-spin"></i> ' + $buttonToDisable.text());
  });

  // prevent form submission on enter press
  $('.prevent-form-submission-on-enter-press').keypress(function (event) {
    preventFormSubmissionOnEnterPress(event);
  });

});

function showAlertMessageSuccess(message) {
  var $alertMessageSuccess = $('.asdh-alert-message.alert-success');
  var $alertMessageDanger = $('.asdh-alert-message.alert-danger');
  var $alertMessageWarning = $('.asdh-alert-message.alert-warning');

  $alertMessageDanger.hide();
  $alertMessageWarning.hide();
  $alertMessageSuccess.children('p').text(message);
  $alertMessageSuccess.fadeIn();
  setTimeout(function () {
    $alertMessageSuccess.fadeOut();
  }, 5000);
}

function showAlertMessageDanger(message) {
  var $alertMessageSuccess = $('.asdh-alert-message.alert-success');
  var $alertMessageDanger = $('.asdh-alert-message.alert-danger');
  var $alertMessageWarning = $('.asdh-alert-message.alert-warning');

  $alertMessageSuccess.hide();
  $alertMessageWarning.hide();
  $alertMessageDanger.children('p').text(message);
  $alertMessageDanger.fadeIn();
  setTimeout(function () {
    $alertMessageDanger.fadeOut();
  }, 5000);
}

function showAlertMessageWarning(message) {
  var $alertMessageSuccess = $('.asdh-alert-message.alert-success');
  var $alertMessageDanger = $('.asdh-alert-message.alert-danger');
  var $alertMessageWarning = $('.asdh-alert-message.alert-warning');

  $alertMessageSuccess.hide();
  $alertMessageDanger.hide();
  $alertMessageWarning.children('p').text(message);
  $alertMessageWarning.fadeIn();
  setTimeout(function () {
    $alertMessageWarning.fadeOut();
  }, 5000);
}

function preventFormSubmissionOnEnterPress(event) {
  if(event.keyCode === 13) {
    event.preventDefault();
  }
}

function asdhCenterImageInsideMe($imageContainer) {
  var $image = $imageContainer.children('img');
  var containerHeight = $imageContainer.height();
  var imageHeight = $image.height();
  var imageWidth = $image.width();
  var heightDifference = containerHeight - imageHeight;
  var newImageWidthPercentage = 100;

  if (containerHeight > imageHeight) {
    var fractionalChange = heightDifference / imageHeight;
    newImageWidthPercentage = 100 + fractionalChange * 100;
    $image.css({
      width: newImageWidthPercentage + '%',
      left: -( fractionalChange * imageWidth / 2 )
    });
  } else if (containerHeight < imageHeight) {
    $image.css({
      top: heightDifference / 2,
      left: 0
    });
  } else {
    $image.css({
      top: 0,
      left: 0
    });
  }
}

function seconds_to_time(totalSeconds) {
  var $className = $('.contribution_time');
  var years = Math.floor(totalSeconds / (60 * 60 * 24 * 30 * 12));
  var remainingSeconds = totalSeconds - years * (60 * 60 * 24 * 30 * 12);

  var months = Math.floor(remainingSeconds / (60 * 60 * 24 * 30));
  remainingSeconds = remainingSeconds - months * (60 * 60 * 24 * 30);

  var days = Math.floor(remainingSeconds / (60 * 60 * 24));
  remainingSeconds = remainingSeconds - days * (60 * 60 * 24);

  var hours = Math.floor(remainingSeconds / (60 * 60));
  remainingSeconds = remainingSeconds - hours * (60 * 60);

  var minutes = Math.floor(remainingSeconds / 60);
  var seconds = remainingSeconds % 60;

  if (years > 0) {
    $className.text(years + "y " + months + "m " + days + "d " + hours + "h " + minutes + "m " + seconds + "s");
  } else if (years <= 0) {
    $className.text(months + "m " + days + "d " + hours + "h " + minutes + "m " + seconds + "s");
  } else if (months <= 0) {
    $className.text(days + "d " + hours + "h " + minutes + "m " + seconds + "s");
  } else if (days <= 0) {
    $className.text(hours + "h " + minutes + "m " + seconds + "s");
  } else if (minutes <= 0) {
    $className.text(seconds + "s");
  } else if (seconds <= 0) {
    $className.text(seconds + "s");
  }
}
