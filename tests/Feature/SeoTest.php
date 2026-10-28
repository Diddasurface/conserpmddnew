<?php

namespace Tests\Feature;

use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase {
        refreshDatabase as protected refreshIsolatedDatabase;
    }

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost', 'app.env' => 'production']);
        app('url')->forceRootUrl('http://localhost');
    }

    public function refreshDatabase(): void
    {
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        $this->refreshIsolatedDatabase();
    }

    public function test_public_pages_allow_indexing_and_have_distinct_metadata(): void
    {
        $titles = [];
        $descriptions = [];
        foreach (['/', '/nosotros', '/contactanos'] as $path) {
            $response = $this->get($path.'?utm_source=test')->assertOk();
            $dom = new DOMDocument;
            @$dom->loadHTML($response->getContent());
            $xpath = new DOMXPath($dom);
            $this->assertSame('es', $dom->documentElement->getAttribute('lang'));
            $this->assertSame('index, follow, max-image-preview:large', $xpath->evaluate('string(//meta[@name="robots"]/@content)'));
            $this->assertSame('https://conserpmdd.com'.$path, $xpath->evaluate('string(//link[@rel="canonical"]/@href)'));
            $titles[] = $xpath->evaluate('string(//title)');
            $descriptions[] = $xpath->evaluate('string(//meta[@name="description"]/@content)');
            $schema = json_decode($xpath->evaluate('string(//script[@type="application/ld+json"])'), true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame('Organization', $schema['@graph'][0]['@type']);
            $this->assertSame('+51982604441', $schema['@graph'][0]['telephone']);
            $this->assertStringContainsString('ConserpMDD', end($titles));
            $this->assertNotEmpty(end($descriptions));
        }
        $this->assertCount(3, array_unique($titles));
        $this->assertCount(3, array_unique($descriptions));
    }

    public function test_local_pages_and_certificate_pages_keep_noindex(): void
    {
        config(['app.env' => 'local']);
        $this->get('/')->assertOk()->assertSee('content="noindex, nofollow"', false);
        config(['app.env' => 'production']);
        $this->get('/certificados')->assertOk()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->get('/certificados/UNKNOWN')->assertNotFound()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->get('/admin/login')->assertOk()->assertSee('name="robots" content="noindex, nofollow"', false);
    }

    public function test_sitemap_contains_only_real_public_pages_and_robots_announces_it(): void
    {
        $document = new DOMDocument;
        $this->assertTrue($document->load(public_path('sitemap.xml')));
        $locations = [];
        foreach ($document->getElementsByTagName('loc') as $node) {
            $locations[] = $node->textContent;
        }
        $this->assertSame([
            'https://conserpmdd.com/', 'https://conserpmdd.com/nosotros', 'https://conserpmdd.com/contactanos',
        ], $locations);
        $robots = file_get_contents(public_path('robots.txt'));
        $this->assertStringContainsString('Sitemap: https://conserpmdd.com/sitemap.xml', $robots);
        $this->assertStringContainsString('Disallow: /admin', $robots);
        $this->assertStringNotContainsString('Disallow: /certificados', $robots);
    }

    public function test_search_console_meta_verification_can_be_configured(): void
    {
        config(['seo.google_verification' => 'verification-test-token']);
        $this->get('/nosotros')->assertOk()->assertSee('name="google-site-verification" content="verification-test-token"', false);
    }
}
