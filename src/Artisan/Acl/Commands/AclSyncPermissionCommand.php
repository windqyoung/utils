<?php

namespace Windqyoung\Utils\Artisan\Acl\Commands;


use Symfony\Component\Console\Input\InputOption;
use Log;
use Windqyoung\Utils\Artisan\Acl\Models\AclPermission;

class AclSyncPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'acl:sync-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add new permission to the table.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $permissions = $this->getPermissions();

        $this->savePermissions($permissions);
    }

    protected function savePermissions($permissions)
    {
        foreach ($permissions as $p)
        {
            $this->saveOnePermission($p);
        }
    }

    protected function saveOnePermission($permission)
    {
        $msg = sprintf('process %s(%s)',
            $unique = $permission['unique_tag'],
            $uri_tag = $permission['uri_tag']);

        if ($permission['ignore'])
        {
            Log::debug($msg . " ignore");
            return;
        }

        $p = AclPermission::whereUniqueTag($unique)->first();

        $force = $this->option('force');
        // 存在, 并且不强制更新, 跳过
        if ($p && ! $force)
        {
            Log::info($msg . " skip(exists)");
            return;
        }

        $model = ($p && $force) ? $p : new AclPermission();

        $model->title = $permission['title'];
        $model->comment = $permission['comment'];
        $model->permission = $permission['permission'];
        $model->route_name = $permission['route_name'];
        $model->method = $permission['method'];
        $model->uri_pattern = $permission['uri_pattern'];
        $model->unique_tag = $permission['unique_tag'];

        $model->save();

        $this->info(sprintf("%s\tdone(%s)", $msg, $p ? 'update' : 'new'));
    }

    protected function getPermissions()
    {
        $target = $this->option('target') ?: $this->exportFilename();
        if (! is_file($target))
        {
            throw new \InvalidArgumentException("the target file ${target} not exists.");
        }

        $permissions = include $target;
        if (empty($permissions))
        {
            throw new \InvalidArgumentException("the permission data is empty.");
        }

        return $permissions;
    }

    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['target', 'T', InputOption::VALUE_OPTIONAL, 'the file to save'],
            ['force', null, InputOption::VALUE_NONE, 'force to update the table, if a permission exists.']
        ]);
    }
}
