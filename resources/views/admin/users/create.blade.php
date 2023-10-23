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
                <form novalidate action="{{ route('admin.users.store') }}" method="POST" onsubmit="return validateForm() && removeCommas2();">
                    @csrf
                    <div class="card card-primary">
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
                                                @if ($jabatan->deleted != 1)
                                                    <option value="{{ $jabatan->id }}"
                                                        data-tunjangan_jabatan="{{ $jabatan->tunjangan_jabatan }}"
                                                        @if (old('jabatan_id') == $jabatan->id) selected @endif>
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
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div class="card-title">Tunjangan</div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="tunjangan">
                                        <div class="form-group">
                                            <label for="nama_tunjangan[]">Nama Tunjangan</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Tj.</div>
                                                </div>
                                                <input type="text" name="nama_tunjangan[]"
                                                    class="form-control autocomplete_txt_tunjangan" data-type='namatunjangan'
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nilai_tunjangan[]">Nilai Tunjangan</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rp.</div>
                                                </div>
                                                <input type="text" name="nilai_tunjangan[]"
                                                    class="form-control nilai-tunjangan" required
                                                    oninput="addCommas2(this)">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger removeTunjanganAdd mb-3"> <i
                                                class="fa fa-trash"></i> Hapus Tunjangan</button>
                                    </div>
                                    <div id="tunjanganContainer"></div>
                                    <button type="button" id="addTunjangan" class="btn btn-outline-success"> <i
                                            class="fa fa-plus"></i> Tambah Tunjangan</button>
                                    <p id="totalTunjangan">Total Tunjangan: Rp. 0</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div class="card-title">Potongan</div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="potongan">
                                        <div class="form-group">
                                            <label for="nama_potongan[]">Nama Potongan</label>
                                            <input type="text" name="nama_potongan[]"
                                                class="form-control autocomplete_txt_potongan" data-type='namapotongan' required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nilai_potongan[]">Nilai Potongan</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rp.</div>
                                                </div>
                                                <input type="text" name="nilai_potongan[]"
                                                    class="form-control nilai-potongan" required
                                                    oninput="addCommas2(this)">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger removePotonganAdd mb-3"> <i
                                                class="fa fa-trash"></i> Hapus Potongan</button>
                                    </div>
                                    <div id="potonganContainer"></div>
                                    <button type="button" id="addPotongan" class="btn btn-outline-success"> <i
                                            class="fa fa-plus"></i> Tambah Potongan</button>
                                    <p id="totalPotongan">Total Potongan: Rp. 0</p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
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
                                                id="search3" oninput="addCommas2(this)"
                                                value="{{ old('potongan_pinjaman') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </form>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
