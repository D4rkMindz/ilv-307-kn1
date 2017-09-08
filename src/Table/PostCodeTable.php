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
        $query->select('number')->where(['number'=> $postCode]);
        $row = $query->execute()->fetch();
        return !empty($row);
    }
}
