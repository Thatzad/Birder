<?php namespace Thatzad\Birder;

use Thatzad\Birder\Exceptions\BirderException;

class Birder
{

    protected $adapter;


    public function __construct(Thatzad\Birder\Adapters\BirderAdapter $adapter)
    {

    }

}
