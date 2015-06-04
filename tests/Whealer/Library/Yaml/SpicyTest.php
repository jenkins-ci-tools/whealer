<?php
namespace Whealer\Test\Library\Yaml;
use Whealer\Library\Yaml\Spicy;

class SpicyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function loadString()
    {
        $raw = <<<EOT
---
- test:
    1:
        1
        2
        3
    2
    3
EOT;
        $yaml = Spicy::loadString($raw);
        $this->assertEquals(array(array("test"=>array(1=>array(1,2,3),2,3))), $yaml);
    }
}
