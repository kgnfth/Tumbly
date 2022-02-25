<?php

namespace App\Providers;

use Illuminate\Contracts\View\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Tumblr\API\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function () {
            if (session()->has('oauth_token')) {
                return new Client(
                    env('TUMBLR_API_KEY'),
                    env('TUMBLR_SECRET_KEY'),
                    session('oauth_token'),
                    session('oauth_token_secret')
                );
            } else {
                return new Client(env('TUMBLR_API_KEY'), env('TUMBLR_SECRET_KEY'));
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['request']->server->set('HTTPS', 'on');

        Paginator::useBootstrap();

        view()->composer('*', function (View $view) {
            $client = new Client(
                env('TUMBLR_API_KEY'),
                env('TUMBLR_SECRET_KEY'),
                session('oauth_token'),
                session('oauth_token_secret')
            );
            $view->with('tumblr', $client);
        });
    }
}
