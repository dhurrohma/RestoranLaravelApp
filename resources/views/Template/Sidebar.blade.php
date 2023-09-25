<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('Image/logo.jpeg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Restoran</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('Image/profil.jpeg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            @if ($userRoles->contains(1) || $userRoles->contains(2))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('kios') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kios</p>
                </a>
              </li>
            </ul>
            @endif
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('data-menu') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Menu</p>
                </a>
              </li>
            </ul>
            @if ($userRoles->contains(1))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('data-role') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Role</p>
                </a>
              </li>
            </ul>
            @endif
            @if ($userRoles->contains(1))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('data-user') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data User</p>
                </a>
              </li>
            </ul>
            @endif
            @if ($userRoles->contains(1) || $userRoles->contains(2))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('trans-report') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Laporan Transaksi
                    @if ($count > 0)
                      <span class="badge badge-danger right">{{ $count }}</span>
                    @endif
                  </p>
                </a>
              </li>
            </ul>
            @endif
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('select-kios') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pesan Makan</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('order-history') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Pesananku
                    @if ($countOrder > 0)
                      <span class="badge badge-danger right">{{ $countOrder }}</span>
                    @endif
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li> -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>