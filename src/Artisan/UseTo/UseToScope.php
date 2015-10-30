<?php

namespace Windqyoung\Utils\Artisan\UseTo;


use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;

class UseToScope implements ScopeInterface
{
    /**
     * {@inheritDoc}
     * @see \Illuminate\Database\Eloquent\ScopeInterface::apply()
     */
    public function apply(Builder $builder, Model $model)
    {
        /**
         * @var $model Model
         */
        $name = $model::getBootUseToTraitProperyName();
        $value = $model::$$name;

        $value = $model->getConnection()->getPdo()->quote($value);

        $builder->where($model->getQualifiedUseToFieldName(), new Expression($value));

        $this->addWithTrashed($builder);
    }

    /**
     * 使用方法withTrashedUseTo来移除apply添加的条件
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithTrashed(Builder $builder)
    {
        $builder->macro('withTrashedUseTo', function (Builder $builder) {
            $this->remove($builder, $builder->getModel());

            return $builder;
        });
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Database\Eloquent\ScopeInterface::remove()
     */
    public function remove(Builder $builder, Model $model)
    {
        /**
         * @var $model \App\Models\AuctionItem
         */
        $column = $model->getQualifiedUseToFieldName();

        $query = $builder->getQuery();

        $query->wheres = collect($query->wheres)->reject(function ($where) use ($column) {
            return 'Basic' == $where['type']
                    &&
                $where['column'] == $column;
        })->values()->all();
    }
}