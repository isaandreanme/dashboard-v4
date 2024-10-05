<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel; // Pastikan untuk mengimpor Panel
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements
    HasAvatar
    // MustVerifyEmail
    // FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Tambahkan logika yang sesuai untuk menentukan akses
        return str_ends_with($this->email, '@example.com') && $this->hasVerifiedEmail();
    }

    // Relasi dengan Pendaftaran
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    // Relasi dengan Proses CPMI
    public function proses_cpmis()
    {
        return $this->hasMany(ProsesCpmi::class);
    }

    // Relasi dengan Marketings
    public function marketings()
    {
        return $this->hasMany(Marketing::class);
    }
}
