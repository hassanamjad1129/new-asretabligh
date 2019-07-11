<?php


namespace App\Services;


use Illuminate\Support\Facades\Facade;
/**
 * @see GatewayResolver
 */
class Gateway extends Facade
{
    /**
     * The name of the binding in the IoC container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gateway';
    }
}