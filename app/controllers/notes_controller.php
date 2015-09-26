<?php
/**
 * Created by PhpStorm.
 * User: Tuomas Junno
 * Date: 20.9.2015
 */

class NoteController extends BaseController{

    public static function index(){
        $notes = Note::all();
        View::make('note/index.html', array('notes' => $notes));
    }

    public static function create() {
        View::make('note/new.html');
    }

    public static function store(){
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
        $note = Note::find($id);
        View::make('note/show.html', array('note' => $note));
    }

    public static function edit($id){
        $note = Note::find($id);
        View::make('note/edit.html', array('attributes' => $note));
    }

    public static function update($id){
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
        $note = new Note(array('id' => $id));
        $note->destroy();
        Redirect::to('/note', array('message' => 'Task removed!'));
    }

}