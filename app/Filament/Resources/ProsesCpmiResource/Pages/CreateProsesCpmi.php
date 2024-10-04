<?php

namespace App\Filament\Resources\ProsesCpmiResource\Pages;

use App\Filament\Resources\ProsesCpmiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Pendaftaran;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use Illuminate\Support\Facades\Auth;

class CreateProsesCpmi extends CreateRecord
{
    protected static string $resource = ProsesCpmiResource::class;
    protected static ?string $title = 'BUAT PROSES CPMI';

    
    protected function getCreatedNotification(): ?Notification
    {
        $data = $this->record;

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
            ->body("<strong>{$data->nama}</strong> Berhasil Ditambahkan
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
