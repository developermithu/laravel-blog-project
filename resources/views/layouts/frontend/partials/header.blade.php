
    <header class="default-header">
      <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container px-3">
            <a class="navbar-brand" href="/">
              <img src="{{asset('frontend/img/logo.png')}}" alt="website-logo">
            </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="lnr lnr-menu"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent" >
                  <ul class="navbar-nav scrollable-menu">
                      <li><a href="/">Home</a></li>
                      <li><a href="/posts">Posts</a></li>
                      <li><a href="/categories">Categories</a></li>
                      <li><a href="/about">About</a></li>
                       
              @if (Route::has('login'))
                    @auth
                      <!-- Dropdown -->
                      <li class="dropdown">
                        <a href="#"  onclick="dropMenu()">
                            <i class="fa fa-user-circle"></i>&nbsp;
                        </a>
                        <div id="dropMenu" class="dropdown-menu menu1" style="display: none;">
                          @if (Auth::user()->role->id == 1)
                          <a href="{{route('admin.profile')}}" class="dropdown-item" target="_blank"><i class="fa fa-user-circle"></i>&nbsp; {{Auth::user()->name}}</a>
                          <a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fa fa-tv"></i>&nbsp; Dashboard</a>

                          @elseif(Auth::user()->role->id == 2)
                          <a class="dropdown-item" href="{{ route('user.dashboard') }}"><i class="fa fa-tv"></i>&nbsp; Dashboard</a>
                          @else
                          null
                          @endif     
                          <a class="dropdown-item" href="/admin/dashboard"><i class="fa fa-heart"></i>&nbsp; Favorite List</a>
                          <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                   <i class="fa fa-sign-out"></i>&nbsp; Logout
                             </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                        </div>
                    </li>
              @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endif
                @endauth
          @endif

                    <script>
                        function dropMenu(){
                        var dropmenu = document.getElementById('dropMenu');
                            if (dropmenu.style.display === "none") {
                                dropmenu.style.display = "block";
                            } else {
                                dropmenu.style.display = "none";
                            }
                            }
                    </script>
                  </ul>
                </div>
          </div>
      </nav>
  </header>