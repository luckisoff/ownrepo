<div class="form-group {{ isset($center)&&!$center?'':'text-center' }}">
  {{--<label for="image">Image</label>--}}
  <div class="fileinput fileinput-new text-center" data-provides="fileinput">
    <label class="fileinput-new thumbnail" for="{{ isset($image_name_field)?$image_name_field:'image' }}">
      <img src="{{ isset($input_image)?$input_image:material_dashboard_url('img/image_placeholder.png')}}"
           alt=""
           style="width:140px;height:140px;">
    </label>
    <div class="fileinput-preview fileinput-exists thumbnail"></div>
    <div>
      <span class="btn btn-rose btn-round btn-file asdh-btn-small">
          <span class="fileinput-new">Select {{ ucfirst($display_name??$image_name_field??'image') }}</span>
          <span class="fileinput-exists">Change</span>
          <input type="file"
                 id="{{ isset($image_name_field)?$image_name_field:'image' }}"
                 name="{{ isset($image_name_field)?$image_name_field:'image' }}"
                 accept="image/*"/>
      </span>
      <a href="#"
         class="btn btn-danger btn-round fileinput-exists asdh-btn-small"
         data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
    </div>
  </div>
</div>