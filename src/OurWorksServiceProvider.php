<?php

namespace MediaWebId\OurWorks;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use MediaWebId\OurWorks\Commands\OurWorksCommand;

class OurWorksServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('ourworks')
            ->hasConfigFile()
            ->hasRoutes('web')
            ->hasViews()
            ->hasMigration('create_ourworks_table')
            ->hasCommand(OurWorksCommand::class);
    }
}
