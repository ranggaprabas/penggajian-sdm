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
                        <li class="breadcrumb-item active">Edit SDM</li>
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
                <form action="{{ route('admin.users.update', $data->id) }}" method="POST" onsubmit="removeCommas2()">
                    @csrf
                    @method('put')
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <div class="card-title">
                                Profile SDM
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input class="form-control" type="text" name="nama"
                                            value="{{ old('nama', $data->nama) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="entitas">Entitas</label>
                                        <select class="form-control" name="entitas_id" id="entitas">
                                            <option value="">-- Choose Categories --</option>
                                            @foreach ($entita as $entitas)
                                                <option value="{{ $entitas->id }}"
                                                    {{ $data->entitas && $data->entitas->id == $entitas->id ? 'selected' : '' }}>
                                                    {{ $entitas->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan</label>
                                        <select class="form-control" name="jabatan_id" id="jabatan">
                                            <option value="">-- Choose Categories --</option>
                                            @foreach ($jabatans as $jabatan)
                                                <option value="{{ $jabatan->id }}"
                                                    data-tunjangan_jabatan="{{ $jabatan->tunjangan_jabatan }}"
                                                    {{ $data->jabatan && $data->jabatan->id == $jabatan->id ? 'selected' : '' }}>
                                                    {{ $jabatan->nama }} - Rp.
                                                    {{ number_format($jabatan->tunjangan_jabatan, 0, '', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control" type="text" name="email"
                                            value="{{ old('email', $data->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nik">Nik</label>
                                        <input class="form-control" type="number" name="nik"
                                            value="{{ old('nik', $data->nik) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                            <option {{ $data->jenis_kelamin === 'laki-laki' ? 'selected' : null }}
                                                value="laki-laki">Laki-Laki</option>
                                            <option {{ $data->jenis_kelamin === 'perempuan' ? 'selected' : null }}
                                                value="perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option {{ $data->status === 1 ? 'selected' : null }} value="1">Pegawai
                                        Tetap
                                    </option>
                                    <option {{ $data->status === 0 ? 'selected' : null }} value="0">Pegawai
                                        Tidak
                                        Tetap</option>
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
                                            <input class="form-control" type="text" name="tunjangan_makan" id="search" oninput="addCommas2(this)"
                                                value="{{ old('tunjangan_makan', str_replace(',', '.', number_format($details->komponenGaji->tunjangan_makan))) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tunjangan_transportasi">Transportasi</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp.</div>
                                            </div>
                                            <input class="form-control" type="text" name="tunjangan_transportasi" id="search2" oninput="addCommas2(this)"
                                                value="{{ old('tunjangan_transportasi', str_replace(',', '.', number_format($details->komponenGaji->tunjangan_transportasi))) }}">
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
                                            <input class="form-control" type="text" name="potongan_pinjaman" id="search3" oninput="addCommas2(this)"
                                                value="{{ old('potongan_pinjaman', str_replace(',', '.', number_format($details->komponenGaji->potongan_pinjaman))) }}">
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
