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
        View::make('note/index.html', array('notes' => $notes));
    }

    public static function create() {
        self::check_logged_in();
        View::make('note/new.html');
    }

    public static function store(){
        self::check_logged_in();
        $params = $_POST;
        $attributes= array(
            'name' => $params['name'],
            'priority' => $params['priority'],
            'description' => $params['description'],
            'added' => date("d.m.Y")
        );

        $note = new Note($attributes);
        $errors = $note->errors();

        if(count($errors) == 0) {
            $note->save();

            Redirect::to('/note/' . $note->id, array('message' => 'New task added!'));
        }else{
            View::make('note/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }

    }

    public static function show($id){
        self::check_logged_in();
        $note = Note::find($id);
        View::make('note/show.html', array('note' => $note));
    }

    public static function edit($id){
        self::check_logged_in();
        $note = Note::find($id);
        View::make('note/edit.html', array('attributes' => $note));
    }

    public static function update($id){
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'priority' => $params['priority'],
            'description' => $params['description']
        );

        $note = new Note($attributes);
        $errors = $note->errors();

        if (count($errors) == 0) {
            $note->update();

            Redirect::to('/note/' . $note->id, array('message' => 'Task has been updated successfully'));
        }else{
            View::make('note/edit.html', array('errors' => '$errors', 'attributes' => '$attributes'));
        }
    }

    public static function destroy($id){
        self::check_logged_in();
        $note = new Note(array('id' => $id));
        $note->destroy();
        Redirect::to('/note', array('message' => 'Task removed!'));
    }

}