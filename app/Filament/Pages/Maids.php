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
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Enums\ActionsPosition;

class Maids extends Page implements HasTable
{
    use InteractsWithTable;
    use HasPageShield;

    protected function getShieldRedirectPath(): string
    {
        return '/unauthorized'; // Redirect jika user tidak memiliki akses
    }

    protected static ?string $navigationLabel = 'MAIDS';
    protected static ?string $title = 'MAIDS';
    protected ?string $heading = 'MAIDS';
    protected ?string $subheading = 'Maid Listing';
    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';
    protected static string $view = 'filament.pages.maids';

    public function table(Table $table): Table
    {
        return $table
            ->query(Marketing::where('agency_id', 2))
            ->columns([
                Split::make([
                    ImageColumn::make('foto')
                        ->label('PICTURE')
                        ->circular()
                        ->size(200),
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
                    Panel::make([
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
                            // ApprovalStatusColumn::make("approvalStatus.status")->toggleable(isToggledHiddenByDefault: true),
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
                    ])
                    ->action(function (Marketing $record, array $data) {
                        $agencyId = $data['agency_id'];
                        $this->sendRequestInterviewNotification($record, $agencyId);
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

    protected function sendRequestInterviewNotification(Marketing $record, $agencyId)
    {
        // Ambil nama editor
        $editor = Auth::user();
        $editorName = $editor ? $editor->name : 'Unknown';

        // Akses nama dari relasi pendaftaran
        $pendaftaranNama = $record->pendaftaran->nama ?? 'Tidak diketahui';  // Handle jika 'pendaftaran' null

        // Ambil informasi agency berdasarkan ID
        $agency = Agency::find($agencyId);
        $agencyName = $agency ? $agency->nama : 'Tidak diketahui'; // Jika agency tidak ditemukan, fallback ke 'Tidak diketahui'

        // Tombol "View" untuk melihat detail permintaan
        $viewButton = NotificationAction::make('Lihat')
            ->url(MarketingResource::getUrl('view', ['record' => $record]));

        // Buat notifikasi
        $notification = Notification::make()
            ->title('REQUEST INTERVIEW')
            ->body("Request interview untuk <strong>{$pendaftaranNama}</strong> untuk <strong>{$agencyName}</strong> telah diajukan oleh <strong>{$editorName}</strong>.") // Tampilkan nama agency
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
}
