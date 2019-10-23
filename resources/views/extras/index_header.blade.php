<div class="card-header card-header-text" data-background-color="green">
  <h4 class="card-title">All <b>{{isset($custom_name)?str_plural(ucwords($custom_name)):str_plural(ucwords($routeType))}}</b></h4>
  {{--<p class="category">New employees on 15th September, 2016</p>--}}
</div>
{{--create new--}}
<a href="{{ route($routeType.'.create') }}" class="btn btn-success btn-round btn-xs create-new">
  <i class="material-icons">add_circle_outline</i> New {{isset($custom_name)?$custom_name:$routeType}}
</a>
