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
                        <li class="breadcrumb-item"><a href="{{ route('admin.jabatan.index') }}">{{ $pages }}</a></li>
                        <li class="breadcrumb-item active">Edit Jabatan</li>
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

                            <form action="{{ route('admin.jabatan.update', $jabatan->id) }}" method="POST"
                                onsubmit="removeCommas()">
                                @csrf
                                @method('put')
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="name">Nama</label>
                                    <input class="form-control" style="width: 80%;" type="text" name="nama"
                                        value="{{ old('nama', $jabatan->nama) }}">
                                </div>
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="tunjangan_jabatan">Tunjangan Jabatan</label>
                                    <div class="input-group" style="width: 80%">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input class="form-control" style="width: 80%;" type="text"
                                            name="tunjangan_jabatan" oninput="addCommas(this)"
                                            value="{{ old('tunjangan_jabatan', str_replace(',', '.', number_format($jabatan->tunjangan_jabatan))) }}">
                                    </div>
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
