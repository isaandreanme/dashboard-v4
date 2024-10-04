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
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

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
                TextColumn::make('Agency.nama')->label('MARKET')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        '- OPEN ON MARKET' => 'success',
                        default => 'gray',
                    }),
                ImageColumn::make('foto')->label('PICTURE')->circular(),
                // TextColumn::make('code_hk')->label('CODE HK'),
                TextColumn::make('pendaftaran.nama')->label('NAME'),
                TextColumn::make('lulusan')->label('EDUCATION')
                    ->formatStateUsing(fn(string $state): string => strtoupper($state)),
                TextColumn::make('agama')->label('RELIGION'),
                TextColumn::make('status_nikah')->label('STATUS'),
                TextColumn::make('pendaftaran.age')->label('AGE')->suffix(' YO'),
                TextColumn::make('Pendaftaran.Pengalaman.nama')->label('EXPERIENCE')
                    ->searchable(),
                // ApprovalStatusColumn::make("approvalStatus.status")->toggleable(isToggledHiddenByDefault: true),

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
                ]),
                TableAction::make('requestInterview')  // Gunakan TableAction di sini
                ->label('Request Interview')
                ->color('danger')
                ->icon('heroicon-o-bell')
                ->form([
                    // Tambahkan field select untuk memilih Agency
                    Select::make('agency_id')
                        ->label('Please Chose Your Agency Name')
                        ->options(Agency::all()->pluck('nama', 'id')) // Mengambil daftar agency dari model Agency
                        ->required()
                        ->searchable(), // Memungkinkan pengguna mencari agency dalam select box
                ])
                ->action(function (Marketing $record, array $data) {
                    // Mengambil agency_id dari form input
                    $agencyId = $data['agency_id'];

                    // Lakukan logika yang diperlukan, misalnya mengirim notifikasi atau menyimpan data
                    $this->sendRequestInterviewNotification($record, $agencyId);
                }),

            ])
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
        $recipients = User::all();

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

        // Kirim notifikasi ke semua penerima
        foreach ($recipients as $recipient) {
            $notification->sendToDatabase($recipient);
        }
    }
}
