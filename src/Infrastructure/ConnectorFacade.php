<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure;

use Redis;
use RedisException;
use Psr\Log\LoggerInterface;

class ConnectorFacade
{
    public string $host;
    public int $port = 6379;
    public ?string $password = null;
    public ?int $dbindex = null;

    public $connector;
    private LoggerInterface $logger; // Подключение логгера

    public function __construct($host, $port, $password, $dbindex, LoggerInterface $logger)
    {
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->dbindex = $dbindex;
        $this->logger = $logger; //  Подключение логгера
    }

    protected function build(): void
    {
        $redis = new Redis();

        try {
            $isConnected = $redis->isConnected();
            if (! $isConnected && $redis->ping('Pong')) {
                $isConnected = $redis->connect(
                    $this->host,
                    $this->port,
                );
            }
        } catch (RedisException $e) {
            $this->logger->error('Redis connection failed: ' . $e->getMessage()); // Логируем ошибкуподключения
        }

        if ($isConnected) {
            try {
                $redis->auth($this->password);
                $redis->select($this->dbindex);
                $this->connector = new Connector($redis);
            } catch (RedisException $e) {
                $this->logger->error('Redis connection failed: ' . $e->getMessage()); // Логируем ошибкуподключения
            }
        } else {
            $this->logger->error('Redis not connected.');
        }
    }
}
