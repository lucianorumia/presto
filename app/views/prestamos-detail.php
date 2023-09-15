<?php
namespace Back\Views;

use Back\Controllers\Prestamos;
use DateTime;

$prestamo_id = $security->aideDecrypt($view_data['id']);
$token = $security->generateClientToken($_SESSION['token'], pathinfo(__FILE__, PATHINFO_FILENAME));

$prestamos = new Prestamos;
$prestamo_details = $prestamos->getPrestamoDetail($prestamo_id);

$cuota_states_colors = [
    0 => 'yellow', // no vencida
    1 => 'red', // en mora
    2 => 'orange', // judicial
    3 => 'green', // cancelada
    4 => 'def', // refinanciada
    5 => 'purple', // incobrable
];

// var_dump($prestamo_details);

?>
        <h1 class="page-title">Detalle Pr&eacute;stamo</h1>
        <div class="details-band">
            <div class="details-band__element" id="detail-cod">
                <p class="details-band__label">C&oacute;digo</p>
                <p class="details-band__info"><?php echo $prestamo_details['cod']; ?></p>
            </div>
            <div class="details-band__element" id="detail-cliente">
                <p class="details-band__label">Cliente</p>
                <p class="details-band__info"><?php echo $prestamo_details['cliente']; ?></p>
            </div>
            <div class="details-band__element" id="detail-monto">
                <p class="details-band__label">Monto</p>
                <p class="details-band__info"><?php
                    $monto = number_format($prestamo_details['monto'], 2, ',', '.');
                    echo $monto;
                ?></p>
            </div>
            <div class="details-band__element" id="detail-fecha-entrega">
                <p class="details-band__label">Entrega</p>
                <p class="details-band__info"><?php
                    $fecha_entrega_datetime = new \DateTime($prestamo_details['fecha_entrega']);
                    $fecha_entrega = $fecha_entrega_datetime->format('d/m/Y');
                    echo $fecha_entrega;
                ?></p>
            </div>
            <div class="details-band__element" id="detail-modalidad">
                <p class="details-band__label">Modalidad</p>
                <p class="details-band__info"><?php echo $prestamo_details['modalidad']; ?></p>
            </div>
            <div class="details-band__element" id="detail-periodicidad">
                <p class="details-band__label">Periodicidad</p>
                <p class="details-band__info"><?php echo $prestamo_details['periodicidad']; ?></p>
            </div>
            <div class="details-band__element" id="detail-tasa">
                <p class="details-band__label">Tasa</p>
                <p class="details-band__info"><?php
                    $tasa = number_format($prestamo_details['tasa'] * 100, 0) . '%';
                    echo $tasa;
                ?></p>
            </div>
        </div>
        <div class="frame">
            <!-- def-table -->
            <div class="def-table__container">
                <table class="def-table" id="cuotas-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Cuota</th>
                            <th>Vencimiento</th>
                            <th>Capital</th>
                            <th>Interés</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
foreach ($prestamo_details['cuotas'] as $cuota) {
    $row_mark_color = $cuota_states_colors[$cuota['state_id']];
    $key = $security->aideEncrypt($cuota['id']);
    $cod = $cuota['cod'];
    $fecha_vto_datetime = new \DateTime($cuota['fecha_vto']);
    $fecha_vto = $fecha_vto_datetime->format('d/m/Y');
    $capital = number_format($cuota['capital'], 2, ',', '.');
    $interes = number_format($cuota['interes'], 2, ',', '.');
    $total = number_format($cuota['total'], 2, ',', '.');
    $state = $cuota['state'];
    
    echo <<<HTML
                        <tr>
                            <td>
                                <div class="def-table__row-mark def-table__row-mark--{$row_mark_color}"></div>
                            </td>
                            <td>{$cod}</td>
                            <td>{$fecha_vto}</td>
                            <td>{$capital}</td>
                            <td>{$interes}</td>
                            <td>{$total}</td>
                            <td>{$state}</td>
                            <td>
                                <a class="def-table__plus-btn" href="/cuotas/{$key}">+</a>
                            </td>
                        </tr>
HTML . PHP_EOL;
}
?>                        
                    </tbody>
                </table>
            </div>
            <div class="frame__bottom"></div>
        </div>
        <!-- action-bar -->
        <div class="action-bar">
            <a class="action-bar__button spclss--no-effects-font" href="/prestamos/alta">Nuevo pr&eacute;stamo</a>
            <div class="action-bar__circle"></div>
        </div>