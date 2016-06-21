<?php

namespace Windqyoung\Utils\Artisan\Acl\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Windqyoung\Utils\Artisan\Acl\Models\AclRole;
use Windqyoung\Utils\Artisan\Acl\Models\AclUserRole;

class AclAttachRoleAndUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'acl:attach-role-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'grant a user a role.';

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
        $roleName = $this->argument('role');

        $roleModel = AclRole::whereName($roleName)->first();

        if (! $roleModel)
        {
            $this->error($msg = "the role $roleName does not exists");
            throw new \InvalidArgumentException($msg);
        }

        $userIds = $this->argument('user_id');

        foreach ($userIds as $uid)
        {
            $rel = new AclUserRole();
            $rel->user_id = $uid;
            $rel->role_id = $roleModel->id;
            $rel->save();

            $this->info(sprintf('role: %d, user: %d, rel: %d', $roleModel->id,$uid, $rel->id));
        }
    }

    protected function getArguments()
    {
        return [
            ['role', InputArgument::REQUIRED, 'the role name', null],
            ['user_id', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'the user id(s)', null],
        ];
    }
}
