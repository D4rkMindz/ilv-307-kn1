<?php

namespace App\Table;

class PeopleTable extends AppTable
{
    protected $table = 'people';

    public function existsId(int $id)
    {
        $query = $this->newSelect();
        $query->select(['id', 'deleted'])->where(['id' => $id, 'deleted' => false]);
        $row = $query->execute()->fetch();

        return !empty($row);
    }
}
