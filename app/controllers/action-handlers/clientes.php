<?php

use Back\Cross\Security;
use Back\Cross\Views;
use Back\Cross\CstmException;
use Back\Cross\CstmExceptions;
use Back\Controllers\Clientes;

$security = new Security;
$clientes = new Clientes;

$resp = [];

try {
    $json_rqst = file_get_contents('php://input');
    $rqst = json_decode($json_rqst, true);

    if (isset($rqst['token'])) {
        $from = $security->franDecrypt($rqst['token']);

        if ($from === Views::Clientes->value) {
            $name = is_null($rqst['name']) ? null : htmlspecialchars($rqst['name']);

            $rows = $clientes->getClientes($name);

            $clientes = [];
            foreach ($rows as $row) {
                $clientes[] = [
                    'key' => $security->aideEncrypt($row['id']),
                    'denominacion' => $row['denominacion'],
                    'telefono' => $row['telefono'] ?? '',
                ];
            }

            $resp['success'] = true;
            $resp['clientes'] = $clientes;
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
