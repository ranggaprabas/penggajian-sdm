@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            SDM
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
                    <li class="breadcrumb-item active"><a href="{{ route('admin.sdm.index') }}">{{ $pages }}</a>
                    </li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
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
                                        <td>{{ $data->entitas->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Divisi</th>
                                        <td>{{ $data->divisi->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td>
                                            @if ($data->jabatan->deleted == 1)
                                                {{ $data->jabatan->nama }} <span style="color: red;">(jabatan
                                                    deleted)</span>
                                            @else
                                                {{ $data->jabatan->nama ?? '-' }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Telegram Id</th>
                                        <td>{{ $data->chat_id ?? '-' }}</td>
                                    </tr>
                                    <!-- Tampilkan total tunjangan -->
                                    <tr>
                                        <th>Total Tunjangan:</th>
                                        <td>
                                            @php
                                                $totalTunjangan = 0; // Inisialisasi total tunjangan
                                            @endphp

                                            <ul>
                                                @if ($data->jabatan->deleted != 1)
                                                    @if ($data->jabatan->tunjangan_jabatan != 1)
                                                        <li>
                                                            Tj. Jabatan:
                                                            {{ number_format($data->jabatan->tunjangan_jabatan, 0, '', '.') }}
                                                        </li>
                                                        @php
                                                            $totalTunjangan += $data->jabatan->tunjangan_jabatan;
                                                        @endphp
                                                    @endif
                                                @endif

                                                @foreach ($details->komponenGaji as $tunjangan)
                                                    <li>
                                                        Tj. {{ $tunjangan->nama_tunjangan }}: Rp.
                                                        {{ number_format($tunjangan->nilai_tunjangan, 0, '', '.') }}
                                                    </li>
                                                    @php
                                                        $totalTunjangan += $tunjangan->nilai_tunjangan;
                                                    @endphp
                                                @endforeach
                                            </ul>
                                            <strong>Total: Rp.
                                                {{ number_format($totalTunjangan, 0, '', '.') }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Potongan:</th>
                                        <td>
                                            @php
                                                $totalPotongan = 0;
                                            @endphp
                                            @if ($details->potonganGaji->count() > 0)
                                                <ul>
                                                    @foreach ($details->potonganGaji as $potongan)
                                                        <li> {{ $potongan->nama_potongan }}: Rp.
                                                            {{ number_format($potongan->nilai_potongan, 0, '', '.') }}
                                                        </li>
                                                        @php
                                                            $totalPotongan += $potongan->nilai_potongan;
                                                        @endphp
                                                    @endforeach
                                                </ul>
                                                <strong>Total: Rp.
                                                    {{ number_format($totalPotongan, 0, '', '.') }}
                                                @else
                                                    Tidak ada potongan.
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Take Home Pay:</th>
                                        @php
                                            $takeHomePay = $totalTunjangan - $totalPotongan;
                                        @endphp
                                        <td>
                                            <strong>Rp. {{ number_format($takeHomePay, 0, '', '.') }}
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
