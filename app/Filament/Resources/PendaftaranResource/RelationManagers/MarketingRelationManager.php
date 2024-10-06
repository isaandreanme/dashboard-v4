<?php

namespace App\Filament\Resources\PendaftaranResource\RelationManagers;

use App\Models\Agency;
use App\Models\Marketing;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MarketingRelationManager extends RelationManager
{
    protected static string $relationship = 'Marketing';
    protected static ?string $title = 'MARKETING / BIODATA';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section::make('AKUN CPMI')
                //     ->description('Pilih Akun CPMI jika Sudah Registrasi Di Portal')->schema([
                //         Select::make('user_id')
                //             ->relationship('User', 'name')
                //             ->placeholder('Pilih Akun CPMI')
                //             ->label('Akun CPMI')
                //             ->getOptionLabelFromRecordUsing(fn(User $record) => "{$record->name} ({$record->email})")
                //             ->searchable()
                //             ->optionsLimit(3),
                //     ]),
                Section::make('REQUEST BIODATA KE MARKETING')
                    ->description('Dari Data Pendaftaran')
                    ->icon('heroicon-m-check-badge')
                    ->schema([
                        Fieldset::make('')
                            ->schema([
                                Select::make('sales_id',)
                                    ->relationship('Sales', 'nama')
                                    ->label('SALES MARKETING')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->optionsLimit(6)
                                    ->placeholder('Pilih Marketing'),
                                    Select::make('agency_id')
                                    ->relationship('Agency', 'nama')
                                    ->required()
                                    ->label('AGENCY MARKETING')
                                    ->options(Agency::whereIn('id', [1, 2])->pluck('nama', 'id')) // Hanya menampilkan agency_id 1 dan 2
                                    ->placeholder('Pilih Agency'),                                
                            ])->columns(2),

                        // Section::make('VERIVIKASI DOKUMEN')
                        //     ->description('Silahkan Centang Jika Data Sudah Lengkap')
                        //     ->icon('heroicon-o-check-circle')
                        //     ->schema([
                        //         Toggle::make('pendaftaran.data_lengkap')
                        //             ->inline(true),
                        //     ]),
                    ])

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('Pendaftaran.nama')->label('CPMI')->weight('bold')->searchable()
                    ->copyable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                TextColumn::make('Pendaftaran.nomor_ktp')->label('E-KTP')->color('primary')
                    ->copyable()
                    ->searchable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                // ->limit(10),
                TextColumn::make('ProsesCpmi.Tujuan.nama')->label('TUJUAN')->color('primary')
                    ->copyable()
                    ->searchable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                TextColumn::make('ProsesCpmi.Status.nama')->label('STATUS')->color('primary')
                    ->copyable()
                    ->searchable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                TextColumn::make('Agency.nama')->label('STATUS MARKET')->color('primary')
                    ->copyable()
                    ->searchable()
                    ->copyMessage('Salin Berhasil')
                    ->copyMessageDuration(1500),
                IconColumn::make('get_job')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->label('STATUS JOB')->toggleable(isToggledHiddenByDefault: false)->disabled(),
                TextColumn::make('tgl_job')
                    ->label('TGL JOB')->toggleable(isToggledHiddenByDefault: false)->disabled(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-m-check-badge')
                    ->label('REQ BIODATA KE MARKETING +'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Ubah')
                        ->color('primary'),
                    Action::make('Download Pdf')
                        ->label('Biodata Hongkong')
                        ->icon('heroicon-o-printer')
                        ->url(fn(Marketing $record) => route('hongkong.pdf.download', ['id' => $record->id]))
                        ->openUrlInNewTab()
                        ->color('success'),
                    Action::make('Download Pdf')
                        ->label('Biodata Taiwan')
                        ->icon('heroicon-o-printer')
                        ->url(fn(Marketing $record) => route('taiwan.pdf.download', ['id' => $record->id]))
                        ->openUrlInNewTab()
                        ->color('success'),
                    Action::make('Download Pdf')
                        ->label('Biodata Singapore')
                        ->icon('heroicon-o-printer')
                        ->url(fn(Marketing $record) => route('singapore.pdf.download', ['id' => $record->id]))
                        ->openUrlInNewTab()
                        ->color('success'),
                    Action::make('Download Pdf')
                        ->label('Biodata Malaysia')
                        ->icon('heroicon-o-printer')
                        ->url(fn(Marketing $record) => route('malaysia.pdf.download', ['id' => $record->id]))
                        ->openUrlInNewTab()
                        ->color('success'),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
