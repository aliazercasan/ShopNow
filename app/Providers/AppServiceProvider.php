<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        // Auto-seed database on first deployment
        if (app()->environment('production')) {
            try {
                // Check if users table exists and is empty
                if (Schema::hasTable('users')) {
                    $userCount = DB::table('users')->count();
                    
                    if ($userCount === 0) {
                        // Database is empty, seed it
                        Artisan::call('db:seed', ['--force' => true]);
                        \Log::info('✅ Database auto-seeded successfully on first deployment');
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Auto-seed failed: ' . $e->getMessage());
            }
        }
    }
}
