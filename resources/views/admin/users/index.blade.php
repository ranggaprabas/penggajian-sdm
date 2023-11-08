@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->




    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="m-0">{{ __('Admin') }}</h1>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-success"> <i class="fa fa-plus"></i> </a>
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
                            <div class="d-flex align-items-center mb-3">
                            </div>
                            <div class="d-flex justify-content-end mb-2">
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                            <th class="action-column">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @foreach ($admins as $admin)
                                            <tr id="_index{{ $admin->id }}">
                                                <td>{{ $counter }}</td>
                                                <td>{{ $admin->nama }}</td>
                                                <td>{{ $admin->email }}</td>
                                                <td>{{ $admin->jenis_kelamin }}</td>
                                                <td>
                                                    @if (auth()->user() && auth()->user()->id === $admin->id)
                                                        <span class="badge bg-info">Me (Myself)</span>
                                                        @if ($admin->status)
                                                            <span class="badge bg-primary">Superadmin</span>
                                                        @else
                                                            <span class="badge bg-warning">Admin</span>
                                                        @endif
                                                    @else
                                                        @if ($admin->status)
                                                            <span class="badge bg-primary">Superadmin</span>
                                                        @else
                                                            <span class="badge bg-warning">Admin</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.users.show', $admin->id) }}"
                                                        class="btn-sm btn-warning d-inline-block mx-1"> <i
                                                            class="text-white fa fa-eye"></i> </a>
                                                    <a href="{{ route('admin.edit-users', $admin->id) }}"
                                                        class="btn-sm btn-info d-inline-block"> <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" id="btn-delete-admin"
                                                        data-id="{{ $admin->id }}" data-nama="{{ $admin->nama }}"
                                                        class="btn-sm btn-danger d-inline-block"> <i
                                                            class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            @php
                                                $counter++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Jenis Kelamin</th>
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
