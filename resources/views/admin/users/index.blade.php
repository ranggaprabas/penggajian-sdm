@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->




    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="m-0">{{ __('SDM') }}</h1>

                    <a href="{{ route('admin.users.create') }}" class="btn btn-success"> <i class="fa fa-plus"></i> </a>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (Request::is('admin/users/deleted'))
                <!-- Cek apakah berada di halaman "deleted" -->
                <a href="{{ route('admin.users.index') }}" class="btn btn-success ml-auto">
                    <i class="fa fa-arrow-left"></i> Kembali <!-- Ganti teks tombol menjadi "Kembali" -->
                </a>
            @else
                <a href="{{ route('admin.users.index.deleted') }}" class="btn btn-success ml-auto">
                    <i class="fa fa-power-off"></i> Lihat Data Yang Dihapus
                    <!-- Teks tombol tetap "Lihat Data Yang Dihapus" -->
                </a>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-2">
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Nik</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Entitas</th>
                                            <th>Jabatan</th>
                                            <th>Status</th>
                                            <th class="action-column">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @foreach ($users as $user)
                                            @if ($user->is_admin != 1)
                                                <tr id="_index{{ $user->id }}">
                                                    <td>{{ $counter }}</td>
                                                    <td>{{ $user->nama }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->nik }}</td>
                                                    <td>{{ $user->jenis_kelamin }}</td>
                                                    <td>{{ $user->entitas->nama ?? '-' }}</td>
                                                    <td>
                                                        @if ($user->jabatan->deleted == 1)
                                                            {{ $user->jabatan->nama }} <span style="color: red;"> (jabatan
                                                                deleted) </span>
                                                        @else
                                                            {{ $user->jabatan->nama ?? '-' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($user->status)
                                                            <span class="badge bg-success">pegawai tetap</span>
                                                        @else
                                                            <span class="badge bg-warning">pegawai tidak tetap</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($user->deleted == 0)
                                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                                class="btn-sm btn-warning d-inline-block mx-1"> <i
                                                                    class="text-white fa fa-eye"></i> </a>
                                                            <a href="{{ route('admin.edit-users', $user->id) }}"
                                                                class="btn-sm btn-info d-inline-block"> <i
                                                                    class="fa fa-edit"></i>
                                                            </a>
                                                        @endif
                                                        @if ($isDeletedPage)
                                                            <a href="javascript:void(0)" id="btn-restore-users"
                                                                data-id="{{ $user->id }}"
                                                                data-nama="{{ $user->nama }}"
                                                                class="btn-sm btn-success d-inline-block">
                                                                <i class="fa fa-undo"></i>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0)" id="btn-delete-users"
                                                                data-id="{{ $user->id }}"
                                                                data-nama="{{ $user->nama }}"
                                                                class="btn-sm btn-danger d-inline-block"> <i
                                                                    class="fa fa-power-off"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Nik</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Entitas</th>
                                            <th>Jabatan</th>
                                            <th>Status</th>
                                            <th class="action-column">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <!-- previous and next default adminlte -->

                        {{-- <div class="card-footer clearfix">
                            {{ $users->links() }}
                        </div> --}}
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
