<?php

class Database
{
    private static ?Database $instance = null;
    private ?PDO $pdo = null;
    private bool $connected = false;
    private string $error = '';

    private function __construct()
    {
        try {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                DB_HOST, DB_PORT, DB_NAME
            );
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
            $this->connected = true;
        } catch (PDOException $e) {
            $this->connected = false;
            $this->error = $e->getMessage();
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): ?PDO
    {
        return $this->pdo;
    }

    public function isConnected(): bool
    {
        return $this->connected;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
