<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="ti-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('sales.index') }}" class=" waves-effect">
                        <i class="ti-bolt"></i>
                        <span>Sales</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class=" waves-effect">
                        <i class="ti-tag"></i>
                        <span>Product</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}" class=" waves-effect">
                        <i class="ti-list"></i>
                        <span>Category</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
