<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="text-center bg-red">
        <span class="brand-link" id="time-node"></span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('vendor/admin-lte/dist/img/avatar2.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-header"><i class="nav-icon fas fa-folder-open"></i> ORDERS</li>
                <li class="nav-item">
                    <a href="{{ route('admin.order-tables.index') }}" class="nav-link @if(Route::is('admin.order-tables*')) active @endif">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Order tables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.order-products.index') }}" class="nav-link @if(Route::is('admin.order-products*')) active @endif">
                        <i class="fas fa-glass-martini nav-icon"></i>
                        <p>Order products</p>
                    </a>
                </li>

                <li class="nav-header"><i class="nav-icon fas fa-boxes"></i> PRODUCTS</li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link @if(Route::is('admin.categories*')) active @endif">
                        <i class="fas fa-box nav-icon"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link @if(Route::is('admin.products*')) active @endif">
                        <i class="fas fa-archive nav-icon"></i>
                        <p>Products</p>
                    </a>
                </li>

                @if (auth()->user()->isAdmin())

                <li class="nav-header"><i class="nav-icon fas fa-reply"></i> ORDERS REPORTS</li>
                <li class="nav-item">
                    <a href="{{ route('admin.reports-table.index') }}" class="nav-link @if(Route::is('admin.reports-table.*')) active @endif">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Table reports</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reports-products.index') }}" class="nav-link @if(Route::is('admin.reports-products*')) active @endif">
                        <i class="fas fa-glass-martini nav-icon"></i>
                        <p>Product reports</p>
                    </a>
                </li>

                <li class="nav-header"><i class="nav-icon fas fa-cog"></i>  SETTINGS</li>
                <li class="nav-item">
                    <a href="{{ route('admin.hall-groups.index') }}" class="nav-link @if(Route::is('admin.hall-groups*')) active @endif">
                        <i class="far fa-map nav-icon"></i>
                        <p>Hall Groups</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.tables.index') }}" class="nav-link @if(Route::is('admin.tables*')) active @endif">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Tables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.rates.index') }}" class="nav-link @if(Route::is('admin.rates*')) active @endif">
                        <i class="fas fa-percentage nav-icon"></i>
                        <p>Rates</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
