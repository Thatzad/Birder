<?php

namespace spec\Thatzad\Birder\Adapters;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BirderAdapterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Thatzad\Birder\Adapters\BirderAdapter');
    }
}
