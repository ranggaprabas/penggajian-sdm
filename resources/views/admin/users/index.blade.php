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
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->nama }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->nik }}</td>
                                            <td>{{ $user->jenis_kelamin }}</td>
                                            <td>{{ $user->entitas->nama ?? '-' }}</td>
                                            <td>{{ $user->jabatan->nama ?? '-' }}</td>
                                            <td>
                                                @if($user->status)
                                                    <span class="badge bg-success">pegawai tetap</span>
                                                @else
                                                    <span class="badge bg-warning">pegawai tidak tetap</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn-sm btn-warning d-inline-block mx-1"> <i class="text-white fa fa-eye"></i> </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-sm btn-info d-inline-block"> <i class="fa fa-edit"></i> </a>
                                                <form class="d-inline-block m-1" onclick="return confirm('anda yakin ? ');"  action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                                                    @csrf 
                                                    @method('delete')
                                                    <button type="submit" class="btn-sm btn-danger"> <i class="fa fa-trash"></i> </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                            {{ $users->links() }}
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection