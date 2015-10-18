<?php
/**
 * Created by PhpStorm.
 * User: Tuomas Junno
 * Date: 20.9.2015
 */

class NoteController extends BaseController{

    public static function index(){
        self::check_logged_in();
        $user_id = $_SESSION['user'];
        $notes = Note::all($user_id);
        $priorities = Priority::all($user_id);
        View::make('note/index.html', array('notes' => $notes, 'priorities' => $priorities));
    }

    public static function create() {
        self::check_logged_in();
        $user_id = $_SESSION['user'];
        $priorities = Priority::all($user_id);
        $types = Type::all($user_id);
        View::make('note/new.html', array('types' => $types, 'priorities' => $priorities));
    }

    public static function store(){
        self::check_logged_in();
        $params = $_POST;
        $types = $params['types'];
        $attributes= array(
            'name' => $params['name'],
            'types' => array(),
            'priority' => $params['priority'],
            'description' => $params['description'],
            'added' => date("d.m.Y")
        );

        foreach($types as $type){
            $attributes['types'][] = $type;
        }

        $note = new Note($attributes);
        $errors = $note->errors();

        if(count($errors) == 0) {
            $note->save();
            Redirect::to('/note/' . $note->id, array('message' => 'New task added!'));
        }else{
            $user_id = $_SESSION['user'];
            $types = Type::all($user_id);
            $priorities = Priority::all($user_id);
            $selected = $note->types;
            View::make('note/new.html', array('errors' => $errors, 'attributes' => $attributes, 'priorities' => $priorities, 'types' => $types, 'selected' => $selected));
        }

    }

    public static function show($id){
        self::check_logged_in();
        $user_id = $_SESSION['user'];
        $note = Note::find($id);
        $priorities = Priority::all($user_id);
        View::make('note/show.html', array('note' => $note, 'priorities' => $priorities));
    }

    public static function edit($id){
        self::check_logged_in();
        $note = Note::find($id);
        $user_id = $_SESSION['user'];
        $priorities = Priority::all($user_id);
        $types = Type::all($user_id);
        $notetypes = array();
        foreach($note->types as $type){
            $notetypes[] = $type->id;
        }

        View::make('note/edit.html', array('attributes' => $note, 'priorities' => $priorities, 'types' => $types, 'notetypes' => $notetypes));
    }

    public static function update($id){
        self::check_logged_in();
        $params = $_POST;
        $types = $params['types'];
        $priorities = Priority::all($_SESSION['user']);
        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'priority' => $params['priority'],
            'description' => $params['description'],
            'types' => array()
        );
        foreach($types as $type){
            $attributes['types'][] = $type;
        }

        $note = new Note($attributes);
        $errors = $note->errors();
        if (count($errors) == 0) {
            $note->update();

            Redirect::to('/note/' . $note->id, array('message' => 'Task has been updated successfully'));
        }else{
            $user_id = $_SESSION['user'];
            $types = Type::all($user_id);
            $priorities = Priority::all($user_id);
            $notetypes = array();
            foreach($note->types as $type){
                $notetypes[] = $type->id;
            }
            View::make('note/edit.html', array('errors' => '$errors', 'attributes' => '$attributes', 'priorities' => $priorities, 'types' => $types, 'notetypes' => $notetypes));
        }
    }

    public static function finish($id){
        self::check_logged_in();
        $note = new Note(array('id' => $id));
        $note->finish();
        Redirect::to('/note', array('message' => 'Task finished!'));
    }

    public static function destroy($id){
        self::check_logged_in();
        $note = new Note(array('id' => $id));
        $note->destroy();
        Redirect::to('/note', array('message' => 'Task removed!'));
    }

}