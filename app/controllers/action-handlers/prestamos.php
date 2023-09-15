<?php

use Back\Controllers\Prestamos;

$cliente_id = is_null($rqst['cliente']) ? null : $security->aideDecrypt($rqst['cliente']);
$state_id = is_null($rqst['state']) ? null : $rqst['state'];

$prestamos = new Prestamos();
$resulset = $prestamos->getPrestamos($cliente_id, $state_id);

$prestamos_data = [];
    foreach ($resulset as $prestamo) {
        $prestamos_data[] = [
            'key' => $security->aideEncrypt($prestamo['id']),
            'cod' => $prestamo['cod'],
            'cliente' => $prestamo['cliente_denominacion'],
            'estadoId' => $prestamo['state_id'],
            'estado' => $prestamo['state'],
            'monto' => $prestamo['monto'],
            'cuotas' => $prestamo['cuotas'],
            'periodicidad' => $prestamo['periodicidad'],
            'tasa' => $prestamo['tasa']
        ];
    }

$resp['success'] = true;
$resp['prestamos'] = $prestamos_data;