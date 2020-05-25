<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Validator;
use Hash;
use Auth;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Bind models explicitly
        $router->pattern('user', '[a-zA-Z0-9-]+');
        $router->model('user', \App\User::class);
        $router->pattern('merchant', '[a-zA-Z0-9-]+');
        $router->model('merchant', \App\Merchant::class);
        $router->pattern('Wallet', '[a-zA-Z0-9-]+');
        $router->model('Wallet', \App\Wallet::class);
        /*
        //
        Validator::extend('greater_than', function($attribute, $value, $parameters, $validator) {
            // $min_field = $parameters[0];
            // $data = $validator->getData();   
            $min_value = $data[$min_field];
            return $value > $parameters[0];
        });   
        Validator::replacer('greater_than', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
          // return str_replace(':field', $message.' '.$parameters[0], 'Total '.$attribute.' must be more than '.$parameters[0].'');
        });
        */
        Validator::extend('greater_than_field', function($attribute, $value, $parameters, $validator) {
          $min_field  = $parameters[0];
          $data       = $validator->getData();
          $min_value  = $data[$min_field];
          return $value >= $min_value;
        });   

        Validator::replacer('greater_than_field', function($message, $attribute, $rule, $parameters) {
          return str_replace(':field', $message.' '.$parameters[0], 'Total '.$attribute.' must be more than '.$parameters[0].'');
        });
        Validator::extend('passwordNotSame', function($attribute, $value, $parameters, $validator) {
                return Hash::check($value, Auth::user()->password);
        });
         Validator::replacer('passwordNotSame', function($message, $attribute, $rule, $parameters) {
          return str_replace(':field', $message, 'The current passowrd is not match');
        });

        // Map relations
        Relation::morphMap([
            'user' => \App\User::class,
            'merchant' => \App\Merchant::class,
            'member' => \App\OrganizationMember::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
