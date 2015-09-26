<?php

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/suunnitelmat', function() {
    HelloWorldController::index();
});

$routes->get('/suunnitelmat/note', function() {
    HelloWorldController::note_list();
});

$routes->get('/suunnitelmat/note/1', function() {
    HelloWorldController::note_show();
});

$routes->get('/suunnitelmat/note/1/edit', function() {
    HelloWorldController::note_edit();
});

$routes->get('/suunnitelmat/login', function() {
    HelloWorldController::login();
});

$routes->get('/', function(){
    NoteController::index();
});

$routes->get('/note', function(){
    NoteController::index();
});
$routes->get('/note/new', function(){
    NoteController::create();
});
$routes->get('/note/:id', function($id){
    NoteController::show($id);
});

$routes->post('/note', function(){
    NoteController::store();
});

$routes->get('/note/:id/edit', function($id){
    NoteController::edit($id);
});

$routes->post('/note/:id/edit', function($id){
    NoteController::update($id);
});

$routes->post('/note/:id/destroy', function($id){
    NoteController::destroy($id);
});

$routes->get('/login', function(){
  UserController::login();
});

$routes->post('/login', function(){
  UserController::handle_login();
});

