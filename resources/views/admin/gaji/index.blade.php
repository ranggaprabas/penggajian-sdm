@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="m-0">{{ __('Data Gaji SDM') }}</h1>
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
                    <div class="card p-4">
                        <form action="{{ route('admin.gaji.index') }}" method="get">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="bulan">Bulan</label>
                                        <select class="form-control" name="bulan" id="bulan" required>
                                            <option value=""disabled selected>-- Pilih Bulan --</option>
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
                                        <select class="form-control" name="tahun" id="tahun" required>
                                            <option value=""disabled selected>-- Pilih Tahun --</option>
                                            {{ $last = date('Y') - 5 }}
                                            {{ $now = date('Y') }}

                                            @for ($i = $now; $i >= $last; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                            @if (request()->get('bulan') === null && request()->get('tahun') === null)
                                <a href="{{ route('admin.gaji.cetak', [ltrim(date('m'), '0'), date('Y')]) }}"
                                    class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                            @else
                                <a href="{{ route('admin.gaji.cetak', [request()->get('bulan'), request()->get('tahun')]) }}"
                                    class="btn btn-info" target="_blank"> Cetak <i class="fa fa-print"></i> </a>
                            @endif
                            <div class="alert alert-warning mt-3">
                                <i class="fa fa-info-circle"></i> Silahkan pilih bulan dan tahun terlebih dahulu untuk
                                melakukan filter. <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if (request()->get('bulan') === null && request()->get('tahun') === null)
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success }}">
                            <i class="fa fa-eye"></i><span style="margin-right: 10px;"></span>Menampilkan Data Gaji SDM
                            bulan <span class="text-bold">{{ date('F') }}</span>
                            tahun <span class="text-bold">{{ date('Y') }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success }}">
                            @php
                                $bulan = request()->get('bulan');
                                $namaBulan = date('F', mktime(0, 0, 0, $bulan, 1));
                            @endphp
                            <i class="fa fa-eye"></i><span style="margin-right: 10px;"></span>Menampilkan Data Gaji SDM
                            bulan <span class="text-bold">{{ $namaBulan }}</span> tahun
                            <span class="text-bold">{{ request()->get('tahun') }}</span>
                        </div>
                    </div>
                </div>
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if (count($items) > 0)
                                    <div class="table-responsive">
                                        <table id="example" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nik</th>
                                                    <th>Nama</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Entitas</th>
                                                    <th>Jabatan</th>
                                                    <th>Tunjangan Jabatan</th>
                                                    <th>Tunjangan</th>
                                                    <th>Take Home Pay</th>
                                                    <th class="action-column">Action</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $counter = 1;
                                            @endphp
                                            <tbody>
                                                @forelse($items as $item)
                                                    <tr id="_index{{ $item->id }}">
                                                        <td>{{ $counter }}</td>
                                                        <td>{{ $item->nik }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->jenis_kelamin }}</td>
                                                        <td>{{ $item->entitas }}</td>
                                                        <td>{{ $item->jabatan }}</td>
                                                        <td>Rp. {{ number_format($item->tunjangan_jabatan, 0, '', '.') }}
                                                        </td>
                                                        <td>
                                                            @if ($item->tunjangan)
                                                                @php
                                                                    $tunjangan = json_decode($item->tunjangan);
                                                                @endphp
                                                                <ul>
                                                                    @if (is_array($tunjangan) && count($tunjangan) > 0)
                                                                        @foreach ($tunjangan as $t)
                                                                            <li>{{ $t->nama_tunjangan }}: Rp.
                                                                                {{ number_format($t->nilai_tunjangan, 0, '', '.') }}
                                                                            </li>
                                                                        @endforeach
                                                                        @php
                                                                            $total_tunjangan = array_sum(array_column($tunjangan, 'nilai_tunjangan'));
                                                                            $take_home_pay = $item->tunjangan_jabatan + $total_tunjangan;
                                                                        @endphp
                                                                    @else
                                                                        <li>{{ $tunjangan->nama_tunjangan }}: Rp.
                                                                            {{ number_format($tunjangan->nilai_tunjangan, 0, '', '.') }}
                                                                        </li>
                                                                        @php
                                                                            $take_home_pay = $item->tunjangan_jabatan + $tunjangan->nilai_tunjangan;
                                                                        @endphp
                                                                    @endif
                                                                </ul>
                                                            @else
                                                                Tidak ada tunjangan.
                                                            @endif
                                                        </td>
                                                        <td>Rp. {{ number_format($take_home_pay, 0, '', '.') }}</td>
                                                        <td>
                                                            <a href="javascript:void(0)" id="btn-delete-gaji"
                                                                data-id="{{ $item->id }}"
                                                                data-nama="{{ $item->nama }}"
                                                                class="btn-sm btn-danger d-inline-block"> <i
                                                                    class="fa fa-undo"></i></a>
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
                                                    <th>Nik</th>
                                                    <th>Nama</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Entitas</th>
                                                    <th>Jabatan</th>
                                                    <th>Tunjangan Jabatan</th>
                                                    <th>Tunjangan</th>
                                                    <th class="action-column">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="badge bg-danger"> <i class="fa fa-exclamation-circle"></i> Data
                                            Kosong!, Diperlukan Mengisi <a href="{{ route('admin.absensis.show') }}"
                                                style="color: #000000 !important; text-decoration: underline;">Input
                                                Gaji</a> terlebih dahulu</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
    <!-- /.content -->
@endsection
