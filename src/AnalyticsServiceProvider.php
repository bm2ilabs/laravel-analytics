<?php namespace SoftArt\Packages\Analytics;

use SoftArt\Packages\Analytics\Analytics;
use SoftArt\Packages\Analytics\AnalyticsClient;
use SoftArt\Packages\Analytics\AnalyticsClientFactory;

/**
* AnalyticsServiceProvider
*/
class AnalyticsServiceProvider extends \Spatie\Analytics\AnalyticsServiceProvider
{

    /**
     * Register the service provider.
     */
    public function register()
    {
        $analyticsConfig = config('laravel-analytics');

        $this->app->bind(AnalyticsClient::class, function () use ($analyticsConfig) {
            return AnalyticsClientFactory::createForConfig($analyticsConfig);
        });

        $this->app->bind(Analytics::class, function () use ($analyticsConfig) {
            $this->guardAgainstInvalidConfiguration($analyticsConfig);

            $client = app(AnalyticsClient::class);

            return new Analytics($client, $analyticsConfig['view_id']);
        });

        $this->app->alias(Analytics::class, 'laravel-analytics');
    }
}
