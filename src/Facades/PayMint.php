<?php
namespace PayMint\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class PayMint extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'paymint';
    }
}
