<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastInformation extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'message'];

    public function sdm()
    {
        return $this->belongsTo(Sdm::class, 'category_id');
    }
}
