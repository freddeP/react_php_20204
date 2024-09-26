<?php

require_once('router_.php');
require_once('helper.php');
require_once("data.php");

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






/// POSTSSS.....

/* debug($_POST);  // url-encoded
debug(file_get_contents('php://input'));  // resten */