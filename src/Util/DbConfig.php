<?php
declare(strict_types=1);

namespace Example\Util;

use PDO;

final class DbConfig
{
    /** @var string */
    private $host;

    /** @var int */
    private $port;

    /** @var string */
    private $dbName;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    public function __construct()
    {
        $this->host = getenv('DB_HOST');
        $this->port = getenv('DB_PORT');
        $this->dbName = getenv('DB_NAME');
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
    }

    public function createPdo(): PDO
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s', $this->host, $this->dbName);
        return new PDO($dsn, $this->username, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
}