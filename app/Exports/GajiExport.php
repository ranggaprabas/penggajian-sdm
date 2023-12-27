<?php

namespace App\Exports;

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
        $formattedRows = [];

        foreach ($this->items as $item) {
            $formattedRow = [
                'id' => $item->id,
                'sdm_id' => $item->sdm_id,
                'chat_id' => $item->chat_id,
                'bulan' => $item->bulan,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'nama' => $item->nama,
                'email' => $item->email,
                'status' => $item->status,
                'nik' => $item->nik,
                'jenis_kelamin' => $item->jenis_kelamin,
                'jabatan' => $item->jabatan,
                'tunjangan_jabatan' => $item->tunjangan_jabatan,
                'entitas' => $item->entitas,
                'divisi' => $item->divisi,
            ];

            // Memisahkan tunjangan menjadi kolom baru
            $formattedRow += $this->formatTunjangan($item->tunjangan);

            // Memisahkan potongan menjadi kolom baru
            $formattedRow += $this->formatPotongan($item->potongan);

            $formattedRows[] = $formattedRow;
        }

        return collect($formattedRows);
    }

    private function formatTunjangan($tunjangan)
    {
        $formattedTunjangan = json_decode($tunjangan, true);
        $formattedColumns = [];

        foreach ($formattedTunjangan as $item) {
            $columnName = 'tunjangan_' . $item['nama_tunjangan'];
            $formattedColumns[$columnName] = $item['nilai_tunjangan'];
        }

        // Tambahkan kolom tambahan untuk tunjangan yang tidak memiliki nama belakang
        $tunjanganKeys = array_column($formattedTunjangan, 'nama_tunjangan');
        $allTunjanganKeys = array_unique(array_merge($this->getAllTunjanganKeys(), $tunjanganKeys));

        foreach ($allTunjanganKeys as $key) {
            $columnName = 'tunjangan_' . $key;
            if (!isset($formattedColumns[$columnName])) {
                $formattedColumns[$columnName] = null;
            }
        }

        return $formattedColumns;
    }

    private function formatPotongan($potongan)
    {
        $formattedPotongan = json_decode($potongan, true);
        $formattedColumns = [];

        foreach ($formattedPotongan as $item) {
            $columnName = 'potongan_' . $item['nama_potongan'];
            $formattedColumns[$columnName] = $item['nilai_potongan'];
        }

        // Tambahkan kolom tambahan untuk potongan yang tidak memiliki nama belakang
        $potonganKeys = array_column($formattedPotongan, 'nama_potongan');
        $allPotonganKeys = array_unique(array_merge($this->getAllPotonganKeys(), $potonganKeys));

        foreach ($allPotonganKeys as $key) {
            $columnName = 'potongan_' . $key;
            if (!isset($formattedColumns[$columnName])) {
                $formattedColumns[$columnName] = null;
            }
        }

        return $formattedColumns;
    }

    private function getAllTunjanganKeys()
    {
        $allKeys = [];

        foreach ($this->items as $item) {
            $formattedTunjangan = json_decode($item->tunjangan, true);
            $tunjanganKeys = array_column($formattedTunjangan, 'nama_tunjangan');
            $allKeys = array_merge($allKeys, $tunjanganKeys);
        }

        return array_unique($allKeys);
    }

    private function getAllPotonganKeys()
    {
        $allKeys = [];

        foreach ($this->items as $item) {
            $formattedPotongan = json_decode($item->potongan, true);
            $potonganKeys = array_column($formattedPotongan, 'nama_potongan');
            $allKeys = array_merge($allKeys, $potonganKeys);
        }

        return array_unique($allKeys);
    }

    public function headings(): array
    {
        $headings = [
            'id',
            'sdm_id',
            'chat_id',
            'bulan',
            'created_at',
            'updated_at',
            'nama',
            'email',
            'status',
            'nik',
            'jenis_kelamin',
            'jabatan',
            'tunjangan_jabatan',
            'entitas',
            'divisi',
        ];

        // Dapatkan nama tunjangan dan potongan dari SDM pertama
        $firstItem = $this->items->first();

        $tunjanganKeys = [];
        $potonganKeys = [];

        if ($firstItem) {
            $tunjanganKeys = array_keys($this->formatTunjangan($firstItem->tunjangan));
            $potonganKeys = array_keys($this->formatPotongan($firstItem->potongan));
        }

        // Tambahkan nama kolom tunjangan dan potongan
        $headings = array_merge($headings, $tunjanganKeys, $potonganKeys);

        return $headings;
    }
}
