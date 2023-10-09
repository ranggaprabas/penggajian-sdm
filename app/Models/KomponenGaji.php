<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenGaji extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function komponenGaji()
    {
        return $this->belongsTo(User::class);
    }
}
