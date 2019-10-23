@extends('admin.layouts.app')

@section('title', 'All '. ucwords(str_plural($routeType)))

@push('css')
  <style>
    .checkbox .asdh-label-color {
      color : black;
    }

    .panel .panel-body {
      height   : 200px;
      overflow : auto;
    }

    .panel .panel-body.asdh-panel-body {
      height   : auto;
      overflow : hidden;
    }

    .asdh-delete-menu span {
      color  : red;
      cursor : pointer;
    }
  </style>
  <style>
    .dd {
      position    : relative;
      display     : block;
      margin      : 0;
      padding     : 0;
      max-width   : 600px;
      list-style  : none;
      font-size   : 13px;
      line-height : 20px;
    }

    .dd-list {
      display    : block;
      position   : relative;
      margin     : 0;
      padding    : 0;
      list-style : none;
    }

    .dd-list .dd-list {
      padding-left : 30px;
    }

    .dd-collapsed .dd-list {
      display : none;
    }

    .dd-item,
    .dd-empty,
    .dd-placeholder {
      display     : block;
      position    : relative;
      margin      : 0;
      padding     : 0;
      min-height  : 20px;
      font-size   : 13px;
      line-height : 20px;
    }

    .dd-handle {
      display               : block;
      height                : 30px;
      margin                : 5px 0;
      padding               : 5px 10px;
      color                 : #333;
      text-decoration       : none;
      font-weight           : bold;
      border                : 1px solid #ccc;
      background            : #fafafa;
      background            : -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
      background            : -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
      background            : linear-gradient(top, #fafafa 0%, #eee 100%);
      -webkit-border-radius : 3px;
      border-radius         : 3px;
      box-sizing            : border-box;
      -moz-box-sizing       : border-box;
    }

    .dd-handle:hover {
      color      : #2ea8e5;
      background : #fff;
    }

    .dd-item > button {
      display     : block;
      position    : relative;
      cursor      : pointer;
      float       : left;
      width       : 25px;
      height      : 20px;
      margin      : 5px 0;
      padding     : 0;
      text-indent : 100%;
      white-space : nowrap;
      overflow    : hidden;
      border      : 0;
      background  : transparent;
      font-size   : 12px;
      line-height : 1;
      text-align  : center;
      font-weight : bold;
    }

    .dd-item > button:before {
      content     : '+';
      display     : block;
      position    : absolute;
      width       : 100%;
      text-align  : center;
      text-indent : 0;
    }

    .dd-item > button[data-action="collapse"]:before {
      content : '-';
    }

    .dd-placeholder,
    .dd-empty {
      margin          : 5px 0;
      padding         : 0;
      min-height      : 30px;
      background      : #f2fbff;
      border          : 1px dashed #b6bcbf;
      box-sizing      : border-box;
      -moz-box-sizing : border-box;
    }

    .dd-empty {
      border              : 1px dashed #bbb;
      min-height          : 100px;
      background-color    : #e5e5e5;
      background-image    : -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
      -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
      background-image    : -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
      -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
      background-image    : linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
      linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
      background-size     : 60px 60px;
      background-position : 0 0, 30px 30px;
    }

    .dd-dragel {
      position       : absolute;
      pointer-events : none;
      z-index        : 9999;
    }

    .dd-dragel > .dd-item .dd-handle {
      margin-top : 0;
    }

    .dd-dragel .dd-handle {
      -webkit-box-shadow : 2px 4px 6px 0 rgba(0, 0, 0, .1);
      box-shadow         : 2px 4px 6px 0 rgba(0, 0, 0, .1);
    }
  </style>
  <style>
    .dd3-content {
      display               : block;
      height                : 30px;
      margin                : 5px 0;
      padding               : 5px 10px 5px 40px;
      color                 : #333;
      text-decoration       : none;
      font-weight           : bold;
      border                : 1px solid #ccc;
      background            : #fafafa;
      background            : -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
      background            : -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
      background            : linear-gradient(top, #fafafa 0%, #eee 100%);
      -webkit-border-radius : 3px;
      border-radius         : 3px;
      box-sizing            : border-box;
      -moz-box-sizing       : border-box;
    }

    .dd3-content:hover {
      color      : #2ea8e5;
      background : #fff;
    }

    .dd-dragel > .dd3-item > .dd3-content {
      margin : 0;
    }

    .dd3-item > button {
      margin-left : 30px;
    }

    .dd3-handle {
      position                   : absolute;
      margin                     : 0;
      left                       : 0;
      top                        : 0;
      cursor                     : pointer;
      width                      : 30px;
      text-indent                : 100%;
      white-space                : nowrap;
      overflow                   : hidden;
      border                     : 1px solid #aaa;
      background                 : #ddd;
      background                 : -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
      background                 : -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
      background                 : linear-gradient(top, #ddd 0%, #bbb 100%);
      border-top-right-radius    : 0;
      border-bottom-right-radius : 0;
    }

    .dd3-handle:before {
      content     : '≡';
      display     : block;
      position    : absolute;
      left        : 0;
      top         : 3px;
      width       : 100%;
      text-align  : center;
      text-indent : 0;
      color       : #fff;
      font-size   : 20px;
      font-weight : normal;
    }

    .dd3-handle:hover {
      background : #ddd;
    }
  </style>
@endpush

@section('content')

  <div class="row">

    <div class="col-md-5">
      <div class="card">

        <div class="card-header card-header-text" data-background-color="green">
          <h4 class="card-title">Add Menus from the list below</h4>
        </div>

        <div class="card-content">
          <form action="{{ route('menu.store') }}" method="post">
            {{ csrf_field() }}
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

              {{--miscellaneous--}}
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <a role="button"
                     data-toggle="collapse"
                     data-parent="#accordion"
                     href="#miscellaneous"
                     aria-expanded="true"
                     aria-controls="collapseOne">
                    <h4 class="panel-title">Miscellaneous<i class="material-icons">keyboard_arrow_down</i></h4>
                  </a>
                </div>
                <div id="miscellaneous" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <div class="checkbox">
                      <label class="asdh-label-color">
                        <input type="checkbox"
                               name="menu_items[]"
                               value="About Us|||about-us" {{ check_if_menu_exists('about-us',$all_menus)?'checked':'' }}>
                        About Us
                      </label>
                    </div>
                    <div class="checkbox">
                      <label class="asdh-label-color">
                        <input type="checkbox"
                               name="menu_items[]"
                               value="Contact Us|||contact-us" {{ check_if_menu_exists('contact-us',$all_menus)?'checked':'' }}>
                        Contact Us
                      </label>
                    </div>
                    <div class="checkbox">
                      <label class="asdh-label-color">
                        <input type="checkbox"
                               name="menu_items[]"
                               value="All Posts|||posts" {{ check_if_menu_exists('posts',$all_menus)?'checked':'' }}>
                        All Posts
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              {{--categories--}}
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <a class="collapsed"
                     role="button"
                     data-toggle="collapse"
                     data-parent="#accordion"
                     href="#categories"
                     aria-expanded="false"
                     aria-controls="collapseTwo">
                    <h4 class="panel-title">Categories<i class="material-icons">keyboard_arrow_down</i></h4>
                  </a>
                </div>
                <div id="categories" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                    @foreach($categories as $category)
                      <div class="checkbox">
                        <label class="asdh-label-color">
                          <input type="checkbox"
                                 name="menu_items[]"
                                 {{ check_if_menu_exists('category/'.$category->slug,$all_menus)?'checked':'' }}
                                 value="{{ $category->name }}|||category/{{ $category->slug }}"> {{ $category->name }}
                        </label>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>

              {{--pages--}}
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <a class="collapsed"
                     role="button"
                     data-toggle="collapse"
                     data-parent="#accordion"
                     href="#menu-pages"
                     aria-expanded="false"
                     aria-controls="collapseThree">
                    <h4 class="panel-title">Pages<i class="material-icons">keyboard_arrow_down</i></h4>
                  </a>
                </div>
                <div id="menu-pages" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    @foreach($pages as $page)
                      <div class="checkbox">
                        <label class="asdh-label-color">
                          <input type="checkbox"
                                 name="menu_items[]"
                                 {{ check_if_menu_exists($page->slug, $all_menus)?'checked':'' }}
                                 value="{{ $page->title }}|||{{ $page->slug }}"> {{ $page->title }}
                        </label>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>

              {{--posts--}}
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFour">
                  <a class="collapsed"
                     role="button"
                     data-toggle="collapse"
                     data-parent="#accordion"
                     href="#menu-posts"
                     aria-expanded="false"
                     aria-controls="collapseThree">
                    <h4 class="panel-title">Posts<i class="material-icons">keyboard_arrow_down</i></h4>
                  </a>
                </div>
                <div id="menu-posts" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                  <div class="panel-body">
                    @foreach($posts as $post)
                      <div class="checkbox">
                        <label class="asdh-label-color">
                          <input type="checkbox"
                                 name="menu_items[]"
                                 {{ check_if_menu_exists($post->slug, $all_menus)?'checked':'' }}
                                 value="{{ $post->title }}|||{{ $post->slug }}"> {{ $post->title }}
                        </label>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>

              {{--custom--}}
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFive">
                  <a role="button"
                     data-toggle="collapse"
                     data-parent="#accordion"
                     href="#custom-menu"
                     aria-expanded="false"
                     aria-controls="collapseOne">
                    <h4 class="panel-title">Custom<i class="material-icons">keyboard_arrow_down</i></h4>
                  </a>
                </div>
                <div id="custom-menu" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                  <div class="panel-body">
                    {{--custom_menu--}}
                    <input type="text"
                           class="form-control"
                           placeholder="Enter menu name here"
                           name="custom_menu[]"/>
                    <input type="text"
                           class="form-control"
                           placeholder="Enter slug here"
                           name="custom_menu[]"/>
                    <span style="background:#555;color:#fff;padding:5px 7px;">{{ route('home') }}/{slug}</span>
                    {{--./custom_menu--}}
                  </div>
                </div>
              </div>
            </div>

            <div class="text-right">
              <button type="submit" class="btn btn-success btn-sm">Add to Menu</button>
            </div>
          </form>
        </div>

      </div>
    </div>

    <div class="col-md-7">
      <div class="card">

        <div class="card-header card-header-text" data-background-color="green">
          <h4 class="card-title">List of added Menus</h4>
        </div>

        <div class="card-content">

          <form action="{{ route('menu.change-order') }}" method="post" class="asdh-nestable">
            <div class="dd" id="nestable">
              <ol class="dd-list">
                @foreach($menus as $key=>$menu)
                  <li class="dd-item dd3-item" data-id="{{ $menu->id }}">
                    <div class="dd-handle dd3-handle"></div>
                    <div class="dd3-content">{{ $menu->label }}
                      <a href="#"
                         data-toggle="modal"
                         data-target="#change_menu_{{str_slug($menu->label).$menu->id}}"
                         style="position:absolute;right:10px;">Change</a>
                    </div>
                    @if($menu->has_sub_menus())
                      <ol class="dd-list">
                        @foreach($menu->sub_menus() as $sub_menu)
                          <li class="dd-item dd3-item" data-id="{{ $sub_menu->id }}">
                            <div class="dd-handle dd3-handle"></div>
                            <div class="dd3-content">{{ $sub_menu->label }}
                              <a href="#"
                                 data-toggle="modal"
                                 data-target="#change_menu_{{str_slug($sub_menu->label).$sub_menu->id}}"
                                 style="position:absolute;right:10px;">Change</a>
                            </div>
                          </li>
                        @endforeach
                      </ol>
                    @endif
                  </li>
                @endforeach
              </ol>
            </div>
            @if($menus->count())
              <button type="submit" class="btn btn-success btn-sm">Save Order</button>
            @endif
          </form>

          {{-- pop up --}}
          @foreach($menus as $key=>$menu)
            <div class="modal fade asdh-delete make-darker"
                 id="change_menu_{{str_slug($menu->label).$menu->id}}"
                 tabindex="-1"
                 role="dialog"
                 aria-labelledby="myModalLabel"
                 aria-hidden="true">
              <div class="modal-dialog">
                <form action="{{ route('menu.change-label', $menu) }}" method="post" class="modal-content">
                  {{csrf_field()}}
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>
                    <h4 class="modal-title">Change Menu Label</h4>
                  </div>
                  <div class="modal-body">
                    {{--label--}}
                    <div class="form-group">
                      <label for="label">{{ ucwords('label') }}
                        <small>*</small>
                      </label>
                      <input type="text"
                             class="form-control"
                             id="label"
                             name="label"
                             required="true"
                             value="{{ $menu->label }}"/>
                    </div>
                    {{--./label--}}
                  </div>
                  <div class="modal-footer">
                    <a href="#" type="submit"
                       class="btn btn-danger btn-sm asdh-delete-menu"
                       data-url="{{ route('menu.destroy',$menu) }}"
                       style="position:absolute;left:20px;bottom:0;">Delete Menu
                    </a>
                    <button type="submit"
                            class="btn btn-success btn-sm"
                            {{--data-dismiss="modal"--}}
                            style="position:absolute;right:20px;">Change
                    </button>
                  </div>
                </form>
              </div>
            </div>
            @foreach($menu->sub_menus() as $sub_menu)
              <div class="modal fade asdh-delete make-darker"
                   id="change_menu_{{str_slug($sub_menu->label).$sub_menu->id}}"
                   tabindex="-1"
                   role="dialog"
                   aria-labelledby="myModalLabel"
                   aria-hidden="true">
                <div class="modal-dialog">
                  <form action="{{ route('menu.change-label', $sub_menu) }}" method="post" class="modal-content">
                    {{csrf_field()}}
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                      </button>
                      <h4 class="modal-title">Change Menu Label</h4>
                    </div>
                    <div class="modal-body">
                      {{--label--}}
                      <div class="form-group">
                        <label for="label">{{ ucwords('label') }}
                          <small>*</small>
                        </label>
                        <input type="text"
                               class="form-control"
                               id="label"
                               name="label"
                               required="true"
                               value="{{ $sub_menu->label }}"/>
                      </div>
                      {{--./label--}}
                    </div>
                    <div class="modal-footer">
                      <a href="#" type="submit"
                         class="btn btn-danger btn-sm asdh-delete-menu"
                         data-url="{{ route('menu.destroy',$sub_menu) }}"
                         style="position:absolute;left:20px;bottom:0;">Delete Menu
                      </a>
                      <button type="submit"
                              class="btn btn-success btn-sm"
                              {{--data-dismiss="modal"--}}
                              style="position:absolute;right:20px;">Change
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            @endforeach
          @endforeach
        </div>

      </div>
    </div>

  </div>


@endsection

@push('script')
  <script src="{{ asset('public/plugins/nestable.js') }}"></script>
  <script>
    var serializedData;
    var $nestable = $('#nestable');
    var updateOutput = function (e) {
      var list = e.length ? e : $(e.target),
        output = list.data('output');
      if (window.JSON) {
        return window.JSON.stringify(list.nestable('serialize'));
      } else {
        return 'JSON browser support required for this demo.';
      }
    };
    // activate Nestable for list 1
    $nestable.nestable({
      group: 1,
      maxDepth: 2
    }).on('change', function () {
      serializedData = updateOutput($nestable.data('output', $('#nestable-output')));
    });
    // output initial serialised data
    serializedData = updateOutput($nestable.data('output', $('#nestable-output')));

    $('.asdh-nestable').submit(function (event) {
      event.preventDefault();
      $.ajax({
        type: 'post',

        url: @php echo "'". route('menu.change-order') ."'" @endphp,
        data: {serialized_data: serializedData},
        success: function (data) {
          alert(data.message);
//          console.log(data.message);
        }
      });
    });
  </script>

  <script>
    $(document).ready(function () {
      $('.asdh-delete-menu').on('click', function (e) {
        e.preventDefault();
        if (confirm('Are you sure?')) {
          window.location.href = $(this).data('url');
        }
      });
    });
  </script>
@endpush
