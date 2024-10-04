<?php

namespace App\Filament\Resources\ProsesCpmiResource\Pages;

use App\Filament\Resources\ProsesCpmiResource;
use App\Models\ProsesCpmi;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use Illuminate\Support\Facades\Auth;

class EditProsesCpmi extends EditRecord
{
    protected static string $resource = ProsesCpmiResource::class;
    protected static ?string $title = 'UBAH PROSES CPMI';


    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()->label('Batal'),
            Actions\DeleteAction::make(),
        ];
    }

    public static function getGlobalSearchResultTitle(ProsesCpmi $record): string
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
            ->url(ProsesCpmiResource::getUrl('view', ['record' => $data]));

        // Dapatkan nama pengguna yang sedang masuk
        $editor = Auth::user();
        $editorName = $editor ? $editor->name : 'Unknown';

        // Ambil semua penerima notifikasi
        $recipients = User::all();

        // Buat notifikasi dengan tombol "View"
        $notification = Notification::make()
            ->title('PROSES CPMI')
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
    protected function getRedirectUrl(): string
    {
        $record = $this->record;
        return $this->getResource()::getUrl('index', ['record' => $record]);
    }
}
