<?php

class Database extends PDO
{
    private static $instance;

    public function __construct()
    {
        try {
            parent::__construct(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $this->exec("SET NAMES 'utf8'");
            $this->exec('SET character_set_connection=utf8');
            $this->exec('SET character_set_client=utf8');
            $this->exec('SET character_set_results=utf8');

            date_default_timezone_set('America/Sao_Paulo');
        } catch (\PDOException $e) {
            echo DB_TYPE . DB_HOST;
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance) && is_null(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        $sth = $this->prepare($sql);
        if (count($array) > 0) {
            foreach ($array as $key => $value) {
                if (!is_array($value)) {
                    $sth->bindValue("$key", $value);
                }
            }
        }
        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }

    public function insert($table, $data, $return_id = true)
    {
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO `$table` (`$fieldNames`) VALUES ($fieldValues)");

        $out = "";
        foreach ($data as $key => $value) {
            $out .= ", " . $value;
            $sth->bindValue(":$key", $value);
        }
        $sth->execute();
        $ret = true;
        if ($return_id) {
            $row = $this->select("select LAST_INSERT_ID() as uid");
            $ret = $row[0]['uid'];
        }
        return $ret;
    }

    public function update($table, $data, $where)
    {
        ksort($data);
        $fieldDetails = NULL;
        foreach ($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        $sth = $this->prepare("UPDATE `$table` SET $fieldDetails WHERE $where");
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        $result = $sth->execute();
        return $result;
    }

    public function delete($table, $where, $limit = 1)
    {
        return $this->exec("DELETE FROM `$table` WHERE $where LIMIT $limit");
    }
}
