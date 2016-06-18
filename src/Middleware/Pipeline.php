<?php



namespace Windqyoung\Utils\Middleware;





class Pipeline
{
    private $pipes;

    public function __construct($pipes)
    {
        $this->pipes = $pipes;
    }

    public function __invoke($args)
    {
        if (is_callable($next = $this->createNext()))
        {
            return $next($args, $this);
        }

        return $args;
    }

    private function createNext()
    {
        if (count($this->pipes) == 0)
        {
            return;
        }

        $next = array_shift($this->pipes);

        if (is_string($next))
        {
            $next = $this->createNextFromString($next);
        }

        if (is_callable($next))
        {
            return $next;
        }

        throw new \Exception('does not a callable');
    }

    private function createNextFromString($next)
    {
        if (function_exists($next))
        {
            return $next;
        }

        if (false === strpos($next, '::'))
        {
            return new $next;
        }

        $ref = new \ReflectionMethod($next);

        if ($ref->isStatic())
        {
            return $next;
        }

        return [new $ref->class, $ref->name];
    }
}
