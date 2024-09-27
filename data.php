<?php

class Data{


public static function create($data){

    $oldData = self::getData();
    $oldData[$data['id']] = $data;
    self::saveData($oldData);
}

public static function delete($id){
    $oldData = self::getData();
    unset($oldData[$id]);
    self::saveData($oldData);
}

public static function getOne($id){
    $oldData = self::getData();
    return $oldData[$id];
}


private static function saveData($data){
    file_put_contents("data.json", json_encode($data, JSON_PRETTY_PRINT));
}

public static function getData(){
    $oldData = file_get_contents("data.json");
    return (array) json_decode($oldData);
}

public static function update($id, $data){

    $oldData = self::getData();
    $oldData[$id] = $data;
    self::saveData($oldData);
    return $oldData[$id];

}


}