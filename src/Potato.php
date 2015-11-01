<?php

/**
 * @package A simple ORM that performs basic CRUD operations
 * @author Surajudeen AKANDE <surajudeen.akande@andela.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 * @link http://www.github.com/andela-sakande
 *
 */

namespace Sirolad;

use PDO;
use PDOException;
use Sirolad\DB\DBConnect;
use Sirolad\Libraries\Formatter;
use Sirolad\Libraries\TableMapper;
use Sirolad\Interfaces\PotatoInterface;
use Sirolad\Exceptions\EmptyTableException;
use Sirolad\Exceptions\RecordNotFoundException;
use Sirolad\Exceptions\TableDoesNotExistException;

abstract class Potato
{
    protected $record = [];

    public function __set($field, $value) {
        $this->record[$field] = $value;
    }

    public function tableName() {
        return TableMapper::getTableName(get_called_class());
    }

    public function getRecord() {
        return $this->record;
    }

    protected function makeDbConn() {
        $getConn = new DBConnect();
        return $getConn->getConnection();
    }

    public function find($record) {
        return self::where('id', $record);
    }

    public function where($field, $value) {
        try {
            $dbConn = self::makeDbConn();
            $sql = 'SELECT * FROM ' . self::tableName() . ' WHERE ' . $field . ' = ?';
            $query = $dbConn->prepare($sql);
            $query->execute([$value]);
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        finally {
            $dbConn = null;
        }

        if ($query->rowCount()) {
            $found = new static;
            $found->dbData = $query->fetch(PDO::FETCH_ASSOC);

            return $found;
        }
        else {
            throw new RecordNotFoundException;
        }
    }

    public function getAll() {
        try {
            $dbConn = self::makeDbConn();
            $query = $dbConn->prepare('SELECT * FROM ' . self::tableName());
            $query->execute();
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        finally {
            $dbConn = null;
        }

        if ($query->rowCount()) {
            return json_encode($query->fetchAll(PDO::FETCH_ASSOC), JSON_FORCE_OBJECT);
        }
        else {
            throw new EmptyTableException;
        }
    }

    public function save() {
        try {
            $dbConn = self::makeDbConn();

            if (isset($this->record['dbData']) && is_array($this->record['dbData'])) {
                $sql = 'UPDATE ' . $this->tableName() . ' SET ' . Formatter::tokenize(implode(',', Formatter::makeAssociativeArray($this->record)), ',') . ' WHERE id=' . $this->record['dbData']['id'];
                $query = $dbConn->prepare($sql);
                $query->execute();
            }
            else {
                $sql = 'INSERT INTO ' . $this->tableName() . ' (' . Formatter::tokenize(implode(',', array_keys($this->record)), ',') . ')' . ' VALUES ' . '(' . Formatter::tokenize(implode(',', Formatter::generateUnnamedPlaceholders($this->record)), ',') . ')';
                $query = $dbConn->prepare($sql);
                $query->execute(array_values($this->record));
            }
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        finally {
            $dbConn = null;
        }

        return $query->rowCount();
    }

    public function destroy($record) {
        try {
            $dbConn = self::makeDbConn();
            $query = $dbConn->prepare('DELETE FROM ' . self::tableName() . ' WHERE id= ' . $record);
            $query->execute();
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
        finally {
            $dbConn = null;
        }

        $check = $query->rowCount();

        try {
            if ($check) {
                return $check;
            } else {
                throw new RecordNotFoundException;
            }
        } catch (RecordNotFoundException $e) {
             echo $e->message();
        }
    }
}
