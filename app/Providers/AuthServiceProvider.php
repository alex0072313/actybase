<?php

namespace App\Providers;

use App\Category;
use App\Image;
use App\Owner;
use App\Policies\CategoryPolicy;
use App\Policies\ImagePolicy;
use App\Policies\OwnerPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Category::class => CategoryPolicy::class,
        Owner::class    => OwnerPolicy::class,
        Image::class    => ImagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
