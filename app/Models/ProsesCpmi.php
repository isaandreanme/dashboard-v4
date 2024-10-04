<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Audit;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;

class ProsesCpmi extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;
    protected $guarded = [];

    // Relasi ke Pendaftaran
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    // Relasi ke Tujuan
    public function tujuan()
    {
        return $this->belongsTo(Tujuan::class);
    }

    // Relasi ke Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');  // 'status_id' adalah foreign key yang ada di tabel 'proses_cpmis'
    }

    // Relasi ke Sales
    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    // Relasi ke Marketing
    public function marketing()
    {
        return $this->belongsTo(Marketing::class);
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

    // Relasi ke Pengalaman
    public function pengalaman()
    {
        return $this->belongsTo(Pengalaman::class);
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

    public function formatAuditFieldsForPresentation($field, Audit $record)
    {
        $fields = Arr::wrap($record->{$field});

        $formattedResult = '<ul>';

        foreach ($fields as $key => $value) {
            $formattedResult .= '<li>';
            $formattedResult .= match ($key) {
                'user_id' => '<strong>User</strong> : ' . User::find($record->{$field}['user_id'])?->name . '<br />',
                'status_id' =>  '<strong>STATUS</strong> : ' . Status::find($value)?->nama . '<br />', // Menampilkan nama status
                'tujuan_id' =>  '<strong>TUJUAN</strong> : ' . Tujuan::find($value)?->nama . '<br />', // Menampilkan nama tujuan
                'tanggal_pra_bpjs' => '<strong>PRA BPJS</strong> : ' . $record->{$field}['tanggal_pra_bpjs'] . '<br />',
                'tanggal_ujk' => '<strong>UJK</strong> : ' . $record->{$field}['tanggal_ujk'] . '<br />',
                'tglsiapkerja' => '<strong>Tgl Siap Kerja</strong> : ' . $record->{$field}['tglsiapkerja'] . '<br />',
                'email_siapkerja' => '<strong>Email Siap Kerja</strong> : ' . $record->{$field}['email_siapkerja'] . '<br />',
                'password_siapkerja' => '<strong>Password Siap Kerja</strong> : ' . $record->{$field}['password_siapkerja'] . '<br />',
                'tgl_bp2mi' => '<strong>BP2MI</strong> : ' . $record->{$field}['tgl_bp2mi'] . '<br />',
                'no_id_pmi' => '<strong>ID PMI</strong> : ' . $record->{$field}['no_id_pmi'] . '<br />',
                'file_pp' => '<strong>File PP</strong> : ' . $record->{$field}['file_pp'] . '<br />',
                'tanggal_medical_full' => '<strong>Medical Full</strong> : ' . $record->{$field}['tanggal_medical_full'] . '<br />',
                'tanggal_ec' => '<strong>EC</strong> : ' . $record->{$field}['tanggal_ec'] . '<br />',
                'tanggal_visa' => '<strong>Visa</strong> : ' . $record->{$field}['tanggal_visa'] . '<br />',
                'tanggal_bpjs_purna' => '<strong>BPJS Purna</strong> : ' . $record->{$field}['tanggal_bpjs_purna'] . '<br />',
                'tanggal_teto' => '<strong>TETO</strong> : ' . $record->{$field}['tanggal_teto'] . '<br />',
                'tanggal_pap' => '<strong>PAP</strong> : ' . $record->{$field}['tanggal_pap'] . '<br />',
                'tanggal_penerbangan' => '<strong>Penerbangan</strong> : ' . $record->{$field}['tanggal_penerbangan'] . '<br />',
                'tanggal_in_toyo' => '<strong>In Toyo</strong> : ' . $record->{$field}['tanggal_in_toyo'] . '<br />',
                'tanggal_in_agency' => '<strong>In Agency</strong> : ' . $record->{$field}['tanggal_in_agency'] . '<br />',
                'file_medical_full' => '<strong>File Medical Full</strong> : ' . $record->{$field}['file_medical_full'] . '<br />',
                'file_ec' => '<strong>File EC</strong> : ' . $record->{$field}['file_ec'] . '<br />',
                'file_visa' => '<strong>File Visa</strong> : ' . $record->{$field}['file_visa'] . '<br />',
                'file_bpjs_purna' => '<strong>File BPJS Purna</strong> : ' . $record->{$field}['file_bpjs_purna'] . '<br />',
                'file_teto' => '<strong>File TETO</strong> : ' . $record->{$field}['file_teto'] . '<br />',
                'file_pap' => '<strong>File PAP</strong> : ' . $record->{$field}['file_pap'] . '<br />',
                'file_penerbangan' => '<strong>File Penerbangan</strong> : ' . $record->{$field}['file_penerbangan'] . '<br />',
                'file_in_toyo' => '<strong>File In Toyo</strong> : ' . $record->{$field}['file_in_toyo'] . '<br />',
                'file_in_agency' => '<strong>File In Agency</strong> : ' . $record->{$field}['file_in_agency'] . '<br />',


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
