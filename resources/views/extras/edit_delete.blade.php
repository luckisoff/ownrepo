<a href="{{ route($routeType.'.edit', $modal) }}" type="button" class="btn btn-success asdh-edit" title="Edit">
  <i class="material-icons">edit</i>
</a>
<button type="button"
        class="btn btn-danger asdh-delete"
        data-toggle="modal"
        data-target="#delete_popup_{{$routeType.$modal->id}}"
        title="Delete">
  <i class="material-icons">close</i>
</button>

<div class="modal fade asdh-delete make-darker"
     id="delete_popup_{{$routeType.$modal->id}}"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{route($routeType.'.destroy', $modal)}}" method="post" class="modal-content">
      {{csrf_field()}}
      {{method_field('DELETE')}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          <i class="material-icons">clear</i>
        </button>
        <h4 class="modal-title">Are you sure?</h4>
      </div>
      <div class="modal-body">
        <p>{{$message}}</p>
      </div>
      <div class="modal-footer text-center">
        <button type="submit" class="btn btn-danger">Yes Delete It</button>
        <button type="button" class="btn btn-success" data-dismiss="modal">No Don't Delete It</button>
      </div>
    </form>
  </div>
</div>