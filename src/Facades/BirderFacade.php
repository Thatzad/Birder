<?php namespace Thatzad\Birder\Facades;

use Illuminate\Support\Facades\Facade;

class BirderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Birder';
    }
}
