<?php

namespace Windqyoung\Utils\Artisan\Acl\Commands;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Windqyoung\Utils\Artisan\Acl\Models\AclRole;
use Windqyoung\Utils\Artisan\Acl\Models\AclPermission;
use Windqyoung\Utils\Artisan\Acl\Models\AclRolePermission;

class AclGrantRolePermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'acl:grant-role-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'grant a role some permissions.';

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
        $role = $this->argument('role');

        $roleModel = AclRole::whereName($role)->first();

        if (! $roleModel)
        {
            $this->error($msg = "the role $role does not exists");
            throw new \InvalidArgumentException($msg);
        }

        $permission_args = $this->argument('permission');

        $permModes = AclPermission::whereIn(
                $this->option('unique-tag') ? 'unique_tag' : 'id',
                $permission_args
            )->get();

        foreach ($permModes as $pm)
        {
            $rel = new AclRolePermission();
            $rel->role_id = $roleModel->id;
            $rel->permission_id = $pm->id;
            $rel->save();

            $this->info(sprintf('role: %d, perm: %d, rel: %d', $roleModel->id, $pm->id, $rel->id));
        }
    }


    protected function getArguments()
    {
        return [
            ['role', InputArgument::REQUIRED, 'the role name', null],
            ['permission', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'one or more permission\'s id(s) or unique tag(s)', null],
        ];
    }

    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['unique-tag', 'U', InputOption::VALUE_NONE, null],
        ]);
    }
}
