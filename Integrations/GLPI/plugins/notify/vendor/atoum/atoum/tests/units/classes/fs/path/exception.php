<?php

namespace atoum\atoum\tests\units\fs\path;

use atoum\atoum
;

require_once __DIR__ . '/../../../runner.php';

class exception extends atoum\test
{
    public function testClass()
    {
        $this->testedClass->extends(atoum\exceptions\runtime::class);
    }
}
