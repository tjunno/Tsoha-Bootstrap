<?php

/**
 * Created by PhpStorm.
 * User: Tuomas Junno
 * Date: 20.9.2015
 */
class Note extends BaseModel
{
    public $id, $dude, $name, $state, $description, $added, $priority, $type;

    public function __construct($attributes){
        parent::__construct($attributes);
    }

    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM Note');
        $query->execute();
        $rows = $query->fetchAll();
        $notes = array();
        foreach($rows as $row){
            $notes[] = new Note(array(
                'id' => $row['id'],
                'dude' => $row['dude'],
                'name' => $row['name'],
                'state'=> $row['state'],
                'description' => $row['description'],
                'added' => $row['added'],
                'priority' => $row['priority']
            ));
        }
        return $notes;
    }

    /**
     *
     */
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Note WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row){
           $note = new Note(array(
                'id' => $row['id'],
                'dude' => $row['dude'],
                'name' => $row['name'],
                'state'=> $row['state'],
                'description' => $row['description'],
                'added' => $row['added'],
                'priority' => $row['priority']
            ));
           return $note;
        }
        return null;
    }

    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Note (name, priority, description) VALUES (:name, :priority, :description) RETURNING id');
        $query->execute(array('name' => $this->name, 'priority' => $this->priority, 'description' => $this->description));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function remove(){
        $query = DB::connection()->prepare('DELETE FROM Note where id = :id');
        $query->execute(array('id' => $this->id));
        $row = $query->fetch();
    }

}