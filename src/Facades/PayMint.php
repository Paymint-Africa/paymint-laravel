<?php
namespace PayMint\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \PayMint\Resources\Checkout checkout()
 * @method static \PayMint\Resources\VirtualAccount virtualAccounts()
 * @method static \PayMint\Resources\Webhook webhooks()
 * 
 * @see \PayMint\PayMintClient
 */
class PayMint extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'paymint';
    }
}
