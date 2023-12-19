<?php

namespace App\Exports;

use App\Absensi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GajiExport implements FromCollection, WithHeadings
{
    protected $items;

    public function __construct(Collection $items)
    {
        $this->items = $items;
    }

    public function collection()
    {
        return $this->items->map(function ($item) {
            $formattedTunjangan = $this->formatTunjangan($item->tunjangan);
            $formattedPotongan = $this->formatPotongan($item->potongan);

            return [
                'id' => $item->id,
                'sdm_id' => $item->sdm_id,
                'chat_id' => $item->chat_id,
                'bulan' => $item->bulan,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'nama' => $item->nama,
                'nik' => $item->nik,
                'jenis_kelamin' => $item->jenis_kelamin,
                'jabatan' => $item->jabatan,
                'tunjangan' => $formattedTunjangan,
                'potongan' => $formattedPotongan,
                'tunjangan_jabatan' => $item->tunjangan_jabatan,
                'entitas' => $item->entitas,
                'divisi' => $item->divisi,
            ];
        });
    }

    // Metode tambahan untuk memformat tunjangan
    private function formatTunjangan($tunjangan)
    {
        $formattedTunjangan = json_decode($tunjangan, true);
        $formattedString = '';

        foreach ($formattedTunjangan as $item) {
            $formattedString .= $item['nama_tunjangan'] . '=' . $item['nilai_tunjangan'] . ', ';
        }

        // Menghapus koma dan spasi terakhir
        $formattedString = rtrim($formattedString, ', ');

        return $formattedString;
    }

    // Metode tambahan untuk memformat potongan
    private function formatPotongan($potongan)
    {
        $formattedPotongan = json_decode($potongan, true);
        $formattedString = '';

        foreach ($formattedPotongan as $item) {
            $formattedString .= $item['nama_potongan'] . '=' . $item['nilai_potongan'] . ', ';
        }

        // Menghapus koma dan spasi terakhir
        $formattedString = rtrim($formattedString, ', ');

        return $formattedString;
    }


    public function headings(): array
    {
        return [
            'id',
            'sdm_id',
            'chat_id',
            'bulan',
            'created_at',
            'updated_at',
            'nama',
            'nik',
            'jenis_kelamin',
            'jabatan',
            'tunjangan',
            'potongan',
            'tunjangan_jabatan',
            'entitas',
            'divisi',
        ];
    }
}
