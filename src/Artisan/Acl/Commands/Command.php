<?php


namespace Windqyoung\Utils\Artisan\Acl\Commands;

use Illuminate\Console\Command as BaseCommand;

class Command extends BaseCommand
{
    public function exportFilename()
    {
        return config_path('/acl_permissions.php');
    }
}
