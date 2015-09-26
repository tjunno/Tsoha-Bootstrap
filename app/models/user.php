<?php
/**
 * Created by PhpStorm.
 * User: Tuomas Junno
 * Date: 26.9.2015
 */

class User extends BaseModel
{
    public $id;
    public $name;
    public $password;

    public function __construct($attributes) {
    parent::__construct($attributes);
        $this->validators = array('validate_password', 'validate_ user');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Dude');
        $query->execute();
        $rows = $query->fetchAll();
        $users = array();
        foreach ($rows as $row) {
            $users[] = new User(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password']
            ));
        }
        return $users;
    }

    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Dude WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $user = new User(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password']
            ));
        }
        return $user;
    }

    public static function authenticate($name, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Dude WHERE name = :name AND password = :password LIMIT 1');
        $query->execute(array('name' => $name, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            $user = new User(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password']
            ));
            return $user;
        } else {
            return null;
        }
    }

    public function validate_password() {
        $errors = array();
        if ($this->password == '' || $this->priority == null){
            $errors[] = 'Enter a password!';
        }
        if ($this->password < 5 || $this->password > 120){
            $errors[] = 'Password must be between 5 and 120 chars!';
        }
        return $errors;
    }

    public function validate_user() {
        $errors = array();
       if ($this->username == '' || $this->username == null){
            $errors[] = 'Enter a username!';
        }
        if ($this->username < 1 || $this->username > 120){
            $errors[] = 'Username must be between 1 and 120 chars!';
        }
        return $errors;
    }
}
