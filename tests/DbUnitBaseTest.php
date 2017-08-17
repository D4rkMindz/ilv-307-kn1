<?php

namespace App\Test;

use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;
use PDO;
use Phinx\Console\PhinxApplication;
use Phinx\Wrapper\TextWrapper;
use PHPUnit\DbUnit\Database\DefaultConnection;
use PHPUnit\DbUnit\Operation\Factory;
use PHPUnit\DbUnit\TestCaseTrait;
use Exception;

abstract class DbUnitBaseTest extends BaseTest
{
    use TestCaseTrait;

    /**
     * @var PDO
     */
    private static $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;

    /**
     * Get Connection.
     *
     * @return DefaultConnection
     */
    public function getConnection(): DefaultConnection
    {
        if ($this->conn === null) {
            $this->conn = $this->createDefaultDBConnection(static::getPdo());
        }

        return $this->conn;
    }

    /**
     * Get PHP Data Object.
     *
     * @return PDO
     */
    protected static function getPdo(): PDO
    {
        if (!self::$pdo) {
            container()->set('db', null);
            $config = config();
            $config->set('db', $config->get('db_test'));
            self::$pdo = db()->getDriver()->connection();
        }

        return self::$pdo;
    }

    /**
     * Setup before Class.
     *
     * This code will be executed before every class. This makes sure, that the test-database is always in the same
     * "test-state".
     */
    public static function setUpBeforeClass()
    {
        static::getPdo();
    }

    /**
     * Setup.
     *
     * This code will be executed once before the tests are executed.
     */
    protected function setUp()
    {
        static $setup = false;
        if (!$setup) {
            $this->setupCakeConnection();
            $this->setupSession();
            $this->setupDatabase();
            $setup = true;
        }
        $this->truncateTables();
        Factory::INSERT()->execute($this->getConnection(), $this->getDataSet());
    }

    /**
     * Truncate all Tables.
     */
    protected function truncateTables()
    {
        $pdo = static::getPdo();
        $stmt = $pdo->query('SHOW TABLES');
        while ($row = $stmt->fetch()) {
            $table = array_values($row)[0];
            $pdo->prepare(sprintf('TRUNCATE TABLE `%s`', $table))->execute();
        }
    }

    /**
     * Setup Database.
     *
     * @throws Exception
     */
    public function setupDatabase()
    {
        $pdo = static::getPdo();
        $stmt = $pdo->query('SHOW TABLES');
        while ($row = $stmt->fetch()) {
            $table = array_values($row)[0];
            $pdo->prepare(sprintf('DROP TABLE `%s`', $table))->execute();
        }
        chdir(__DIR__ . '/../config');
        $wrap = new TextWrapper(new PhinxApplication());
        // Execute the command and determine if it was successful.
        $env = 'local';
        $target = null;
        call_user_func([$wrap, 'getMigrate'], $env, $target);
        $error = $wrap->getExitCode() > 0;
        if ($error) {
            throw new Exception('Error: Setup database failed with exit code: %s', $wrap->getExitCode());
        }
    }

    /**
     * Setup Cake Connection.
     *
     * This method is used to setup a valid connection for CakePHP Querybuilder.
     */
    public function setupCakeConnection()
    {
        $config = config()->get("db_test");
        $driver = new Mysql([
            'host' => $config['host'],
            'port' => $config['port'],
            'database' => $config['database'],
            'username' => $config['username'],
            'password' => $config['password'],
            'encoding' => $config['encoding'],
            'charset' => $config['charset'],
            'collation' => $config['collation'],
            'prefix' => '',
            'flags' => [
                // Enable exceptions
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Set default fetch mode
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ],
        ]);
        $db = new Connection([
            'driver' => $driver,
        ]);
        container()->set('db', $db);
    }

    /**
     * Generate Update row.
     *
     * @param array $row
     * @return array
     */
    public function generateUpdateRow(array $row): array
    {
        foreach ($row as $key => $value) {
            if (preg_match('/\w*(id)\w*/', $key)) {
                continue;
            }
            $converted = preg_replace('/[ÄÖÜäöüÉÈÀéèà]/', "", $row[$key]);
            $parts = str_split(html_entity_decode($converted));
            sort($parts);
            $row[$key] = implode($parts);
        }

        return $row;
    }
}
