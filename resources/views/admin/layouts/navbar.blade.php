<nav class="navbar theme-color-background navbar-absolute">
  <div class="container-fluid">
    <div class="navbar-minimize">
      <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
        <i class="material-icons visible-on-sidebar-regular">more_vert</i>
        <i class="material-icons visible-on-sidebar-mini">view_list</i>
      </button>
    </div>
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href={{ route('admin_home') }}> {{ $company->name }} </a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <!--
        <li class="dropdown hidden-xs">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="material-icons">notifications</i>
            <span class="notification">5</span>
            <p class="hidden-lg hidden-md">
              Notifications
              <b class="caret"></b>
            </p>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a href="#">Mike John responded to your email</a>
            </li>
            <li>
              <a href="#">You have 5 new tasks</a>
            </li>
            <li>
              <a href="#">You're now friend with Andrew</a>
            </li>
            <li>
              <a href="#">Another Notification</a>
            </li>
            <li>
              <a href="#">Another One</a>
            </li>
          </ul>
        </li>
        -->
        <li class="dropdown hidden-xs">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="material-icons">person</i>
            <p class="hidden-lg hidden-md">
              Notifications
              <b class="caret"></b>
            </p>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a href="{{ route('user.profile') }}">My Profile</a>
            </li>
            <li>
              <a href="{{ route('user.password.change') }}">Change Password</a>
            </li>
            <li>
              <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </li>
          </ul>
        </li>
        <li class="separator hidden-lg hidden-md hidden-xs"></li>
      </ul>
      <form class="navbar-form navbar-right hidden-xs" role="search" style="display: none;">
        <div class="form-group form-search is-empty">
          <input type="text" class="form-control" placeholder="Search">
          <span class="material-input"></span>
        </div>
        <button type="submit" class="btn btn-white btn-round btn-just-icon">
          <i class="material-icons">search</i>
          <div class="ripple-container"></div>
        </button>
      </form>
    </div>
  </div>
</nav>