<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use OwenIt\Auditing\Contracts\Audit;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;

class Pendaftaran extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $guarded = [];

    protected static ?string $recordTitleAttribute = 'nama';

    // Relasi ke Province
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    // Relasi ke Regency
    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    // Relasi ke District
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    // Relasi ke Village
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    // Relasi ke ProsesCpmi
    public function prosesCpmi()
    {
        return $this->hasMany(ProsesCpmi::class);
    }

    // Relasi ke Kantor
    public function kantor()
    {
        return $this->belongsTo(Kantor::class);
    }

    // Relasi ke Sponsor
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    // Relasi ke Tujuan
    public function tujuan()
    {
        return $this->belongsTo(Tujuan::class);
    }

    // Relasi ke Pengalaman
    public function pengalaman()
    {
        return $this->belongsTo(Pengalaman::class);
    }

    // Relasi ke Marketing
    public function marketing()
    {
        return $this->hasMany(Marketing::class);
    }

    // Mendapatkan usia dari tgl_lahir
    public function getAgeAttribute()
    {
        if ($this->tgl_lahir) {
            $dateOfBirth = Carbon::parse($this->tgl_lahir);
            return $dateOfBirth->age;
        }
        return 'N/A';
    }

    public function formatAuditFieldsForPresentation($field, Audit $record)
    {
        $fields = Arr::wrap($record->{$field});

        $formattedResult = '<ul>';

        foreach ($fields as $key => $value) {
            $formattedResult .= '<li>';
            $formattedResult .= match ($key) {
                'user_id' => '<strong>User</strong> : ' . User::find($record->{$field}['user_id'])?->name . '<br />',
                'kantor_id' =>  '<strong>KANTOR</strong> : ' . Kantor::find($value)?->nama . '<br />',
                'sponsor_id' =>  '<strong>SPONSOR-PL</strong> : ' . Sponsor::find($value)?->nama . '<br />',
                'pengalaman_id' =>  '<strong>PENGALAMAN</strong> : ' . Pengalaman::find($value)?->nama . '<br />',

                    // 'tanggal_pra_bpjs' => '<strong>PRA BPJS</strong> : ' . $record->{$field}['tanggal_pra_bpjs'] . '<br />',


                default => ' - ',
            };
            $formattedResult .= '</li>';
        }

        $formattedResult .= '</ul>';

        return new HtmlString($formattedResult);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
}
