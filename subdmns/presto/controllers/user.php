<?php
namespace Back\Controllers;

use Back\Cross\Security;
use Back\Models\DbConnection;
use Back\Models\User as User_mdl;

class User {
    public function loginDataMatch($name, $pass): array|false {
        $dbh = new DbConnection;
        $user_mdl = new User_mdl($dbh);
        $user_match = $user_mdl->selectUserByName($name);
        // $dbh = null;

        if($user_match){
            $hash_pass = $user_match['pass'];
            $pass_match = password_verify($pass, $hash_pass);
            if ($pass_match) {
                return [
                    "user_id" => $user_match["id"],
                    "role_id" => $user_match['role_id']
                ];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function passVerify($user_id, $pass): bool {
        $dbh = new DbConnection;
        $user_mdl = new User_mdl($dbh);
        $user_data = $user_mdl->selectUserById($user_id);
        // $dbh = null;
        $hash_pass = $user_data["pass"];
        $res = password_verify($pass, $hash_pass);

        return $res;
    }
    
    public function getUsers($name = null, $role_id = null) {
        $dbh = new DbConnection;
        $user_mdl = new User_mdl($dbh);
        $resp = $user_mdl->selectUsers($name, $role_id);
        // $dbh = null;
        
        return $resp;
    }

    public function getUserById($id) {
        $dbh = new DbConnection;
        $user_mdl = new User_mdl($dbh);
        $resp = $user_mdl->selectUserById($id);

        return $resp;
    }

    public function getUserRoles() {
        $dbh = new DbConnection;
        $user_mdl = new User_mdl($dbh);
        $resp = $user_mdl->selectUserRoles();
        
        return $resp;
    }

    public function createUser($name, $pass, $email, $role_id) {
        $dbh = new DbConnection;
        $user_mdl = new User_mdl($dbh);
        $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
        $resp = $user_mdl->insertUser($name, $hash_pass, $email, $role_id);
        
        return $resp;
    }

    public function deleteUser($id) {
        $dbh = new DbConnection;
        $user_mdl = new User_mdl($dbh);
        $resp = $user_mdl->deleteUser($id);
        
        return $resp;
    }
}