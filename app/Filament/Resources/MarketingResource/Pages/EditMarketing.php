<?php

namespace App\Filament\Resources\MarketingResource\Pages;

use App\Filament\Resources\MarketingResource;
use App\Models\Marketing;
use App\Models\User;
use EightyNine\Approvals\Models\ApprovableModel;
use EightyNine\Approvals\Traits\HasApprovalHeaderActions; // Trait untuk Approval Header
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use Illuminate\Support\Facades\Auth;

class EditMarketing extends EditRecord
{
    use HasApprovalHeaderActions; // Gunakan trait ini untuk menambahkan tombol approval di header

    protected static string $resource = MarketingResource::class;
    protected static ?string $title = 'EDIT BIODATA';

    protected function getHeaderActions(): array
    {
        // Aksi default lainnya...
        return [
            // Aksi lainnya...
        ];
    }

    public static function getGlobalSearchResultTitle(Marketing $record): string
    {
        return $record->nama;
    }

    protected function getSavedNotification(): ?Notification
    {
        $data = $this->record;

        // Pastikan relasi `pendaftaran` dimuat
        $data->load('pendaftaran');

        // Dapatkan nama dari relasi `pendaftaran`, dan fallback jika null
        $pendaftaranNama = $data->pendaftaran->nama ?? 'Tidak diketahui';

        // Buat tombol "View" dengan tipe yang benar
        $viewButton = NotificationAction::make('Lihat')
            ->url(MarketingResource::getUrl('view', ['record' => $data]));

        // Dapatkan nama pengguna yang sedang masuk
        $editor = Auth::user();
        $editorName = $editor ? $editor->name : 'Unknown';

        // Ambil semua penerima notifikasi
        $recipients = User::all();

        // Buat notifikasi dengan tombol "View"
        $notification = Notification::make()
            ->title('MARKETING')
            ->body("<strong>{$pendaftaranNama}</strong> Berhasil Update
                <br>
                Oleh <strong>{$editorName}</strong>")
            ->actions([$viewButton])
            ->persistent()
            ->success()
            ->duration(1000);

        // Kirim notifikasi ke semua penerima
        foreach ($recipients as $recipient) {
            $notification->sendToDatabase($recipient);
        }

        return $notification;
    }


    protected function getOnCompletionAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make("Done")
            ->color("success")
            ->hidden(fn(ApprovableModel $record) => $record->shouldBeHidden());
    }
}
