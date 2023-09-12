<?php

use Back\Controllers\Prestamos;

$cliente_id = $security->aideDecrypt($rqst['cliente']);
$monto = $rqst['monto'];
$modalidad = $rqst['modalidad'];
$periodicidad = $rqst['periodicidad'];
$tasa = $rqst['tasa'];
$entrega = new DateTime($rqst['entrega']);
$cuotas = $rqst['cuotas'];
$cta_deb_id = $rqst['ctaDeb'];
$cta_cred_id = $rqst['ctaCred'];
$usuario = $_SESSION['user_id'];

$prestamo_data = [
    'cliente' => $cliente_id,
    'monto' => $monto,
    'modalidad' => $modalidad,
    'periodicidad' => $periodicidad,
    'tasa' => $tasa,
    'entrega' => $entrega,
    'cuotas' => $cuotas,
    'cta_deb_id' => $cta_deb_id,
    'cta_cred_id' => $cta_cred_id
];

$prestamos = new Prestamos();
$prestamos->createPrestamo($prestamo_data, $usuario);

$resp['success'] = true;
