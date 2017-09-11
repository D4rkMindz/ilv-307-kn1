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
     * @return int last inserted ID
     */
    public function insert(array $row): int
    {
        return (int) $this->db->insert($this->table, $row)->lastInsertId();
    }

    /**
     * Update database
     *
     * @param string $whereValue - value to match with the where attribute
     * @param string $whereAttribute - attribute to check
     * @param array $row
     * @return StatementInterface
     */
    public function update(array $row, string $whereValue, string $whereAttribute = 'id'): StatementInterface
    {
        $query = $this->db->newQuery();
        $query->update($this->table)
            ->set($row)
            ->where([$whereAttribute => $whereValue]);

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
