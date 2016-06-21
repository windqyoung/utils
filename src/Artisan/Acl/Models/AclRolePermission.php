<?php

namespace Windqyoung\Utils\Artisan\Acl\Models;


/**
 * Windqyoung\Utils\Artisan\Acl\Models\AclRolePermission
 *
 * @property integer $id
 * @property integer $role_id 角色id
 * @property integer $permission_id 权限id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclRolePermission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclRolePermission whereRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclRolePermission wherePermissionId($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclRolePermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclRolePermission whereUpdatedAt($value)
 */
class AclRolePermission extends Model
{
    protected $table = 'acl_role_permission';
}
