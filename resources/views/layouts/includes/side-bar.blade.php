<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('admin/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-light">
            <span class="logo-lg">
                <img src="{{ asset('admin/assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('category*') ? 'active' : '' }}"
                        href="{{ route('category.index') }}" role="button" aria-expanded="false"
                        aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Danh mục</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('products*') ? 'active' : '' }}" href="#sidebarProduct"
                        data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProduct">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Sản phẩm</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::is('products*') ? 'show' : '' }}"
                        id="sidebarProduct">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('product_management.index') }}"
                                    class="nav-link {{ Request::is('products/product_management*') ? 'active' : '' }}"
                                    data-key="t-analytics">
                                    Quản lý Sản phẩm </a>
                            </li>
                            <li class="nav-item">

                                <a href="{{ route('product_size.index') }}"
                                    class="nav-link {{ Request::is('products/product_size*') ? 'active' : '' }}"
                                    data-key="t-analytics">
                                    Quản lý kích thước </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('product_color.index') }}"
                                    class="nav-link {{ Request::is('products/product_color*') ? 'active' : '' }}"
                                    data-key="t-analytics">
                                    Quản lý Màu sắc </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('user*') ? 'active' : '' }}" href="{{ route('user.index') }}"
                      role="button" aria-expanded="false" aria-controls="sidebarUser">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Người Dùng</span>
                    </a>
                </li>
             
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('order*') ? 'active' : '' }}"
                        href="{{ route('order.index') }}" role="button" aria-expanded="false"
                        aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Đơn hàng</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
