<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $siteContent = SiteContent::current();

        return view('services.index', [
            'services' => $siteContent->services(),
            'siteContent' => $siteContent,
        ]);
    }

    public function show(string $service): View
    {
        $siteContent = SiteContent::current();
        $services = $siteContent->services();
        abort_unless(array_key_exists($service, $services), 404);

        return view('services.show', [
            'slug' => $service,
            'service' => $services[$service],
            'services' => $services,
            'siteContent' => $siteContent,
        ]);
    }
}
