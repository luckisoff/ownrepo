@if(session('success_message'))
  <div class="alert alert-success stay" style="position:fixed;width:50%;top:20px;left:25%;z-index: 1000;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p>{{session('success_message')}}</p>
  </div>
@elseif(session('failure_message'))
  <div class="alert alert-warning stay" style="position:fixed;width:50%;top:20px;left:25%;z-index: 1000;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p>{{session('failure_message')}}</p>
  </div>
@endif

@if(count($errors))
  <div class="alert alert-danger stay" style="position:fixed;width:50%;top:20px;left:25%;z-index: 1000;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @foreach($errors->all() as $error)
      <p>{{$error}}</p>
    @endforeach
  </div>
@endif
