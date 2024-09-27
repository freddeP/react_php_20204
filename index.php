<?php
session_start();
require_once('router_.php');
require_once('helper.php');
require_once("data.php");
require_once("users.php");

// Route för att serva vår react-client
App::get("/", function(){
    include("client/dist/static.html");
});

App::post("/create", function(){

    $data = (array) json_decode(file_get_contents('php://input'));
    $data['id'] = uniqid(true);
    Data::create($data);
    jsonResponse($data);

});

App::get("/cars", function(){
    jsonResponse(Data::getData());

    //echo json_encode(Data::getData());
});

App::delete('/cars/$id', function($id){

    Data::delete($id);

jsonResponse(["deleted"=>$id]);

});

App::get('/cars/$id', function($id){
    jsonResponse(Data::getOne($id));    
});

App::put('/cars/$id', function($id){

    $data = (array) json_decode(file_get_contents('php://input'));
   
    jsonResponse(Data::update($id, $data));

});

App::post("/register", function(){

    $data = (array) json_decode( file_get_contents('php://input') );
   
    jsonResponse( User::register($data) );

});

App::post("/login", function(){

    $data = (array) json_decode( file_get_contents('php://input') );
   
    jsonResponse( User::login($data) );

});


App::get("/auth", function(){

    jsonResponse($_SESSION);

});




/// POSTSSS.....

/* debug($_POST);  // url-encoded
debug(file_get_contents('php://input'));  // resten */