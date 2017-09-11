<?php

namespace App\Table;

/**
 * Class OAuthAccessTokenTable
 *
 * @package App\Table
 */
class OAuthAccessTokenTable extends AppTable
{
    protected $table = 'oauth_access_tokens';

    /**
     * Get client_id by access_token.
     *
     * @param string $accessToken - with access token.
     * @return array $row - with client id
     */
    public function getUserByAccessToken(string $accessToken): array
    {
        $fields = ['id' => 'u.id', 'level' => 'r.level', 'role_id'=> 'r.id'];
        $query = $this->newSelect();
        $query->select($fields)
            ->join([
                'u' => [
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'u.id = ' . $this->table . '.user_id',
                ],
                'r' => [
                    'table' => 'roles',
                    'type' => 'INNER',
                    'conditions' => 'r.id = u.role_id',
                ],
            ])
            ->where([$this->table . '.access_token' => $accessToken]);
        $row = $query->execute()->fetch('assoc');
        if (!empty($row)) {
            return $row;
        }

        return [];
    }
}
