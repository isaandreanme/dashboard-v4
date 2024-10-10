<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Dotswan\FilamentLaravelPulse\Widgets\PulseCache;
use Dotswan\FilamentLaravelPulse\Widgets\PulseExceptions;
use Dotswan\FilamentLaravelPulse\Widgets\PulseQueues;
use Dotswan\FilamentLaravelPulse\Widgets\PulseServers;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowOutGoingRequests;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowQueries;
use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowRequests;
use Dotswan\FilamentLaravelPulse\Widgets\PulseUsage;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Support\Enums\ActionSize;

class Pulse extends Page
{
    
    use HasPageShield;
    protected function getShieldRedirectPath(): string
    {
        return '/unauthorized'; // Redirect jika user tidak memiliki akses
    }

    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Status Aplikasi';
    protected static ?string $title = 'Status Aplikasi';
    protected ?string $heading = 'Aplikasi Monitor';
    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';
    protected static string $view = 'filament.pages.pulse';
    protected static ?int $navigationSort = 15;


    use HasFiltersAction;

    public function getColumns(): int|string|array
    {
        return 12;
    }

    public function getWidgets(): array
    {
        return [
            PulseUsage::class,
            PulseServers::class,
            PulseCache::class,
            PulseExceptions::class,
            // PulseQueues::class,
            // PulseSlowQueries::class,
            // PulseSlowRequests::class,
            // PulseSlowOutGoingRequests::class
        ];
    }
}
