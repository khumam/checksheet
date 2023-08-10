<?php

namespace App\Providers;

use App\Interfaces\CheckSheetInterface;
use App\Interfaces\EquipmentInterface;
use App\Interfaces\GradingInterface;
use App\Interfaces\LossInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\UserSettingInterface;
use App\Repositories\CheckSheetRepository;
use App\Repositories\EquipmentRepository;
use App\Repositories\GradingRepository;
use App\Repositories\LossRepository;
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
        $this->app->bind(CheckSheetInterface::class, CheckSheetRepository::class);
        $this->app->bind(GradingInterface::class, GradingRepository::class);
        $this->app->bind(LossInterface::class, LossRepository::class);
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
