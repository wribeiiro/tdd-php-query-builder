<?php

namespace Wribeiiro\QueryBuilder\Contracts;

interface QueryInterface
{
    /**
     * Return the string of SQL
     *
     * @return string
     */
    public function getSql(): string;
}
