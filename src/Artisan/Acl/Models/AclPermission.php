<?php

namespace Windqyoung\Utils\Artisan\Acl\Models;


/**
 * Windqyoung\Utils\Artisan\Acl\Models\AclPermission
 *
 * @property integer $id
 * @property string $title 权限的名字, 因为使用name容易和route_name混, 改名叫title
 * @property string $comment 具体说明
 * @property string $permission 一个特殊的权限字符串
 * @property string $route_name 路由里面的名字, 比如 index, ...
 * @property string $method http请求方法, GET, POST, ...
 * @property string $uri_pattern 使用str_is来比较当前uri
 * @property string $unique_tag 一断标识, 查询一个权限是否已添加时, 使用这字段来判断
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclPermission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclPermission whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclPermission whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclPermission wherePermission($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclPermission whereRouteName($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclPermission whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclPermission whereUriPattern($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclPermission whereUniqueTag($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Windqyoung\Utils\Artisan\Acl\Models\AclPermission whereUpdatedAt($value)
 */
class AclPermission extends Model
{
    protected $table = 'acl_permission';
}
