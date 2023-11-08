@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-center">
                    <h1 class="m-0 text-center">{{ __('Data Laporan Slip Gaji SDM') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card p-4">
                        <form action="{{ route('admin.laporan.store') }}" method="post" target="_blank">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="karyawan_id">Nama SDM</label>
                                        <select class="form-control select2" name="karyawan_id" id="karyawan_id" style="width: 100%;" required>
                                            <option value="" disabled selected>-- Pilih SDM --</option>
                                            @foreach ($sdms as $sdm)
                                                <option value="{{ $sdm->id }}">{{ $sdm->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="bulan">Bulan</label>
                                        <select class="form-control select2" name="bulan" id="bulan" required>
                                            <option value="" disabled selected>-- Pilih Bulan --</option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <select class="form-control select2" name="tahun" id="tahun" required>
                                            <option value="" disabled selected>-- Pilih Tahun --</option>
                                            {{ $last = date('Y') - 10 }}
                                            {{ $now = date('Y') }}

                                            @for ($i = $now; $i >= $last; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info"><i class="fa fa-print"></i> Cetak</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
