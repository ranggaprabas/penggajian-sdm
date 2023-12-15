@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            Broadcast Information
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
                    <li class="breadcrumb-item active"><a
                            href="{{ route('admin.broadcast-information.index') }}">{{ $title }}</a>
                    </li>
                    <li class="breadcrumb-item">Table</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success solid alert-dismissible fade show" id="info-message">
                            <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                <polyline points="9 11 12 14 22 4"></polyline>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                            </svg>
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="btn-close"></button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- Move the 'Add' button to the right -->
                                <div class="ml-auto-add">
                                    <a href="{{ route('admin.broadcast-information.create') }}"
                                        class="btn btn-rounded btn-success">
                                        <span class="btn-icon-start text-success"><i
                                                class="fa fa-plus color-success"></i></span>
                                        Add
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="example2" class="display" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Admin</th>
                                            <th>To</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="normal-text">
                                        @foreach ($uniqueBroadcasts as $index => $broadcast)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if (isset($broadcast['last_update']))
                                                        @php
                                                            $last_update = \Carbon\Carbon::parse($broadcast['last_update'])->tz('Asia/Jakarta');
                                                        @endphp
                                                        {{ $last_update->format('Y-m-d H:i:s') }}
                                                    @else
                                                        No last updated date.
                                                    @endif
                                                    @if (isset($broadcast['action']))
                                                        <span class="badge light badge-primary">Action:
                                                            {{ $broadcast['action'] }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($broadcast['username']))
                                                        {{ $broadcast['username'] }}
                                                    @else
                                                        No admin assigned.
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($broadcast['sdm_names']))
                                                        @php
                                                            $sdmNames = $broadcast['sdm_names'];
                                                            $displayNames = count($sdmNames) > 3 ? array_slice($sdmNames, 0, 3) : $sdmNames;
                                                        @endphp
                                                        {{ implode(', ', $displayNames) }}
                                                        @if (count($sdmNames) > 3)
                                                            , ...
                                                        @endif
                                                    @else
                                                        No category assigned.
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.broadcast-information.show', $broadcast['id']) }}"
                                                        class="btn btn-warning shadow btn-xs sharp me-1"> <i
                                                            class="text-white fa fa-eye"></i> </a>
                                                </td>
                                            </tr>
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
    <div class="footer">
        <div class="copyright">
        </div>
    </div>
@endsection
