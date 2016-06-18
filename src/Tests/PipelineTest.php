<?php



namespace Windqyoung\Utils\Tests;



use Windqyoung\Utils\Middleware\Pipeline;

class PipelineTest extends \PHPUnit_Framework_TestCase
{

    public function testPipes()
    {
        $pipes = [
            $func = __NAMESPACE__ . '\pipeline_func',
            __CLASS__,
            $static = __CLASS__ . '::staticFunc',
            $dynamic = __CLASS__ . '::dynamicFunc',
        ];

        $next = new Pipeline($pipes);

        $data = ['hello', 'world'];
        $rs = $next($data);

        $this->assertTrue($rs[$func]);

        $this->assertTrue($rs[__CLASS__ . '::__invoke']);

        $this->assertTrue($rs[$static]);

        $this->assertTrue($rs[$dynamic]);
    }

    public function __invoke($args, $next)
    {
        $args[__METHOD__] = true;
        return $next($args);
    }

    public function dynamicFunc($args, $next)
    {
        $args[__METHOD__] = true;
        return $next($args);
    }

    public static function staticFunc($args, $next)
    {
        $args[__METHOD__] = true;
        return $next($args);
    }

}

function pipeline_func($args, $next)
{
    $args[__FUNCTION__] = true;

    return $next($args);
}