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
                <form novalidate action="{{ route('admin.sdm.store') }}" method="POST"
                    onsubmit="return validateForm() && removeCommas2();">
                    @csrf
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
                                                name="nama" value="{{ old('nama') }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="entitas">Entitas</label>
                                            <select class="form-control gray-border select2" name="entitas_id"
                                                id="entitas">
                                                <option value="">--Choose Categories--</option>
                                                @foreach ($entita as $entitas)
                                                    <option value="{{ $entitas->id }}"
                                                        @if (old('entitas_id') == $entitas->id) selected @endif>
                                                        {{ $entitas->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="divisi">Divisi</label>
                                            <select class="form-control gray-border select2" name="divisi_id"
                                                id="divisi">
                                                <option value="">--Choose Categories--</option>
                                                @foreach ($divisis as $divisi)
                                                    <option value="{{ $divisi->id }}"
                                                        @if (old('divisi_id') == $divisi->id) selected @endif>
                                                        {{ $divisi->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="jabatan">Jabatan</label>
                                            <select class="form-control gray-border select2" name="jabatan_id"
                                                id="jabatan">
                                                <option value="">--Choose Categories--</option>
                                                @foreach ($jabatans as $jabatan)
                                                    @if ($jabatan->deleted != 1)
                                                        <option value="{{ $jabatan->id }}"
                                                            data-tunjangan_jabatan="{{ $jabatan->tunjangan_jabatan }}"
                                                            @if (old('jabatan_id') == $jabatan->id) selected @endif>
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
                                                name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="nik">Nik</label>
                                            <input class="form-control gray-border" type="number" id="nik"
                                                name="nik" value="{{ old('nik') }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="default-select form-control wide gray-border"
                                                name="jenis_kelamin" id="jenis_kelamin">
                                                <option value="laki-laki">Laki-Laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="default-select form-control wide gray-border" name="status"
                                                id="status">
                                                <option value="1">Pegawai Tetap</option>
                                                <option value="0">Pegawai Tidak Tetap</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="basic-form">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Tunjangan</div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="tunjangan">
                                            <div class="form-group mb-3">
                                                <label for="nama_tunjangan[]">Nama Tunjangan</label>
                                                <select class="form-control select2" name="nama_tunjangan[]"
                                                    id="tunjangannew_id" style="width: 100%;" required>
                                                    <option value="__create__">Lainnya</option>
                                                    <option value="" disabled selected>-- Pilih Tunjangan --</option>
                                                    @foreach ($tunjangans as $tunjangan)
                                                        <option value="{{ $tunjangan->nama_tunjangan }}">
                                                            {{ $tunjangan->nama_tunjangan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    // Inisialisasi Select2
                                                    $('#tunjangannew_id').select2();

                                                    // Menangani perubahan nilai pada elemen select
                                                    $('#tunjangannew_id').on('change', async function() {
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
                                                <label for="nilai_tunjangan[]">Nilai Tunjangan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="text" name="nilai_tunjangan[]"
                                                        class="form-control nilai-tunjangan gray-border" required
                                                        oninput="addCommas2(this)">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-danger removeTunjanganAdd mb-3">
                                                <i class="fa fa-trash"></i> Hapus Tunjangan</button>
                                        </div>
                                        <div id="tunjanganContainer"></div>
                                        <button type="button" id="addTunjangan" class="btn btn-outline-success"> <i
                                                class="fa fa-plus"></i> Tambah Tunjangan</button>
                                        <p id="totalTunjangan">Total Tunjangan: Rp. 0</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Potongan</div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="potongan">
                                            <div class="form-group mb-3">
                                                <label for="nama_potongan[]">Nama Potongan</label>
                                                <select class="form-control select2" name="nama_potongan[]"
                                                    id="potongannew_id" style="width: 100%;" required>
                                                    <option value="__create__">Lainnya</option>
                                                    <option value="" disabled selected>-- Pilih Potongan --</option>
                                                    @foreach ($potongans as $potongan)
                                                        <option value="{{ $potongan->nama_potongan }}">
                                                            {{ $potongan->nama_potongan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    // Inisialisasi Select2
                                                    $('#potongannew_id').select2();

                                                    // Menangani perubahan nilai pada elemen select
                                                    $('#potongannew_id').on('change', async function() {
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
                                                <label for="nilai_potongan[]">Nilai Potongan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="text" name="nilai_potongan[]"
                                                        class="form-control nilai-potongan gray-border" required
                                                        oninput="addCommas2(this)">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-danger removePotonganAdd mb-3">
                                                <i class="fa fa-trash"></i> Hapus Potongan</button>
                                        </div>
                                        <div id="potonganContainer"></div>
                                        <button type="button" id="addPotongan" class="btn btn-outline-success"> <i
                                                class="fa fa-plus"></i> Tambah Potongan</button>
                                        <p id="totalPotongan">Total Potongan: Rp. 0</p>
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

    {{-- Komponen Add Tunjangan --}}

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
                    <button type="button" class="btn btn-outline-danger removeTunjanganAdd mb-3"> <i class="fa fa-trash"></i>  Hapus Tunjangan</button>
                </div>
            `;
                $("#tunjanganContainer").append(newTunjangan);
                counter++;

                // Inisialisasi Select2 pada elemen yang baru ditambahkan
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            }

            $("#addTunjangan").click(function() {
                addTunjanganInput();
            });

            function calculateTotalTunjangan() {
                var total = 0;
                $(".nilai-tunjangan").each(function() {
                    var nilai = parseFloat($(this).val().replace(/\D/g, ''));
                    if (!isNaN(nilai)) {
                        total += nilai;
                    }
                });

                // Menggunakan metode toLocaleString() untuk memisahkan ribuan dengan titik
                var formattedTotal = total.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });

                $("#totalTunjangan").text("Total Tunjangan: " + formattedTotal);
            }

            $(document).on("input", ".nilai-tunjangan", function() {
                calculateTotalTunjangan();
            });

            $(document).on("click", ".removeTunjanganAdd", function() {
                $(this).closest('.tunjangan')
                    .remove(); // Menghapus elemen yang mengandung elemen yang akan dihapus
                calculateTotalTunjangan(); // Rekalkulasi total
            });

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




    {{-- Komponen Add Potongan --}}

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
                    <button type="button" class="btn btn-outline-danger removePotonganAdd mb-3"> <i class="fa fa-trash"></i>  Hapus Potongan</button>
                </div>
            `;
                $("#potonganContainer").append(newPotongan);
                counter++;

                // Inisialisasi Select2 pada elemen yang baru ditambahkan
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            }

            $("#addPotongan").click(function() {
                addPotonganInput();
            });

            function calculateTotalPotongan() {
                var total = 0;
                $(".nilai-potongan").each(function() {
                    var nilai = parseFloat($(this).val().replace(/\D/g, ''));
                    if (!isNaN(nilai)) {
                        total += nilai;
                    }
                });

                // Menggunakan metode toLocaleString() untuk memisahkan ribuan dengan titik
                var formattedTotal = total.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });

                $("#totalPotongan").text("Total Potongan: " + formattedTotal);
            }

            $(document).on("input", ".nilai-potongan", function() {
                calculateTotalPotongan();
            });

            $(document).on("click", ".removePotonganAdd", function() {
                $(this).closest('.potongan')
                    .remove(); // Menghapus elemen yang mengandung elemen yang akan dihapus
                calculateTotalPotongan(); // Rekalkulasi total
            });

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
