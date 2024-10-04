<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $guarded = [];
    
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
}
