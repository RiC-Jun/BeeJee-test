<?php

namespace App\Models;

use App\Db;

class Task
{
    const TABLE = 'tasks';

    public $id;
    public $username;
    public $email;
    public $description;
    public $checked;
    public $edited;

    public static function getTotalQty()
    {
        $db = new Db();
        $sql = 'SELECT COUNT(*) FROM ' . self::TABLE;
        return $db->singleValue($sql);
    }

    public static function getAll($params)
    {
        $conditions = ' ORDER BY ' . $params['field'] . ' ' . $params['direction'];
        $conditions .= ' LIMIT ' . $params['start'] . ', ' . $params['step'];

        $sql = 'SELECT * FROM ' . self::TABLE . $conditions;

        $db = new Db();
        return $db->query(
            $sql,
            [],
            self::class
        );
    }

    public static function getTaskById($id)
    {
        $db = new Db();

        $sql = 'SELECT * FROM ' . static::TABLE . ' WHERE id=:id';
        $data = $db->query(
            $sql,
            [':id' => $id],
            static::class
        );

        return $data ? $data[0] : null;
    }

    public function insertTask()
    {
        $fields = get_object_vars($this);

        $cols = [];
        $data = [];

        foreach ($fields as $name => $value) {
            if ($value) {
                $cols[] = $name;
                $data[':' . $name] = $value;
            }
        }

        $sql = '
INSERT INTO ' . static::TABLE . '
(' . implode(',', $cols) . ')
VALUES
(' . implode(',', array_keys($data)) . ')
';
        $db = new Db();
        $result = $db->execute($sql, $data);
        return $result;
    }

    public function updateTask()
    {
        $fields = get_object_vars($this);

        unset($fields['username'], $fields['email']);

        $data = [];
        foreach ($fields as $name => $value) {
            $data[':' . $name] = $value;
        }

        $sql = 'UPDATE ' . static::TABLE . ' SET 
            description = :description,
            checked = :checked,
            edited = :edited
        WHERE
            id = :id';

        $db = new Db();
        $result = $db->execute($sql, $data);
        return $result;
    }

}