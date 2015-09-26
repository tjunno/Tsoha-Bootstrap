<?php
/**
 * Created by PhpStorm.
 * User: Tuomas Junno
 * Date: 26.9.2015
 */

class User extends BaseModel {
    public $id;
    public $name;
    public $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
        /*$this->validators = array('validate_password', 'validate_ user');*/
    }
/*
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
*/
    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Dude WHERE name = :name AND password = :password LIMIT 1');
        $query->execute(array('name' => $username, 'password' => $password));
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

    public static function find($id) {
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
/*
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
       if ($this->name == '' || $this->name == null){
            $errors[] = 'Enter a username!';
        }
        if ($this->name < 1 || $this->name > 120){
            $errors[] = 'Username must be between 1 and 120 chars!';
        }
        return $errors;
    }*/
}
