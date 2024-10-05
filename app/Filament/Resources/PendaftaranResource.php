<?php

namespace App\Filament\Resources;

use App\Filament\Exports\PendaftaranExporter;
use App\Filament\Resources\PendaftaranResource\Pages;
use App\Filament\Resources\PendaftaranResource\RelationManagers;
use App\Models\Pendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PendaftaranResource\RelationManagers\DataPmiRelationManager;
use App\Filament\Resources\PendaftaranResource\RelationManagers\MarketingRelationManager;
use App\Filament\Resources\PendaftaranResource\RelationManagers\ProsesCpmiRelationManager;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\Village;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Illuminate\Contracts\View\View;
use Filament\Actions\Exports\Enums\ExportFormat;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class PendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    // protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'PENDAFTARAN';
    protected static ?int $navigationSort = -20;
    protected static ?string $navigationGroup = 'PROSES';


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('AKUN CPMI')
                    ->description('Pilih Akun CPMI jika Sudah Registrasi Di Portal')->schema([
                        Select::make('user_id')
                            ->relationship('User', 'name')
                            ->placeholder('Pilih Akun CPMI')
                            ->label('Akun CPMI')
                            ->getOptionLabelFromRecordUsing(fn(User $record) => "{$record->name} ({$record->email})")
                            ->searchable()
                            ->optionsLimit(3),
                    ]),
                Fieldset::make('')
                    ->schema([
                        TextInput::make('nama')
                            ->rules('required')
                            ->placeholder('Masukan Nama Lengkap')
                            ->label('Nama CPMI'),
                        TextInput::make('nomor_ktp')
                            ->label('Nomor E-KTP')
                            ->rules('required')
                            ->placeholder('Masukan 16 Digit No KTP')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->numeric()
                            ->minLength(5)
                            ->maxLength(17),
                        TextInput::make('tempat_lahir')
                            ->rules('required')
                            ->placeholder('Masukan Tempat Lahir')
                            ->label('Tempat Lahir'),
                        DatePicker::make('tgl_lahir')
                            ->rules('required')
                            ->placeholder('Pilih Tanggal Lahir')
                            ->label('Tanggal Lahir')
                            ->native(false)->displayFormat('d/m/Y'),
                        TextInput::make('nomor_telp')
                            ->label('Nomor Telp CPMI')
                            ->placeholder('Contoh. 081xxxx')
                            ->numeric()
                            ->minLength(6)
                            ->maxLength(13),
                        TextInput::make('nomor_kk')
                            ->label('Nomor KK')
                            ->placeholder('Masukan 16 Digit No KK')
                            ->numeric()
                            ->minLength(5)
                            ->maxLength(17),
                        TextInput::make('nama_wali')
                            ->placeholder('Masukan Nama Wali / Suami')
                            ->label('Nama Wali'),
                        TextInput::make('nomor_ktp_wali')
                            ->label('Nomor E-KTP WALI')
                            ->rules('required')
                            ->placeholder('Masukan 16 Digit No KTP')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->numeric()
                            ->minLength(5)
                            ->maxLength(17),
                        Section::make('')
                            ->schema([
                                Select::make('kantor_id',)
                                    ->relationship('Kantor', 'nama')
                                    ->required()
                                    ->placeholder('Pilih Kantor Cabang')
                                    ->label('Kantor Cabang'),
                                Select::make('sponsor_id',)
                                    ->relationship('Sponsor', 'nama')
                                    ->placeholder('Pilih SPONSOR PL')
                                    ->searchable()
                                    ->required()
                                    ->preload()
                                    ->optionsLimit(3)
                                    ->label('SPONSOR PL')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('nama')->unique()
                                    ])
                                    ->required(),
                                Select::make('pengalaman_id',)
                                    ->relationship('Pengalaman', 'nama')
                                    ->required()
                                    ->placeholder('Pilih Pengalaman')
                                    ->label('Pengalaman CPMI'),
                            ])->columns(3),
                    ])->columns(4),

                Fieldset::make('ALAMAT')
                    ->schema([
                        TextInput::make('alamat')
                            ->placeholder('Masukan Alamat')
                            ->label('Alamat'),
                        TextInput::make('rtrw')
                            ->placeholder('Masukan RT / RW')
                            ->label('RT / RW')
                            // ->numeric()
                            ->minLength(7)
                            ->maxLength(7)
                            ->mask('999/999'),

                        //----------------------------------------------------------------
                        Select::make('province_id')
                            ->label('Provinsi')
                            ->options(Province::all()->pluck('name', 'id')->toArray())
                            ->reactive()
                            ->optionsLimit(3)
                            ->afterStateUpdated(fn(callable $set) => $set('regency_id', null))
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih Provinsi'),
                        Select::make('regency_id')
                            ->label('Kabupaten / Kota')
                            ->options(function (callable $get) {
                                $province = Province::find($get('province_id'));
                                if (!$province) {
                                    return Regency::pluck('name', 'id');
                                }
                                return $province->regencies->pluck('name', 'id');
                            })
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('district_id', null))
                            ->searchable()
                            ->preload()
                            ->optionsLimit(3)
                            ->placeholder('Cari Kabupaten / Kota'),
                        Select::make('district_id')
                            ->label('Kecamatan')
                            ->options(function (callable $get) {
                                $regencies = Regency::find($get('regency_id'));
                                if (!$regencies) {
                                    return District::pluck('name', 'id');
                                }
                                return $regencies->districts->pluck('name', 'id');
                            })
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('village_id', null))
                            ->searchable()
                            ->preload()
                            ->optionsLimit(3)
                            ->placeholder('Cari Kecamatan'),
                        Select::make('village_id')
                            ->searchable()
                            ->label('Kelurahan')
                            ->optionsLimit(3)
                            ->placeholder('Cari Kelurahan')
                            ->getSearchResultsUsing(function ($search, $get) {
                                if (!$get('regency_id')) {
                                    return [];
                                }
                                return Village::where('district_id', $get('district_id'))
                                    ->where('name', 'like', "%{$search}%")
                                    // ->Limit(3)
                                    ->pluck('name', 'id');
                            })
                            ->getOptionLabelUsing(fn($value): ?string => Village::find($value)?->name),
                    ])->columns(2),

                Fieldset::make('PRA MEDICAL')
                    ->schema([
                        DatePicker::make('tanggal_pra_medical')->label('Tanggal Pra Medical')->placeholder('Pilih Tanggal')->native(false)->displayFormat('d/m/Y'),
                        TextInput::make('pra_medical')->placeholder('Keterangan')->label('Hasil Pra Medical'),
                        FileUpload::make('file_medical')->label('Upload Hasil Medical')
                            ->disk('public')
                            ->directory('pendaftaran/file_ktp_wali')
                            ->preserveFilenames()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')->openable()
                            ->previewable()
                            ->downloadable(),
                    ])->columns(3),


                Section::make('UPLOAD DOKUMEN')
                    ->description('Silahkan Upload Data Pendaftar')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                        Section::make('VERIVIKASI DOKUMEN')
                            ->description('Silahkan Centang Jika Data Sudah Lengkap')
                            ->icon('heroicon-o-check-circle')
                            ->schema([
                                Toggle::make('data_lengkap')
                                    ->inline(true),
                            ])->columns(2)->collapsible(),

                        FileUpload::make('file_ktp')->label('Upload KTP')
                            ->disk('public')
                            ->directory('pendaftaran/file_ktp')
                            ->preserveFilenames()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')->openable()
                            ->previewable()
                            ->downloadable(),
                        FileUpload::make('file_ktp_wali')->label('Upload KTP Wali')
                            ->disk('public')
                            ->directory('pendaftaran/file_ktp_wali')
                            ->preserveFilenames()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')->openable()
                            ->previewable()
                            ->downloadable(),
                        FileUpload::make('file_kk')->label('Upload KK')
                            ->disk('public')
                            ->directory('pendaftaran/file_kk')
                            ->preserveFilenames()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')->openable()
                            ->previewable()
                            ->downloadable(),
                        FileUpload::make('file_akta_lahir')->label('Upload Akta Lahir')
                            ->disk('public')
                            ->directory('pendaftaran/file_akta_lahir')
                            ->preserveFilenames()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')->openable()
                            ->previewable()
                            ->downloadable(),
                        FileUpload::make('file_surat_nikah')->label('Upload Surat Nikah')
                            ->disk('public')
                            ->directory('pendaftaran/file_surat_nikah')
                            ->preserveFilenames()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')->openable()
                            ->previewable()
                            ->downloadable(),
                        FileUpload::make('file_surat_ijin')->label('Upload Surat Ijin')
                            ->disk('public')
                            ->directory('pendaftaran/file_surat_ijin')
                            ->preserveFilenames()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')->openable()
                            ->previewable()
                            ->downloadable(),
                        FileUpload::make('file_ijazah')->label('Upload Ijazah')
                            ->disk('public')
                            ->directory('pendaftaran/file_ijazah')
                            ->preserveFilenames()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')->openable()
                            ->previewable()
                            ->downloadable(),
                        FileUpload::make('file_tambahan')->label('Upload File Tambahan')
                            ->disk('public')
                            ->directory('pendaftaran/file_tambahan')
                            ->preserveFilenames()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')->openable()
                            ->previewable()
                            ->downloadable(),
                    ])->columns(4)->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('DAFTAR')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('nama')->label('NAMA')
                    ->searchable()
                    ->description(
                        fn(Pendaftaran $record): string =>
                        $record->nomor_ktp
                            ? "{$record->nomor_ktp} - " . ($record->user ? $record->user->email : 'Akun Tidak Terhubung')
                            : 'No KTP available'
                    ),
                // TextColumn::make('tgl_lahir')->label('TGL LAHIR'),
                TextColumn::make('tgl_lahir')
                    ->label('USIA')
                    ->formatStateUsing(function ($state) {
                        if (!$state) {
                            return 'N/A'; // Return a default value if no date of birth is available
                        }
                        $dateOfBirth = \Carbon\Carbon::parse($state);
                        $age = $dateOfBirth->age; // Calculate age
                        return $age . ' Tahun'; // Return age with 'years' suffix
                    }),
                TextColumn::make('nomor_ktp')
                    ->label('E-KTP')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tanggal_pra_medical')
                    ->label('TGL MEDICAL'),
                TextColumn::make('pra_medical')
                    ->label('HASIL MEDICAL'),
                TextColumn::make('ProsesCpmi.Status.nama')->label('STATUS')
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
                TextColumn::make('Marketing.Agency.nama')
                    ->label('MARKET'),

            ])
            ->filters([
                SelectFilter::make('Tujuan')
                    ->relationship('ProsesCpmi.Tujuan', 'nama')
                    ->label('TUJUAN')
                    ->placeholder('SEMUA'),
                SelectFilter::make('kantor')
                    ->relationship('Kantor', 'nama')
                    ->label('KANTOR')
                    ->placeholder('SEMUA'),
                SelectFilter::make('Status')
                    ->relationship('ProsesCpmi.Status', 'nama')
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
                    ->exporter(PendaftaranExporter::class)
                    ->columnMapping(true)
                    ->label('Unduh Data Pendaftaran')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->formats([
                        ExportFormat::Xlsx,
                    ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportAction::make()
                        ->exporter(PendaftaranExporter::class)
                        ->columnMapping(true)
                        ->label('Unduh Data Pendaftaran')
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
            ProsesCpmiRelationManager::class,
            MarketingRelationManager::class,
            AuditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftarans::route('/'),
            'create' => Pages\CreatePendaftaran::route('/create'),
            'edit' => Pages\EditPendaftaran::route('/{record}/edit'),
            'view' => Pages\ViewPendaftaran::route('/{record}'),

        ];
    }
}
