<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = ['nama']; // Pastikan kolom 'nama' ada di tabel status
    
    public function Pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
    public function ProsesCpmi()
    {
        return $this->hasMany(ProsesCpmi::class);
    }
    public function Marketing()
    {
        return $this->hasMany(Marketing::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
