<!-- Sidebar -->
<div class="nav-header">
    <div class="nav-header" style="display: flex; align-items: center;">
        <a href="{{ route('admin.home') }}" class="brand-logo">
            @if (auth()->user()->status == 1)
                <!-- Jika status pengguna adalah 1, tampilkan gambar Taman Media -->
                <img src="{{ asset('images/tamanmedia.png') }}" alt="PT. TAMAN MEDIA INDONESIA Logo" width="50">
            @else
                <!-- Jika status pengguna bukan 1, tampilkan gambar entitas -->
                @if (auth()->user()->entitas && auth()->user()->entitas->image)
                    <img src="{{ asset('storage/' . auth()->user()->entitas->image) }}"
                        alt="{{ auth()->user()->entitas->nama }} Logo" width="50">
                @else
                    <!-- Default image jika entitas tidak memiliki gambar -->
                    <img src="{{ asset('images/default.png') }}" alt="Default Logo" width="50">
                @endif
            @endif
            <svg class="brand-title" width="200px" height="33px">
                <text x="0" y="15" fill="rgb(25, 59, 98)" font-size="16">
                    Penggajian SDM
                </text>
            </svg>
        </a>
    </div>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            @if (auth()->user()->is_admin)
                <li>
                    <a href="{{ route('admin.home') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-025-dashboard"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                @if (auth()->check() && auth()->user()->status == 1)
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="ai-icon-admin" aria-expanded="false">
                            <i class="fa fa-cogs"></i>
                            <span class="nav-text">Admin</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('admin.sdm.index') }}" class="ai-icon-sdm" aria-expanded="false">
                        <i class="fas fa-users"></i>
                        <span class="nav-text">SDM</span>
                    </a>
                </li>
                @if (auth()->check() && auth()->user()->status == 1)
                    <li>
                        <a href="{{ route('admin.entitas.index') }}" class="ai-icon" aria-expanded="false">
                            <i class="fas fa-building"></i>
                            <span class="nav-text">Entitas</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('admin.divisi.index') }}" class="ai-icon-home" aria-expanded="false">
                        <i class="fas fa-university"></i>
                        <span class="nav-text">Divisi</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.jabatan.index') }}" class="ai-icon-jabatan" aria-expanded="false">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <span class="nav-text">Jabatan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pinjaman.index') }}" class="ai-icon-jabatan" aria-expanded="false">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <span class="nav-text">Pinjaman SDM</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.gaji.index') }}" class="ai-icon-jabatan" aria-expanded="false">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span class="nav-text">Payroll</span>
                    </a>
                </li>
                {{-- <li>
                    <a class="has-arrow ai-icon-gaji" href="javascript:void()" aria-expanded="false">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span class="nav-text">Gaji</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.gaji.index') }}">
                                <p>Data Gaji</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.absensis.show') }}">
                                <p>Input Gaji</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-022-copy"></i>
                        <span class="nav-text">Laporan Slip</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a href="{{ route('admin.laporan.index') }}">
                                <p>Slip Gaji</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                @php
                    $telegramBotToken = \App\Models\Setting::where('telegram_bot_token', '!=', '')->value(
                        'telegram_bot_token',
                    );
                @endphp
                @if (!empty($telegramBotToken))
                    <li>
                        <a href="{{ route('admin.broadcast-information.index') }}" class="ai-icon-home"
                            aria-expanded="false">
                            <i class="fas fa-envelope"></i>
                            <span class="nav-text">Broadcast Information</span>
                        </a>
                    </li>
                @endif
            @else
                <li>
                    <a href="{{ route('admin.laporan.show') }}" class="ai-icon-jabatan" aria-expanded="false">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span class="nav-text">Slip Gaji</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>

<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
