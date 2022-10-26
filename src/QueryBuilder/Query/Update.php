<?php

namespace Wribeiiro\QueryBuilder\Query;

use Wribeiiro\QueryBuilder\Contracts\QueryInterface;

class Update implements QueryInterface
{
    private string $sql = "";

    /**
     *
     * @param string $table
     * @param array $fields
     * @param array $conditions
     * @param string $opetator
     */
    public function __construct(
        string $table,
        array $fields = [],
        array $conditions = [],
        string $opetator = ' AND'
    ) {
        $this->sql = "UPDATE $table SET ";

        $setClausule = "";
        foreach ($fields as $field) {
            $setClausule .= $setClausule
                ? ", $field = :$field"
                : "$field = :$field";
        }

        $where = "";
        foreach ($conditions as $key => $condition) {
            $where .= $where
                ? "$opetator $key = $condition"
                : "WHERE $key = $condition";
        }

        $this->sql .= "$setClausule $where";
    }

    /** @inheritDoc */
    public function getSql(): string
    {
        return $this->sql;
    }
}
