<?php

// GajiImport.php

// GajiImport.php

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
        return new Absensi([
            'sdm_id' => $row['sdm_id'],
            'chat_id' => $row['chat_id'],
            'bulan' => $row['bulan'],
            'created_at' => Carbon::parse($row['created_at']),
            'updated_at' => Carbon::parse($row['updated_at']),
            'nama' => $row['nama'],
            'nik' => $row['nik'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'jabatan' => $row['jabatan'],
            'tunjangan' => $row['tunjangan'],
            'potongan' => $row['potongan'],
            'tunjangan_jabatan' => $row['tunjangan_jabatan'],
            'entitas' => $row['entitas'],
            'divisi' => $row['divisi'],
        ]);
    }
}
