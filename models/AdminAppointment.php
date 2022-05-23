<?php

namespace Model;

class AdminAppointment extends ActiveRecord
{
    protected static $table = 'appointmentsServices';
    protected static $columnsDB = ['id', 'time', 'customer', 'email', 'phone', 'service', 'price'];

    public $id;
    public $time;
    public $customer;
    public $email;
    public $phone;
    public $service;
    public $price;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->time = $args['time'] ?? '';
        $this->customer = $args['customer'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->service = $args['service'] ?? '';
        $this->price = $args['price'] ?? '';
    }
}
