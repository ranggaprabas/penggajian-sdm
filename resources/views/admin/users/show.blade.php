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
                        <li class="breadcrumb-item active">Detail SDM</li>
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
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Nama</th>
                                            <td>{{ $data->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $data->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nik</th>
                                            <td>{{ $data->nik }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>{{ $data->jenis_kelamin }}</td>
                                        </tr>
                                        <tr>
                                            <th>Entitas</th>
                                            <td>{{ $data->entitas->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jabatan</th>
                                            <td>
                                                @if ($data->jabatan->deleted == 1)
                                                    {{ $data->jabatan->nama }} (jabatan deleted)
                                                @else
                                                    {{ $data->jabatan->nama ?? '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <!-- Tampilkan total tunjangan -->
                                        <tr>
                                            <th>Total Tunjangan:</th>
                                            <td>
                                                @php
                                                    $totalTunjangan = 0;
                                                @endphp
                                                @if ($details->komponenGaji->count() > 0)
                                                    <ul>
                                                        @if ($data->jabatan->deleted != 1)
                                                            <li>
                                                                Tj. Jabatan:
                                                                {{ number_format($data->jabatan->tunjangan_jabatan, 0, '', '.') }}
                                                            </li>
                                                        @endif
                                                        @foreach ($details->komponenGaji as $tunjangan)
                                                            <li>Tj. {{ $tunjangan->nama_tunjangan }}: Rp.
                                                                {{ number_format($tunjangan->nilai_tunjangan, 0, '', '.') }}
                                                            </li>
                                                            @php
                                                                $totalTunjangan += $tunjangan->nilai_tunjangan;
                                                            @endphp
                                                        @endforeach
                                                    </ul>
                                                    @php
                                                        if ($data->jabatan->deleted != 1) {
                                                            $totalTunjangan = $data->jabatan->tunjangan_jabatan + $totalTunjangan;
                                                        }
                                                    @endphp

                                                    <strong>Total: Rp.
                                                        {{ number_format($totalTunjangan, 0, '', '.') }}
                                                    @else
                                                        Tidak ada tunjangan.
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if ($data->status)
                                                    <span class="badge bg-success">Pegawai Tetap</span>
                                                @else
                                                    <span class="badge bg-warning">Pegawai Tidak Tetap</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
