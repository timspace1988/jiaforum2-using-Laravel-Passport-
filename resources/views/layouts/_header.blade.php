<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top" >
  <div class="container">
    <!--Branding Image-->
    <a class="navbar-brand" href="{{ url('/') }}">
      JiaForum
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navBarSupportedContent" aria-controls="navBarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navBarSupportedContent">
      <!--Left side of navbar-->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ active_class(if_route('topics.index')) }}"><a href="{{ route('topics.index') }}" class="nav-link">Topics</a></li>
        <li class="nav-item {{ category_nav_active(1) }}"><a href="{{ route('categories.show', 1) }}" class="nav-link">Notes</a></li>
        <li class="nav-item {{ category_nav_active(2) }}"><a href="{{ route('categories.show', 2) }}" class="nav-link">Share</a></li>
        <li class="nav-item {{ category_nav_active(3) }}"><a href="{{ route('categories.show', 3) }}" class="nav-link">Tutorial</a></li>
        <li class="nav-item {{ category_nav_active(4) }}"><a href="{{ route('categories.show', 4) }}" class="nav-link">Blog</a></li>
      </ul>
      <!--Right side of navbar-->
      <ul class="navbar-nav navbar-right">
        <!--Authentication link-->
        @guest
        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Sign in</a></li>
        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Sign up</a></li>
        @else
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="ture" aria-expanded="false">
            <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px" height="30px">
            {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a href="{{ route('users.show', Auth::id()) }}" class="dropdown-item"><i class="far fa-user mr-2"></i>Account</a>
            <a href="{{ route('users.edit', Auth::id()) }}" class="dropdown-item"><i class="far fa-edit mr-2"></i>Edit Profile</a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" id="logout">
              <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Do you want to logout?')">
                {{ csrf_field()}}
                <button class="btn btn-block btn-danger" type="submit" name="button">Log Out</button>
              </form>
            </a>
          </div>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
