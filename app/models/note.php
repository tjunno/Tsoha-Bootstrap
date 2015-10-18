<?php

/**
 * Created by PhpStorm.
 * User: Tuomas Junno
 * Date: 20.9.2015
 */
class Note extends BaseModel
{
    public $id, $dude, $name, $state, $description, $added, $priority, $types;

    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_description');
    }

    public static function all($user){
        $query = DB::connection()->prepare('SELECT * FROM Note WHERE dude = :user');
        $query->execute(array('user' => $user));
        $rows = $query->fetchAll();
        $notes = array();

        foreach ($rows as $row) {
            $querytype = DB::connection()->prepare('SELECT type.id, type.name from Note, Type, Typeonote WHERE type.dude = note.dude AND typeonote.type = type.id AND typeonote.note = note.id AND note.id = :id');
            $querytype->execute(array('id' => $row['id']));
            $typerows = $querytype->fetchAll();
            $types = array();
            foreach ($typerows as $typerow) {
                $types[] = new Type(array(
                    'id' => $typerow['id'],
                    'name' => $typerow['name']
                ));
            }
            $notes[] = new Note(array(
                'id' => $row['id'],
                'dude' => $row['dude'],
                'name' => $row['name'],
                'state'=> $row['state'],
                'description' => $row['description'],
                'added' => $row['added'],
                'priority' => $row['priority'],
                'types' => $types
            ));
            unset($types);
        }
        return $notes;
    }

    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Note WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        $querytype = DB::connection()->prepare('SELECT type.id, type.name from Note, Type, Typeonote WHERE type.dude = note.dude AND  typeonote.type = type.id AND typeonote.note = note.id AND note.id = :id');
        $querytype->execute(array('id' => $row['id']));
        $typerows = $querytype->fetchAll();
        $types = array();
        if ($row){
        foreach ($typerows as $typerow) {
            $types[] = new Type(array(
                'id' => $typerow['id'],
                'name' => $typerow['name']
            ));
        }

           $note = new Note(array(
                'id' => $row['id'],
                'dude' => $row['dude'],
                'name' => $row['name'],
                'state'=> $row['state'],
                'description' => $row['description'],
                'added' => $row['added'],
                'priority' => $row['priority'],
                'types' => $types
            ));
            return $note;
        }
        return null;
    }

    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Note (dude, name, priority, description, added) VALUES (:dude, :name, :priority, :description, :added) RETURNING id');
        $query->execute(array('dude'=>$_SESSION['user'], 'name' => $this->name, 'added' => $this->added, 'priority' => $this->priority, 'description' => $this->description));
        $row = $query->fetch();
        $this->id = $row['id'];
        foreach($this->types as $type) {
            $querytype = DB::connection()->prepare('INSERT INTO Typeonote (type, note) VALUES (:type, :note)');
            $querytype->execute(array('type' => $type, 'note' => $this->id));
            $row = $query->fetch();
	  }
    }

    public function update(){
        $query = DB::connection()->prepare('UPDATE Note SET (name, priority, description) = (:name, :priority, :description) WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'priority' => $this->priority, 'description' => $this->description));
        $row = $query->fetch();
        $types = $this->types;
        $destroyoldies = DB::connection()->prepare('DELETE FROM Typeonote WHERE note = :note');
        $destroyoldies->execute(array('note' => $this->id));
        $row = $query->fetch();
        foreach($types as $type) {
            $querytype = DB::connection()->prepare('INSERT INTO Typeonote (type, note) VALUES (:type, :note)');
            $querytype->execute(array('type' => $type, 'note' => $this->id));
            $row = $query->fetch();
        }
    }

    public function finish() {
        $query = DB::connection()->prepare('UPDATE Note SET state = TRUE WHERE id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
    }

    public function destroy(){
        $query = DB::connection()->prepare('DELETE FROM Note WHERE id = :id');
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

    public function validate_description(){
        $errors = array();
        if ($this->priority == '' || $this->priority == null){
            $errors[] = 'Description cannot be empty';
        }

        if (strlen($this->description) > 255){
            $errors[] = 'Description must be under 255 chars!';
        }
        return $errors;
    }

}