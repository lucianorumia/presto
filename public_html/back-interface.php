<?php

use Back\Cross\Router;
use Back\Cross\CstmException;
use Back\Cross\CstmExceptions;
use Back\Cross\Security;

session_start();
require __DIR__ . '/../app/cross/router.php'; // Set ref!

try {
    $json_rqst = file_get_contents('php://input');
    
    if (empty($json_rqst)) {
        throw new CstmException(CstmExceptions::NO_REQUEST);
    } else {
        $rqst = json_decode($json_rqst, true);
        
        if (isset($rqst['token'])) {
            $token = $rqst['token'];
            $security = new Security;

            if ($security->validateToken($token, $_SESSION['token'])) {
                $token_data = $security->decryptToken($token);
                $from = $token_data['from'];

                require Router::getFilePath('Back\\Controllers\\ActionHandlers\\' . $from);
            } else {
                throw new CstmException(CstmExceptions::INVALID_TOKEN);
            }
        } else {
            throw new CstmException(CstmExceptions::NO_TOKEN);
        }
    }
} catch (CstmException $ex) {
    $resp['success'] = false;
    $resp['error'] = "CSTM{$ex->getCode()}";
} catch (Throwable $th) {
    $resp['success'] = false;
    $resp['error'] = $th->getMessage();
}

header("Content-Type: application/json; charset=UTF-8");
echo $json_resp = json_encode($resp);
