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
                    <a class="nav-link menu-link {{ Request::is('statistic*') ? 'active' : '' }}"
                        href="{{ route('statistic.index') }}" role="button" aria-expanded="false"
                        aria-controls="sidebarDashboards">
                        <i class="ri-bar-chart-box-line"></i> <span data-key="t-dashboards">Thống kê</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('category*') ? 'active' : '' }}"
                        href="{{ route('category.index') }}" role="button" aria-expanded="false"
                        aria-controls="sidebarDashboards">
                        <i class="ri-article-line"></i> <span data-key="t-dashboards">Danh mục</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('combo*') ? 'active' : '' }}"
                        href="{{ route('combo.index') }}" role="button" aria-expanded="false"
                        aria-controls="sidebarDashboards">
                        <i class="ri-links-line"></i> <span data-key="t-dashboards">Combo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('products*') ? 'active' : '' }}" href="#sidebarProduct"
                        data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProduct">
                        <i class="ri-record-circle-line"></i> <span data-key="t-dashboards">Sản phẩm</span>
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
                                    Quản lý Kích thước </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('product_color.index') }}"
                                    class="nav-link {{ Request::is('products/product_color*') ? 'active' : '' }}"
                                    data-key="t-analytics">
                                    Quản lý Màu sắc </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('product_tag.index') }}"
                                    class="nav-link {{ Request::is('products/product_tag*') ? 'active' : '' }}"
                                    data-key="t-analytics">
                                    Quản lý Loại đá và Chất liệu </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('user*') ? 'active' : '' }}" href="#sidebarUser"
                        data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUser">
                        <i class="ri-account-circle-line"> </i> <span data-key="t-dashboards">Người Dùng</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::is('user*') ? 'show' : '' }}" id="sidebarUser">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('user.index') }}"
                                    class="nav-link {{ Request::is('user/user*') ? 'active' : '' }}" data-key="t-analytics">
                                    Danh sách người dùng </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.index') }}"
                                    class="nav-link {{ Request::is('user/admin*') ? 'active' : '' }}" data-key="t-analytics">
                                    Quản trị </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('order*') ? 'active' : '' }}"
                        href="{{ route('order.index') }}" role="button" aria-expanded="false"
                        aria-controls="sidebarDashboards">
                        <i class="ri-bank-card-2-line"></i> <span data-key="t-dashboards">Đơn hàng</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('comment*') ? 'active' : '' }}"
                        href="{{ route('comment.index') }}" role="button" aria-expanded="false"
                        aria-controls="sidebarDashboards">
                        <i class="ri-chat-4-line"></i></i> <span data-key="t-dashboards">Bình luận</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('voucher*') ? 'active' : '' }}"
                        href="{{ route('voucher.index') }}" role="button" aria-expanded="false"
                        aria-controls="sidebarDashboards">
                        <i class="ri-percent-line"></i> <span data-key="t-dashboards">Ưu đãi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('ads_service*') ? 'active' : '' }}"
                        href="{{ route('ads_service.index') }}" role="button" aria-expanded="false"
                        aria-controls="sidebarDashboards">
                        <i class="ri-global-line"></i> <span data-key="t-dashboards">Dịch vụ quảng cáo</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
