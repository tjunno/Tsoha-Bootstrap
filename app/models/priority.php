<?php
/**
 * Created by PhpStorm.
 * User: polaris
 * Date: 4.10.2015
 * Time: 17:54
 */

class Priority extends BaseModel
{
    public $id, $name, $prio, $dude;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_priority');
    }

    public static function all($user)
    {
        $query = DB::connection()->prepare('SELECT * FROM Priority WHERE dude = :user');
        $query->execute(array('user' => $user));
        $rows = $query->fetchAll();
        $priorities = array();
        foreach ($rows as $row) {
            $priorities[] = new Priority(array(
                'id' => $row['id'],
                'dude' => $row['dude'],
                'prio' => $row['prio'],
                'name' => $row['name']
            ));
        }
        return $priorities;
    }

    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Priority WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row){
           $priority = new Priority(array(
               'id' => $row['id'],
               'prio' => $row['prio'],
               'name' => $row['name'],
               'dude' => $row['dude']
            ));
           return $priority;
        }
        return null;
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Priority SET name = :name, prio = :prio WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'prio' => $this->prio));
    }

    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Priority (dude, prio, name) VALUES (:dude, :prio, :name) RETURNING id');
        $query->execute(array('dude'=>$_SESSION['user'], 'name' => $this->name, 'prio' => $this->prio));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function destroy(){
        $query = DB::connection()->prepare('DELETE FROM Priority where id = :id');
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

    public function validate_priority(){
        $errors = array();
        if ($this->prio == '' || $this->prio == null){
            $errors[] = 'Priority cannot be empty';
        }
        if ($this->prio < 0 || $this->prio > 10) {
            $errors[] = 'Priority must be over between 0 and 10';
        }
        return $errors;
    }

}