<?php
/**
 * CategoryServiceProvider.php
 * Copyright (C) 2016 thegrumpydictator@gmail.com
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

declare(strict_types = 1);


namespace FireflyIII\Providers;

use FireflyIII\Exceptions\FireflyException;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class CategoryServiceProvider
 *
 * @package FireflyIII\Providers
 */
class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'FireflyIII\Repositories\Category\CategoryRepositoryInterface',
            function (Application $app, array $arguments) {
                if (!isset($arguments[0]) && $app->auth->check()) {
                    return app('FireflyIII\Repositories\Category\CategoryRepository', [auth()->user()]);
                }
                if (!isset($arguments[0]) && !$app->auth->check()) {
                    throw new FireflyException('There is no user present.');
                }

                return app('FireflyIII\Repositories\Category\CategoryRepository', $arguments);
            }
        );

    }
}
