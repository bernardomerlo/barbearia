<?php

class MongoDb
{
    private MongoDB\Client $client;
    private MongoDB\Database $db;
    private static ?MongoDb $instance = null;

    private function __construct()
    {
        try {
            // Conectar ao MongoDB
            $this->client = new MongoDB\Client("mongodb://localhost:27017");
            $this->db = $this->client->barbearia; // Nome do banco de dados
        } catch (\Exception $e) {
            throw new \Exception("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): MongoDb
    {
        if (self::$instance === null) {
            self::$instance = new MongoDb();
        }
        return self::$instance;
    }

    public function getConnection(): MongoDB\Database
    {
        return $this->db;
    }

    // Inserir um documento
    public function insert(string $collection, array $document): string
    {
        $result = $this->db->{$collection}->insertOne($document);
        return $result->getInsertedId();
    }

    // Selecionar documentos
    public function select(string $collection, array $filter = [], array $options = []): array
    {
        $result = $this->db->{$collection}->find($filter, $options);
        return iterator_to_array($result);
    }

    // Selecionar um único documento
    public function selectOne(string $collection, array $filter = []): ?array
    {
        return $this->db->{$collection}->findOne($filter);
    }

    // Atualizar documentos
    public function update(string $collection, array $filter, array $update): int
    {
        $result = $this->db->{$collection}->updateMany($filter, ['$set' => $update]);
        return $result->getModifiedCount();
    }

    // Deletar documentos
    public function delete(string $collection, array $filter): int
    {
        $result = $this->db->{$collection}->deleteMany($filter);
        return $result->getDeletedCount();
    }

    // Verificar se um documento existe
    public function exists(string $collection, array $filter): bool
    {
        return (bool) $this->db->{$collection}->countDocuments($filter);
    }

    // Contar documentos
    public function count(string $collection, array $filter = []): int
    {
        return $this->db->{$collection}->countDocuments($filter);
    }
}
