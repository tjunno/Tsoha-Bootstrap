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
      // Testaa koodiasi täällä
      $tsoha = Note::find(1);
      $notes = Note::all();

      Kint::dump($notes);
      Kint::dump($tsoha);


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
