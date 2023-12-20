<?php

namespace App\Imports;

use App\Models\Absensi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GajiImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
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
                'nik' => $row['nik'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'jabatan' => $row['jabatan'],
                'tunjangan_jabatan' => $row['tunjangan_jabatan'],
                'entitas' => $row['entitas'],
                'divisi' => $row['divisi'],
            ];

            // Extract tunjangan and potongan dynamically
            $tunjangan = $this->extractColumnValues($row, 'tunjangan_');
            $potongan = $this->extractColumnValuesPotongan($row, 'potongan_');

            // Combine common fields and extracted values
            $gaji = Absensi::updateOrCreate(
                ['id' => $row['id']],
                array_merge($gajiData, ['tunjangan' => $tunjangan, 'potongan' => $potongan])
            );
        }
    }


    private function extractColumnValues($row, $prefix)
    {
        $values = [];
        foreach ($row as $key => $value) {
            if ($key !== 'tunjangan_jabatan' && strpos($key, $prefix) === 0 && $value !== null) {
                $columnName = substr($key, strlen($prefix));

                // Gunakan fungsi formatColumnName untuk mengubah nama kolom
                $formattedColumnName = $this->formatColumnName($columnName);

                $values[] = [
                    'nama_tunjangan' => $formattedColumnName,
                    'nilai_tunjangan' => $value,
                ];
            }
        }

        return json_encode($values);
    }

    private function extractColumnValuesPotongan($row, $prefix)
    {
        $values = [];
        foreach ($row as $key => $value) {
            if (strpos($key, $prefix) === 0 && $value !== null) {
                $columnName = substr($key, strlen($prefix));

                // Gunakan fungsi formatColumnName untuk mengubah nama kolom
                $formattedColumnName = $this->formatColumnName($columnName);

                $values[] = [
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
}
