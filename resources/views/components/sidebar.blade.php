<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"><Strong style="font-family: 'Times New Roman', Times, serif; font-size: 16px;"
                    class="text-warning">E</Strong>-Klinik</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">E-K</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown">
                <a href="{{ url('admin/dashboard') }}" class="nav-link"><i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li
                class="dropdown {{ request()->is(['admin/management-users', 'admin/management-doctors']) ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown {{ request()->is(['admin/management-users', 'admin/management-doctors']) ? 'show' : '' }}"
                    data-toggle="dropdown"
                    aria-expanded="{{ request()->is(['admin/management-users', 'admin/management-doctors']) ? 'true' : 'false' }}">
                    <i class="fas fa-folder"></i> <span>Master Data</span>
                </a>
                <ul class="dropdown-menu" style="">
                    <li class="{{ request()->is('admin/management-users') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('managementUser') }}"><i class="fas fa-users"></i> User</a>
                    </li>
                </ul>
                <ul class="dropdown-menu" style="">
                    <li class="{{ request()->is('admin/management-doctors') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('managementDoctor') }}"><i class="fa-solid fa-suitcase-medical"></i> Dokter</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
