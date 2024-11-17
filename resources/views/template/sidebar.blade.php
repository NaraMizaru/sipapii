<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <h3>{{ env('APP_NAME') }}</h3>
                </div>

                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Dashboard</li>

                <li class="sidebar-item {{ @$menu_type == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Pengelolaan</li>

                <li class="sidebar-item {{ @$menu_type == 'pengelolaan-kelas' ? 'active' : '' }}">
                    <a href="{{ route('admin.pengelolaan.kelas') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Kelola Kelas</span>
                    </a>
                </li>

                <li class="sidebar-item {{ @$menu_type == 'pengelolaan-instansi' ? 'active' : '' }}">
                    <a href="{{ route('admin.pengelolaan.instansi') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Kelola Instansi</span>
                    </a>
                </li>

                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                        <span>Siswa</span>
                    </a>

                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="table-datatable.html" class="submenu-link">Akun Siswa</a>
                        </li>

                        <li class="submenu-item">
                            <a href="table-datatable-jquery.html" class="submenu-link">Nilai Siswa</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
