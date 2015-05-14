<?php

class NamespaceTest extends \PHPUnit_Framework_TestCase
{
    public function provideNamespace()
    {
        return array(
            //array(
                //'src/Tests/Foobar.php',
                //'Psr0\\Tests\\Foobar',
            //),
            array(
                'tests/Foobar.php',
                'Psr4\\Tests',
            ),
            array(
                'src/Psr0/Sub/Name/Foobar.php',
                'Psr0\\Sub\\Name'
            ),
            array(
                'src/Psr0/Foobar.php',
                'Psr0'
            ),
            array(
                'src/Psr4/Foobar.php',
                'Psr4'
            ),
            array(
                'src/Psr4/Sub/Name/Foobar.php',
                'Psr4\\Sub\\Name'
            ),
        );
    }
    /**
     * @dataProvider provideNamespace
     */
    public function testNamespace($file, $namespace)
    {
        chdir(__DIR__);
        exec('php ' . __DIR__ . '/../lib/namespaces.php ' . $file, $output);
        array_shift($output);
        $output = implode(PHP_EOL, $output);
        $this->assertEquals($namespace, $output);
    }
}
