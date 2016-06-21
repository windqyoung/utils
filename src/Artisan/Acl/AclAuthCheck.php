<?php


namespace Windqyoung\Utils\Artisan\Acl;


use Windqyoung\Utils\Artisan\Acl\Models\AclRole;
use Windqyoung\Utils\Artisan\Acl\Models\AclPermission;
use Windqyoung\Utils\Artisan\Acl\Models\AclUserRole;
use Windqyoung\Utils\Artisan\Acl\Models\AclRolePermission;

class AclAuthCheck
{
    /**
     * 管理员id
     *
     * @var int
     */
    private $adminId;

    /**
     * 超级角色id, 如果有在此数组中的role_id, 直接通过, 不检查
     *
     * @var array
     */
    private $superRoleIds = [];

    /**
     * 管理员所属角色
     *
     * @var AclRole[]|\Illuminate\Database\Eloquent\Collection
     */
    private $roles;

    /**
     * 管理员所属角色拥有的所有权限
     * @var AclPermission[]|Illuminate\Database\Eloquent\Collection
     */
    private $rolePermissions;

    public function __construct($adminId)
    {
        $this->adminId = $adminId;
    }

    /**
     * 超级角色的id
     *
     * @param array
     */
    public function setSuperRoleIds($superRoleIds)
    {
        $this->superRoleIds = $superRoleIds;
    }

    /**
     * 有对某个route的访问权限? 判断权限表中的route_name, method
     *
     * @param string $routeName route name
     * @param string $method http method
     */
    public function canAccessRoute($routeName, $method = 'GET', $checkSuperRole = true)
    {
        if ($checkSuperRole && $this->isSuperRole())
        {
            return true;
        }

        if ($this->hasRoutePermission($routeName, $method))
        {
            return true;
        }

        return false;
    }

    public function canAccessAnyRoute($routeAndMethods, $checkSuperRole = true)
    {
        if ($checkSuperRole && $this->isSuperRole())
        {
            return true;
        }

        foreach ($routeAndMethods as $ram)
        {
            $ram = (array)$ram;
            $routeName = $ram[0];
            $method = empty($ram[1]) ? 'GET' : $ram[1];

            if ($this->hasRoutePermission($routeName, $method))
            {
                return true;
            }
        }

        return false;
    }

    private
    function hasRoutePermission($routeName, $method)
    {
        if (empty($routeName) || empty($method))
        {
            return false;
        }

        $permissions = $this->getPermissions();

        foreach ($permissions as $p)
        {
            if ($p->route_name == $routeName && $p->method == $method)
            {
                return true;
            }
        }

        return false;
    }

    private function getPermissions()
    {
        if (! $this->rolePermissions)
        {
            $this->rolePermissions = AclPermission::whereIn('id', function ($query) {
                /** @var $query \Illuminate\Database\Query\Builder */
                $query->from(AclRolePermission::tableName())
                    ->select('permission_id')
                    ->whereIn('role_id', $this->getRoles()->lists('id'));

            })->get();
        }

        return $this->rolePermissions;
    }

    private function isSuperRole()
    {
        $roles = $this->getRoles();

        foreach ($roles as $r)
        {
            if (in_array($r->id, $this->superRoleIds))
            {
                return true;
            }
        }

        return false;
    }

    private function getRoles()
    {
        if (! $this->roles)
        {
            $this->roles = AclRole::whereIn('id', function ($query) {
                /** @var $query \Illuminate\Database\Query\Builder */
                $query->select('role_id')->from(AclUserRole::tableName())
                        ->where('user_id', $this->adminId);
            })->get();
        }

        return $this->roles;
    }

    /**
     * 有某个权限? 判断权限表中的permission字段
     * @param string $permission
     */
    public function hasPermission($permission, $checkSuperRole = true)
    {
        if ($checkSuperRole && $this->isSuperRole())
        {
            return true;
        }

        if (empty($permission))
        {
            return false;
        }

        $pms = $this->getPermissions();


        foreach ($pms as $p)
        {
            if ($p->permission == $permission)
            {
                return true;
            }
        }

        return false;
    }
}
