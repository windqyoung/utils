<?php


namespace Windqyoung\Utils\Artisan;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;


class OrderBy
{
    const ASC = 1;
    const DESC = 2;

    private $value;

    /**
     * @var Expression|string
     */
    private $column;

    public function __construct($value, $column, $defIsAsc = true)
    {
        $this->column = $column;

        $this->setValue($value, $defIsAsc);
    }

    public function setValue($v, $defIsAsc)
    {
        if (in_array($v, [self::ASC, self::DESC]))
        {
            $this->value = $v;
        } else
        {
            $this->value = $defIsAsc ? self::ASC : self::DESC;
        }
    }

    /**
     * @param Builder $query
     */
    public function apply($query)
    {
        $query->getQuery()->orderBy(
            $this->getOrderColumn($query),
            self::ASC == $this->value ? 'asc' : 'desc'
        );
    }

    /**
     * @param Builder $query
     */
    private function getOrderColumn($query)
    {
        if ($this->column instanceof Expression)
        {
            return $this->column;
        }

        return $query->getModel()->getTable() . '.' . $this->column;
    }

    /**
     * 当前排序
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * 相反的排序
     */
    public function other()
    {
        return self::ASC == $this->value ? self::DESC : self::ASC;
    }


    public function isDesc()
    {
        return self::DESC == $this->value;
    }
}