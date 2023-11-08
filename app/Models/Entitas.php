<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entitas extends Model
{
    use HasFactory;
    protected $table = 'entitas';

    protected $guarded = ['id'];
}
