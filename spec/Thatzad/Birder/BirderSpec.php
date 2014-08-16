<?php

namespace spec\Thatzad\Birder;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BirderSpec extends ObjectBehavior
{

    function let(Thatzad\Birder\Adapters\BirderAdapter $adapter)
    {
        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Thatzad\Birder\Birder');
    }
}
