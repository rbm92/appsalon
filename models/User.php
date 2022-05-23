<?php

namespace Model;

class User extends ActiveRecord
{
    // Database
    protected static $table = 'users';
    protected static $columnsDB = ['id', 'name', 'surname', 'email', 'password', 'phone', 'admin', 'confirmed', 'token'];

    public $id;
    public $name;
    public $surname;
    public $email;
    public $password;
    public $phone;
    public $admin;
    public $confirmed;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->surname = $args['surname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmed = $args['confirmed'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    // Validation for creating an account
    public function validateNewAccount()
    {
        if (!$this->name) {
            self::$alerts['error'][] = 'Name is requested';
        }
        if (!$this->surname) {
            self::$alerts['error'][] = 'Surname is requested';
        }
        if (!$this->email) {
            self::$alerts['error'][] = 'Email is requested';
        }
        if (!$this->password) {
            self::$alerts['error'][] = 'Password is requested';
        }
        if (strlen($this->password) < 6) {
            self::$alerts['error'][] = 'Password must have at least 6 characters';
        }

        return self::$alerts;
    }

    public function validateLogin()
    {
        if (!$this->email) {
            self::$alerts['error'][] = 'Email is requested';
        }

        if (!$this->password) {
            self::$alerts['error'][] = 'Password is requested';
        }

        return self::$alerts;
    }

    public function validateEmail()
    {
        if (!$this->email) {
            self::$alerts['error'][] = 'Email is requested';
        }

        return self::$alerts;
    }

    public function validatePassword()
    {
        if (!$this->password) {
            self::$alerts['error'][] = 'Password is requested';
        }

        if (strlen($this->password) < 6) {
            self::$alerts['error'][] = 'Password must have at least 6 characters ';
        }

        return self::$alerts;
    }

    // Checking if user already exists
    public function userExists()
    {
        $query = "SELECT * FROM " . self::$table . " WHERE email = '" . $this->email . "' LIMIT 1";

        $result = self::$db->query($query);

        // num_rows will be 1 if user is already in DB
        if ($result->num_rows) {
            self::$alerts['error'][] = 'User is already registered';
        }

        return $result;
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken()
    {
        $this->token = uniqid();
    }

    public function checkPasswordAndConfirmed($password)
    {
        $result = password_verify($password, $this->password);

        if (!$result || !$this->confirmed) {
            self::$alerts['error'][] = 'Incorrect Password or Account not Confirmed';
        } else {
            return true;
        }
    }
}
