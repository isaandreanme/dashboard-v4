<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MarketingResource;
use App\Models\Agency;
use App\Models\Marketing;
use App\Models\User;
use Filament\Actions\Action;  // Aliased as Action
use Filament\Pages\Page;
use Filament\Tables\Actions\Action as TableAction;  // Gunakan alias lain untuk Filament Tables Action
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use Illuminate\Support\Facades\Auth;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use EightyNine\Approvals\Models\ApprovableModel;
use EightyNine\Approvals\Tables\Columns\ApprovalStatusColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Enums\ActionsPosition;
use Illuminate\Contracts\View\View;

class Workers extends Page implements HasTable
{
    use InteractsWithTable;
    use HasPageShield;

    protected function getShieldRedirectPath(): string
    {
        return '/unauthorized'; // Redirect jika user tidak memiliki akses
    }

    protected static ?string $navigationLabel = 'WORKERS';
    protected static ?string $title = 'Workers';
    protected ?string $heading = 'Workers';
    protected ?string $subheading = 'Workers Listing';
    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';
    protected static string $view = 'filament.pages.workers';

    public function table(Table $table): Table
    {
        return $table
            ->query(Marketing::where('agency_id', 2))
            ->paginated([6, 24, 48, 100, 'all'])
            ->columns([
                Split::make([
                    ImageColumn::make('foto')
                        ->label('PICTURE')
                        ->circular()
                        ->size(200),

                    Panel::make([
                        Stack::make([
                            TextColumn::make('pendaftaran.nama')
                                ->label('CPMI')
                                ->weight('bold')
                                ->searchable()
                                ->description(
                                    fn(Marketing $record): string =>
                                    $record->pendaftaran
                                        ? ($record->pendaftaran->age
                                            ? "{$record->pendaftaran->age} - Years Old"
                                            : 'Age not available')
                                        : 'Pendaftaran tidak ditemukan'
                                ),
                            TextColumn::make('Agency.nama')
                                ->label('MARKET')
                                ->badge()
                                ->color(fn(string $state): string => match ($state) {
                                    '- OPEN ON MARKET' => 'success',
                                    default => 'gray',
                                })
                                ->formatStateUsing(fn(string $state): string => $state === '- OPEN ON MARKET' ? 'OPEN MARKET' : $state)
                        ])->space(1),
                        Stack::make([
                            TextColumn::make('lulusan')
                                ->prefix('EDUCATION : ')
                                ->label('EDUCATION')
                                ->formatStateUsing(fn(string $state): string => strtoupper($state)),
                            TextColumn::make('agama')
                                ->prefix('RELIGION : ')
                                ->label('RELIGION'),
                            TextColumn::make('status_nikah')
                                ->prefix('STATUS : ')
                                ->label('STATUS'),
                            TextColumn::make('Pendaftaran.Pengalaman.nama')
                                ->prefix('EXPERIENCE : ')
                                ->label('EXPERIENCE')
                                ->searchable(),
                            TextColumn::make('spokenenglish')
                                ->prefix('ENGLISH : ')
                                ->label('STATUS'),
                            TextColumn::make('spokenmandarin')
                                ->prefix('MANDARIN : ')
                                ->label('STATUS'),
                            TextColumn::make('spokencantonese')
                                ->prefix('CANTONESE : ')
                                ->label('STATUS'),


                        ])->space(1),
                    ])->collapsed(false),
                ])->from('md'),
            ])->contentGrid([
                'md' => 2,
                'xl' => 2,
            ])
            ->defaultSort('updated_at', 'desc')
            ->actions([
                ...\EightyNine\Approvals\Tables\Actions\ApprovalActions::make(
                    TableAction::make("Done")
                        ->label('Request Interview')
                        ->hidden(fn(ApprovableModel $record) => $record->shouldBeHidden())
                        ->color('warning')
                ),
                ActionGroup::make([
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
                ])->label('Biodata Downloads')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('primary')
                    ->button(),
                TableAction::make('requestInterview')
                    ->label('Request Interview')
                    ->color('danger')
                    ->icon('heroicon-o-bell')
                    ->form([
                        Select::make('agency_id')
                            ->label('Please Chose Your Agency Name')
                            ->options(Agency::whereNotIn('id', [1, 2])->pluck('nama', 'id'))  // Mengecualikan agency_id 1 dan 2
                            ->required()
                            ->searchable(),
                        DatePicker::make('JadwalInterview')
                            ->label('Please Select An Interview Schedule')
                            ->native(false),
                        TimePicker::make('appointment_at')
                            ->datalist([
                                '09:00',
                                '09:30',
                                '10:00',
                                '10:30',
                                '11:00',
                                '11:30',
                                '12:00',
                            ])
                            ->label('Time In WIB Jakarta Timezone'),
                    ])
                    ->action(function (Marketing $record, array $data) {
                        $agencyId = $data['agency_id'];
                        $this->sendRequestInterviewNotification($record, $agencyId, $data);
                    }),
            ], position: ActionsPosition::AfterCells)
            ->filters([
                SelectFilter::make('Tujuan')
                    ->relationship('Tujuan', 'nama')
                    ->label('TUJUAN')
                    ->placeholder('SEMUA'),
            ])
            ->filtersTriggerAction(
                fn(TableAction $action) => $action->button()->label('FILTER'),
            );
    }

    protected function sendRequestInterviewNotification(Marketing $record, $agencyId, array $data)
    {
        // Ambil nama editor
        $editor = Auth::user();
        $editorName = $editor ? $editor->name : 'Unknown';

        // Akses nama dari relasi pendaftaran
        $pendaftaranNama = $record->pendaftaran->nama ?? 'Tidak diketahui';  // Handle jika 'pendaftaran' null

        // Ambil informasi agency berdasarkan ID
        $agency = Agency::find($agencyId);
        $agencyName = $agency ? $agency->nama : 'Tidak diketahui'; // Jika agency tidak ditemukan, fallback ke 'Tidak diketahui'

        // Ambil jadwal interview dan appointment_at dari data
        $jadwalInterview = $data['JadwalInterview'] ?? 'Tidak ditentukan';
        $appointmentAt = $data['appointment_at'] ?? 'Tidak ditentukan';

        // Tombol "View" untuk melihat detail permintaan
        $viewButton = NotificationAction::make('Lihat')
            ->url(MarketingResource::getUrl('view', ['record' => $record]));

        // Buat notifikasi
        $notification = Notification::make()
            ->title('REQUEST INTERVIEW')
            ->body("
                Request interview untuk <strong>{$pendaftaranNama}</strong> untuk <strong>{$agencyName}</strong> telah diajukan oleh <strong>{$editorName}</strong>.<br>
                Jadwal Interview : <strong>{$jadwalInterview}</strong><br>
                Waktu : <strong>{$appointmentAt}</strong> WIB
            ") // Tampilkan nama agency, jadwal, dan appointment_at
            ->actions([$viewButton])
            ->persistent()
            ->success();

        // Kirim notifikasi ke semua admin dan juga ke editor
        $recipients = User::where('is_admin', true)->orWhere('id', $editor->id)->get();

        // Kirim notifikasi ke semua penerima
        foreach ($recipients as $recipient) {
            $notification->sendToDatabase($recipient);
        }
    }

    public function getFooter(): ?View
    {
        return view('filament.settings.custom-footer');
    }
}
