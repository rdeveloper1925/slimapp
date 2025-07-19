<?php

namespace App\Repositories;

use App\Interfaces\DatabaseInterface;
use PDO;
use PDOException;

class Database implements DatabaseInterface
{
    private string $host;
    private string $dbName;
    private string $user;
    private string $pass;
    private int $port;
    private ?PDO $pdo = null;
    private array $lastError = [];

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->port = $_ENV['DB_PORT'];
        $this->connect();
    }

    public function setDbName(string $dbName): Database{
        $this->dbName = $dbName;
        return $this;
    }

    public function connect(): void
    {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            $this->lastError = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ];
            $this->pdo = null;
        }
        
    }

    public function isConnected(): bool
    {
        return $this->pdo instanceof PDO && empty($this->lastError);
    }

    public function getConnection(): ?PDO
    {
        return $this->pdo;
    }

    public function getConnectionString(): string
    {
        return "mysql:host={$this->host};dbname={$this->dbName};user={$this->user}";
    }

    public function getLastError(): array
    {
        return $this->lastError;
    }

    // Optional: helper to safely run a query
    public function run(string $sql, array $params = []): mixed
    {
        if (!$this->isConnected()) {
            return false;
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            $this->lastError = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'sql' => $sql,
                'params' => $params,
                'trace' => $e->getTraceAsString(),
            ];
            return false;
        }
    }
}
