66<div class="sidebar"
     {{--data-active-color="blue"--}}
     data-background-color="black"
     data-image="{{material_dashboard_url('img/sidebar-3.jpg')}}">
  {{--<div class="logo">
    <a href="{{ route('admin_home') }}" class="simple-text logo-mini">
 6     <i class="material-icons">dashboard</i>
  6  </a>
    <a href="{{ route('admin_home') }}" class="simple-text logo-normal">
      {{$company->name}}
    </a>
  </div>--}}
  <div class="sidebar-wrapper">
    <div class="user">
      <div class="photo">
{{--        <img src="{{auth()->user()->image(34,34)}}"/>--}}
      </div>
      <div class="info">
        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
          <span>
              {{auth()->user()->name}}
            <b class="caret"></b>
          </span>
        </a>
        <div class="clearfix"></div>
        <div class="collapse @if(request()->is('admin/user/'.auth()->id().'/edit') || request()->is('admin/my-profile') || request()->is('admin/change-password')) in @endif"
             id="collapseExample">
          <ul class="nav">
            <li @if(request()->is('admin/my-profile')) class="active" @endif>
              <a href="{{ route('user.profile') }}">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">My Profile</span>
              </a>
            </li>
            <li @if(request()->is('admin/user/'.auth()->id().'/edit')) class="active" @endif>
              <a href="{{ route('user.edit', auth()->user()) }}">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">Edit Profile</span>
              </a>
            </li>
            <li @if(request()->is('admin/change-password')) class="active" @endif>
              <a href="{{ route('user.password.change') }}">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">Change Password</span>
              </a>
            </li>
            <li>
              <a href="{{ url('/logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">Logout</span>
              </a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <ul class="nav">
      {{--company--}}
      <li @if(request()->is('admin/company/'.$company->id.'/edit')) class="active" @endif>
        <a href="{{ route('company.edit',$company->id) }}">
          <i class="material-icons">account_balance</i>
          <p>Company</p>
        </a>
      </li>
      {{--./company--}}

      {{--notification--}}
      <li @if(request()->is('admin/notification*')) class="active" @endif>
        <a href="{{ route('notification.index') }}">
          <i class="material-icons">notifications</i>
          <p>{{ ucwords('notification') }}</p>
        </a>
      </li>
      {{--./notification--}}

      {{--select-user-from-registration--}}
      <li @if(request()->is('admin/select-user-from-registration')) class="active" @endif>
        <a href="{{ route('registration.selection') }}">
          <i class="material-icons">poll</i>
          <p>Select Participants</p>
        </a>
      </li>
      {{--./select-user-from-registration--}}

      {{--prize--}}
      {{--<li @if(request()->is('admin/prize*')) class="active" @endif>
        <a href="{{ route('prize.index') }}">
          <i class="material-icons">card_giftcard</i>
          <p>{{ ucwords('prize') }}</p>
        </a>
      </li>--}}
      {{--./prize--}}

      {{--menu--}}
      {{--<li @if(request()->is('admin/menu*')) class="active" @endif>
        <a href="{{ route('menu.index') }}">
          <i class="material-icons">menu</i>
          <p>Menu</p>
        </a>
      </li>--}}
      {{--./menu--}}

      {{--user--}}
      <li @if(request()->is('admin/user*')) class="active" @endif>
        <a data-toggle="collapse" href="#user">
          <i class="material-icons">person</i>
          <p>{{ ucfirst('user') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse @if(request()->is('admin/user*')) in @endif" id="user">
          <ul class="nav">
            <li @if(request()->is('admin/user')) class="active" @endif>
              <a href="{{ route('user.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                <!-- <i class="material-icons">spellcheck</i> -->
                <span class="sidebar-normal">All {{ ucfirst(str_plural('user')) }}</span>
              </a>
            </li>
            <li @if(request()->is('admin/user/create')) class="active" @endif>
              <a href="{{ route('user.create') }}">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">New {{ ucfirst('user') }}</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      {{--./user--}}

      {{--difficulty-level--}}
      <li @if(request()->is('admin/difficulty-level*')) class="active" @endif>
        <a data-toggle="collapse" href="#difficulty-level">
          <i class="material-icons">line_weight</i>
          <p>{{ ucfirst('difficulty level') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse @if(request()->is('admin/difficulty-level*')) in @endif" id="difficulty-level">
          <ul class="nav">
            <li @if(request()->is('admin/difficulty-level')) class="active" @endif>
              <a href="{{ route('difficulty-level.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">All {{ ucfirst(str_plural('difficulty level')) }}</span>
              </a>
            </li>
            <li @if(request()->is('admin/difficulty-level/create')) class="active" @endif>
              <a href="{{ route('difficulty-level.create') }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">add_circle_outline</i>--}}
                <span class="sidebar-normal">New {{ ucfirst('difficulty level') }}</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      {{--./difficulty-level--}}


      {{--question-set-collection--}}
      {{--<li @if(request()->is('admin/question-set-collection*')) class="active" @endif>
        <a data-toggle="collapse" href="#question-set-collection">
          <i class="material-icons">settings_ethernet</i>
          <p>{{ ucfirst('question set collection') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse @if(request()->is('admin/question-set-collection*')) in @endif"
             id="question-set-collection">
          <ul class="nav">
            <li @if(request()->is('admin/question-set-collection')) class="active" @endif>
              <a href="{{ route('question-set-collection.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">All {{ ucfirst(str_plural('question set collection')) }}</span>
              </a>
            </li>
            <li @if(request()->is('admin/question-set-collection/create')) class="active" @endif>
              <a href="{{ route('question-set-collection.create') }}">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">New {{ ucfirst('question set collection') }}</span>
              </a>
            </li>
          </ul>
        </div>
      </li>--}}
      {{--./question-set-collection--}}

      {{--sponsor--}}
      <li @if(request()->is('admin/sponsor*') || request()->has('sponsor_id') || request()->is('admin/question-set*') || request()->has('question_set_id')) class="active" @endif>
        <a data-toggle="collapse" href="#sponsor">
          <i class="material-icons">nfc</i>
          <p>{{ ucfirst('Live Quizzes') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse @if(request()->is('admin/sponsor*') || request()->has('sponsor_id') || request()->is('admin/question-set*') || request()->has('question_set_id')) in @endif" id="sponsor">
          <ul class="nav">
            <li @if(request()->is('admin/sponsor')) class="active" @endif>
              <a href="{{ route('sponsor.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">Sponsors</span>
              </a>
            </li>

            <li @if(request()->is('admin/question-set')) class="active" @endif>
              <a href="{{ route('question-set.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">Live Quiz</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      {{--./sponsor--}}

      {{--category--}}
      <li @if(request()->is('admin/category*')) class="active" @endif>
        <a data-toggle="collapse" href="#category">
          <i class="material-icons">layers</i>
          <p>{{ ucfirst('category') }}<b class="caret"></b></p>
        </a>
        <div class="collapse @if(request()->is('admin/category*')) in @endif" id="category">
          <ul class="nav">
            <li @if(request()->is('admin/category')) class="active" @endif>
              <a href="{{ route('category.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">All {{ ucfirst(str_plural('category')) }}</span>
              </a>
            </li>
            <li @if(request()->is('admin/category/create')) class="active" @endif>
              <a href="{{ route('category.create') }}">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">New {{ ucfirst('category') }}</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      {{--./category--}}


      {{--question--}}
      <li @if((request()->is('admin/question')||request()->is('admin/question/*')) && (!request()->has('question_set_id') && !request()->has('sponsor_id'))) class="active" @endif>
        <a data-toggle="collapse" href="#question">
          <i class="material-icons">adjust</i>
          <p>{{ ucfirst('question') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse @if((request()->is('admin/question')||request()->is('admin/question/*') || request()->is('admin/question-type/*')) && (!request()->has('question_set_id') && !request()->has('sponsor_id')))) in @endif"
             id="question">
          <ul class="nav">

            <li @if(request()->is('admin/question-type*')) class="active" @endif>
              <a href="{{ route('question-type.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">All {{ ucfirst(str_plural('Question type')) }}</span>
              </a>
            </li>
            
              <li @if(request()->is('admin/setquestion')) class="active" @endif>
                  <a href="{{ route('setquestion.index') }}">
                    <span class="sidebar-mini">&nbsp;</span>
                    {{--<i class="material-icons">spellcheck</i>--}}
                    <span class="sidebar-normal">All {{ ucfirst(str_plural('set question')) }}</span>
                  </a>
                </li>

                

            <li @if(request()->is('admin/question')) class="active" @endif>
              <a href="{{ route('question.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">All {{ ucfirst(str_plural('question')) }}</span>
              </a>
            </li>
            <li @if(request()->is('admin/question/create') && !request()->has('sponsor_id')) class="active" @endif>
              <a href="{{ route('question.create') }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">add_circle_outline</i>--}}
                <span class="sidebar-normal">New {{ ucfirst('question') }}</span>
              </a>
            </li>

            <li @if(request()->is('admin/question/excel-upload')) class="active" @endif>
              <a href="{{ route('question.upload-excel') }}">
                <span class="sidebar-mini">&nbsp;</span>
                <span class="sidebar-normal">{{ ucfirst('excel upload') }}</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      {{--./question--}}


      {{--f-question--}}
      <li @if(request()->is('admin/f-question*')) class="active" @endif>
        <a data-toggle="collapse" href="#f-question">
          <i class="material-icons">nfc</i>
          <p>Fastest Finger First
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse @if(request()->is('admin/f-question*')) in @endif" id="f-question">
          <ul class="nav">
            <li @if(request()->is('admin/f-question')) class="active" @endif>
              <a href="{{ route('f-question.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">All Questions</span>
              </a>
            </li>
            <li @if(request()->is('admin/f-question/create')) class="active" @endif>
              <a href="{{ route('f-question.create') }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">add_circle_outline</i>--}}
                <span class="sidebar-normal">New Question</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      {{--./f-question--}}


      {{--advertisement--}}
      <li @if(request()->is('admin/advertisement')) class="active" @endif>
        <a data-toggle="collapse" href="#advertisement">
          <i class="material-icons">developer_board</i>
          <p>{{ ucfirst('advertisement') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse @if(request()->is('admin/advertisement')) in @endif" id="advertisement">
          <ul class="nav">
            <li @if(request()->fullUrl()===url('admin/advertisement?category=0')) class="active" @endif>
              <a href="{{ route('top-banner.create', ['category' => 0]) }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">Top Banner</span>
              </a>
            </li>

            <li @if(request()->fullUrl()===url('admin/advertisement?category=1')) class="active" @endif>
              <a href="{{ route('top-banner.create', ['category' => 1]) }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">Leaderboard</span>
              </a>
            </li>

            <li @if(request()->fullUrl()===url('admin/advertisement?category=2')) class="active" @endif>
              <a href="{{ route('top-banner.create', ['category' => 2]) }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">Fastest Finger First</span>
              </a>
            </li>

            <li @if(request()->fullUrl()===url('admin/advertisement?category=3')) class="active" @endif>
              <a href="{{ route('top-banner.create', ['category' => 3]) }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">Registration</span>
              </a>
            </li>

            <li @if(request()->fullUrl()===url('admin/advertisement?category=4')) class="active" @endif>
              <a href="{{ route('top-banner.create', ['category' => 4]) }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">News</span>
              </a>
            </li>

            <li @if(request()->fullUrl()===url('admin/advertisement?category=5')) class="active" @endif>
              <a href="{{ route('top-banner.create', ['category' => 5]) }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">Sponsor</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      {{--./question--}}

      {{--news-feed--}}
      <li @if(request()->is('admin/news-feed*')) class="active" @endif>
        <a data-toggle="collapse" href="#news-feed">
          <i class="material-icons">nfc</i>
          <p>{{ ucfirst('news feed') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse @if(request()->is('admin/news-feed*')) in @endif" id="news-feed">
          <ul class="nav">
            <li @if(request()->is('admin/news-feed*')&&request()->query('type')===null) class="active" @endif>
              <a href="{{ route('news-feed.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">spellcheck</i>--}}
                <span class="sidebar-normal">All {{ ucfirst(str_plural('news')) }}</span>
              </a>
            </li>
            <li @if(request()->is('admin/news-feed*')&&request()->query('type')==='video') class="active" @endif>
              <a href="{{ route('news-feed.index',['type'=>'video']) }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">add_circle_outline</i>--}}
                <span class="sidebar-normal">All {{ ucfirst('videos') }}</span>
              </a>
            </li>
            <li @if(request()->is('admin/news-feed*')&&request()->query('type')==='gallery') class="active" @endif>
              <a href="{{ route('news-feed.index',['type'=>'gallery']) }}">
                <span class="sidebar-mini">&nbsp;</span>
                {{--<i class="material-icons">add_circle_outline</i>--}}
                <span class="sidebar-normal">All {{ ucfirst('galleries') }}</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      {{--./news-feed--}}


      {{--page--}}
      {{--<li @if(request()->is('admin/page*')) class="active" @endif>
        <a data-toggle="collapse" href="#page">
          <i class="material-icons">note_add</i>
          <p>{{ ucfirst('page') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse @if(request()->is('admin/page*')) in @endif" id="page">
          <ul class="nav">
            <li @if(request()->is('admin/page')) class="active" @endif>
              <a href="{{ route('page.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                --}}{{--<i class="material-icons">spellcheck</i>--}}{{--
                <span class="sidebar-normal">All {{ ucfirst(str_plural('page')) }}</span>
              </a>
            </li>
            <li @if(request()->is('admin/page/create')) class="active" @endif>
              <a href="{{ route('page.create') }}">
                <span class="sidebar-mini">&nbsp;</span>
                --}}{{--<i class="material-icons">add_circle_outline</i>--}}{{--
                <span class="sidebar-normal">New {{ ucfirst('page') }}</span>
              </a>
            </li>
          </ul>
        </div>
      </li>--}}
      {{--./page--}}


      {{--post--}}
      {{--<li @if(request()->is('admin/post*')) class="active" @endif>
        <a data-toggle="collapse" href="#post">
          <i class="material-icons">library_books</i>
          <p>Post
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse @if(request()->is('admin/post*')) in @endif" id="post">
          <ul class="nav">
            <li @if(request()->is('admin/post')) class="active" @endif>
              <a href="{{ route('post.index') }}">
                <span class="sidebar-mini">&nbsp;</span>
                --}}{{--<i class="material-icons">spellcheck</i>--}}{{--
                <span class="sidebar-normal">All Posts</span>
              </a>
            </li>
            <li @if(request()->is('admin/post/create')) class="active" @endif>
              <a href="{{ route('post.create') }}">
                <span class="sidebar-mini">&nbsp;</span>
                --}}{{--<i class="material-icons">add_circle_outline</i>--}}{{--
                <span class="sidebar-normal">New Post</span>
              </a>
            </li>
          </ul>
        </div>
      </li>--}}
      {{--./post--}}


      {{--subscriber--}}
      {{--<li @if(request()->is('admin/subscribers')) class="active" @endif>
        <a href="{{ route('admin.subscriber') }}">
          <i class="material-icons">people_outline</i>
          <p>Subscribers</p>
        </a>
      </li>--}}
      {{--./subscriber--}}

    </ul>
  </div>
</div>
