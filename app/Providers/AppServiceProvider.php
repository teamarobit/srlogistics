<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // CLOUDFLARE_TUNNEL_URL_FIX
        if (!app()->runningInConsole()) {
            $request = request();
            $forwardedHost = (string) $request->headers->get('X-Forwarded-Host', '');
            $isCloudflareRequest = $request->headers->has('CF-Connecting-IP')
                || $request->headers->has('Cf-Ray')
                || str_contains($forwardedHost, 'sr-v1.livedeals.co.in');

            if ($isCloudflareRequest) {
                URL::forceScheme('https');
                URL::forceRootUrl((string) config('app.url'));
            }
        }
    }
}
