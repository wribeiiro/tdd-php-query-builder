<?php

namespace Wribeiiro\QueryBuilder\Query;

use Wribeiiro\QueryBuilder\Contracts\QueryInterface;

class Delete implements QueryInterface
{
    private string $sql = "";

    /**
     *
     * @param string $table
     * @param array $conditions
     * @param string $opetator
     */
    public function __construct(
        string $table,
        array $conditions = [],
        string $opetator = " AND"
    ) {
        $this->sql = "DELETE FROM $table";

        $where = "";
        foreach ($conditions as $key => $c) {
            $where .= $where
                ? "{$opetator} {$key} = {$c}"
                : " WHERE {$key} = {$c}";
        }

        $this->sql .= "$where";
    }

     /** @inheritdoc */
    public function getSql(): string
    {
        return $this->sql;
    }
}
