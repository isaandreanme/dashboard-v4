<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class SitesSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('sites.site_name', 'Porta P3MI');
        $this->migrator->add('sites.site_description', 'Dashboard Perusahhan Penempatan Perkerja Migran Indonesia');
        $this->migrator->add('sites.site_keywords', 'P3MI, Dashboard, Programming');
        $this->migrator->add('sites.site_profile', asset('images/icon.png'));
        $this->migrator->add('sites.site_logo',asset('images/icon.png'));
        $this->migrator->add('sites.site_author', 'Zimam Ar Rois');
        $this->migrator->add('sites.site_address', 'Semarang, Indonesia');
        $this->migrator->add('sites.site_email', 'zimamarrois@gmail.com');
        $this->migrator->add('sites.site_phone', '+447978290488');
        $this->migrator->add('sites.site_phone_code', '+62');
        $this->migrator->add('sites.site_location', 'Indonesia');
        $this->migrator->add('sites.site_currency', 'IDR');
        $this->migrator->add('sites.site_language', 'Indonesian');
        $this->migrator->add('sites.site_social', []);
    }
}
