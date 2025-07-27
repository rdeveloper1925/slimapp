<?php
namespace App\Repositories;

use App\Interfaces\DatabaseInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DB implements DatabaseInterface{
    private array $config;
    private array $lastError = [];
    public Connection $conn;

    public function __construct(){
        $this->config = [
            'host' => $_ENV['DB_HOST'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
            'driver'   => 'pdo_mysql',
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8mb4'
        ];
        $this->connect();
    }

    public function connect(): void{
        try{
            $this->conn = DriverManager::getConnection($this->config);
        }catch(\Exception $e){
            $this->lastError = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ];
        }
        
    }

    public function isConnected(): bool
    {
        return $this->fetchOne("SELECT 1;", []);
    }

    public function setDbName(string $dbName)
    {
        try{
            $this->conn->executeStatement("USE `$dbName`;");
        }catch(\Exception $e){
            $this->lastError = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ];
        }
    }

    public function getConnection(): Connection
    {
        return $this->conn;
    }

    public function getLastError(): array
    {
        return $this->lastError;
    }

    public function fetchOne(string $sql, array $params = []): mixed
    {
        return $this->conn->fetchOne($sql, $params);
    }

    public function fetchAssoc(string $sql, array $params = []): array
    {
        return $this->conn->fetchAssociative($sql, $params);
    }

    public function execute(string $sql, array $params = []): int
    {
        return $this->conn->executeStatement($sql, $params);
    }
}