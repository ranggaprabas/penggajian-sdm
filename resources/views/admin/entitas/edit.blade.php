@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.entitas.index') }}">{{ $pages }}</a></li>
                        <li class="breadcrumb-item active">Edit Entitas</li>
                    </ol>
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
                        <div class="card-body p-3">

                            <form action="{{ route('admin.entitas.update', $entita->id) }}" method="POST">
                                @csrf
                                @method('put')
                                <div style="gap: .5rem;flex-wrap: wrap;"
                                    class="form-group justify-content-between d-flex align-items-center mb-5">
                                    <label class="m-0" for="name">Nama</label>
                                    <input class="form-control" style="width: 80%;" type="text" name="nama"
                                        value="{{ old('nama', $entita->nama) }}">
                                </div>
                                <button class="btn btn-primary" type="submit">Simpan</button>
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
