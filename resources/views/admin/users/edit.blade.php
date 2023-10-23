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
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" onsubmit="removeCommas2()">
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
                                            value="{{ old('nama', $user->nama) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="entitas">Entitas</label>
                                        <select class="form-control" name="entitas_id" id="entitas">
                                            <option value="">-- Choose Categories --</option>
                                            @foreach ($entita as $entitas)
                                                <option value="{{ $entitas->id }}"
                                                    {{ $user->entitas && $user->entitas->id == $entitas->id ? 'selected' : '' }}>
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
                                                @if ($jabatan->deleted != 1)
                                                    <option value="{{ $jabatan->id }}"
                                                        data-tunjangan_jabatan="{{ $jabatan->tunjangan_jabatan }}"
                                                        {{ $user->jabatan && $user->jabatan->id == $jabatan->id ? 'selected' : '' }}>
                                                        {{ $jabatan->nama }} - Rp.
                                                        {{ number_format($jabatan->tunjangan_jabatan, 0, '', '.') }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control" type="text" name="email"
                                            value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nik">Nik</label>
                                        <input class="form-control" type="number" name="nik"
                                            value="{{ old('nik', $user->nik) }}">
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
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option {{ $user->status === 1 ? 'selected' : null }} value="1">Pegawai
                                        Tetap
                                    </option>
                                    <option {{ $user->status === 0 ? 'selected' : null }} value="0">Pegawai
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
                                        <div id="tunjanganContainer">
                                            @if ($user->komponenGaji)
                                                @foreach ($user->komponenGaji as $tunjangan)
                                                    <div class="tunjangan">
                                                        <div class="form-group">
                                                            <label for="nama_tunjangan">Nama Tunjangan</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Tj.</div>
                                                                </div>
                                                                <input type="text" class="form-control autocomplete_txt"
                                                                    name="nama_tunjangan[]" id="search"
                                                                    data-type='namatunjangan' required
                                                                    value="{{ $tunjangan->nama_tunjangan }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nilai_tunjangan">Nilai Tunjangan</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Rp.</div>
                                                                </div>
                                                                <input type="text" class="form-control"
                                                                    name="nilai_tunjangan[]" required
                                                                    value="{{ old('nilai_tunjangan', str_replace(',', '.', number_format($tunjangan->nilai_tunjangan))) }}"
                                                                    oninput="addCommas2(this)">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="tunjangan_ids[]"
                                                            value="{{ $tunjangan->id }}">
                                                        <button type="button"
                                                            class="btn btn-outline-danger removeTunjangan mb-3"><i
                                                                class="fa fa-trash"></i> Hapus
                                                            Tunjangan</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" id="addTunjanganEdit" class="btn btn-outline-success"> <i
                                                class="fa fa-plus"></i> Tambah Tunjangan</button>
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
