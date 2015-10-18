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

$routes->post('/note/:id/finish', function($id){
    NoteController::finish($id);
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

$routes->post('/logout', function(){
  UserController::logout();
});

$routes->get('/type', function(){
    TypeController::index();
});

$routes->post('/type', function(){
    TypeController::store();
});

$routes->get('/type/:id/edit', function($id){
    TypeController::edit($id);
});

$routes->post('/type/:id/edit', function($id){
    TypeController::update($id);
});

$routes->post('/type/:id/destroy', function($id){
    TypeController::destroy($id);
});

$routes->get('/priority', function(){
    PriorityController::index();
});

$routes->post('/priority', function(){
    PriorityController::store();
});

$routes->get('/priority/:id/edit', function($id){
    PriorityController::edit($id);
});

$routes->post('/priority/:id/edit', function($id){
    PriorityController::update($id);
});

$routes->post('/priority/:id/destroy', function($id){
    PriorityController::destroy($id);
});

