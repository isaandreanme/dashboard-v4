<?php

namespace App\Filament\Resources;

use App\Filament\Exports\MarketingExporter;
use App\Filament\Resources\MarketingResource\Pages;
use App\Filament\Resources\MarketingResource\RelationManagers;
use App\Models\Marketing;
use App\Models\Pendaftaran;
use App\Models\ProsesCpmi;
use App\Models\Status;
use App\Models\Tujuan;
use EightyNine\Approvals\Models\ApprovableModel;
use EightyNine\Approvals\Tables\Actions\ApprovalActions;
use EightyNine\Approvals\Tables\Columns\ApprovalStatusColumn;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
//-------------
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;

class MarketingResource extends Resource
{
    protected static ?string $model = Marketing::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    // protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationLabel = 'MARKETING';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'PROSES';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('MARKETING')
                    ->icon('heroicon-m-check-badge')
                    ->schema([
                        Select::make('sales_id',)
                            ->relationship('Sales', 'nama')
                            ->required()
                            ->placeholder('Pilih Marketing')
                            ->searchable()
                            ->label('Marketing'),
                        Select::make('agency_id',)
                            ->relationship('Agency', 'nama')
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih Agency')
                            ->label('Agency'),
                        DatePicker::make('tgl_job',)
                            ->placeholder('Pilih Tanggal Job')
                            ->label('TGL JOB'),
                        Toggle::make('get_job')
                            ->inline(true)
                            ->inlineLabel(true)
                            ->label('STATUS JOB'),
                    ])->columns(4),
                //---------------------------------------------------------------- Applicants Information Sheet 申請人資料
                Section::make('PENDAFTARAN')
                    ->description('Data Pendaftaran')
                    ->icon('heroicon-m-check-badge')
                    ->schema([
                        Select::make('pendaftaran_id',)
                            ->relationship('Pendaftaran', 'nama')
                            ->getOptionLabelFromRecordUsing(fn(Pendaftaran $record) => "{$record->nama}")
                            ->label('Nama')
                            ->required()
                            ->searchable()
                            ->optionsLimit(5),
                        // ->disabled(),
                        TextInput::make('nomor_hp')
                            ->numeric()
                            ->minLength(1)
                            ->maxLength(12)
                            ->placeholder('CONTOH : +62812686753')
                            ->label('NOMOR HANDPHONE'),

                        Select::make('pendaftaran_id',)
                            ->relationship('Pendaftaran', 'nomor_ktp')
                            ->getOptionLabelFromRecordUsing(fn(Pendaftaran $record) => "{$record->nomor_ktp}")
                            ->label('E-KTP')
                            ->disabled()
                            ->searchable(),

                        //---------
                        Select::make('pendaftaran_id')
                            ->relationship('ProsesCpmi', 'tanggal_medical')
                            ->label('Tanggal Medical')
                            ->getOptionLabelFromRecordUsing(function (ProsesCpmi $record) {
                                $tanggal = \Carbon\Carbon::parse($record->tanggal_medical);
                                return $tanggal->format('d/m/Y');
                            })
                            ->disabled(),
                        //---------
                    ])->columns(4),
                //---------------------------------------------------------------- Applicants Information Sheet 申請人資料

                Section::make('')
                    ->schema([
                        FileUpload::make('foto')->label('Upload FOTO')
                            ->disk('public')
                            ->directory('biodata/foto')
                            ->preserveFilenames()
                            ->loadingIndicatorPosition('right')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')->openable()
                            ->previewable()
                            ->downloadable(),
                    ]),
                Section::make('')
                    ->schema([
                        TextInput::make('code_hk')->label('CODE HONG KONG'),
                        TextInput::make('code_tw')->label('CODE TAIWAN'),
                        TextInput::make('code_sgp')->label('CODE SINGAPORE'),
                        TextInput::make('code_my')->label('CODE MALAYSIA'),
                    ])->columns(4),

