<style>
  .backend-message {
    position : fixed;
    width    : 400px;
    top      : 3px;
    right    : 30px;
    z-index  : 9999;
    opacity  : 0.8;
  }
</style>

@if(session('success_message'))
  <div class="alert alert-success stay backend-message">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
      <span class="material-icons">clear</span></button>
    <p>{{session('success_message')}}</p>
  </div>
@elseif(session('failure_message'))
  <div class="alert alert-warning stay backend-message">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
      <span class="material-icons">clear</span></button>
    <p>{{session('failure_message')}}</p>
  </div>
@endif

@if(count($errors))
  <div class="alert stay alert-danger backend-message">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
      <span class="material-icons">clear</span></button>
    @foreach($errors->all() as $error)
      <p>{{$error}}</p>
    @endforeach
  </div>
@endif
