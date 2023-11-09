<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotonganGaji extends Model
{
    use HasFactory;
    protected $guarded = [];
 
    public function sdm()
    {
        return $this->belongsTo(Sdm::class);
    }
}
