<?php
/**
 * Created by PhpStorm.
 * User: Tuomas Junno
 * Date: 4.10.2015
 */

class TypeController extends BaseController
{

    public static function index()
    {
        self::check_logged_in();
        $user_id = $_SESSION['user'];
        $types = Type::all($user_id);
        View::make('type/index.html', array('types' => $types));
    }

    public static function create()
    {
        self::check_logged_in();
        View::make('type/new.html');
    }

    public static function store()
    {
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'name' => $params['name'],
        );

        $type = new Type($attributes);
        $errors = $type->errors();

        if(count($errors) == 0) {
            $type->save();

            Redirect::to('/type/' . $type->id, array('message' => 'New type added!'));
        }else{
            View::make('type/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }

    }

    public static function edit($id){
        self::check_logged_in();
        $note = Note::find($id);
        View::make('type/edit.html', array('attributes' => $type));
    }

    public static function update($id){
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'name' => $params['name']
        );

        $type = new Type($attributes);
        $errors = $type->errors();

        if (count($errors) == 0) {
            $type->update();

            Redirect::to('/type/' . $type->id, array('message' => 'Type has been updated successfully'));
        }else{
            View::make('type/edit.html', array('errors' => '$errors', 'attributes' => '$attributes'));
        }
    }


    public static function destroy($id){
        self::check_logged_in();
        $note = new Type(array('id' => $id));
        $note->destroy();
        Redirect::to('/type', array('message' => 'Type removed!'));
    }
}