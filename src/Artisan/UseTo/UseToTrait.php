<?php


namespace Windqyoung\Utils\Artisan\UseTo;


/**
 * 使用use_to字段的条件
 * @author windq
 *
 */
trait UseToTrait
{

    public static function bootUseToTrait()
    {
        $name = static::getBootUseToTraitProperyName();
        // 如果设置了, 添加scope
        if (isset(static::$$name))
        {
            static::addGlobalScope(new UseToScope());
        }

    }

    public static function getBootUseToTraitProperyName()
    {
        return 'bootUseToTrait' . str_replace('\\', '', static::class);
    }

    public function getQualifiedUseToFieldName()
    {
        return $this->getTable() . '.use_to';
    }
}
