<?php

namespace Tests\Feature;

use Tests\TestCase;

class ServicePagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost']);
        app('url')->forceRootUrl('http://localhost');
    }

    public function test_service_index_links_every_configured_service(): void
    {
        $response = $this->get('/servicios')->assertOk();

        foreach (config('company_services') as $slug => $service) {
            $response
                ->assertSee($service['short_title'])
                ->assertSee(route('services.show', $slug), false);
        }
    }

    public function test_each_service_has_its_own_public_page(): void
    {
        foreach (config('company_services') as $slug => $service) {
            $this->get('/servicios/'.$slug)
                ->assertOk()
                ->assertSee($service['title'])
                ->assertSee('Solicitar información');
        }
    }

    public function test_unknown_service_returns_not_found(): void
    {
        $this->get('/servicios/no-existe')->assertNotFound();
    }
}
