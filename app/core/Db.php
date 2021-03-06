<?php
/**
 * Класс для работы с бд
 * Используется технология PDO
 */

namespace app\core;

use http\Exception;
use PDO;

class Db
{
    protected function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $config   = require '/../config/db.php';
        $db = new PDO(
            'mysql:host='.$config['host'].';dbname='.$config['db_name'],
            $config['username'],
            $config['password']
        );
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES utf8');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
    /**
     * @param $table - название таблицы
     * @param $fields - название поля
     * @param null $insertParams
     * @return null
     */
    public function insert($table, $fields, $insertParams = null)
    {
        try {
                $result = null;
                $names  = '';
                $vals   = '';
                foreach ($fields as $name => $val) {
                    if (isset($names[0])) {
                        $names .= ', ';
                        $vals .= ', ';
                    }
                    $names .= $name;
                    $vals .= ':' . $name;
                }
                $ignore = isset($insertParams['ignore']) && $insertParams['ignore']? 'IGNORE': '';
                $sql = "INSERT ".$ignore." INTO " . $table . ' (' . $names . ') VALUES (' . $vals . ')';
                $rs = $this->connect()->prepare($sql);
                foreach ($fields as $name => $val) {
                    $rs->bindValue(':' . $name, $val);
                }
                if ($rs->execute()) {
                    $result = $this->connect()->lastInsertId(null);
                }
                return $result;
        } catch(Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param $table
     * @param $fields
     * @param $where
     * @param null $params
     * @return mixed Returns true/false
     */
    public function update($table, $fields, $where, $params = null)
    {
        try {
            $sql = 'UPDATE ' . $table . ' SET ';
            $first = true;
            foreach (array_keys($fields) as $name) {
                if (!$first) {
                    $first = false;
                    $sql .= ', ';
                }
                $first = false;
                $sql .= $name . ' = :_' . $name;
            }
            if (!is_array($params)) {
                $params = array();
            }
            $sql .= ' WHERE ' . $where;
            $rs = $this->connect()->prepare($sql);
            foreach ($fields as $name => $val) {
                $params[':_' . $name] = $val;
            }
            $result = $rs->execute($params);
            return $result;
        } catch(Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param $table - название таблицы
     * @param $where
     * @param $param - id строки
     */
    public function delete($table, $where, $param)
    {
        $this->connect()->exec("DELETE FROM ".$table." WHERE ".$where."=".$param);
    }

    /**
     * @param $query
     * @param null $params
     * @return null
     */
    public function queryValue($query, $params = null)
    {
        try {
            $result = null;
            $stmt = $this->connect()->prepare($query);
            if ($stmt->execute($params)) {
                $result = $stmt->fetchColumn();
                $stmt->closeCursor();
            }
            return $result;
        } catch(Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param $query
     * @param null $params
     * @return array|null
     */
    public function queryValues($query, $params = null)
    {
        try {
            $result = null;
            $stmt = $this->connect()->prepare($query);
            if ($stmt->execute($params)) {
                $result = array();
                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                $result[] = $row[0];
                }
            }
            return $result;
        } catch(Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param $query
     * @param null $params
     * @param int $fetchStyle
     * @param null $classname
     * @return null
     */
    public function queryRow($query, $params = null, $fetchStyle = PDO::FETCH_ASSOC, $classname = null)
    {
        return $this->queryRowOrRows(true, $query, $params, $fetchStyle, $classname);
    }

    /**
     * @param $query
     * @param null $params
     * @param int $fetchStyle
     * @param null $classname
     * @return null
     */
    public function queryRows($query, $params = null, $fetchStyle = PDO::FETCH_ASSOC, $classname = null)
    {
        return $this->queryRowOrRows(false, $query, $params, $fetchStyle, $classname);
    }

    /**
     * @param $singleRow
     * @param $query
     * @param null $params
     * @param int $fetchStyle
     * @param null $classname
     * @return null
     */
    private function queryRowOrRows($singleRow, $query, $params = null, $fetchStyle = PDO::FETCH_ASSOC, $classname = null)
    {
        try {
            $result = null;
            $stmt = $this->connect()->prepare($query);
            if($classname) {
                $stmt->setFetchMode($fetchStyle, $classname);
            } else {
                $stmt->setFetchMode($fetchStyle);
            }
            if ($stmt->execute($params)) {
                $result = $singleRow? $stmt->fetch(): $stmt->fetchAll();
                $stmt->closeCursor();
            }
            return $result;
        } catch(Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param $str
     * @return mixed
     */
    public function quote($str)
    {
        return $this->connect()->quote($str);
    }

    /**
     * @param $arr
     * @return array
     */
    public function quoteArray($arr)
{
    $result = array();
    foreach ($arr as $val) {
    $result[] = $this->connect()->quote($val);
    }
    return $result;
}

    /**
     * @param $arr
     * @return string
     */
    public function quoteImplodeArray($arr)
    {
        return implode(',', $this->quoteArray($arr));
    }

    // returns true/false
    /**
     * @param $query
     * @param null $params
     * @return mixed
     */
    public function sql($query, $params = null)
    {
        try {
            $result = null;
            $stmt = $this->connect()->prepare($query);
            return $stmt->execute($params);
        } catch(Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param $e
     */
    private function report($e)
    {
        throw $e;
    }

}