<?php

namespace Model;

class ActiveRecord
{

    // Database
    protected static $db;
    protected static $table = '';
    protected static $columnsDB = [];

    // Alerts & messages
    protected static $alerts = [];

    // Connection to DB - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public static function setAlert($type, $message)
    {
        static::$alerts[$type][] = $message;
    }

    // Validation
    public static function getAlerts()
    {
        return static::$alerts;
    }

    public function validate()
    {
        static::$alerts = [];
        return static::$alerts;
    }

    // Query SQL to create an object in memory
    public static function querySQL($query)
    {
        // Query DB
        $result = self::$db->query($query);

        // Iterating results
        $array = [];
        while ($register = $result->fetch_assoc()) {
            $array[] = static::createObject($register);
        }

        // freeing memory
        $result->free();

        // returning results
        return $array;
    }

    // Creating object in memory equal to the one in DB
    protected static function createObject($register)
    {
        $object = new static;

        foreach ($register as $key => $value) {
            if (property_exists($object, $key)) {
                $object->$key = $value;
            }
        }

        return $object;
    }

    // Identifying & joining DB attributes
    public function attributes()
    {
        $attributes = [];
        foreach (static::$columnsDB as $column) {
            if ($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    // Sanitizing data before saving to DB
    public function sanitizeAttributes()
    {
        $attributes = $this->attributes();
        $sanitizing = [];
        foreach ($attributes as $key => $value) {
            $sanitizing[$key] = self::$db->escape_string($value);
        }
        return $sanitizing;
    }

    // Synching DB with objects in memory
    public function synch($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Registers - CRUD
    public function save()
    {
        $result = '';
        if (!is_null($this->id)) {
            // update
            $result = $this->update();
        } else {
            // Creating a new register
            $result = $this->create();
        }
        return $result;
    }

    // All registers
    public static function all()
    {
        $query = "SELECT * FROM " . static::$table;
        $result = self::querySQL($query);
        return $result;
    }

    // Getting a register by id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE id = ${id}";
        $result = self::querySQL($query);
        return array_shift($result);
    }

    // Getting a specific number of registers
    public static function get($limit)
    {
        $query = "SELECT * FROM " . static::$table . " LIMIT ${limit}";
        $result = self::querySQL($query);
        return array_shift($result);
    }

    // Generic GET query
    public static function where($column, $value)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE ${column} = '${value}'";
        $result = self::querySQL($query);
        return array_shift($result);
    }

    // SQL raw query (use when model methods are not enough)
    public static function SQL($query)
    {
        $result = self::querySQL($query);
        return $result;
    }

    // Creating a new register
    public function create()
    {
        // Sanitizing data
        $attributes = $this->sanitizeAttributes();

        // Insert in DB
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        // Script to debug query errors
        // return json_encode(['query' => $query]);

        // Query result
        $result = self::$db->query($query);
        return [
            'result' =>  $result,
            'id' => self::$db->insert_id
        ];
    }

    // Updating a register
    public function update()
    {
        // Sanitizing data
        $attributes = $this->sanitizeAttributes();

        // Iterating to add every value to DB
        $values = [];
        foreach ($attributes as $key => $value) {
            $values[] = "{$key}='{$value}'";
        }

        // SQL query
        $query = "UPDATE " . static::$table . " SET ";
        $query .=  join(', ', $values);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Updating DB
        $result = self::$db->query($query);
        return $result;
    }

    // Deleting a register by ID
    public function delete()
    {
        $query = "DELETE FROM "  . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }
}
