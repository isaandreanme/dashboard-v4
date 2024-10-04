<?php

namespace App\Filament\Pages;

use App\Models\Kantor; // Pastikan untuk mengimport model Kantor
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Contracts\View\View;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Support\Enums\Alignment;


class Dashboard extends \Filament\Pages\Dashboard
{
    use HasPageShield;

    protected function getShieldRedirectPath(): string
    {
        return '/unauthorized'; // Redirect jika user tidak memiliki akses
    }
    protected static ?string $title = 'RINGKASAN';
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    use HasFiltersForm;

    public ?string $startDate = null;
    public ?string $endDate = null;
    public ?string $kantor = null; // Properti untuk filter kantor

    protected function getHeaderActions(): array
    {
        return [

            Action::make('downloadPdf')
                ->label('Unduh Laporan')
                ->icon('heroicon-o-printer')
                ->modalHeading('Pilih Periode Laporan')
                ->modalDescription('Silahkan Pilih Rentang Waktu yang Anda Inginkan')
                ->modalSubmitActionLabel('Unduh Laporan')
                ->modalIcon('heroicon-o-printer')

                ->modalWidth('md')
                ->form([
                    DatePicker::make('startDate')
                        ->label('Tanggal Mulai'),
                    DatePicker::make('endDate')
                        ->label('Tanggal Akhir'),
                ])
                ->action(function (array $data) {
                    // Redirect ke halaman unduh PDF dengan tanggal dari form modal
                    $this->redirectRoute('laporan.pdf.download', [
                        'startDate' => $data['startDate'],
                        'endDate' => $data['endDate'],
                        'kantor' => request('kantor'), // Jika ada kantor yang dipilih di halaman
                    ]);
                })
                ->color('success')
                ->modalAlignment(Alignment::Center),
                // ->slideOver(),

                // Notification::make()
                // ->title('Unduh Laporan')
        ];
    }
    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('FILTER')
                    ->schema([
                        DatePicker::make('startDate')
                            ->prefixIcon('heroicon-m-check-circle')
                            ->prefixIconColor('primary')
                            ->prefix('MULAI')
                            ->label('')
                            ->required(),
                        DatePicker::make('endDate')
                            ->prefixIcon('heroicon-m-check-circle')
                            ->prefixIconColor('primary')
                            ->prefix('SAMPAI')
                            ->label('')
                            ->required(),
                        Select::make('kantor')
                            ->options(Kantor::all()->pluck('nama', 'id'))
                            ->label('')
                            ->prefixIcon('heroicon-m-check-circle')
                            ->prefixIconColor('primary')
                            ->prefix('PILIH')
                            ->placeholder('SEMUA KANTOR'),
                    ])->columns(3),
            ]);
    }

    public function getFooter(): ?View
    {
        return view('filament.settings.custom-footer');
    }
}
