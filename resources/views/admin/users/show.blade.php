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
                                            <td>{{ $user->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nik</th>
                                            <td>{{ $user->nik }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>{{ $user->jenis_kelamin }}</td>
                                        </tr>
                                        <tr>
                                            <th>Entitas</th>
                                            <td>{{ $user->entitas->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jabatan</th>
                                            <td>{{ $user->jabatan->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tunjangan Jabatan</th>
                                            <td>
                                                <span class="badge bg-primary"><i class="fa fa-plus"></i></span>
                                                @if ($user->jabatan)
                                                    Rp. {{ number_format($user->jabatan->tunjangan_jabatan, 0, '', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Tunjangan Makan</th>
                                            <td>
                                                <span class="badge bg-primary"><i class="fa fa-plus"></i></span>
                                                @if ($user->tunjangan_makan)
                                                    Rp. {{ number_format($user->tunjangan_makan, 0, '', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Tunjangan Transportasi</th>
                                            <td>
                                                <span class="badge bg-primary"><i class="fa fa-plus"></i></span>
                                                @if ($user->tunjangan_transportasi)
                                                    Rp. {{ number_format($user->tunjangan_transportasi, 0, '', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        @php
                                            $total_potongan = $user->potongan_pinjaman;
                                            $total_gaji = $user->jabatan ? $user->jabatan->tunjangan_jabatan + $user->tunjangan_makan + $user->tunjangan_transportasi - $total_potongan : null;
                                        @endphp

                                        <tr>
                                            <th>Total Potongan</th>
                                            <td>
                                                <span class="badge bg-danger"><i class="fa fa-minus"></i></span>
                                                @if ($total_potongan)
                                                    Rp. {{ number_format($total_potongan, 0, '', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Take Home Pay</th>
                                            <td>
                                                <i class="fa fa-money-bill"></i>
                                                @if ($total_gaji !== null)
                                                    Rp. {{ number_format($total_gaji, 0, '', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if ($user->status)
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
