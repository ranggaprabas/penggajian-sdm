<?php

namespace App\Imports;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GajiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $sdmId = $row['sdm_id'];
        $bulan = $row['bulan'];

        // Check if SDM already exists in Absensi for the specified month
        $isSdmInAbsensi = Absensi::where('sdm_id', $sdmId)
            ->where('bulan', $bulan)
            ->exists();

        // Jika SDM belum ada di dalam Absensi, simpan data
        if (!$isSdmInAbsensi) {
            $gaji = [
                'sdm_id' => $row['sdm_id'],
                'chat_id' => $row['chat_id'],
                'bulan' => $row['bulan'],
                'created_at' => Carbon::parse($row['created_at']),
                'updated_at' => Carbon::parse($row['updated_at']),
                'nama' => $row['nama'],
                'nik' => $row['nik'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'jabatan' => $row['jabatan'],
                'tunjangan' => $this->parseJsonArray($row['tunjangan']),
                'potongan' => $this->parsePotonganArray($row['potongan']),
                'tunjangan_jabatan' => $row['tunjangan_jabatan'],
                'entitas' => $row['entitas'],
                'divisi' => $row['divisi'],
            ];

            // Simpan data dan kembalikan instance model yang baru
            return new Absensi($gaji);
        }

        // Jika SDM sudah ada di dalam Absensi, kembalikan null atau false
        return null; // atau false
    }

    private function parseJsonArray($string)
    {
        $items = explode(', ', $string);

        return collect($items)
            ->map(function ($item) {
                // Use a more robust regex pattern to capture the key-value pairs
                if (preg_match('/^(.+)=(\d+)$/', $item, $matches)) {
                    $namaTunjangan = $matches[1];
                    $nilaiTunjangan = $matches[2];

                    return [
                        'nama_tunjangan' => $namaTunjangan,
                        'nilai_tunjangan' => (int)$nilaiTunjangan,
                    ];
                } else {
                    // Handle the case where the pattern doesn't match
                    return [];
                }
            })
            ->filter(); // Removes falsy values (empty arrays)
    }

    private function parsePotonganArray($string)
    {
        $items = explode(', ', $string);

        return collect($items)
            ->map(function ($item) {
                // Use a more robust regex pattern to capture the key-value pairs
                if (preg_match('/^(.+)=(\d+)$/', $item, $matches)) {
                    $namaPotongan = $matches[1];
                    $nilaiPotongan = $matches[2];

                    return [
                        'nama_potongan' => $namaPotongan,
                        'nilai_potongan' => (int)$nilaiPotongan,
                    ];
                } else {
                    // Handle the case where the pattern doesn't match
                    return [];
                }
            })
            ->filter(); // Removes falsy values (empty arrays)
    }
}
