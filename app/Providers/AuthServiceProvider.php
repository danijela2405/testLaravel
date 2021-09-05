<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Reservation;
use App\Models\Store;
use App\Policies\ProductPolicy;
use App\Policies\ReservationPolicy;
use App\Policies\StorePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Store::class => StorePolicy::class,
        Product::class => ProductPolicy::class,
        Reservation::class => ReservationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
