@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            Input Gaji SDM
                        </div>
                    </div>
                    <!-- Right navbar links -->
                    <ul class="navbar-nav header-right">
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="btn btn-primary d-sm-inline-block position-relative" data-toggle="dropdown"
                                aria-expanded="false" style="padding-bottom: 26px;">
                                {{ Auth::user()->nama }} <i class="fa fa-user ms-3 scale-5"></i>
                                @if (Auth::check())
                                    <div class="position-absolute start-50 translate-middle-x text-center">
                                        @if (Auth::user()->status)
                                            superadmin
                                        @else
                                            admin
                                        @endif
                                    </div>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div id="dlab_W_Notification1" class="widget-media dlab-scroll p-3" style="height:230px;">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-info">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <div class="media-body">
                                                    <a href="{{ route('admin.profile.show') }}" class="dropdown-item">
                                                        <h6 class="mb-1">{{ __('My profile') }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-danger">
                                                    <i class="fa fa-cog"></i>
                                                </div>
                                                <div class="media-body">
                                                    <a href="{{ route('admin.settings.show') }}" class="dropdown-item">
                                                        <h6 class="mb-1">{{ __('Setting') }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-success">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </div>
                                                <div class="media-body">
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <a href="{{ route('logout') }}" class="dropdown-item"
                                                            onclick="event.preventDefault(); confirmLogout();">
                                                            <h6 class="mb-1"> {{ __('Log Out') }}</h6>
                                                        </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div> <!-- /.navbar -->

    <!-- Main content -->
    <div class="content-body">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success solid alert-dismissible fade show" id="info-message">
                    <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="btn-close"></button>
                </div>
            @endif
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('admin.absensis.show') }}">Gaji</a>
                    </li>
                    <li class="breadcrumb-item">Input Gaji SDM</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card p-4">
                        <form action="{{ route('admin.absensis.show') }}" method="get">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="bulan">Bulan</label>
                                        <select class="form-control select2" name="bulan" id="bulan" required>
                                            <option value=""disabled selected>-- Pilih Bulan --</option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <select class="form-control select2" name="tahun" id="tahun" required>
                                            <option value=""disabled selected>-- Pilih Tahun --</option>
                                            {{ $last = date('Y') - 10 }}
                                            {{ $now = date('Y') }}

                                            @for ($i = $now; $i >= $last; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3 mb-3"><i class="fa fa-filter"></i> Filter</button>
                            <div class="alert alert-secondary alert-dismissible fade show">
                                <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                                <strong>Info!</strong> Silahkan pilih bulan dan tahun terlebih dahulu untuk melakukan filter. 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if (request()->get('bulan') === null && request()->get('tahun') === null)
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success solid alert-dismissible fade show">
                            <i class="fa fa-eye"></i><span style="margin-right: 10px;"></span>Menampilkan data Input Gaji
                            SDM bulan <span class="text-bold">{{ date('F') }}</span>
                            tahun <span class="text-bold">{{ date('Y') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success solid alert-dismissible fade show">
                            @php
                                $bulan = request()->get('bulan');
                                $namaBulan = date('F', mktime(0, 0, 0, $bulan, 1));
                            @endphp
                            <i class="fa fa-eye"></i><span style="margin-right: 10px;"></span>Menampilkan data Input Gaji
                            SDM bulan <span class="text-bold">{{ $namaBulan }}</span> tahun
                            <span class="text-bold">{{ request()->get('tahun') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('admin.absensis.store') }}" method="post">
                        @csrf
                        @if (request()->get('bulan') === null && request()->get('tahun') === null)
                            <input type="hidden" name="bulan" value="{{ ltrim(date('m') . date('Y'), '0') }}">
                        @else
                            <input type="hidden" name="bulan"
                                value="{{ request()->get('bulan') . request()->get('tahun') }}">
                        @endif
                        <div class="card">
                            <div class="card-body">
                                @if (count($absensis) > 0)
                                    <div class="table-responsive">
                                        <table id="example1" class="display" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nik</th>
                                                    <th>Nama</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Entitas</th>
                                                    <th>Divisi</th>
                                                    <th>Jabatan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="normal-text">
                                                @forelse($absensis as $absensi)
                                                    <tr>
                                                        <input type="hidden" name="karyawan_id[]"
                                                            value="{{ $absensi->id }}">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $absensi->nik }}</td>
                                                        <td>{{ $absensi->nama }}</td>
                                                        <td>{{ $absensi->jenis_kelamin }}</td>
                                                        <td>{{ $absensi->nama_entitas ?? '-' }}</td>
                                                        <td>{{ $absensi->nama_divisi ?? '-' }}</td>
                                                        <td>{{ $absensi->nama_jabatan ?? '-' }}</td>
                                                        <td>
                                                            {{-- <input type="hidden" name="karyawan_id[]" value="{{ $absensi->id }}"> --}}
                                                            <button type="submit" name="individual_submit" value="{{ $absensi->id }}"
                                                                class="btn btn-primary btn-xs"><i class="fas fa-check"></i> Gaji</button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center">Data Kosong</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nik</th>
                                                    <th>Nama</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Entitas</th>
                                                    <th>Divisi</th>
                                                    <th>Jabatan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary mx-auto btn-block mt-3"> <i
                                                class="fa fa-check"></i> Gaji Serentak</button>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="badge bg-danger"> <i class="fa fa-exclamation-circle"></i> Data
                                            Kosong!, Data Input Gaji Bulan ini sudah masuk di <a
                                                href="{{ route('admin.gaji.index') }}"
                                                style="color: #000000 !important; text-decoration: underline;">Data
                                                Gaji</a></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <div class="footer">
        <div class="copyright">
        </div>
    </div>
@endsection
