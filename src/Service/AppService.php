<?php

namespace App\Service;

use App\Table\OAuthAccessTokenTable;

/**
 * Class AppService
 */
class AppService
{
    /**
     * Check if user has permission.
     *
     * @param string $accessToken
     * @param int $action
     * @return bool true if user has permission
     */
    protected function hasPermission(string $accessToken, int $action): bool
    {
        $user = $this->getUser($accessToken);

        // TODO: adjust user access level
        if ($user['level'] >= $action) {
            return false;
        }

        if ($user['level'] > 32) {
            return false;
        }

        return true;
    }

    /**
     * Get user by access token.
     *
     * @param string $accessToken
     * @return array with user data
     */
    protected function getUser(string $accessToken): array
    {
        $oAuthAccessTokenTable = new OAuthAccessTokenTable();
        return $oAuthAccessTokenTable->getUserByAccessToken($accessToken);
    }
}
