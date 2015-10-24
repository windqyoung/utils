<?php



namespace Windqyoung\Utils\Artisan;


class BladeExtension
{
    /**
     *
     * @var \Illuminate\View\Compilers\BladeCompiler
     */
    private $blade;

    /**
     * @var \Illuminate\Foundation\Application
     */
    private $app;

    private $containerName = 'windq.blade_ext';


    /**
     * @param \Illuminate\View\Compilers\BladeCompiler $blade
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct($blade, $app)
    {
        $this->blade = $blade;
        $this->app = $app;
    }

    public function register()
    {
        $this->app->instance(__CLASS__, $this);

        $this->app->alias(__CLASS__, $this->containerName);

        $this->blade->directive('include_layout', function ($expr) {
            return "<?php echo app('{$this->containerName}')->renderLayout{$expr} ?>";
        });
    }

    public function renderLayout($view, $data = [], $mergeData = [])
    {
        $env = new \Illuminate\View\Factory(
                $this->app->make('view.engine.resolver'),
                $this->app->make('view.finder'),
                $this->app->make('events')
        );

        return $env->make($view, $data, $mergeData);
    }
}