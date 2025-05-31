<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request; // <-- Убедитесь, что эта строка есть

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
        // Добавьте это в метод boot:
        $this->app->make(Request::class)->server->set('HTTPS', true); // <-- Это для HMR от Vite, чтобы он генерировал https
        $this->app->make(Request::class)->server->set('SERVER_PORT', 443); // <-- Для форм и других ссылок

        // Это опционально, но рекомендуется для более сложных случаев с прокси:
        $this->app->bind('path.public', function() {
            return base_path('public');
        });

        // Настройка доверенных прокси (это важно для генерации URL)
        // Для localtunnel/ngrok, которые не имеют фиксированных IP, можно доверить всем:
        $this->app['request']->server->set('HTTPS', 'on'); // Принудительно установить HTTPS
        $this->app['request']->setTrustedProxies(
            ['REMOTE_ADDR'], Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO | Request::HEADER_X_FORWARDED_AWS_ELB
        );
        // Или, более просто, для базовых случаев (если вы не используете сложные балансировщики):
        // $this->app['request']->setTrustedProxies(['127.0.0.1', $this->app['request']->server('REMOTE_ADDR')]); // Только localhost и текущий удаленный IP
        // Если проблемы остаются, можно использовать TrustProxies middleware (см. ниже)
    }
}