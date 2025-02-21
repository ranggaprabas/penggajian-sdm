@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            Setting
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
                    <li class="breadcrumb-item active"><a href="{{ route('admin.settings.show') }}">Beranda Setting</a>
                    </li>
                </ol>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if ($errors->any())
                        <div class="alert alert-danger solid alert-dismissible fade show" id="info-message">
                            <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                </polygon>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="btn-close"></button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.settings.update') }}"
                                enctype="multipart/form-data" onsubmit="return validateFormSetting();">
                                @csrf
                                @method('PUT')
                                @if (Auth::user()->status == 1)
                                    <div style="gap: .5rem;flex-wrap: wrap;"
                                        class="form-group justify-content-between d-flex align-items-center mb-3">
                                        <label for="telegram_bot_token">Telegram Bot Token:</label>
                                        <input class="form-control gray-border" style="width: 100%;" type="text"
                                            id="setting" name="telegram_bot_token"
                                            value="{{ $setting->telegram_bot_token ?? '' }}">
                                    </div>
                                @endif
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-3">
                                    <label for="alamat">Alamat Entitas:</label>
                                    <input class="form-control gray-border" style="width: 100%;" type="text"
                                        id="alamat" name="alamat"
                                        value="{{ $entitas->alamat ?? '' }}">
                                </div>
                                <!-- Upload image field -->
                                <div style="gap: .5rem; flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label for="image">Gambar Entitas</label>
                                    <input type="file" id="image" class="form-control gray-border mb-3"
                                        name="image" style="width: 100%;">
                                    <!-- Display image from Entitas if available -->
                                    @if ($entitas && $entitas->image)
                                        <img src="{{ asset('storage/' . $entitas->image) }}" alt="Entitas Image"
                                            class="w-25">
                                    @endif
                                    @if ($entitas && $entitas->image)
                                        <input type="hidden" name="old_image" value="{{ $entitas->image }}">
                                    @endif
                                </div>
                                <button class="btn btn-primary" type="submit">Save Setting</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
