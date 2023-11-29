@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            Admin
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

    <!-- Main content -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('admin.users.index') }}">{{ $pages }}</a>
                    </li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
            <div class="col-lg-12">
                <form novalidate action="{{ route('admin.users.update', $user->id) }}" method="POST"
                    onsubmit="return validateFormAdminEdit() && removeCommas2();">
                    @csrf
                    @method('put')
                    @if ($errors->any())
                        <div class="alert alert-danger solid alert-dismissible fade show" id="info-message">
                            <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                </polygon>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="btn-close"></button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Profile Admin</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input class="form-control gray-border" type="text" id="nama"
                                                name="nama" value="{{ old('nama', $user->nama) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input class="form-control gray-border" type="text" id="email"
                                                name="email" value="{{ old('email', $user->email) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="default-select form-control wide gray-border"
                                                name="jenis_kelamin" id="jenis_kelamin">
                                                <option {{ $user->jenis_kelamin === 'laki-laki' ? 'selected' : null }}
                                                    value="laki-laki">Laki-Laki</option>
                                                <option {{ $user->jenis_kelamin === 'perempuan' ? 'selected' : null }}
                                                    value="perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="default-select form-control wide gray-border" name="status"
                                                id="status">
                                                <option {{ $user->status === 1 ? 'selected' : null }} value="1">
                                                    superadmin
                                                </option>
                                                <option {{ $user->status === 0 ? 'selected' : null }} value="0">admin
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group-password">
                                            <label for="password">Password Baru</label>
                                            <input class="form-control gray-border" type="password" id="password"
                                                name="password">
                                            <span class="eye-toggle">
                                                <i class="fas fa-eye" id="password-toggle"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group-password">
                                            <div class="form-group">
                                                <label for="password_confirmation">Konfirmasi Password Baru</label>
                                                <input class="form-control gray-border" type="password"
                                                    id="password_confirmation" name="password_confirmation">
                                                <span class="eye-toggle"><i class="fas fa-eye"
                                                        id="password-confirmation-toggle"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </form>
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
