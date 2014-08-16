<?php namespace Thatzad\Birder;

use Thatzad\Birder\Adapters\BirderAdapter;
use Thatzad\Birder\Exceptions\BirderException;

class Birder
{

    /**
     * Adapter to use
     * @var Thatzad\Birder\Adapters\BirderAdapter
     */
    protected $adapter;


    public function __construct(BirderAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

}
