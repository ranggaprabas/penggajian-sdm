@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            SDM
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
                                <div id="dlab_W_Notification1" class="widget-media dlab-scroll p-3" style="height:200px;">
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


    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('admin.sdm.index') }}">SDM</a>
                    </li>
                    <li class="breadcrumb-item">Table</li>
                </ol>
            </div>

            <!-- Main content -->
            <div class="row">
                <div class="col-12">
                    @if ($isDeletedPage)
                        <div class="alert alert-secondary alert-dismissible fade show">
                            <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <strong>Info!</strong> Menampilkan data SDM dengan status tidak aktif.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            </button>
                        </div>
                    @endif
                    @if (!$isDeletedPage)
                        <div class="alert alert-secondary alert-dismissible fade show">
                            <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <strong>Info!</strong> Menampilkan data SDM dengan status aktif.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            </button>
                        </div>
                    @endif
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
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <p class="mr-2 mb-0 mx-2">Status SDM</p>
                                    <!-- Cek apakah berada di halaman "deleted" -->
                                    <button type="button" class="btn btn-outline-success btn-xs mx-1"
                                        onclick="window.location.href='{{ route('admin.sdm.index') }}'">Aktif</button>
                                    <button type="button" class="btn btn-outline-danger btn-xs mx-2"
                                        onclick="window.location.href='{{ route('admin.sdm.index.deleted') }}'">Resign</button>
                                </div>

                                @if (!$isDeletedPage)
                                    <a href="{{ route('admin.sdm.create') }}" class="btn btn-rounded btn-success">
                                        <span class="btn-icon-start text-success"><i
                                                class="fa fa-plus color-success"></i></span>
                                        Add
                                    </a>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Entitas</th>
                                            <th>Divisi</th>
                                            <th>Jabatan</th>
                                            <th>Status</th>
                                            @if (Auth::user()->status == 1)
                                                <th>Last Update</th>
                                            @endif
                                            <th class="action-column">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="normal-text">
                                        @foreach ($sdms as $sdm)
                                            <tr id="_index{{ $sdm->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $sdm->nama }}</td>
                                                <td>{{ $sdm->jenis_kelamin }}</td>
                                                <td>{{ $sdm->entitas->nama ?? '-' }}</td>
                                                <td>{{ $sdm->divisi->nama ?? '-' }}</td>
                                                <td>
                                                    @if ($sdm->jabatan->deleted == 1)
                                                        {{ $sdm->jabatan->nama }} <span style="color: red;"> (jabatan
                                                            deleted) </span>
                                                    @else
                                                        {{ $sdm->jabatan->nama ?? '-' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($sdm->status)
                                                        @if ($isDeletedPage)
                                                            <span class="badge light badge-danger">pegawai resign</span>
                                                        @else
                                                            <span class="badge light badge-success">pegawai tetap</span>
                                                        @endif
                                                    @else
                                                        @if ($isDeletedPage)
                                                            <span class="badge light badge-danger">pegawai resign</span>
                                                        @else
                                                            <span class="badge light badge-warning">pegawai tidak
                                                                tetap</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                @if (Auth::user()->status == 1)
                                                    <td>
                                                        @if ($sdm->last_update)
                                                            @php
                                                                $last_update = \Carbon\Carbon::parse($sdm->last_update)->tz('Asia/Jakarta');
                                                            @endphp
                                                            {{ $last_update->format('Y-m-d H:i:s') }}
                                                        @else
                                                            No last updated date
                                                        @endif
                                                        @if ($sdm->action)
                                                            <span class="badge light badge-primary">Action:
                                                                {{ $sdm->action }}</span>
                                                        @endif
                                                    </td>
                                                @endif
                                                <td>
                                                    @if ($sdm->deleted == 0)
                                                        <a href="{{ route('admin.sdm.show', $sdm->id) }}"
                                                            class="btn btn-warning shadow btn-xs sharp me-1"> <i
                                                                class="text-white fa fa-eye"></i> </a>
                                                        <a href="{{ route('admin.edit-sdm', $sdm->id) }}"
                                                            class="btn btn-primary shadow btn-xs sharp me-1"> <i
                                                                class="fa fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    @if ($isDeletedPage)
                                                        <a href="javascript:void(0)" id="btn-restore-users"
                                                            data-id="{{ $sdm->id }}"
                                                            data-nama="{{ $sdm->nama }}"
                                                            class="btn btn-success shadow btn-xs sharp me-1">
                                                            <i class="fa fa-power-off"></i>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0)" id="btn-delete-users"
                                                            data-id="{{ $sdm->id }}"
                                                            data-nama="{{ $sdm->nama }}"
                                                            class="btn btn-danger shadow btn-xs sharp me-1"> <i
                                                                class="fa fa-power-off"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Entitas</th>
                                            <th>Divisi</th>
                                            <th>Jabatan</th>
                                            <th>Status</th>
                                            @if (Auth::user()->status == 1)
                                                <th>Last Update</th>
                                            @endif
                                            <th class="action-column">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <!-- previous and next default adminlte -->

                        {{-- <div class="card-footer clearfix">
                            {{ $users->links() }}
                        </div> --}}
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="footer">
        <div class="copyright">
        </div>
    </div>
    <!-- /.content -->
@endsection
