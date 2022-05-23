<?php

namespace Model;

class Service extends ActiveRecord
{
    // Database
    protected static $table = 'services';
    protected static $columnsDB = ['id', 'name', 'price'];

    public $id;
    public $name;
    public $price;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->price = $args['price'] ?? '';
    }

    public function validate()
    {
        if (!$this->name) {
            self::$alerts['error'][] = 'Name is required';
        }

        if (!$this->price) {
            self::$alerts['error'][] = 'Price is required';
        }

        if (!is_numeric($this->price)) {
            self::$alerts['error'][] = 'Invalid price format';
        }

        return self::$alerts;
    }
}
