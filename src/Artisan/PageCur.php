<?php


namespace Windqyoung\Utils\Artisan;


use Illuminate\Pagination\LengthAwarePaginator;
use URL;
use Request;

class PageCur
{

    /**
     * 给一个分页对象， 设置当前url， 及query参数
     * @param LengthAwarePaginator $p
     * @param array $options
     * @return LengthAwarePaginator
     */
    public static function make($p, $options = [])
    {
        $query = array_get(
            $options,
            'query',
            function () {
                return Request::getFacadeRoot()->query->all();
            }
        );
        foreach ($query as $key => $value)
        {
            $p->addQuery($key, $value);
        }

        $p->setPath(array_get($options, 'path', URL::current()));

        return $p;
    }

}
