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
            <div class="col-lg-12">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <div class="card-title">Profile SDM</div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input class="form-control" type="text" name="nama"
                                            value="{{ old('nama') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="entitas">Entitas</label>
                                        <select class="form-control" name="entitas_id" id="entitas">
                                            <option value="">--Choose Categories--</option>
                                            @foreach ($entita as $entitas)
                                                <option value="{{ $entitas->id }}"
                                                    @if (old('entitas_id') == $entitas->id) selected @endif>
                                                    {{ $entitas->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan</label>
                                        <select class="form-control" name="jabatan_id" id="jabatan">
                                            <option value="">--Choose Categories--</option>
                                            @foreach ($jabatans as $jabatan)
                                                <option value="{{ $jabatan->id }}"
                                                    data-tunjangan_jabatan="{{ $jabatan->tunjangan_jabatan }}"
                                                    @if (old('jabatan_id') == $jabatan->id) selected @endif>
                                                    {{ $jabatan->nama }} - Rp.
                                                    {{ number_format($jabatan->tunjangan_jabatan, 0, '', '.') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control" type="text" name="email"
                                            value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nik">Nik</label>
                                        <input class="form-control" type="number" name="nik"
                                            value="{{ old('nik') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                            <option value="laki-laki">Laki-Laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="1">Pegawai Tetap</option>
                                    <option value="0">Pegawai Tidak Tetap</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-lightblue">
                                <div class="card-header">
                                    <div class="card-title">Tunjangan</div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="form-group">
                                        <label for="tunjangan_makan">Makan</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp.</div>
                                            </div>
                                            <input class="form-control" type="text" name="tunjangan_makan" 
                                                value="{{ old('tunjangan_makan') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tunjangan_transportasi">Transportasi</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp.</div>
                                            </div>
                                            <input class="form-control" type="text" name="tunjangan_transportasi"
                                                value="{{ old('tunjangan_transportasi') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-lightblue">
                                <div class="card-header">
                                    <div class="card-title">Potongan</div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="form-group">
                                        <label for="potongan_pinjaman">Pinjaman</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp.</div>
                                            </div>
                                            <input class="form-control" type="text" name="potongan_pinjaman"
                                                value="{{ old('potongan_pinjaman') }}">
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
@endsection