                //----------------------------------------------------------------
                Section::make('Applicants Information Sheet')
                    ->description('申請人資料')
                    ->schema([
                        Fieldset::make('')
                            ->schema([
                                Select::make('pendaftaran_id',)
                                    ->relationship('Pendaftaran', 'nama')
                                    ->getOptionLabelFromRecordUsing(fn(Pendaftaran $record) => "{$record->nama}")
                                    ->label('Nama'),
                                // ->disabled(),
                                Select::make('national')
                                    ->label('Negara Asal')
                                    ->options([
                                        'INDONESIAN' => 'INDONESIAN',
                                    ])
                                    ->default('INDONESIAN'), // Menetapkan nilai default
                                Select::make('kelamin')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'FEMALE' => 'FEMALE',
                                        'MALE' => 'MALE',
                                    ]),
                                Select::make('lulusan')
                                    ->label('Pendidikan')
                                    ->options([
                                        'Elementary School' => 'Elementary School',
                                        'Junior High School' => 'Junior High School',
                                        'Senior Highschool' => 'Senior Highschool',
                                        'University' => 'University',
                                    ]),
                                Select::make('agama')
                                    ->label('Agama')
                                    ->options([
                                        'MOESLIM' => 'MOESLIM',
                                        'CRISTIAN' => 'CRISTIAN',
                                        'HINDU' => 'HINDU',
                                        'BOEDHA' => 'BOEDHA',
                                    ]),
                                TextInput::make('anakke')
                                    ->label('Anak Ke')
                                    ->numeric()
                                    ->minLength(1)
                                    ->maxLength(2),
                                TextInput::make('brother')
                                    ->label('Saudara Laki Laki')
                                    ->numeric()
                                    ->minLength(1)
                                    ->maxLength(2),
                                TextInput::make('sister')
                                    ->label('Saudara perempuan')
                                    ->numeric()
                                    ->minLength(1)
                                    ->maxLength(2),
                            ]),

