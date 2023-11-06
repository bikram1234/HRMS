<?php

namespace App\Providers;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\PermissionResource;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Filament\Resources\GeographyResource;



class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function() {
            // Check if the user is authenticated
            if (auth()->check() && auth()->user()->is_admin === 1 && auth()->user()->hasAnyRole(['super-admin', 'admin', 'moderator'])) {
                Filament::registerUserMenuItems ([
                    UserMenuItem::make()
                        ->label('Manage Users')
                        ->url(UserResource::getUrl())
                        ->icon('heroicon-s-users'),
                    UserMenuItem::make()
                    ->label('Manage Roles')
                    ->url(RoleResource::getUrl())
                    ->icon('heroicon-s-cog'),
                    UserMenuItem::make()
                    ->label('Manage Permissions')
                    ->url(PermissionResource::getUrl())
                    ->icon('heroicon-s-key'),
                ]);
            }
        });
    }
    
}
