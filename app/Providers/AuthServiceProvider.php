<?php

namespace App\Providers;

use App\Conversation;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::before(function ($user, $ability){
            if(Auth::check() && $user->abilities()->contains($ability)){
                return true;
            }
        });

        Gate::define('not-company', function ($user){
            if(\auth()->guard('company')->check()){
                return false;
            }else{
                return true;
            }
        });

        Gate::define('must_be_employee', function ($user){
            if(\auth()->guard('employee')->check()){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('show_my_conversations', function ($user, $conversation){
            return $conversation->hr_id == $user->id || $conversation->employee_id == $user->id;

        });

        Gate::define('must_be_admin', function ($user, $vacationType = null){
            if (isset($vacationType)){
                if($vacationType->type == 'custom'){
                    return true;
                }
            }
            return \auth()->guard('company')->check() and $user->id == 1;
        });
    }
}
