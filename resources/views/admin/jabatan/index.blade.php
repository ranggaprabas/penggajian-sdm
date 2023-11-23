@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->




    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="m-0">{{ __('Jabatan') }}</h1>

                    <a href="{{ route('admin.jabatan.create') }}" class="btn btn-success"> <i class="fa fa-plus"></i> </a>
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
                    @if (session('success'))
                        <div class="alert alert-success" id="info-message">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tunjangan Jabatan</th>
                                            <th>Total Gaji</th>
                                            @if (Auth::user()->status == 1)
                                                <th class="col-2">User</th>
                                                <th class="col-2">Last Update</th>
                                            @endif
                                            <th class="action-column">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="normal-text">
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @foreach ($items as $item)
                                            @if ($item->deleted == 0)
                                                {{-- Hanya tampilkan jabatan yang belum dihapus --}}
                                                <tr id="index_{{ $item->id }}">
                                                    <td>{{ $counter }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>Rp. {{ number_format($item->tunjangan_jabatan, 0, '', '.') }}</td>
                                                    @php $total_gaji =  $item->tunjangan_jabatan @endphp
                                                    <td>Rp. {{ number_format($total_gaji, 0, '', '.') }}</td>
                                                    @if (Auth::user()->status == 1)
                                                        <td>{{ $item->username ?? 'Empty user last update' }}</td>
                                                        <td>
                                                            @if ($item->last_update)
                                                                @php
                                                                    $last_update = \Carbon\Carbon::parse($item->last_update)->tz('Asia/Jakarta');
                                                                @endphp
                                                                {{ $last_update->format('Y-m-d H:i:s') }}
                                                            @else
                                                                No last updated date.
                                                            @endif
                                                            <br>
                                                            @if ($item->action)
                                                                <span class="badge bg-primary">Action:
                                                                    {{ $item->action }}</span>
                                                            @endif
                                                            <br>
                                                            <br>
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <a href="{{ route('admin.edit-jabatan', $item->id) }}"
                                                            class="btn btn-info"> <i class="fa fa-edit"></i> </a>
                                                        <a href="javascript:void(0)" id="btn-delete-jabatan"
                                                            data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                                            class="btn btn-danger"> <i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        {{-- <div class="card-footer clearfix">
                            {{ $items->links() }}
                        </div> --}}
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
