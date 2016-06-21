<?php

namespace Windqyoung\Utils\Artisan\Acl\Commands;


use Symfony\Component\Console\Input\InputArgument;
use Windqyoung\Utils\Artisan\Acl\Models\AclRole;

class AclCreateRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'acl:create-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a role by name.';

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
        $name = $this->argument('name');
        $cmt = $this->argument('description');

        $role = new AclRole();
        $role->name = $name;
        $role->comment = $cmt;
        $role->save();

        $this->info('saved: ' . $role->id);
    }


    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'name of the role', null],
            ['description', InputArgument::OPTIONAL, 'description of the role', ''],
        ];
    }
}
