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
        $token = $security->franDecrypt($rqst['token']);

        if ($token === Views::Clientes->value) {
            $nombre = htmlspecialchars($rqst['nombre']);
            $apellido = htmlspecialchars($rqst['apellido']);
            
            $tels = $rqst['tels'];
            $emails = $rqst['emails'];
            $addresses = $rqst['addresses'];

            $obs = $rqst['obs'];

            // // Extended form fields
            // if ($rqst['extended']) {
            //     if (isset($rqst['docNro'])) {
            //         $doc_nro = htmlspecialchars($rqst['docNro']);
            //         $doc_tipo = filter_var($data['docTipo'],FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE); // puede definirse rango
            //         if (is_null($docTipo)) throw new CstmException(CstmExceptions::INPUT_VALIDATE_ERROR);
            //     }
            // } else {
            //     $doc_tipo = null;
            //     $doc_nro = null;
            //     $fecha_nac = null;
            //     $obs = null;    
            // }
            $cliente_data = [
                'nombre' => $nombre,
                'apellido' => $apellido,
                'tels' => $tels,
                'emails' => $emails,
                'addresses' => $addresses,
                'obs' => $obs
            ];
            
            $clientes->createCliente($cliente_data, 1);

            $resp['success'] = true;
        } else {
            throw new CstmException(CstmExceptions::INVALID_TOKEN);
        }
    } else {
        throw new CstmException(CstmExceptions::NO_TOKEN);
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
