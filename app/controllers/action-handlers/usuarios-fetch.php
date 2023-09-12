<?php

use Back\Cross\Security;
use Back\Cross\Views;
use Back\Cross\CstmException;
use Back\Cross\CstmExceptions;
use Back\Controllers\User;

$security = new Security;
$user = new User;

$resp = [];

try {
    $json_rqst = file_get_contents('php://input');
    $rqst = json_decode($json_rqst, true);

    if (isset($rqst['fran'])) {
        $from = $security->franDecrypt($rqst['fran']);

        if ($from === Views::Users->value) {
            $name = $rqst['name'];
            $role_id = $rqst['roleId'];

            $rows = $user->getUsers($name, $role_id);

            $users = [];
            foreach ($rows as $index => $row) {
                $users[$index] = [
                    'key' => $security->aideEncrypt($row['id']),
                    'name' => $row['name'],
                    'role' => $row['role'],
                    'email' => $row['email'],
                ];
            }

            $resp['success'] = true;
            $resp['users'] = $users;
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
