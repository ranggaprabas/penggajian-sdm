<?php

namespace App\Imports;

use App\Models\Absensi;
use App\Models\Divisi;
use App\Models\Entitas;
use App\Models\Jabatan;
use App\Models\Sdm;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GajiImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $createdOrUpdatedAbsensi = [];

        foreach ($rows as $row) {
            // Extract common fields
            $gajiData = [
                'id' => $row['id'],
                'sdm_id' => $row['sdm_id'],
                'chat_id' => $row['chat_id'],
                'bulan' => $row['bulan'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
                'nama' => $row['nama'],
                'email' => $row['email'],
                'nik' => $row['nik'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'jabatan' => $row['jabatan'],
                'tunjangan_jabatan' => $row['tunjangan_jabatan'],
                'entitas' => $row['entitas'],
                'divisi' => $row['divisi'],
            ];

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
                'chat_id' => $row['chat_id'],
                // ... (add other fields as needed)
            ];

             // Update or create related data in the SDM table
             $sdm = Sdm::updateOrCreate(
                ['id' => $row['sdm_id']],
                $sdmData + [
                    'entitas_id' => Entitas::firstOrCreate(['nama' => $row['entitas']])->id,
                    'divisi_id' => Divisi::firstOrCreate(['nama' => $row['divisi']])->id,
                    'jabatan_id' => Jabatan::firstOrCreate(['nama' => $row['jabatan']])->id,
                    'jenis_kelamin' => $row['jenis_kelamin'],
                ]
            );
            // Update also tunjangan and potongan in the KomponenGaji and PotonganGaji models
            $this->updateOrCreateKomponenGaji($sdm, $tunjangan);
            $this->updateOrCreatePotonganGaji($sdm, $potongan);
        }

        return $createdOrUpdatedAbsensi;
    }



    private function extractColumnValues($row, $prefix, $sdmId)
    {
        $values = [];
        foreach ($row as $key => $value) {
            if ($key !== 'tunjangan_jabatan' && strpos($key, $prefix) === 0 && $value !== null) {
                $columnName = substr($key, strlen($prefix));

                // Gunakan fungsi formatColumnName untuk mengubah nama kolom
                $formattedColumnName = $this->formatColumnName($columnName);

                $values[] = [
                    'sdm_id' => $sdmId,
                    'nama_tunjangan' => $formattedColumnName,
                    'nilai_tunjangan' => $value,
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

                $values[] = [
                    'sdm_id' => $sdmId,
                    'nama_potongan' => $formattedColumnName,
                    'nilai_potongan' => $value,
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
            ]);
        }
    }
    }
