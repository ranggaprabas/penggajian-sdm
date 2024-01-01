@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            Payroll SDM
                        </div>
                    </div>
                    <!-- Right navbar links -->
                    <ul class="navbar-nav header-right">
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="btn btn-primary d-sm-inline-block position-relative" data-toggle="dropdown"
                                aria-expanded="false" style="padding-bottom: 26px;">
                                {{ Auth::user()->nama }} <i class="fa fa-user ms-3 scale-5"></i>
                                @if (Auth::check())
                                    <div class="position-absolute start-50 translate-middle-x text-center">
                                        @if (Auth::user()->status)
                                            superadmin
                                        @else
                                            admin
                                        @endif
                                    </div>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div id="dlab_W_Notification1" class="widget-media dlab-scroll p-3" style="height:200px;">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-info">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <div class="media-body">
                                                    <a href="{{ route('admin.profile.show') }}" class="dropdown-item">
                                                        <h6 class="mb-1">{{ __('My profile') }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-success">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </div>
                                                <div class="media-body">
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <a href="{{ route('logout') }}" class="dropdown-item"
                                                            onclick="event.preventDefault(); confirmLogout();">
                                                            <h6 class="mb-1"> {{ __('Log Out') }}</h6>
                                                        </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div> <!-- /.navbar -->

    <!-- Main content -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('admin.gaji.index') }}">{{ $pages }}</a>
                    </li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info solid alert-dismissible fade show">
                        <i class="fa fa-eye"></i><span style="margin-right: 10px;"></span>Detail Payroll SDM
                        <span class="text-bold">{{ $data->nama }}</span>
                        bulan <span class="text-bold">{{ $bulan }}</span>
                        tahun <span class="text-bold">{{ $tahun }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
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
                                        <td>{{ $data->entitas ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Divisi</th>
                                        <td>{{ $data->divisi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td>{{ $data->jabatan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telegram Id</th>
                                        <td>{{ $data->chat_id ?? '-' }}</td>
                                    </tr>
                                    <!-- Tampilkan total tunjangan -->
                                    <tr>
                                        <th>Total Tunjangan:</th>
                                        <td>
                                            @if ($data->tunjangan)
                                                @php
                                                    $tunjangan = json_decode($data->tunjangan, true);
                                                @endphp
                                                <ul>
                                                    <li>
                                                        Tj. Jabatan:
                                                        Rp. {{ number_format($data->tunjangan_jabatan, 0, '', '.') }}
                                                    </li>
                                                    @if (is_array($tunjangan) && count($tunjangan) > 0)
                                                        @php
                                                            $total_tunjangan = array_sum(array_column($tunjangan, 'nilai_tunjangan'));
                                                            $jumlah_tunjangan = $data->tunjangan_jabatan + $total_tunjangan;
                                                        @endphp
                                                        @foreach ($tunjangan as $t)
                                                            <li>Tj. {{ $t['nama_tunjangan'] ?? '-' }}: Rp.
                                                                {{ number_format($t['nilai_tunjangan'], 0, '', '.') }}
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        @php
                                                            $jumlah_tunjangan = $data->tunjangan_jabatan;
                                                        @endphp
                                                    @endif
                                                </ul>
                                                <strong>Total: Rp.
                                                    {{ number_format($jumlah_tunjangan, 0, '', '.') }}
                                                </strong>
                                            @else
                                                Tidak ada tunjangan.
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Potongan:</th>
                                        <td>
                                            @if ($data->potongan)
                                                @php
                                                    $potongan = json_decode($data->potongan, true);
                                                @endphp
                                                <ul>
                                                    @php
                                                        $jumlah_potongan = 0; // Set potongan menjadi 0 jika tidak ada data potongan
                                                    @endphp
                                                    @if (is_array($potongan) && count($potongan) > 0)
                                                        @php
                                                            $total_potongan = array_sum(array_column($potongan, 'nilai_potongan'));
                                                            $jumlah_potongan = $total_potongan;
                                                        @endphp
                                                        @foreach ($potongan as $t)
                                                            <li>{{ $t['nama_potongan'] ?? '-' }}: Rp.
                                                                {{ number_format($t['nilai_potongan'], 0, '', '.') }}
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        Tidak ada potongan.
                                                    @endif
                                                </ul>
                                                <strong>Total: Rp.
                                                    {{ number_format($jumlah_potongan, 0, '', '.') }}
                                                </strong>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Take Home Pay:</th>
                                        @php
                                            $take_home_pay = $jumlah_tunjangan - $jumlah_potongan;
                                        @endphp
                                        <td>
                                            <strong>Rp. {{ number_format($take_home_pay, 0, '', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($data->status)
                                                <span class="badge light badge-success">Pegawai Tetap</span>
                                            @else
                                                <span class="badge light badge-warning">Pegawai Tidak Tetap</span>
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
    <div class="footer">
        <div class="copyright">
        </div>
    </div> <!-- /.content -->
@endsection
