<?php

namespace App\Providers;

use App\Interfaces\EquipmentInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\UserSettingInterface;
use App\Repositories\CourseRepository;
use App\Repositories\EquipmentRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserSettingRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(UserSettingInterface::class, UserSettingRepository::class);
        $this->app->bind(EquipmentInterface::class, EquipmentRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
