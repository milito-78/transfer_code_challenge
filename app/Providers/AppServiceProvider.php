<?php

namespace App\Providers;

use App\Infrastructure\Database\Mysql\TransactionRepository;
use App\Infrastructure\Database\Mysql\UserRepository;
use App\Infrastructure\Repositories\ITransactionRepository;
use App\Infrastructure\Repositories\IUserRepository;
use App\Infrastructure\Sms\Factory as SmsFactory;
use App\Infrastructure\Sms\Interfaces\Sender as SmsSender;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositories();

        $this->app->bind(SmsSender::class,function (){
            return (new SmsFactory(config("sms")))->create();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend("card_number",function ($attribute, $value, $parameters, $validator){
            $validator->setFallbackMessages([$attribute => ":attribute is not a valid card number."]);
            return is_card_number_valid($value);
        });
    }


    /**
     * Register repositories
     * @return void
     */
    private function registerRepositories(): void
    {
        //UserRepository
        $this->app->bind(IUserRepository::class,UserRepository::class);
        $this->app->bind(ITransactionRepository::class,TransactionRepository::class);
    }
}
