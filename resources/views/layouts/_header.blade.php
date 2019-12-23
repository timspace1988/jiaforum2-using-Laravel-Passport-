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
      <ul class="navbar-nav mr-auto"></ul>
      <!--Right side of navbar-->
      <ul class="navbar-nav navbar-right">
        <!--Authentication link-->
        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Sign in</a></li>
        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Sign up</a></li>
      </ul>
    </div>
  </div>
</nav>
