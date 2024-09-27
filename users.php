<?php

class User{

    public static function register($user){

        $allUsers = self::getData();
        foreach($allUsers as $u){
            $u = (array) $u;
            if($u['email'] == $user['email']){
                return ["error"=>"User exists"];
            }
        }

        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
          return ["error"=>"invalid email"];
        }

        $hash = password_hash($user['password'], PASSWORD_DEFAULT,["cost"=>12]);

        $newUser = [
            "email"=>$user['email'],
            "password"=>$hash,
            "id"=>uniqid(true)
        ];

        // Pusha in ny user i all users
        $allUsers[] = $newUser;

        // Sparar till json-fil
        self::saveData($allUsers);
        return $newUser;
  
    }

    public static function login($user){
        $allUsers = self::getData();
        $found = false;
        foreach($allUsers as $u){
            $u = (array) $u;
            if($u['email'] == $user['email']){
                $found = true;
                break;
            }
        }
        if(!$found) return ["error"=>"user not found"];

        if(!password_verify($user['password'], $u['password']))
        {
            return ["error"=>"wrong password"];
        }

        $_SESSION['auth']=true;
        $_SESSION['userId']=$u['id'];
        return ["message"=>"Logged in", "userId"=>$u['id']];


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
        file_put_contents("users.json", json_encode($data, JSON_PRETTY_PRINT));
    }
    
    public static function getData(){
        $oldData = file_get_contents("users.json");
        return (array) json_decode($oldData);
    }
    
    public static function update($id, $data){
    
        $oldData = self::getData();
        $oldData[$id] = $data;
        self::saveData($oldData);
        return $oldData[$id];
    
    }

}