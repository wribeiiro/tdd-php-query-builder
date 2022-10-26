<?php

namespace Wribeiiro\QueryBuilder\Query;

use Wribeiiro\QueryBuilder\Contracts\QueryInterface;

class Insert implements QueryInterface
{
    private string $sql = "";

    /**
     *
     * @param string $table
     * @param array $fields
     */
    public function __construct(
        string $table,
        array $fields
    ) {
        $this->sql = "INSERT INTO $table";

        if (count($fields) > 0) {
            $this->sql .= "(" . implode(", ", $fields) . ")";
        }

        $this->sql .= " VALUES(:" . implode(", :", $fields) . ")";
    }

     /** @inheritdoc */
    public function getSql(): string
    {
        return $this->sql;
    }
}
