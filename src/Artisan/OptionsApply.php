<?php

namespace Windqyoung\Utils\Artisan;


use Illuminate\Database\Eloquent\Builder;


/**
 * 根据一个选项数组, 来生成带有当前标识的列表.
 *
 * @author windq
 *
 */
class OptionsApply
{
    /**
     * 选项集合
     * @var array
     */
    public $optionsArray = [];

    /**
     * 当前选项
     * @var string
     */
    protected $option;

    /**
     * 默认选项
     * @var string
     */
    public $default;

    /**
     * @param callable $opt
     */
    public $routeCallable;

    /**
     * 数据库条件的数组
     * @var array|callable[]
     */
    public $applyCallableArray = [];

    public function __construct($opt = null)
    {
        if (!is_null($opt))
        {
            $this->setOption($opt);
        }
    }

    public function setOption($opt)
    {
        $this->option = array_key_exists($opt, $this->optionsArray) ? $opt : $this->getDefault();
    }

    public function getDefault()
    {
        return array_key_exists($this->default, $this->optionsArray) ? $this->default : key($this->optionsArray);
    }

    /**
     * 当前选项的判断
     * @param string $opt
     * @param string $currentText
     * @param string $notCurrentText
     */
    public function currentText($opt, $currentText = 'current', $notCurrentText = '')
    {
        return $opt == $this->option ? $currentText : $notCurrentText;
    }

    /**
     * 生成url
     * @param string $opt
     * @return string
     */
    public function getRoute($opt)
    {
        if (is_callable($this->routeCallable))
        {
            return call_user_func($this->routeCallable, $opt);
        }

        throw new \Exception('需要一个route生成器');
    }

    /**
     * 对Builder对象添加条件
     * @param Builder $query
     */
    public function apply($query)
    {
        if (isset($this->applyCallableArray[$this->option]) && is_callable($func = $this->applyCallableArray[$this->option]))
        {
            call_user_func($func, $query);
            return;
        }

        throw new \Exception('需要一个apply函数');
    }
}
