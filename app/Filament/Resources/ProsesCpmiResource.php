<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProsesCpmiResource\Pages;
use App\Filament\Resources\ProsesCpmiResource\RelationManagers;
use App\Models\ProsesCpmi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Pendaftaran;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Filament\Tables\Actions\Action;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Exports\ProsesCpmiExporter;
use Filament\Forms\Components\Fieldset;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Carbon\Carbon;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables\Actions\ExportAction;
use IbrahimBougaoua\FilaProgress\Tables\Columns\ProgressBar;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class ProsesCpmiResource extends Resource
{
    protected static ?string $model = ProsesCpmi::class;

    // protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';
    protected static ?string $navigationLabel = 'PROSES CPMI';
    protected static ?int $navigationSort = -1;
    protected static ?string $navigationGroup = 'PROSES';


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('PENDAFTARAN')
                    ->description('Data Pendaftaran')
                    ->icon('heroicon-m-check-badge')
                    ->schema([
                        Select::make('status_id',)
                            ->relationship('Status', 'nama')
                            ->required()
                            ->placeholder('Pilih Status CPMI')
                            ->label('Status CPMI'),
                        Select::make('tujuan_id',)
                            ->relationship('Tujuan', 'nama')
                            ->required()
                            ->placeholder('Pilih Negara Tujuan')
                            ->label('Negara Tujuan'),
                        Select::make('pendaftaran_id',)
                            ->relationship('Pendaftaran', 'nama')
                            ->getOptionLabelFromRecordUsing(fn(Pendaftaran $record) => "{$record->nama}")
                            ->label('Nama')
                            ->searchable(),
                        // ->disabled(),
                        Select::make('pendaftaran_id',)
                            ->relationship('Pendaftaran', 'nomor_ktp')
                            ->getOptionLabelFromRecordUsing(fn(Pendaftaran $record) => "{$record->nomor_ktp}")
                            ->label('E-KTP')
                            ->disabled(),
                    ])->columns(4),

                Section::make('SIAP KERJA / ID BP2MI')
                    ->description('Silahkan Input Akun SiapKerja')
                    ->icon('heroicon-o-briefcase')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Fieldset::make('PRA BPJS DAN UJK')
                                    ->schema([
                                        DatePicker::make('tanggal_pra_bpjs')->label('Tanggal PRA BPJS')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                        DatePicker::make('tanggal_ujk')->label('Tanggal UJK')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),

                                    ]),
                                DatePicker::make('tglsiapkerja')
                                    ->label('Tanggal SiapKerja')
                                    ->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                TextInput::make('email_siapkerja')
                                    ->label('Email  Akun SiapKerja')
                                    ->placeholder('Contoh. mario@gmail.com')
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('password_siapkerja')
                                    ->label('Password Akun SiapKerja')
                                    ->placeholder('Password Akun SiapKerja')
                                    ->maxLength(255),
                                DatePicker::make('tgl_bp2mi')
                                    ->label('Tanggal ID BP2MI')
                                    ->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                TextInput::make('no_id_pmi')
                                    ->placeholder('Masukan NO ID CPMI')
                                    ->label('ID SISKO BP2MI'),
                                FileUpload::make('file_pp')->disk('public')->label('Perjanjian Penempatan')
                                    ->directory('datapmi/file_pp')
                                    ->loadingIndicatorPosition('right')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->openable()
                                    ->previewable()
                                    ->downloadable(),



                            ]),
                    ])->columns(4)->collapsed(),
                Section::make('INPUT PROSES')
                    ->description('Silahkan Update Proses CPMI')
                    ->icon('heroicon-o-arrow-path-rounded-square')
                    ->schema([
                        Fieldset::make('')
                            ->schema([
                                DatePicker::make('tanggal_medical_full')->label('TANGGAL MEDICAL FULL (2)')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                FileUpload::make('file_medical_full')->disk('public')->label('Pilih File')
                                    ->directory('datapmi/file_pp')
                                    ->loadingIndicatorPosition('right')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->openable()
                                    ->previewable()
                                    ->downloadable(),
                            ])->columns(2),
                        Fieldset::make('')
                            ->schema([
                                DatePicker::make('tanggal_ec')->label('TANGGAL EC/KONTRAK (3)')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                FileUpload::make('file_ec')->disk('public')->label('Pilih File')
                                    ->directory('datapmi/file_pp')
                                    ->loadingIndicatorPosition('right')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->openable()
                                    ->previewable()
                                    ->downloadable(),
                            ])->columns(2),
                        Fieldset::make('')
                            ->schema([
                                DatePicker::make('tanggal_visa')->label('TANGGAL VISA (4)')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                FileUpload::make('file_visa')->disk('public')->label('Pilih File')
                                    ->directory('datapmi/file_pp')
                                    ->loadingIndicatorPosition('right')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->openable()
                                    ->previewable()
                                    ->downloadable(),
                            ])->columns(2),
                        Fieldset::make('')
                            ->schema([
                                DatePicker::make('tanggal_bpjs_purna')->label('TANGGAL BPJS PURNA (5)')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                FileUpload::make('file_bpjs_purna')->disk('public')->label('Pilih File')
                                    ->directory('datapmi/file_pp')
                                    ->loadingIndicatorPosition('right')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->openable()
                                    ->previewable()
                                    ->downloadable(),
                            ])->columns(2),
                        Fieldset::make('')
                            ->schema([
                                DatePicker::make('tanggal_teto')->label('TANGGAL TETO (TAIWAN) (6)')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                FileUpload::make('file_teto')->disk('public')->label('Pilih File')
                                    ->directory('datapmi/file_pp')
                                    ->loadingIndicatorPosition('right')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->openable()
                                    ->previewable()
                                    ->downloadable(),
                            ])->columns(2),
                        Fieldset::make('')
                            ->schema([
                                DatePicker::make('tanggal_pap')->label('TANGGAL PAP BP2MI (7)')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                FileUpload::make('file_pap')->disk('public')->label('Pilih File')
                                    ->directory('datapmi/file_pp')
                                    ->loadingIndicatorPosition('right')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->openable()
                                    ->previewable()
                                    ->downloadable(),
                            ])->columns(2),
                        Fieldset::make('')
                            ->schema([
                                DatePicker::make('tanggal_penerbangan')->label('TANGGAL PENERBANGAN (8)')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                FileUpload::make('file_penerbangan')->disk('public')->label('Pilih File')
                                    ->directory('datapmi/file_pp')
                                    ->loadingIndicatorPosition('right')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->openable()
                                    ->previewable()
                                    ->downloadable(),
                            ])->columns(2),
                        Fieldset::make('')
                            ->schema([
                                DatePicker::make('tanggal_in_toyo')->label('TANGGAL INVOICE TOYO (9)')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                FileUpload::make('file_in_toyo')->disk('public')->label('Pilih File')
                                    ->directory('datapmi/file_pp')
                                    ->loadingIndicatorPosition('right')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->openable()
                                    ->previewable()
                                    ->downloadable(),
                            ])->columns(2),
                        Fieldset::make('')
                            ->schema([
                                DatePicker::make('tanggal_in_agency')->label('TANGGAL INVOICE AGENCY (10)')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                                FileUpload::make('file_in_agency')->disk('public')->label('Pilih File')
                                    ->directory('datapmi/file_pp')
                                    ->loadingIndicatorPosition('right')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->openable()
                                    ->previewable()
                                    ->downloadable(),
                            ])->columns(2),
                    ])->columns(2)->collapsed(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                TextColumn::make('Pendaftaran.nama')->label('CPMI')->weight('bold')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
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
                SelectFilter::make('Tujuan')
                    ->relationship('Tujuan', 'nama')
                    ->label('TUJUAN')
                    ->placeholder('SEMUA'),
                SelectFilter::make('kantor_id')
                    ->relationship('Pendaftaran.Kantor', 'nama')
                    ->label('KANTOR')
                    ->placeholder('SEMUA'),
                SelectFilter::make('Status')
                    ->relationship('Status', 'nama')
                    ->label('STATUS')
                    ->multiple()
                    ->optionsLimit(6)
                    ->preload()
                    ->placeholder('Pilih Satu Atau Beberapa'),
            ], layout: FiltersLayout::Modal)
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label('FILTER'),
            )->filtersFormColumns(3)
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Ubah')
                        ->color('primary'),
                    Tables\Actions\DeleteAction::make(),

                ])
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(ProsesCpmiExporter::class)
                    ->columnMapping(true)
                    ->label('Unduh Data Proses CPMI')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->formats([
                        ExportFormat::Xlsx,
                    ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportAction::make()
                        ->exporter(ProsesCpmiExporter::class)
                        ->columnMapping(true)
                        ->label('Unduh Data Proses CPMI')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->formats([
                            ExportFormat::Xlsx,
                        ]),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AuditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProsesCpmis::route('/'),
            'create' => Pages\CreateProsesCpmi::route('/create'),
            'edit' => Pages\EditProsesCpmi::route('/{record}/edit'),
            'view' => Pages\ViewProsesCpmi::route('/{record}'),  // Tambahkan ini

        ];
    }
}
