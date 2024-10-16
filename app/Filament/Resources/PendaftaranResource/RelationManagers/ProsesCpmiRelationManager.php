<?php

namespace App\Filament\Resources\PendaftaranResource\RelationManagers;

use App\Models\Pendaftaran;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\ProsesCpmiResource;
use App\Models\ProsesCpmi;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use IbrahimBougaoua\FilaProgress\Tables\Columns\ProgressBar;

class ProsesCpmiRelationManager extends RelationManager
{
    protected static string $relationship = 'ProsesCpmi';
    protected static ?string $title = 'PROSES CPMI';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Informasi Pendaftaran')
                        ->schema([
                            DatePicker::make('created_at')
                                ->prefixIcon('heroicon-m-check-circle')
                                ->prefixIconColor('success')
                                ->prefix('PILIH TANGGAL')
                                ->label('Tanggal Pendaftaran')
                                ->required()
                                ->displayFormat('d/m/Y')
                                ->format('Y-m-d'), // Internal ISO format (YYYY-MM-DD),
                        ]),
                    Step::make('Status dan Tujuan')
                        ->schema([
                            Select::make('status_id')
                                ->relationship('Status', 'nama')
                                ->required()
                                ->placeholder('Pilih Status CPMI')
                                ->label('Status CPMI'),
                            Select::make('tujuan_id')
                                ->relationship('Tujuan', 'nama')
                                ->required()
                                ->placeholder('Pilih Negara Tujuan')
                                ->label('Negara Tujuan'),
                        ]),
                    Step::make('Pelatihan')
                        ->schema([
                            Select::make('pelatihan_id')
                                ->relationship('Pelatihan', 'nama')
                                ->required()
                                ->placeholder('Pilih LPKS')
                                ->label('LPKS/BLK'),
                        ]),
                ]),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                ProgressBar::make('PROGRESS')
                    ->label('PROGRESS')
                    ->getStateUsing(function ($record) {
                        // Cek apakah status_id adalah 3
                        if ($record->status_id == 3) {
                            // Jika status_id adalah 3, langsung kembalikan progres 100%
                            return [
                                'total' => 100,
                                'progress' => 100,
                            ];
                        }

                        // Cek apakah status_id adalah 1 atau 2
                        if (!in_array($record->status_id, [1, 2])) {
                            // Jika status_id bukan 1 atau 2, progres tidak dihitung (return null atau 0 progres)
                            return [
                                'total' => 0,
                                'progress' => 0,
                            ];
                        }

                        // Daftar field tanggal yang ingin diperiksa (semua berupa tanggal)
                        $fields = [
                            'tanggal_pra_bpjs',
                            'tanggal_ujk',
                            'tglsiapkerja',
                            'tgl_bp2mi',
                            'tanggal_medical_full',
                            'tanggal_ec',
                            'tanggal_visa',
                            'tanggal_bpjs_purna',
                            'tanggal_pap',
                            'tanggal_penerbangan',
                        ];

                        // Mengakses tanggal_pra_medical dan data_lengkap dari relasi pendaftaran
                        if ($record->pendaftaran) {
                            $fields[] = 'pendaftaran.tanggal_pra_medical';  // Field untuk tanggal_pra_medical
                            $fields[] = 'pendaftaran.data_lengkap';          // Field boolean untuk data_lengkap
                        }

                        // Menghitung total field
                        $total = count($fields);

                        // Menghitung field yang terisi (tidak null atau boolean true untuk data_lengkap)
                        $filled = collect($fields)
                            ->reduce(function ($count, $field) use ($record) {
                                // Memeriksa field dari relasi (misalnya pendaftaran.tanggal_pra_medical)
                                if (str_contains($field, '.')) {
                                    [$relation, $fieldName] = explode('.', $field);
                                    $value = $record->$relation->$fieldName;
                                    // Jika field adalah 'data_lengkap', harus bernilai true
                                    if ($fieldName === 'data_lengkap') {
                                        return $count + ($value === true ? 1 : 0);
                                    }
                                    // Field tanggal harus tidak null (misalnya tanggal_pra_medical)
                                    return $count + (!is_null($value) ? 1 : 0);
                                }
                                // Memeriksa field biasa (tanggal di record) yang tidak boleh null
                                return $count + (!is_null($record->$field) ? 1 : 0);
                            }, 0);

                        // Menghitung persentase progress
                        $progress = ($filled / $total) * 100;

                        // Debugging log untuk membantu memeriksa field yang terisi
                        logger('Total fields: ' . $total);
                        logger('Filled fields: ' . $filled);
                        logger('Progress: ' . $progress);

                        // Mengembalikan total dan progress dalam bentuk persentase
                        return [
                            'total' => 100,  // Persentase total
                            'progress' => $progress,  // Persentase progress
                        ];
                    }),
                TextColumn::make('Status.nama')->label('STATUS')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'BARU' => 'warning',
                        'ON PROSES' => 'info',
                        'TERBANG' => 'success',
                        'PENDING' => 'danger',
                        'UNFIT' => 'gray',
                        'MD' => 'gray',
                        default => 'secondary',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'BARU' => 'heroicon-o-bell',
                        'ON PROSES' => 'heroicon-o-arrow-path-rounded-square',
                        'TERBANG' => 'heroicon-o-paper-airplane',
                        'PENDING' => 'heroicon-o-clock',
                        'UNFIT' => 'heroicon-o-beaker',
                        'MD' => 'heroicon-o-x-circle',
                    })
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                TextColumn::make('pendaftaran.nama') // Pastikan relasi ke Pendaftaran ada
                    ->label('CPMI')
                    ->weight('bold')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500)
                    ->description(
                        fn(ProsesCpmi $record): string =>
                        $record->pendaftaran->nomor_ktp
                            ? "{$record->pendaftaran->nomor_ktp} - " . ($record->pendaftaran->user ? $record->pendaftaran->user->email : 'Akun Tidak Terhubung')
                            : 'No KTP available'
                    ),
                TextColumn::make('Pendaftaran.nomor_ktp')->label('E-KTP')->color('primary')
                    ->copyable()
                    ->searchable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500)
                    ->toggleable(isToggledHiddenByDefault: true),
                // ->limit(10),
                TextColumn::make('Pendaftaran.kantor.nama')->label('KANTOR')->color('success')
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500)->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('Tujuan.nama')->label('TUJUAN')->color('success')
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                TextColumn::make('Pendaftaran.tanggal_pra_medical')->label('PRA MEDICAL')
                    ->copyable()
                    ->sortable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                TextColumn::make('Pelatihan.nama')->label('LPKS/BLK')->color('success')
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                TextColumn::make('tgl_bp2mi')->label('TGL ID')
                    ->copyable()
                    ->sortable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                TextColumn::make('Pendaftaran.created_at')->label('LAMA PROSES')->color('warning')
                    ->since()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500)->toggleable(isToggledHiddenByDefault: false),

            ])->defaultSort('updated_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-m-check-badge')
                    ->label('PROSES CPMI BARU +'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Ubah')
                        ->color('primary'),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // protected function getCreatedNotification(): ?Notification
    // {
    //     $data = $this->record;

    //     // Buat tombol "View" dengan tipe yang benar
    //     $viewButton = NotificationAction::make('Lihat')
    //         ->url(ProsesCpmiResource::getUrl('view', ['record' => $data]));

    //     // Dapatkan nama pengguna yang sedang masuk
    //     $editor = Auth::user();
    //     $editorName = $editor ? $editor->name : 'Unknown';

    //     // Ambil semua penerima notifikasi
    //     $recipients = User::all();

    //     // Buat notifikasi dengan tombol "View"
    //     $notification = Notification::make()
    //         ->title('PROSES CPMI')
    //         ->body("<strong>{$data->nama}</strong> Berhasil Ditambahkan
    //                 <br>
    //                 Oleh <strong>{$editorName}</strong>")
    //         ->actions([$viewButton])
    //         ->persistent()
    //         ->success()
    //         ->duration(1000);

    //     // Kirim notifikasi ke semua penerima
    //     foreach ($recipients as $recipient) {
    //         $notification->sendToDatabase($recipient);
    //     }

    //     return $notification;
    // }
}
