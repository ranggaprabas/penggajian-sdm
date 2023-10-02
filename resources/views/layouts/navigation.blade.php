<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('admin.profile.show') }}" class="d-block">{{ Auth::user()->nama }}</a>
        </div>
    </div>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @if (auth()->user()->is_admin)
                <li class="nav-item {{ Route::is('admin.home') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.home') }}" class="nav-link {{ Route::is('admin.home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{ __('Dashboard') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('admin.users.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ Route::is('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            {{ __('SDM') }}
                        </p>
                    </a>
                </li>
                
                <li class="nav-item {{ Route::is('admin.entitas.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.entitas.index') }}"
                        class="nav-link {{ Route::is('admin.entitas.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            {{ __('Entitas') }}
                        </p>
                    </a>
                </li>

                <li class="nav-item {{ Route::is('admin.jabatan.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.jabatan.index') }}"
                        class="nav-link {{ Route::is('admin.jabatan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            {{ __('Jabatan') }}
                        </p>
                    </a>
                </li>


                <!-- <li class="nav-item">
                        <i class="nav-icon far fa-address-card"></i>
                    
                </li> -->

                {{-- <li
                    class="nav-item {{ Route::is('admin.absensis.index') || Route::is('admin.absensis.show') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Route::is('admin.absensis.index') || Route::is('admin.absensis.show') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            Kehadiran 
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"
                        {{ Route::is('admin.absensis.index') || Route::is('admin.absensis.show') ? 'style=display:block;' : '' }}>
                        <li class="nav-item {{ Route::is('admin.absensis.index') ? 'menu-open' : '' }}">
                            <a href="{{ route('admin.absensis.index') }}"
                                class="nav-link {{ Route::is('admin.absensis.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Kehadiran</p>
                            </a>
                        </li>
                        
                    </ul>
                </li> --}}
                <li
                    class="nav-item {{ Route::is('admin.gaji.index') || Route::is('admin.absensis.show') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.gaji.index') || Route::is('admin.absensis.show')? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Gaji
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview {{ Route::is('admin.gaji.index') || Route::is('admin.absensis.show') ? 'style=display:block;' : '' }}">
                        <li class="nav-item {{ Route::is('admin.gaji.index') ? 'menu-open' : '' }}">
                            <a href="{{ route('admin.gaji.index') }}" class="nav-link {{ Route::is('admin.gaji.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Gaji</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::is('admin.absensis.show') ? 'menu-open' : '' }}">
                            <a href="{{ route('admin.absensis.show') }}"
                                class="nav-link {{ Route::is('admin.absensis.show') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Input Gaji</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::is('admin.laporan.index') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.laporan.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Laporan Slip
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview {{ Route::is('admin.laporan.index') ? 'style=display:block;' : '' }}">
                        <li class="nav-item {{ Route::is('admin.laporan.index') ? 'menu-open' : '' }}">
                            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ Route::is('admin.laporan.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Slip Gaji</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-circle nav-icon"></i>
                        <p>
                            Laporan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('admin.laporan.show') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Slip Gaji</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
