<?php
  class HelloWorldController extends BaseController
  {

    public static function index()
    {
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
      View::make('suunnitelmat/index.html');
    }

    public static function sandbox()
    {
      $doom = new Note(array(
          'name' => 'd',
          'priority' => '1',
          'description' => 'Boom, boom!'
      ));
      $errors = $doom->errors();

      Kint::dump($errors);

    }

    public static function note_list()
    {
      View::make('suunnitelmat/note_list.html');
    }

    public static function note_show()
    {
      View::make('suunnitelmat/note_show.html');
    }

    public static function login()
    {
      View::make('suunnitelmat/login.html');
    }
  }
