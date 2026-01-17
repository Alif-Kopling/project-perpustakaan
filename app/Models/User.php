<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Model untuk entitas User
 * Menyimpan data pengguna aplikasi (admin dan siswa)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut ke tipe data tertentu
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Mengecek apakah user adalah admin
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Mengecek apakah user adalah siswa
     * @return bool
     */
    public function isStudent()
    {
        return $this->role === 'siswa';
    }

    /**
     * Mendapatkan data member yang terkait dengan user
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function member()
    {
        return $this->hasOne(Member::class, 'username', 'username');
    }
}
