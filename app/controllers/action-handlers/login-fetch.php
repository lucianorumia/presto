<?php

use Back\Cross\Security;
use Back\Cross\CstmException;
use Back\Cross\CstmExceptions;
use Back\Cross\Views;
use Back\Controllers\User;

$security = new Security;
$user = new User;

try {
    if (isset($_POST["fran"])) {
        $from = $security->franDecrypt(htmlspecialchars($_POST["fran"]));

        if ($from == Views::Login->value) {
            $name = htmlspecialchars($_POST["name"]);
            $pass = htmlspecialchars($_POST["pass"]);
            $match = $user->loginDataMatch($name, $pass);

            if ($match) {
                session_start();
                $_SESSION["user_id"] = $match["user_id"];
                $_SESSION["user_name"] = $name;
                $_SESSION["user_role_id"] = $match["role_id"];
                $_SESSION["token"] = $security->generateSessionToken();

                $resp['success'] = true;
                $resp['location'] = '/home';
            } else {
                throw new CstmException(CstmExceptions::WRONG_LOGIN_DATA);
            }
        } else {
            throw new CstmException(CstmExceptions::INVALID_FRAN);
        }
    } else {
        throw new CstmException(CstmExceptions::NO_FRAN);
    }
} catch (CstmException $ex) {
    $resp['success'] = false;
    $resp['error'] = "CST{$ex->getCode()}";
} catch (Throwable $th) {
    $resp['success'] = false;
    $resp['error'] = $th->getMessage();
}

header("Content-Type: application/json; charset=UTF-8");
echo $json_resp = json_encode($resp);