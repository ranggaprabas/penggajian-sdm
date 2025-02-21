<?php

namespace App\Imports;

use App\Models\Absensi;
use App\Models\Divisi;
use App\Models\Entitas;
use App\Models\Jabatan;
use App\Models\Sdm;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GajiImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $createdOrUpdatedAbsensi = [];
        $user = Auth::user();
        $entitasAdmin = $user->entitas->nama;

        foreach ($rows as $row) {
            // Jika status user adalah 1, atau entitas dalam baris cocok dengan entitas pengguna yang sedang login
            if ($user->status == 1 || $row['entitas'] === $entitasAdmin) {
                // Extract common fields
                $gajiData = $this->extractCommonFields($row);

                // Extract tunjangan and potongan dynamically
                $tunjangan = $this->extractColumnValues($row, 'tunjangan_', $row['sdm_id']);
                $potongan = $this->extractColumnValuesPotongan($row, 'potongan_', $row['sdm_id']);

                // Cek apakah data untuk bulan dan SDM tertentu sudah ada dalam Absensi
                $existingAbsensi = Absensi::where('bulan', $row['bulan'])
                    ->where('sdm_id', $row['sdm_id'])
                    ->first();

                if (!$existingAbsensi) {
                    // Data untuk bulan dan SDM tertentu belum ada, buat entitas baru dan simpan
                    $createdOrUpdatedAbsensi[] = Absensi::create(array_merge($gajiData, ['tunjangan' => $tunjangan, 'potongan' => $potongan]));
                } else {
                    // Data untuk bulan dan SDM tertentu sudah ada, perbarui entitas
                    $existingAbsensi->update(array_merge($gajiData, ['tunjangan' => $tunjangan, 'potongan' => $potongan]));
                    $createdOrUpdatedAbsensi[] = $existingAbsensi;
                }

                // Simpan atau perbarui data di tabel SDM
                $sdmData = [
                    'nama' => $row['nama'],
                    'email' => $row['email'],
                    'nik' => $row['nik'],
                    'status' => $row['status'],
                    'chat_id' => $row['chat_id'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'gaji_pokok' => $row['gaji_pokok'],
                ];

                // Update or create related data in the SDM table
                $sdm = Sdm::updateOrCreate(
                    ['id' => $row['sdm_id']],
                    $sdmData + [
                        'entitas_id' => Entitas::firstOrCreate(['nama' => $row['entitas']])->id,
                        'divisi_id' => $this->getOrCreateDivisiId($row),
                    ]
                );

                // Cari jabatan berdasarkan nama
                $jabatan = Jabatan::where('nama', $row['jabatan'])->where('tunjangan_jabatan', $row['tunjangan_jabatan'])->first();

                // Jika jabatan tidak ditemukan, buat jabatan baru
                if (!$jabatan) {
                    $jabatan = Jabatan::create([
                        'nama' => $row['jabatan'],
                        'tunjangan_jabatan' => $row['tunjangan_jabatan'],
                        'entitas_id' => $sdm->entitas_id,
                    ]);
                }

                // Simpan ID jabatan pada entitas SDM
                $sdm->jabatan_id = $jabatan->id;
                $sdm->save();

                // Update also tunjangan and potongan in the KomponenGaji and PotonganGaji models
                $this->updateOrCreateKomponenGaji($sdm, $tunjangan);
                $this->updateOrCreatePotonganGaji($sdm, $potongan);
            }
        }

        return $createdOrUpdatedAbsensi;
    }

    private function getOrCreateDivisiId($row)
    {
        $entitasId = Entitas::firstOrCreate(['nama' => $row['entitas']])->id;
        $divisi = Divisi::where('entitas_id', $entitasId)->where('nama', $row['divisi'])->first();

        if (!$divisi) {
            // Jika divisi belum ada, buat divisi baru
            $divisi = Divisi::create([
                'nama' => $row['divisi'],
                'entitas_id' => $entitasId,
            ]);
        }

        return $divisi->id;
    }

    private function extractCommonFields($row)
    {
        return [
            'id' => $row['id'],
            'sdm_id' => $row['sdm_id'],
            'chat_id' => $row['chat_id'],
            'bulan' => $row['bulan'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'nama' => $row['nama'],
            'email' => $row['email'],
            'status' => $row['status'],
            'nik' => $row['nik'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'jabatan' => $row['jabatan'],
            'tunjangan_jabatan' => $row['tunjangan_jabatan'],
            'entitas' => $row['entitas'],
            'divisi' => $row['divisi'],
            'gaji_pokok' => $row['gaji_pokok'],
        ];
    }



    private function extractColumnValues($row, $prefix, $sdmId)
    {
        $values = [];
        foreach ($row as $key => $value) {
            if ($key !== 'tunjangan_jabatan' && strpos($key, $prefix) === 0 && $value !== null) {
                $columnName = substr($key, strlen($prefix));

                // Gunakan fungsi formatColumnName untuk mengubah nama kolom
                $formattedColumnName = $this->formatColumnName($columnName);

                // Extract note column
                $noteColumnName = 'note_' . $prefix . $columnName;
                $noteValue = $row[$noteColumnName] ?? null;

                $values[] = [
                    'sdm_id' => $sdmId,
                    'nama_tunjangan' => $formattedColumnName,
                    'nilai_tunjangan' => $value,
                    'note_tunjangan' => $noteValue,
                ];
            }
        }

        return json_encode($values);
    }

    private function extractColumnValuesPotongan($row, $prefix, $sdmId)
    {
        $values = [];
        foreach ($row as $key => $value) {
            if (strpos($key, $prefix) === 0 && $value !== null) {
                $columnName = substr($key, strlen($prefix));

                // Gunakan fungsi formatColumnName untuk mengubah nama kolom
                $formattedColumnName = $this->formatColumnName($columnName);

                // Extract note column
                $noteColumnName = 'note_' . $prefix . $columnName;
                $noteValue = $row[$noteColumnName] ?? null;

                $values[] = [
                    'sdm_id' => $sdmId,
                    'nama_potongan' => $formattedColumnName,
                    'nilai_potongan' => $value,
                    'note_potongan' => $noteValue,
                ];
            }
        }

        return json_encode($values);
    }

    // Fungsi untuk mengonversi kata menjadi format yang diinginkan
    private function formatColumnName($columnName)
    {
        return ucwords(str_replace('_', ' ', $columnName));
    }

    private function updateOrCreateKomponenGaji($sdm, $tunjangans)
    {
        $komponenGaji = $sdm->komponenGaji();

        // Hapus tunjangan lama
        $komponenGaji->delete();

        // Tambahkan tunjangan baru
        foreach (json_decode($tunjangans, true) as $tunjangan) {
            $komponenGaji->create([
                'sdm_id' => $sdm->id,
                'nama_tunjangan' => ucwords($tunjangan['nama_tunjangan']),
                'nilai_tunjangan' => $tunjangan['nilai_tunjangan'],
                'note_tunjangan' => $tunjangan['note_tunjangan'] ?? null,
            ]);
        }
    }

    private function updateOrCreatePotonganGaji($sdm, $potongans)
    {
        $potonganGaji = $sdm->potonganGaji();

        // Hapus potongan lama
        $potonganGaji->delete();

        // Tambahkan potongan baru
        foreach (json_decode($potongans, true) as $potongan) {
            $potonganGaji->create([
                'sdm_id' => $sdm->id,
                'nama_potongan' => ucwords($potongan['nama_potongan']),
                'nilai_potongan' => $potongan['nilai_potongan'],
                'note_potongan' => $potongan['note_potongan'] ?? null,
            ]);
        }
    }
}
