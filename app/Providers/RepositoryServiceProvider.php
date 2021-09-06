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
use App\Repositories\Codes\Contract\CodeRepositoryInterface;
use App\Repositories\Codes\CodeRepository;
use App\Repositories\Users\Contract\UserSubscribeRepositoryInterface;
use App\Repositories\Users\UserSubscribeRepository;
use App\Repositories\Serial\Contract\SerialRepositoryInterface;
use App\Repositories\Serial\SerialRepository;
use App\Repositories\Premiums\Contract\PremiumMaziiRepositoryInterface;
use App\Repositories\Premiums\PremiumMaziiRepository;
use App\Repositories\Purchase\Contract\MaziiPurchaseRepositoryInterface;
use App\Repositories\Purchase\MaziiPurchaseRepository;
use App\Repositories\Jlpt\Contract\JlptRepositoryInterface;
use App\Repositories\Jlpt\JlptRepository;
use App\Repositories\Languages\Contract\LanguageRepositoryInterface;
use App\Repositories\Languages\LanguageRepository;
use App\Repositories\UserMazii\Contract\UserMaziiRepositoryInterface;
use App\Repositories\UserMazii\UserMaziiRepository;
use App\Repositories\Profile\Contract\ProfileRepositoryInterface;
use App\Repositories\Profile\ProfileRepository;
use App\Repositories\Jobs\Contract\JobRepositoryInterface;
use App\Repositories\Jobs\JobRepository;
use App\Repositories\Comments\Contract\CommentRepositoryInterface;
use App\Repositories\Comments\CommentRepository;
use App\Repositories\ChildComments\Contract\ChildCommentRepositoryInterface;
use App\Repositories\ChildComments\ChildCommentRepository;



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
            CodeRepositoryInterface::class,
            CodeRepository::class
        );
        $this->app->bind(
            UserSubscribeRepositoryInterface::class,
            UserSubscribeRepository::class
        );
        $this->app->bind(
            SerialRepositoryInterface::class,
            SerialRepository::class
        );
        $this->app->bind(
            PremiumMaziiRepositoryInterface::class,
            PremiumMaziiRepository::class
        );
        $this->app->bind(
            MaziiPurchaseRepositoryInterface::class,
            MaziiPurchaseRepository::class
        );
        $this->app->bind(
            JlptRepositoryInterface::class,
            JlptRepository::class
        );
        $this->app->bind(
            LanguageRepositoryInterface::class,
            LanguageRepository::class
        );
        $this->app->bind(
            UserMaziiRepositoryInterface::class,
            UserMaziiRepository::class
        );
        $this->app->bind(
            ProfileRepositoryInterface::class,
            ProfileRepository::class
        );
        $this->app->bind(
            JobRepositoryInterface::class,
            JobRepository::class
        );
        $this->app->bind(
            CommentRepositoryInterface::class,
            CommentRepository::class
        );
        $this->app->bind(
            ChildCommentRepositoryInterface::class,
            ChildCommentRepository::class
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
