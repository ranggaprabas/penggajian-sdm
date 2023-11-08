@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ $pages }}</a></li>
                        <li class="breadcrumb-item active">Edit Admin</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-lg-12">
                <form novalidate action="{{ route('admin.users.update', $user->id) }}" method="POST"
                    onsubmit="return validateFormAdminEdit() && removeCommas2();">
                    @csrf
                    @method('put')
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">
                                Profile Admin
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input class="form-control" type="text" id="nama" name="nama"
                                            value="{{ old('nama', $user->nama) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control" type="text" id="email" name="email"
                                            value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                            <option {{ $user->jenis_kelamin === 'laki-laki' ? 'selected' : null }}
                                                value="laki-laki">Laki-Laki</option>
                                            <option {{ $user->jenis_kelamin === 'perempuan' ? 'selected' : null }}
                                                value="perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-password">
                                        <label for="password">Password Baru</label>
                                        <input class="form-control" type="password" id="password" name="password">
                                        <span class="eye-toggle">
                                            <i class="fas fa-eye" id="password-toggle"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-password">
                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                                            <input class="form-control" type="password" id="password_confirmation"
                                                name="password_confirmation">
                                            <span class="eye-toggle"><i class="fas fa-eye"
                                                    id="password-confirmation-toggle"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option {{ $user->status === 1 ? 'selected' : null }} value="1">superadmin
                                    </option>
                                    <option {{ $user->status === 0 ? 'selected' : null }} value="0">admin</option>
                                </select>
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
@endsection
