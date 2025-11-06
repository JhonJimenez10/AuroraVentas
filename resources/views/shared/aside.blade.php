<aside id="sidebar" class="sidebar shadow-sm">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @can('see-sales')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Ventas</span><i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('sales.new-sale') }}">
                            <i class="bi bi-circle"></i><span>Vender Producto</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sales.detail-sale') }}">
                            <i class="bi bi-circle"></i><span>Consultar Ventas</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('see-admin')
            <li class="nav-item">
                <a class="nav-link collapsed {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                    href="{{ route('categories.index') }}">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Categorías</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa-solid fa-box-open"></i>
                    <span>Productos</span><i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <ul id="products-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('products.index') }}">
                            <i class="bi bi-circle"></i><span>Administrar Productos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports_products.index') }}">
                            <i class="bi bi-circle"></i><span>Reportes Productos</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed {{ request()->routeIs('shopping.*') ? 'active' : '' }}"
                    href="{{ route('shopping.index') }}">
                    <i class="fa-solid fa-cart-arrow-down"></i>
                    <span>Compras</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed {{ request()->routeIs('customers.*') ? 'active' : '' }}"
                    href="{{ route('customers.index') }}">
                    <i class="fa-solid fa-user-group"></i>
                    <span>Clientes</span>
                </a>

            <li class="nav-item">
                <a class="nav-link collapsed {{ request()->routeIs('providers.*') ? 'active' : '' }}"
                    href="{{ route('providers.index') }}">
                    <i class="fa-solid fa-truck"></i>
                    <span>Proveedores</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed {{ request()->routeIs('users.*') ? 'active' : '' }}"
                    href="{{ route('users.index') }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>
        @endcan

    </ul>
</aside>

<style>
    /* --- Estilo base --- */
    .sidebar {
        background: #ffffff;
        border-right: 1px solid rgba(0, 0, 0, 0.05);
        min-height: 100vh;
        padding-top: 1rem;
        transition: all 0.3s ease;
    }

    .sidebar-nav .nav-item {
        margin-bottom: 0.4rem;
    }

    .sidebar-nav .nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        color: #374151;
        padding: 0.65rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.25s ease;
    }

    .sidebar-nav .nav-link i {
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    .sidebar-nav .nav-link:hover {
        background-color: #f3f4f6;
        color: #2563eb;
        transform: translateX(3px);
    }

    .sidebar-nav .nav-link.active {
        background-color: #e0e7ff;
        color: #1e40af;
        font-weight: 600;
    }

    /* --- Submenús animados --- */
    .nav-content.collapse {
        transition: all 0.35s ease;
    }

    .nav-content.collapsing {
        opacity: 0;
        transform: translateY(-5px);
    }

    .nav-content.collapse.show {
        opacity: 1;
        transform: translateY(0);
    }

    .nav-content a {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.45rem 1.5rem;
        color: #6b7280;
        transition: all 0.25s ease;
        border-radius: 0.4rem;
        position: relative;
    }

    .nav-content a::before {
        content: "";
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%) scaleY(0);
        width: 3px;
        height: 60%;
        background-color: #2563eb;
        border-radius: 3px;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .nav-content a:hover {
        background-color: #f9fafb;
        color: #2563eb;
        transform: translateX(4px);
    }

    .nav-content a:hover::before {
        opacity: 1;
        transform: translateY(-50%) scaleY(1);
    }

    .nav-content .bi-circle {
        font-size: 0.5rem;
    }

    .nav-link .bi-chevron-down {
        transition: transform 0.25s ease;
    }

    .nav-link[aria-expanded="true"] .bi-chevron-down {
        transform: rotate(-180deg);
    }
</style>
