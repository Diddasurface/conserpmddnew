<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Panel;
use Tests\TestCase;

class ProductionPanelAccessTest extends TestCase
{
    public function test_only_configured_admin_emails_can_access_production_panel(): void
    {
        config(['app.env' => 'production', 'admin.emails' => ['admin@example.com']]);
        $panel = Filament::getPanel('admin');

        $this->assertTrue((new User(['email' => 'ADMIN@example.com']))->canAccessPanel($panel));
        $this->assertFalse((new User(['email' => 'other@example.com']))->canAccessPanel($panel));
        $this->assertFalse((new User(['email' => 'admin@example.com']))->canAccessPanel(Panel::make()->id('other')));

        config(['admin.emails' => []]);
        $this->assertFalse((new User(['email' => 'admin@example.com']))->canAccessPanel($panel));
    }

    public function test_existing_local_accounts_keep_access(): void
    {
        config(['app.env' => 'local', 'admin.emails' => []]);
        $this->assertTrue((new User(['email' => 'local@example.com']))->canAccessPanel(Filament::getPanel('admin')));
    }
}
