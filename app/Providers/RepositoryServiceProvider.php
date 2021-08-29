<?php

namespace App\Providers;

use App\Repositories\Admins\AdminRepository;
use App\Repositories\Admins\Contract\AdminRepositoryInterface;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\Contract\CategoryRepositoryInterface;
use App\Repositories\Permissions\Contract\PermissionRepositoryInterface;
use App\Repositories\Permissions\PermissionRepository;
use App\Repositories\Posts\Contract\PostRepositoryInterface;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Tags\Contract\TagRepositoryInterface;
use App\Repositories\Tags\TagRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Roles\Contract\RoleRepositoryInterface;
use App\Repositories\Roles\RoleRepository;
use App\Repositories\Codes\Contract\CodePurchaseRepositoryInterface;
use App\Repositories\Codes\CodePurchaseRepository;
use App\Repositories\Users\Contract\UserSubscribeRepositoryInterface;
use App\Repositories\Users\UserSubscribeRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AdminRepositoryInterface::class,
            AdminRepository::class
        );
        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );
        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );
        $this->app->bind(
            PostRepositoryInterface::class,
            PostRepository::class
        );
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->bind(
            TagRepositoryInterface::class,
            TagRepository::class
        );
        $this->app->bind(
            CodePurchaseRepositoryInterface::class,
            CodePurchaseRepository::class
        );
        $this->app->bind(
            UserSubscribeRepositoryInterface::class,
            UserSubscribeRepository::class
        );
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
