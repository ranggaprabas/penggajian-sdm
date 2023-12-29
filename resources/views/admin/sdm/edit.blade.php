@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            SDM
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
                    <li class="breadcrumb-item active"><a href="{{ route('admin.sdm.index') }}">{{ $pages }}</a>
                    </li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
            <div class="col-lg-12">
                <form novalidate action="{{ route('admin.sdm.update', $sdm->id) }}" method="POST"
                    onsubmit="return validateForm() && removeCommas2();">
                    @csrf
                    @method('put')
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
                        <div class="card-header">
                            <h4 class="card-title">Profile SDM</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input class="form-control gray-border" type="text" id="nama"
                                                name="nama" value="{{ old('nama', $sdm->nama) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group ">
                                            <label for="entitas">Entitas</label>
                                            <select class="form-control gray-border select2" name="entitas_id"
                                                id="entitas">
                                                <option value="" disabled selected>-- Pilih Entitas --</option>
                                                @foreach ($entita as $entitas)
                                                    <option value="{{ $entitas->id }}"
                                                        {{ $sdm->entitas && $sdm->entitas->id == $entitas->id ? 'selected' : '' }}>
                                                        {{ $entitas->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group ">
                                            <label for="divisi">Divisi</label>
                                            <select class="form-control gray-border select2" name="divisi_id"
                                                id="divisi">
                                                <option value="" disabled selected>-- Pilih Divisi --</option>
                                                @foreach ($divisis as $divisi)
                                                    <option value="{{ $divisi->id }}"
                                                        {{ $sdm->divisi && $sdm->divisi->id == $divisi->id ? 'selected' : '' }}>
                                                        {{ $divisi->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="jabatan">Jabatan</label>
                                            <select class="form-control gray-border select2" name="jabatan_id"
                                                id="jabatan" required>
                                                <option value="" disabled selected>-- Pilih Jabatan --</option>
                                                @foreach ($jabatans as $jabatan)
                                                    @if ($jabatan->deleted != 1)
                                                        <option value="{{ $jabatan->id }}"
                                                            data-tunjangan_jabatan="{{ $jabatan->tunjangan_jabatan }}"
                                                            {{ $sdm->jabatan && $sdm->jabatan->id == $jabatan->id ? 'selected' : '' }}>
                                                            {{ $jabatan->nama }} - Rp.
                                                            {{ number_format($jabatan->tunjangan_jabatan, 0, '', '.') }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input class="form-control gray-border" type="text" id="email"
                                                name="email" value="{{ old('email', $sdm->email) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="nik">Nik</label>
                                            <input class="form-control gray-border" type="number" id="nik"
                                                name="nik" value="{{ old('nik', $sdm->nik) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="default-select form-control wide gray-border"
                                                name="jenis_kelamin" id="jenis_kelamin">
                                                <option {{ $sdm->jenis_kelamin === 'laki-laki' ? 'selected' : null }}
                                                    value="laki-laki">Laki-Laki</option>
                                                <option {{ $sdm->jenis_kelamin === 'perempuan' ? 'selected' : null }}
                                                    value="perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="chat_id">Telegram Id</label>
                                            <select class="form-control select2" name="chat_id" id="chat_id"
                                                style="width: 100%;">
                                                <option value="__create__">Lainnya</option>
                                                <option value="">-- Pilih Telegram Id --</option>
                                                <option value="{{ $sdm->chat_id }}"
                                                    @if ($sdm->id) selected @endif>
                                                    {{ $sdm->chat_id }}
                                                </option>
                                                {{-- Options from tunjangans --}}
                                                @foreach ($telegramUsers as $telegramUser)
                                                    <option value="{{ $telegramUser->chat_id }}">
                                                        {{ $telegramUser->username }} - {{ $telegramUser->chat_id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="default-select form-control wide gray-border" name="status"
                                            id="status">
                                            <option {{ $sdm->status === 1 ? 'selected' : null }} value="1">
                                                Pegawai
                                                Tetap
                                            </option>
                                            <option {{ $sdm->status === 0 ? 'selected' : null }} value="0">
                                                Pegawai
                                                Tidak
                                                Tetap</option>
                                        </select>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            // Inisialisasi Select2
                                            $('#chat_id').select2();

                                            // Menangani perubahan nilai pada elemen select
                                            $('#chat_id').on('change', async function() {
                                                // Mendapatkan nilai terpilih
                                                var selectedValue = $(this).val();

                                                // Cek apakah opsi "Buat Nilai Baru" dipilih
                                                if (selectedValue === '__create__') {
                                                    // Tampilkan modal SweetAlert2 untuk memasukkan nama Tunjangan baru
                                                    const {
                                                        value: newChatId
                                                    } = await Swal.fire({
                                                        input: 'text',
                                                        inputLabel: 'Telegram Id Baru',
                                                        inputPlaceholder: 'Masukkan Telegram Id Baru',
                                                        showCancelButton: true,
                                                        inputValidator: (value) => {
                                                            if (!value) {
                                                                return 'Telegram Id tidak boleh kosong!';
                                                            }
                                                        }
                                                    });

                                                    // Cek jika pengguna memasukkan nilai baru
                                                    if (newChatId) {
                                                        // Tambahkan nilai baru ke dalam select
                                                        var newOption = new Option(newChatId, newChatId, true, true);
                                                        $(this).append(newOption).trigger('change');
                                                    } else {
                                                        // Batal jika pengguna membatalkan operasi
                                                        $(this).val('').trigger('change');
                                                    }
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Tunjangan</h4>
                                </div>
                                <div class="card-body p-3">
                                    <div class="form-group">
                                        <div id="tunjanganContainer">
                                            @if ($sdm->komponenGaji)
                                                @foreach ($sdm->komponenGaji as $tunjangan)
                                                    <div class="tunjangan">
                                                        <div class="form-group mb-3">
                                                            <label for="nama_tunjangan">Nama Tunjangan</label>
                                                            <select class="form-control select2" name="nama_tunjangan[]"
                                                                id="tunjangannew_id_{{ $tunjangan->id }}"
                                                                style="width: 100%;" required>
                                                                <option value="__create__">Lainnya</option>
                                                                <option value="" disabled>-- Pilih Tunjangan --
                                                                </option>
                                                                @foreach ($sdm->komponenGaji as $optionTunjangan)
                                                                    <option value="{{ $optionTunjangan->nama_tunjangan }}"
                                                                        @if ($optionTunjangan->id == $tunjangan->id) selected @endif>
                                                                        {{ $optionTunjangan->nama_tunjangan }}
                                                                    </option>
                                                                @endforeach
                                                                {{-- Options from tunjangans --}}
                                                                @foreach ($tunjangans as $optionTunjangan)
                                                                    <option
                                                                        value="{{ $optionTunjangan->nama_tunjangan }}">
                                                                        {{ $optionTunjangan->nama_tunjangan }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
                                                                // Inisialisasi Select2
                                                                $('#tunjangannew_id_{{ $tunjangan->id }}').select2();

                                                                // Menangani perubahan nilai pada elemen select
                                                                $('#tunjangannew_id_{{ $tunjangan->id }}').on('change', async function() {
                                                                    // Mendapatkan nilai terpilih
                                                                    var selectedValue = $(this).val();

                                                                    // Cek apakah opsi "Buat Nilai Baru" dipilih
                                                                    if (selectedValue === '__create__') {
                                                                        // Tampilkan modal SweetAlert2 untuk memasukkan nama Tunjangan baru
                                                                        const {
                                                                            value: newTunjanganName
                                                                        } = await Swal.fire({
                                                                            input: 'text',
                                                                            inputLabel: 'Nama Tunjangan Baru',
                                                                            inputPlaceholder: 'Masukkan Nama Tunjangan Baru',
                                                                            showCancelButton: true,
                                                                            inputValidator: (value) => {
                                                                                if (!value) {
                                                                                    return 'Nama Tunjangan tidak boleh kosong!';
                                                                                }
                                                                            }
                                                                        });

                                                                        // Cek jika pengguna memasukkan nilai baru
                                                                        if (newTunjanganName) {
                                                                            // Tambahkan nilai baru ke dalam select
                                                                            var newOption = new Option(newTunjanganName, newTunjanganName, true, true);
                                                                            $(this).append(newOption).trigger('change');
                                                                        } else {
                                                                            // Batal jika pengguna membatalkan operasi
                                                                            $(this).val('').trigger('change');
                                                                        }
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                        <div class="form-group mb-3">
                                                            <label for="nilai_tunjangan">Nilai Tunjangan</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Rp.</span>
                                                                <input type="text" class="form-control gray-border"
                                                                    name="nilai_tunjangan[]" required
                                                                    value="{{ old('nilai_tunjangan', str_replace(',', '.', number_format($tunjangan->nilai_tunjangan))) }}"
                                                                    oninput="addCommas2(this)">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="tunjangan_ids[]"
                                                            value="{{ $tunjangan->id }}">
                                                        <button type="button"
                                                            class="btn btn-outline-danger removeTunjangan mb-3"><i
                                                                class="fa fa-trash"></i> Hapus
                                                            Tunjangan</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" id="addTunjanganEdit" class="btn btn-outline-success"> <i
                                                class="fa fa-plus"></i> Tambah Tunjangan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Potongan</h4>
                                </div>
                                <div class="card-body p-3">
                                    <div class="form-group">
                                        <div id="potonganContainer">
                                            @if ($sdm->potonganGaji)
                                                @foreach ($sdm->potonganGaji as $potongan)
                                                    <div class="potongan">
                                                        <div class="form-group mb-3">
                                                            <label for="nama_potongan">Nama Potongan</label>
                                                            <select class="form-control select2" name="nama_potongan[]"
                                                                id="potongannew_id_{{ $potongan->id }}"
                                                                style="width: 100%;" required>
                                                                <option value="__create__">Lainnya</option>
                                                                <option value="" disabled>-- Pilih Potongan --
                                                                </option>
                                                                @foreach ($sdm->potonganGaji as $optionPotongan)
                                                                    <option value="{{ $optionPotongan->nama_potongan }}"
                                                                        @if ($optionPotongan->id == $potongan->id) selected @endif>
                                                                        {{ $optionPotongan->nama_potongan }}
                                                                    </option>
                                                                @endforeach
                                                                {{-- Options from potongans --}}
                                                                @foreach ($potongans as $optionPotongan)
                                                                    <option value="{{ $optionPotongan->nama_potongan }}">
                                                                        {{ $optionPotongan->nama_potongan }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
                                                                // Inisialisasi Select2
                                                                $('#potongannew_id_{{ $potongan->id }}').select2();

                                                                // Menangani perubahan nilai pada elemen select
                                                                $('#potongannew_id_{{ $potongan->id }}').on('change', async function() {
                                                                    // Mendapatkan nilai terpilih
                                                                    var selectedValue = $(this).val();

                                                                    // Cek apakah opsi "Buat Nilai Baru" dipilih
                                                                    if (selectedValue === '__create__') {
                                                                        // Tampilkan modal SweetAlert2 untuk memasukkan nama Potongan baru
                                                                        const {
                                                                            value: newPotonganName
                                                                        } = await Swal.fire({
                                                                            input: 'text',
                                                                            inputLabel: 'Nama Potongan Baru',
                                                                            inputPlaceholder: 'Masukkan Nama Potongan Baru',
                                                                            showCancelButton: true,
                                                                            inputValidator: (value) => {
                                                                                if (!value) {
                                                                                    return 'Nama Potongan tidak boleh kosong!';
                                                                                }
                                                                            }
                                                                        });

                                                                        // Cek jika pengguna memasukkan nilai baru
                                                                        if (newPotonganName) {
                                                                            // Tambahkan nilai baru ke dalam select
                                                                            var newOption = new Option(newPotonganName, newPotonganName, true, true);
                                                                            $(this).append(newOption).trigger('change');
                                                                        } else {
                                                                            // Batal jika pengguna membatalkan operasi
                                                                            $(this).val('').trigger('change');
                                                                        }
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                        <div class="form-group mb-3">
                                                            <label for="nilai_potongan">Nilai Potongan</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Rp.</span>
                                                                <input type="text" class="form-control gray-border"
                                                                    name="nilai_potongan[]" required
                                                                    value="{{ old('nilai_potongan', str_replace(',', '.', number_format($potongan->nilai_potongan))) }}"
                                                                    oninput="addCommas2(this)">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="note_potongan[]">Note Potongan</label>
                                                            <input class="form-control gray-border" type="text"
                                                                name="note_potongan[]" id="note_potongan" value="{{ $potongan->note_potongan ?? '' }}">
                                                        </div>            
                                                        <input type="hidden" name="potongan_ids[]"
                                                            value="{{ $potongan->id }}">
                                                        <button type="button"
                                                            class="btn btn-outline-danger removePotongan mb-3"><i
                                                                class="fa fa-trash"></i> Hapus
                                                            Potongan</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" id="addPotonganEdit" class="btn btn-outline-success"> <i
                                                class="fa fa-plus"></i> Tambah Potongan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </form>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <div class="footer">
        <div class="copyright">
        </div>
    </div>

    {{-- Komponen Edit Tunjangan --}}

    <script>
        $(document).ready(function() {
            var counter = 0;


            function addTunjanganInput() {
                var newTunjangan = `
        <div class="tunjangan">
            <div class="form-group mb-3">
                <label for="nama_tunjangan${counter}">Nama Tunjangan</label>
                <select class="form-control select2" name="nama_tunjangan[]"
                        id="tunjangannew_id${counter}" style="width: 100%;" required>
                        <option value="__create__">Lainnya</option>
                        <option value="" disabled selected>-- Pilih Tunjangan --</option>
                        @foreach ($tunjangans as $tunjangan)
                            <option value="{{ $tunjangan->nama_tunjangan }}">
                                {{ $tunjangan->nama_tunjangan }}
                            </option>
                        @endforeach
                    </select>
            </div>
            <div class="form-group mb-3">
                <label for="nilai_tunjangan${counter}">Nilai Tunjangan</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input class="form-control nilai-tunjangan gray-border" type="text" name="nilai_tunjangan[]" oninput="addCommas2(this)" required>
                </div>
            </div>
            <button type="button" class="btn btn-outline-danger removeTunjangan mb-3"> <i class="fa fa-trash"></i>  Hapus Tunjangan</button>
        </div>
    `;
                $("#tunjanganContainer").append(newTunjangan);
                counter++;

                // Inisialisasi Select2 pada elemen yang baru ditambahkan
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            }

            $("#addTunjanganEdit").click(function() {
                addTunjanganInput();
            });

            $(document).on("click", ".removeTunjangan", function() {
                var tunjanganElement = $(this).closest('.tunjangan');
                tunjanganElement.remove(); // Hapus elemen secara visual
                updateTunjanganIds();
            });

            function updateTunjanganIds() {
                var tunjanganIds = [];

                $(".tunjangan").each(function(index) {
                    var tunjanganId = $(this).find("[name='tunjangan_ids[]']").val();

                    // Tambahkan logika untuk menetapkan id baru untuk tunjangan yang baru ditambahkan 
                    if (!tunjanganId) {
                        tunjanganId = "new_tunjangan_" + index;
                        $(this).find("[name='tunjangan_ids[]']").val(tunjanganId);
                    }
                    tunjanganIds.push(tunjanganId);
                });
                $("#tunjangan_ids").val(tunjanganIds.join(','));
            }

            // Inisialisasi Select2
            $('.select2').select2();

            // Menangani perubahan nilai pada elemen select
            $(document).on('change', '[id^="tunjangannew_id"]', async function() {
                // Mendapatkan nilai terpilih
                var selectedValue = $(this).val();

                // Cek apakah opsi "Buat Nilai Baru" dipilih
                if (selectedValue === '__create__') {
                    // Tampilkan modal SweetAlert2 untuk memasukkan nama Tunjangan baru
                    const {
                        value: newTunjanganName
                    } = await Swal.fire({
                        input: 'text',
                        inputLabel: 'Nama Tunjangan Baru',
                        inputPlaceholder: 'Masukkan Nama Tunjangan Baru',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Nama Tunjangan tidak boleh kosong!';
                            }
                        }
                    });

                    // Cek jika pengguna memasukkan nilai baru
                    if (newTunjanganName) {
                        // Tambahkan nilai baru ke dalam select
                        var newOption = new Option(newTunjanganName, newTunjanganName, true, true);
                        $(this).append(newOption).trigger('change');
                    } else {
                        // Batal jika pengguna membatalkan operasi
                        $(this).val('').trigger('change');
                    }
                }
            });
        });
    </script>

    {{-- Komponen Edit Potongan --}}

    <script>
        $(document).ready(function() {
            var counter = 0;

            function addPotonganInput() {
                var newPotongan = `
        <div class="potongan">
            <div class="form-group mb-3">
                <label for="nama_potongan${counter}">Nama Potongan</label>
                <select class="form-control select2" name="nama_potongan[]"
                        id="potongannew_id${counter}" style="width: 100%;" required>
                        <option value="__create__">Lainnya</option>
                        <option value="" disabled selected>-- Pilih Potongan --</option>
                        @foreach ($potongans as $potongan)
                            <option value="{{ $potongan->nama_potongan }}">
                                {{ $potongan->nama_potongan }}
                            </option>
                        @endforeach
                    </select>
            </div>
            <div class="form-group mb-3">
                <label for="nilai_potongan${counter}">Nilai Potongan</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input class="form-control nilai-potongan gray-border" type="text" name="nilai_potongan[]" oninput="addCommas2(this)" required>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="note_potongan${counter}">Catatan Potongan</label>
                <input class="form-control gray-border" type="text" name="note_potongan[]" id="note_potongan">
            </div>   
            <button type="button" class="btn btn-outline-danger removePotongan mb-3"> <i class="fa fa-trash"></i>  Hapus Potongan</button>
        </div>
    `;
                $("#potonganContainer").append(newPotongan);
                counter++;

                // Inisialisasi Select2 pada elemen yang baru ditambahkan
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            }

            $("#addPotonganEdit").click(function() {
                addPotonganInput();
            });

            $(document).on("click", ".removePotongan", function() {
                var potonganElement = $(this).closest('.potongan');
                potonganElement.remove(); // Hapus elemen secara visual
                updatePotonganIds();
            });

            function updatePotonganIds() {
                var potonganIds = [];

                $(".potongan").each(function(index) {
                    var potonganId = $(this).find("[name='potongan_ids[]']").val();

                    // Tambahkan logika untuk menetapkan id baru untuk potongan yang baru ditambahkan
                    if (!potonganId) {
                        potonganId = "new_potongan_" + index;
                        $(this).find("[name='potongan_ids[]']").val(potonganId);
                    }
                    potonganIds.push(potonganId);
                });

                $("#potongan_ids").val(potonganIds.join(','));
            }

            // Inisialisasi Select2
            $('.select2').select2();

            // Menangani perubahan nilai pada elemen select
            $(document).on('change', '[id^="potongannew_id"]', async function() {
                // Mendapatkan nilai terpilih
                var selectedValue = $(this).val();

                // Cek apakah opsi "Buat Nilai Baru" dipilih
                if (selectedValue === '__create__') {
                    // Tampilkan modal SweetAlert2 untuk memasukkan nama Potongan baru
                    const {
                        value: newPotonganName
                    } = await Swal.fire({
                        input: 'text',
                        inputLabel: 'Nama Potongan Baru',
                        inputPlaceholder: 'Masukkan Nama Potongan Baru',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Nama Potongan tidak boleh kosong!';
                            }
                        }
                    });

                    // Cek jika pengguna memasukkan nilai baru
                    if (newPotonganName) {
                        // Tambahkan nilai baru ke dalam select
                        var newOption = new Option(newPotonganName, newPotonganName, true, true);
                        $(this).append(newOption).trigger('change');
                    } else {
                        // Batal jika pengguna membatalkan operasi
                        $(this).val('').trigger('change');
                    }
                }
            });
        });
    </script>


@endsection
