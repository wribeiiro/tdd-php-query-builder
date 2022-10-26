<?php

namespace Wribeiiro\QueryBuilder\Query;

use Wribeiiro\QueryBuilder\Contracts\QueryInterface;

class Select implements QueryInterface
{
	private string $query = "";
	private string $where = "";
	private string $orderBy = "";
	private string $limit = "";
	private string $join = "";

	public function __construct($table)
	{
		$this->query = 'SELECT * FROM ' . $table;
	}

    /**
     * Undocumented function
     *
     * @param string $field
     * @param string $operator
     * @param ?string $bind
     * @param string $concat
     * @return self
     */
	public function where(
        string $field,
        string $operator,
        ?string $bind = null,
        string $concat = 'AND'
    ): self {
		$bind = is_null($bind) ? ':' . $field : $bind;

		if(!$this->where) {
			$this->where .= ' WHERE ' . $field . ' ' . $operator . ' ' . $bind;
		} else {
			$this->where .= ' ' . $concat . ' ' . $field . ' ' . $operator . ' ' . $bind;
		}

		return $this;
	}

    /**
     * Undocumented function
     *
     * @param string $field
     * @param string $order
     * @return self
     */
	public function orderBy(string $field, string $order): self
	{
		$this->orderBy = ' ORDER BY ' . $field . ' ' . $order;

		return $this;
	}

    /**
     * Undocumented function
     *
     * @param string $kip
     * @param string $take
     * @return self
     */
	public function limit(string $kip, string $take): self
	{
		$this->limit = ' LIMIT ' . $kip . ', ' . $take;

		return $this;
	}

    /**
     * Undocumented function
     *
     * @param string $joinType
     * @param string $table
     * @param string $foreignKey
     * @param string $operator
     * @param string $referenceColumn
     * @param string|bool $concat
     * @return self
     */
	public function join(
        string $joinType,
        string $table,
        string $foreignKey,
        string $operator,
        string $referenceColumn,
        string|bool $concat = false
    ): self {
		if (!$concat) {
			$this->join .= ' ' . $joinType . ' ' . $table . ' ON ' . $foreignKey . ' ' . $operator . ' ' . $referenceColumn;
		} else {
			$this->join .= ' ' . $concat . ' ' . $foreignKey . ' ' . $operator . ' ' . $referenceColumn;
		}

		return $this;
	}

    /**
     * Undocumented function
     *
     * @param [wtftype] ...$fields
     * @return self
     */
	public function select(...$fields): self
	{
		$fields = implode(', ', $fields);

		$this->query = str_replace('*', $fields, $this->query);

		return $this;
	}

    /** @inheritDoc */
	public function getSql(): string
	{
		return $this->query . $this->join . $this->where . $this->orderBy . $this->limit;
	}
}