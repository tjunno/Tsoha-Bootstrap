<?php
/**
 * Created by PhpStorm.
 * User: Tuomas Junno
 * Date: 26.9.2015
 */

class UserController extends BaseController{

  public static function login(){
      View::make('user/login.html');
  }

  public static function handle_login(){
    $params = $_POST;

    $user = User::authenticate($params['username'], $params['password']);

    if(!$user){
      View::make('user/login.html', array('errors' => 'Wrong username or password!', 'username' => $params['username']));
    }else{
      $_SESSION['user'] = $user->id;

      Redirect::to('/', array('message' => 'Welcome back ' . $user->name . '!'));
    }
  }
}