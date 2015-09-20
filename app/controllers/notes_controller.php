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
        $note = new Note(array(
            'name' => $params['name'],
            'priority' => $params['priority'],
            'description' => $params['description']
        ));

        $note->save();

        Redirect::to('/note/' . $note->id, array('message' => 'New task added!'));
    }

    public static function show($id){
        $note = Note::find($id);
        View::make('note/show.html', array('note' => $note));
    }

    public static function remove($id){
        $note = new Note(array('id' => $id));
        $note->remove();
        Redirect::to('/note/' . $note->id, array('message' => 'Task removed!'));
    }

}