                        Fieldset::make('')
                            ->schema([
                                Select::make('usia')
                                    ->relationship('Pendaftaran', 'age') // Menggunakan atribut age yang telah didefinisikan
                                    ->getOptionLabelFromRecordUsing(fn(Pendaftaran $record) => $record->age)
                                    ->label('USIA')
                                    ->disabled()
                                    ->suffix(' YO'),
                                Select::make('tanggal_lahir',)
                                    ->relationship('Pendaftaran', 'tgl_lahir')
                                    ->getOptionLabelFromRecordUsing(fn(Pendaftaran $record) => "{$record->tgl_lahir}")
                                    ->label('TANGGAL LAHIR')
                                    ->disabled(),
                                Select::make('status_nikah')
                                    ->label('Setatus Pernikahan')
                                    ->options([
                                        'SINGLE' => 'SINGLE',
                                        'MARRIED' => 'MARRIED',
                                        'DIVORCED' => 'DIVORCED',
                                        'WIDOW' => 'WIDOW',
                                    ]),
                                TextInput::make('tinggi_badan')
                                    ->label('Tinggi Badan')
                                    ->numeric()
                                    ->minLength(1)
                                    ->maxLength(3)
                                    ->suffix(' CM'),
                                TextInput::make('berat_badan')
                                    ->label('Berat Badan')
                                    ->numeric()
                                    ->minLength(1)
                                    ->maxLength(2)
                                    ->suffix(' KG'),
                                TextInput::make('son')->placeholder('CONTOH : 1 / 14 (YO)')
                                    ->label('Anak Laki Laki'),
                                TextInput::make('daughter')->placeholder('CONTOH : 1 / 14 (YO)')
                                    ->label('Anak Perempuan'),
                            ]),

                    ])->columns(2),

                //---------------------------------------------------------------- Working Experience 工作經驗
                Section::make('Working Experience')
                    ->description('工作經驗')
                    ->schema([
                        Radio::make('careofbabies')
                            ->label('Merawat Bayi ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('careoftoddler')
                            ->label('Merawat Balita ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('careofchildren')
                            ->label('Merawat Anak ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('careofelderly')
                            ->label('Merawat Lansia ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('careofdisabled')
                            ->label('Merawat Penyandang Cacat ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('careofbedridden')
                            ->label('Merawat Penyandang Lumpuh ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('careofpet')
                            ->label('Merawat Hewan ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('householdworks')
                            ->label('Pekerjaan Rumah Tangga ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('carwashing')
                            ->label('Mencuci Mobil ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('gardening')
                            ->label('Berkebun ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('cooking')
                            ->label('Memasak ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('driving')
                            ->label('Menyetir Mobil ?')
                            ->default('NO')
                            ->options([
                                'YES' => 'YES',
                                'NO' => 'NO',
                            ])
                            ->inline()
                            ->inlineLabel(false),

                    ])->columns(3),

                //---------------------------------------------------------------- Overseas Experience 海外工作經驗
                Section::make('Overseas Experience')
                    ->description('海外工作經驗')
                    ->schema([
                        TextInput::make('homecountry')->suffix(' Years')->label('Di Indonesia'),
                        TextInput::make('hongkong')->suffix(' Years')->label('Hong Kong'),
                        TextInput::make('singapore')->suffix(' Years')->label('Singapore'),
                        TextInput::make('taiwan')->suffix(' Years')->label('Taiwan'),
                        TextInput::make('malaysia')->suffix(' Years')->label('Malaysia'),
                        TextInput::make('macau')->suffix(' Years')->label('Macau'),
                        TextInput::make('middleeast')->suffix(' Years')->label('Timur Tengah'),
                        TextInput::make('other')->label('Lainya'),
                    ])->columns(4),

                //---------------------------------------------------------------- Language Skills 語言能力
                Section::make('Language Skills')
                    ->description('語言能力')
                    ->schema([
                        Radio::make('spokenenglish')
                            ->label('Bahasa Inggris')
                            ->options([
                                'POOR' => 'POOR',
                                'FAIR' => 'FAIR',
                                'GOOD' => 'GOOD',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('spokencantonese')
                            ->label('Bahasa Kantonis')
                            ->options([
                                'POOR' => 'POOR',
                                'FAIR' => 'FAIR',
                                'GOOD' => 'GOOD',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                        Radio::make('spokenmandarin')
                            ->label('Bahasa Mandarin')
                            ->options([
                                'POOR' => 'POOR',
                                'FAIR' => 'FAIR',
                                'GOOD' => 'GOOD',
                            ])
                            ->inline()
                            ->inlineLabel(false),
                    ])->columns(3),

                //---------------------------------------------------------------- Remark 備註
                Section::make('REMARK')
                    ->description('備註')
                    ->schema([
                        Textarea::make('remark')->label(false),
                    ]),
                //     //---------------------------------------------------------------- Previous Duties 過往工作
                Section::make('Previous Duties')
                    ->description('過往工作')
                    ->schema([
                        Repeater::make('pengalaman')->label('Pengalaman')
                            ->schema([
                                TextInput::make('nomorpengalaman')->label('Nomor'),
                                TextInput::make('negara')->label('Negara'),
                                TextInput::make('gaji')->label('Gaji'),
                                TextInput::make('jumlahorang')->label('Jumlah Orang'),
                                TextInput::make('tahunmulai')->label('Tahun Mulai'),
                                TextInput::make('tahunselesai')->label('Tahun Selesai'),
                                TextInput::make('alasan')->placeholder('Kosongkan Jika Tidak Ada')->label('Alasan Berhenti'),
                                Fieldset::make('')
                                    ->schema([
                                        Fieldset::make('')
                                            ->schema([
                                                Radio::make('careofbabies')
                                                    ->label('Merawat Bayi ?')
                                                    ->default('NO')
                                                    ->options([
                                                        'YES' => 'YES',
                                                        'NO' => 'NO',
                                                    ])
                                                    ->inline()
                                                    ->inlineLabel(false),
                                                TextInput::make('usiabayi')->label('Usia Bayi')->suffix(' Bulan'),
                                            ]),
                                        Fieldset::make('')
                                            ->schema([
                                                Radio::make('careoftoddler')
                                                    ->label('Merawat Balita ?')
                                                    ->default('NO')
                                                    ->options([
                                                        'YES' => 'YES',
                                                        'NO' => 'NO',
                                                    ])
                                                    ->inline()
                                                    ->inlineLabel(false),
                                                TextInput::make('usiabalita')->label('Usia Balita')->suffix(' Tahun'),
                                            ]),
                                        Fieldset::make('')
                                            ->schema([
                                                Radio::make('careofchildren')
                                                    ->label('Merawat Anak ?')
                                                    ->default('NO')
                                                    ->options([
                                                        'YES' => 'YES',
                                                        'NO' => 'NO',
                                                    ])
                                                    ->inline()
                                                    ->inlineLabel(false),
                                                TextInput::make('usiaanak')->label('Usia Anak')->suffix(' Tahun'),
                                            ]),
                                        Fieldset::make('')
                                            ->schema([
                                                Radio::make('careofelderly')
                                                    ->label('Merawat Lansia ?')
                                                    ->default('NO')
                                                    ->options([
                                                        'YES' => 'YES',
                                                        'NO' => 'NO',
                                                    ])
                                                    ->inline()
                                                    ->inlineLabel(false),
                                                TextInput::make('usialansia')->label('Usia Lansia')->suffix(' Tahun'),
                                            ]),
                                        Fieldset::make('')
                                            ->schema([
                                                Radio::make('careofdisabled')
                                                    ->label('Merawat Penyandang Cacat ?')
                                                    ->default('NO')
                                                    ->options([
                                                        'YES' => 'YES',
                                                        'NO' => 'NO',
                                                    ])
                                                    ->inline()
                                                    ->inlineLabel(false),
                                                TextInput::make('usiadisable')->label('Usia Disable')->suffix(' Tahun'),
                                            ]),
                                        Fieldset::make('')
                                            ->schema([
                                                Radio::make('careofbedridden')
                                                    ->label('Merawat Penyandang Lumpuh ?')
                                                    ->default('NO')
                                                    ->options([
                                                        'YES' => 'YES',
                                                        'NO' => 'NO',
                                                    ])
                                                    ->inline()
                                                    ->inlineLabel(false),
                                                TextInput::make('usialumpuh')->label('Usia Penyandang Lumpuh')->suffix(' Tahun'),
                                            ]),
                                        Radio::make('careofpet')
                                            ->label('Merawat Hewan ?')
                                            ->default('NO')
                                            ->options([
                                                'YES' => 'YES',
                                                'NO' => 'NO',
                                            ])
                                            ->inline()
                                            ->inlineLabel(false),
                                        Radio::make('householdworks')
                                            ->label('Pekerjaan Rumah Tangga ?')
                                            ->default('NO')
                                            ->options([
                                                'YES' => 'YES',
                                                'NO' => 'NO',
                                            ])
                                            ->inline()
                                            ->inlineLabel(false),
                                        Radio::make('carwashing')
                                            ->label('Mencuci Mobil ?')
                                            ->default('NO')
                                            ->options([
                                                'YES' => 'YES',
                                                'NO' => 'NO',
                                            ])
                                            ->inline()
                                            ->inlineLabel(false),
                                        Radio::make('gardening')
                                            ->label('Berkebun ?')
                                            ->default('NO')
                                            ->options([
                                                'YES' => 'YES',
                                                'NO' => 'NO',
                                            ])
                                            ->inline()
                                            ->inlineLabel(false),
                                        Radio::make('cooking')
                                            ->label('Memasak ?')
                                            ->default('NO')
                                            ->options([
                                                'YES' => 'YES',
                                                'NO' => 'NO',
                                            ])
                                            ->inline()
                                            ->inlineLabel(false),
                                        Radio::make('driving')
                                            ->label('Menyetir Mobil ?')
                                            ->default('NO')
                                            ->options([
                                                'YES' => 'YES',
                                                'NO' => 'NO',
                                            ])
                                            ->inline()
                                            ->inlineLabel(false),

                                    ])->columns(3)
                            ])->columns(3)->defaultItems(2)->maxItems(2),
                    ]),
                //---------------------------------------------------------------- Other Question 其他問題
                Section::make('Other Question')
                    ->description('其他問題')
                    ->schema([
                        Fieldset::make('')
                            ->schema([
                                Radio::make('babi')->label('Memakan Daging Babi ?')
                                    ->default('NO')
                                    ->options([
                                        'YES' => 'YES',
                                        'NO' => 'NO',
                                    ])
                                    ->inline()
                                    ->inlineLabel(false),
                                Radio::make('liburbukanhariminggu')->label('Bersedia Libur Selain Minggu')
                                    ->default('NO')
                                    ->options([
                                        'YES' => 'YES',
                                        'NO' => 'NO',
                                    ])
                                    ->inline()
                                    ->inlineLabel(false),
                                Radio::make('berbagikamar')->label('Berbagi Kamar ?')
                                    ->helperText('Berbagi Kamar Dengan BAYI / ANAK / ORANG TUA ?')
                                    ->default('NO')
                                    ->options([
                                        'YES' => 'YES',
                                        'NO' => 'NO',
                                    ])
                                    ->inline()
                                    ->inlineLabel(false),
                                Radio::make('takutanjing')->label('Takut Dengan Anjing ?')
                                    ->default('NO')
                                    ->options([
                                        'YES' => 'YES',
                                        'NO' => 'NO',
                                    ])
                                    ->inline()
                                    ->inlineLabel(false),
                                Radio::make('merokok')->label('Merokok ?')
                                    ->default('NO')
                                    ->options([
                                        'YES' => 'YES',
                                        'NO' => 'NO',
                                    ])
                                    ->inline()
                                    ->inlineLabel(false),
                                Radio::make('alkohol')->label('Minum Alkohol ?')
                                    ->default('NO')
                                    ->options([
                                        'YES' => 'YES',
                                        'NO' => 'NO',
                                    ])
                                    ->inline()
                                    ->inlineLabel(false),
                            ])->columns(3),
                        Fieldset::make('')
                            ->schema([
                                Radio::make('pernahsakit')->label('Pernah Sakit ?')
                                    ->default('NO')
                                    ->helperText('Isi Keterangan Jika Pernah Sakit Lama / Operasi')
                                    ->options([
                                        'YES' => 'YES',
                                        'NO' => 'NO',
                                    ])
                                    ->inline()
                                    ->inlineLabel(false),

                                Textarea::make('ketsakit')
                                    ->label('Keterangan Pernah Sakit'),
                            ])->columns(2),

                    ])->columns(2),

                //----------------------------------------------------------------



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                TextColumn::make('pendaftaran.nama') // Pastikan relasi ke Pendaftaran ada
                    ->label('CPMI')
                    ->weight('bold')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500)
                    ->description(
                        fn(Marketing $record): string =>
                        $record->pendaftaran->nomor_ktp
                            ? "{$record->pendaftaran->nomor_ktp} - " . ($record->pendaftaran->user ? $record->pendaftaran->user->email : 'Akun Tidak Terhubung')
                            : 'No KTP available'
                    ),
                TextColumn::make('Pendaftaran.nomor_ktp')->label('E-KTP')->color('primary')
                    ->copyable()
                    ->searchable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ProsesCpmi.Tujuan.nama')->label('TUJUAN')->color('primary')
                    ->copyable()
                    ->searchable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                TextColumn::make('Agency.nama')->label('STATUS MARKET')->color('primary')
                    ->copyable()
                    ->sortable()
                    ->searchable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                IconColumn::make('Pendaftaran.data_lengkap')
                    ->boolean()
                    ->sortable()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->label('DATA LENGKAP')->toggleable(isToggledHiddenByDefault: false)->disabled(),
                IconColumn::make('get_job')
                    ->boolean()
                    ->sortable()
                    ->sortable()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->label('STATUS JOB')->toggleable(isToggledHiddenByDefault: false)->disabled(),
                TextColumn::make('tgl_job')
                    ->label('TGL JOB')->toggleable(isToggledHiddenByDefault: false)->disabled(),
                TextColumn::make('Pendaftaran.created_at')->label('LAMA PROSES')->color('warning')
                    ->since()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500)->toggleable(isToggledHiddenByDefault: false),
                // ApprovalStatusColumn::make("approvalStatus.status")->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                SelectFilter::make('STATUS MARKET')
                    ->relationship('Agency', 'nama')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(2)
                    ->label('STATUS MARKET')
                    ->placeholder('SEMUA'),
                SelectFilter::make('NEGARA TUJUAN')
                    ->relationship('Tujuan', 'nama')
                    ->label('NEGARA TUJUAN')
                    ->placeholder('SEMUA'),
            ], layout: FiltersLayout::Modal)
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label('FILTER'),
            )->filtersFormColumns(2)
            ->actions([
                ...\EightyNine\Approvals\Tables\Actions\ApprovalActions::make(
                    Tables\Actions\Action::make("Done")
                        ->label('APRROVE')
                        ->hidden(fn(ApprovableModel $record) => $record->shouldBeHidden())
                ),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('UPDATE')
                        ->color('info'),
                    Action::make('Download Pdf')
                        ->label('Biodata For Hongkong')
                        ->icon('heroicon-o-printer')
                        ->url(fn(Marketing $record) => route('hongkong.pdf.download', ['id' => $record->id]))
                        ->openUrlInNewTab()
                        ->color('success'),
                    Action::make('Download Pdf')
                        ->label('Biodata For Taiwan')
                        ->icon('heroicon-o-printer')
                        ->url(fn(Marketing $record) => route('taiwan.pdf.download', ['id' => $record->id]))
                        ->openUrlInNewTab()
                        ->color('success'),
                    Action::make('Download Pdf')
                        ->label('Biodata For Singapore')
                        ->icon('heroicon-o-printer')
                        ->url(fn(Marketing $record) => route('singapore.pdf.download', ['id' => $record->id]))
                        ->openUrlInNewTab()
                        ->color('success'),
                    Action::make('Download Pdf')
                        ->label('Biodata For Malaysia')
                        ->icon('heroicon-o-printer')
                        ->url(fn(Marketing $record) => route('malaysia.pdf.download', ['id' => $record->id]))
                        ->openUrlInNewTab()
                        ->color('success'),
                    Tables\Actions\DeleteAction::make()
                        ->label('HAPUS'),

                ])
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(MarketingExporter::class)
                    ->columnMapping(true)
                    ->label('Unduh Data Marketing')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->formats([
                        ExportFormat::Xlsx,
                    ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportAction::make()
                        ->exporter(MarketingExporter::class)
                        ->columnMapping(true)
                        ->label('Unduh Data Marketing')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarketings::route('/'),
            'create' => Pages\CreateMarketing::route('/create'),
            'edit' => Pages\EditMarketing::route('/{record}/edit'),
            'view' => Pages\ViewMarketing::route('/{record}'),  // Tambahkan ini

        ];
    }
}
