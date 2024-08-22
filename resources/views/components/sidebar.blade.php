<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('sales.index') }}" class="waves-effect">
                        <i class="fa-solid fa-bolt-lightning"></i>
                        <span>Sales</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('products.index') }}" class="waves-effect">
                        <i class="fa-solid fa-tag"></i>
                        <span>Product</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('categories.index') }}" class="waves-effect">
                        <i class="fa-solid fa-list"></i>
                        <span>Category</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
