<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Send email to winners</title>
  <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <form action="{{ route('send-winner-email') }}"
            method="get"
            class="from-prevent-multiple-submit"
            id="TypeValidation">
        <div class="card">

          <div class="card-header card-header-text" data-background-color="green">
            <h4 class="card-title">Send email to winners.</h4>
          </div>

          <div class="card-content">

            {{--week_day--}}
            <div class="form-group">
              <label for="week_day">{{ ucwords('week day') }}
                <small>*</small>
              </label>
              <input type="number"
                     class="form-control"
                     id="week_day"
                     name="week_day"
                     required="true"
                     value="{{ old('week_day') }}"/>
            </div>
            {{--./week_day--}}

            {{--limit--}}
            <div class="form-group">
              <label for="limit">{{ ucwords('limit') }}
                <small>*</small>
              </label>
              <input type="number"
                     class="form-control"
                     id="limit"
                     name="limit"
                     required="true"
                     value="20"/>
            </div>
            {{--./limit--}}

            {{--submit--}}
            <div class="">
              <button type="submit"
                      class="btn btn-success btn-fill btn-prevent-multiple-submit">Send
              </button>
            </div>
            {{--./submit--}}

          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script>
  $(document).ready(function () {
    $('.from-prevent-multiple-submit').submit(function () {
      var $buttonToDisable = $('.btn-prevent-multiple-submit');
      $buttonToDisable.prop('disabled', true);
      $buttonToDisable.html('Sending...');
    });
  });
</script>
</body>
</html>