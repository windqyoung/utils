<?php

namespace Windqyoung\Utils\Artisan\Acl\Models;


/**
 * Windqyoung\Utils\Artisan\Acl\Models\AclUserRole
 *
 * @property integer $id
 * @property integer $user_id 用户id
 * @property integer $role_id 角色id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclUserRole whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclUserRole whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclUserRole whereRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclUserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclUserRole whereUpdatedAt($value)
 */
class AclUserRole extends Model
{
    protected $table = 'acl_user_role';
}
