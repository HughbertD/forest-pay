<?php

use \Illuminate\Database\Eloquent\Builder;

/**
 * Global scope to Deposit / Withdrawal transactions only
 * Class TransactionScope
 */
class TransactionScope implements \Illuminate\Database\Eloquent\ScopeInterface
{
    /**
     * @var string - column on transaction table that is scoped
     */
    private $scopeToColumn = 'event';

    /**
     * @var string - scope itself to narrow the search to on the column
     */
    private $columnScope;

    public function __construct($eventScope)
    {
        $this->columnScope = $eventScope;
    }

    /**
     * Apply global scope to query
     * @param Builder $builder
     */
    public function apply(Builder $builder)
    {
        $builder->where('event', $this->columnScope);
    }

    /**
     * Remove the global scope from a query
     * @param Builder $builder
     */
    public function remove(Builder $builder)
    {
        $query = $builder->getQuery();
        foreach ((array) $query->wheres as $key => $where) {
            if (!$this->isScoped($where['column'], $where['value'])) {
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
    private function isScoped($column, $value)
    {
        return ($column == $this->scopeToColumn && $value == $this->columnScope);
    }

}