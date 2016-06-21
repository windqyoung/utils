<?php

namespace Windqyoung\Utils\Artisan\Acl\Models;


/**
 * Windqyoung\Utils\Artisan\Acl\Models\AclRole
 *
 * @property integer $id
 * @property string $name 角色的名字
 * @property string $comment 备注说明
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclRole whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclRole whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclRole whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclRole whereUpdatedAt($value)
 */
class AclRole extends Model
{
    protected $table = 'acl_role';
}
