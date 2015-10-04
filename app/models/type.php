<?php
/**
 * Created by PhpStorm.
 * User: Tuomas Junno
 * Date: 4.10.2015
 */

class Type extends BaseModel
{
    public $id, $name, $dude;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }

    public static function all($user)
    {
        $query = DB::connection()->prepare('SELECT * FROM Type WHERE dude = :user');
        $query->execute(array('user' => $user));
        $rows = $query->fetchAll();
        $types = array();
        foreach ($rows as $row) {
            $types[] = new Type(array(
                'id' => $row['id'],
                'dude' => $row['dude'],
                'name' => $row['name']
            ));
        }
        return $types;
    }

    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Type WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row){
           $type = new Type(array(
                'id' => $row['id'],
                'dude' => $row['dude'],
                'name' => $row['name']
            ));
           return $type;
        }
        return null;
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Type SET name = :name WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name));
    }

    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Type (dude, name) VALUES (:dude, :name) RETURNING id');
        $query->execute(array('dude'=>$_SESSION['user'], 'name' => $this->name));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function destroy(){
        $query = DB::connection()->prepare('DELETE FROM Type where id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
    }

    public function validate_name(){
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Name cannot be empty!';
        }
        if (strlen($this->name) < 3) {
            $errors[] = 'Length of the name must be over 3 chars';
        }
        if (strlen($this->name) > 120) {
            $errors[] = 'Length of the name must be under 120 chars';
        }
        return $errors;
    }

}