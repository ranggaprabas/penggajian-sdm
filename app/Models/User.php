<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function entitas()
    {
        return $this->belongsTo(Entitas::class);
    }

    public function komponenGaji()
    {
        return $this->hasMany(KomponenGaji::class);
    }
    public function komponenGajis()
    {
        return $this->hasOne(KomponenGaji::class);
    }

    public function delete()
    {
        // Hapus terlebih dahulu komponen gaji (jika ada)
        if ($this->komponenGaji) {
            $this->komponenGaji->delete();
        }

        // Hapus user
        return parent::delete();
    }
}
