@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            Admin
                        </div>
                    </div>
                    <!-- Right navbar links -->
                    <ul class="navbar-nav header-right">
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="btn btn-primary d-sm-inline-block" data-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->nama }} <i class="fa fa-user"></i>
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

    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('admin.users.index') }}">Admin</a>
                    </li>
                    <li class="breadcrumb-item">Table</li>
                </ol>
            </div>

            <!-- Main content -->
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible alert-alt fade show" id="info-message">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- Move the 'Add' button to the right -->
                                <div class="ml-auto-add">
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-rounded btn-success">
                                        <span class="btn-icon-start text-success"><i class="fa fa-plus color-success"></i></span>
                                        Add
                                    </a>
                                </div>
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
                                            <th>User</th>
                                            <th>Last Update</th>
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
                                                        <span class="badge light badge-info">Me (Myself)</span>
                                                        @if ($admin->status)
                                                            <span class="badge light badge-primary">Superadmin</span>
                                                        @else
                                                            <span class="badge light badge-warning">Admin</span>
                                                        @endif
                                                    @else
                                                        @if ($admin->status)
                                                            <span class="badge light badge-primary">Superadmin</span>
                                                        @else
                                                            <span class="badge light badge-warning">Admin</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $admin->username ?? 'Empty user last update ' }}
                                                </td>
                                                <td>
                                                    @if ($admin->last_update)
                                                        @php
                                                            $last_update = Carbon\Carbon::parse($admin->last_update)->tz('Asia/Jakarta');
                                                        @endphp
                                                        {{ $last_update->format('Y-m-d H:i:s') }}
                                                    @else
                                                        No last updated date
                                                    @endif
                                                    <br>
                                                    @if ($admin->action)
                                                        <span class="badge light badge-primary">Action:
                                                            {{ $admin->action }}</span>
                                                    @endif
                                                    <br>
                                                    <br>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.users.show', $admin->id) }}"
                                                        class="btn btn-warning shadow btn-xs sharp me-1"> <i
                                                            class="text-white fa fa-eye"></i> </a>
                                                    <a href="{{ route('admin.edit-users', $admin->id) }}"
                                                        class="btn btn-primary shadow btn-xs sharp me-1"> <i
                                                            class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" id="btn-delete-admin"
                                                        data-id="{{ $admin->id }}" data-nama="{{ $admin->nama }}"
                                                        class="btn btn-danger shadow btn-xs sharp me-1"> <i
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
                                            <th>User</th>
                                            <th>Last Update</th>
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
