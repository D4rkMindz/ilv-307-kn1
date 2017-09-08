<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Initial extends AbstractMigration
{
    public function change()
    {
        $this->execute("ALTER DATABASE CHARACTER SET 'utf8';");
        $this->execute("ALTER DATABASE COLLATE='utf8_unicode_ci';");
        $this->table("oauth_access_tokens")->save();
        $this->execute("ALTER TABLE `oauth_access_tokens` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `oauth_access_tokens` COMMENT='';");
        $this->execute("ALTER TABLE `oauth_access_tokens` CHARSET='utf8';");
        $this->execute("ALTER TABLE `oauth_access_tokens` COLLATE='utf8_unicode_ci';");
        $this->table('oauth_access_tokens')
            ->addColumn('access_token', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8"])
            ->addColumn('client_id', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'access_token'])
            ->addColumn('user_id', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'client_id'])
            ->addColumn('expires', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'after' => 'user_id'])
            ->addColumn('scope', 'string', ['null' => true, 'limit' => 4000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'expires'])
            ->update();
        $this->table("oauth_authorization_codes")->save();
        $this->execute("ALTER TABLE `oauth_authorization_codes` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `oauth_authorization_codes` COMMENT='';");
        $this->execute("ALTER TABLE `oauth_authorization_codes` CHARSET='utf8';");
        $this->execute("ALTER TABLE `oauth_authorization_codes` COLLATE='utf8_unicode_ci';");
        $this->table('oauth_authorization_codes')
            ->addColumn('authorization_code', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8"])
            ->addColumn('client_id', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'authorization_code'])
            ->addColumn('user_id', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'client_id'])
            ->addColumn('redirect_uri', 'string', ['null' => true, 'limit' => 2000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'user_id'])
            ->addColumn('expires', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'after' => 'redirect_uri'])
            ->addColumn('scope', 'string', ['null' => true, 'limit' => 4000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'expires'])
            ->addColumn('id_token', 'string', ['null' => true, 'limit' => 1000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'scope'])
            ->update();
        $this->table("oauth_clients")->save();
        $this->execute("ALTER TABLE `oauth_clients` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `oauth_clients` COMMENT='';");
        $this->execute("ALTER TABLE `oauth_clients` CHARSET='utf8';");
        $this->execute("ALTER TABLE `oauth_clients` COLLATE='utf8_unicode_ci';");
        $this->table('oauth_clients')
            ->addColumn('client_id', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8"])
            ->addColumn('client_secret', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'client_id'])
            ->addColumn('redirect_uri', 'string', ['null' => true, 'limit' => 2000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'client_secret'])
            ->addColumn('grant_types', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'redirect_uri'])
            ->addColumn('scope', 'string', ['null' => true, 'limit' => 4000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'grant_types'])
            ->addColumn('user_id', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'scope'])
            ->update();
        $this->table("oauth_jwt")->save();
        $this->execute("ALTER TABLE `oauth_jwt` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `oauth_jwt` COMMENT='';");
        $this->execute("ALTER TABLE `oauth_jwt` CHARSET='utf8';");
        $this->execute("ALTER TABLE `oauth_jwt` COLLATE='utf8_unicode_ci';");
        $this->table('oauth_jwt')
            ->addColumn('client_id', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8"])
            ->addColumn('subject', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'client_id'])
            ->addColumn('public_key', 'string', ['null' => false, 'limit' => 2000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'subject'])
            ->update();
        $this->table("oauth_refresh_tokens")->save();
        $this->execute("ALTER TABLE `oauth_refresh_tokens` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `oauth_refresh_tokens` COMMENT='';");
        $this->execute("ALTER TABLE `oauth_refresh_tokens` CHARSET='utf8';");
        $this->execute("ALTER TABLE `oauth_refresh_tokens` COLLATE='utf8_unicode_ci';");
        $this->table('oauth_refresh_tokens')
            ->addColumn('refresh_token', 'string', ['null' => false, 'limit' => 40, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8"])
            ->addColumn('client_id', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'refresh_token'])
            ->addColumn('user_id', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'client_id'])
            ->addColumn('expires', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'after' => 'user_id'])
            ->addColumn('scope', 'string', ['null' => true, 'limit' => 4000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'expires'])
            ->update();
        $this->table("oauth_scopes")->save();
        $this->execute("ALTER TABLE `oauth_scopes` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `oauth_scopes` COMMENT='';");
        $this->execute("ALTER TABLE `oauth_scopes` CHARSET='utf8';");
        $this->execute("ALTER TABLE `oauth_scopes` COLLATE='utf8_unicode_ci';");
        $this->table('oauth_scopes')
            ->addColumn('scope', 'string', ['null' => false, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8"])
            ->addColumn('is_default', 'boolean', ['null' => true, 'limit' => MysqlAdapter::INT_TINY, 'precision' => 3, 'after' => 'scope'])
            ->update();
        $this->table("oauth_users")->save();
        $this->execute("ALTER TABLE `oauth_users` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `oauth_users` COMMENT='';");
        $this->execute("ALTER TABLE `oauth_users` CHARSET='utf8';");
        $this->execute("ALTER TABLE `oauth_users` COLLATE='utf8_unicode_ci';");
        $this->table('oauth_users')
            ->addColumn('username', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8"])
            ->addColumn('password', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'username'])
            ->addColumn('first_name', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'password'])
            ->addColumn('last_name', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'first_name'])
            ->addColumn('email', 'string', ['null' => true, 'limit' => 80, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'last_name'])
            ->addColumn('email_verified', 'boolean', ['null' => true, 'limit' => MysqlAdapter::INT_TINY, 'precision' => 3, 'after' => 'email'])
            ->addColumn('scope', 'string', ['null' => true, 'limit' => 4000, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'email_verified'])
            ->update();
        $this->table("people")->save();
        $this->execute("ALTER TABLE `people` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `people` COMMENT='';");
        $this->execute("ALTER TABLE `people` CHARSET='utf8';");
        $this->execute("ALTER TABLE `people` COLLATE='utf8_unicode_ci';");
        if ($this->table('people')->hasColumn('id')) {
            $this->table("people")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10])->update();
        } else {
            $this->table("people")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10])->update();
        }
        $this->table('people')
            ->addColumn('first_name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])
            ->addColumn('last_name', 'string', ['null' => false, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'first_name'])
            ->addColumn('address', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_general_ci", 'encoding' => "utf8", 'after' => 'last_name'])
            ->addColumn('postalcode_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'address'])
            ->addColumn('created', 'datetime', ['null' => true, 'after' => 'postalcode_id'])
            ->addColumn('created_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'created'])
            ->addColumn('modified', 'datetime', ['null' => true, 'after' => 'created_by'])
            ->addColumn('modified_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'modified'])
            ->addColumn('deleted', 'datetime', ['null' => true, 'after' => 'modified_by'])
            ->addColumn('deleted_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'deleted'])
            ->update();
        if($this->table('people')->hasIndex('fk_person_cities1_idx')) {
            $this->table("people")->removeIndexByName('fk_person_cities1_idx');
        }
        $this->table("people")->addIndex(['postalcode_id'], ['name' => "fk_person_cities1_idx", 'unique' => false])->save();
        $this->table("postcodes")->save();
        $this->execute("ALTER TABLE `postcodes` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `postcodes` COMMENT='';");
        $this->execute("ALTER TABLE `postcodes` CHARSET='utf8';");
        $this->execute("ALTER TABLE `postcodes` COLLATE='utf8_unicode_ci';");
        if ($this->table('postcodes')->hasColumn('id')) {
            $this->table("postcodes")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("postcodes")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $this->table('postcodes')
            ->addColumn('country', 'string', ['null' => false, 'limit' => 2, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])
            ->addColumn('state', 'string', ['null' => false, 'limit' => 10, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'country'])
            ->addColumn('number', 'string', ['null' => false, 'limit' => 10, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'state'])
            ->addColumn('number2', 'string', ['null' => true, 'limit' => 10, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'number'])
            ->addColumn('title_de', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'number2'])
            ->addColumn('title_fr', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'title_de'])
            ->addColumn('title_it', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'title_fr'])
            ->addColumn('title_en', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'title_it'])
            ->addColumn('created', 'datetime', ['null' => true, 'after' => 'title_en'])
            ->addColumn('created_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'created'])
            ->addColumn('modified', 'datetime', ['null' => true, 'after' => 'created_by'])
            ->addColumn('modified_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'modified'])
            ->addColumn('deleted', 'integer', ['null' => true, 'default' => '0', 'limit' => MysqlAdapter::INT_TINY, 'precision' => 3, 'after' => 'modified_by'])
            ->addColumn('deleted_at', 'datetime', ['null' => false, 'after' => 'deleted'])
            ->addColumn('deleted_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'deleted_at'])
            ->update();
        $this->table("roles")->save();
        $this->execute("ALTER TABLE `roles` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `roles` COMMENT='';");
        $this->execute("ALTER TABLE `roles` CHARSET='utf8';");
        $this->execute("ALTER TABLE `roles` COLLATE='utf8_unicode_ci';");
        if ($this->table('roles')->hasColumn('id')) {
            $this->table("roles")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("roles")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $this->table('roles')
            ->addColumn('level', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'id'])
            ->addColumn('title', 'string', ['null' => false, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'level'])
            ->update();
        $this->table("tasks")->save();
        $this->execute("ALTER TABLE `tasks` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `tasks` COMMENT='';");
        $this->execute("ALTER TABLE `tasks` CHARSET='utf8';");
        $this->execute("ALTER TABLE `tasks` COLLATE='utf8_unicode_ci';");
        if ($this->table('tasks')->hasColumn('id')) {
            $this->table("tasks")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10])->update();
        } else {
            $this->table("tasks")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10])->update();
        }
        $this->table('tasks')
            ->addColumn('title', 'string', ['null' => true, 'limit' => 45, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])
            ->addColumn('description', 'text', ['null' => true, 'limit' => 65535, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'title'])
            ->addColumn('due_date', 'datetime', ['null' => true, 'after' => 'description'])
            ->addColumn('created', 'datetime', ['null' => true, 'after' => 'due_date'])
            ->addColumn('created_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'created'])
            ->addColumn('modified', 'datetime', ['null' => true, 'after' => 'created_by'])
            ->addColumn('modified_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'modified'])
            ->addColumn('deleted', 'datetime', ['null' => true, 'after' => 'modified_by'])
            ->addColumn('deleted_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'deleted'])
            ->addColumn('resolved', 'datetime', ['null' => true, 'after' => 'deleted_by'])
            ->addColumn('resolved_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'resolved'])
            ->update();
        $this->table("user_tasks")->save();
        $this->execute("ALTER TABLE `user_tasks` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `user_tasks` COMMENT='';");
        $this->execute("ALTER TABLE `user_tasks` CHARSET='utf8';");
        $this->execute("ALTER TABLE `user_tasks` COLLATE='utf8_unicode_ci';");
        if ($this->table('user_tasks')->hasColumn('id')) {
            $this->table("user_tasks")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        } else {
            $this->table("user_tasks")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'identity' => 'enable'])->update();
        }
        $this->table('user_tasks')
            ->addColumn('user_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'id'])
            ->addColumn('task_id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'user_id'])
            ->update();
        if($this->table('user_tasks')->hasIndex('fk_user_has_task_task1_idx')) {
            $this->table("user_tasks")->removeIndexByName('fk_user_has_task_task1_idx');
        }
        $this->table("user_tasks")->addIndex(['task_id'], ['name' => "fk_user_has_task_task1_idx", 'unique' => false])->save();
        if($this->table('user_tasks')->hasIndex('fk_user_has_task_user1_idx')) {
            $this->table("user_tasks")->removeIndexByName('fk_user_has_task_user1_idx');
        }
        $this->table("user_tasks")->addIndex(['user_id'], ['name' => "fk_user_has_task_user1_idx", 'unique' => false])->save();
        $this->table("users")->save();
        $this->execute("ALTER TABLE `users` ENGINE='InnoDB';");
        $this->execute("ALTER TABLE `users` COMMENT='';");
        $this->execute("ALTER TABLE `users` CHARSET='utf8';");
        $this->execute("ALTER TABLE `users` COLLATE='utf8_unicode_ci';");
        if ($this->table('users')->hasColumn('id')) {
            $this->table("users")->changeColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10])->update();
        } else {
            $this->table("users")->addColumn('id', 'integer', ['null' => false, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10])->update();
        }
        $this->table('users')
            ->addColumn('username', 'string', ['null' => true, 'limit' => 255, 'collation' => "utf8_unicode_ci", 'encoding' => "utf8", 'after' => 'id'])
            ->addColumn('created', 'datetime', ['null' => true, 'after' => 'username'])
            ->addColumn('created_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'created'])
            ->addColumn('modified', 'datetime', ['null' => true, 'after' => 'created_by'])
            ->addColumn('modified_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'modified'])
            ->addColumn('deleted', 'datetime', ['null' => true, 'after' => 'modified_by'])
            ->addColumn('deleted_by', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'deleted'])
            ->addColumn('person_id', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'deleted_by'])
            ->addColumn('role_id', 'integer', ['null' => true, 'limit' => MysqlAdapter::INT_REGULAR, 'precision' => 10, 'after' => 'person_id'])
            ->update();
        if($this->table('users')->hasIndex('fk_user_person_idx')) {
            $this->table("users")->removeIndexByName('fk_user_person_idx');
        }
        $this->table("users")->addIndex(['person_id'], ['name' => "fk_user_person_idx", 'unique' => false])->save();
        if($this->table('users')->hasIndex('fk_user_permissionlevel1_idx')) {
            $this->table("users")->removeIndexByName('fk_user_permissionlevel1_idx');
        }
        $this->table("users")->addIndex(['role_id'], ['name' => "fk_user_permissionlevel1_idx", 'unique' => false])->save();
    }
}
