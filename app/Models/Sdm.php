<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sdm extends Model
{
    use HasFactory;
 
    protected $guarded = [];
    // for user_id
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    // for user_id
    public function entitas()
    {
        return $this->belongsTo(Entitas::class);
    }

    // for user_id
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    // for edit
    public function komponenGaji()
    {
        return $this->hasMany(KomponenGaji::class);
    }

    public function absensi()
    {
        return $this->hasOne(Absensi::class, 'sdm_id', 'id');
    }
    // for create
    public function komponenGajis()
    {
        return $this->hasOne(KomponenGaji::class);
    }


    // for edit
    public function potonganGaji()
    {
        return $this->hasMany(PotonganGaji::class);
    }
    // for create
    public function potonganGajis()
    {
        return $this->hasOne(PotonganGaji::class);
    }

    public function delete()
    {
        // Hapus terlebih dahulu komponen gaji (jika ada)
        if ($this->komponenGaji) {
            $this->komponenGaji->delete();
        }
        // Hapus terlebih dahulu potongan gaji (jika ada)
        if ($this->potonganGaji) {
            $this->potonganGaji->delete();
        }

        // Hapus user
        return parent::delete();
    }
}
