<?php
/**
 * Created by PhpStorm.
 * User: Tuomas Junno
 * Date: 4.10.2015
 */

class PriorityController extends BaseController
{

    public static function index()
    {
        self::check_logged_in();
        $user_id = $_SESSION['user'];
        $priorities = Priority::all($user_id);
        View::make('priority/index.html', array('priorities' => $priorities));
    }

    public static function store()
    {
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'name' => $params['name'],
            'prio' => $params['prio']
        );

        $priority = new Priority($attributes);
        $errors = $priority->errors();

        if(count($errors) == 0) {
            $priority->save();

            Redirect::to('/priority', array('message' => 'New priority added!'));
        }else{
            View::make('priority/index.html', array('errors' => $errors, 'attributes' => $attributes));
        }

    }

    public static function edit($id){
        self::check_logged_in();
        $priority = Priority::find($id);
        View::make('priority/edit.html', array('attributes' => $priority));
    }

    public static function update($id){
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'prio' => $prio,
            'name' => $params['name']
        );

        $priority = new Priority($attributes);
        $errors = $priority->errors();

        if (count($errors) == 0) {
            $priority->update();

            Redirect::to('/priority', array('message' => 'Priority has been updated successfully'));
        }else{
            View::make('priority/edit.html', array('errors' => '$errors', 'attributes' => '$attributes'));
        }
    }


    public static function destroy($id){
        self::check_logged_in();
        $priority = new Priority(array('id' => $id));
        $priority->destroy();
        Redirect::to('/priority', array('message' => 'Priority removed!'));
    }
}