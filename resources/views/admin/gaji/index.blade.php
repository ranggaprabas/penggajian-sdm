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
                                <div id="dlab_W_Notification1" class="widget-media dlab-scroll p-3" style="height:230px;">
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
                                                <div class="media me-2 media-danger">
                                                    <i class="fa fa-cog"></i>
                                                </div>
                                                <div class="media-body">
                                                    <a href="{{ route('admin.settings.show') }}" class="dropdown-item">
                                                        <h6 class="mb-1">{{ __('Setting') }}</h6>
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
                    <li class="breadcrumb-item active"><a href="{{ route('admin.gaji.index') }}">Payroll SDM</a>
                    </li>
                </ol>
            </div>
            <!-- Tambahkan bagian berikut untuk menampilkan keterangan -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-secondary alert-dismissible fade show">
                                <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="me-2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                                <strong>Info!</strong> Silahkan pilih bulan dan tahun terlebih dahulu untuk melakukan
                                filter.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                </button>
                            </div>
                            <form action="{{ route('admin.gaji.index') }}" method="get">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="bulan">Bulan</label>
                                            <select class="form-control select2" name="bulan" id="bulan" required>
                                                <option value="" disabled>-- Pilih Bulan --</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}" @if(request('bulan') == $i) selected @endif>
                                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                                    </option>
                                                @endfor
                                            </select>                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tahun">Tahun</label>
                                            <select class="form-control select2" name="tahun" id="tahun" required>
                                                <option value="" disabled>-- Pilih Tahun --</option>
                                                @php
                                                    $last = date('Y') - 10;
                                                    $now = date('Y');
                                                @endphp
                                            
                                                @for ($i = $now; $i >= $last; $i--)
                                                    <option value="{{ $i }}" @if(request('tahun') == $i) selected @endif>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="d-md-flex">
                                    <button class="btn btn-secondary mt-3 mb-3 mx-1"><i class="fa fa-filter"></i>
                                        Filter</button>
                                    @if (request()->get('bulan') === null && request()->get('tahun') === null)
                                        @php
                                            $bulan = ltrim(date('m'), '0');
                                            $tahun = date('Y');
                                        @endphp
                                        <a href="{{ route('admin.gaji.cetak', [$bulan, $tahun]) }}"
                                            class="btn btn-danger mt-3 mb-3 mx-1">
                                            <i class="fa fa-file-pdf"></i> PDF
                                        </a>
                                        <a href="{{ route('admin.gaji.export-excel', [$bulan, $tahun]) }}"
                                            class="btn btn-success mt-3 mb-3 mx-1">
                                            <i class="fa fa-file-excel"></i> Export Excel
                                        </a>
                                    @else
                                        @php
                                            $bulan = request()->get('bulan');
                                            $tahun = request()->get('tahun');
                                        @endphp
                                        <a href="{{ route('admin.gaji.cetak', [$bulan, $tahun]) }}"
                                            class="btn btn-danger mt-3 mb-3 mx-1">
                                            <i class="fa fa-file-pdf"></i> PDF
                                        </a>
                                        <a href="{{ route('admin.gaji.export-excel', [$bulan, $tahun]) }}"
                                            class="btn btn-success mt-3 mb-3 mx-1">
                                            <i class="fa fa-file-excel"></i> Export Excel
                                        </a>
                                    @endif
                            </form>
                            <form action="{{ route('admin.gaji.import-excel') }}" method="post"
                                enctype="multipart/form-data" onsubmit="return validateFormInputExcel();">
                                @csrf
                                <div class="d-flex gap-3 mt-3 mb-3 mx-1">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-file-excel"></i>
                                        Import
                                        Excel</button>
                                    <input type="file" name="file" accept=".xlsx, .xls" id="file"
                                        class="form-control gray-border" style="width: 55%">
                                </div>
                            </form>
                        </div>
                        <form
                            action="{{ route('admin.gaji.gaji-serentak', ['bulan' => request()->get('bulan', date('n')), 'tahun' => request()->get('tahun', date('Y'))]) }}"
                            method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary mt-1 mb-1">
                                <i class="fa fa-calculator"></i> Gaji Serentak
                            </button>
                            <!-- Tampilkan informasi jumlah SDM yang belum masuk gaji -->
                            <span class="text-muted ml-2 mx-2">Total SDM yang belum digaji:
                                {{ $sdmCountNotInAbsensi }}</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (request()->get('bulan') === null && request()->get('tahun') === null)
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success solid alert-dismissible fade show">
                        <i class="fa fa-eye"></i><span style="margin-right: 10px;"></span>Menampilkan Data Gaji SDM
                        bulan <span class="text-bold">{{ date('F') }}</span>
                        tahun <span class="text-bold">{{ date('Y') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success solid alert-dismissible fade show">
                        @php
                            $bulan = request()->get('bulan');
                            $namaBulan = date('F', mktime(0, 0, 0, $bulan, 1));
                        @endphp
                        <i class="fa fa-eye"></i><span style="margin-right: 10px;"></span>Menampilkan Data Gaji SDM
                        bulan <span class="text-bold">{{ $namaBulan }}</span> tahun
                        <span class="text-bold">{{ request()->get('tahun') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if (count($items) > 0)
                            <div class="table-responsive">
                                @php
                                    function calculateTakeHomePay($item)
                                    {
                                        $jumlah_tunjangan = 0;
                                        $jumlah_potongan = 0;

                                        if ($item->tunjangan) {
                                            $tunjangan = json_decode($item->tunjangan, true);
                                            $item->tunjangan_jabatan = $item->tunjangan_jabatan ?? 0;

                                            if (is_array($tunjangan) && count($tunjangan) > 0) {
                                                $total_tunjangan = array_sum(array_column($tunjangan, 'nilai_tunjangan'));
                                                $jumlah_tunjangan = $item->tunjangan_jabatan + $total_tunjangan;
                                            } else {
                                                $jumlah_tunjangan = $item->tunjangan_jabatan;
                                            }
                                        }

                                        if ($item->potongan) {
                                            $potongan = json_decode($item->potongan, true);

                                            if (is_array($potongan) && count($potongan) > 0) {
                                                $total_potongan = array_sum(array_column($potongan, 'nilai_potongan'));
                                                $jumlah_potongan = $total_potongan;
                                            }
                                        }

                                        return $item->gaji_pokok + $jumlah_tunjangan - $jumlah_potongan;
                                    }
                                @endphp
                                <table id="example2" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Entitas</th>
                                            <th>Divisi</th>
                                            <th>Jabatan</th>
                                            <th>Take Home Pay</th>
                                            <th class="action-column">Action</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    <tbody class="normal-text">
                                        @forelse($items as $item)
                                            <tr id="_index{{ $item->id }}">
                                                <td>{{ $counter }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->entitas }}</td>
                                                <td>{{ $item->divisi }}</td>
                                                <td>{{ $item->jabatan }}</td>
                                                <td>
                                                    @php
                                                        $take_home_pay = calculateTakeHomePay($item);
                                                    @endphp
                                                    Rp. {{ number_format($take_home_pay, 0, '', '.') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.gaji.show', $item->id) }}"
                                                            class="btn btn-warning shadow btn-xs sharp me-1"> <i
                                                                class="text-white fa fa-eye"></i> </a>
                                                        <a href="{{ route('admin.edit-gaji', $item->id) }}"
                                                            class="btn btn-primary shadow btn-xs sharp me-1"> <i
                                                                class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.gaji.pdf', ['id' => $item->id, 'bulan' => request()->get('bulan', date('n')), 'tahun' => request()->get('tahun', date('Y'))]) }}" method="get">
                                                            @csrf
                                                            <!-- ... (form input bulan dan tahun) ... -->
                                                            <button type="submit" class="btn light btn-danger btn-xxs">
                                                                <i class="fa fa-file-pdf"></i>
                                                            </button>
                                                        </form>                                                        
                                                        <a href="javascript:void(0)" id="btn-delete-gaji"
                                                            data-id="{{ $item->id }}"
                                                            data-nama="{{ $item->nama }}"
                                                            class="btn btn-danger shadow btn-xs sharp me-1"> <i
                                                                class="fa fa-undo"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                                $counter++;
                                            @endphp
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Data Kosong</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Entitas</th>
                                            <th>Divisi</th>
                                            <th>Jabatan</th>
                                            <th>Take Home Pay</th>
                                            <th class="action-column">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center">
                                <span class="badge bg-danger">
                                    <i class="fa fa-exclamation-circle"></i> Data Kosong!, Diperlukan Gaji Serentak /
                                    Import
                                    Excel
                                    terlebih dahulu
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    </div>
    <!-- /.content -->
    <div class="footer">
        <div class="copyright">
        </div>
    </div>
@endsection
