  <!--================ Admin Panel For Admin ===============-->
  @if (Auth::user()->role_id == 1)
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('admin.dashboard')}}" class="brand-link">
      <img src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('storage/user/' .Auth::user()->image)}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('admin.profile')}}" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!--  User Option -->
          <li class="nav-item has-treeview">
            <a href="{{route('admin.user')}}" class="nav-link">
              <i class="nav-icon fa fa-user"></i>
              <p>
                User Option
              </p>
            </a>
              </li>

          <hr class="sidebar-divider">

          <!--  Site Option -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class=" nav-icon fas fa-window-maximize"></i>
              <p>
                Site Option
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="website_title.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Title & Slogan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="social_link.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Social Media</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="copyright.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Copyright</p>
                </a>
              </li>
            </ul>
          </li>
          <!--  Category Option -->
          <li class="nav-item has-treeview">
            <a href="{{route('admin.category')}}" class="nav-link">
              <i class="nav-icon fas fa-list-ol"></i>
              <p>
                Category Option
              </p>
            </a>
          </li>
          <!--  Post Option -->
          <li class="nav-item has-treeview">
            <a href="{{route('admin.post')}}" class="nav-link">
              <i class=" nav-icon fas fa-th-list"></i>
              <p>
                Post Option
              </p>
            </a>
            </li>
          <!--  Post Option -->
          <li class="nav-item has-treeview">
            <a href="{{route('admin.comment')}}" class="nav-link">
              <i class=" nav-icon fas fa-th-list"></i>
              <p>
                Comments
              </p>
            </a>
            </li>
          <!--  Post Option -->
          <li class="nav-item has-treeview">
            <a href="{{route('admin.comment-reply')}}" class="nav-link">
              <i class=" nav-icon fas fa-th-list"></i>
              <p>
                Comment Replies
              </p>
            </a>
            </li>

          <hr class="sidebar-divider">

      </nav>
    </div>
  </aside>
  @else  

  <!--================== Regular User Admin Panel ====================-->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('user.dashboard')}}" class="brand-link">
      <img src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">User Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('storage/user/' .Auth::user()->image)}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('user.profile')}}" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!--  Post Option -->
          <li class="nav-item has-treeview">
            <a href="{{route('user.comment')}}" class="nav-link">
              <i class=" nav-icon fas fa-th-list"></i>
              <p>
                Comments
              </p>
            </a>
            </li>
          <!--  Comment Replies -->
          <li class="nav-item has-treeview">
            <a href="{{route('user.comment-reply')}}" class="nav-link">
              <i class=" nav-icon fas fa-th-list"></i>
              <p>
                Comment Replies
              </p>
            </a>
            </li>

          <hr class="sidebar-divider">
      </nav>
    </div>
  </aside>
    <!--================= Regular User Admin Panel =====================-->
  @endif

