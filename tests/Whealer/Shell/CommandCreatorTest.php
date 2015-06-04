<?php
namespace Whealer\Test\Shell;
use Whealer\Shell\CommandCreator;
class CommandCreatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function get()
    {

        $command = CommandCreator::get("echo", [], '"Hello World"');
        $this->assertEquals('echo  "Hello World"', $command);
    }

    /**
     * @test
     */
    public function which()
    {
        $bin = CommandCreator::which("ssh");
        $this->assertEquals("/usr/bin/ssh", $bin);
    }

    /**
     * @test
     */
    public function pipe()
    {
        $commands = [
            CommandCreator::get("ls", ["-la"], './'),
            CommandCreator::get("grep", [], 'phpunit.xml')
        ];
        $raw = CommandCreator::pipe($commands);
        $this->assertEquals('ls -la ./ | grep  phpunit.xml', $raw);
    }

    /**
     * @test
     */
    public function join()
    {
        $commands = [
            CommandCreator::get("echo", [], '"Hello World\n"'),
            CommandCreator::get("ls", ["-la"], './')
        ];
        $raw = CommandCreator::join($commands);
        $this->assertEquals('echo  "Hello World\n" && ls -la ./', $raw);
    }



    /**
     * @test
     */
    public function docker()
    {
        $bin = CommandCreator::which("docker");
        $command = CommandCreator::get($bin, ["build","-t" => "jenkins-ci-php:latest"], "./");
        $this->assertEquals("/usr/local/bin/docker build -t jenkins-ci-php:latest ./", $command);
    }
}
