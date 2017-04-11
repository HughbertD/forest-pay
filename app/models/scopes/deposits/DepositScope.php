<?php

use \Illuminate\Database\Eloquent\Builder;

/**
 * Global scope to DEPOSIT transactions only
 * Class DepositScope
 */
class DepositScope implements \Illuminate\Database\Eloquent\ScopeInterface
{
    private $scopeToColumn = 'event';

    /**
     * Apply global scope to query
     * @param Builder $builder
     */
    public function apply(Builder $builder)
    {
        $builder->where('event', \Deposit::$event);
    }

    /**
     * Remove the global scope from a query
     * @param Builder $builder
     */
    public function remove(Builder $builder)
    {
        $query = $builder->getQuery();
        foreach ((array) $query->wheres as $key => $where) {
            if (!$this->isDepositScoped($where['column'], $where['value'])) {
                continue;
            }
            unset($query->wheres[$key]);
            $query->wheres = array_values($query->wheres);
        }
    }

    /**
     * Does this match our scope?
     * @param $column
     * @param $value
     * @return bool
     */
    private function isDepositScoped($column, $value)
    {
        return ($column == $this->scopeToColumn && $value == \Deposit::$event);
    }

}