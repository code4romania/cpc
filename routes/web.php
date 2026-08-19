<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/' . config('cpc.default_locale', 'ro'));

Route::prefix('{locale}')
    ->where(['locale' => 'ro|en'])
    ->middleware(SetLocale::class)
    ->group(function (): void {
        Route::livewire('/', 'pages::home')->name('home');

        Route::middleware('guest')->group(function (): void {
            Route::livewire('/login', 'pages::login')->name('login');
            Route::livewire('/register', 'pages::register')->name('register');
        });

        Route::middleware('auth')->group(function (): void {
            Route::livewire('/auth/pending', 'pages::auth-pending')->name('auth.pending');

            Route::middleware('professional.verified')
                ->prefix('portal')
                ->group(function (): void {
                    Route::livewire('/', 'pages::portal-index')->name('portal.index');
                    Route::livewire('/resources', 'pages::portal-resources')->name('portal.resources');
                    Route::livewire('/consultations', 'pages::portal-consultations-index')->name('portal.consultations.index');
                    Route::livewire('/consultations/create', 'pages::portal-consultations-create')->name('portal.consultations.create');
                    Route::livewire('/consultations/{consultation}', 'pages::portal-consultations-show')->name('portal.consultations.show');
                    Route::livewire('/profile', 'pages::portal-profile')->name('portal.profile');
                });
        });

        Route::livewire('/resources', 'pages::resources-index')->name('resources.index');
        Route::livewire('/resources/{slug}', 'pages::resources-show')->name('resources.show');
        Route::livewire('/statistics', 'pages::statistics-index')->name('statistics.index');
        Route::livewire('/statistics/index-vulnerability', 'pages::statistics-index-detail')
            ->defaults('type', 'vulnerability')->name('statistics.index-vulnerability');
        Route::livewire('/statistics/index-resilience', 'pages::statistics-index-detail')
            ->defaults('type', 'resilience')->name('statistics.index-resilience');
        Route::livewire('/statistics/index-rti', 'pages::statistics-index-detail')
            ->defaults('type', 'rti')->name('statistics.index-rti');
        Route::livewire('/statistics/{slug}', 'pages::statistics-show')->name('statistics.show');
        Route::livewire('/organizations', 'pages::organizations-index')->name('organizations.index');
        Route::livewire('/submit', 'pages::submit')->name('submit.index');
        Route::livewire('/about', 'pages::about')->name('about');
        Route::livewire('/partner-organizations', 'pages::partners-index')->name('partners.index');
        Route::livewire('/terms', 'pages::static-page')->defaults('slug', 'terms')->name('terms');
        Route::livewire('/cookie-policy', 'pages::static-page')->defaults('slug', 'cookie-policy')->name('cookie-policy');
        Route::livewire('/privacy', 'pages::static-page')->defaults('slug', 'privacy')->name('privacy');
        Route::livewire('/accessibility', 'pages::static-page')->defaults('slug', 'accessibility')->name('accessibility');
    });
