<?php


namespace Windqyoung\Utils\Artisan\Acl\Models;


use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    public static function tableName()
    {
        $ins = new static();
        return $ins->getTable();
    }

}
