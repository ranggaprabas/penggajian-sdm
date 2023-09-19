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
                        <li class="breadcrumb-item active">Add SDM</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-3">

                            <form action="{{ route('admin.users.store') }}" method="POST">
                                @csrf
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="entitas">Entitas</label>
                                    <select class="form-control" style="width: 80%;" name="entitas_id" id="entitas">
                                        <option value="">--Choose Categories--</option>
                                        @foreach ($entita as $entitas)
                                            <option value="{{ $entitas->id }}"
                                                @if (old('entitas_id') == $entitas->id) selected @endif>
                                                {{ $entitas->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="jabatan">Jabatan</label>
                                    <select class="form-control" style="width: 80%;" name="jabatan_id" id="jabatan">
                                        <option value="">--Choose Categories--</option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{ $jabatan->id }}"
                                                @if (old('jabatan_id') == $jabatan->id) selected @endif>
                                                {{ $jabatan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="nama">Nama</label>
                                    <input class="form-control" style="width: 80%;" type="text" name="nama"
                                        value="{{ old('nama') }}">
                                </div>
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="email">Email</label>
                                    <input class="form-control" style="width: 80%;" type="text" name="email"
                                        value="{{ old('email') }}">
                                </div>
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="nik">Nik</label>
                                    <input class="form-control" style="width: 80%;" type="number" name="nik"
                                        value="{{ old('nik') }}">
                                </div>
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" style="width: 80%;" name="jenis_kelamin"
                                        id="jenis_kelamin">
                                        <option value="laki-laki">Laki-Laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="status">Status</label>
                                    <select class="form-control" style="width: 80%;" name="status" id="status">
                                        <option value="1">Pegawai Tetap</option>
                                        <option value="0">Pegawai Tidak Tetap</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
