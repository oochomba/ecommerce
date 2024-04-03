  <!-- Navbar -->
  @php
      $usr = Auth::guard('admin')->user();
  @endphp
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ url('') }}" target="_blank" class="nav-link">View Website</a>
          </li>
      </ul>

      <!-- SEARCH FORM -->
      <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                      <i class="fa fa-search"></i>
                  </button>
              </div>
          </div>
      </form>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="fa fa-comments"></i>
                  <span class="badge badge-danger navbar-badge">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <a href="#" class="dropdown-item">
                      <!-- Message Start -->
                      <div class="media">
                          <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                          <div class="media-body">
                              <h3 class="dropdown-item-title">
                                  Brad Diesel
                                  <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                              </h3>
                              <p class="text-sm">Call me whenever you can...</p>
                              <p class="text-sm text-muted"><i class="fa fa-clock mr-1"></i> 4 Hours Ago</p>
                          </div>
                      </div>
                      <!-- Message End -->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <!-- Message Start -->
                      <div class="media">
                          <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                          <div class="media-body">
                              <h3 class="dropdown-item-title">
                                  John Pierce
                                  <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                              </h3>
                              <p class="text-sm">I got your message bro</p>
                              <p class="text-sm text-muted"><i class="fa fa-clock mr-1"></i> 4 Hours Ago</p>
                          </div>
                      </div>
                      <!-- Message End -->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <!-- Message Start -->
                      <div class="media">
                          <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                          <div class="media-body">
                              <h3 class="dropdown-item-title">
                                  Nora Silvester
                                  <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                              </h3>
                              <p class="text-sm">The subject goes here</p>
                              <p class="text-sm text-muted"><i class="fa fa-clock mr-1"></i> 4 Hours Ago</p>
                          </div>
                      </div>
                      <!-- Message End -->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
          </li>
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="fa fa-bell"></i>
                  <span class="badge badge-warning navbar-badge">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <span class="dropdown-item dropdown-header">15 Notifications</span>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fa fa-envelope mr-2"></i> 4 new messages
                      <span class="float-right text-muted text-sm">3 mins</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fa fa-users mr-2"></i> 8 friend requests
                      <span class="float-right text-muted text-sm">12 hours</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fa fa-file mr-2"></i> 3 new reports
                      <span class="float-right text-muted text-sm">2 days</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
              </div>
          </li>

      </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src="{{ url('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Ecommerce</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ url('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                      alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">{{ ucwords(Auth::user()->name) }}</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  @if ($usr->can('dashboard.view'))
                      <li class="nav-item">
                          <a href="{{ url('admin/dashboard') }}"
                              class="nav-link {{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
                              <i class="nav-icon fa fa-tachometer"></i>
                              <p> Dashboard </p>
                          </a>
                      </li>
                  @endif

                  @if ($usr->can('admin.view') || $usr->can('admin.create') || $usr->can('admin.edit') || $usr->can('admin.delete'))
                      <li class="nav-item has-treeview {{ Request::segment(2) == 'admin' ? 'menu-open' : '' }}">
                          <a href="#" class="nav-link {{ Request::segment(2) == 'admin' ? 'active' : '' }}">
                              <i class="nav-icon fa fa-users"></i>
                              <p>
                                  Admins
                                  <i class="fa fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if ($usr->can('admin.view'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/admin/list') }}"
                                          class="nav-link {{ Request::segment(2) == 'admin' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>System Admins</p>
                                      </a>
                                  </li>
                              @endif
                              @if ($usr->can('admin.create'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/admin/add') }}"
                                          class="nav-link {{ Request::segment(2) == 'admin' && Request::segment(3) == 'add' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Add Admin</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif

                  @if ($usr->can('role.view') || $usr->can('role.create') || $usr->can('role.eidt') || $usr->can('role.delete'))
                      <li class="nav-item has-treeview {{ Request::segment(2) == 'roles' ? 'menu-open' : '' }}">
                          <a href="#" class="nav-link {{ Request::segment(2) == 'roles' ? 'active' : '' }}">
                              <i class="nav-icon fa fa-users"></i>
                              <p>
                                  Roles & Permissions
                                  <i class="fa fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if ($usr->can('role.view'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/roles') }}"
                                          class="nav-link {{ Request::segment(2) == 'roles' && Request::segment(3) == '' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>All Roles</p>
                                      </a>
                                  </li>
                              @endif
                              @if ($usr->can('role.view'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/roles/add') }}"
                                          class="nav-link {{ Request::segment(2) == 'roles' && Request::segment(3) == 'add' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Create Role</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif

                  @if (
                      $usr->can('category.view') ||
                          $usr->can('category.create') ||
                          $usr->can('category.eidt') ||
                          $usr->can('category.delete'))
                      <li class="nav-item has-treeview {{ Request::segment(2) == 'category' ? 'menu-open' : '' }}">
                          <a href="#" class="nav-link {{ Request::segment(2) == 'category' ? 'active' : '' }}">
                              <i class="nav-icon fa fa-list"></i>
                              <p>
                                  Category
                                  <i class="fa fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if ($usr->can('category.view'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/category/list') }}"
                                          class="nav-link {{ Request::segment(2) == 'category' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Categories List</p>
                                      </a>
                                  </li>
                              @endif
                              @if ($usr->can('category.create'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/category/add') }}"
                                          class="nav-link {{ Request::segment(2) == 'category' && Request::segment(3) == 'add' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Add Category</p>
                                      </a>
                                  </li>
                              @endif

                          </ul>
                      </li>
                  @endif

                  @if (
                      $usr->can('subCategory.view') ||
                          $usr->can('subCategory.create') ||
                          $usr->can('subCategory.eidt') ||
                          $usr->can('subCategory.delete'))
                      <li
                          class="nav-item has-treeview {{ Request::segment(2) == 'sub_category' ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ Request::segment(2) == 'sub_category' ? 'active' : '' }}">
                              <i class="nav-icon fa fa-list"></i>
                              <p>
                                  Sub Category
                                  <i class="fa fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if ($usr->can('subCategory.view'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/sub_category/list') }}"
                                          class="nav-link {{ Request::segment(2) == 'sub_category' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Sub Categories List</p>
                                      </a>
                                  </li>
                              @endif

                              @if ($usr->can('subCategory.create'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/sub_category/add') }}"
                                          class="nav-link {{ Request::segment(2) == 'sub_category' && Request::segment(3) == 'add' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Add Sub Category</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif



                  @if (
                      $usr->can('subSubCategory.view') ||
                          $usr->can('subSubCategory.create') ||
                          $usr->can('subSubCategory.eidt') ||
                          $usr->can('subSubCategory.delete'))
                      <li
                          class="nav-item has-treeview {{ Request::segment(2) == 'sub_SubCategory' ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ Request::segment(2) == 'sub_SubCategory' ? 'active' : '' }}">
                              <i class="nav-icon fa fa-list"></i>
                              <p>
                                  Sub Sub-Category
                                  <i class="fa fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if ($usr->can('subSubCategory.view'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/sub_SubCategory/list') }}"
                                          class="nav-link {{ Request::segment(2) == 'sub_SubCategory' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Sub Sub-Categories List</p>
                                      </a>
                                  </li>
                              @endif

                              @if ($usr->can('subSubCategory.create'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/sub_SubCategory/add') }}"
                                          class="nav-link {{ Request::segment(2) == 'sub_SubCategory' && Request::segment(3) == 'add' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Add Sub Sub-Category</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif



                  @if (
                      $usr->can('product.view') ||
                          $usr->can('product.create') ||
                          $usr->can('product.eidt') ||
                          $usr->can('product.delete'))
                      <li class="nav-item has-treeview {{ Request::segment(2) == 'product' ? 'menu-open' : '' }}">
                          <a href="#" class="nav-link {{ Request::segment(2) == 'product' ? 'active' : '' }}">
                              <i class="nav-icon fa fa-list"></i>
                              <p>
                                  Product
                                  <i class="fa fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if ($usr->can('product.view'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/product/list') }}"
                                          class="nav-link {{ Request::segment(2) == 'product' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Product List</p>
                                      </a>
                                  </li>
                              @endif
                              @if ($usr->can('product.create'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/product/add') }}"
                                          class="nav-link {{ Request::segment(2) == 'product' && Request::segment(3) == 'add' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Add Product</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif

                  @if ($usr->can('brand.view') || $usr->can('brand.create') || $usr->can('brand.eidt') || $usr->can('brand.delete'))
                      <li class="nav-item has-treeview {{ Request::segment(2) == 'brand' ? 'menu-open' : '' }}">
                          <a href="#" class="nav-link {{ Request::segment(2) == 'brand' ? 'active' : '' }}">
                              <i class="nav-icon fa fa-list"></i>
                              <p>
                                  Brand
                                  <i class="fa fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if ($usr->can('brand.view'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/brand/list') }}"
                                          class="nav-link {{ Request::segment(2) == 'brand' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Brand List</p>
                                      </a>
                                  </li>
                              @endif
                              @if ($usr->can('brand.create'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/brand/add') }}"
                                          class="nav-link {{ Request::segment(2) == 'brand' && Request::segment(3) == 'add' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Add Brand</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif


                  @if ($usr->can('color.view') || $usr->can('color.create') || $usr->can('color.eidt') || $usr->can('color.delete'))
                      <li class="nav-item has-treeview {{ Request::segment(2) == 'color' ? 'menu-open' : '' }}">
                          <a href="#" class="nav-link {{ Request::segment(2) == 'color' ? 'active' : '' }}">
                              <i class="nav-icon fa fa-list"></i>
                              <p>
                                  Color
                                  <i class="fa fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if ($usr->can('color.view'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/color/list') }}"
                                          class="nav-link {{ Request::segment(2) == 'color' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Color List</p>
                                      </a>
                                  </li>
                              @endif
                              @if ($usr->can('color.create'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/color/add') }}"
                                          class="nav-link {{ Request::segment(2) == 'color' && Request::segment(3) == 'add' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Add Color</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif


                  @if (
                      $usr->can('discountCode.view') ||
                          $usr->can('discountCode.create') ||
                          $usr->can('discountCode.eidt') ||
                          $usr->can('discountCode.delete'))
                      <li
                          class="nav-item has-treeview {{ Request::segment(2) == 'discountcode' ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ Request::segment(2) == 'discountcode' ? 'active' : '' }}">
                              <i class="nav-icon fa fa-list"></i>
                              <p>
                                  Discount Code
                                  <i class="fa fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if ($usr->can('discountCode.view'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/discountcode/list') }}"
                                          class="nav-link {{ Request::segment(2) == 'discountcode' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Discount Code List</p>
                                      </a>
                                  </li>
                              @endif
                              @if ($usr->can('discountCode.create'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/discountcode/add') }}"
                                          class="nav-link {{ Request::segment(2) == 'discountcode' && Request::segment(3) == 'add' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Add Discount Code</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif


                  @if (
                      $usr->can('shippingCharge.view') ||
                          $usr->can('shippingCharge.create') ||
                          $usr->can('shippingCharge.eidt') ||
                          $usr->can('shippingCharge.delete'))
                      <li
                          class="nav-item has-treeview {{ Request::segment(2) == 'shippingcharge' ? 'menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ Request::segment(2) == 'shippingcharge' ? 'active' : '' }}">
                              <i class="nav-icon fa fa-list"></i>
                              <p>
                                  Shipping Charge
                                  <i class="fa fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if ($usr->can('shippingCharge.view'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/shippingcharge/list') }}"
                                          class="nav-link {{ Request::segment(2) == 'shippingcharge' && Request::segment(3) == 'list' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Shipping Charge List</p>
                                      </a>
                                  </li>
                              @endif
                              @if ($usr->can('shippingCharge.create'))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/shippingcharge/add') }}"
                                          class="nav-link {{ Request::segment(2) == 'shippingcharge' && Request::segment(3) == 'add' ? 'active' : '' }}">
                                          <i class="fa fa-circle nav-icon"></i>
                                          <p>Add Shipping Charge</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif

                  <li class="nav-item">
                      <a href="{{ url('admin/customer-contacts') }}" class="nav-link">
                          <i class="nav-icon fa fa-user"></i>
                          <p>
                              Customer Contacts
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ url('admin/logout') }}" class="nav-link">
                          <i class="nav-icon fa fa-user"></i>
                          <p>
                              Logout
                          </p>
                      </a>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
