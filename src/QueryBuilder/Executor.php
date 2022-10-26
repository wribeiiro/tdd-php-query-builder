<?php

namespace Wribeiiro\QueryBuilder;

use Wribeiiro\QueryBuilder\Contracts\QueryInterface;

class Executor
{
    /**
     * @var \PDO
     */
    private \PDO $connection;

    /**
     *
     * @var QueryInterface|null
     */
    private ?QueryInterface $query;

    /**
     * @var array
     */
    private array $params = [];

    private mixed $result;

    public function __construct(
        \PDO $connection,
        QueryInterface $query = null
    ) {
        $this->connection = $connection;
        $this->query = $query;
    }

    /**
     * Set query
     *
     * @param [type] $queryBuilder
     * @return void
     */
    public function setQuery(QueryInterface $queryBuilder)
    {
        $this->query = $queryBuilder;
    }

    /**
     * Set a param
     *
     * @param string $bind
     * @param mixed $value
     * @return self
     */
    public function setParam(string $bind, mixed $value)
    {
        $this->params[] = [
            'bind' => $bind,
            'value' => $value
        ];

        return $this;
    }

    /**
     * Return all params
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Execute the query
     *
     * @return mixed
     */
    public function execute()
    {
        $proccess = $this->connection->prepare($this->query->getSql());

		if(count($this->params) > 0) {
			foreach($this->params as $param) {

				$type = gettype($param['value']) == 'integer' ? \PDO::PARAM_INT : \PDO::PARAM_STR;

				$proccess->bindValue($param['bind'], $param['value'], $type);
			}
		}

        $returnProccess = $proccess->execute();

		$this->result   = $proccess;

		return $returnProccess;
    }

    public function getResult()
    {
        if (!$this->result) {
            return null;
        }

        return $this->result->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *
     * @return string
     */
    public function getSql(): string
    {
        return $this->query->getSql();
    }
}
