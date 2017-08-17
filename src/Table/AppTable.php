<?php

namespace App\Table;

use Cake\Database\Connection;
use Cake\Database\Query;
use Cake\Database\StatementInterface;

/**
 * Class AppTable
 */
class AppTable
{
    protected $table = null;

    protected $db;

    /**
     * AppTable constructor.
     *
     * @param Connection $db
     */
    public function __construct(Connection $db = null)
    {
        if ($db === null) {
            $db = db();
        }
        $this->db = $db;
    }

    /**
     * Get Query.
     *
     * @return Query
     */
    public function newSelect(): Query
    {
        return $this->db->newQuery()->from($this->table);
    }

    /**
     * Get all entries from database.
     *
     * @return array $rows
     */
    public function getAll(): array
    {
        $query = $this->newSelect();
        $query->select('*');
        $rows = $query->execute()->fetchAll('assoc');

        return $rows;
    }

    /**
     * Insert into database.
     *
     * @param array $row with data to insertUser into database
     * @return StatementInterface
     */
    public function insert(array $row): StatementInterface
    {
        return $this->db->insert($this->table, $row);
    }

    /**
     * Update database
     *
     * @param string $where should be the id
     * @param array $row
     * @return StatementInterface
     */
    public function update(array $row, string $where): StatementInterface
    {
        $query = $this->db->newQuery();
        $query->update($this->table)
            ->set($row)
            ->where(['id' => $where]);

        return $query->execute();
    }

    /**
     * Delete from database.
     *
     * @param string $id
     * @return StatementInterface
     */
    public function delete(string $id): StatementInterface
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
