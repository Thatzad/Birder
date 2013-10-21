<?php namespace Thatzad\Birder\Facades;

use Illuminate\Support\Facades\Facade;

class Birder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'birder';
    }
}
