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
                        <li class="breadcrumb-item active">Add Jabatan</li>
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

                            <form action="{{ route('admin.jabatan.store') }}" method="POST" onsubmit="removeCommas()">
                                @csrf
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="name">Nama</label>
                                    <input class="form-control" style="width: 80%;" type="text" name="nama"
                                        value="{{ old('nama') }}">
                                </div>
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="gaji_pokok">Gaji Pokok</label>
                                    <div class="input-group" style="width: 80%;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input class="form-control" style="width: 80%;" type="text" name="gaji_pokok"
                                            id="gaji_pokok" oninput="addCommas(this)" value="{{ old('gaji_pokok') }}">
                                    </div>
                                </div>
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="transportasi">Transportasi</label>
                                    <div class="input-group" style="width: 80%">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input class="form-control" style="width: 80%;" type="text" name="transportasi"
                                            id="transportasi" oninput="addCommas(this)" value="{{ old('transportasi') }}">
                                    </div>
                                </div>
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="uang_makan">Uang Makan</label>
                                    <div class="input-group" style="width: 80%">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input class="form-control" style="width: 80%;" type="text" name="uang_makan"
                                            id="uang_makan" oninput="addCommas(this)" value="{{ old('uang_makan') }}">
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
