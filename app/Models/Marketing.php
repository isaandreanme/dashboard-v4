<?php

namespace App\Models;

use EightyNine\Approvals\Models\ApprovableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketing extends ApprovableModel
{
    use HasFactory;
    protected $guarded = [];

    // Meng-cast 'pengalaman' sebagai JSON
    protected $casts = [
        'pengalaman' => 'array', // Laravel akan otomatis mengonversi ke array
    ];

    // Relasi ke Pendaftaran
    public function Pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    // Relasi ke ProsesCpmi
    public function prosesCpmi()
    {
        return $this->belongsTo(ProsesCpmi::class, 'pendaftaran_id');
    }

    // Relasi ke Tujuan
    public function tujuan()
    {
        return $this->belongsTo(Tujuan::class);
    }

    // Relasi ke Status
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // Relasi ke Sales
    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }

    // Relasi ke Sponsor
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    // Relasi ke Agency
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    // Relasi ke Kantor
    public function kantor()
    {
        return $this->belongsTo(Kantor::class);
    }

    // Relasi ke Regency
    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    // Relasi ke Village
    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }
    public function shouldBeHidden(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make("Done")
            ->color("success")
            ->hidden(fn(ApprovableModel $record) => $record->shouldBeHidden());
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getFotoUrlAttribute()
    {
        return asset('storage/' . $this->foto);
    }
}
