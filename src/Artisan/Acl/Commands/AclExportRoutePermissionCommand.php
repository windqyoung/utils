<?php

namespace Windqyoung\Utils\Artisan\Acl\Commands;


use Illuminate\Routing\Router;
use Symfony\Component\Console\Input\InputOption;

class AclExportRoutePermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'acl:export-route-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate the permission by route name and methods.';

    /**
     *
     * @var Router
     */
    private $router;

    /**
     * @var \Illuminate\Routing\RouteCollection
     */
    private $routes;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;
        $this->routes = $router->getRoutes();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $routes = $this->getRoutes();

        $this->saveRoutes($routes);
    }


    protected function saveRoutes($permissions)
    {
        $target = $this->option('target') ?: $this->exportFilename();

        if (is_dir($target))
        {
            throw new \InvalidArgumentException("error, target($target) is a directory.");
        }

        $old = [];
        if (file_exists($target))
        {
            $old = include $target;
        }

        $new = [];
        foreach ($permissions as $p)
        {
            if (! $this->containsPermission($old, $p))
            {
                $new[] = $p;
            }
        }

        if (! empty($new))
        {
            file_put_contents($target, '<?php return ' . var_export(array_merge($old, $new), true) . ';');
        }

        $this->table([], $new);

        $this->info(sprintf('find permission: %d', count($permissions)));
        $this->info(sprintf('get old permission: %d', count($old)));
        $this->info(sprintf('new permission: %d', count($new)));
    }

    protected function containsPermission($all, $p)
    {
        foreach ($all as $one)
        {
            if ($one['route_name'] == $p['route_name']
                && $one['method'] == $p['method']
                && $one['uri_tag'] == $p['uri_tag']
            ) {
                return true;
            }
        }

        return false;
    }

    protected function getRoutes()
    {
        $result = [];
        foreach ($this->routes as $r)
        {
            /** @var $r \Illuminate\Routing\Route */
            $name = $r->getName();
            $uri = $r->uri();
            foreach ($r->getMethods() as $m)
            {
                $result[] = $this->filterRoute([
                    'title' => '',
                    'comment' => '',
                    'permission' => '',
                    'route_name' => $name,
                    'method' => $m,
                    'uri_pattern' => '',
                    'uri_tag' => $uri,
                    'unique_tag' => uniqid('acl_'),
                    'ignore' => false,
                ], $r);
            }
        }

        return array_filter($result);
    }


    /**
     * @param array $array
     * @param \Illuminate\Routing\Route $route
     */
    protected function filterRoute($array, $route)
    {
        if (empty($array['route_name'])
            || $array['method'] == 'HEAD' // 去掉head这个, 因为所有的GET都关联一个HEAD, 重复了
        ) {
            return;
        }

        return $array;
    }

    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['target', 'T', InputOption::VALUE_OPTIONAL, 'the file to save'],
        ]);
    }
}
