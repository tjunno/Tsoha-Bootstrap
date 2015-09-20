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

$routes->post('/:id/remove', function($id){
    NoteController::remove($id);
});

