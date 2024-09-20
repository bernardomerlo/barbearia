<?php

class Database
{
    private PDO $conn;

    // metodo construtor faz a conexao com o banco de dados passado por parametro
    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=sql102.infinityfree.com;dbname=if0_37338099_barbearia", "if0_37338099", "bJMISSC1S7PrcqJ", [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Exception("Query failed: " . $e->getMessage());
        }
    }

    // faz a query juntamente com os parametros passados 
    private function query(string $query, array $params): \PDOStatement
    {
        try {
            $statement = $this->conn->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (\PDOException $e) {
            throw new \Exception("Query failed: " . $e->getMessage());
        }
    }

    // seleciona e retorna um array associativo

    public function select(string $query, array $params = [], bool $isAssoc = false): array
    {
        $result_query = $this->query($query, $params);
        if ($isAssoc) {
            $result_array = $result_query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result_array = $result_query->fetchAll(PDO::FETCH_OBJ);
        }
        return $result_array;
    }

    // seleciona e retorna somnente um objeto
    public function selectOne(string $query, array $params = []): object|false
    {
        $result_query = $this->query($query, $params);
        $result_object = $result_query->fetch(PDO::FETCH_OBJ);
        return $result_object;
    }

    // atualiza e retorna o numero de linhas afetadas
    public function update(string $query, array $params = []): int
    {
        $result_query = $this->query($query, $params);
        return $result_query->rowCount();
    }

    // insere e retorna o id inserido
    public function insert(string $query, array $params = []): int
    {
        $this->query($query, $params);
        return (int) $this->conn->lastInsertId();
    }

    // deleta e retorna o numero de linhas afetdas
    public function delete(string $query, array $params): int
    {
        $result_query = $this->query($query, $params);
        return $result_query->rowCount();
    }

    // inicia uma nova transacao
    public function beginTransaction(): void
    {
        $this->conn->beginTransaction();
    }

    // termina a transacao 
    public function endTransaction(): void
    {
        $this->conn->commit();
    }

    // volta a transacao desfazendo tudo
    public function rollback(): void
    {
        $this->conn->rollback();
    }

    // faz a query e retorna a quantidade de linhas afetadas
    public function count(string $query, array $params): int
    {
        $result_query = $this->select($query, $params);
        return count($result_query);
    }

    // faz a query e retorna true se ela existir e false se nao
    public function exists(string $query, array $params): bool
    {
        return !!$this->selectOne($query, $params);
    }

    //
    public function bulkInsert(string $query, array $params): int
    {
        // cria a strign com as '?' e adiciona na query
        $values_placeholders = "(" . implode(',', array_fill(0, count($params[0]), '?')) . ")";
        $string_values = implode(',', array_fill(0, count($params), $values_placeholders));
        $query .= $string_values;
        // transforma o array "params" para um array flat
        $flatten_params = array_merge(...array_map(function ($array) {
            return array_values($array);
        }, $params));
        //chama a funcao query que executa a mesma
        return $this->query($query, $flatten_params)->rowCount();
    }

    public function getPrimaryKey($table_name)
    {
        $primary = self::select("SHOW KEYS FROM $table_name WHERE Key_name = 'PRIMARY'");
        return $primary[0]->Column_name;
    }

    public function insertBulkQuery($data, $table_name)
    {

        $pk = self::getPrimaryKey($table_name);

        foreach ($data as $key => $value) {
            if ($key != $pk) {
                if (!empty($value)) {
                    $set[] = $key;
                    $values[$key] = $value;
                }
            }
        }

        $set_names = implode(", ", $set);

        $sql = "INSERT INTO $table_name ($set_names) VALUES (:" . implode(",:", $set) . ")";

        return [$sql, $values];
    }

    public function updateBulkQuery(array $data, string $table_name): array
    {

        $pk = self::getPrimaryKey($table_name);

        foreach ($data as $key => $value) {

            if ($key != $pk) {
                if (!empty($value)) {
                    $set[] = $key . " = :" . $key . "";
                    $values[$key] = $value;
                }
            }
        }
        $values[$pk] = $data[$pk];

        $set = implode(", ", $set);
        $sql = "UPDATE $table_name SET $set WHERE $pk = :$pk";
        return [$sql, $values];
    }


    public function multiInsertBulkQuery($datas, $table_name)
    {

        $pk = self::getPrimaryKey($table_name);

        foreach ($datas as $i_key => $data) {
            foreach ($data as $key => $value) {
                if ($key != $pk) {
                    if (!empty($value)) {
                        if ($i_key == 0) {
                            $set_names[] = $key;
                        }
                        $set[] = $key . $i_key;
                        $values[$key . $i_key] = $value;
                    }
                }
            }
            $value_txt[$i_key] = "(" . implode(", ", $set) . ")";
            unset($set);
        }
        $sql = "INSERT INTO $table_name (" . implode(", ", $set_names) . ") VALUES " . implode(", ", $value_txt);
        return [$sql, $values];
    }

    public function QueryResContemParametros($query_res, $params)
    {
        foreach ($params as $key => $value) {
            // Se nao tiver a key do parametro no resultado ou o valor for diferente
            if (!isset($query_res->$key) || $query_res->$key != $value) {
                return false;
            }
        }
        return true;
    }
}
