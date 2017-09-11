<?php

namespace App\Table;

/**
 * Class PostCodeTable
 */
class PostCodeTable extends AppTable
{
    protected $table = 'postcodes';

    /**
     * Check if postcode exists.
     *
     * @param int $postCode
     * @return bool
     */
    public function existsPostCode(int $postCode): bool
    {
        $query = $this->newSelect();
        $query->select('number')->where(['number' => $postCode, 'deleted'=> false]);
        $row = $query->execute()->fetch();

        return !empty($row);
    }

    /**
     * Get ID by postcode
     *
     * @param int $postCode
     * @return int
     */
    public function getIdByPostCode(int $postCode): int
    {
        $query = $this->newSelect();
        $query->select('id')->where(['number' => $postCode, 'deleted'=> false]);
        $row = $query->execute()->fetch();

        return !empty($row) ? $row[0] : 0;
    }
}
